<?php
require_once "conf/pgis.php";

function _getPlacePopulationColumn() {
    return "
	COALESCE(	    
	    P.population,
	    CASE		
		WHEN P.place = 'city' THEN 90000
		WHEN P.place = 'town' THEN 3000
		WHEN P.place IN ('suburb','borough') THEN 3000
		WHEN P.place = 'village' THEN 300
		WHEN P.place IN ('neighbourhood','official_neighborhood','municipality') THEN 200
		WHEN P.place = 'hamlet' THEN 15
		WHEN P.place IN ('isolated_dwelling','farm') THEN 3
	    END	    
	)
    ";
}

function _getPlaceTypeSql() {
    return "
	(CASE
	    WHEN P.place IN ('continent','country','state','county','region','island','islat','township') THEN 'region'
	    WHEN P.place IN ('city','town','village','hamlet','isolated_dwelling','farm') THEN 'urb'
	    WHEN P.place IN ('suburb','neighbourhood','municipality','borough') THEN 'suburb'
	    WHEN P.place IN ('locality') THEN 'locality'
	    ELSE 'unknown'
	END)
    ";
}



function _getPlaceGradeSql() {
	$population = _getPlacePopulationColumn();		
	
	return "
	    (CASE
		WHEN P.place = 'continent' THEN 45
		WHEN P.place = 'country' THEN 44
		WHEN P.place = 'state' THEN 43
		WHEN P.place = 'county' THEN 42
		WHEN P.place IN ('region','township') THEN 41
		ELSE floor(least(40,greatest(0,log(CASE WHEN ($population) > 0 THEN $population ELSE 1 END)*7-7)))::integer
	    END)
	";
}

function sql_text_place_short($priority = null) {
    return "
	SELECT * FROM place ORDER BY grade DESC, population DESC
    ";
}

function sql_text_place($cols = '0',$where = '1 = 1') {		
    $placeGradeSql = _getPlaceGradeSql();	
    $placeTypeSql = _getPlaceTypeSql();	
return <<<EOD
    SELECT
	P.way,
		$placeTypeSql AS
	type,	
		$placeGradeSql AS
	grade,
	    P.population AS
	population,
	    P.name AS
	name,
	    P.name AS
	name_short,
	    P.name AS
	name_very_short,
	P.place,
	P.osm_id,
	$cols			
    FROM places P  
    WHERE
	    P.place IS NOT NULL			   
	AND P.name IS NOT NULL
	AND ($where)
    ORDER BY ($placeGradeSql) DESC
EOD;
}
