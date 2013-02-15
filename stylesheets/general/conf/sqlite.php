<?php

function ds_sqlite($table, $geometry_field = 'way', $key_field = 'osm_id') {
	global $TILE;
	return '"Datasource": ' . json_encode(array(
		'file'              => "/home/klinger/mymap/data/tiles/sqlite/$TILE.db",
		'table'             => $table,
		'type'              => 'sqlite',
		'wkb_format'        => 'spatialite',
		'use_spatial_index' => 'false',
		'geometry_field'    => $geometry_field,
		'key_field'         => $key_field,		
		'srid'              => '+proj=longlat +ellps=WGS84 +datum=WGS84 +no_defs',		
	));
}
