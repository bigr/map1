#!/usr/bin/env python
# -*- coding: utf-8 -*-
import mwparserfromhell
import re
import codecs
import sys
import xml.etree.cElementTree as xml
from string import replace

_temp = __import__("mapping_"+sys.argv[1])
wikiMapping = _temp.wikiMapping

class Mapper:
	def __init__(self,wikicode):
		self._wikicode = wikicode
		self._templates = self._wikicode.filter_templates()
	def __contains__(self, item):		
		exp = re.compile(item if isinstance(item,basestring) else item[0],re.UNICODE|re.MULTILINE)
		if not isinstance(item,basestring):
			exp2 = re.compile(item[1],re.UNICODE|re.MULTILINE)
		
		for tpl in self._templates:
			if ( exp.match(unicode(tpl.name).strip()) ):
				if isinstance(item,basestring):
					return True
				else:
					for param in tpl.params:												
						if exp2.match(unicode(param.name).strip()):
							return True
		

	def __getitem__(self,key):
		exp = re.compile(key[0],re.UNICODE|re.MULTILINE)		
		exp2 = re.compile(key[1],re.UNICODE|re.MULTILINE)
		
		for tpl in self._templates:
			if ( exp.match(unicode(tpl.name).strip()) ):				
				for param in tpl.params:												
					if exp2.match(unicode(param.name).strip()):
						return param.value.strip()
	
	def integer(self,value,delimiter):
		match =  re.match(ur"\d+(?:" + delimiter + "\d\d\d)*(?=$|\D)",value)
		if match:
			return re.sub(delimiter,'',match.group(0))
		else:
			return None				


print """
DROP TABLE IF EXISTS "wiki";
SELECT DropGeometryColumn('public','wiki', 'way');
CREATE TABLE "wiki" (
  "id" BIGINT PRIMARY KEY,
  "title" VARCHAR(511),
  "name" VARCHAR(511),
  "place" VARCHAR(127),
  "status" VARCHAR(127),
  "ele" INT,
  "population" INT, 
  "text_length" INT,
  "historic" VARCHAR(127),
  "castle_type" VARCHAR(127),
  "ruins" INT,
  "amenity" VARCHAR(127),
  "religion" VARCHAR(63),
  "place_of_worship" VARCHAR(63),
  "tourism" VARCHAR(63),
  "natural" VARCHAR(127),    
  "osm_id" BIGINT
);
SELECT AddGeometryColumn('wiki', 'way', 900913, 'POINT', 2);
"""		

sys.stdout=codecs.getwriter('utf-8')(sys.stdout)

source = sys.stdin
context = iter(xml.iterparse(source, events=("start", "end")))
_,root = context.next()


page = False        
id = 0
fields = {}
for event, elem in context:	   	
    if elem.tag == "{http://www.mediawiki.org/xml/export-0.7/}page":
	page = event == 'start'
	if event == 'end':	    
	    if 'lat' in fields:		
		id += 1;
		
		print """
			INSERT INTO wiki (
			    id,way,title,
			    name,ele,population,text_length,place,
			    historic,castle_type,ruins,amenity,
			    religion,place_of_worship,tourism,"natural"
			) VALUES (
			    %(id)s,ST_Transform(ST_SetSRID(ST_MakePoint(%(lon)s,%(lat)s),4326),900913),%(title)s,
			    %(name)s,%(ele)s,%(population)s,%(text_length)s,%(place)s,
			    %(historic)s,%(castle_type)s,%(ruins)s,%(amenity)s,
			    %(religion)s,%(place_of_worship)s,%(tourism)s,%(natural)s
			);""" % {
		    'id': id,
		    'lat': fields['lat'],
		    'lon': fields['lon'],
		    'title': ("'" + replace(title,"'","''") + "'") if title else 'null',
		    'name': ("'" + replace(fields['title'],"'","''") + "'") if 'title' in fields else 'null',						
		    'ele': "'" + fields['ele'] + "'" if 'ele' in fields else 'null',
		    'population': "'" + fields['population'] + "'" if 'population' in fields and fields['population'] else 'null',			
		    'text_length': ("'" + str(text_length) + "'") if text_length else 'null',
		    'place': "'" + fields['place'] + "'" if 'place' in fields else 'null',
		    'historic': "'" + fields['historic'] + "'" if 'historic' in fields else 'null',	
		    'castle_type': "'" + fields['castle_type'] + "'" if 'castle_type' in fields else 'null',	
		    'ruins': "'" + fields['ruins'] + "'" if 'ruins' in fields else 'null',
		    'amenity': "'" + fields['amenity'] + "'" if 'amenity' in fields else 'null',
		    'religion': "'" + fields['religion'] + "'" if 'religion' in fields else 'null',
		    'place_of_worship': "'" + fields['place_of_worship'] + "'" if 'place_of_worship' in fields else 'null',
		    'tourism': "'" + fields['tourism'] + "'" if 'tourism' in fields else 'null',
		    'natural': "'" + fields['natural'] + "'" if 'natural' in fields else 'null'
		}
	else:
	    text_length = None
	    fields = {}
    elif page and event == 'end':
	if elem.tag=='{http://www.mediawiki.org/xml/export-0.7/}title':
	    title = elem.text		
	elif elem.tag=='{http://www.mediawiki.org/xml/export-0.7/}text':	
	    if elem.text:
		try:
		    text = replace(elem.text,'&nbsp;',' ')
		    text_length = len(text)		
		    wikicode = mwparserfromhell.parse(text)
		    x = Mapper(wikicode)
		    fields = {}
		    for field,mps in wikiMapping.items():	
			for mp in mps:
			    if mp['cond'](x):
				fields[field] = mp['val'](x)
				break
		except Exception, err:
		    sys.stderr.write('ERROR: %s\n' % str(err))
	    else:
		text_length = None
		fields = {}
	    
    if event == 'end':
	root.clear()

print """
UPDATE wiki W
SET osm_id = P.osm_id
FROM planet_osm_point P
WHERE 
      P.place IN ('city','town','village','hamlet','isolated_dwelling','suburb','neighbourhood')
  AND W.place IN ('urb','city','town','village','hamlet','isolated_dwelling','suburb','neighbourhood')
  AND COALESCE(W.name,W.title) = P.name
  AND ST_DWithin(W.way,P.way,3000)
  AND W.population IS NOT NULL;
  
UPDATE wiki W
SET osm_id = P.osm_id
FROM planet_osm_point P
WHERE 
      P.natural = 'peak'
  AND W.natural = 'peak'
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
     W.historic in ('castle','ruins');

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
     W.amenity in ('place_of_worship');  
    
  
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
    W.amenity in ('theatre');
  

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
    W.tourism IN ('museum','gallery')


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
     W.historic IN ('memorial','monument') 

"""
