var map1 = map1 || {}
map1.utfgrid = map1.utfgrid || {}

map1.utfgrid.Layer = OpenLayers.Class(OpenLayers.Layer.UTFGrid,{
    initialize: function(options) {
        options = options || {}
        options = OpenLayers.Util.extend({           
            utfgridResolution: 4,
            displayInLayerSwitcher: false,
            sphericalMercator: true,
            projection: new OpenLayers.Projection("EPSG:900913"),
            displayProjection: new OpenLayers.Projection("EPSG:4326"), 
        }, options); 
        OpenLayers.Layer.UTFGrid.prototype.initialize.apply(this, [options]); 
        this.infoPopup = false       
    }
});

map1.utfgrid.ControlMouseMove =  OpenLayers.Class(OpenLayers.Control.UTFGrid,{
    initialize: function(map,options) {
        var self = this        
        this.infoPopup = false
        this.map = map        
        options = options || {}
        options = OpenLayers.Util.extend({            
            handlerMode: 'move',
            callback: function(infoLookup) { self.onMouseMove(infoLookup) }
        }, options); 
        OpenLayers.Control.UTFGrid.prototype.initialize.apply(this, [options]);                             
    },
    
    onMouseMove: function(infoLookup) { 
        var self = this
        
        if ( this.map.isLocked() ) return
               
        if ( undefined == infoLookup[1] || undefined === infoLookup[1]['data'] ) {          
            $('#map').css('cursor','auto')
            if ( this.infoPopup != false) {
                if ( this.infoPopup.timeOut ) {
                    clearTimeout(this.infoPopup.timeOut)
                    this.infoPopup.timeOut = null
                }
                else {
                    $('#gridinfo .current').hide()
                    $('#gridinfo .current').html('')
                    this.infoPopup = false
                    //this.map.removePopup(this.infoPopup)
                }
            }            
            
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

        var data = {features: []}
        for ( i in infoLookup[1]['data'] ) {
            data['features'][i] = {tags: []}            
            for ( prop in infoLookup[1]['data'][i] ) {
                if (infoLookup[1]['data'][i].hasOwnProperty(prop)) {
                    if (prop == 'wikipedia') {
                        data['features'][i]['wikipedia'] = infoLookup[1]['data'][i][prop].replace(':','.wikipedia.org/wiki/')
                    }
                    else if (prop == 'name' ) {
                        data['features'][i]['name'] = infoLookup[1]['data'][i][prop]
                    }
                    else if (prop == 'osm_id' ) {
                        data['features'][i]['osm_id'] = infoLookup[1]['data'][i][prop]
                    }
                    else if (prop == 'website' ) {
                        data['features'][i]['website'] = infoLookup[1]['data'][i][prop]
                    }
                    else if (prop == 'way_area' ) {
                        data['features'][i]['way_area'] = infoLookup[1]['data'][i][prop]
                    }
                    else {
                        data['features'][i]['tags'].push({'key':prop,'val':infoLookup[1]['data'][i][prop]})
                    }
                }
            }
        }
        /*
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
        */
        var content = ich.featureinfo(data)    
        content = jQuery('<div>').append(content)
        this.map.i18n.translate(content)
        content = content.html()
        $('#gridinfo .current').html(content)
        $('#gridinfo .current').show()
        this.infoPopup = {timeOut: 100}
        /*
        if ( !this.infoPopup ) {
        
            this.infoPopup = new OpenLayers.Popup("featureinfo",
                null,
                new OpenLayers.Size(300,150),
                content,
                false
            );
            
            //this.infoPopup.moveTo(new OpenLayers.Pixel(this.map.maxPx.x-320,this.map.maxPx.y-175));
            this.infoPopup.timeOut = setTimeout(function() {
                self.map.addPopup(self.infoPopup);
                $(self.infoPopup.div).offset({top: $(document).height() - 170, left: $(document).width() - 320})
                self.infoPopup.timeOut = null
            },250)
                        
        }
        else {
            this.infoPopup.setContentHTML(content)
            //this.infoPopup.moveTo(new OpenLayers.Pixel(this.map.maxPx.x-320,this.map.maxPx.y-175));
            //this.infoPopup.lonlat = arguments[1]
            //this.infoPopup.updatePosition()                
        }
        * */
        /*
        var offset = $(this.infoPopup.div).offset()
                
        $(this.infoPopup.div).offset({left:offset.left+16,top:offset.top+16})
        */
        //$(this.infoPopup.div).css('background','none')
         
    }
});

map1.utfgrid.ControlClick =  OpenLayers.Class(OpenLayers.Control.UTFGrid,{
    initialize: function(map,options) {
        var self = this
        this.map = map
        options = options || {}
        options = OpenLayers.Util.extend({            
            handlerMode: 'click',
            callback: function(infoLookup) { self.onClick(infoLookup) }
        }, options); 
        OpenLayers.Control.UTFGrid.prototype.initialize.apply(this, [options]);                
    },
    onClick: function(infoLookup) {                
        $('#gridinfo .sticked').html($('#gridinfo .current').html())
        $('#gridinfo .current').html('')
        //if ( undefined != infoLookup[1] && undefined != infoLookup[1]['data'] && null != infoLookup[1]['data']['wiki'] ) {
        //    window.open('http://cs.wikipedia.org/wiki/'+infoLookup[1]['data']['wiki'], 'Wikipedie', '')
        //}    
    }
    
});










