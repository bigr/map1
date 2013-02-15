<?php
require_once "inc/utils.php";
require_once "conf/pgis.php";
require_once "conf/sqlite.php";
require_once "conf/aerialway.conf.php";
require_once "sql/_common.sql.php";


function sql_aerialway($where = '1 = 1',$order = 'z_order') {
	global $AERIALWAY;
	$layerSql = _getLayerSql();
	$propertyWhereQuery = getPropertyWhereQuery($AERIALWAY);
return <<<EOD
    SELECT
	way,		
	aerialway,
	    COALESCE("piste:lift",'no') AS
	"piste:lift",
	    $layerSql as 
	layer,
	osm_id
    FROM aerialway
    WHERE
		    ($propertyWhereQuery)
	    AND ($where)
EOD;
}

function sql_aerialway_short($layer,$where = '1 = 1',$order = 'z_order') {
    return "SELECT * FROM aerialways WHERE layer = $layer";
}


function sql_aerialway_point($cols = '0',$where = '1 = 1',$order = 'z_order') {
	$layerSql = _getLayerSql();
return <<<EOD
    SELECT
	way,	  
	aerialway,
	    COALESCE("piste:lift",'no') AS
	"piste:lift",
	(($layerSql) - 1) AS layer,
	osm_id,
	$cols
    FROM aerialway_point
    WHERE
	    aerialway IN ('pylon')
	AND ($where)
EOD;
}


function sql_aerialway_point_short($layer, $cols = '0',$where = '1 = 1',$order = 'z_order') {
    return "SELECT * FROM aerialway_points WHERE layer = $layer";
}
