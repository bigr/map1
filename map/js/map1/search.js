var map1 = map1 || {}


map1.Search = $class({
    constructor: function(map) {
        var self = this
        this._map = map
        //this._forms = $(forms)        
        //this._forms.submit(function() { alert('tu'); return false; self.search(); return false; })
        this._whisperDelay = 200
        this._whisperTimer = false           
        this.whisperActive = []   
        this.searchResult = []            
        
        
        $('#panel-search #wayPoints').append(self.getForm())
        
    },
    
    search: function(query, i) {
        var self = this
        $.ajax({            
            url:"nominatim/search?q="+query+"&polygon=1&format=json&countrycodes=cz,sk,pl,at",
            success: function(data) {
                //data = $.parseJSON(data)
                var j = 0
                for ( var tmp in data ) {
                    if ( data[tmp].type != 'administrative' ) {
                        j = tmp
                        break
                    }
                }                
                    
                var loc = new OpenLayers.LonLat(data[j].lon,data[j].lat).transform(
                    new OpenLayers.Projection("EPSG:4326"),
                    self._map.getProjectionObject()
                )
                self._map.setCenter(loc)
                if ( undefined === i  ) {
                    self._map.routing.appendWayPoint(loc)
                }
                else {
                    self._map.routing.moveWayPoint(i,loc)
                }
            }
        })
        return false;
    },
    
    getForm: function () {
        var self = this
        var content = ich.searchitem({})       
        content.submit(function(obj) {
            var i =  $('form.search').index(content)            
            if ( i < $('form.search').length - 1 ) {
                self.search($(content).find('[name="query"]').val(),$('form.search').index(content)); return false; 
            }
            else {
                self.search($(content).find('[name="query"]').val()); return false; 
            }
        })               
        
        if ( undefined !== this._map.routing ) {
            content.find('.dosearch').attr('src','image/route-'+this._map.routing.vehicle+'.png')
            content.find('.vehicle ul [data-vehicle="'+this._map.routing.vehicle+'"]').hide()
            
            content.find('.vehicle ul li').click(function() {
                var query = $(content).find('[name="query"]').val()
                content.find('.vehicle ul [data-vehicle="'+self._map.routing.vehicle+'"]').show()
                self._map.routing.vehicle = $(this).attr('data-vehicle')                
                content.find('.dosearch').attr('src','image/route-'+self._map.routing.vehicle+'.png')
                content.find('.vehicle ul [data-vehicle="'+self._map.routing.vehicle+'"]').hide()
                
                if ( '' != query.replace(/^\s+|\s+$/g,"") ) {
                    self.search(query);
                }
                else {
                    $('#panel-search #wayPoints .search:last .searchQuery').focus()
                    self._map.routing.refresh()                                
                    self.updateRouteInfo()
                }                
            })
        }
        
        
        content.find('.close').click(function() {
            self._map.routing.removeWayPoint($('form.search').index(content))
            return false
        })  
        
        content.find('.add').click(function() {
            self._map.routing.insertWayPoint($('form.search').index(content))
            return false
        }) 
        
        content.find('[name="query"]').keyup(function(e) {
            switch ( e.keyCode ) {
                case 40:
                case 38:
                case 27:
                case 13:
                    return false                                    
                    
            }            
            self._scheduleWhisper($('form.search').index(content),$(content).find('[name="query"]').val()); 
        })
        
        content.find('[name="query"]').keydown(function(e) {
            switch ( e.keyCode ) {
                case 40:                    
                    self._whisperDown($('form.search').index(content))
                    return false
                case 38:
                    self._whisperUp($('form.search').index(content))
                    return false                
                case 27:                    
                    if ( !self.whisperActive[$('form.search').index(content)] ) {
                        content.find('[name="query"]').blur()
                    }
                    else {
                        self._removeWhisper($('form.search').index(content))
                    }
                    return false
                case 13:
                    self._removeWhisper($('form.search').index(content))
                    return self._whisperEnter($('form.search').index(content))
            }

        })   
        
        content.find('[name="query"]').blur(function() { 
            self._removeWhisper($('form.search').index(content)); 
        })
        
        content.find('[name="query"]').focus(function() { 
            this.select()
        })                
              
        return content
    },
    
    appendItem: function(loc) {
        var self = this            
        $('#panel-search #wayPoints').append(self.getForm())         
        $('#panel-search #wayPoints .search:last .searchQuery').focus()
        
        this.updateNumbers()
        this.updateRouteInfo()        
        
        loc.transform(  
            this._map.getProjectionObject(),
            new OpenLayers.Projection("EPSG:4326")
        )
        $.ajax({
            url:"nominatim/reverse?lat="+loc.lat+"&lon="+loc.lon+"&format=json&zoom=15",
            success: function(data) {                                
                //data = $.parseJSON(data)                       
                
                var name = self._parseDisplayName(data['display_name'])
                $('#panel-search .search').eq(-2).find('input[name="query"]').val(name[0])
                $('#panel-search #wayPoints .search').eq(-2).find('.info').html(name[1])                                
            }
        })
        
    },
    
    insertItem: function(i, loc) {   
        var self = this   
        
        this.getForm().insertAfter($('#panel-search .search:eq('+i+')'))
        $('#panel-search #wayPoints .search:eq('+(i+1)+') .searchQuery').focus()
        this.updateNumbers() 
        this.updateRouteInfo()
        
        loc.transform(  
            this._map.getProjectionObject(),
            new OpenLayers.Projection("EPSG:4326")
        )
        $.ajax({            
            url:"nominatim/reverse?lat="+loc.lat+"&lon="+loc.lon+"&format=json&zoom=15",
            success: function(data) {                
                //data = $.parseJSON(data)
                var name = self._parseDisplayName(data['display_name'])                
                $('#panel-search .search:eq('+ (i+1) + ') input[name="query"]').val(name[0])
                $('#panel-search .search:eq('+ (i+1) + ') input[name="query"]').select()
                $('#panel-search .search:eq('+ (i+1) + ') .info').html(name[1])
            }
        })
        
    },
    
    removeItem: function(i) {        
        $('#panel-search #wayPoints .search:eq('+i+')').remove()
        if ( $('#panel-search #wayPoints .search').length == 1 ) {
            $('#panel-search #wayPoints .search .dosearch').attr('src','image/search.png')
        }
        this.updateNumbers()  
        this.updateRouteInfo()      
    },
    
    modifyItem: function(i,loc) {  
        var self = this
        
        loc.transform(  
            this._map.getProjectionObject(),
            new OpenLayers.Projection("EPSG:4326")
        )
        $.ajax({            
            url:"nominatim/reverse?lat="+loc.lat+"&lon="+loc.lon+"&format=json&zoom=15",
            success: function(data) { 
                //data = $.parseJSON(data)                
                var name = self._parseDisplayName(data['display_name'])                                
                $('#panel-search .search:eq('+i+') input[name="query"]').val(name[0])
                $('#panel-search .search:eq('+i+') .info').html(name[1])
            }
        })
        this.updateRouteInfo()
    },
    
    updateNumbers: function() {
        $('#panel-search #wayPoints .search').each(function(i) {
            $(this).find('.number').attr('src','image/number'+(i+1)+'.png')
        })
    },
    
    updateRouteInfo: function() {
        if ( undefined !== this._map.routing ) {
            var self = this
            
            var distance = 0.0
            var time = 0.0
            for ( var i in this._map.routing.way ) { 
                if ( isNaN(i) ) continue;
                if  ( undefined !== this._map.routing.distances[i] ) {                    
                    distance += parseFloat(this._map.routing.distances[i])
                    time += parseFloat(this._map.routing.travelTimes[i])
                }
            }
            
            var itemsCount = $('#panel-search #wayPoints .search').length
            
            if ( itemsCount > 2 ) {
                var content = ich.routeinfo({
                    vehicle: this._map.routing.vehicle,
                    distance: Math.floor(distance),
                    hours: Math.floor((time/3600)),
                    minutes: Math.floor((time/60)%60)
                })
            }
            else if ( itemsCount == 2 ) {
                var content = ich.routeinfo({
                    vehicle: this._map.routing.vehicle                  
                })
            }
            else {
                var content = ''
            }

            $('#panel-search #routeInfo').html(content)                                        
            
        }
    },
    
    lock: function(searchLoadingIcon) {
        if ( undefined === searchLoadingIcon )
            searchLoadingIcon = true
        $('#panel-search .search .searchResult').css('display','none') 
        $('#panel-search .search .searchResult ul li.selected').removeClass('selected')
        if ( searchLoadingIcon ) {            
            $('#panel-search #routeInfo').html('<div class="loader"><img src="image/loader.gif"/></div>')
        }
        $('#panel-search input').attr('disabled','disabled') 
        $('#panel-search').addClass('disabled')
        $('#panel-search').css('cursor','wait')
    },
    
    unlock: function() {
        $('#panel-search #routeInfo').html('')
        $('#panel-search').removeClass('disabled')
        $('#panel-search input').removeAttr('disabled') 
        $('#panel-search').css('cursor','auto')
    },
    
    _scheduleWhisper: function(i, query) {
        var self = this
        this.whisperActive[i] = true
        if ( this.whisperTimer ) 
            clearTimeout(this._whisperTimer)
            
        this._whisperTimer = setTimeout(function() { self._makeWhisper(i,query) },this.whisperDelay);        
    },

    _makeWhisper: function(i, query) {        
        var self = this                
        $.ajax({            
            url:"nominatim/search?q="+query+"&addressdetails=1&format=json",
            success: function(data) {
                //data = $.parseJSON(data) 
                if ( !self.whisperActive[i] ) return
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
                        loc: new OpenLayers.LonLat(data[k].lon,data[k].lat).transform(
                            new OpenLayers.Projection("EPSG:4326"),
                            self._map.getProjectionObject()
                        )                       
                    });
                    var content = ich.searchresult({result: result})
                    
                    content.find('li').mouseenter(function(e) {
                        $(content).find('li').removeClass('selected')
                        $(this).addClass('selected')
                        return true
                    })
                    
                    content.find('li a').click(function(e) {                        
                        self._whisperEnter(i)
                        return false
                    })
                                        
                    
                    $('#panel-search .search:eq('+ (i) + ') .searchResult').html(content);
                    $('#panel-search .search:eq('+ (i) + ') .searchResult').css('display','block')
                }
                self.searchResult[i] = result
            }
        })
        
        return false;
    },
    
     _removeWhisper: function(i) {
         this.whisperActive[i] = false
         $('#panel-search .search:eq('+ (i) + ') .searchResult').css('display','none') 
         var obj = $('#panel-search .search:eq('+ (i) + ') .searchResult ul li.selected').removeClass('selected')
     },
     
     _whisperDown: function(i) {
         $('#panel-search .search:eq('+ (i) + ') .searchResult').css('display','block') 
         var obj = $('#panel-search .search:eq('+ (i) + ') .searchResult ul')
         var selected = obj.find('li.selected')
         var i = obj.find('li').index(selected)         
         if ( i == -1 ) {
             obj.find('li:first').addClass('selected')
         }
         else if ( i == obj.find('li').length - 1 ) {
         }
         else {
             obj.find('li').eq(i).removeClass('selected')
             obj.find('li').eq(i+1).addClass('selected')
         }
     },
     
     _whisperUp: function(i) {
         var obj = $('#panel-search .search:eq('+ (i) + ') .searchResult ul')
         var selected = obj.find('li.selected')
         var i = obj.find('li').index(selected)                  
         if ( i == -1 || i == 0 ) {
         }
         else {
             obj.find('li').eq(i).removeClass('selected')
             obj.find('li').eq(i-1).addClass('selected')
         }
     },
     
     _whisperEnter: function(i) {        
        var obj = $('#panel-search .search:eq('+ (i) + ') .searchResult ul')
        var selected = obj.find('li.selected')
        var j = obj.find('li').index(selected)
        if ( j == -1 ) {
            return true
        }
        else {            
            if ( i == $('#panel-search .search').length - 1 ) {
                this._map.routing.appendWayPoint(this.searchResult[i][j].loc)
            }
            else {
                this._map.routing.moveWayPoint(i,this.searchResult[i][j].loc)
            }
            this._removeWhisper(i)
            return false
        }
     },
     
     _parseDisplayName: function(name) {
         return [name.split(',')[0],name.split(',').slice(1).join()]
     }
});
