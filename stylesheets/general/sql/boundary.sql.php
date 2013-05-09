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
	global $TILE;
	$db = explode('.',$TILE);
	$table = $db[0].'_'.$db[1];
	return "SELECT * FROM adminboundaries_$table WHERE admin_level=$level";			
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
			WHEN iucn_level IS NOT NULL AND btrim(iucn_level) IN ('I','Ia','Ib','1','1a','1b') THEN 1			
			WHEN iucn_level IS NOT NULL AND btrim(iucn_level) IN ('II','2') THEN 2
			WHEN iucn_level IS NOT NULL AND btrim(iucn_level) IN ('III','3') THEN 3
			WHEN iucn_level IS NOT NULL AND btrim(iucn_level) IN ('IV','4') THEN 4
			WHEN iucn_level IS NOT NULL AND btrim(iucn_level) IN ('V','5') THEN 5
			WHEN iucn_level IS NOT NULL AND btrim(iucn_level) IN ('VI','6') THEN 6
			WHEN iucn_level IS NOT NULL AND btrim(iucn_level) IN ('VII','7') THEN 7			
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
		protection_title,
		protection_object,
		protection_aim,
		protection_ban,
		protection_instruction,
		related_law,
		site_zone,
		valid_from,
		start_date,
		end_date,
		opening_hours,
		operator,
		governance_type,
		site_ownership,
		site_status,
		protection_award,
		contamination,
		ethnic_group,
		period,
		scale,
		ownership,
		owner,
		attribution,
		type,
		military,
		boundary,
		landuse,
		leisure,
		wikipedia,
		website,
		$cols
	FROM paboundary
	WHERE
		(boundary IN ('protected_area','national_park') OR
		landuse='military' OR
		leisure='nature_reserve' OR
		military IN ('danger_area','range')) AND	
		($where)
EOD;
}

function sql_boundary_pa_short($class) {	
	return "SELECT * FROM paboundaries WHERE protect_class=$class ORDER BY way_area DESC";			
}

function sql_boundary_pa_text_short() {	
	return "SELECT * FROM paboundaries WHERE name IS NOT NULL ORDER BY way_area DESC";			
}
