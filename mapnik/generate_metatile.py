#!/usr/bin/env python

import mapnik
import sys
import math

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
mapfiles = sys.argv[4].strip(';').split(';') 



mtileSize = int(TILE_SIZE * (2 ** (zoom - METATILE_ZOOM)))


im = None
for mapfile in mapfiles:
    print "Rendering '%s'..." % mapfile
    m = mapnik.Map(mtileSize,mtileSize)
    mapnik.load_map(m, mapfile, True)
    m.buffer_size = 256 # TODO
    m.resize(mtileSize, mtileSize)
    _1 = num2deg(mtileX,mtileY,METATILE_ZOOM)
    _2 = num2deg(mtileX+1,mtileY+1,METATILE_ZOOM)
    bbox = P_900913.forward(mapnik.Box2d(_1[0], _1[1], _2[0], _2[1]))
    m.zoom_to_box(bbox)

    tileim = mapnik.Image(mtileSize, mtileSize)            
    mapnik.render(m, tileim)
    tileim = Image.fromstring('RGBA',(mtileSize, mtileSize),tileim.tostring())
    im = composite(mtileSize,tileim,im)

im.save("/tmp/test.jpg",'JPEG',quality=85)


