<?php
require_once "conf/pgis.php";
require_once "sql/highway.sql.php";
require_once "conf/sqlite.php";

function sql_text_highway_short($priority = null) {
    return "
	SELECT * FROM text_highway
    ";
}

function sql_text_highway_e($priority = null) {
    return "
	SELECT way,int_ref AS number,(CHAR_LENGTH(int_ref::text)+1) AS number_length FROM highway_text
    ";
}

function sql_text_highway($cols = '0',$where = '1 = 1',$order = 'LENGTH(way) DESC') {	
	$isBridgeSql = _isBridgeSql();
	$isTunnelSql = _isTunnelSql();
	$isLinkSql = _isLinkSql();
	$highwayCol = _getHighwayColSql();
	$highwayGradeSql = _getHighwayGradeSql();
	$highwaySql = _getHighwaySql();
return <<<EOD
	SELECT
			way,				
				$highwayGradeSql AS
			grade,
			name,
			ref,
				LENGTH(ref) AS
			ref_length,				
				$highwaySql AS
			highway,
				(CASE
					WHEN $isLinkSql THEN CAST('yes' AS text)
					ELSE CAST('no' AS text)
				END) AS 
			is_link,
				(CASE
					WHEN $isBridgeSql THEN CAST('yes' AS text)
					ELSE CAST('no' AS text)
				END) AS 
			is_bridge,
				(CASE
					WHEN $isTunnelSql THEN CAST('yes' AS text)
					ELSE CAST('no' AS text)
				END) AS 
			is_tunnel,
				COALESCE(junction, CAST('no' AS text)) AS				
			junction,
				(CASE WHEN highway = 'construction' THEN  CAST('yes' AS text) ELSE  CAST('no' AS text) END) AS
			is_construction,
			osm_id,				
			int_ref,
			    LENGTH(int_ref) AS
			intref_length,	
			int_ref AS number,
			LENGTH(int_ref) AS number_length,
			$cols			
		FROM highway_text
		WHERE
				    highway IS NOT NULL
			    AND osm_id > 0
			    AND (ref IS NOT NULL OR name IS NOT NULL OR int_ref IS NOT NULL)
			    AND ($where)
		ORDER BY $order
EOD;
}
