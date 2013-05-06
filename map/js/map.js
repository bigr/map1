var MAP_TILE_URLS = [
    "http://tethys.bigr.cz/map/tiles/${z}/${x}/${y}.jpg"    
];

var DATA_TILE_URLS = 
    "http://tethys.bigr.cz/map/tiles/${z}/${x}/${y}.js.gz"    
;

I18n = function() {
    var self = this
    self.dictionary = {}
    var language = 'cs'    
    $.getJSON("locales/" + language + "/translation.json", function(data) {
        self.dictionary = data
        self.translate($(document))
    });        
        
    
    this.translate = function(obj) {
        self = this
        obj.find('*[data-i18n-src]').each(function(i){                        
            text = $(this).attr('src')            
            if ( text in self.dictionary ) {                
                $(this).attr('src',self.dictionary[text])
                $(this).removeAttr('data-i18n-src')
            }
        });
        obj.find('*[data-i18n]').each(function(i){
            text = $(this).text().replace(/^\s+|\s+$/g,"")           
            if ( text in self.dictionary ) {
                $(this).text(self.dictionary[text])
                $(this).removeAttr('data-i18n')
            }
        });
        
    }
}

self.i18n = new I18n()

var utfgrid = new OpenLayers.Layer.UTFGrid({
    url: "http://tethys.bigr.cz/map/tiles/${z}/${x}/${y}.js.gz",
    utfgridResolution: 4, // default is 2
    displayInLayerSwitcher: false
});

var infoPopup = false

var  callback = function(infoLookup) {            
    if ( undefined == infoLookup[1] || undefined === infoLookup[1]['data'] ) {
        $('#map').css('cursor','auto')
        if ( infoPopup ) {
            if ( infoPopup.timeOut ) {
                clearTimeout(infoPopup.timeOut)
                infoPopup.timeOut = null
            }
            else {
                this.map.removePopup(infoPopup)
            }
        }
        infoPopup = false
        
        return
    }
    else {
        if ( infoLookup[1]['data']['wiki'] ) {
            $('#map').css('cursor','pointer')
        }
        else {
            $('#map').css('cursor','crosshair')
        }
    }
    
    
    data = infoLookup[1]['data']
    if ( data['highway'] != null ) {
        if ( data['surface'] == null ) {
            if ( parseInt(data['grade']) < 5 ) {
                data['surface'] = 'paved'
            }
            else if ( parseInt(data['grade']) < 8 ) {
                data['surface'] = 'propably_paved'
            }        
            else if ( parseInt(data['grade']) == 8 ) {
                data['surface'] = 'propably_unpaved'
            }
            else {
                data['surface'] = 'unpaved'
            }
        }
        
        if ( parseInt(data['grade']) < 7 ) {
            data['photo'] = 'highway_photo_grade_'+data['grade']
        }
        else {
            data['photo'] = 'highway_photo_surface_'+data['surface']
        }
    }
    
    content = ich.featureinfo(data)    
    content = jQuery('<div>').append(content)
    i18n.translate(content)
    content = content.html()
    
    if ( !infoPopup ) {
    
        infoPopup = new OpenLayers.Popup("featureinfo",
            arguments[1],
            new OpenLayers.Size(300,150),
            content,
            false
        );
        infoPopup.timeOut = setTimeout(function() {
            this.map.addPopup(infoPopup);
            infoPopup.timeOut = null
        },250)
    }
    else {
        infoPopup.setContentHTML(content)
        infoPopup.lonlat = arguments[1]
        infoPopup.updatePosition()                
    }
    var offset = $(infoPopup.div).offset()
            
    $(infoPopup.div).offset({left:offset.left+16,top:offset.top+16})
    $(infoPopup.div).css('background','none')
    
}

var callback2 = function(infoLookup) {    
    //if ( undefined != infoLookup[1] && undefined != infoLookup[1]['data'] && null != infoLookup[1]['data']['wiki'] ) {
    //    window.open('http://cs.wikipedia.org/wiki/'+infoLookup[1]['data']['wiki'], 'Wikipedie', '')
    //}     
}

var utfgridControl = new OpenLayers.Control.UTFGrid({
    layers: [utfgrid],
    handlerMode: 'move',
    callback: callback
})

var utfgridControl2 = new OpenLayers.Control.UTFGrid({
    layers: [utfgrid],
    handlerMode: 'click',
    callback: callback2
})


var map = new OpenLayers.Map({
    div: "map",
    projection: new OpenLayers.Projection("EPSG:900913"),
    displayProjection: new OpenLayers.Projection("EPSG:4326"),
    layers: [        
        new OpenLayers.Layer.XYZ("Prostě mapa SK", MAP_TILE_URLS, {
            transitionEffect: "resize", 
            buffer: 2, 
            sphericalMercator: true, 
            numZoomLevels: 17,
            isBaseLayer: true      
        }),  
        
        utfgrid,      
        new OpenLayers.Layer.Vector("info")
    ],
    controls: [
        new OpenLayers.Control.Navigation({
            dragPanOptions: {
                enableKinetic: true
            }
        }),        
        new OpenLayers.Control.Attribution(),
        new OpenLayers.Control.Permalink({anchor: true}),
        utfgridControl,
        utfgridControl2
    ],
    center: new OpenLayers.LonLat(15,50).transform(
        new OpenLayers.Projection("EPSG:4326"),
        new OpenLayers.Projection("EPSG:900913")
    ),   
    zoom: 8,
/*
    drawPolygon: function(coordinates) {
        var site_points = []
        for (i in coordinates) {            
            var point = new OpenLayers.Geometry.Point(coordinates[i][0], coordinates[i][1]);
            point.transform(
                new OpenLayers.Projection("EPSG:4326"),
                new OpenLayers.Projection("EPSG:900913")
              );
            site_points.push(point);
        }
        site_points.push(site_points[0]);

        
        
        var linear_ring = new OpenLayers.Geometry.LinearRing(site_points);
        
        var polygonFeature = new OpenLayers.Feature.Vector(
            new OpenLayers.Geometry.Polygon([linear_ring]), null, {
                strokeWidth: 2,
                strokeColor: '#0f0',
                strokeOpacity: 0.3,
                fillColor: '#0f0',
                fillOpacity: 0.1
                
            }
        );
        layer = new OpenLayers.Layer.Vector("Layer");
        self.addLayer(layer)
        layer.addFeatures([polygonFeature])
        
        
    },
*/
    search: function(query) {
        if ( undefined === query ) {
            query = $('#searchQuery').val().toLowerCase();
        }
        /*
        key = query.substring(0,2)
        $.ajax({            
            url:'search/db/' + key + '.js.gz',
            success: function(data) {
                var db = new Jsdb(data)
                var rows = db.like(query,'2 DESC')
                self.setMapCenter([rows[0][1][3],rows[0][1][4],rows[0][1][5],rows[0][1][6]])
            }
        })
        return false;
        */                    
        $.ajax({            
            url:"http://nominatim.openstreetmap.org/search?q="+query+"&polygon=1&format=json&countrycodes=cz,sk,pl,at",
            success: function(data) {
                data = $.parseJSON(data)               
                self.setMapCenter(data[0].boundingbox)
                //self.drawPolygon(data[0].polygonpoints)
            }
        })
        return false;
    },
    
    

    makeSearchList: function() {
        query = $('#searchQuery').val().toLowerCase()
        /*
        if ( query.length <= 2 ) {
            $('#searchResult').html('')
            return false;
        }
        //list = $('<ul/>');				
                        
        key = query.substring(0,2)				
        
        $.ajax({
                url:'search/db/' + key + '.js.gz',
                success: function(data) {
                    var db = new Jsdb(data)
                    var rows = db.like(query,'2 DESC')
                    var limit = 7 + query.length * 3
                    result = []
                    for ( var k in rows ) {
                        result.push({
                            key: rows[k][0],
                            type: rows[k][1][1],
                            location: rows[k][1][0],
                            lon1: rows[k][1][3],
                            lat1: rows[k][1][4],
                            lon2: rows[k][1][5],
                            lat2: rows[k][1][6],
                        });
                        limit--
                        if ( 0 == limit ) break;
                    }
                    var content = ich.searchresult({result: result})                        
                    $('#searchResult').html(content);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    
                }
                
        })
        */
        
        $.ajax({            
            url:"http://nominatim.openstreetmap.org/search?q="+query+"&addressdetails=1&format=json&countrycodes=cz,sk,pl,at",
            success: function(data) {
                data = $.parseJSON(data)  
                result = []             
                for ( var k in data ) {
                    if ( data[k].class == 'boundary' )
                        continue;
                    if ( data[k].class == 'highway' ) {
                        data[k].type = 'highway_' + data[k].type;
                    }
                    result.push({
                        key: data[k].display_name,
                        type: data[k].type,
                        location: '',
                        lon1: data[k].boundingbox[1],
                        lat1: data[k].boundingbox[0],
                        lon2: data[k].boundingbox[3],
                        lat2: data[k].boundingbox[2]
                    });
                    var content = ich.searchresult({result: result})                        
                    $('#searchResult').html(content);
                }
            }
        })
        
        return false;
    },

    setMapCenter: function(boundingbox) {
        var bounds = new OpenLayers.Bounds();       
        
        bounds.extend(new OpenLayers.LonLat(boundingbox[2],boundingbox[0]).transform(
            new OpenLayers.Projection("EPSG:4326"),
            new OpenLayers.Projection("EPSG:900913")
        ));
        bounds.extend(new OpenLayers.LonLat(boundingbox[3],boundingbox[1]).transform(
            new OpenLayers.Projection("EPSG:4326"),
            new OpenLayers.Projection("EPSG:900913")
        ));            
        
        //bounds.extend(new OpenLayers.LonLat(boundingbox[0],boundingbox[1]));
        //bounds.extend(new OpenLayers.LonLat(boundingbox[2],boundingbox[3]));
        this.zoomToExtent(bounds)
        return false;
    },
    

    routing: function() {
    },
    
   
    init: function() {
        self = this
        
        //$('#menu').hover(this.menuHoverIn, this.menuHoverOut)

        $('#searchQuery').keyup(function() {
            $('#content').stopTime('hide')
            $('#searchQuery').stopTime('makeSearchList')
            $('#searchQuery').oneTime(1000, 'makeSearchList', self.makeSearchList)
        })
        
        
        var geojson_format = new OpenLayers.Format.GeoJSON();
        var vector_layer = new OpenLayers.Layer.Vector(); 
        self.addLayer(vector_layer);
        
        $.ajax({            
            url:"http://www.yournavigation.org/api/1.0/gosmore.php?flat=50.079606659709796&flon=14.453787603219034&tlat=49.774388547862486&tlon=18.22339493294614&format=kml&v=motorcar&fast=1&layer=mapnik&instructions=1&tessellate=1",
            timeout: 1000*1000,
            success: function(data) {
                data = $.parseJSON(data)  
                vector_layer.addFeatures(geojson_format.read(data));
                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(errorThrown.message);
            }
        });
        

        new SideBar('#panel-search','#button-start')
        new SideBar('#sidebar','#button-start, #panel-search',true)

        self.printDialog = new Dialog(['#dialog-print','#dialog-print-2','#dialog-print-3'],'.button-print','.dialog > .header > .close,.dialog > .footer > .close','.dialog > .footer > .next','.dialog > .footer > .prev','.dialog > .footer > .finish');
        OpenLayers.Util.extend(self.printDialog,{
            onOpen: function() {
                
                self.printAreaLayer = new OpenLayers.Layer.Vector("Box layer");
                self.addLayer(self.printAreaLayer)
                self.printAreaCtrl = new OpenLayers.Control.DrawFeature(
                    self.printAreaLayer,                    
                    OpenLayers.Handler.RegularPolygon,{
                        handlerOptions: {
                            sides: 4,
                            irregular: true,  
                            keyMask: OpenLayers.Handler.MOD_CTRL,                                                       
                        }, 
                        featureAdded: function(f) {
                            remove = []   
                            for ( var i in self.printAreaLayer.features ) {
                                if ( self.printAreaLayer.features[i] != f ) {
                                    remove.push(self.printAreaLayer.features[i])                                        
                                }
                            }
                            if ( remove.length > 0 ) 
                                self.printAreaLayer.removeFeatures(remove);
                                
                            self.printBoundingBox = f.geometry.getBounds()
                            self.printBoundingBox.transform(new OpenLayers.Projection("EPSG:900913"),new OpenLayers.Projection("EPSG:4326"))                       
                        },                       
                    }
                );                    
                self.addControl(self.printAreaCtrl);                                                                
            },
            
            onPageOpen: function(pageNum) {
                if ( 0 == pageNum ) {
                    self.printAreaCtrl.activate()
                }
            },
            
            onPageClose: function(pageNum) {
                if ( 0 == pageNum ) {                
                    self.printAreaCtrl.deactivate()
                }
            },
            
            onClose: function() {
                self.removeControl(self.printAreaCtrl)
                self.removeLayer(self.printAreaLayer)
            },
            
            onFinish: function() {                                
                bounds = self.printBoundingBox.toArray()                                
                var measure = $('#print-measure').val();
                var format = $('#print-paper-format').val();
                var orientation = $('#print-paper-orientation').val();
                             
                window.open('pdfMap.html?M='+measure+'&x1='+bounds[0]+'&x2='+bounds[2]+'&y1='+bounds[1]+'&y2='+bounds[3]+'&marginX='+15+'&marginY='+15+'&minDPI='+150+'&o='+orientation+'&f='+format,'print',"width=300,height=150,menubar=no,resizable=no,location=no,status=no,toolbar=no,directories=no,scrollbars=no")
            }
        })

        
        $(document).bind('keydown', 'ctrl+p', function() {
            self.printDialog.open()
            return false;
        });  
        
        $(document).bind('keydown', '+', function() {
            self.zoomIn()
        });  
        
        $(document).bind('keydown', '-', function() {
            self.zoomOut()
        });  
        
        $(document).bind('keydown', 'left', function() {
            self.pan(-300,0)
        });
        
        $(document).bind('keydown', 'right', function() {
            self.pan(300,0)
        });
        
        $(document).bind('keydown', 'up', function() {
            self.pan(0,-300)
        });
        
        $(document).bind('keydown', 'down', function() {
            self.pan(0,300)
        });

        //this.menuHoverOut()
    }

});

map.init()



