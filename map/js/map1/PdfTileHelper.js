var map1 = map1 || {}

map1.PdfTileHelper = function() {
	self = this
	this.pxToTx= function(px) {
		return [Math.floor(px[0]/256),Math.floor(px[1]/256)]
	}		
	
	this.tileFromLL = function(ll,zoom) {
		var proj = new this.GoogleProjection()
		return proj.fromLLtoPixel(ll,zoom).map(this.pxToTx)		
	}			
	
	this.getAreaTiles = function(area) {		
		var ret = []		
		for ( var j=area.tx1[1]; j <= area.tx2[1]; ++j ) {
			for ( var i=area.tx1[0]; i <= area.tx2[0]; ++i ) {
				ret.push(area.zoom+'/'+i+'/'+j)			
			}
		}
		return ret
	}
	
	this.getPageCount = function(_area,width,height,overlapx,overlapy) {
		var sizeX = Math.ceil((_area.width+2*overlapx)/width)
		var sizeY = Math.ceil((_area.height+2*overlapy)/height)
		return sizeX*sizeY;
	}
	
	this.fitAreaToPages = function(_area,width,height,overlapx,overlapy) {
		var proj = new this.GoogleProjection();
		
		var sizeX = Math.ceil((_area.width+2*overlapx)/width)
		var sizeY = Math.ceil((_area.height+2*overlapy)/height)
		var ret = {}
		
		ret.helper = self
		
		ret.pageCount = sizeX*sizeY
		
		ret.ll1 = proj.fromPixelToLL([
			_area.px1[0] + (_area.width + 2*overlapx - sizeX*width)/2,
			_area.px2[1] - (_area.height + 2*overlapy - sizeY*height)/2
		],_area.zoom)
		
		ret.ll2 = proj.fromPixelToLL([
			_area.px2[0] - (_area.width + 2*overlapx - sizeX*width)/2,
			_area.px1[1] + (_area.height + 2*overlapy - sizeY*height)/2
		],_area.zoom)
			
		var area = new self.Area(ret.ll1,ret.ll2,_area.zoom)		
		ret.area = area
		
		ret.sizeX = sizeX
		ret.sizeY = sizeY		
		ret.pages = []		
		
		for ( var j = 0; j < sizeY; ++j ) {
			for ( var i = 0; i < sizeX; ++i ) {
				n = i+j*sizeX		
				ret.pages[n] = {}
				ret.pages[n].helper = self
				ret.pages[n].x = i
				ret.pages[n].y = j
				ret.pages[n].left = i > 0 ? n - 1 : null
				ret.pages[n].right = i < sizeX - 1 ? n + 1 : null
				ret.pages[n].up = j > 0 ? n - sizeX : null
				ret.pages[n].down = j < sizeY - 1 ? n + sizeX : null
				
				ret.pages[n].px1 = [
					area.px1[0] + i * (width - overlapx),
					area.px1[1] + j * (height - overlapy)
				]
				
				ret.pages[n].px2 = [
					ret.pages[n].px1[0] + width,
					ret.pages[n].px1[1] + height
				]
				
				ret.pages[n].area = new this.Area(
					proj.fromPixelToLL(
						[ret.pages[n].px1[0],ret.pages[n].px2[1]],						
						area.zoom
					),
					proj.fromPixelToLL(
						[ret.pages[n].px2[0],ret.pages[n].px1[1]],
						area.zoom
					),
					area.zoom
				)								
				
				ret.pages[n].tiles = {}
				
				for ( var ty=ret.pages[n].area.tx1[1]; ty <= ret.pages[n].area.tx2[1]; ++ty ) {					
					for ( var tx=ret.pages[n].area.tx1[0]; tx <= ret.pages[n].area.tx2[0]; ++tx ) {
						var tile = area.zoom+'/'+tx+'/'+ty
						ret.pages[n].tiles[tile] = {}
						ret.pages[n].tiles[tile].y = ty*256 - ret.pages[n].px1[1]
						ret.pages[n].tiles[tile].x = tx*256 - ret.pages[n].px1[0]
						ret.pages[n].tiles[tile].sy = 0
						ret.pages[n].tiles[tile].sx = 0
						ret.pages[n].tiles[tile].sheight = 256
						ret.pages[n].tiles[tile].swidth = 256
						
						if ( ret.pages[n].tiles[tile].y < 0 ) {
							ret.pages[n].tiles[tile].sy = -ret.pages[n].tiles[tile].y
							ret.pages[n].tiles[tile].sheight = 256 - ret.pages[n].tiles[tile].sy
							ret.pages[n].tiles[tile].y = 0
						}
						if ( height < ret.pages[n].tiles[tile].y + 256 ) {							
							ret.pages[n].tiles[tile].sheight += height - ret.pages[n].tiles[tile].y - 256
						}
						if ( ret.pages[n].tiles[tile].x < 0 ) {
							ret.pages[n].tiles[tile].sx = -ret.pages[n].tiles[tile].x							
							ret.pages[n].tiles[tile].swidth = 256 - ret.pages[n].tiles[tile].sx
							ret.pages[n].tiles[tile].x = 0							
						}
						if ( width < ret.pages[n].tiles[tile].x + 256 ) {							
							ret.pages[n].tiles[tile].swidth += width - ret.pages[n].tiles[tile].x - 256
						}
						ret.pages[n].tiles[tile].height = ret.pages[n].tiles[tile].sheight
						ret.pages[n].tiles[tile].width = ret.pages[n].tiles[tile].swidth
					}
				}
				
			}
		}
		return ret
	}
	
	this.Area = function(ll1,ll2,zoom) {
		var proj = new self.GoogleProjection()
		this.ll1 = ll1
		this.ll2 = ll2
		this.zoom = zoom		
		this.px1 = proj.fromLLtoPixel(ll1,zoom)
		this.px2 = proj.fromLLtoPixel(ll2,zoom)
		var tmp = this.px2[1]
		this.px2[1] = this.px1[1] 
		this.px1[1] = tmp
		this.tx1 = self.pxToTx(this.px1)
		this.tx2 = self.pxToTx(this.px2)
		this.width = this.px2[0]-this.px1[0] 
		this.height = this.px2[1]-this.px1[1] 
	}
	
	this.GoogleProjection = function(levels) {
		if ( undefined === levels ) levels = 18
			
		this.DEG_TO_RAD = Math.PI/180.0
		this.RAD_TO_DEG = 180.0/Math.PI
		
		
		this.Bc = []
		this.Cc = []
		this.zc = []
		this.Ac = []
		c = 256
		for ( var d = 0; d < levels; ++d ) {
			e = c/2;
			this.Bc.push(c/360.0)
			this.Cc.push(c/(2 * Math.PI))
			this.zc.push([e,e])
			this.Ac.push(c)
			c *= 2
		}
		
		
		
		this.minmax = function (a,b,c) {
			a = Math.max(a,b)
			a = Math.min(a,c)
			return a
		}
				
		this.fromLLtoPixel = function(ll,zoom) {
			 var d = this.zc[zoom]		 
			 var e = Math.round(d[0] + ll[0] * this.Bc[zoom])		 
			 var f = this.minmax(Math.sin(this.DEG_TO_RAD * ll[1]),-0.9999,0.9999)		 
			 var g = Math.round(d[1] + 0.5*Math.log((1+f)/(1-f))*(-this.Cc[zoom]))
			 return [e,g]
		}
		 
		this.fromPixelToLL = function(px,zoom) {
			 var e = this.zc[zoom]
			 var f = (px[0] - e[0])/this.Bc[zoom]
			 var g = (px[1] - e[1])/-this.Cc[zoom]
			 var h = this.RAD_TO_DEG * ( 2 * Math.atan(Math.exp(g)) - 0.5 * Math.PI)
			 return [f,h]
		}
	}	
}
