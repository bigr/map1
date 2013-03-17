var map1 = map1 || {}


map1.Search = $class({
    constructor: function(map) {
        var self = this
        this._map = map        
        this._whisperDelay = 300
        this._whisperTimer = false
        this.whisperActive = []   
        this.searchResult = []            
        
        this.whisperXhr = false
        
        $('#panel-search #wayPoints').append(self.getForm())
        
    },
    
    search: function(query, i) {
        var self = this       
        $.ajax({            
            url:"/nominatim/search?q="+query+"&polygon=0&addressdetails=1&format=json",
            success: function(data) {                
                    
                var loc = new OpenLayers.LonLat(data[0].lon,data[0].lat).transform(
                    new OpenLayers.Projection("EPSG:4326"),
                    self._map.getProjectionObject()
                )
                
                var nm = self._parseDisplayName(data[0]['address'])                                
                
                self._map.setCenter(loc)
                if ( undefined === i  ) {
                    $('#panel-search .search').eq(-1).find('input[name="query"]').val(nm[0])
                    $('#panel-search #wayPoints .search').eq(-1).find('.info').html(nm[1]) 
                    self._map.routing.appendWayPoint(loc,false)
                   
                }
                else {
                    $('#panel-search .search:eq('+i+') input[name="query"]').val(nm[0])
                    $('#panel-search .search:eq('+i+') .info').html(nm[1])
                    self._map.routing.moveWayPoint(i,loc,false)                   
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
                    ret = self._whisperEnter($('form.search').index(content))
                    self._removeWhisper($('form.search').index(content))
                    return ret; 
            }

        })   
        
        
        content.find('[name="query"]').blur(function() { 
            setTimeout(function() {  self._removeWhisper($('form.search').index(content));  },self._whisperDelay);    
        })
         
        
        content.find('[name="query"]').focus(function() { 
            this.select()
        })                
              
        return content
    },
    
    appendItem: function(loc, updateInput) {
        var self = this            
        $('#panel-search #wayPoints').append(self.getForm())         
        $('#panel-search #wayPoints .search:last .searchQuery').focus()
        
        this.updateNumbers()
        this.updateRouteInfo()        
         
        
        if ( updateInput == undefined || updateInput == true ) {        
            loc.transform(  
                this._map.getProjectionObject(),
                new OpenLayers.Projection("EPSG:4326")
            )        
            var language = window.navigator.userLanguage || window.navigator.language
            $.ajax({            
                url:"/nominatim/reverse?lat="+loc.lat+"&lon="+loc.lon+"&format=json&accept-language="+language,
                success: function(data) {                
                    var nm = self._parseDisplayName(data['address'])
                    $('#panel-search .search').eq(-2).find('input[name="query"]').val(nm[0])
                    $('#panel-search #wayPoints .search').eq(-2).find('.info').html(nm[1])                                
                }
            })
        }
        
    },
    
    insertItem: function(i, loc, updateInput) {   
        var self = this   
        
        this.getForm().insertAfter($('#panel-search .search:eq('+i+')'))
        $('#panel-search #wayPoints .search:eq('+(i+1)+') .searchQuery').focus()
        this.updateNumbers() 
        this.updateRouteInfo()
        
        if ( updateInput == undefined || updateInput == true ) {    
            loc.transform(  
                this._map.getProjectionObject(),
                new OpenLayers.Projection("EPSG:4326")
            )
            var language = window.navigator.userLanguage || window.navigator.language
            $.ajax({                
                url:"/nominatim/reverse?lat="+loc.lat+"&lon="+loc.lon+"&format=json&accept-language="+language,
                success: function(data) {                        
                    var nm = self._parseDisplayName(data['address'])                
                    $('#panel-search .search:eq('+ (i+1) + ') input[name="query"]').val(nm[0])
                    $('#panel-search .search:eq('+ (i+1) + ') input[name="query"]').select()
                    $('#panel-search .search:eq('+ (i+1) + ') .info').html(nm[1])
                }
            })
        }
        
    },
    
    removeItem: function(i) {        
        $('#panel-search #wayPoints .search:eq('+i+')').remove()
        if ( $('#panel-search #wayPoints .search').length == 1 ) {
            $('#panel-search #wayPoints .search .dosearch').attr('src','image/search.png')
        }
        this.updateNumbers()  
        this.updateRouteInfo()      
    },
    
    modifyItem: function(i,loc,updateInput) {  
        var self = this        
        loc.transform(  
            this._map.getProjectionObject(),
            new OpenLayers.Projection("EPSG:4326")
        )
        if ( updateInput == undefined || updateInput == true ) {  
            language = window.navigator.userLanguage || window.navigator.language
            $.ajax({                      
                url:"/nominatim/reverse?lat="+loc.lat+"&lon="+loc.lon+"&format=json&accept-language="+language,
                success: function(data) {                         
                    var nm = self._parseDisplayName(data['address'])                                
                    $('#panel-search .search:eq('+i+') input[name="query"]').val(nm[0])
                    $('#panel-search .search:eq('+i+') .info').html(nm[1])
                }
            })
            this.updateRouteInfo()
        }
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
        
        if ( this.whisperXhr ) {
            this.whisperXhr.abort()
            this.whisperXhr = false
        }
            
        this._whisperTimer = setTimeout(function() { self._makeWhisper(i,query) },this._whisperDelay);        
    },

    _makeWhisper: function(i, query) {        
        var self = this 
        if ( this.whisperXhr ) {
            this.whisperXhr.abort()
            this.whisperXhr = false
        }
        $('#panel-search .search:eq('+ (i) + ') .searchResult').html('<div class="loader"><img src="image/loader_light.gif"/></div>')
        this.whisperXhr = $.ajax({
            url:"/nominatim/search?q="+query+"&addressdetails=1&format=json",
            success: function(data) {                
                if ( !self.whisperActive[i] ) return
                result = []                
                for ( var k in data ) {
                    if ( data[k].class == 'boundary' && data[k].type == 'administrative' ) { 
                        if (  data[k].importance > 0.7 )                                              
                            data[k].type = 'city';
                        else if (  data[k].importance > 0.55 )                                              
                            data[k].type = 'town';
                        else if (  data[k].importance > 0.4 )
                            data[k].type = 'village';
                        else
                            data[k].type = 'hamlet';
                    }                    
                    if ( data[k].class == 'highway' ) {
                        data[k].type = 'highway_' + data[k].type;
                    }
                    
                    if ( data[k].type == 'house' ) {
                        house = true
                    }
                    else {
                        house = false
                    }
                    
                    
                    nm = self._parseDisplayName(data[k].address)                                                                               
                    
                    result.push({
                        key: nm[0],
                        locality: nm[1],
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
                    
                }
                
                
                $('#panel-search .search:eq('+ (i) + ') .searchResult').css('display','block')
                
                
                
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
             this._removeWhisper(i)
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
            var nm = [this.searchResult[i][j].key,this.searchResult[i][j].locality]          
            if ( i == $('#panel-search .search').length - 1 ) {
                $('#panel-search .search').eq(-1).find('input[name="query"]').val(nm[0])
                $('#panel-search #wayPoints .search').eq(-1).find('.info').html(nm[1]) 
                this._map.routing.appendWayPoint(this.searchResult[i][j].loc,false)
            }
            else {
                $('#panel-search .search:eq('+i+') input[name="query"]').val(nm[0])
                $('#panel-search .search:eq('+i+') .info').html(nm[1])
                this._map.routing.moveWayPoint(i,this.searchResult[i][j].loc,false)
            }
            this._removeWhisper(i)
            
            return false
        }
     },
     
     _parseDisplayName: function(address) {               
       
        urb = address['city']
        if ( undefined == urb ) {
            urb = address['town']
        }
        if ( undefined == urb ) {
            urb = address['village']
        }
        if ( undefined == urb ) {
            urb = address['hamlet']
        }
        if ( undefined == urb ) {
            urb = address['locality']
        }
        
        suburb = address['neighbourhood']
        if ( undefined == suburb ) {
            suburb = address['city_district']
        }
        if ( undefined == suburb ) {
            suburb = address['suburb']
        }
        
        road = address['road']
        if ( undefined == road ) {
            road = address['footway']
        }
        if ( undefined == road ) {
            road = address['pedestrian']
        }
        if ( undefined == road ) {
            road = address['residential']
        }
        
        if ( road != undefined && !isNaN(road.split(' ')[0]) ) {
            road = undefined
        }
        
        locality = null        
        if ( address['county'] != undefined && address['county'].indexOf(urb) == -1 ) {
            locality = address['county']
        }
        else if ( address['county'] == undefined && address['state_district'] != undefined && address['state_district'].indexOf(desc) == -1 ) {
            locality = address['state_district']
        }
        else if ( address['county'] == undefined && address['state_district'] == undefined && address['state'] != undefined && address['state'].indexOf(desc) == -1 ) {
            locality = address['state']
        }
       
        place = null
        
        if ( address['restaurant'] != undefined )
            place = 'restaurant';
        if ( address['cafe'] != undefined )
            place = 'cafe';
        if ( address['bar'] != undefined )
            place = 'bar';
        if ( address['pub'] != undefined )
            place = 'pub';
        if ( address['nightclub'] != undefined )
            place = 'nightclub';                        
        if ( address['clothes'] != undefined )
            place = 'clothes';
        if ( address['museum'] != undefined )
            place = 'museum';
        if ( address['cinema'] != undefined )
            place = 'cinema';
        if ( address['theatre'] != undefined )
            place = 'theatre';
        if ( address['bus_stop'] != undefined )
            place = 'bus_stop';
        if ( address['tram_stop'] != undefined )
            place = 'tram_stop';
        if ( address['hospital'] != undefined )
            place = 'hospital';
        if ( address['pharmacy'] != undefined )
            place = 'pharmacy';        
        if ( address['public_building'] != undefined )
            place = 'public_building';
        if ( address['building'] != undefined )
            place = 'building';
        if ( address['convenience'] != undefined )
            place = 'convenience';
        if ( address['supermarket'] != undefined )
            place = 'supermarket';
        if ( address['stationery'] != undefined )
            place = 'stationery';
        if ( address['chemist'] != undefined )
            place = 'chemist';
        if ( address['nature_reserve'] != undefined )
            place = 'nature_reserve';
        if ( address['cave_entrance'] != undefined )
            place = 'cave_entrance';
        if ( address['forest'] != undefined )
            place = 'forest';
        if ( address['river'] != undefined )
            place = 'river';
        if ( address['stream'] != undefined )
            place = 'stream';
         if ( address['water'] != undefined )
            place = 'water';
        if ( address['peak'] != undefined )
            place = 'peak';
        if ( address['reservoir'] != undefined )
            place = 'reservoir';
        if ( address['reservoir'] != undefined )
            place = 'reservoir';
        if ( address['industrial'] != undefined )
            place = 'industrial';
        if ( address['place_of_worship'] != undefined )
            place = 'place_of_worship';
        if ( address['memorial'] != undefined )
            place = 'memorial';
        if ( address['monument'] != undefined )
            place = 'monument';
        if ( address['station'] != undefined )
            place = 'station';
        if ( address['attraction'] != undefined )
            place = 'attraction';
                
        
        if ( place != undefined ) {
            name = address[place] + ' (' + place  + ')'
            desc = ''
            if ( urb !== null ) {
                desc = urb
            }   
                        
            if ( locality !== null ) {
                if ( desc != '' ) {
                    desc += ', ';
                }
                desc += locality
            }          
             
            desc += ', ' + address['country']
        }
        else if ( address['house_number'] != undefined  ) {  
            if ( road != undefined )
                name = road + ' ' + address['house_number']
            else
                name = urb + ' ' + address['house_number']
              
            desc = ''
            if ( urb !== null ) {
                desc = urb
            }   
                        
            if ( locality !== null ) {
                if ( desc != '' ) {
                    desc += ', ';
                }
                desc += locality
            }          
                                                                         
            desc += ', ' + address['country']
             
            
        }
                
        else if ( road != undefined ) {            
            name = road
              
            desc = ''
            if ( urb !== null ) {
                desc = urb
            }   
                        
            if ( locality !== null ) {
                if ( desc != '' ) {
                    desc += ', ';
                }
                desc += locality
            }          
                                                                         
            desc += ', ' + address['country']
        } 
        else if ( suburb !== undefined && suburb != urb ) {
            name = suburb
            
            desc = ''
            if ( urb !== null ) {
                desc = urb
            }   
                        
            if ( locality !== null ) {
                if ( desc != '' ) {
                    desc += ', ';
                }
                desc += locality
            }          
                                                                         
            desc += ', ' + address['country']
        }       
        else if ( urb !== undefined ) {
            name = urb
             
            desc = '';
            if ( locality !== null ) {
                desc = locality
            }
            if ( desc != '' ) {
                desc += ', ';
            }
                                                                         
            desc += address['country']            
        }
        else {            
            name = locality
            desc = address['country']
        }        
        
        return [name,desc]
     }
});
