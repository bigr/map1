# coding: utf-8

from math import pi,cos,sin,log,exp,atan
import mapnik, json, codecs

DEG_TO_RAD = pi/180
RAD_TO_DEG = 180/pi

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

sizeX = 256
sizeY = 256
ll = (15,50)
z = 11

m = mapnik.Map(sizeX, sizeY)
mapnik.load_map(m,'simple.xml')
proj = mapnik.Projection(m.srs)
tileproj = GoogleProjection(16)
p = tileproj.fromLLtoPixel(ll,z)
p0 = (p[0]-sizeX/2,p[1]+sizeY/2)
p1 = (p[0]+sizeX/2,p[1]-sizeY/2)
l0 = tileproj.fromPixelToLL(p0, z);
l1 = tileproj.fromPixelToLL(p1, z);
c0 = proj.forward(mapnik.Coord(l0[0],l0[1]))
c1 = proj.forward(mapnik.Coord(l1[0],l1[1]))
print c0.x,c0.y,c1.x,c1.y
m.zoom_to_box(mapnik.Box2d(c0.x,c0.y, c1.x,c1.y))
m.resize(sizeX, sizeY)
m.buffer_size = 0
im = mapnik.Image(sizeX, sizeY)
mapnik.render_layer(m, im, layer = 0)
im.save('/tmp/test-map.png', 'png')

grid = mapnik.Grid(sizeX, sizeY)
mapnik.render_layer(m, grid, layer = 0, fields=['h','s','sm','r','ri'])
utfgrid = grid.encode('utf',resolution=4)
f = codecs.open('/tmp/test-map.json','w','utf-8')
f.write(json.dumps(utfgrid, ensure_ascii = False))
f.close()



