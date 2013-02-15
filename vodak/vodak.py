#!/usr/bin/python
# -*- coding: utf-8 -*-

import sys
from psycopg2 import *



connection = connect("dbname='" + sys.argv[1] + "' user='klinger' password='' port='5432'")
ways = connection.cursor()
count = connection.cursor()
ways.execute('''
	SELECT DISTINCT osm_id,ST_StartPoint(way),ST_EndPoint(way),ST_Length(way),name FROM waterway WHERE waterway IN ('river','stream') AND name IS NOT NULL AND osm_id > 0
''')

print '''
	DROP TABLE IF EXISTS stream;
'''

print '''
	CREATE TABLE stream (
		osm_id INT,
		length FLOAT,
		grade INT,
		spring_id INT,
		total_length FLOAT,
		total_grade INT
	);
'''

count.execute('''
	SELECT Count(*) FROM waterway WHERE waterway IN ('river','stream') AND name IS NOT NULL;
''');

count = count.fetchone()[0]

streams = {}
springs = {}
outfalls = {}
starts = set()
ends = set()

i = 0
for osmId,start,end,length,name in ways:
	if start == end:
		continue
	if start not in streams:
		streams[start] = []	
	streams[start].append((osmId,start,end,length,name))
	
	if start not in ends:
		if start not in springs:
			springs[start] = []
		springs[start].append((osmId,name))
	if start in outfalls:
		del outfalls[start]
		
	if end not in starts:
		if end not in outfalls:
			outfalls[end] = []
		outfalls[end].append((osmId,name))
	if end in springs:
		del springs[end]
	starts.add(start)
	ends.add(end)
	i += 1
	if i % 1000 == 0:
		sys.stderr.write("Processed ways: %dK / %sK\r" % (i/1000,count/1000))
		sys.stderr.flush()

sys.stderr.write("\n");

inverse = {}

for end,outfall in outfalls.items():
	if len(outfall) > 1:
		for osmId,name in outfall:
			cur = connection.cursor()			
			cur.execute(
				'''			
					SELECT ST_StartPoint(way) FROM waterway WHERE osm_id = %d
				''' % osmId
			)		
			start = cur.fetchone()[0]
			if start in springs and len(springs[start]) > 1:
				inverse[end] = start
					
		
	


jumps = {}

outfallsD = {}
for k,v in outfalls.items():
	if not v[0][1]  or v[0][1] == '':
		continue
	names = v[0][1].split()
	for name in names:
		if name not in outfallsD:
			outfallsD[name] = []
		outfallsD[name].append((k,v[0]))

i = 0
count2 = len(springs)
for (start,tmp) in springs.items():	
	springId,springName = tmp[0]
	i += 1
	if i % 100 == 0:
		sys.stderr.write("Connecting breaked ways: %d / %s\r" % (i,count2))
		sys.stderr.flush()
	if not springName or springName == '':
		continue	
	if springName in outfallsD:		
		for (end,(outfallId,outfallName)) in outfallsD[springName]:
			if outfallId == springId:
				continue
			cur = connection.cursor()			
			cur.execute(
				'''
					SELECT
						ST_Distance(
							(SELECT ST_StartPoint(way) FROM waterway WHERE osm_id = %d LIMIT 1),
							(SELECT ST_EndPoint(way) FROM waterway WHERE osm_id = %d LIMIT 1)
						)			
				''' % (springId,outfallId)
			)
									
			dist = float(cur.fetchone()[0])
			
			if dist > 25000:
				continue
			if end in jumps and jumps[end][1] < dist:			
				continue	
			
			jumps[end] = (start,dist)
	

for jump in jumps.values():
	if jump[0] in springs:
		del springs[jump[0]]


sys.stderr.write("\n");


def _goOverStream(streams,ids,lensprings,p,j,i = 0,lengthA = 0,thisIds = set(), springId = None):
	a = []
	
	if springId == None:
		springId = springs[p][0][0]
	
	if p in streams:
		a.extend(streams[p])
	if p in jumps and jumps[p][0] in streams:		
		a.extend(streams[jumps[p][0]])
	if p in inverse:
		a.extend(streams[inverse[p]])

	for osmId,start,end,length,name in a:
		if (osmId,start,end) in thisIds:			
			break
		else:
			thisIds.add((osmId,start,end))				
		
		if osmId in ids:
			if ids[osmId] < lengthA + length:
				print "UPDATE stream SET length = %f, spring_id = %d WHERE osm_id = %d;" % (lengthA + length,springId,osmId)
				ids[osmId] = lengthA + length
			else:
				continue
		else:
			print "INSERT INTO stream (osm_id,length,spring_id) VALUES (%d,%f,%d);" % (osmId,lengthA + length,springId)
			ids[osmId] = lengthA + length
			i += 1
		
		if i % 1000 == 0:
			sys.stderr.write("Writing streams -> springs: %d / %d, ways: %dK / %sK\r" % (j,lensprings, i/1000,count/1000))
			sys.stderr.flush()
			
		i,j = _goOverStream(streams,ids,lensprings,end,j,i,lengthA + length,set(thisIds), springId)	

	return (i,j)
		
	

sys.stderr.write("\n");

j = 0
i = 0
ids = {}
lensprings = len(springs)
for spring in springs.keys():	
	i,j = _goOverStream(streams,ids,lensprings,spring,j,i)	
	j += 1

sys.stderr.write("\n");		
