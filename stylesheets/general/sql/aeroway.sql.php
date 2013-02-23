<?php
require_once "inc/utils.php";
require_once "conf/pgis.php";
require_once "conf/sqlite.php";
require_once "conf/aeroway.conf.php";
require_once "sql/_common.sql.php";


function sql_aeroway($where = '1 = 1',$order = 'z_order') {
	global $AEROWAY;
	$layerSql = _getLayerSql();
	$propertyWhereQuery = getPropertyWhereQuery($AEROWAY);
return <<<EOD
    SELECT
	way,		
	aeroway,	    
	    $layerSql as 
	layer,
	osm_id
    FROM aeroway
    WHERE
		    ($propertyWhereQuery)
	    AND ($where)
EOD;
}

function sql_aeroway_short($layer,$where = '1 = 1',$order = 'z_order') {
    return "SELECT * FROM aeroways WHERE layer = $layer";
}


function sql_aeroarea($cols = '0',$where = '1 = 1',$order = 'z_order') {
	global $AEROAREA;
	$layerSql = _getLayerSql();
	$propertyWhereQuery = getPropertyWhereQuery($AEROAREA);
return <<<EOD
    SELECT
	way,	  
	aeroway,	  
	($layerSql) AS layer,
	osm_id,
	way_area,
	$cols
    FROM aeroarea
    WHERE
	    	($propertyWhereQuery)
		AND ($where)
EOD;
}


function sql_aeroarea_short($layer, $cols = '0',$where = '1 = 1',$order = 'z_order') {
    return "SELECT * FROM aeroareas WHERE layer = $layer";
}
