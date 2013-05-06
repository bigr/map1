<?php
require_once "inc/utils.php";
require_once "conf/pgis.php";
require_once "conf/accessarea.conf.php";
require_once "sql/_common.sql.php";

function sql_accessarea($cols = '0',$where = '1 = 1',$order = 'z_order') {
	global $ACCESSAREA;
	$propertyWhereQuery = getPropertyWhereQuery($ACCESSAREA)	;
return <<<EOD
	SELECT
		osm_id,
		way,
			COALESCE(access,CAST('null' AS text)) AS
		access,		
		name,
		way_area,
			ST_Centroid(way) AS
		centroid,
		$cols
	FROM accessarea
	WHERE
			($propertyWhereQuery)
		AND ($where)
	ORDER BY way_area DESC
EOD;
}

function sql_accessarea_short($cols = '0',$where = '1 = 1',$order = 'z_order') {
	return "SELECT * FROM accessareas WHERE layer = $layer";
}
