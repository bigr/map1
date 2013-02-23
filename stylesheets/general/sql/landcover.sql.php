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
		osm_id,
		way,
			COALESCE(landuse,CAST('no' AS text)) AS
		landuse,
			COALESCE("natural",CAST('no' AS text)) AS
		natural,
			COALESCE(leisure,CAST('no' AS text)) AS
		leisure,
			COALESCE(amenity,CAST('no' AS text)) AS
		amenity,
		COALESCE(place,CAST('no' AS text)) AS
			place,
		sport,
		COALESCE(wood,type,CAST('no' AS text)) AS wood,
		COALESCE(religion,CAST('no' AS text)) AS religion,
		name,
		way_area,
		$cols
	FROM landcover
	WHERE
				($propertyWhereQuery)
			AND building IS NULL
			AND ($where)	
	ORDER BY way_area DESC
EOD;
}

function sql_landcover_line($cols = '0',$where = '1 = 1',$order = 'z_order') {
	global $LANDCOVER_LINE;
	$propertyWhereQuery = getPropertyWhereQuery($LANDCOVER_LINE);
	return <<<EOD
	SELECT
		osm_id,
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
		COALESCE(wood,type,CAST('no' AS text)) AS wood,
		name,		
	$cols
	FROM landcover_line
	WHERE
				($propertyWhereQuery)			
			AND ($where)	
EOD;
}

function sql_landcover_point($cols = '0',$where = '1 = 1',$order = 'z_order') {
	global $LANDCOVER_POINT;
	$propertyWhereQuery = getPropertyWhereQuery($LANDCOVER_POINT)	;
	return <<<EOD
	SELECT
		osm_id,
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
		COALESCE(wood,type,CAST('no' AS text)) AS wood,
		name,		
	$cols
	FROM landcover_point
	WHERE
				($propertyWhereQuery)			
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
