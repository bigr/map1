# -*- coding: utf-8 -*-

from psycopg2 import *
from sys import argv
import json
import os

def storeInfo(name,X1,Y1,X2,Y2):

	connection = connect("dbname='gis' user='klinger' password='' port=5432")
	cursor = connection.cursor()
	cursor.execute(U"""
		SELECT 
			asText(ST_Simplify(way,250)) AS wkt,
			highway,
			ref,
			int_ref
		FROM planet_osm_line	
		WHERE
				ST_Intersects(way, ST_SetSRID(ST_MakeBox2D(ST_Point('%f','%f'),ST_Point('%f','%f')),900913))
			AND highway IN ('motorway','trunk','primary')
				
	""" % (X1,Y1,X2,Y2))

	data = []
	for row in cursor:
		try:		
			data.append(
				{
					'a': {
						'highway':row[1],
						'ref':row[2],
						'ref_int':row[3]
					},
					'w': 10,
					'g': row[0]
				}				
			)
		except Exception as e:
			print e
			
			
	print(X1,Y1,X2,Y2)

	f = open(name, 'w')
	f.write(json.dumps(data))
	f.close()
	
	os.system('gzip -f %s' % name)


