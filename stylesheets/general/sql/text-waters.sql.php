<?php
require_once "conf/pgis.php";
require_once "sql/waters.sql.php";
require_once "conf/sqlite.php";



function sql_text_waterway($cols = '0',$where = '1 = 1',$order = 'LENGTH(way) DESC') {		
	global $RENDER_ZOOMS;
	$waterwayCol = _getWaterwayColSql();
	$waterwayGradeSql = _getWaterwayGradeSql('S.length');	
	$simplifyTolerance = 5*getPixelSize($RENDER_ZOOMS[0]);
return <<<EOD
	SELECT
		ST_Collect(way) AS way,
			$waterwayGradeSql AS
		grade,
		name,			
		$cols			
	FROM waterway L
	JOIN stream S ON S.osm_id = L.osm_id
	WHERE
				waterway IS NOT NULL
			AND L.osm_id > 0
			AND name IS NOT NULL
			AND ($where)
			AND way IS NOT NULL
	GROUP BY S.spring_id,($waterwayGradeSql),name
EOD;
}

function sql_text_waterway_short($priority) {
	return 'SELECT * FROM text_waterway';
}


function sql_text_waterarea($cols = '0',$where = '1 = 1',$order = 'way_area DESC') {		
	global $WATERAREA;	
	$waterwayCol = _getWaterwayColSql();	
	$propertyWhereQuery = getPropertyWhereQuery($WATERAREA);
return <<<EOD
	SELECT
		way,				
			(CASE
				WHEN waterway IN ('dock','dam') or landuse IN ('basin','reservoir') THEN CAST('yes' AS text)
				ELSE CAST('no' AS text)
			END) AS
		artificial,
		name,
		waterway,
		landuse,
		"natural",			
		way_area,
		$cols
	FROM waterarea_text
	WHERE
				($propertyWhereQuery)
			AND building IS NULL
			AND (waterway IS NULL or waterway <> 'riverbank')
			AND ($where)	
EOD;
}

function sql_text_waterarea_short($priority,$where = '1 = 1',$order = 'z_order') {
    return 'SELECT * FROM waterarea_texts_tbl';
}
