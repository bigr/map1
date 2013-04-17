#!/usr/bin/env python
from math import pi,cos,sin,log,exp,atan,floor,ceil,atan
from subprocess import call
import sys, os, codecs
from Queue import Queue

import threading

from PIL import Image, ImageMath

import color_to_alpha
import json

import mapnik

import cairo

DEG_TO_RAD = pi/180
RAD_TO_DEG = 180/pi

# Default number of rendering threads to spawn, should be roughly equal to number of CPU cores available
NUM_THREADS = 1


def minmax (a,b,c):
    a = max(a,b)
    a = min(a,c)
    return a

class GoogleProjection:
    def __init__(self,levels=18):
        self.Bc = []
        self.Cc = []
        self.zc = []
        self.Ac = []
        c = 256
        for d in range(0,levels):
            e = c/2;
            self.Bc.append(c/360.0)
            self.Cc.append(c/(2 * pi))
            self.zc.append((e,e))
            self.Ac.append(c)
            c *= 2
                
    def fromLLtoPixel(self,ll,zoom):
         d = self.zc[zoom]
         e = round(d[0] + ll[0] * self.Bc[zoom])
         f = minmax(sin(DEG_TO_RAD * ll[1]),-0.9999,0.9999)
         g = round(d[1] + 0.5*log((1+f)/(1-f))*-self.Cc[zoom])
         return (e,g)
     
    def fromPixelToLL(self,px,zoom):
         e = self.zc[zoom]
         f = (px[0] - e[0])/self.Bc[zoom]
         g = (px[1] - e[1])/-self.Cc[zoom]
         h = RAD_TO_DEG * ( 2 * atan(exp(g)) - 0.5 * pi)
         return (f,h)



class RenderThread:
    def __init__(self, tile_dir, mapfiles, q, printLock, maxZoom, overwrite = False, tile_size = 256, tile_countX = 1, tile_countY = 1, buffer_size = 128, layer_options = {}, countries = [], zooms = 8):
        self.tile_size = tile_size
        self.layerOptions = layer_options
        self.tile_countX = tile_countX
        self.tile_countY = tile_countY
        self.buffer_size = buffer_size
        self.tile_dir = tile_dir
        self.q = q
        self.countries = countries
        self.zooms = zooms
        
        self.printLock = printLock
        self.overwrite = overwrite
        self.gridMap = False
        self.m = []
        for mapfile in mapfiles:
            if 'hillshade' in mapfile:
                m = 'hillshade'
            elif 'gridinfo' in mapfile:
                self.gridMap = {}
                for country in countries.keys():
                    gridMap = mapnik.Map(int(tile_size), int(tile_size))
                    
                    mapnik.load_map(gridMap,mapfile % {'country':country,'zooms':self.zooms})
                    self.gridMap[country] = gridMap
            else:
                m = {}
                for country in countries.keys(): 
                    #self.mp = mapnik.Map(int(tile_size), int(tile_size))
                    #print "Loading map %s..." % mapfile % {'country':country,'zooms':self.zooms}
                    #mapnik.load_map(_m, mapfile % {'country':country,'zooms':self.zooms}, True)
                    #m[country] = _m
                    m[country] = mapfile % {'country':country,'zooms':self.zooms}
                        
            self.m.append(m)
        
        
            
        # Obtain <Map> projection        
        self.prj = mapnik.Projection('+proj=merc +a=6378137 +b=6378137 +lat_ts=0.0 +lon_0=0.0 +x_0=0.0 +y_0=0 +k=1.0 +units=m +nadgrids=@null +no_defs +over')
        #self.prj = mapnik.Projection('+proj=vandg +lon_0=10 +x_0=0 +y_0=0 +R_A +ellps=WGS84 +datum=WGS84 +units=m +no_defs')
        
        # Projects between tile pixel co-ordinates and LatLong (EPSG:4326)
        self.tileproj = GoogleProjection(maxZoom+1)


    def _renderMapnik(self,mapfile,c0,c1):	
        render_sizeX = int(self.tile_countX * self.tile_size)
        render_sizeY = int(self.tile_countY * self.tile_size)
        bbox = mapnik.Box2d(c0.x,c0.y, c1.x,c1.y)
        
        #m = self.mp
        m = mapnik.Map(int(render_sizeX), int(render_sizeX))
        mapnik.load_map(m, mapfile, True)
        m.resize(render_sizeX, render_sizeY)
        m.zoom_to_box(bbox)
        m.buffer_size = self.buffer_size
        im = mapnik.Image(render_sizeX, render_sizeY)            
        mapnik.render(m, im)
        im = Image.fromstring('RGBA',(render_sizeX, render_sizeY),im.tostring())
        del m
        m = None

        return im
	
    def _renderHillshade(self,c0,c1,l0,l1):
        render_sizeX = int(self.tile_countX * self.tile_size)
        render_sizeY = int(self.tile_countY * self.tile_size)
        
        
        #name = "%d-%d-%d-%d" % (int(c0.x),int(c0.y),int(c1.x),int(c1.y))
        #os.system("/home/klinger/mymap/contours/hillshade.sh %(x1)f %(y1)f %(x2)f %(y2)f %(name)s"
        #    % {			
        #        'x1':c0.x, 'y1':c1.y, 'x2':c1.x, 'y2':c0.y,
        #        'name': name,
        #    }
        #)
        #im = Image.open('/tmp/hillshade-'+name+'.png')
        
        im = Image.new("L",(render_sizeX,render_sizeY),220)
        for lon in range(int(floor(l0[0])),int(ceil(l1[0]))):
            for lat in range(int(floor(l0[1])),int(ceil(l1[1]))): 
                try:
                    cc0 = self.prj.forward(mapnik.Coord(lon,lat))
                    cc1 = self.prj.forward(mapnik.Coord(lon+1,lat+1))
                    
                    cc0x = self.prj.forward(mapnik.Coord(lon-0.01,lat-0.01))
                    cc1x = self.prj.forward(mapnik.Coord(lon+1.01,lat+1.01))
                    
                    sizeX = render_sizeX * (cc1x.x - cc0x.x) / (c1.x - c0.x)
                    sizeY = render_sizeY * (cc1x.y - cc0x.y) / (c1.y - c0.y)
                    
                    fromX = render_sizeX * (cc0.x - c0.x) / (c1.x - c0.x)
                    fromY = render_sizeY * (cc1.y - c1.y) / (c0.y - c1.y) 
                                    
                    tileim = Image.open('/home/klinger/mymap/hillshade/%d/%d.hillshade.jpg' % (lon,lat))                    
                    tileim = tileim.resize(
                        (int(sizeX),int(sizeY)),
                        Image.ANTIALIAS if sizeX > render_sizeX/(l1[0]-l0[0]) else Image.BILINEAR
                    )
                    tileim = tileim.crop((
                        int(render_sizeX * (cc0.x-cc0x.x) / (c1.x - c0.x)),
                        int(render_sizeY * (cc0.y-cc0x.y) / (c1.y - c0.y)),
                        int(sizeX - render_sizeX * (cc1x.x-cc1.x) / (c1.x - c0.x)),
                        int(sizeY - render_sizeY * (cc1x.y-cc1.y) / (c1.y - c0.y)),
                    ));
                    #tileim = tileim.crop((int(cc0.x-cc0x.x),int(cc0x.y-cc0.y),int(sizeX-(cc1x.x-cc1.x)),int(sizeY-(cc1.y-cc1x.y))))
                    #if fromX > 0 and fromY > 0:
                    im.paste(tileim,(int(fromX),int(fromY)))
                except Exception as E:
                    print E    
        
        im = im.resize((render_sizeX,render_sizeY),Image.ANTIALIAS if im.size[0] > render_sizeX else Image.BILINEAR )
        
        lowLimit = 150
        lowCompression = 2.0        
        highLimit = 225
        highCompression = 2.5
        lowCompress = lambda x: lowLimit - ((lowLimit - x) / lowCompression) if x < lowLimit else x
        highCompress = lambda x: (highLimit + ((x - highLimit) / highCompression) if x > highLimit else x) + (255 - highLimit) * (1.0 - 1.0/highCompression);
        gamma = lambda x,g: 255.0 * (float(x) / 255.0) ** (1.0/float(g))
        
        im = Image.eval(im,lambda x: highCompress(lowCompress(gamma(x,1.3))))
        #os.remove('/tmp/hillshade-'+name+'.png')        
        return im
        
    def _composite(self,im1,im2 = None, opts = None):
        if not im2:
            render_sizeX = int(self.tile_countX * self.tile_size)
            render_sizeY = int(self.tile_countY * self.tile_size)
            im2 = Image.new('RGBA', (render_sizeX,render_sizeY), (245, 245, 245, 255))

        if opts and 'colorToAlpha' in opts:
            im1 = color_to_alpha.color_to_alpha(im1,opts['colorToAlpha'])                       
        
        alpha = im1.split()[-1]    
                
        if opts and 'opacity' in opts:
            alpha = Image.eval(alpha,lambda a: a*opts['opacity'])
        
        im = Image.composite(im1,im2,alpha)
        
        return im.convert('RGB')
        
        
    def _allLayers(self):
        k = 0
        for m in self.m:            
            opts = self.layerOptions[str(k)] if str(k) in self.layerOptions else None
            if m == 'hillshade':
                yield m,None,opts 
            else:
                for country,_m in m.items():
                    
                    yield _m,country,opts
            k += 1
            

    def _render(self,c0,c1,l0,l1):	
        ima = None
        k = 1
        for m,country,opts in self._allLayers():
            
            print m,country,opts
            print "Rendering %s: Layer (%d/%d)..." % (country,k,len(self.m)),
            try:
                if m == 'hillshade':
                    im = self._renderHillshade(c0,c1,l0,l1)
                else:
                    im = self._renderMapnik(m,c0,c1)

                print "compositing...",
                ima = self._composite(im,ima,opts)		
                print "done."
            except Exception as E:
                print E            
            k+=1

        return ima

    def _cropAndSave(self,im, tile_uris):
        im.convert('RGB')
        for i in range(int(self.tile_countX)):
            for j in range(int(self.tile_countY)):
                im2 = im.crop((int(self.tile_size*i), int(self.tile_size*j),int(self.tile_size*(i+1)), int(self.tile_size*(j+1))))
                im2.save(tile_uris[i*self.tile_countY +j],'JPEG',quality=85)


    def _renderGridinfo(self,x,y,z,l0,l1,tile_uris):
        for i in range(int(self.tile_countX)):
            for j in range(int(self.tile_countY)):									
                pt0 = (x + self.tile_size*i, y + self.tile_size*(j+1))
                pt1 = (x + self.tile_size*(i+1), y + self.tile_size*j)

                # Convert to LatLong (EPSG:4326)
                lt0 = self.tileproj.fromPixelToLL(pt0, z);
                lt1 = self.tileproj.fromPixelToLL(pt1, z);

                # Convert to map projection (e.g. mercator co-ords EPSG:900913)
                ct0 = self.prj.forward(mapnik.Coord(lt0[0],lt0[1]))
                ct1 = self.prj.forward(mapnik.Coord(lt1[0],lt1[1]))
                
                if self.gridMap:
                    mi = 0
                    for country,_gridMap in self.gridMap.items():                        
                        if  self.countries[country].intersects(mapnik.Box2d(l0[0],l0[1],l1[0],l1[1])):
                            try:
                                _gridMap.zoom_to_box(mapnik.Box2d(ct0.x,ct0.y, ct1.x,ct1.y))
                                _gridMap.resize(int(self.tile_size), int(self.tile_size))
                                _gridMap.buffer_size = 0
                                grid = mapnik.Grid(int(self.tile_size), int(self.tile_size))
                                mapnik.render_layer(_gridMap, grid, layer = 1, fields=['symbol_name','wiki'])
                                mapnik.render_layer(_gridMap, grid, layer = 0, fields=['highway','grade','surface','smoothness','ref','int_ref','tracktype','name'])                
                                utfgrid = grid.encode('utf',resolution=4)                
                                for key1 in utfgrid['data']:
                                    for key2,val2 in utfgrid['data'][key1].items():
                                        if val2 in (None,'no',''):
                                            del utfgrid['data'][key1][key2]
                                gridname = tile_uris[i*self.tile_countY +j].replace(".jpg",".js")
                                f = codecs.open(gridname + '.tmp','w','utf-8')                
                                f.write(json.dumps(utfgrid, ensure_ascii = False))
                                f.close()
                                
                                if mi > 0:
                                    os.system('gzip -f %s' % (gridname + '.tmp'))
                                    if os.path.getsize(gridname + '.tmp.gz') > os.path.getsize(gridname+'.gz'):
                                        os.remove(gridname + '.gz')
                                        os.rename(gridname + '.tmp.gz',gridname+'.gz')
                                    else:
                                        os.remove(gridname + '.tmp.gz')
                                else:
                                    os.rename(gridname + '.tmp.gz',gridname+'.gz')
                            except Exception as E:
                                print E
                                
                                
                        mi += 1
                        
                        
    def render_tile(self, tile_uris, x, y, z):

        # Calculate pixel positions of bottom-left & top-right
        p0 = (x , (y + self.tile_size*self.tile_countY))
        p1 = ((x + self.tile_size*self.tile_countX), y)
        
        # Convert to LatLong (EPSG:4326)
        l0 = self.tileproj.fromPixelToLL(p0, z);
        l1 = self.tileproj.fromPixelToLL(p1, z);

        # Convert to map projection (e.g. mercator co-ords EPSG:900913)
        c0 = self.prj.forward(mapnik.Coord(l0[0],l0[1]))
        c1 = self.prj.forward(mapnik.Coord(l1[0],l1[1]))
        
        im = self._render(c0,c1,l0,l1);
        self._cropAndSave(im,tile_uris)
        
        self._renderGridinfo(x,y,z,l0,l1,tile_uris)

    def loop(self):
        while True:
            #Fetch a tile from the queue and render it
            r = self.q.get()
            if (r == None):
                self.q.task_done()
                break
            else:
                (name, tile_uris, x, y, z) = r

            exists= ""
            overwrite = ""
            skip = False
            for tile_uri in tile_uris:                
                if os.path.isfile(tile_uri):
                    if self.overwrite:
                        overwrite = "overwrite"
                        os.remove(tile_uri)                        
                    else:
                        skip = True                        
                        exists= "exists"
            
            if not skip:
                self.render_tile(tile_uris, x, y, z)                        
               
            for tile_uri in tile_uris:
                bytes=os.stat(tile_uri)[6]
                empty= ''
                if bytes == 103:
                    empty = " Empty Tile "
                self.printLock.acquire()
                print name, ":", tile_uri, exists, empty, overwrite                
                self.printLock.release()                            
            self.q.task_done()




def render_tiles(bbox, mapfiles, tile_dir, minZoom=1,maxZoom=18, name="unknown", num_threads=NUM_THREADS, tms_scheme=False, overwrite = False, tile_size = 256.0, tile_count = 1, buffer_size = 128, layer_options = {}, countries = [], zooms = 8):
    
    gprj = GoogleProjection(maxZoom+1) 

    ll0 = (bbox[0],bbox[3])
    ll1 = (bbox[2],bbox[1])
    
    px0 = gprj.fromLLtoPixel(ll0,maxZoom)
    px1 = gprj.fromLLtoPixel(ll1,maxZoom)
    
    tmp = int(px1[0]/tile_size) - int(px0[0]/tile_size) + 1;
    if tmp < tile_count:
        tile_countX = int(tmp)
    else:        
        tile_countX = int(ceil(float(tmp) / ceil(float(tmp) / float(tile_count)))) 
        
        
    tmp = int(px1[1]/tile_size) - int(px0[1]/tile_size) + 1;   
    if tmp < tile_count:
        tile_countY = int(tmp)
    else:        
        tile_countY = int(ceil(float(tmp) / ceil(float(tmp) / float(tile_count))))        
    
    print "render_tiles(",bbox, mapfiles, tile_dir, minZoom,maxZoom, name,overwrite,tile_countX,tile_countY,buffer_size, ")"

    # Launch rendering threads
    queue = Queue(32)
    printLock = threading.Lock()
    renderers = {}
    for i in range(num_threads):
        renderer = RenderThread(tile_dir, mapfiles, queue, printLock, maxZoom, overwrite, tile_size, tile_countX,tile_countY, buffer_size, layer_options, countries = countries, zooms = zooms)
        render_thread = threading.Thread(target=renderer.loop)
        render_thread.start()
        #print "Started render thread %s" % render_thread.getName()
        renderers[i] = render_thread

    if not os.path.isdir(tile_dir):
         os.mkdir(tile_dir)
    
    for z in range(minZoom,maxZoom + 1):
        px0 = gprj.fromLLtoPixel(ll0,z)
        px1 = gprj.fromLLtoPixel(ll1,z)
        fromX = int(px0[0]) - int(px0[0]) % int(tile_size)
        toX = int(px1[0]) 
        
        fromY = int(px0[1]) - int(px0[1]) % int(tile_size)
        toY = int(px1[1]) 

        # check if we have directories in place
        zoom = "%s" % z
        if not os.path.isdir(tile_dir + zoom):
            os.mkdir(tile_dir + zoom)
        for x in range(fromX,toX,int(tile_countX*tile_size)):
            # check if we have directories in place
            for i in range(int(tile_countX)):
                str_x = "%d" % int(x/tile_size + i)
                if not os.path.isdir(tile_dir + zoom + '/' + str_x):
                    os.mkdir(tile_dir + zoom + '/' + str_x)
            for y in range(fromY,toY,int(tile_countY*tile_size)):
                
                tile_uris = []
                for i in range(int(tile_countX)):
                    str_x = "%d" % int(x/tile_size + i)
                    for j in range(int(tile_countY)):
                        # flip y to match OSGEO TMS spec
                        if tms_scheme:
                            str_y = "%d" % ((2**z-1) - int(y/tile_size + j))
                        else:
                            str_y = "%d" % int(y/tile_size + j)
                        tile_uris.append(tile_dir + zoom + '/' + str_x + '/' + str_y + '.jpg')
                # Submit tile to be rendered into the queue
                
                t = (name, tile_uris, x, y, z)
                try:
                    queue.put(t)
                except KeyboardInterrupt:
                    raise SystemExit("Ctrl-c detected, exiting...")

    # Signal render threads to exit by sending empty request to queue
    for i in range(num_threads):
        queue.put(None)
    # wait for pending rendering jobs to complete
    queue.join()
    for i in range(num_threads):
        renderers[i].join()

REGIONS = {
    'World'              : [(-180.0,-90.0, 180.0,90.0)], 
    
    "Europe"             : [(-10,35,40,75)],
    
    "Central europe"     : [(9.5,42.5,24.1,54.9)],
    
    
    
    'Slovak republic'    : [(16.6,47.7,22.6,49.7)],    
    
    'Poland'             : [(14.1,49.1,24.1,54.9)],
    
    'Austria'            : [(9.5,46.3,17.2,49.0)],
       
    'Slovenia'           : [(13.38,45.4,16.5,46.9)],
           
    'Hungary'            : [(16.0,45.7,23.0,48.6)],
    
    'Crotia'             : [(13.5,42.5,19.5,46.6)],            
    'Sibenik'            : [(15.56,43.26,16.58,43.84)],
    
    'Czech republic'     : [(12,48.5,19,51.1)],
    'Stredni cechy'      : [(13.6,49.6,15.5,50.5)],
    'Okoli Krkonos'      : [(14.83,50.45,15.92,50.89)],    
    'Zapadni Krkonose'   : [(15.3467,50.6781,15.6291,50.8022)],
    'Okoli Prahy'        : [(14,49.8,15,50.3)],
    'Praha'              : [(14.259,49.946,14.660,50.156)],
    'Centrum Prahy'      : [(14.3816,50.0607,14.4887,50.1052)],
    'Trebonsko'          : [(14.607,48.920,14.983,49.212)],
    'Okoli Jiloveho'     : [(14.3879,49.8398,14.69916,49.9589)],
    'Brdy'               : [(13.5943933,49.5775753,14.3440011,49.9070919)],
    'Okoli chalupy'      : [(15.3141911,50.6534653,15.4243831,50.6925925)],
}


RENDER_PROPERTIES = {
     4: (16, 500),
     5: (16, 500),
     6: (16, 500),
     7: (16, 500),
     8: (16, 500),
     9: (16, 500),
    10: (16, 600),
    11: (16, 700),
    12: (16, 800),
    13: (16, 800),
    14: (16, 800),
    15: (16, 800),
    16: (16, 1000),
    17: (16, 1200),
    18: (16, 1500),
}

COUNTRIES = {
    'cz' : mapnik.Box2d(12,48.5,19,51.1),
    'sk' : mapnik.Box2d(16.6,47.7,22.6,49.7),
    'pl' : mapnik.Box2d(14.1,49.1,24.1,54.9),
    'at' : mapnik.Box2d(9.5,46.3,17.2,49.0),
    'sl' : mapnik.Box2d(13.38,45.4,16.5,46.9),
    'hu' : mapnik.Box2d(16.0,45.7,23.0,48.6),
    'hr' : mapnik.Box2d(13.5,42.5,19.5,46.6)
}


if __name__ == "__main__":
    home = os.environ['HOME']
    try:
        mapfiles = os.environ['MAPNIK_MAP_FILES'].strip(';').split(';')
    except KeyError:
        mapfiles = [home + "/svn.openstreetmap.org/applications/rendering/mapnik/osm-local.xml"]        
        
    try:        
        layer_options = json.loads(os.environ['LAYER_OPTIONS'])
    except KeyError:
        layer_options = {}
        
    try:
        tile_dir = os.environ['MAPNIK_TILE_DIR']
    except KeyError:
        tile_dir = home + "/osm/tiles/"

    if not tile_dir.endswith('/'):
        tile_dir = tile_dir + '/'
        
    try:
        zooms = map(int,os.environ['ZOOMS'].split(','))        
    except KeyError:
        zooms = range(8,13)    
    try:
        regions = os.environ['REGIONS'].split(',')
    except KeyError:
        regions = ['Czech republic']            
                
    try:
        overwrite = os.environ['MODE'].lower() == 'overwrite'        
    except KeyError:
        overwrite = False

    for region in regions:
        for zoom in zooms:
            for subregion in REGIONS[region]:
                render_tiles(subregion, mapfiles, tile_dir, zoom, zoom, region, overwrite = overwrite, tile_count = RENDER_PROPERTIES[zoom][0], buffer_size = RENDER_PROPERTIES[zoom][1], layer_options = layer_options, countries = {'World':mapnik.Box2d(-180.0,-90.0, 180.0,90.0)} if int(zoom) < 13  else COUNTRIES, zooms = zoom)
