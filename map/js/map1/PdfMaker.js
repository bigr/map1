var map1 = map1 || {}

map1.PdfMaker = function(orientation,format,downloadifyId) {	
	var self = this
	self.doc = new jsPDF(orientation,"mm",format);
	self._pages = []
	self._downloadifyId = downloadifyId
	
	self.draw = function(page,feature) {
		var pg = self._page(page)
		
		if ( undefined !== map1.PdfMaker.Feature[feature] ) {	
			var args = Array.prototype.slice.call(arguments).slice(2)		
			var f = new map1.PdfMaker.Feature[feature](pg)
			if ( undefined !== f.beforeSchedule )
				f.beforeSchedule.apply(f,args)
			if ( undefined !== f.onDraw ) 				
				pg.scheduleDraw(function() {
					f.onDraw.apply(f,args)
				})			
		}
		else {
			throw "Undefined feature: '" + feature + "'"
		}
		
	}			
	
	self.render = function(onBefore,onAfter) {		
		for ( var i in self._pages ) {
			var page = self._pages[i]
			
			if ( page.status != 'rendered' ) {				
				if ( page.status == 'not-rendered' ) {
					if ( i != 0 )
						self.doc.addPage()
					page.render(onBefore,onAfter)
				}
				setTimeout(function() { self.render(onBefore,onAfter) },200)
				return
			}
		}
		
		Downloadify.create(self._downloadifyId,{
			filename: 'map.pdf',
			data: function(){ 
				return self.doc.output('dataurlstring');
			},
			onComplete: function(){ 
				//window.opener.map.printDialog.next();
				//window.close();
			},
			onCancel: function(){ 
				//window.close();
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
	}
	
	self._hexColorToRGB = function(color) {		
		return [
			parseInt(color.substring(1,3),16),
			parseInt(color.substring(3,5),16),
			parseInt(color.substring(5,7),16)
			
		]		
	}
	
	self._page = function(page) {
		while ( self._pages.length <= page ) {
			self._pages.push(new self.Page(self))
		}
		
		return self._pages[page]
	}
	
	self.XY12 = function(x1,y1,x2,y2) {
		this.x1 = x1 < 0 ? self.doc.internal.pageSize.width + x1 : x1
		this.y1 = y1 < 0 ? self.doc.internal.pageSize.height + y1 : y1
		this.x2 = x2 <= 0 ? self.doc.internal.pageSize.width + x2 : x2
		this.y2 = y2 <= 0 ? self.doc.internal.pageSize.height + y2 : y2		
	}
	
	self.Page = function(maker) {
		var me = this
		me.maker = maker
		me._preload = []
		me._preloaded = {}
		me._schedule = []
		me.status = 'not-rendered'
		me.addToPreload = function(url) {
			me._preload.push(url)
		}
		me.scheduleDraw = function(doDraw) {
			me._schedule.push(doDraw)
		}
		me.render = function(onBefore,onAfter) {
			me.status = 'rendering'
			
			for ( var i in me._preloaded ) {
				if ( !me._preloaded[i].complete ) {
					setTimeout(function() { me.render(onBefore,onAfter) },200)
					return
				}
			}
			
			if ( onBefore !== undefined )
				onBefore(me)				
			
			for ( var i in me._schedule ) {
				me._schedule[i]()
			}
				
			if ( onAfter !== undefined )
				onAfter(me)

			me.status = 'rendered'
		}
	}
}

map1.PdfMaker.Feature  = map1.PdfMaker.Feature  || {}

map1.PdfMaker.Feature.Line = function(page) {
	var self = this	
	self._page = page
	
	self.onDraw = function(x1,y1,x2,y2,color,opacity,width) {
		
		var tmp = new self._page.maker.XY12(x1,y1,x2,y2)
		x1 = tmp.x1
		y1 = tmp.y1
		x2 = tmp.x2
		y2 = tmp.y2
		
		if ( undefined === color ) color = '#000000'
		if ( undefined === opacity ) opacity = 1
		if ( undefined === width ) opacity = 1
		
		var tmp = page.maker._hexColorToRGB(color)
		page.maker.doc.setDrawColor(tmp[0],tmp[1],tmp[2],opacity)
		page.maker.doc.setLineWidth(width)		
		page.maker.doc.line(x1,y1,x2,y2)
	}
}


map1.PdfMaker.Feature.Grid = function(page) {
	var self = this	
	self._page = page
	
	
	self.onDraw = function(x1,y1,x2,y2,color,opacity,width,w,h,x,y,startNumber,textSize,textPos,textColor,textBgcolor,textBgOpacity) {
		
		var tmp = new self._page.maker.XY12(x1,y1,x2,y2)
		x1 = tmp.x1
		y1 = tmp.y1
		x2 = tmp.x2
		y2 = tmp.y2
		
		if ( undefined === color ) color = '#000000'
		if ( undefined === opacity ) opacity = 1
		if ( undefined === width ) opacity = 1
		
		if ( undefined === h ) h = w
		if ( undefined === x ) x = ((x2-x1) % w) / 2
		if ( undefined === y ) y = ((y2-y1) % h) / 2
				
		var tmp = page.maker._hexColorToRGB(color)
		
		page.maker.doc.setDrawColor(tmp[0],tmp[1],tmp[2],opacity)
		page.maker.doc.setLineWidth(width)
		
		for ( var j = y1 + y; j <= y2; j += h ) {
			page.maker.doc.line(x1,j,x2,j)
		}
		
		for ( var i = x1 + x; i <= x2; i += w ) {
			page.maker.doc.line(i,y1,i,y2)
		}				
		
		if ( undefined !== startNumber ) {
			if ( undefined === textSize ) textSize = h/10 < 4 ? 4 : (h/10 > 10 ? 10 : h/10)
			if ( undefined === textPos ) textPos = 2
			if ( undefined === textColor ) textColor = '#ffffff'
			if ( undefined === textBgcolor ) textBgColor = color
			if ( undefined === textBgOpacity ) textBgOpacity = opacity

			var k = 0
			for ( var j = y1 + y; j <= y2-h; j += h ) {
				for ( var i = x1 + x; i <= x2-w; i += w ) {
					if ( textPos == 2 ) {
						var tmp = page.maker._hexColorToRGB(textBgColor)
						page.maker.doc.setFillColor(tmp[0],tmp[1],tmp[2],textBgOpacity)
						page.maker.doc.rect(i+w-2.5*textSize,j+h-1.5*textSize,2.5*textSize,1.5*textSize,'F')				
						var tmp = page.maker._hexColorToRGB(textColor)
						
						page.maker.doc.setTextColor(tmp[0],tmp[1],tmp[2])
						
						page.maker.doc.setFontSize(textSize*4)
						page.maker.doc.text(i+w-2.25*textSize,j+h-0.25*textSize,'' + (startNumber + (k++)))
					}
					//page.maker.doc.text(i,j,labels[k++])
				}
			}
		}
		
		
						
	}
}

map1.PdfMaker.Feature.Rect = function(page) {
	var self = this	
	self._page = page
	
	self.onDraw = function(x1,y1,x2,y2,color,opacity,width,style) {
		/*
		var tmp = new self._page.maker.XY12(x1,y1,x2,y2)
		x1 = tmp.x1
		y1 = tmp.y1
		x2 = tmp.x2
		y2 = tmp.y2
		*/
		
		if ( undefined === color ) color = '#000000'
		if ( undefined === opacity ) opacity = 1
		if ( undefined === width ) width = 1
		if ( undefined === style ) style = 'F'
		var tmp = page.maker._hexColorToRGB(color)
		if ( style == 'S' ) {
			page.maker.doc.setDrawColor(tmp[0],tmp[1],tmp[2])
			page.maker.doc.setLineWidth(width)
		}
		else {
			page.maker.doc.setFillColor(tmp[0],tmp[1],tmp[2])			
		}		
		
		//alert(x1 + ',' + y1 + ',' + (x2 - x1) + ',' + (y2 - y1))		
		page.maker.doc.rect(x1,y1,x2-x1,y2-y1,style)
	}
}


map1.PdfMaker.Feature.Triangle = function(page) {
	var self = this	
	self._page = page
	
	self.onDraw = function(x1,y1,x2,y2,x3,y3,color,opacity,width,style) {
		/*
		var tmp = new self._page.maker.XY12(x1,y1,x2,y2)
		x1 = tmp.x1
		y1 = tmp.y1
		x2 = tmp.x2
		y2 = tmp.y2
		*/
		
		if ( undefined === color ) color = '#000000'
		if ( undefined === opacity ) opacity = 1
		if ( undefined === width ) width = 1
		if ( undefined === style ) style = 'F'
		var tmp = page.maker._hexColorToRGB(color)
		if ( style == 'S' ) {
			page.maker.doc.setDrawColor(tmp[0],tmp[1],tmp[2])
			page.maker.doc.setLineWidth(width)
		}
		else {
			page.maker.doc.setFillColor(tmp[0],tmp[1],tmp[2])			
		}		
		
		//alert(x1 + ',' + y1 + ',' + (x2 - x1) + ',' + (y2 - y1))		
		page.maker.doc.triangle(x1,y1,x2,y2,x3,y3,style)
	}
}

map1.PdfMaker.Feature.Text = function(page) {
	var self = this	
	self._page = page
	
	self.onDraw = function(x1,y1,size,color,text) {
		
		if ( undefined === color ) color = '#000000'
		if ( undefined === size ) size = 12
		
		var tmp = page.maker._hexColorToRGB(color)				
		page.maker.doc.setTextColor(tmp[0],tmp[1],tmp[2])
		page.maker.doc.setFontSize(size)
		page.maker.doc.text(x1,y1,''+text)
	}
}

map1.PdfMaker.Feature.Image = function(page) {
	var self = this	
	self._page = page		
	
	self.beforeSchedule = function(_x1,_y1,images,dpi,quality,bgcolor) {
		//url,x1,y1,x2,y2,sx1,sy1,sx2,sy2,resample
		
		for ( var i in images ) {
			var image = images[i]
			self._page._preload.push(image.url)
			var img = new Image()
			
			img.url = image.url
			/*
			img.onload = function() {											
				self._page._preload.splice(self._page._preload.indexOf(this.url), 1)
			}
			*/
			img.onError = function() {
				throw new Error('Cannot load image');
			}
			
			self._page._preloaded[image.url] = img
			img.src = image.url
			
		}
	}
	
	self.onDraw = function(_x1,_y1,images,dpi,quality,bgcolor,overlays) {
		//url,x1,y1,x2,y2,sx1,sy1,sx2,sy2
		if ( quality === undefined ) quality = 0.85
		if ( dpi === undefined ) dpi = 200		
		if ( bgcolor === undefined ) bgcolor = '#ffffff'
		
		
		var x1 = Number.MAX_VALUE
		var y1 = Number.MAX_VALUE
		var x2 = Number.MIN_VALUE
		var y2 = Number.MIN_VALUE
		for ( var i in images ) {
			var image = images[i]
			if ( image.sx1 === undefined ) image.sx1 = 0
			if ( image.sy1 === undefined ) image.sy1 = 0
			if ( image.sx2 === undefined ) image.sx2 = image.sx1 + self._page._preloaded[image.url].width
			if ( image.sy2 === undefined ) image.sy2 = image.sy1 + self._page._preloaded[image.url].height			
			if ( x1 > image.x1 ) x1 = image.x1
			if ( y1 > image.y1 ) y1 = image.y1
			if ( x2 < image.x2 ) x2 = image.x2
			if ( y2 < image.y2 ) y2 = image.y2
		}
		var canvas = document.createElement('canvas')
		//canvas.style.display = "none"
		document.body.appendChild(canvas)		
		
		canvas.width = (x2-x1)*dpi/25.4
		canvas.height = (y2-y1)*dpi/25.4				
		var ctx = canvas.getContext('2d')		
		
		ctx.fillStyle = bgcolor
		ctx.fillRect(0,0,canvas.width,canvas.height)
		
		for ( var i in images ) {						
			
			var image = images[i]
			var img = self._page._preloaded[image.url]
			try {
				ctx.drawImage(
					img,
					Math.round(image.sx1),Math.round(image.sy1),
					Math.round(image.sx2-image.sx1),
					Math.round(image.sy2-image.sy1),
					Math.round((image.x1-x1)*dpi/25.4),
					Math.round((image.y1-y1)*dpi/25.4),
					Math.round((image.x2-image.x1)*dpi/25.4),
					Math.round((image.y2-image.y1)*dpi/25.4)
					
				)				
			}
			catch(e) {
				console.log("Not found: " + image.url)
			}
		}
		
		if ( undefined !== overlays ) {
			try {
				for ( var i in overlays ) {
					var overlay = overlays[i]
					overlay(ctx)
				}
			}
			catch(e) {
				console.log(e)
			}
		}
						
		try {
			var data = canvas.toDataURL('image/jpeg',quality).slice('data:image/jpeg;base64,'.length);				
			data = atob(data)		
			document.body.removeChild(canvas)
		}
		catch(e) {
			console.log(e)
		}				
				
		page.maker.doc.addImage(data,'JPEG',_x1,_y1,x2-x1,y2-y1)
		
		
	}
}



