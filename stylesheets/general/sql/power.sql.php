<?php
require_once "sql/_common.sql.php";
require_once "conf/sqlite.php";

function _getPowerColSql() {
	return "(CASE WHEN power='construction' THEN construction ELSE power END)";
}

function _getPowerGradeSql() {
	$powerCol = _getPowerColSql();
	
	return "
		(CASE
			WHEN $powerCol = 'line' THEN 1
			WHEN $powerCol = 'minor_line' THEN 2
		END)
	";
}

function sql_power($cols = '0',$where = '1 = 1',$order = 'z_order') {
	$layerSql = _getLayerSql();	
	$powerCol = _getPowerColSql();
	$powerGradeSql = _getPowerGradeSql();
return <<<EOD
    SELECT
	way,		
	    $powerGradeSql AS				
	grade,
	power,							    
	    $layerSql AS 
	layer,	
	osm_id,
	$cols
    FROM power
    WHERE
	    power IS NOT NULL	
	AND ($where)
EOD;
}

function sql_power_short($layer,$where = '1 = 1',$order = 'z_order') {
    return "SELECT * FROM powers WHERE layer = $layer";
}

function sql_power_point($cols = '0',$where = '1 = 1',$order = 'z_order') {
	$layerSql = _getLayerSql();
return <<<EOD
    SELECT
	way,
	osm_id, 
	power,							    
	$layerSql AS layer,
	$cols
    FROM power_point
    WHERE
	    power IN ('pole','tower')
	AND osm_id > 0
	AND ($where)
EOD;
}

function sql_power_point_short($layer,$where = '1 = 1',$order = 'z_order') {
    return "SELECT * FROM power_points WHERE layer = $layer";
}
