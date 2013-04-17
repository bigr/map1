<?php
require_once "inc/utils.php";
require_once "conf/pgis.php";
require_once "conf/sqlite.php";
require_once "conf/barrier.conf.php";
require_once "sql/_common.sql.php";


function sql_barrier($where = '1 = 1',$order = 'z_order') {
	global $BARRIER;
	$layerSql = _getLayerSql();
	$propertyWhereQuery = getPropertyWhereQuery($BARRIER);
return <<<EOD
    SELECT
	way,		
	barrier,
	    $layerSql AS
	layer,
	osm_id
    FROM barrier
    WHERE
		($propertyWhereQuery)	
	AND ($where)
EOD;
}


function sql_barrier_short($layer,$where = '1 = 1',$order = 'z_order') {
    return "SELECT * FROM barriers WHERE layer = $layer";
}


function sql_barrier_point($cols = '0',$where = '1 = 1',$order = 'z_order') {
	global $BARRIERPOINT;
	$layerSql = _getLayerSql();
	
	$propertyWhereQuery = getPropertyWhereQuery($BARRIERPOINT);
return <<<EOD
    SELECT
	way,
	osm_id, 
	barrier,							    
	$layerSql AS layer,
	name,
	$cols	
    FROM barrier_point
    WHERE
	($propertyWhereQuery)			
	AND ($where)	
EOD;
}

function sql_barrier_point_short($layer,$where = '1 = 1',$order = 'z_order') {
    return "SELECT * FROM barrier_points WHERE layer = $layer";
}
