<?php
require_once "inc/utils.php";
require_once "conf/waters.conf.php";
require_once "sql/_common.sql.php";

function _getWaterwayColSql() {
	return "(CASE WHEN waterway='construction' THEN construction ELSE waterway END)";
}

function _getWaterwayGradeSql($col) {	
	return "
	    CASE
		WHEN L.waterway='stream' AND L.name IS NULL THEN 1
		ELSE floor(least(35,greatest(5,log($col)*7-17)))::integer
	    END
	";
}

function sql_waterway_short($layer, $cols = '0',$where = '1 = 1',$order = 'z_order') {
		global $TILE;
		$db = explode('.',$TILE);
		$table = $db[0].'_'.$db[1];
    return "SELECT * FROM waterways_$table WHERE layer = $layer";
}

function sql_waterway_short_notrect($layer, $cols = '0',$where = '1 = 1',$order = 'z_order') {
    $layerSql = _getNewLayerSql();
    return sql_waterway($cols,"$layerSql = $layer",$order);
}


function sql_waterway($cols = '0',$where = '1 = 1',$order = 'z_order') {
	$layerSql = _getNewLayerSql();
	$isBridgeSql = _isBridgeSql();
	$isTunnelSql = _isTunnelSql();	
	$waterwayCol = _getWaterwayColSql();
	$waterwayGradeSql = _getWaterwayGradeSql('S.length');
	$waterwayTotalGradeSql = _getWaterwayGradeSql('S.total_length');
return <<<EOD
	SELECT
			way,
				$waterwayTotalGradeSql AS
			grade_total,
				$waterwayGradeSql AS
			grade,
				(CASE
					WHEN waterway IN ('canal','ditch','drain') THEN CAST('yes' AS text)
					ELSE CAST('no' AS text)
				END) AS			
			artificial,
			waterway,				
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
			$layerSql AS layer,
			    ST_Length(ST_Transform(way,900913)) AS
			way_length,			
			$cols
		FROM waterway L
		LEFT JOIN stream S ON S.osm_id = L.osm_id
		WHERE
				    waterway IN ('river','stream')
			    AND L.osm_id > 0			   
			    AND ($where)
		ORDER BY $order
EOD;
}

function sql_waterpoint($cols = '0',$where = '1 = 1',$order = 'z_order') {
	global $WATERPOINT;
	$layerSql = _getLayerSql();
	
	$propertyWhereQuery = getPropertyWhereQuery($WATERPOINT);
return <<<EOD
    SELECT
	way,
	osm_id, 
	waterway,							    
	$layerSql AS layer,
	name,
	$cols
    FROM waterpoint
    WHERE
	($propertyWhereQuery)			
	AND ($where)	
EOD;
}

function sql_waterpoint_short($layer,$where = '1 = 1',$order = 'z_order') {
    return "SELECT * FROM waterpoints WHERE layer = $layer";
}


function sql_waterarea_short($layer, $cols = '0',$where = '1 = 1',$order = 'z_order') {
    return "SELECT * FROM waterareas WHERE layer = $layer ORDER BY way_area DESC";
}


function sql_waterarea($cols = '0',$where = '1 = 1',$order = 'z_order') {
	global $WATERAREA;
	$layerSql = _getNewLayerSql();	
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
	    waterway,
	    landuse,
	    "natural",
	    $layerSql AS layer,
	    way_area,		
	    osm_id,
	    ST_Centroid(way) AS centroid,
	    name,
	    wikipedia,
	    website,
	    wetland,
	    $cols
	FROM waterarea
	WHERE
		    ($propertyWhereQuery)
		AND building IS NULL
	    AND ($where)
EOD;
}
