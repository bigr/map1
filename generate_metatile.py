#!/usr/bin/env python

import mapnik
import sys
import math
import json
import os
import time
from PIL import Image, ImageMath
import color_to_alpha
from pysqlite2 import dbapi2 as sqlite3

try:
    from osgeo import gdal
    from osgeo import osr
except ImportError:
    import gdal
    import osr




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

conn = sqlite3.connect('/home/klinger/mymap/data/tiles/sqlite/%d.%d.db' %(mtileX, mtileY))

conn.enable_load_extension(True);

c = conn.cursor()

c.execute("SELECT Load_Extension('libspatialite.so');")


bb = map(float,sys.argv[4].split(',')) if len(sys.argv) >= 5 else None

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


SKIPED = 0;
NOT_SKIPED = 0

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
        #print "\n* RENDERING [%d/%d,%d/%d] {<%g|%g>,<%g|%g>}" % (xfrac+1,fractions,yfrac+1,fractions,bbox2.minx,bbox2.maxx,bbox2.miny,bbox2.maxy)        
        if bb and (max(bbox2.minx,bb[0]) >= min(bbox2.maxx,bb[2]) or max(bbox2.miny,bb[1]) >= min(bbox2.maxy,bb[3])):
            #print _1,_2,bb
            #print max(_1[0],bb[0]),min(_2[0],bb[2]),max(_2[1],bb[1]),min(_1[1],bb[3]), (max(_1[0],bb[0]) <= min(_2[0],bb[2]) or max(_2[1],bb[1]) <= min(_1[1],bb[3]))
            print "SKIPED (out of bounds). (%gs/%gs)" % (time.clock() - t00,time.time() - t00_)
            continue
        
        query = "SELECT Count(*) FROM highways_text WHERE MbrOverlaps(way,BuildMbr(%(x1)f,%(y2)f,%(x2)f,%(y1)f)) AND highway = 'residential'" % {
            'x1': bbox2.minx,
            'y1': bbox2.miny,
            'x2': bbox2.maxx,
            'y2': bbox2.maxy,
        }                
        
        c = conn.cursor()
        c.execute(query)
        residentialsCount, = c.fetchone()
               
        
        
        if residentialsCount < 50 and zoom > 20:
            SKIPED += 1
            print "SKIPED (low residentials). (%gs/%gs)" % (time.clock() - t00,time.time() - t00_)
            continue
        else:
            NOT_SKIPED += 1            
       
        for mapfile in mapfiles:
            opts = layer_options[str(k)] if str(k) in layer_options else None
            if mapfile == 'hillshade':
                t0 = time.clock()
                t0_ = time.time()
                sys.stdout.write("\tRendering 'hillshade'...")
                sys.stdout.flush()
                os.system("gdal_translate -q -projwin %(x1)f %(y2)f %(x2)f %(y1)f /home/klinger/mymap/data/tiles/srtm/~%(tileX)s.%(tileY)s.hillshade.tif /tmp/~%(tileX)s.%(tileY)s.hillshade.tif" % {
                    'x1': bbox.minx,
                    'y1': bbox.miny,
                    'x2': bbox.maxx,
                    'y2': bbox.maxy,
                    'tileX': mtileX,
                    'tileY': mtileY
                });
                
                tileim = Image.open('/tmp/~%s.%s.hillshade.tif' % (mtileX,mtileY))
                
                sizeX,sizeY = tileim.size
                tileim = tileim.resize(
                    (int(mtileSize),int(mtileSize)),
                    Image.ANTIALIAS if mtileSize < sizeX else Image.BILINEAR
                )
                lowLimit = 150
                lowCompression = 2.0        
                highLimit = 225
                highCompression = 2.5
                lowCompress = lambda x: lowLimit - ((lowLimit - x) / lowCompression) if x < lowLimit else x
                highCompress = lambda x: (highLimit + ((x - highLimit) / highCompression) if x > highLimit else x) + (255 - highLimit) * (1.0 - 1.0/highCompression);
                gamma = lambda x,g: 255.0 * (float(x) / 255.0) ** (1.0/float(g))
                
                tileim = Image.eval(tileim,lambda x: highCompress(lowCompress(gamma(x,1.3))))
                sys.stdout.write("done. (%gs/%gs)\n" % (time.clock() - t0,time.time() - t0_))
                sys.stdout.flush()
            else:
                t0 = time.clock()
                t0_ = time.time()
                sys.stdout.write("\tRendering '%s'..." % (mapfile)) 
                sys.stdout.flush()               
                m = mapnik.Map(mtileSize,mtileSize)
                mapnik.load_map(m, "%s/~map-%s.xml" % (mappath,mapfile), True)
                m.buffer_size = 512 if mapfile == "text" else 48 
                m.resize(mtileSize, mtileSize)        
                m.zoom_to_box(bbox)
                tileim = mapnik.Image(mtileSize, mtileSize)            
                mapnik.render(m, tileim)
                tileim = Image.fromstring('RGBA',(mtileSize, mtileSize),tileim.tostring())
                sys.stdout.write("done. (%gs/%gs)\n" % (time.clock() - t0,time.time() - t0_))
                sys.stdout.flush()
                        
            im = composite(mtileSize,tileim,im,opts)
            k += 1
            
        
        t0 = time.clock()
        sys.stdout.write("\tCroping tiles...")
        sys.stdout.flush()
        im.convert('RGB')        
        for i in range(mtileSize/TILE_SIZE):
            for j in range(mtileSize/TILE_SIZE):
                im2 = im.crop((TILE_SIZE*i, TILE_SIZE*j,TILE_SIZE*(i+1),TILE_SIZE*(j+1)))
                tileX = mtileX * 2 ** (zoom - METATILE_ZOOM) + xfrac * mtileSize / TILE_SIZE + i
                tileY = (mtileY + 1) * 2 ** (zoom - METATILE_ZOOM) - (yfrac + 1) * mtileSize / TILE_SIZE + j
                if not os.path.isdir("%s/%s/%s" % (TILES_DIR,zoom,tileX)):
                    os.makedirs("%s/%s/%s" % (TILES_DIR,zoom,tileX))
                im2.save("%s/%s/%s/%s.jpg" % (TILES_DIR,zoom,tileX,tileY),'JPEG',quality=85)
        sys.stdout.write("done. (%gs/%gs)\n" % (time.clock() - t0,time.time() - t0_))
        sys.stdout.flush()
        print "DONE. (%gs/%gs)" % (time.clock() - t00,time.time() - t00_)
        sys.stdout.flush()


conn.close()


print "%g" % (100*float(SKIPED)/float(SKIPED+NOT_SKIPED))
