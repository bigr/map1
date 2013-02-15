<?php
$PGIS_TBL_PREFIX = 'planet_osm';

function ds_pgis($table, $geometry_field = 'way') {
	return '"Datasource": ' . json_encode(array(
		'table'           => '(' . trim($table) . ') AS data',
		'type'            => 'postgis',
		'password'        => 'eGo31415EgO',
		'host'            => 'localhost',
		'port'            => 5432,
		'user'            => 'klinger',
		'dbname'          => 'gis_pl',
		'estimate_extent' => false,
		'extent'          => '-20037508,-19929239,20037508,19929239',
		'geometry_field'  => $geometry_field,
		'srid'            => 900913,
	));
}

$PGIS_TBL_POINT = $PGIS_TBL_PREFIX . '_point';
$PGIS_TBL_LINE = $PGIS_TBL_PREFIX . '_line';
$PGIS_TBL_ROAD = $PGIS_TBL_PREFIX . '_road';
$PGIS_TBL_POLYGON = $PGIS_TBL_PREFIX . '_polygon';
$PGIS_TBL_ROUTE = $PGIS_TBL_PREFIX . '_routes2';
$PGIS_TBL_CONTOUR = 'contours';

