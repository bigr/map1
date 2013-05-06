#!/usr/bin/env python

import mapnik
import sys
import math
import json
import os
import time
import codecs
import re
import regions
import Utfgrid
import gzip
from PIL import Image, ImageMath
import color_to_alpha

try:
    from osgeo import gdal
    from osgeo import osr
except ImportError:
    import gdal
    import osr

RESOLUTION=4

gridinfo = {    
    "landcover": ["osm_id","landuse","natural","leisure","amenity","place","sport","power","tourism","historic","wood","religion","name","way_area","wikipedia","website","ele","type","attribution","species","operator"],
    "landcover_point": ["osm_id","natural","name","wood","species","genus","taxon","denotation","attribution","wikipedia","website"],
    "landcover_line": ["osm_id","natural","name","wood","wikipedia","website"],
    "paboundary": ["osm_id","name","protect_class","wikipedia","website","way_area","protection_title","protection_object","protection_aim","protection_ban","protection_instruction","related_law","site_zone","valid_from","start_date","end_date","opening_hours","operator","governance_type","site_ownership","site_status","protection_award","contamination","ethnic_group","period","scale","ownership","owner","attribution","type","military","landuse","leisure"],
    "building": ["osm_id","building","name","walls","height","description","levels","way_area"],
    "highway-road-stroke": ["osm_id","highway","oneway","name","ref","int_ref","lanes","maxspeed","width","lit","sidewalk","footway","cycleway","mtb:scale","sac_scale","attribution","construction","smoothness","surface","tracktype","service","access","foot","ski","inline_skates","ice_skates","horse","vehicle","bicycle","carriage","trailer","caravan","motor_vehicle","motorcycle","moped","mofa","motorcar","motorhome","psv","bus","atv","taxi","tourist_bus","goods","hgv","agricultural","snowmobile","name"], 
    "highway-path-stroke": ["osm_id","highway","oneway","name","ref","int_ref","lanes","maxspeed","width","lit","sidewalk","footway","cycleway","mtb:scale","sac_scale","attribution","construction","smoothness","surface","tracktype","service","access","foot","ski","inline_skates","ice_skates","horse","vehicle","bicycle","carriage","trailer","caravan","motor_vehicle","motorcycle","moped","mofa","motorcar","motorhome","psv","bus","atv","taxi","tourist_bus","goods","hgv","agricultural","snowmobile","name"], 
    "railway": ["osm_id","railway","usage","service","gauge","voltage","frequency","electrified","cutting","embankment","operator","maxspeed","wikipedia","website"],     
    "waterarea": ["osm_id","waterway","natural","landuse","name","wetland","way_area","wikipedia","website"], 
    "power": ["osm_id","line","length","location","voltage","wires","frequency","operator","name","power"], 
    "barrier": ["osm_id","wikipedia","website","fence_type","height","stile","material","name","barrier"],
    "symbol": ["name","historic","man_made","amenity","leisure","tourism","information","natural","building","tower:type","place_of_worship","place_of_worship:type","railway","castle_type","highway","aeroway","type","name","wikipedia","website","ruins"],
    "text-place": ["name","population","place"],
}




#gridinfo = {
#    "highway-road-stroke": ["osm_id","highway","oneway","name","ref","int_ref","lanes","maxspeed","width","lit","sidewalk","footway","cycleway","mtb:scale","sac_scale","attribution","construction","smoothness","surface","tracktype","service","access","foot","ski","inline_skates","ice_skates","horse","vehicle","bicycle","carriage","trailer","caravan","motor_vehicle","motorcycle","moped","mofa","motorcar","motorhome","psv","bus","atv","taxi","tourist_bus","goods","hgv","agricultural","snowmobile","name"], 
#    "highway-path-stroke": ["osm_id","highway","oneway","name","ref","int_ref","lanes","maxspeed","width","lit","sidewalk","footway","cycleway","mtb:scale","sac_scale","attribution","construction","smoothness","surface","tracktype","service","access","foot","ski","inline_skates","ice_skates","horse","vehicle","bicycle","carriage","trailer","caravan","motor_vehicle","motorcycle","moped","mofa","motorcar","motorhome","psv","bus","atv","taxi","tourist_bus","goods","hgv","agricultural","snowmobile","name"], 
#}


def deg2num(lon_deg, lat_deg, zoom):
  lat_rad = math.radians(lat_deg)
  n = 2.0 ** zoom
  xtile = int((lon_deg + 180.0) / 360.0 * n)
  ytile = int((1.0 - math.log(math.tan(lat_rad) + (1 / math.cos(lat_rad))) / math.pi) / 2.0 * n)
  return (xtile, ytile)

def num2deg(xtile, ytile, zoom):
  n = 2.0 ** zoom
  lon_deg = xtile / n * 360.0 - 180.0
  lat_rad = math.atan(math.sinh(math.pi * (1 - 2 * ytile / n)))
  lat_deg = math.degrees(lat_rad)
  return (lon_deg, lat_deg)  

def composite(size,im1,im2 = None, opts = None):
    if not im2:        
        im2 = Image.new('RGBA', (size,size), (255, 255, 255, 255))

    if opts and 'colorToAlpha' in opts:
        im1 = color_to_alpha.color_to_alpha(im1,opts['colorToAlpha'])                       
    
    alpha = im1.split()[-1]    
            
    if opts and 'opacity' in opts:
        alpha = Image.eval(alpha,lambda a: a*opts['opacity'])
    
    im = Image.composite(im1,im2,alpha)
    
    return im.convert('RGB') 
    

TILE_SIZE = 256
METATILE_ZOOM = 8 # ZOOM where the metatile size is one tile size

P_900913 = mapnik.Projection('+proj=merc +a=6378137 +b=6378137 +lat_ts=0.0 +lon_0=0.0 +x_0=0.0 +y_0=0 +k=1.0 +units=m +nadgrids=@null +no_defs +over')




mtileX =  int(sys.argv[1])
mtileY =  int(sys.argv[2])
zoom = int(sys.argv[3])

bbs = ([map(float,sys.argv[4].split(','))] if sys.argv[4] != 'regions' else regions.get(zoom)) if len(sys.argv) >= 5 else None

TILES_DIR = os.environ['TILE_PATH'] if 'TILE_PATH' in os.environ else "/tmp/tiles"
mappath = os.environ['MAPNIK_MAP_PATH']
mapfiles = os.environ['MAPNIK_MAP_FILES'].strip(';').split(';')
layer_options = json.loads(os.environ['LAYER_OPTIONS'])

if zoom == 15:
    MAX_ZOOM_DIFF = 4
elif zoom == 16:
    MAX_ZOOM_DIFF = 4
else:
    MAX_ZOOM_DIFF = 4

fractions =  2 ** (zoom - METATILE_ZOOM - MAX_ZOOM_DIFF) if (zoom - METATILE_ZOOM) >= MAX_ZOOM_DIFF else 1


mtileSize = int(TILE_SIZE * (2 ** (zoom - METATILE_ZOOM))) / fractions

_1 = num2deg(mtileX,mtileY,METATILE_ZOOM)
_2 = num2deg(mtileX+1,mtileY+1,METATILE_ZOOM)
print "Rendering (%dx%d) subtiles." % (mtileSize,mtileSize)
sys.stdout.flush()
for xfrac in range(0,fractions):
    for yfrac in range(0,fractions):
        t00 = time.clock() 
        t00_ = time.time()        
        sys.stdout.flush()
        im = None
        k = 0;
        bboxll = mapnik.Box2d(_1[0], _1[1], _2[0], _2[1])
        bbox = P_900913.forward(bboxll)
        bbox = mapnik.Box2d(
            bbox.minx +  xfrac * (bbox.maxx - bbox.minx) / fractions,            
            bbox.miny +  yfrac * (bbox.maxy - bbox.miny) / fractions,
            bbox.minx +  (xfrac + 1) * (bbox.maxx - bbox.minx) / fractions,
            bbox.miny +  (yfrac + 1) * (bbox.maxy - bbox.miny) / fractions
        )
        
        bbox2 = P_900913.inverse(bbox)
                
        if bbs != None:
            skiped = True
            for bb in bbs:
                if not (max(bbox2.minx,bb[0]) >= min(bbox2.maxx,bb[2]) or max(bbox2.miny,bb[1]) >= min(bbox2.maxy,bb[3])):
                    skiped = False
                    break
            if skiped:
                print "SKIPED (out of bounds). (%gs/%gs)" % (time.clock() - t00,time.time() - t00_)
                continue
       
        
        composer = Utfgrid.Utfgrid()
        for mapfile in mapfiles:                    
            t0 = time.clock()
            t0_ = time.time()
            sys.stdout.write("\tRendering '%s'..." % (mapfile)) 
            sys.stdout.flush()               
            m = mapnik.Map(mtileSize,mtileSize)
            mapnik.load_map(m, "%s/~map-%s.xml" % (mappath,mapfile), True)
            m.buffer_size = 0
            m.resize(mtileSize, mtileSize)        
            m.zoom_to_box(bbox)            
            for n,l in enumerate(m.layers):                
                name = re.sub(r'((?:-layer|-priority|-grade|-class)[-]?[0-9]+)','',l.name)                
                if name in gridinfo: 
                    grid = mapnik.Grid(mtileSize, mtileSize) 
                    mapnik.render_layer(m, grid, layer = n, fields = gridinfo[name])
                    utfgrid = grid.encode('utf',resolution=RESOLUTION)
                    for key1 in utfgrid['data']:
                        for key2,val2 in utfgrid['data'][key1].items():
                            if val2 in (None,'no',''):
                                del utfgrid['data'][key1][key2]                                      
                    
                    composer.addLayer(json.dumps(utfgrid, ensure_ascii = False))
                    
                    
                    
                
            sys.stdout.write("done. (%gs/%gs)\n" % (time.clock() - t0,time.time() - t0_))
            sys.stdout.flush()
                                    
            k += 1
        
        t0 = time.clock()
        t0_ = time.time()
        sys.stdout.write("\tWriting utf grids...")
        sys.stdout.flush()        
        for i in range(mtileSize/TILE_SIZE):
            for j in range(mtileSize/TILE_SIZE):                
                tileX = mtileX * 2 ** (zoom - METATILE_ZOOM) + xfrac * mtileSize / TILE_SIZE + i
                tileY = (mtileY + 1) * 2 ** (zoom - METATILE_ZOOM) - (yfrac + 1) * mtileSize / TILE_SIZE + j
                if not os.path.isdir("%s/%s/%s" % (TILES_DIR,zoom,tileX)):
                    os.makedirs("%s/%s/%s" % (TILES_DIR,zoom,tileX))
                                                
                f = gzip.open("%s/%s/%s/%s.js.gz" % (TILES_DIR,zoom,tileX,tileY),'wb')
                f.write(composer.writeResult([TILE_SIZE*i/RESOLUTION, TILE_SIZE*j/RESOLUTION,TILE_SIZE*(i+1)/RESOLUTION,TILE_SIZE*(j+1)/RESOLUTION]).encode('utf8'))
                f.close()
                
        sys.stdout.write("done. (%gs/%gs)\n" % (time.clock() - t0,time.time() - t0_))
        sys.stdout.flush()
        print "DONE. (%gs/%gs)" % (time.clock() - t00,time.time() - t00_)
        sys.stdout.flush()



