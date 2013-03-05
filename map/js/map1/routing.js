var map1 = map1 || {}
map1.routing = map1.routing || {}

map1.routing.Route = $class({
	constructor: function(map) {
	    var self = this
	    
	    this.activate = false
	    
	    this._locked = 0
	    this.map = map
	    
	    this.way = []
	    this.vehicle = 'motorcar'
	    
	    var style = new OpenLayers.Style(
		{
		    graphicWidth: "${size}",
		    graphicHeight: "${size}",
		    graphicYOffset: "-${size}",
		    externalGraphic: "${externalGraphics}",
		    strokeWidth: "${radius}",
		    strokeColor: "#aa7733",
		    strokeOpacity: "${opacity}",
		    graphicZIndex: "$(zindex)"
		    
		},
		{
		    'context': {
			radius: function() {					
			    var zoom = self.map.getZoom()
			    
			    return zoom > 8
				? 3 * (zoom - 8) + 4
				: 4;
				
			},
			opacity: function() {
			    var zoom = self.map.getZoom()
			    
			    return zoom > 8
				? (zoom < 14 ? (14 - zoom)/20 + 0.3 : 0.3)
				: 0.7
			},
			zindex: function(f) {
			    return f.geometry.CLASS_NAME == 'OpenLayers.Geometry.Point'
				? 10 : -10
			},
			externalGraphics: function(f) {
			    var i = self.wayPoints.indexOf(f);
			    if ( i == -1 )
				i = self.wayPoints.length
			    
			    return "image/marker" + (i+1) + '.png'	
			},
			size: function() {
			    var zoom = self.map.getZoom()
			    
			    return zoom > 8
				? (zoom < 14 ? 3 * (zoom - 8) + 30 : 48) 
				: 30;
			}					    
		    },
		    
		}
	    )
	    
	    this.vector = new OpenLayers.Layer.Vector("Route points",
	    {		
		styleMap: new OpenLayers.StyleMap(
		    {
			'default': style,
			'select': style,
		    }
		),		
		rendererOptions: { zIndexing: true }
	    });	    	    
	    
	    this.drawFeature = new OpenLayers.Control.DrawFeature(
		this.vector,
		OpenLayers.Handler.Point,
		{
		    handlerOptions: {
			style: {
			    opacity: 0
			}
		    },
		    featureAdded: function(f) {
			self.appendWayPoint(f)
		    }
			
		}
	    )
		    
	    
	    this.map.addControl(this.drawFeature)
	    
	    this.selectFeature = new OpenLayers.Control.SelectFeature(
		this.vector, {}
	    )
	    
	    this.vector.events.on({featureselected: function(event) {
		if ( event.feature.geometry.CLASS_NAME == 'OpenLayers.Geometry.Point' ) {
		    
		    var i = self.wayPoints.indexOf(event.feature)
		    self.removeWayPoint(i)
		}
		else {
		    var pixel = self.selectFeature.handlers.feature.evt.xy
		    var i = self.way.indexOf(event.feature)
		    var location = self.map.getLonLatFromPixel(pixel)
		    self.insertWayPoint(i,location)
		}

	    }});
	    
	    this.dragFeature = new OpenLayers.Control.DragFeature(this.vector,{
		
		onComplete: function(f,pixel) {		    
		    var i = self.wayPoints.indexOf(f)
		    var bounds = self.wayPoints[i].geometry.bounds;
		    
		    self.moveWayPoint(i,new OpenLayers.LonLat(bounds.left,bounds.top))
		    
		},			
		geometryTypes: ['OpenLayers.Geometry.Point']		
		
	    }) 	
	   
	    
	    this.dragFeature.handlers['drag'].stopDown = false
	    this.dragFeature.handlers['drag'].stopUp = false
	    this.dragFeature.handlers['drag'].stopClick = false
	    this.dragFeature.handlers['feature'].stopDown = false
	    this.dragFeature.handlers['feature'].stopUp = false
	    this.dragFeature.handlers['feature'].stopClick = false
	   
	    this.map.addControl(this.selectFeature)
	    this.map.addControl(this.dragFeature)
	   
	    
	    //this.map.addLayer(this.vector_layer);  
	    this.map.addLayer(this.vector);   
	    
	    
	    
	    if ( this.active ) this.drawFeature.activate() 
	    this.selectFeature.activate() 
	    this.dragFeature.activate()  
	},
	
	appendWayPoint: function(location, updateInput) {	    
	    var self = this
	    if ( location instanceof OpenLayers.LonLat ) {
		var f = new OpenLayers.Feature.Vector(new OpenLayers.Geometry.Point(location.lon,location.lat))
		this.vector.addFeatures([f])
	    }
	    else {
		var f = location
	    }
	    this.wayPoints.push(f)
	    
	    var callback = function() {
		if ( undefined !== self.map.search ) {
		    if ( !(location instanceof OpenLayers.LonLat) ) {
			location = new OpenLayers.LonLat(f.geometry.x,f.geometry.y)
		    }
			
		    self.map.search.appendItem(location,updateInput)
		}		
	    }
	    
	    if ( this.wayPoints.length > 1 ) {
	       
		var bounds1 = f.geometry.bounds.clone();  
		var bounds2 = this.wayPoints[this.wayPoints.length-2].geometry.bounds.clone()		  
		bounds1.transform(
			this.map.getProjectionObject(),
			new OpenLayers.Projection("EPSG:4326")
		)
		bounds2.transform(
			this.map.getProjectionObject(),
			new OpenLayers.Projection("EPSG:4326")
		)                    
		this.makeRoute(bounds1.left,bounds1.top,bounds2.left,bounds2.top,this.wayPoints.length-2, callback)
	    }
	    else {
		callback()
	    }

	},
	
	insertWayPoint: function(i,location, updateInput) {
	    var self = this
	    
	    if ( undefined === location ) {
		location = this.way[i].geometry.getBounds().getCenterLonLat()		
	    }
	    var f = new OpenLayers.Feature.Vector(new OpenLayers.Geometry.Point(location.lon,location.lat))
	    
	    var loc = location.clone()
	    
	    loc.transform(
		this.map.getProjectionObject(),
		new OpenLayers.Projection("EPSG:4326")
		
	    )
	    	    
	    this.vector.addFeatures([f])
	    this.wayPoints.splice(i+1,0,f)
	    this.way.splice(i+1,0,undefined)
	    var bounds1 = this.wayPoints[i].geometry.bounds.clone().transform(
		    this.map.getProjectionObject(),
		    new OpenLayers.Projection("EPSG:4326")
		    
		)
	    var bounds2 = this.wayPoints[i+2].geometry.bounds.clone().transform(
		    this.map.getProjectionObject(),
		    new OpenLayers.Projection("EPSG:4326")
		    
		)
	    self.__insertWayPointLast__ = false
	    var callback = function() {
		if ( undefined !== self.map.search && true === self.__insertWayPointLast__ ) {			    
		    self.map.search.insertItem(i,location,updateInput)
		    self.__insertWayPointLast__ = false
		    self.vector.redraw();
		}
		else {
		    self.__insertWayPointLast__ = true
		}
	    }
	    this.makeRoute(bounds1.left,bounds1.top,loc.lon,loc.lat,i,callback)
	    this.makeRoute(loc.lon,loc.lat,bounds2.left,bounds2.top,i+1,callback)	    	    	    
	    
	},
	
	removeWayPoint: function(i) {
	    var self = this
	    if ( i > 0 && i < this.wayPoints.length - 1 ) {
		var bounds1 = this.wayPoints[i-1].geometry.bounds.clone().transform(
			this.map.getProjectionObject(),
			new OpenLayers.Projection("EPSG:4326")
			
		    )
		var bounds2 = this.wayPoints[i+1].geometry.bounds.clone().transform(
			this.map.getProjectionObject(),
			new OpenLayers.Projection("EPSG:4326")
		    )
	    }
	    var wf = this.way[i]
	    this.vector.removeFeatures([this.wayPoints[i]])
	    this.way.splice(i, 1)
	    this.wayPoints.splice(i, 1)
	    
	    var callback = function() {
		if ( undefined !== wf ) {
		    self.vector.removeFeatures([wf])
		}
		if ( undefined !== this.map.search ) {		    
		    self.map.search.removeItem(i)
		}
	    }
	    
	    if ( i == 0 ) {		
		callback()
	    }
	    else if ( i == this.wayPoints.length  ) {
		wf = this.way[i-1]
		callback()
	    }
	    else {
		this.makeRoute(bounds1.left,bounds1.top,bounds2.left,bounds2.top,i-1,callback)
	    }

	    this.vector.redraw()
	    
	    
	},
	
	moveWayPoint: function(i,location,updateInput) {
	    var self = this
	    
	    loc = location.clone()
	    
	    loc.transform(
		this.map.getProjectionObject(),
		new OpenLayers.Projection("EPSG:4326")
	    )  
	    
	    self.__moveWayPointLast__ = false
	    var callback = function() {
		if ( undefined !== this.map.search && true === self.__moveWayPointLast__ ) {
		    self.map.search.modifyItem(i,location,updateInput)
		    self.__moveWayPointLast__ = false
		}
		else {
		    self.__moveWayPointLast__ = true
		}
	    }
	    
	    if ( i > 0 ) {
		var bounds2 = this.wayPoints[i-1].geometry.bounds.clone();
		bounds2.transform(
		    this.map.getProjectionObject(),
		    new OpenLayers.Projection("EPSG:4326")
		)
		if ( i >= this.wayPoints.length - 1) {
		    self.__moveWayPointLast__ = true
		}
		this.makeRoute(bounds2.left,bounds2.top,loc.lon,loc.lat,i-1,callback)
	    }
	    
	    if ( i < this.wayPoints.length - 1) {
		var bounds3 = this.wayPoints[i+1].geometry.bounds.clone();
		bounds3.transform(
		    this.map.getProjectionObject(),
		    new OpenLayers.Projection("EPSG:4326")
		)
		if ( i == 0) {
		    self.__moveWayPointLast__ = true
		}
		this.makeRoute(loc.lon,loc.lat,bounds3.left,bounds3.top,i,callback)
	    }
	    
	    if ( this.wayPoints[i].geometry.x != location.lon || this.wayPoints[i].geometry.y != location.lat ) {
		this.wayPoints[i].geometry.move(		    
		    location.lon - this.wayPoints[i].geometry.x,
		    location.lat - this.wayPoints[i].geometry.y		    
		);
		this.vector.redraw()
	    }	    	    
	    
	},
	
	makeRoute: function(flon,flat,tlon,tlat,index,callback) {
	    var self = this  	    
	    this.lock()
	    $.ajax({
		url: '/yournavigation?format=geojson&flat='+flat+'&flon='+flon+'&tlat='+tlat+'&tlon='+tlon+'&v='+self.vehicle+'&fast=1&layer=mapnik',
		success: function(json) {
		    if ( undefined !== self.way[index] ) {
			self.vector.removeFeatures([self.way[index]])
		    }
		    		    
				      
		    var geojson_format = new OpenLayers.Format.GeoJSON();
		    var geometry = geojson_format.parseGeometry(json);
		    geometry.transform(
			new OpenLayers.Projection("EPSG:4326"),
			self.map.getProjectionObject()
		    );
		    
		    self.distances[index] = json.properties.distance
		    self.travelTimes[index] = json.properties.traveltime

		    self.way[index] = new OpenLayers.Feature.Vector(geometry);
		    
		    //self.vector.styleMap.createSymbolizer(self.way[index],'default
		    
		    //self.way[index].style = self.vector.styleMap.styles.default.defaultStyle
		    		    
		    self.vector.addFeatures([self.way[index]]);
		    
		    self.unlock()
		    
		    if ( undefined !== callback ) {
			callback()
		    }
		},
		error: function(jqXHR, textStatus, errorThrown) {
		    self.unlock()
		}
	    });
	},
	
	refresh: function() {
	    var self = this	    
	    this.__refreshRoutesCount__ = this.wayPoints.length - 1
	    var callback = function() {
		if ( undefined !== this.map.search && 0 == --self.__refreshRoutesCount__ ) {		    
		    self.map.search.updateRouteInfo()		    
		}		
	    }
	    
	    for(var i = 0; i < this.wayPoints.length - 1; ++i ) {
		var bounds1 = this.wayPoints[i].geometry.bounds.clone();
		bounds1.transform(
		    this.map.getProjectionObject(),
		    new OpenLayers.Projection("EPSG:4326")
		)
		var bounds2 = this.wayPoints[i+1].geometry.bounds.clone();
		bounds2.transform(
		    this.map.getProjectionObject(),
		    new OpenLayers.Projection("EPSG:4326")
		)
		this.makeRoute(bounds1.left,bounds1.top,bounds2.left,bounds2.top,i,callback)
	    }
	},
	
	lock: function(lockMap, searchLoadingIcon) {
	    if ( undefined === lockMap ) {
		lockMap = true
	    }
	    
	    if ( 0 == this._locked++ ) {
		if ( this.active ) this.drawFeature.deactivate()
		this.selectFeature.deactivate() 
		this.dragFeature.deactivate()  
		if ( undefined !== this.map.search )
		    this.map.search.lock(searchLoadingIcon)
		if ( lockMap == true ) {
		    this.map.lock()
		}
	    }
	},
	
	unlock: function() {
	    if ( 0 == this._locked )
		return
	    if ( 0 == --this._locked ) {	    
		if ( this.active ) this.drawFeature.activate() 
		this.selectFeature.activate() 
		this.dragFeature.activate()
		if ( undefined !== this.map.search )
		    this.map.search.unlock()
		this.map.unlock()
	    }
	},
	
	activate: function() {
	    if ( !this.active ) {
		this.drawFeature.activate()
		this.active = true
	    }
	},
	
	deactivate: function() {
	    if ( this.active ) {
		this.drawFeature.deactivate()
		this.active = false
	    }
	},
	
	wayPoints: [],
	distances: [],
	travelTimes: []	
})
