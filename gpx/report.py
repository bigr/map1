# -*- coding: utf-8 -*-

import gpxpy
import gpxpy.gpx
import geo
import numpy as np
import matplotlib.pyplot as plt
from scipy import interpolate
from scipy import misc
from scipy import signal
import urllib2
import json
import sys
import math

def gauss(width,center,x):
  return math.exp(-(x-center)**2/(2*width**2))

def interPolyChain(m,z,maxNumOfVertices, tolerance = 2.5):
  _cache = {}
      
  def _evaluate(m,z,n):  
    if (str(m),str(z),n) in _cache:
      return _cache[(str(m),str(z),n)]
    if 1 == n:
      if m[-1] == m[0]:
        ret = [0,[(m[0],z[0],0)]]
      else:
        d = (z[-1] - z[0]) / (m[-1] - m[0])
        ret = [0,[(m[0],z[0],d)]]
        tmp = 0
        for i in range(1,len(m)):
          tmp += (m[i] - m[i-1]) * (z[i] - z[i-1]);
        ret[0] = ((tmp  - ((m[-1] - m[0]) * (z[-1] - z[0])))*0.5)**2
    else:  
      ret = [None,None]
      for i in range(1,len(m)-n+1):
        if m[i] - m[0] > 2500:
          break;
        a = _evaluate(m[:i+1],z[:i+1],1)
        b = _evaluate(m[i:],z[i:],n-1)      
        if ret[0] == None or a[0]+b[0] < ret[0]:
          ret[0] = a[0]+b[0]
          ret[1] = a[1]+b[1]
    _cache[(str(m),str(z),n)] = ret
    return ret
      
  for n in range(0,maxNumOfVertices):    
    ret = _evaluate(m,z,n+1)    
    if (ret[0] ** 0.5) / (m[-1] - m[0]) < tolerance:
      return ret
  return ret

def genWaypoints(x,y):
  bbox = [min(y),min(x),max(y),max(x)]
  response = urllib2.urlopen("http://overpass.osm.rambler.ru/cgi/interpreter?data=[out:json];node[natural~'peak'][name](%(X)s);node[place~'town|city|village|hamlet'](%(X)s);out;" % {'X':','.join(map(str,bbox))})    
  places = json.loads(response.read())  
  
  minplaces = {}
  for i in range(len(x)):
    lon,lat = x[i],y[i]    
    pt1 = geo.xyz(lon,lat)
    mindist = False
    minplace = False
    for place in places['elements']:    
      pt2 = geo.xyz(place['lon'],place['lat'])
      dist = geo.distance(pt1,pt2)
      if False == mindist or dist < mindist:
        if (dist < 100 and 'natural' in place['tags'] and place['tags']['natural'] == 'peak') or \
           (dist < 150 and 'place' in place['tags'] and place['tags']['place'] == 'hamlet') or \
           (dist < 500 and 'place' in place['tags'] and place['tags']['place'] == 'village') or \
           (dist < 1500 and 'place' in place['tags'] and place['tags']['place'] == 'place') or \
           (dist < 5000 and 'place' in place['tags'] and place['tags']['place'] == 'city'):
          mindist = dist
          minplace = place
    if minplace:      
      minplaces[minplace['tags']['name']] = minplace
  waypoints = {}
  for place in minplaces.values():    
    pt2 = geo.xyz(place['lon'],place['lat'])
    mindist = False;  
    for i in range(len(x)):
      lon,lat = x[i],y[i]
      pt1 = geo.xyz(lon,lat)
      dist = geo.distance(pt1,pt2)
      if False == mindist or dist < mindist:
        mindist = dist
        mini = i      
    if (mindist < 100 and 'natural' in place['tags'] and place['tags']['natural'] == 'peak') or \
       (mindist < 150 and 'place' in place['tags'] and place['tags']['place'] == 'hamlet') or \
       (mindist < 500 and 'place' in place['tags'] and place['tags']['place'] == 'village') or \
       (mindist < 1500 and 'place' in place['tags'] and place['tags']['place'] == 'place') or \
       (mindist < 5000 and 'place' in place['tags'] and place['tags']['place'] == 'city'):
         
      waypoints[mini] = (mindist,place['tags']['name'])
  return waypoints;

def getUphills(m,z):
  uphill = False
  uphill_candidates = []
  for i in range(1,len(m)):
    cm,cz,lm,lz = m[i],z[i],m[i-1],z[i-1]    
    if cm == lm: continue;
    dz = (cz-lz)/(cm-lm)
    
    if not uphill:
      if dz > 0.0:
        uphill = (lm,lz);
    if uphill:
      if dz < 0.0:
        if lz and (cz - uphill[1])/(cm-uphill[0]) > 0.01:
          uphill_candidates.append((uphill,(lm,lz)))        
        uphill = False    

  uphills = []
  i = 0
    
  while i < len(uphill_candidates):
    k = False
    end = False
    start = uphill_candidates[i][0]
    for j in range(i,len(uphill_candidates)):      
      end_candidate = uphill_candidates[j][1]
      dz = (end_candidate[1]-start[1])/(end_candidate[0]-start[0])      
      if uphill_candidates[j][0][0] != start[0] and (uphill_candidates[j][0][1]-start[1])/(uphill_candidates[j][0][0]-start[0]) < 0.02:
        break
      elif dz > 0.02 and (not end or end[1] < end_candidate[1] ) and (end_candidate[1]-start[1]) > 25:
        end = end_candidate
        k = j
      
    if k:
      uphillm = []
      uphillz = []
      for l in range (len(m)):        
        if m[l] >= start[0] and m[l] <= end[0]:
          uphillm.append(m[l] - start[0])
          uphillz.append(z[l])
      uphills.append((start,end,uphillm,uphillz))
        
      dz = (end[1]-start[1])/(end[0]-start[0])
      
      #print "%.1fkm (%.0fm) - %.1fkm (%.0fm) %.1f%%\t%.0fm\t%.0fm" % (start[0]/1000,start[1],end[0]/1000,end[1],100*dz,end[0]-start[0],end[1]-start[1])
      i = k + 1
    else:
      i += 1
      
  return uphills;

gpx_file = open(sys.argv[1], 'r')

gpx = gpxpy.parse(gpx_file)

x = []
y = []
z = []
m = []
lpt = None

for track in gpx.tracks:
  name = track.name
  for segment in track.segments:
    for point in segment.points:
      pt = geo.xyz(point.latitude,point.longitude)      
      x.append(point.longitude)
      y.append(point.latitude)
      z.append(point.elevation)
      if lpt != None:        
        m.append( m[-1] + geo.distance(pt,lpt))
      else:
        m.append(0.0)
      lpt = pt

#print m

uphills = getUphills(m,z)
waypoints = genWaypoints(x,y)

totalm = 0
totalz = 0

for start,end,m__,z__ in uphills:  
  totalm += end[0]-start[0]
  totalz += end[1]-start[1]

uphill_stats = []
i = 0
for start,end,m__,z__ in uphills:
  i += 1
  item = {}  
  item['i'] = i
  item['l'] = end[0]-start[0]
  item['h'] = end[1]-start[1]
  item['s'] = (end[1]-start[1])/(end[0]-start[0])
  item['rl'] = (end[0]-start[0])/totalm
  item['rh'] = (end[1]-start[1])/totalz
  uphill_stats.append(item)
  

uphill_stats_sorted = sorted(uphill_stats, key=lambda _: _['h'])

def slope2color(ps):
  cps = ps*100
  r = 100 + 0.9*gauss(2.5,0,cps)*156 + 0.8*gauss(4,9,cps)*156 + 0.9*gauss(5,25,cps)*156
  g = 100 + 0.9*gauss(2.5,0,cps)*156 + 0.7*gauss(2,3.5,cps)*156
  b = 100 + 0.9*gauss(2.5,0,cps)*156 + 0.9*gauss(5,25,cps)*156
  
  r = max(0,min(255,int(r)))
  g = max(0,min(255,int(g)))
  b = max(0,min(255,int(b)))    
  return "RGB(%d,%d,%d)" % (r,g,b)

print '<?xml version="1.0" encoding="UTF-8"?>'
print '<gpx-report xmlns="http://map1.eu/xmlns/gpx-report/1.0" name="%s">' % name
print '\t<profile l="%.2f">' % (m[-1]-m[0],)
for i in range(len(m)):
  if i in waypoints:
    label = 'label="%s"' % waypoints[i][1]
  else:
    label = ''
  print '\t\t<pt x="%f" y="%f" m="%.2f" z="%.1f" %s />' % (x[i],y[i],m[i],z[i],label) 
  m[i],z[i]
print '\t</profile>'
print '\t<uphill_stats totalm="%.2f" totalz="%.1f">' % (totalm,totalz)
for item in uphill_stats_sorted:  
  c = slope2color(item['s'])
  print '\t\t<uphill_stat i="%d" h="%.1f" l="%.2f" s="%.1f" rh="%.1f" rl="%.2f" c="%s"/>' % (item['i'],item['h'],item['l'],item['s']*100,item['rh'],item['rl'],c)    
print '\t</uphill_stats>';
print '\t<uphills>'
for start,end,m,z in uphills:  
  s = (end[1]-start[1])/(end[0]-start[0])
  print '\t\t<uphill m1="%.2f" z1="%.1f" m2="%.2f"  z2="%.1f" h="%.1f" l="%.2f" s="%.1f">' % (start[0],start[1],end[0],end[1],end[1]-start[1],end[0]-start[0],100*s)  
  polyChain = interPolyChain(m,z,30)
  for i in range(len(polyChain[1])):
    pm1,pz1,ps = polyChain[1][i]
    if i == len(polyChain[1]) - 1:
      pm2 = end[0]-start[0]
      pz2 = end[1]
    else:
      pm2,pz2,_ = polyChain[1][i+1]
    l = pm2 - pm1 
    h = pz2 - pz1
    
    c = slope2color(ps)
    
    print '\t\t\t<seg m1="%.2f" z1="%.1f" m2="%.2f" z2="%.2f" h="%.1f" l="%.2f" s="%.1f" c="%s"/>' % (pm1,pz1,pm2,pz2,h,l,100*ps,c)
  print "\t\t</uphill>"
print '\t</uphills>'
print '</gpx-report>'

  #print interPolyChain(uphill[2],uphill[3],10)

#print "'"
#print genWaypoints(x,y)
#print "'"







      

