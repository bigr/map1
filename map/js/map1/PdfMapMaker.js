var map1 = map1 || {}

map1.PdfMapMaker = function(map,orientation,format,downloadifyId) {	
	var self = this
	self.map = map
	self.pdfMaker = new map1.PdfMaker(orientation,format,downloadifyId)
	
	
	self.drawRoute = function(page,ctx,i) {
		
		if ( undefined !== self.map && undefined !== self.map.routing ) {
			
			var width = (page.area.zoom > 8 ? 2.5 * (page.area.zoom - 8) + 8 : 8)
			
			ctx.strokeStyle="rgba(0,0,0,0.4)"
			try {
				ctx.setLineDash(param)
			} catch(e) {}
			ctx.lineWidth=width
			
			var proj = new page.helper.GoogleProjection()
			
			for ( var i in self.map.routing.vector.features ) {
				var f = self.map.routing.vector.features[i]
				if ( f.geometry.CLASS_NAME!="OpenLayers.Geometry.Point" ) {				
					var vertices = f.geometry.getVertices()
					var first = true
					ctx.beginPath();
					for ( var j in vertices ) {
						var v = vertices[j].clone().transform(
							new OpenLayers.Projection("EPSG:900913"),
							new OpenLayers.Projection("EPSG:4326")						
						);
						
						var px = proj.fromLLtoPixel([v.x,v.y],page.area.zoom)
						px[0] -= page.area.px1[0]
						px[1] -= page.area.px1[1]
						if ( first ) {					
							ctx.moveTo(px[0],px[1]);
							first = false
						}
						else {
							ctx.lineTo(px[0],px[1])
						}
						
					}
					ctx.stroke();
				}
			}
			
			
			for ( var i in self.map.routing.wayPoints ) {
				var v = self.map.routing.wayPoints[i].geometry.clone().transform(
						new OpenLayers.Projection("EPSG:900913"),
						new OpenLayers.Projection("EPSG:4326")
					);
				var px = proj.fromLLtoPixel([v.x,v.y],page.area.zoom)
				px[0] -= page.area.px1[0]
				px[1] -= page.area.px1[1]
				
				ctx.beginPath()
				ctx.arc(px[0], px[1], width*1.5, 0 , 2 * Math.PI, false);
				ctx.strokeStyle="rgba(0,0,0,0.0)"
				ctx.lineWidth=0
				ctx.fillStyle="#aa7700"
				ctx.fill()
				ctx.stroke()
				ctx.fillStyle = "#ffffff"
				ctx.font = 'bold ' + width*2 + 'px sans-serif';
				ctx.textAlign = 'center'
				ctx.textBaseline = 'middle'
				ctx.fillText(''+(parseInt(i)+1),px[0],px[1])
			}
		}						
		
	}
	
	self.drawMap = function(ll1,ll2,scale,firstPage,x1,y1,x2,y2,overlapx,overlapy,minDPI,quality) {
		
		var tmp = new self.pdfMaker.XY12(x1,y1,x2,y2)
		x1 = tmp.x1
		y1 = tmp.y1
		x2 = tmp.x2
		y2 = tmp.y2
		
		if ( undefined === overlapx ) overlapx = (x2-x1)/15
		if ( undefined === overlapy ) overlapy = (y2-y1)/15
		if ( undefined === minDPI ) minDPI = 125
		if ( undefined === quality ) quality = 0.3		
		
		var DPI = 200
		
		for ( var zoom = 5; zoom < 18; zoom++ ) {
			var S=40075017*Math.cos(((ll1[1]+ll2[1])/2)*Math.PI/180)/Math.pow(2,zoom+8)
			DPI = scale * 0.0254 / S
			if ( DPI > minDPI ) break;
		}				
		
		var tileHelper = new map1.PdfTileHelper();
		var area = new tileHelper.Area(ll1,ll2,zoom)
		
		
		var pages = tileHelper.fitAreaToPages(
			area,
			(x2-x1)*DPI/25.4,
			(y2-y1)*DPI/25.4,
			overlapx*DPI/25.4,
			overlapy*DPI/25.4
		);	
		area = pages.area			
						
		for ( var i in pages.pages ) {
						
			var page = pages.pages[i]
						
			
			var images = []
			for ( url in page.tiles ) {				
				var tile = page.tiles[url]				
				//if ( tile.sy + tile.sheight != 256) alert(tile.sy + tile.sheight)			
				images.push({
					url: '/tiles/'+url+'.jpg',
					x1: tile.x*25.4/DPI,
					y1: tile.y*25.4/DPI,
					x2: (tile.x + tile.width)*25.4/DPI,
					y2: (tile.y + tile.height)*25.4/DPI,
					sx1: tile.sx, 
					sy1: tile.sy,
					sx2: tile.sx + tile.swidth, 
					sy2: tile.sy + tile.sheight
				})
			}						
			
			self.pdfMaker.draw(
				parseInt(i)+parseInt(firstPage),'Image',x1,y1,
				images,
				DPI,quality,'#ffffff',
				[
					(function(page) {return function(ctx) {self.drawRoute(page,ctx)}})(page) //This is why I think javascript is a fucking language
				]
			)
			
			self.pdfMaker.draw(
				parseInt(i)+parseInt(firstPage),
				'Rect',
				x1 + overlapx,
				y1 + overlapy,
				x2 - overlapx,
				y2 - overlapy,
				'#77aa00',
				0.5,
				0.3,
				'S'
			);	
			
			if ( pages.pages.length > 1 ) {
			
				self.pdfMaker.draw(
					parseInt(i)+parseInt(firstPage),
					'Rect',
					(parseInt(i)+parseInt(firstPage)+1) % 2 ? x2 - 17.5 : x1,
					y2 - 17.5,
					(parseInt(i)+parseInt(firstPage)+1) % 2 ? x2 : x1 + 17.5,
					y2,
					'#77aa00',
					0.5,
					0.3,
					'F'
				)	
				
				self.pdfMaker.draw(
					parseInt(i)+parseInt(firstPage),
					'Text',
					(parseInt(i)+parseInt(firstPage)+1) % 2 ? x2 - 16 : x1 + 8,
					y2 - 10,
					18,
					'#ffffff',
					parseInt(i)+parseInt(firstPage)+1								
				)
				
				
				if ( page.left !== null ) {
					self.pdfMaker.draw(
						parseInt(i)+parseInt(firstPage),
						'Triangle',
						x1 + overlapx,
						(y2 + y1)/2 - 8,
						x1 + overlapx,
						(y2 + y1)/2 + 8,
						x1 + overlapx - 12,
						(y2 + y1)/2,
						'#77aa00',
						0.5,
						0.3,
						'F'
					)
									
					self.pdfMaker.draw(
						parseInt(i)+parseInt(firstPage),
						'Text',
						x1 + overlapx - 8,
						(y2 + y1)/2 + 2,
						16,
						'#ffffff',
						page.left +	parseInt(firstPage)+1							
					)
				}
				
				if ( page.right !== null ) {
					self.pdfMaker.draw(
						parseInt(i)+parseInt(firstPage),
						'Triangle',
						x2 - overlapx,
						(y2 + y1)/2 - 8,
						x2 - overlapx,
						(y2 + y1)/2 + 8,
						x2 - overlapx + 12,
						(y2 + y1)/2,
						'#77aa00',
						0.5,
						0.3,
						'F'
					)
									
					self.pdfMaker.draw(
						parseInt(i)+parseInt(firstPage),
						'Text',
						x2 - overlapx + 1.5,
						(y2 + y1)/2 + 2,
						16,
						'#ffffff',
						page.right +	parseInt(firstPage)+1							
					)
				}
				
				if ( page.up !== null ) {
					self.pdfMaker.draw(
						parseInt(i)+parseInt(firstPage),
						'Triangle',
						(x2 + x1)/2 - 8,
						y1 + overlapy,						
						(x2 + x1)/2 + 8,
						y1 + overlapy,						
						(x2 + x1)/2,
						y1 + overlapy - 12,						
						'#77aa00',
						0.5,
						0.3,
						'F'
					)
									
					self.pdfMaker.draw(
						parseInt(i)+parseInt(firstPage),
						'Text',						
						(x2 + x1)/2 - (page.up +	parseInt(firstPage)+1 < 10 ? 1.5 : 3.3),
						y1 + overlapy - 3,
						16,
						'#ffffff',
						page.up +	parseInt(firstPage)+1							
					)
				}
				
				if ( page.down !== null ) {
					self.pdfMaker.draw(
						parseInt(i)+parseInt(firstPage),
						'Triangle',
						(x2 + x1)/2 - 8,
						y2 - overlapy,												
						(x2 + x1)/2 + 8,
						y2 - overlapy,						
						(x2 + x1)/2,
						y2 - overlapy + 12,
						'#77aa00',
						0.5,
						0.3,
						'F'
					)
									
					self.pdfMaker.draw(
						parseInt(i)+parseInt(firstPage),
						'Text',
						(x2 + x1)/2 - (page.down +	parseInt(firstPage)+1 < 10 ? 1.5 : 3.3),
						y2 - overlapy + 6,						
						16,
						'#ffffff',
						page.down +	parseInt(firstPage)+1							
					)
				}
					
			}
		}
		
		
		return pages
					
	}
	
	
	self.getPageCount = function(ll1,ll2,scale,x1,y1,x2,y2,overlapx,overlapy,minDPI) {
		
		var tmp = new self.pdfMaker.XY12(x1,y1,x2,y2)
		x1 = tmp.x1
		y1 = tmp.y1
		x2 = tmp.x2
		y2 = tmp.y2
		
		if ( undefined === overlapx ) overlapx = (x2-x1)/15
		if ( undefined === overlapy ) overlapy = (y2-y1)/15
		if ( undefined === minDPI ) minDPI = 125		
		
		var DPI = 200
		
		for ( var zoom = 5; zoom < 18; zoom++ ) {
			var S=40075017*Math.cos(((ll1[1]+ll2[1])/2)*Math.PI/180)/Math.pow(2,zoom+8)
			DPI = scale * 0.0254 / S
			if ( DPI > minDPI ) break;
		}				
		
		var tileHelper = new map1.PdfTileHelper();
		var area = new tileHelper.Area(ll1,ll2,zoom)
		
		
		return tileHelper.getPageCount(
			area,
			(x2-x1)*DPI/25.4,
			(y2-y1)*DPI/25.4,
			overlapx*DPI/25.4,
			overlapy*DPI/25.4
		);
	}
	
	self.drawGrid = function(ll1,ll2,scale,firstPage,x1,y1,x2,y2,overlapx,overlapy,ll1_g,ll2_g,scale_g,firstPage_g,x1_g,y1_g,x2_g,y2_g,overlapx_g,overlapy_g,minDPI) {
		
		var tmp = new self.pdfMaker.XY12(x1,y1,x2,y2)
		x1 = tmp.x1
		y1 = tmp.y1
		x2 = tmp.x2
		y2 = tmp.y2
		
		var tmp = new self.pdfMaker.XY12(x1_g,y1_g,x2_g,y2_g)
		x1_g = tmp.x1
		y1_g = tmp.y1
		x2_g = tmp.x2
		y2_g = tmp.y2
		
		if ( undefined === overlapx ) overlapx = (x2-x1)/15
		if ( undefined === overlapy ) overlapy = (y2-y1)/15
		if ( undefined === overlapx_g ) overlapx_g = (x2-x1)/15
		if ( undefined === overlapy_g ) overlapy_g = (y2-y1)/15
		if ( undefined === minDPI ) minDPI = 125		
		
		var DPI = 200
		
		for ( var zoom = 5; zoom < 18; zoom++ ) {
			var S=40075017*Math.cos(((ll1[1]+ll2[1])/2)*Math.PI/180)/Math.pow(2,zoom+8)
			DPI = scale * 0.0254 / S
			if ( DPI > minDPI ) break;
		}	
		
		var DPI_g = 200
		
		for ( var zoom_g = 5; zoom_g < 18; zoom_g++ ) {
			var S=40075017*Math.cos(((ll1[1]+ll2[1])/2)*Math.PI/180)/Math.pow(2,zoom_g+8)
			DPI_g = scale_g * 0.0254 / S
			if ( DPI_g > minDPI ) break;
		}			
		
		var tileHelper = new map1.PdfTileHelper();
		var area = new tileHelper.Area(ll1,ll2,zoom)
		
		
		var pages = tileHelper.fitAreaToPages(
			area,
			(x2-x1)*DPI/25.4,
			(y2-y1)*DPI/25.4,
			overlapx*DPI/25.4,
			overlapy*DPI/25.4
		);	
		area = pages.area
		
		var tileHelper_g = new map1.PdfTileHelper();
		var area_g = new tileHelper_g.Area(ll1_g,ll2_g,zoom_g)
		
		
		var pages_g = tileHelper_g.fitAreaToPages(
			area_g,
			(x2_g-x1_g)*DPI_g/25.4,
			(y2_g-y1_g)*DPI_g/25.4,
			overlapx_g*DPI_g/25.4,
			overlapy_g*DPI_g/25.4
		);	
		area_g = pages_g.area						
		
		for ( var i in pages.pages ) {
					
			var page = pages.pages[i]
			
			for ( var j in pages_g.pages ) {
				
				var page_g = pages_g.pages[j]
								
				var area_p = new tileHelper.Area(page_g.area.ll1,page_g.area.ll2,zoom)	
																
				self.pdfMaker.draw(
					parseInt(i)+parseInt(firstPage),
					'Rect',
					x1 + (area_p.px1[0] - page.area.px1[0])*25.4/DPI_g,
					y1 + (area_p.px1[1] - page.area.px1[1])*25.4/DPI_g,
					x1 + (area_p.px1[0] - page.area.px1[0] + area_p.width)*25.4/DPI_g,
					y1 + (area_p.px1[1] - page.area.px1[1] + area_p.height)*25.4/DPI_g,
					'#77aa00',
					0.5,
					0.3,
					'S'
				);
				
			}
			
			
			for ( var j in pages_g.pages ) {
				var page_g = pages_g.pages[j]												
				var area_p = new tileHelper.Area(page_g.area.ll1,page_g.area.ll2,zoom)	

				self.pdfMaker.draw(
					parseInt(i)+parseInt(firstPage),
					'Rect',
					x1 + (area_p.px1[0] - page.area.px1[0] + area_p.width)*25.4/DPI_g - 6,
					y1 + (area_p.px1[1] - page.area.px1[1] + area_p.height)*25.4/DPI_g - 4,
					x1 + (area_p.px1[0] - page.area.px1[0] + area_p.width)*25.4/DPI_g,
					y1 + (area_p.px1[1] - page.area.px1[1] + area_p.height)*25.4/DPI_g,
					'#77aa00',
					0.5,
					undefined,
					'F'
				)

				self.pdfMaker.draw(
					parseInt(i)+parseInt(firstPage),
					'Text',
					x1 + (area_p.px1[0] - page.area.px1[0] + area_p.width)*25.4/DPI_g - 5.5,
					y1 + (area_p.px1[1] - page.area.px1[1] + area_p.height)*25.4/DPI_g - 0.6,
					12,
					'#ffffff',
					parseInt(j)+parseInt(firstPage_g)+1
										
				)		
			}
		}
	}
	
	self.render = function(scale,ll0,ll1,overlapX,overlapY,minDPI) {
		
		var overviewScale = 6400000*2
		
		do {
			overviewScale /= 2
			var pageCount = self.getPageCount(ll0,ll1,overviewScale,10,50,-10,-10,0,0)			
		} while ( pageCount == 1 || overviewScale <= scale )
		overviewScale *= 2					
		
		var pages = self.drawMap(ll0,ll1,overviewScale,0,10,50,-10,-10,0,0)
		
		self.drawGrid(ll0,ll1,overviewScale,0,10,50,-10,-10,0,0,ll0,ll1,scale,pages.pages.length,0,0,0,0,20,20)			
		self.drawMap(ll0,ll1,scale,pages.pages.length,0,0,0,0,20,20)
		
		self.pdfMaker.draw(
			0,
			'Image',
			10,
			10,
			[{
				url: 'image/map1eu_logo_baner.png',
				x1: 0,
				y1: 0,
				x2: 114,
				y2: 33
			}]
		)
		
		self.pdfMaker.draw(
			0,
			'Text',
			85,
			30,
			20,
			'#999999',
			'1:'+scale
		)
		/*
		self.pdfMaker.draw(
			0,
			'Text',
			85,
			15,
			18,
			'#999999',
			'Okolí Prahy'
		)
		* */
		
		//self.pdfMaker.draw(0,'Grid',20,20,-20,-20,'#77aa00',1.0,1.0,80,50,undefined,undefined,2)		
		self.pdfMaker.render()
	}
}



