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
		name,
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

function sql_boundary_short_notrect($level) {	
	return "SELECT * FROM adminboundary WHERE admin_level=$level";			
}

function sql_boundary_pa($cols = '0',$where = '1 = 1') {	
	return <<<EOD
	SELECT
		way,			
		(CASE
			WHEN protect_class IS NOT NULL THEN protect_class
			WHEN iucn_level IS NOT NULL AND iucn_level = 'I' THEN 1
			WHEN iucn_level IS NOT NULL AND iucn_level = 'Ia' THEN 1
			WHEN iucn_level IS NOT NULL AND iucn_level = 'Ib' THEN 1
			WHEN iucn_level IS NOT NULL AND iucn_level = 'II' THEN 2
			WHEN iucn_level IS NOT NULL AND iucn_level = 'III' THEN 3
			WHEN iucn_level IS NOT NULL AND iucn_level = 'IV' THEN 4
			WHEN iucn_level IS NOT NULL AND iucn_level = 'V' THEN 5
			WHEN iucn_level IS NOT NULL AND iucn_level = 'VI' THEN 6
			WHEN iucn_level IS NOT NULL AND iucn_level = 'VII' THEN 7
			WHEN iucn_level IS NOT NULL THEN CAST(iucn_level AS integer)
			WHEN boundary = 'national_park' THEN 2
			WHEN leisure = 'nature_reserve' THEN 4
			WHEN military IS NOT NULL THEN 25 
			ELSE 0			
		END) AS protect_class,
		name,
		osm_id,	
		way_area,
			ST_Centroid(way) AS
		centroid,
		$cols
	FROM paboundary
	WHERE
		(boundary IN ('protected_area','national_park') OR
		landuse='military' OR
		leisure='nature_reserve' OR
		military IS NOT NULL) AND	
		($where)			
EOD;
}

function sql_boundary_pa_short($class) {	
	return "SELECT * FROM paboundary WHERE protect_class=$class";			
}
