<?php
require_once "inc/utils.php";
require_once "conf/pgis.php";
require_once "conf/text-symbol.conf.php";
require_once "sql/_common.sql.php";
require_once "sql/symbol.sql.php";

function sql_text_symbol_short($priority = null) {
    return "
	SELECT * FROM text_symbol TS
	JOIN symbol_density D ON TS.osm_id = D.osm_id
	ORDER BY grade DESC
    ";
}

function sql_text_symbol($priority = null,$where = '1 = 1',$order = 'z_order') {
	global $TEXT_SYMBOL;
	$propertyWhereQuery = getPropertyWhereQuery($TEXT_SYMBOL,array('grade'));	
	$propertyWhereQuery = str_replace('"historic"',"T.historic",$propertyWhereQuery);
	$propertyWhereQuery = str_replace('"castle_type"',"T.castle_type",$propertyWhereQuery);
	$propertyWhereQuery = str_replace('"amenity"',"T.amenity",$propertyWhereQuery);
	$propertyWhereQuery = str_replace('"tourism"',"T.tourism",$propertyWhereQuery);
	$propertyWhereQuery = str_replace('"natural"',"T.natural",$propertyWhereQuery);
	$propertyWhereQuery = str_replace('"ruins"',"T.ruins",$propertyWhereQuery);
	$propertyWhereQuery = str_replace('"place_of_worship"',"T.place_of_worship",$propertyWhereQuery);
	$symbolGradeSql = getSymbolGradeSql();
return <<<EOD
    SELECT
	    T.way AS		
	way,
	    T.name AS
	name,
	    $symbolGradeSql AS
	grade,
		COALESCE(T.historic,'no'::text) AS
	historic,
		COALESCE(T.man_made,'no'::text) AS
	man_made,
		COALESCE(T.tourism,'no'::text) AS
	tourism,	
	    COALESCE(T.amenity,'no'::text) AS
	amenity,
	    COALESCE(T.natural,'no'::text) AS
	"natural",
		COALESCE(leisure,'no'::text) AS
	leisure,		    
		COALESCE(building,'no'::text) AS
	building,
		COALESCE(T.ruins,'no'::text) AS
	ruins,	
	"tower:type",
	information,	
		COALESCE(T.place_of_worship,'no'::text) AS
	place_of_worship,
		COALESCE(T."place_of_worship:type",'no'::text) AS
	"place_of_worship:type",
		COALESCE(T.castle_type,'no'::text) AS
	castle_type,
		COALESCE(T.way_area,0) AS
	way_area,
	T.osm_id
    FROM (
	SELECT osm_id,way,name,historic,man_made,tourism,amenity,"natural",leisure,building,ruins,"tower:type",information,place_of_worship,"place_of_worship:type",castle_type,0 AS way_area, z_order FROM
	    symbol
	
    ) AS T    
    WHERE
		    ($propertyWhereQuery)
	    AND T.name IS NOT NULL
	    AND ($where)
    ORDER BY $symbolGradeSql DESC, COALESCE(T.way_area,0) DESC, $order
EOD;
}
