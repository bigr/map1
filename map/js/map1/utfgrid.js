var map1 = map1 || {}
map1.utfgrid = map1.utfgrid || {}

map1.utfgrid.Layer = OpenLayers.Class(OpenLayers.Layer.UTFGrid,{
    initialize: function(options) {
        options = options || {}
        options = OpenLayers.Util.extend({           
            utfgridResolution: 4,
            displayInLayerSwitcher: false
        }, options); 
        OpenLayers.Layer.UTFGrid.prototype.initialize.apply(this, [options]);        
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
        
        if ( this.map.isLocked ) return
               
        if ( undefined == infoLookup[1] || undefined === infoLookup[1]['data'] ) {
            $('#map').css('cursor','auto')
            if ( this.infoPopup ) {
                if ( this.infoPopup.timeOut ) {
                    clearTimeout(this.infoPopup.timeOut)
                    this.infoPopup.timeOut = null
                }
                else {
                    this.map.removePopup(this.infoPopup)
                }
            }
            this.infoPopup = false
            
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
        this.map.i18n.translate(content)
        content = content.html()
        
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
        /*
        var offset = $(this.infoPopup.div).offset()
                
        $(this.infoPopup.div).offset({left:offset.left+16,top:offset.top+16})
        */
        $(this.infoPopup.div).css('background','none')
         
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
        if ( undefined != infoLookup[1] && undefined != infoLookup[1]['data'] && null != infoLookup[1]['data']['wiki'] ) {
            window.open('http://cs.wikipedia.org/wiki/'+infoLookup[1]['data']['wiki'], 'Wikipedie', '')
        }    
    }
    
});










