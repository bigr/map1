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
