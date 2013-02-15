// API key for http://openlayers.org. Please get your own at
// http://bingmapsportal.com/ and use that instead.
//var apiKey = "AqTGBsziZHIJYYxgivLBf0hVdrAk9mWO5cQcb8Yux8sW5M8c8opEC2lZqKR1ZZXf";

// initialize map when page ready
var map;
var gg = new OpenLayers.Projection("EPSG:4326");
var sm = new OpenLayers.Projection("EPSG:900913");

function get_my_url (bounds) {
	var res = this.map.getResolution();
	var x = Math.round ((bounds.left - this.maxExtent.left) / (res * this.tileSize.w));
	var y = Math.round ((this.maxExtent.top - bounds.top) / (res * this.tileSize.h));
	var z = this.map.getZoom();

	var path = z + "/" + x + "/" + y + "." + this.type; 
	var url = this.url;
	if (url instanceof Array) {
		url = this.selectUrl(path, url);
	}
	return url + path;
	
}

var init = function (onSelectFeatureFunction) {

    var geolocate = new OpenLayers.Control.Geolocate({
        id: 'locate-control',
        geolocationOptions: {
            enableHighAccuracy: false,
            maximumAge: 0,
            timeout: 7000
        }
    });
    
    
	var lonlat = new OpenLayers.LonLat(15.12,49.79);
	lonlat.transform(gg, sm);
    
    // create map
    map = new OpenLayers.Map({
        div: "map",
        theme: null,
        projection: sm,
        numZoomLevels: 15,
        controls: [
            new OpenLayers.Control.Attribution(),
            new OpenLayers.Control.TouchNavigation({
                dragPanOptions: {
                    enableKinetic: true
                }
            }),
            geolocate,
        ],
        layers: [
           
            new OpenLayers.Layer.OSM("Alpha", "tiles-alpha/", 
			new OpenLayers.Layer.OSM("Devel", "tiles/", {
					type: 'jpg', numZoomLevels: 15, getURL: get_my_url
			}),
			{
					type: 'png', numZoomLevels: 13, getURL: get_my_url
			}),                        
        ],
        center: lonlat,
        zoom: 8
    });

};
