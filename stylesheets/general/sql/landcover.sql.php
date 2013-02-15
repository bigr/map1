<?php
require_once "inc/utils.php";
require_once "conf/pgis.php";
require_once "conf/landcover.conf.php";
require_once "sql/_common.sql.php";

function sql_landcover($cols = '0',$where = '1 = 1',$order = 'z_order') {
	global $LANDCOVER;
	$propertyWhereQuery = getPropertyWhereQuery($LANDCOVER)	;
return <<<EOD
	SELECT
		way,
			COALESCE(landuse,CAST('no' AS text)) AS
		landuse,
			COALESCE("natural",CAST('no' AS text)) AS
		natural,
			COALESCE(leisure,CAST('no' AS text)) AS
		leisure,
			COALESCE(amenity,CAST('no' AS text)) AS
		amenity,
		sport,
		way_area,
		$cols
	FROM landcover
	WHERE
				($propertyWhereQuery)
			AND building IS NULL
			AND ($where)	
EOD;
}

function sql_residentialcover_hack($cols = '0',$where = '1 = 1',$order = 'z_order') {	
return <<<EOD
	SELECT
		way,
		$cols
	FROM residential
	WHERE ($where)
	ORDER BY $order
EOD;
}

function sql_placescover($cols = '0',$where = '1 = 1') {    
return "   
    SELECT way,grade FROM place WHERE type='urb'
";
}
