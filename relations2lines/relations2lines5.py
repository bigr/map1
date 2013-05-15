#!/usr/bin/python
# -*- coding: utf-8 -*-

__author__="xtesar7"

from psycopg2 import *
import sys
import relation
import route
import time
from copy import deepcopy
from sys import setrecursionlimit

def main():

    print time.strftime("%H:%M:%S", time.localtime()), " - script started"
    print "  Searching RelationIDs and Lines in route..."
    # Create connection to DB server.

    connection = connect("dbname='" + sys.argv[1] + "' user='klinger' password='' port=5432");
    relationCursor = connection.cursor()
    auxiliaryCursor = connection.cursor()
    wayCursor = connection.cursor()

    # Find relation IDs to be parsed, ie. those with osmc:symbol or some mtb values
    # Treat lines with useful attributes as relations (osm_id >= 0)
    relationIDs = []
    relations = []
    relationCursor.execute('''
        SELECT
            osm_id,
                CASE
                    WHEN ("highway"='track' AND "tracktype"='grade1' AND "mtb:scale" IS NULL) THEN 'grade1'                   
                    ELSE "mtb:scale"
                END AS
            "mtb:scale",
            "mtb:scale:uphill",
            "sac_scale",
            network,
            "osmc:symbol",
            route,                           
            ref
        FROM route
        WHERE            
            (
                   COALESCE("osmc:symbol","mtb:scale","mtb:scale:uphill","sac_scale") IS NOT NULL
                OR route IN ('mtb','horse','ski','bicycle','horse')
                OR ("highway"='track' AND "tracktype"='grade1')
            )
            AND
            (
                "access" IS NULL OR "access" NOT IN ('private','no') OR COALESCE(bicycle,foot,horse) = 'yes'
            )
            AND ST_Transform(way,4326) && ST_MakeEnvelope(%s, %s, %s, %s, 4326);            
    ''' % (sys.argv[2],sys.argv[3],sys.argv[4],sys.argv[5]))
    
    
    while True:
        # Fetch some of the result.
        rows = relationCursor.fetchmany(100)

        # Empty result means end of query.
        if not rows:
            break;

        #relations have negative osm_id in route table
        #lines have positive osm_id in route table
        for row in rows:
            if (row[0] < 0):
                #osm_id is not a primary key
                if not (row[0] in relationIDs):
                    relationIDs.append(-row[0])
            else:
                # 0: osm_id; 1: mtb:scale; 2: mtb:scale:uphill; 3: network; 4: "osmc:symbol; 5: route; 6: ref"
                lineInfo = "LINE;" + str(row[0]) + ";" + str(row[1]) + ";" + str(row[2]) + ";" + str(row[3]) + ";" + str(row[4]) + ";" + str(row[5]) + ";" + str(row[6])
                relations.append(relation.Relation(lineInfo))

    print time.strftime("%H:%M:%S", time.localtime()), " - RelationIDs and Lines found."
    print "  Getting Relation details from route_rels..."
    # Select important columns just for our IDs
    for id in relationIDs:
        relationCursor.execute('''
            SELECT id, members, tags
                FROM route_rels
                WHERE id=%s
        ''' % id)
        row = relationCursor.fetchone()
        # Make Relation object with parsed data
        relations.append(relation.Relation(row))

    print time.strftime("%H:%M:%S", time.localtime()), " - relations details found."
    print "  Making single routes from relations with all osmc:symbols..."

    # Find final routes and append all corresponding osmcSymbols
    routes = routesFromRels(relations)

    listOfRoutes = routes.values()
    listOfRoutes.sort()
    print time.strftime("%H:%M:%S", time.localtime()), " - routes now have osmc:symbols."
    print "  Finding firstNode and lastNode for each route in route_ways..."

    # Clean previous routes.
    auxiliaryCursor.execute("DROP TABLE IF EXISTS routes")
    auxiliaryCursor.execute("DELETE FROM geometry_columns WHERE f_table_name = 'routes'")
    auxiliaryCursor.execute("CREATE TABLE routes AS SELECT osm_id, way, highway, tracktype,oneway FROM route WHERE osm_id = 0")
    
    auxiliaryCursor.execute("DELETE FROM geometry_columns WHERE f_table_name = 'routes'")
    auxiliaryCursor.execute("INSERT INTO geometry_columns VALUES ('', 'public', 'routes', 'way', 2, 900913, 'LINESTRING')")

    # Add important information to each route
    i = 0;
    for r in listOfRoutes:
        i+=1
        #print "%d/%d" % (i,len(listOfRoutes))
        auxiliaryCursor.execute('''
            SELECT way, highway, tracktype,sac_scale,oneway FROM route
              WHERE osm_id=%s AND (("access"<>'private' AND "access"<>'no') OR "access" IS NULL OR ("access" IN ('private', 'no') AND bicycle='yes'))
        ''' % r.id)
        row = auxiliaryCursor.fetchone()
        # Some route IDs from relations may not be present in line table, ie. out of bounding box, those are ignored
        if row is not None:
            routes[r.id].geometry = row[0]
            routes[r.id].highway = row[1]
            routes[r.id].tracktype = row[2]
            routes[r.id].sacScale = row[3]
            routes[r.id].oneway = row[4]
            wayCursor.execute('''
                SELECT nodes[1], nodes[array_upper(nodes, 1)]
                    FROM route_ways
                    WHERE id=%s
            ''' % r.id)
            firstEndNodes = wayCursor.fetchone()
            routes[r.id].firstNode = firstEndNodes[0]
            routes[r.id].lastNode = firstEndNodes[1]
#            print r.id, ": ", routes[r.id].firstNode, ", ", routes[r.id].lastNode
        else:
            routes.pop(r.id)
    print time.strftime("%H:%M:%S", time.localtime()), " - firstNodes and lastNodes are found."
    print "  Finding route neighbours based on first and last nodes..."

    # Find end nodes and their routes
    nodes = findNodes(routes)

    # Find previous and next route neighbours
    for r in routes:
        nextRouteIDs = deepcopy(nodes[routes[r].lastNode])
        nextRouteIDs.remove(routes[r].id)
        previousRouteIDs = deepcopy(nodes[routes[r].firstNode])
        previousRouteIDs.remove(routes[r].id)
        for rid in nextRouteIDs:
            routes[routes[r].id].nextRoutes.append(rid)
        for rid in previousRouteIDs:
            routes[routes[r].id].previousRoutes.append(rid)

    #remove unconnected tracks with highway=track and tracktype=grade1 and mtb:scale is null
    print time.strftime("%H:%M:%S", time.localtime()), "  Removing disconnected tracks."
    routes = removeUnconnected(routes, nodes)
    print "  Tracks removed."

    print time.strftime("%H:%M:%S", time.localtime()), "  Finding dangerous nodes (column warning)."
    # Find nodeIDs, where track's attribute mtb:scale changes rapidly (difference >= 2),
    # create new column warning in routes with the difference
    dangerNodes = findDangerousNodes(nodes, routes)
    pointCursor = connection.cursor()
    insertDangerNodes(dangerNodes, pointCursor)
    pointCursor.close()

    print time.strftime("%H:%M:%S", time.localtime()), " - neighbours are found."
    print "  Determining offset for each route..."

    # Find offset polarity
#    listOfRoutes = routes.values()
    listOfRoutes = sorted(routes.values(), key=lambda route: route.osmcSigns[0], reverse=True)
    if len(listOfRoutes)>1000:
        setrecursionlimit(len(listOfRoutes))
    for r in listOfRoutes:
#        print "For cycle: ", r.id, r.osmcSigns[0]
        setOffset(routes, r.id, "next")
        setOffset(routes, r.id, "previous")
    print time.strftime("%H:%M:%S", time.localtime()), " - offset is found."
    print "  Inserting of routes into new empty table routes..."

    # Determine maximum number of different osmcSymbols at one route
    maxSigns = 0
    for r in routes.values():
        if (maxSigns < r.numOfSigns):
            maxSigns = r.numOfSigns
    if maxSigns < 8:
        maxSigns = 8

    # Prepare database table for data insertion
    auxiliaryCursor.execute('''
        ALTER TABLE routes
          ADD "mtb:scale" text;
    ''')
    auxiliaryCursor.execute('''
        ALTER TABLE routes
          ADD "mtb:scale:uphill" text;
    ''')
    auxiliaryCursor.execute('''
        ALTER TABLE routes
          ADD "sac_scale" text;
    ''')
    auxiliaryCursor.execute('''
        ALTER TABLE routes
          ADD offsetSide integer;
    ''')
    # Add columns for maximum number of osmcSymbols
    for column in range(maxSigns):
        auxiliaryCursor.execute('''
            ALTER TABLE routes
              ADD osmcSymbol%s text;
        ''' % (str(column)))
        auxiliaryCursor.execute('''
            ALTER TABLE routes
              ADD network%s text;
        ''' % (str(column)))
        auxiliaryCursor.execute('''
            ALTER TABLE routes
              ADD route%s text;
        ''' % (str(column)))
        auxiliaryCursor.execute('''
            ALTER TABLE routes
              ADD ref%s text;
        ''' % (str(column)))

    # Insert route values into the table
    for r in listOfRoutes:
        if r.geometry is not None:
            row = r.getValuesRow()            
            auxiliaryCursor.execute('''
                INSERT INTO routes
                  VALUES (%s)
            ''' % (row))
    print " Finished inserting routes into new table."

    auxiliaryCursor.execute('''
        DROP TABLE IF EXISTS route_centroids;
    ''');

    auxiliaryCursor.execute('''        
        CREATE TABLE route_centroids AS
        SELECT H1.osm_id,St_Centroid(St_Envelope(H1.way)) AS centroid FROM routes H1                
    ''');

    auxiliaryCursor.execute('''
        CREATE INDEX i__route_centroids__controid ON route_centroids USING GIST (centroid)
    ''');

    auxiliaryCursor.execute('''
        DROP TABLE IF EXISTS route_density;
    ''');

    auxiliaryCursor.execute('''        
        CREATE TABLE route_density AS 
        SELECT H1.osm_id AS osm_id,Count(H2.osm_id) AS density FROM route_centroids H1
        LEFT JOIN route_centroids H2 ON ST_DWithin(H1.centroid,H2.centroid,1000) AND H1.osm_id <> H2.osm_id
        GROUP BY H1.osm_id
     ''');

    auxiliaryCursor.execute('''
        CREATE INDEX i__route_density__osm_id ON route_density (osm_id)
    ''');

    auxiliaryCursor.execute('''
        DROP TABLE IF EXISTS routes2
    ''');

    auxiliaryCursor.execute('''
        CREATE TABLE routes2 AS (
        SELECT osm_id,route,way,offsetside,highway,tracktype,"mtb:scale","mtb:scale:uphill",sac_scale,color,network,oneway,rank() OVER (PARTITION BY osm_id ORDER BY 
         (CASE
           WHEN route IS NULL THEN 100
           WHEN color = 'violet' THEN 1
           WHEN color = 'turquoise' THEN 2
           WHEN color = 'red' THEN 3
           WHEN color = 'green' THEN 4
           WHEN color = 'blue' THEN 5       
           WHEN color = 'yellow' THEN 6
           WHEN color = 'black' THEN 7
           WHEN color = 'white' THEN 8
           WHEN color = 'brown' THEN 9
           WHEN color = 'orange' THEN 10
           WHEN color = 'purple' THEN 11
         END)
         
      ) AS offset,density FROM (
    SELECT 
      osm_id,way,
      offsetside,network,oneway,
      (CASE 
        WHEN route IN ('bicycle','mtb') THEN 'bicycle'
        WHEN route IS NULL AND (osmcsymbol IS NOT NULL OR network IS NOT NULL OR ref IS NOT NULL) THEN 'hiking'
        WHEN route IN ('foot','hiking') THEN 'hiking'
        ELSE route
      END) AS route,
      highway,tracktype,"mtb:scale","mtb:scale:uphill",sac_scale,
      (CASE
         WHEN route IN ('bicycle','mtb') THEN 'violet'
         WHEN route IN ('ski') THEN 'turquoise'
         WHEN osmcsymbol LIKE 'red:%' THEN 'red'
         WHEN osmcsymbol LIKE 'blue:%' THEN 'blue'
         WHEN osmcsymbol LIKE 'green:%' THEN 'green'
         WHEN osmcsymbol LIKE 'yellow:%' THEN 'yellow'
         WHEN osmcsymbol LIKE 'black:%' THEN 'black'
         WHEN osmcsymbol LIKE 'white:%' THEN 'white'
         WHEN osmcsymbol LIKE 'brown:%' THEN 'brown'
         WHEN osmcsymbol LIKE 'orange:%' THEN 'orange'
         WHEN osmcsymbol LIKE 'purple:%' THEN 'purple'
         WHEN network = 'iwn' THEN 'red'
         WHEN network = 'nwn' THEN 'green'
         WHEN network = 'rwn' THEN 'blue'
         ELSE 'red'
       END) AS color,
       density     	
    FROM (
        SELECT
          Y.osm_id,way,
          offsetside,highway,tracktype,"mtb:scale","mtb:scale:uphill",sac_scale,oneway,	  
           
          (CASE X.Which
          WHEN '0' THEN route0
          WHEN '1' THEN route1
          WHEN '2' THEN route2
          WHEN '3' THEN route3
          WHEN '4' THEN route4
          WHEN '5' THEN route5
          WHEN '6' THEN route6
          WHEN '7' THEN route7	  
          END) AS route,
            
          (CASE X.Which
          WHEN '0' THEN osmcsymbol0
          WHEN '1' THEN osmcsymbol1
          WHEN '2' THEN osmcsymbol2
          WHEN '3' THEN osmcsymbol3
          WHEN '4' THEN osmcsymbol4
          WHEN '5' THEN osmcsymbol5
          WHEN '6' THEN osmcsymbol6
          WHEN '7' THEN osmcsymbol7	  
          END) AS osmcsymbol,
          
          (CASE X.Which
          WHEN '0' THEN network0
          WHEN '1' THEN network1
          WHEN '2' THEN network2
          WHEN '3' THEN network3
          WHEN '4' THEN network4
          WHEN '5' THEN network5
          WHEN '6' THEN network6
          WHEN '7' THEN network7	  
          END) AS network,
          
          (CASE X.Which
          WHEN '0' THEN ref0
          WHEN '1' THEN ref1
          WHEN '2' THEN ref2
          WHEN '3' THEN ref3
          WHEN '4' THEN ref4
          WHEN '5' THEN ref5
          WHEN '6' THEN ref6
          WHEN '7' THEN ref7
          END) AS "ref",
          
          (SELECT Max(RD.density) FROM route_density RD WHERE RD.osm_id = Y.osm_id) AS density
              
        FROM
           routes Y
           CROSS JOIN (SELECT '0' UNION ALL SELECT '1' UNION ALL SELECT '2' UNION ALL SELECT '3' UNION ALL SELECT '4' UNION ALL SELECT '5' UNION ALL SELECT '6' UNION ALL SELECT '7' UNION ALL SELECT '8') X (Which)           
    ) AS R
    ) R2
    GROUP BY R2.osm_id,R2.way,R2.route,R2.offsetside,R2.highway,R2.tracktype,R2."mtb:scale",R2."mtb:scale:uphill",R2.sac_scale,R2.color,R2.density,R2.network,R2.oneway )
    ''');

    print "Relations:   ", len(relations)
    print "max Signs:   ", maxSigns
    print "Routes:      ", len(routes)
    print "Nodes:       ", len(nodes)
    print "Danger nodes:", len(dangerNodes)
#    print routes[39952857].nextRoutes, routes[44013159].previousRoutes
#    print nodes[559611826]

    # commit the result into the database
    auxiliaryCursor.close()
    connection.commit()
    
    print time.strftime("%H:%M:%S", time.localtime()), " - Relations2lines finished successfully."
    # end of main function
################################################################################

def routesFromRels(relations):
    routes = {}
    for rel in relations:
        if True or rel.osmcSymbol:
            for lineId in rel.lines:
                if routes.has_key(lineId):
                    routes[lineId].addSign(rel)
                else:
                    newRoute = route.Route(lineId, rel)
                    routes[lineId] = newRoute
    return routes

def findNodes(routes):
    nodes = {}
    for r in routes.values():
        if r.firstNode in nodes:
            nodes[r.firstNode].append(r.id)
        else:
            nodes[r.firstNode] = [r.id]
        if r.lastNode in nodes:
            nodes[r.lastNode].append(r.id)
        else:
            nodes[r.lastNode] = [r.id]
    return nodes

def setOffset(routes, currentId, direction):
    if (routes[currentId].offset == None):
        routes[currentId].offset = -1
#    print "Correct order: ", currentId
    if (direction == "next"):
        for nextID in routes[currentId].nextRoutes:
            if not (routes.has_key(nextID)):
                return
            if (routes[nextID].offset != None):
                return
            else:
                if (routes[currentId].lastNode == routes[nextID].firstNode):
                    routes[nextID].offset = routes[currentId].offset
                    setOffset(routes, nextID, "next")
                elif (routes[currentId].lastNode == routes[nextID].lastNode):
                    routes[nextID].offset = -routes[currentId].offset
                    setOffset(routes, nextID, "previous")
    else:
        for nextID in routes[currentId].previousRoutes:
            if not (routes.has_key(nextID)):
                return
            if (routes[nextID].offset != None):
                return
            else:
                if (routes[currentId].firstNode == routes[nextID].firstNode):
                    routes[nextID].offset = -routes[currentId].offset
                    setOffset(routes, nextID, "next")
                elif (routes[currentId].firstNode == routes[nextID].lastNode):
                    routes[nextID].offset = routes[currentId].offset
                    setOffset(routes, nextID, "previous")

def findDangerousNodes(nodes, routes):
    dangerNodes = {}
    for node in nodes:
        mtbMin = 6
        mtbMax = 0
        for line in nodes[node]:
            if routes[line].mtbScale:
                try:
                    mtbScale = int(routes[line].mtbScale.replace('+', '').replace('-',''))
                    if mtbScale > mtbMax:
                        mtbMax = mtbScale
                    if mtbScale < mtbMin:
                        mtbMin = mtbScale
                except ValueError:
                    continue
        if (mtbMax - mtbMin) >= 2:
            dangerNodes[node] = mtbMax - mtbMin
    return dangerNodes

def insertDangerNodes(nodes, cursor):
    cursor.execute('''
        SELECT attname FROM pg_attribute WHERE attrelid=(SELECT oid FROM pg_class WHERE relname='route_point') AND attname='warning'
        ''')
    if cursor.fetchone():
        cursor.execute('''
            ALTER TABLE route_point
                DROP COLUMN warning
            ''')
    cursor.execute('''
            ALTER TABLE route_point
                ADD "warning" integer
        ''')
    for dnID in nodes:
        cursor.execute("SELECT osm_id, way FROM route_point WHERE osm_id=%s" % dnID)
        if cursor.fetchone():
            cursor.execute('''
                UPDATE route_point SET "warning"=%s WHERE osm_id=%s
                ''' % (str(nodes[dnID]), dnID))
        else:
            cursor.execute("select lat, lon from route_nodes where id=%s" % dnID)
            nodeLatLon = cursor.fetchone()
            geometryCommand = "ST_SetSRID(ST_Point( %s, %s),900913) " % (str(nodeLatLon[1]/100.0), str(nodeLatLon[0]/100.0))
            pointValues = str(dnID) + ", " + geometryCommand + ", " + str(nodes[dnID])
            cursor.execute("INSERT INTO route_point (osm_id, way, warning) VALUES (%s)" % pointValues)

def removeUnconnected(routes, nodes):
    gradeOneIDs = []
    for r in routes:
        if routes[r].mtbScale == 'grade1':
            gradeOneIDs.append(routes[r].id)
    parsed = []
    connectedGradeOne = []
    disconnectedGradeOne = []
    for gradeOneID in gradeOneIDs:
        if gradeOneID in parsed:
            continue
        component = []
        component.append(gradeOneID)
        connected = False
        parsed.append(gradeOneID)
        neighbours = routes[gradeOneID].previousRoutes + routes[gradeOneID].nextRoutes
        while neighbours:
            n = neighbours.pop()
            if n in parsed:
                continue
            if not (routes[n].mtbScale == None or routes[n].mtbScale == 'grade1'):
                connected = True
                parsed.append(n)
                continue
            if routes[n].mtbScale == 'grade1':
                component.append(n)
                newToSearch = routes[n].previousRoutes + routes[n].nextRoutes
                for new in newToSearch:
                    if not new in parsed:
                        neighbours.append(new)
            parsed.append(n)
        if connected:
            connectedGradeOne += component
        else:
            disconnectedGradeOne += component
    print time.strftime("%H:%M:%S", time.localtime()), "  Components found, connection determined, now cleaning after removal..."
    iterations = 0
    for id in disconnectedGradeOne:
        if len(routes[id].osmcSigns) <= 1:
            r = routes.pop(id)
            nodes[r.firstNode].remove(r.id)
            if not len(nodes[r.firstNode]):
                nodes.pop(r.firstNode)
            nodes[r.lastNode].remove(r.id)
            if not len(nodes[r.lastNode]):
                nodes.pop(r.lastNode)
        else:
            routes[id].mtbScale = None

    # set correct mtb:scale value
    for id in connectedGradeOne:
        routes[id].mtbScale = '0'
    return routes
            

if __name__ == "__main__":
    main()

