var map1 = map1 || {}

map1.PrintDialog = $class({
    Extends: map1.gui.Dialog,    
    
    constructor: function(map, id,id_handle,id_close,id_next,id_prev,id_finish) {         
        this.map = map
        map1.gui.Dialog.call(this, id,id_handle,id_close,id_next,id_prev,id_finish);
    },
    
    onOpen: function() {
        var self = this
        this.printAreaLayer = new OpenLayers.Layer.Vector("Box layer");
        this.map.addLayer(this.printAreaLayer)
        this.printAreaCtrl = new OpenLayers.Control.DrawFeature(
            this.printAreaLayer,                    
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
                        
                    self.printBoundingBox = f.geometry.getBounds().clone()
                    self.printBoundingBox.transform(
                        self.map.getProjectionObject(),
                        new OpenLayers.Projection("EPSG:4326")
                    )
                },                       
            }
        );
                
        if ( undefined !== this.map.routing ) {
            this.map.routing.lock(false,false)
        }
        
        if ( undefined !== this.map.routing && this.map.routing.wayPoints.length >= 2 ) {
            bounds = this.map.routing.vector.getDataExtent()
            bounds.top += bounds.getHeight()/10
            bounds.bottom -= bounds.getHeight()/10
            bounds.left -= bounds.getWidth()/10
            bounds.right += bounds.getWidth()/10            
        }
        else {
            var bounds = this.map.getExtent().clone()
            bounds.top -= bounds.getHeight()/12
            bounds.bottom += bounds.getHeight()/12        
            bounds.left += bounds.getWidth()/12
            bounds.right -= bounds.getWidth()/12
        }
        
        self.printBoundingBox = bounds.clone().transform(
            self.map.getProjectionObject(),
            new OpenLayers.Projection("EPSG:4326")
        )
        
        var f = new OpenLayers.Feature.Vector(new OpenLayers.Geometry.Polygon(
            new OpenLayers.Geometry.LinearRing([
                new OpenLayers.Geometry.Point(bounds.left, bounds.top),
                new OpenLayers.Geometry.Point(bounds.right, bounds.top),
                new OpenLayers.Geometry.Point(bounds.right, bounds.bottom),
                new OpenLayers.Geometry.Point(bounds.left, bounds.bottom)
            ])
        ))	    
	    this.printAreaLayer.addFeatures([f])
        
        this.map.addControl(this.printAreaCtrl);                                                                
    },
    
    onPageOpen: function(pageNum) {
        if ( 0 == pageNum ) {
            this.printAreaCtrl.activate()
        }
    },
    
    onPageClose: function(pageNum) {
        if ( 0 == pageNum ) {                
            this.printAreaCtrl.deactivate()
        }
    },
    
    onClose: function() {
        this.map.removeControl(this.printAreaCtrl)
        this.map.removeLayer(this.printAreaLayer)
        
        if ( undefined !== this.map.routing ) {
            this.map.routing.unlock()
        }
    },
    
    onFinish: function() {                                
        bounds = this.printBoundingBox.toArray()                                
        var measure = $('#print-measure').val();
        var format = $('#print-paper-format').val();
        var orientation = $('#print-paper-orientation').val();
                     
        window.open('pdfMap.html?scale='+measure+'&x1='+bounds[0]+'&x2='+bounds[2]+'&y1='+bounds[1]+'&y2='+bounds[3]+'&overlapX='+15+'&overlapY='+15+'&minDPI='+150+'&o='+orientation+'&f='+format,'print',"width=300,height=150,menubar=no,resizable=no,location=no,status=no,toolbar=no,directories=no,scrollbars=no")
    }
});
