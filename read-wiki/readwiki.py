#!/usr/bin/env python
# -*- coding: utf-8 -*-
import sys
import re
import xml.etree.cElementTree as xml
import codecs
from string import replace

def parseGeoLocation(geo_cz,geo_dms,geo,coord):
	try:
		toNumber = lambda s:float(replace(s,u",",u"."))		
		if geo_cz:
			x = geo_cz.split('|')
			return (toNumber(x[0]) + toNumber(x[1])/60.0 + toNumber(x[2])/3600.0,toNumber(x[3]) + toNumber(x[4])/60.0 + toNumber(x[5])/3600.0)
		elif geo_dms:		
			x = geo_dms.split('|')
			ret = (toNumber(x[0]) + toNumber(x[1])/60.0 + toNumber(x[2])/3600.0,toNumber(x[5]) + toNumber(x[6])/60.0 + toNumber(x[7])/3600.0)
			if x[3]=='S':
				ret = (-ret[0],ret[1])
			if x[8]=='W':
				ret = (ret[0],-ret[1])
			return ret
		elif geo:
			x = geo.split('|')
			x = x[0].split('_')		
			if x[3] in ['S','N'] and x[7] in ['W','E']:
				ret = (toNumber(x[0]) + toNumber(x[1])/60.0 + toNumber(x[2])/3600.0,toNumber(x[4]) + toNumber(x[5])/60.0 + toNumber(x[6])/3600.0)
				if x[3]=='S':
					ret = (-ret[0],ret[1])
				if x[7]=='W':
					ret = (ret[0],-ret[1])
				return ret
			elif x[2] in ['S','N'] and x[5] in ['W','E']:
				ret = (toNumber(x[0]) + toNumber(x[1])/60.0,toNumber(x[3]) + toNumber(x[4])/60.0)
				if x[2]=='S':
					ret = (-ret[0],ret[1])
				if x[5]=='W':
					ret = (ret[0],-ret[1])
				return ret
		elif coord:
		    pass;
		    
		return None;
	except:
		return None;

	
	
sys.stdout=codecs.getwriter('utf-8')(sys.stdout)

source = sys.stdin
context = iter(xml.iterparse(source, events=("start", "end")))
_,root = context.next()


geo_cz_pattern = re.compile(ur"{{(?:g|G)eo cz\|([^}{]+)}}");
geo_dms_pattern = re.compile(ur"{{(?:g|G)eo dms\|([^}{]+)}}");
geo_pattern = re.compile(ur"{{(?:g|G)eo\|([^}{]+)}}");
coord_pattern = re.compile(ur"{{(?:c|C|k|K)oord(?:ynaty)?\|([^}{]+)}}");

category_pattern = re.compile(ur"\[\[(?:k|K)ategorie:([^\]\|]+)(?:\|[^\]]*)?\]\]");
infobox_pattern = re.compile(ur"{{(?:i|I)nfobox[\s-]*([^\|]+)\|[^}]*}}");
#ele_pattern = re.compile(ur"\|/s*vrchol/s*=/s*([0..9]+)");

ele_pattern = re.compile(ur"\| (?:vrchol|kóta) = ([0-9\s]+)");
population_pattern = re.compile(ur"\| (?:obyvatelé) = ([0-9\s\.]+)");
status_pattern = re.compile(ur"\| (?:status) = ([^\s]+)");
name_pattern = re.compile(ur"(?:\|)? (?:název) = (.+)");


print """
DROP TABLE IF EXISTS "wiki";
SELECT DropGeometryColumn('public','wiki', 'way');
CREATE TABLE "wiki" (
  "id" BIGINT PRIMARY KEY,
  "title" VARCHAR(511),
  "name" VARCHAR(511),
  "infobox" VARCHAR(127),
  "status" VARCHAR(127),
  "ele" INT,
  "population" INT,
  "cats" VARCHAR(1023),
  "text_length" INT,
  "historic" VARCHAR(127),
  "castle_type" VARCHAR(127),
  "ruins" INT,
  "amenity" VARCHAR(127),
  "religion" VARCHAR(63),
  "place_of_worship" VARCHAR(63),
  "tourism" VARCHAR(63),
  "natural" VARCHAR(127),  
  "nkp" INT,
  "kp" INT,
  "osm_id" BIGINT
);
SELECT AddGeometryColumn('wiki', 'way', 900913, 'POINT', 2);
"""

page = False        
id = 0;
for event, elem in context:	   	
	if elem.tag == "{http://www.mediawiki.org/xml/export-0.6/}page":
		page = event == 'start'
		if event == 'end':
			if geo_cz or geo_dms or geo:
				cats = ';'.join(categories) if categories else ''
				id += 1;
				tmp = parseGeoLocation(geo_cz, geo_dms,geo)
				if tmp:
					print "INSERT INTO wiki (id,way,title,name,infobox,status,ele,population,cats,text_length) VALUES (%(id)s,ST_Transform(ST_SetSRID(ST_MakePoint(%(lon)s,%(lat)s),4326),900913),%(title)s,%(name)s,%(infobox)s,%(status)s,%(ele)s,%(population)s,%(cats)s,%(text_length)s);" % {
						'id': id,
						'lat': tmp[0],
						'lon': tmp[1],
						'title': ("'" + replace(title,"'","''") + "'") if title else 'null',
						'name': ("'" + replace(name,"'","''") + "'") if name else 'null',
						'infobox': ("'" + infobox + "'") if infobox else 'null',
						'status': ("'" + replace(status,"'","''") + "'") if status else 'null',
						'ele': ("'" + str(ele) + "'") if ele else 'null',
						'population': ("'" + str(population) + "'") if population else 'null',
						'cats': ("'" + replace(cats,"'","''") + "'") if cats else 'null',
						'text_length': ("'" + str(text_length) + "'") if text_length else 'null'
					}
		else:
			text_length = name = population = status = ele = infobox = categories = geo_cz = geo_dms = geo = None
	elif page and event == 'end':
		if elem.tag=='{http://www.mediawiki.org/xml/export-0.6/}title':
			title = elem.text		
		elif elem.tag=='{http://www.mediawiki.org/xml/export-0.6/}text':	
			if elem.text:					
				text = replace(elem.text,'&nbsp;',' ')
				text_length = len(text)
				geo_cz = geo_cz_pattern.search(text)				
				geo_cz = geo_cz.group(1) if geo_cz else None
				geo_dms = geo_dms_pattern.search(text)
				geo_dms = geo_dms.group(1) if geo_dms else None
				geo = geo_pattern.search(text)
				geo = geo.group(1) if geo else None
				categories = category_pattern.findall(text)
				infobox = infobox_pattern.search(text)
				infobox = infobox.group(1).strip() if infobox else None

				try:
					ele = ele_pattern.search(text)				
					ele = int(re.sub("[^0-9]",'',ele.group(1))) if ele else None
				except:
					ele = None

				try:
					population = population_pattern.search(text)
					population = int(re.sub("[^0-9]",'',population.group(1))) if population else None										
				except:
					population = None

				status = status_pattern.search(text)
				status = status.group(1).strip() if status else None

				name = name_pattern.search(text)
				name = name.group(1).strip() if name else None
			else:
				text_length = name = population = status = ele = infobox = categories = geo_cz = geo_dms = geo = None
		
	if event == 'end':
		root.clear()


print """
UPDATE wiki W
SET osm_id = P.osm_id
FROM planet_osm_point P
WHERE 
      P.place IN ('city','town','village','hamlet','isolated_dwelling','suburb','neighbourhood')
  AND COALESCE(W.name,W.title) = P.name
  AND ST_DWithin(W.way,P.way,3000)
  AND W.population IS NOT NULL;
  
UPDATE wiki W
SET osm_id = P.osm_id
FROM planet_osm_point P
WHERE 
      P.natural = 'peak'
  AND W.infobox = 'hora'
  AND (
       (ST_DWithin(W.way,P.way,300) AND COALESCE(W.name,W.title) = P.name)
    OR (ST_DWithin(W.way,P.way,100) AND (W.name IS NULL OR P.name IS NULL))
    OR ST_DWithin(W.way,P.way,30)
  );

UPDATE wiki W
SET osm_id = (
SELECT P.osm_id
FROM (
         SELECT osm_id,name,way,historic FROM planet_osm_point
   UNION SELECT osm_id,name,way,historic FROM planet_osm_polygon) P
WHERE 
      P.historic IN ('castle','ruins')
  
  AND (    
    ST_DWithin(W.way,P.way,1000 * (0.01 + similarity(regexp_replace(COALESCE(W.name,W.title),'hrad|z..cenina|z.mek|tvrz','','i'),regexp_replace(P.name,'hrad|z..cenina|z.mek|tvrz','','i'))))
  )
  ORDER BY ST_Distance(W.way,P.way) / (0.01 + similarity(regexp_replace(COALESCE(W.name,W.title),'hrad|z..cenina|z.mek','','i'),regexp_replace(P.name,'hrad|z..cenina|z.mek','','i')))  
LIMIT 1
)
WHERE
     W.infobox in ('Hrad','hrad')
  OR W.cats LIKE ('%Hrady %')
  OR W.cats LIKE ('%Z_mky %')
  OR W.cats LIKE ('%Tvrze %')
  OR W.cats LIKE ('%Z__ceniny hrad_ %');

UPDATE wiki W
SET osm_id = (
SELECT P.osm_id
FROM (
         SELECT osm_id,name,way,amenity FROM planet_osm_point
   UNION SELECT osm_id,name,way,amenity FROM planet_osm_polygon) P
WHERE 
      P.amenity = 'place_of_worship'
  
  AND (    
    ST_DWithin(W.way,P.way,300 * (0.01 + similarity(regexp_replace(COALESCE(W.name,W.title),'kostel','','i'),regexp_replace(P.name,'kostel','','i'))))
  )
  ORDER BY ST_Distance(W.way,P.way) / (0.01 + similarity(regexp_replace(COALESCE(W.name,W.title),'kostel','','i'),regexp_replace(P.name,'kostel','','i')))  
LIMIT 1
)
WHERE
     W.infobox in ('kostel','Kostel')  
  OR W.cats LIKE ('%Kostely %')
  OR W.cats LIKE ('%Kaple %')
  OR W.cats LIKE ('%Kl__tery %')
  OR W.cats LIKE ('%Me_ity %')
  OR W.cats LIKE ('%Synagogy %');
    
  
UPDATE wiki W
SET osm_id = (
SELECT P.osm_id
FROM (
         SELECT osm_id,name,way,amenity FROM planet_osm_point
   UNION SELECT osm_id,name,way,amenity FROM planet_osm_polygon) P
WHERE 
      P.amenity = 'theatre'
  
  AND (    
    ST_DWithin(W.way,P.way,500 * (0.01 + similarity(regexp_replace(COALESCE(W.name,W.title),'divadlo','','i'),regexp_replace(P.name,'divadlo','','i'))))
  )
  ORDER BY ST_Distance(W.way,P.way) / (0.01 + similarity(regexp_replace(COALESCE(W.name,W.title),'divadlo','','i'),regexp_replace(P.name,'divadlo','','i')))  
LIMIT 1
)
WHERE
    W.cats LIKE ('%Divadla %');
  

UPDATE wiki W
SET osm_id = (
SELECT P.osm_id
FROM (
         SELECT osm_id,name,way,tourism FROM planet_osm_point
   UNION SELECT osm_id,name,way,tourism FROM planet_osm_polygon) P
WHERE 
      P.tourism IN ('museum','gallery')
  
  AND (    
    ST_DWithin(W.way,P.way,500 * (0.01 + similarity(regexp_replace(COALESCE(W.name,W.title),'muzeum','','i'),regexp_replace(P.name,'muzeum','','i'))))
  )
  ORDER BY ST_Distance(W.way,P.way) / (0.01 + similarity(regexp_replace(COALESCE(W.name,W.title),'muzeum','','i'),regexp_replace(P.name,'muzeum','','i')))  
LIMIT 1
)
WHERE
     W.cats LIKE ('%Muzea %')
  OR W.cats LIKE ('%Galerie %');


UPDATE wiki W
SET osm_id = (
SELECT P.osm_id
FROM (
         SELECT osm_id,name,way,historic FROM planet_osm_point
   UNION SELECT osm_id,name,way,historic FROM planet_osm_polygon) P
WHERE 
      P.historic IN ('memorial','monument')  
  AND (    
    ST_DWithin(W.way,P.way,500 * (0.01 + similarity(regexp_replace(COALESCE(W.name,W.title),'pam.tn.k|pomn.k','','i'),regexp_replace(P.name,'pam.tn.k|pomn.k','','i'))))
  )
  ORDER BY ST_Distance(W.way,P.way) / (0.01 + similarity(regexp_replace(COALESCE(W.name,W.title),'pam.tn.k|pomn.k','','i'),regexp_replace(P.name,'pam.tn.k|pomn.k','','i')))  
LIMIT 1
)
WHERE
     W.cats LIKE ('%Pomn_ky a pam_tn_ky %'); 


UPDATE wiki W
SET "natural" = 'peak'
WHERE W.infobox = 'hora';
 
UPDATE wiki W
SET
  historic = 'castle',
  castle_type = (CASE
    WHEN W.cats LIKE ('%Hrady %') OR W.cats LIKE ('%Z__ceniny hrad_ %') THEN 'defensive'
    WHEN W.cats LIKE ('%Z_mky %') THEN 'stately'
    ELSE NULL    
  END),
  ruins = (CASE
    WHEN W.cats LIKE ('%Z__ceniny %') THEN 1
    ELSE NULL
  END)
WHERE
     W.infobox in ('Hrad','hrad')
  OR W.cats LIKE ('%Hrady %')
  OR W.cats LIKE ('%Z_mky %')
  OR W.cats LIKE ('%Z__ceniny hrad_ %');
  
UPDATE wiki W
SET
  amenity = 'place_of_worship',
  religion = (CASE
    WHEN W.cats LIKE ('%Me_ity %') THEN 'christian'
    WHEN W.cats LIKE ('%Synagogy %') THEN 'jewish'
    ELSE 'muslim'    
  END),
  place_of_worship = (CASE
    WHEN W.cats LIKE ('%Kaple %') THEN 'chapel'
    WHEN W.cats LIKE ('%Kl__tery %') THEN 'monastery'
    ELSE 'church'    
  END)
WHERE    
     W.infobox in ('kostel','Kostel')
  OR W.cats LIKE ('%Kostely %')
  OR W.cats LIKE ('%Kaple %')
  OR W.cats LIKE ('%Kl__tery %')
  OR W.cats LIKE ('%Me_ity %')
  OR W.cats LIKE ('%Synagogy %');

UPDATE wiki W
SET amenity = 'theatre'
WHERE 
  W.cats LIKE ('%Divadla %');

UPDATE wiki W
SET tourism = 'museum'
WHERE 
     W.cats LIKE ('%Muzeua %')  
  OR W.cats LIKE ('%Galerie %');


UPDATE wiki W
SET nkp = 1
WHERE 
    W.cats LIKE ('%N_rodn_ kulturn_ p_m_tky %');
    
UPDATE wiki W
SET kp = 1
WHERE 
    W.cats LIKE ('%Kulturn_ p_m_tky %');
"""


