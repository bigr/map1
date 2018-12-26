<?php
function ds_shapefile_raw($file) {
	return '"Datasource": ' . json_encode(array(
		'file'            => trim($file),
		'type'            => 'shape',
		'encoding'        => 'latin1',
	));
}

function ds_shapefile($file) {
	return '"Datasource": ' . json_encode(array(
		'file'            => '/root/map1/shp/'.trim($file).'.shp',
		'type'            => 'shape',
		'encoding'        => 'latin1',
	));
}

function ds_osmfile($file) {
	return '"Datasource": ' . json_encode(array(
		'file'            => '/root/map1/shp/'.trim($file).'.osm',
		'type'            => 'osm',		
	));
}
