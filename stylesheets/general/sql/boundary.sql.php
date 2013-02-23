<?php
require_once "inc/utils.php";
require_once "conf/pgis.php";
require_once "conf/boundary.conf.php";
require_once "sql/_common.sql.php";

function _getBoundaryWaySql() {
	$SIM = array(8 =>1200, 9 => 800, 10 => 500, 11 => 300, 12 => 150, 13 => 70);
	$zoom = end($GLOBALS['RENDER_ZOOMS']);
	return !empty($SIM[$zoom])
		? "ST_simplify(way,{$SIM[$zoom]})"
		: 'way';
	
}

function sql_boundary($cols = '0',$where = '1 = 1',$order = 'z_order') {	
	$waySql = _getBoundaryWaySql();
return <<<EOD
	(SELECT
		way,			
		admin_level,
		osm_id,
		$cols
	FROM adminboundary
	WHERE			
		($where)		
	ORDER BY $order)
EOD;
}

function sql_boundary_short($level) {	
	return "SELECT * FROM adminboundaries WHERE admin_level=$level";			
}

function sql_boundary_pa($cols = '0',$where = '1 = 1') {	
	return <<<EOD
	SELECT
		way,			
		(CASE
			WHEN protect_class IS NOT NULL THEN protect_class
			WHEN boundary = 'national_park' THEN 2
			WHEN military IS NOT NULL THEN 25 
			ELSE 0			
		END) AS protect_class,
		name,
		osm_id,		
		$cols
	FROM paboundary
	WHERE
		(boundary IN ('protected_area','national_park') OR
		landuse='military' OR
		boundary='national_park' OR
		military IS NOT NULL) AND	
		($where)			
EOD;
}
