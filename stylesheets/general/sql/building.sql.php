<?php
require_once "inc/utils.php";
require_once "conf/building.conf.php";
require_once "sql/_common.sql.php";

function sql_building($cols = '0',$where = '1 = 1',$order = 'z_order') {
	$isBridgeSql = _isBridgeSql();
	$isTunnelSql = _isTunnelSql();
return <<<EOD
	SELECT
		way,
		osm_id,
		$cols
	FROM building
	WHERE			
		building IS NOT NULL
		AND NOT ($isBridgeSql)
		AND NOT ($isTunnelSql)
		AND building NOT IN ('bridge','tunnel')
		AND ($where)	
EOD;
}


function sql_building_short($where = '1 = 1',$order = 'z_order') {
    return "SELECT * FROM buildings";
}
