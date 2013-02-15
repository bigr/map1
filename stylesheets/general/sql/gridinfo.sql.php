<?php
require_once "sql/_common.sql.php";
require_once "sql/highway.sql.php";
require_once "sql/symbol.sql.php";


function sql_gridinfoHighway($cols = '0',$where = '1 = 1',$order = 'z_order') {
	$layerSql = _getLayerSql();
	$isBridgeSql = _isBridgeSql();
	$isTunnelSql = _isTunnelSql();
	$isLinkSql = _isLinkSql();
	$highwayCol = _getHighwayColSql();
	$highwayGradeSql = _getHighwayGradeSql();
	$highwaySql = _getHighwaySql();
	$smoothnessSql = _getSmoothnessSql();
return <<<EOD
    SELECT
	way,
		(CASE
			WHEN $highwayCol IN ('motorway','motorway_link','trunk','trunk_link','primary','primary_link','secondary','secondary_link','tertiary','tertiary_link','unclassified','minor','service','residential','living_street','pedestrian','track') THEN 'road'
			WHEN $highwayCol IN ('footway','path','steps','cycleway','bridleway') THEN 'path'
			ELSE 'unknown'
		END) AS
	type,
		$highwayGradeSql AS
	grade,
		$smoothnessSql AS
	smoothness,
		$highwaySql AS
	highway,
		(CASE
			WHEN $isLinkSql THEN 'yes'::text
			ELSE 'no'::text
		END) AS 
	is_link,
		(CASE
			WHEN $isBridgeSql THEN 'yes'::text
			ELSE 'no'::text
		END) AS 
	is_bridge,
		(CASE
			WHEN $isTunnelSql THEN 'yes'::text
			ELSE 'no'::text
		END) AS 
	is_tunnel,
		COALESCE(junction,'no'::text) AS
	junction,
		(CASE WHEN highway = 'construction' THEN 'yes'::text ELSE 'no'::text END) AS
	is_construction,
	$layerSql AS layer,
	osm_id,
	ref,
	int_ref,
	name,
	tracktype,
	surface,
	NULL AS symbol_name,
	NULL AS wiki,
	$cols
    FROM {$GLOBALS['PGIS_TBL_LINE']}
    WHERE
		highway IS NOT NULL
	AND osm_id > 0			    	
	AND ($where)
    ORDER BY ($highwayGradeSql),$layerSql DESC, $order
EOD;
}

function sql_gridInfoSymbol($where = '1 = 1',$order = 'z_order') {
	global $SYMBOL;
	$propertyWhereQuery = getPropertyWhereQuery($SYMBOL,array('grade'));
	$propertyWhereQuery = str_replace('"historic"',"COALESCE(W.historic,T.historic)",$propertyWhereQuery);
	$propertyWhereQuery = str_replace('"castle_type"',"COALESCE(W.castle_type,T.castle_type)",$propertyWhereQuery);
	$propertyWhereQuery = str_replace('"amenity"',"COALESCE(W.amenity,T.amenity)",$propertyWhereQuery);
	$propertyWhereQuery = str_replace('"tourism"',"COALESCE(W.tourism,T.tourism)",$propertyWhereQuery);
	$propertyWhereQuery = str_replace('"natural"',"COALESCE(W.natural,T.natural)",$propertyWhereQuery);
	$propertyWhereQuery = str_replace('"ruins"',"COALESCE((CASE WHEN W.ruins=1 THEN 'yes' ELSE NULL END),T.ruins)",$propertyWhereQuery);
	$propertyWhereQuery = str_replace('"place_of_worship"',"COALESCE(W.place_of_worship,T.place_of_worship)",$propertyWhereQuery);
	
	$symbolGradeSql = getSymbolGradeSql();
return <<<EOD
    SELECT
	way,
	grade,
	historic,
	man_made,
	tourism,	
	amenity,
	"natural",		
	leisure,
	building,
	ruins,	
	"tower:type",
	information,			
	place_of_worship,		
	"place_of_worship:type",		
	castle_type,		
	way_area,
	osm_id,
	NULL AS highway,
	NULL AS surface,
	NULL AS smoothness,
	NULL AS ref,
	NULL AS int_ref,
	NULL AS tracktype,
	name, 
	name AS symbol_name,
	wiki
    FROM (SELECT * FROM symbol) AS T
    ORDER BY grade DESC   
EOD;
}
