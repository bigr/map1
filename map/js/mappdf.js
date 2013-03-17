

MapPdf = function(map) {
	var self = this
			
	this.map = map
	
	this.loadImage = function(url) {
		img = new Image;
		img.src = url;
		img.onError = function() {
			throw new Error('Cannot load image: "'+url+'"');
		}
		return img;									
	}		
	
	this.makeTitleImage = function(tiles,images,p0,p1,zoom,width,height,zoom2,p02,p12) {	
		var canvas = document.createElement('canvas')
		document.body.appendChild(canvas)
		canvas.width = width
		canvas.height = height
		var ctx = canvas.getContext('2d')
		ctx.fillStyle='#ffffff'
		ctx.fillRect(0,0,width,height)
		
		var fromX = Math.floor(p0[0]/256);
		var fromY = Math.floor(p0[1]/256);
		var toX = Math.ceil(p1[0]/256);
		var toY = Math.ceil(p1[1]/256);
		
		tilesX = (width - ((toX - fromX + 1) * 255)) / 2 
		tilesY = (height - ((toY - fromY + 1) * 255)) - 70
		
		ctx.drawImage(images[0], 50, 75);	
		
		ctx.fillStyle='#ffffff'
		ctx.fillRect(0,0,50,height)	
		ctx.fillRect(width-50,0,width,height)
		
		ctx.fillStyle='RGBA(0,0,0,0.07)'
		ctx.fillRect(50,tilesY-20,width-100,height-tilesY-30)
		
		for ( var x = fromX; x <= toX; ++x ) {
			for ( var y = fromY; y <= toY; ++y ) {				
				try {
					
					ctx.drawImage(tiles[x][y], tilesX + (x - fromX) * 256, tilesY + (y - fromY) * 256 );					
				} catch(e) {					
					//alert((x - fromX) * 255 - xoffset)
				}
			}
		}	
				
		var xoffset = 256*Math.floor(p02[0]/256)/Math.pow(2,zoom2-zoom) - Math.floor(p0[0]/256)*256
		var yoffset = 256*Math.floor(p02[1]/256)/Math.pow(2,zoom2-zoom) - Math.floor(p0[1]/256)*256			
		
		ctx.fillStyle="rgba(255, 255, 255, 0.4)"
		ctx.fillRect(tilesX,tilesY,xoffset,(toY-fromY+1)*256)
		ctx.fillRect(tilesX+xoffset+self.xpages*(width-self.marginX)/Math.pow(2,zoom2-zoom),tilesY,(toX-fromX+1)*256-xoffset-self.xpages*(width-self.marginX)/Math.pow(2,zoom2-zoom),(toY-fromY+1)*256)
		ctx.fillRect(tilesX+xoffset,tilesY,self.xpages*(width-self.marginX)/Math.pow(2,zoom2-zoom),yoffset)
		ctx.fillRect(tilesX+xoffset,tilesY+yoffset+self.ypages*(height-self.marginY)/Math.pow(2,zoom2-zoom),self.xpages*(width-self.marginX)/Math.pow(2,zoom2-zoom),(toY-fromY+1)*256-yoffset-self.ypages*(height-self.marginY)/Math.pow(2,zoom2-zoom))
		
		
		//desaturate(ctx,tilesX+xoffset,tilesY+yoffset,tilesX+xoffset+self.xpages*(width-self.marginX)/Math.pow(2,zoom2-zoom),tilesY+yoffset+self.ypages*(height-self.marginY)/Math.pow(2,zoom2-zoom))				
		
		ctx.strokeStyle="RGBA(119,170,0,0.7)"
		ctx.lineWidth=2
		for ( var py = 0; py <= self.ypages; ++py ) {
			
			y = yoffset+tilesY+py*(height-self.marginY)/Math.pow(2,zoom2-zoom)			
			ctx.moveTo(tilesX+xoffset,y);
			ctx.lineTo(tilesX+xoffset+self.xpages*(width-self.marginX)/Math.pow(2,zoom2-zoom),y);
			ctx.stroke();
		}
		
		for ( var px = 0; px <= self.xpages; ++px ) {
			
			x = xoffset+tilesX+px*(width-self.marginX)/Math.pow(2,zoom2-zoom)			
			ctx.moveTo(x,tilesY+yoffset);
			ctx.lineTo(x,tilesY+yoffset+self.ypages*(height-self.marginY)/Math.pow(2,zoom2-zoom));
			ctx.stroke();
		}
		
		for ( var py = 1; py <= self.ypages; ++py ) {
			for ( var px = 1; px <= self.xpages; ++px ) {
				y = yoffset+tilesY+py*(height-self.marginY)/Math.pow(2,zoom2-zoom)
				x = xoffset+tilesX+px*(width-self.marginX)/Math.pow(2,zoom2-zoom)
				ctx.fillStyle="RGBA(119,170,0,0.7)"
				ctx.fillRect(x-40,y-40,40,40)
				ctx.fillStyle = "#FFFFFF";
				ctx.font = "bold 25px Arial";		
				ctx.fillText(px + (py-1)*self.xpages + 1, x - 35, y-12)
			}
		}
		
		
		
		
		ctx.fillStyle='#ffffff'
		ctx.fillRect(0,0,50,height)	
		ctx.fillRect(width-50,0,width,height)			
				
		
		
		data = canvas.toDataURL('image/jpeg',0.8).slice('data:image/jpeg;base64,'.length);		
		data = atob(data)
		document.body.removeChild(canvas);
		return data;
		
	}
	
	this.makeImage = function(tiles,markers,p0,p1,zoom,page) {	    
		var canvas = document.createElement('canvas');
		document.body.appendChild(canvas);
		canvas.width = p1[0] - p0[0];
		canvas.height = p1[1] - p0[1];

		var ctx = canvas.getContext('2d');
		
		var fromX = Math.floor(p0[0]/256);
		var fromY = Math.floor(p0[1]/256);
		var toX = Math.ceil(p1[0]/256);
		var toY = Math.ceil(p1[1]/256);
		
		var xoffset = p0[0] - fromX*256
		var yoffset = p0[1] - fromY*256	    	    
		
		for ( var x = fromX; x <= toX; ++x ) {
			for ( var y = fromY; y <= toY; ++y ) {
				try {
					ctx.drawImage(tiles[x][y], (x - fromX) * 255 - xoffset, (y - fromY) * 255 - yoffset);					
				} catch(e) {					
					//alert((x - fromX) * 255 - xoffset)
				}
			}
		}		
		
		
		ctx.strokeStyle="rgba(0,0,0,0.6)";
		 try {
			ctx.setLineDash(param);
		  } catch(e) {
			
		  }
		ctx.lineWidth="16"
		if ( undefined !== self.map.routing ) {
			var proj = new this.GoogleProjection()
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
						
						var px = proj.fromLLtoPixel([v.x,v.y],zoom)
						px[0] = px[0] - p0[0]
						px[1] = px[1] - p0[1]
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
				var px = proj.fromLLtoPixel([v.x,v.y],zoom)
				px[0] = px[0] - p0[0]
				px[1] = px[1] - p0[1]
				ctx.drawImage(markers[i], px[0], px[1]-32,64,64);
			}
		}
		
		if ( page % 2 ) {
			ctx.fillStyle="#77AA00"
			ctx.fillRect(canvas.width-100,canvas.height-100,100,100)
			ctx.fillStyle = "#FFFFFF";
			ctx.font = "bold 50px Arial";		
			ctx.fillText(page + 1, canvas.width-90, canvas.height-45)
		}
		else {
			ctx.fillStyle="#77AA00"
			ctx.fillRect(0,canvas.height-100,100,100)
			ctx.fillStyle = "#FFFFFF";
			ctx.font = "bold 50px Arial";		
			ctx.fillText(page + 1, 30, canvas.height-45)
		}
		
		if ( (page - 1) % self.xpages != self.xpages - 1 ) {
			ctx.fillStyle="#77AA00"
			ctx.beginPath();
			ctx.moveTo(canvas.width-80, canvas.height/2-40);
			ctx.lineTo(canvas.width-20, canvas.height/2);
			ctx.lineTo(canvas.width-80, canvas.height/2+40);
			ctx.lineTo(canvas.width-80, canvas.height/2-40);
			ctx.closePath();
			ctx.fill();			
			ctx.fillStyle = "#FFFFFF";
			ctx.font = "bold 30px Arial";
			ctx.fillText(page + 2, canvas.width-70, canvas.height/2 + 10)
		}
		
		if ( (page - 1)  % self.xpages != 0 ) {	
			ctx.fillStyle="#77AA00"
			ctx.beginPath();
			ctx.moveTo(80, canvas.height/2-40);
			ctx.lineTo(20, canvas.height/2);
			ctx.lineTo(80, canvas.height/2+40);
			ctx.lineTo(80, canvas.height/2-40);
			ctx.closePath();
			ctx.fill();	
			ctx.fillStyle = "#FFFFFF";
			ctx.font = "bold 30px Arial";
			ctx.fillText(page, 50, canvas.height/2 + 10)
		}
		
		if ( parseInt((page - 1) / self.xpages) > 0 ) {
			ctx.fillStyle="#77AA00"
			ctx.beginPath();
			ctx.moveTo(canvas.width/2-40, 80);
			ctx.lineTo(canvas.width/2, 20);
			ctx.lineTo(canvas.width/2+40, 80);
			ctx.lineTo(canvas.width/2-40, 80);
			ctx.closePath();
			ctx.fill();			
			ctx.fillStyle = "#FFFFFF";
			ctx.font = "bold 30px Arial";
			ctx.fillText(parseInt(page - self.xpages)+1, canvas.width/2 - 15, 70)
		}				
		
		if ( parseInt( (page - 1) / self.xpages) < self.ypages - 1) {
			ctx.fillStyle="#77AA00"
			ctx.beginPath();
			ctx.moveTo(canvas.width/2-40, canvas.height - 80);
			ctx.lineTo(canvas.width/2, canvas.height - 20);
			ctx.lineTo(canvas.width/2+40, canvas.height -80);
			ctx.lineTo(canvas.width/2-40, canvas.height - 80);
			ctx.closePath();
			ctx.fill();			
			ctx.fillStyle = "#FFFFFF";
			ctx.font = "bold 30px Arial";
			ctx.fillText(parseInt(page + self.xpages)+1, canvas.width/2 - 15, canvas.height - 50)
		}
		
		
		data = canvas.toDataURL('image/jpeg',0.3).slice('data:image/jpeg;base64,'.length);		
		data = atob(data)
		document.body.removeChild(canvas);
		
		return data;
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
			 d = this.zc[zoom]		 
			 e = Math.round(d[0] + ll[0] * this.Bc[zoom])		 
			 f = this.minmax(Math.sin(this.DEG_TO_RAD * ll[1]),-0.9999,0.9999)		 
			 g = Math.round(d[1] + 0.5*Math.log((1+f)/(1-f))*(-this.Cc[zoom]))
			 return [e,g]
		}
		 
		this.fromPixelToLL = function(px,zoom) {
			 e = this.zc[zoom]
			 f = (px[0] - e[0])/this.Bc[zoom]
			 g = (px[1] - e[1])/-this.Cc[zoom]
			 h = this.RAD_TO_DEG * ( 2 * Math.atan(Math.exp(g)) - 0.5 * Math.PI)
			 return [f,h]
		}
	}
	
	this.makeTitlePageImage = function(pages,p0,p1,z,width,height,z2,p02,p12,images,tiles) {
		var self = this				
		
		var fromX = Math.floor(p0[0]/256);
		var fromY = Math.floor(p0[1]/256);
		var toX = Math.ceil(p1[0]/256);
		var toY = Math.ceil(p1[1]/256);				
		
		if ( undefined === images ) {
			pages[0] = false;
			images = {};						
			images[0] = this.loadImage('image/map1eu_logo_contribution.png')						
			
			tiles = {};
			for ( var x = fromX; x <= toX; ++x ) {
				tiles[x] = {}
				for ( var y = fromY; y <= toY; ++y ) {					
					tiles[x][y] = this.loadImage('tiles/'+z+'/' + x + '/' + y + '.jpg')
				}
			}
		}
				
		
		
		if ( !images[0].complete ) {
			setTimeout(function() { self.makeTitlePageImage(pages,p0,p1,z,width,height,z2,p02,p12,images,tiles); },200);
			return;
		}
		
		for ( var x in tiles ) {
			for ( var y in tiles[x] ) {
				if ( !tiles[x][y].complete) {
					setTimeout(function() { self.makeTitlePageImage(pages,p0,p1,z,width,height,z2,p02,p12,images,tiles); },200);
					return;
				}
			}
		}
		
		pages[0] = this.makeTitleImage(tiles,images,p0,p1,z,width,height,z2,p02,p12);
		
		return;
	}
	
	this.makePageImage = function(pages,p0,p1,z,number,tiles,markers) {	   	    
		var self = this
		
		var fromX = Math.floor(p0[0]/256);
		var fromY = Math.floor(p0[1]/256);
		var toX = Math.ceil(p1[0]/256);
		var toY = Math.ceil(p1[1]/256);
		
		//alert((p1[0] - p0[0]) + ',' + (p1[1] - p0[1]));	    	    
		
		if ( undefined === tiles ) {
			pages[number] = false;
			tiles = {};
			for ( var x = fromX; x <= toX; ++x ) {
				tiles[x] = {}
				for ( var y = fromY; y <= toY; ++y ) {
					tiles[x][y] = this.loadImage('tiles/'+z+'/' + x + '/' + y + '.jpg')
				}
			}
			markers = {};
			for ( var i = 0; i<22; i++ ) {
				markers[i] = this.loadImage('image/marker'+(i+1)+'.png')				
			}
		}
		
		
		for ( var x in tiles ) {
			for ( var y in tiles[x] ) {
				if ( !tiles[x][y].complete) {
					setTimeout(function() { self.makePageImage(pages,p0,p1,z,number,tiles,markers); },200);
					return;
				}
			}
		}
		
		for ( var i = 0; i<22; i++ ) {
			if ( !markers[i].complete) {
				setTimeout(function() { self.makePageImage(pages,p0,p1,z,number,tiles,markers); },200);
				return;
			}
		}
		
		pages[number] = this.makeImage(tiles,markers,p0,p1,z,number);
		return;
	
	}
		
	
	
	this.renderPageImages = function(doc,pages,onRendered) {
		var self = this				
		
		var first = true
			
		for ( number in pages ) {		
			if ( pages[number] === true ) {
				first = false
				continue
			}
			if ( pages[number] === false ) {
				setTimeout(function() {self.renderPageImages(doc,pages,onRendered);},200)
				return;
			}
			if ( !first ) doc.addPage()			
			doc.addImage(pages[number],'JPEG',0,0,doc.internal.pageSize.width,doc.internal.pageSize.height)			
			pages[number] = true
			first = false
		}
		
		onRendered()
	}
	
	this.render = function(M,ll0,ll1,downloadifyId,marginX,marginY,minDPI,orientation,format) {		    	
		var doc = new jsPDF(orientation,"mm",format);		
		var pages = {}		
		
		var proj = new this.GoogleProjection();
		
		for ( var zoom = 8; zoom < 18; zoom++ ) {
			var S=40075017*Math.cos(((ll0[1]+ll1[1])/2)*Math.PI/180)/Math.pow(2,zoom+8)
			DPI = M * 0.0254 / S
			if ( DPI > minDPI ) break;
		}							
		
		var p0 = proj.fromLLtoPixel(ll0,zoom);
		var p1 = proj.fromLLtoPixel(ll1,zoom);	
				

		var _tmp = p0[1]		
		p0[1] = p1[1]
		p1[1] = _tmp
		
		marginX *= DPI/25.4
		marginY *= DPI/25.4
		
		
		self.marginY = marginY
		self.marginX = marginX
		
		var width = (doc.internal.pageSize.width*DPI/25.4 - 2*marginX)
		var height = (doc.internal.pageSize.height*DPI/25.4 - 2*marginY)
		var xpages = Math.ceil((p1[0] - p0[0]) / width);
		var ypages = Math.ceil((p1[1] - p0[1]) / height);		
		
		this.xpages = xpages
		this.ypages = ypages
		
		titleZoom = Math.floor(zoom-Math.log(Math.max(xpages,ypages)*2) / Math.LN2)		
		
				
		var p0title = proj.fromLLtoPixel(ll0,titleZoom);
		var p1title = proj.fromLLtoPixel(ll1,titleZoom);	
									
		while ( (height + 2*marginY - ((Math.ceil(p0title[1])/256 - Math.floor(p1title[1])/256 + 1) * 256))  < 700 ) {
			
			titleZoom -= 1
			p0title = proj.fromLLtoPixel(ll0,titleZoom);
			p1title = proj.fromLLtoPixel(ll1,titleZoom);	
			
		}
				
		
		var xoffset = (xpages * width - p1[0] + p0[0]) / 2;
		var yoffset = (ypages * height - p1[1] + p0[1]) / 2;								
		
		this.makeTitlePageImage(pages,
			[p0title[0],p1title[1]],
			[p1title[0],p0title[1]],
			titleZoom,width+2* marginX,height + 2* marginY,
			zoom,p0,p1
		);
		
		for ( var py = 0; py < ypages; ++py ) {
			for ( var px = 0; px < xpages; ++px ) {		
				this.makePageImage(pages,
					[p0[0] - xoffset + px*width - marginX,
						p0[1] - yoffset + py*height - marginY],
					[p0[0] - xoffset + (px+1)*width + marginX,
						p0[1] - yoffset + (py+1)*height + marginY],
					zoom, px+py*xpages+1
				);
			}
		}
		
		this.renderPageImages(doc,pages, function() {
			Downloadify.create(downloadifyId,{
			filename: 'map.pdf',
			data: function(){ 
				return doc.output('dataurlstring');
			},
			onComplete: function(){ 
				window.opener.map.printDialog.next();
				window.close();
			},
			onCancel: function(){ 
				window.close();
			},
			onError: function(){ 
				alert('You must put something in the File Contents or there will be nothing to save!'); 
			},
			transparent: false,
			swf: 'swf/downloadify.swf',
			downloadImage: 'image/download-pdf.png',
			width: 192,
			height: 32,
			transparent: true,
			append: false,
			dataType: 'base64'
			});
		});
	}
}
