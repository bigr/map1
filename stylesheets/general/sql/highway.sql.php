<?php
require_once "sql/_common.sql.php";

function _getHighwayColSql() {
	return "(CASE WHEN highway='construction' THEN construction ELSE highway END)";
}

function _getHighwayGradeSql($forceHighwayCol = false) {
	$highwayCol = $forceHighwayCol ? 'highway' : _getHighwayColSql();
	
	return "
		(CASE
			WHEN $highwayCol IN ('motorway','motorway_link') THEN 0
			WHEN $highwayCol IN ('trunk','trunk_link') THEN 1
			WHEN $highwayCol IN ('primary','primary_link') THEN 2
			WHEN $highwayCol IN ('secondary','secondary_link') THEN 3
			WHEN $highwayCol IN ('tertiary','tertiary_link') THEN 4
			WHEN $highwayCol IN ('unclassified','minor') THEN 5
			WHEN $highwayCol IN ('service') THEN 6
			WHEN $highwayCol IN ('residential','living_street','pedestrian') THEN 7
			WHEN $highwayCol = 'track' THEN (CASE
				WHEN tracktype = 'grade1' THEN 8
				WHEN tracktype = 'grade2' THEN 9
				WHEN tracktype = 'grade3' THEN 10
				WHEN tracktype = 'grade4' THEN 11
				WHEN tracktype = 'grade5' THEN 12
				ELSE 13
			END)
			WHEN $highwayCol = 'road' THEN 13
			WHEN $highwayCol IN ('footway','cycleway','bridleway','steps') THEN 9 
			WHEN $highwayCol = 'path' THEN 12
			ELSE 13
		END)
	";
}

function _getHighwaySql() {
    $highwayCol = _getHighwayColSql();
    return "
	(CASE
	    WHEN $highwayCol = 'motorway_link' THEN 'motorway'
	    WHEN $highwayCol = 'trunk_link' THEN 'trunk'
	    WHEN $highwayCol = 'primary_link' THEN 'primary'
	    WHEN $highwayCol = 'secondary_link' THEN 'secondary'
	    WHEN $highwayCol = 'tertiary_link' THEN 'tertiary'
	    ELSE $highwayCol
	END)
    ";
}

function _getSmoothnessSql() {
    $highwayCol = _getHighwayColSql();
    return "
	(CASE
	    WHEN $highwayCol IN ('motorway','trunk','motorway_link','trunk_link') THEN 0
	    WHEN $highwayCol IN ('primary','primary_link','secondary','secondary_link','tertiary','tertiary_link','unclassified','minor','service','residential','living_street','pedestrian') THEN (CASE
		    WHEN surface IN ('unpaved','compacted','fine_gravel','grass_paver') THEN 2
		    WHEN surface IN ('dirt','earth','ground','gravel','mud','sand','grass') THEN 3
		    ELSE 1
	    END)
	    WHEN highway = 'track' THEN (CASE
		    WHEN tracktype = 'grade1' THEN (CASE
			    WHEN surface IN ('asphalt','cobblestone:flattened','concrete:plates','paving_stones','paving_stones:30','paving_stones:20') THEN 1
			    WHEN surface IN ('unpaved','compacted','fine_gravel','grass_paver','gravel') THEN 3
			    WHEN surface IN ('dirt','earth','ground','mud','sand','grass') THEN 4
			    ELSE 2
		    END)
		    WHEN tracktype IN ('grade2','grade3') THEN (CASE
			    WHEN surface IN ('asphalt','cobblestone:flattened','concrete:plates','paving_stones','paving_stones:30','paving_stones:20','paved','cobblestone','concrete ','concrete:lanes','paving_stones:30','paving_stones:20','wood','metal') THEN 2
			    WHEN surface IN ('dirt','earth','ground','mud','sand','grass') THEN 4
			    ELSE 3
		    END)
		    ELSE (CASE
			    WHEN surface IN ('paved','asphalt','cobblestone:flattened','concrete:plates','paving_stones','paving_stones:30','paving_stones:20','paved','cobblestone','concrete ','concrete:lanes','paving_stones:30','paving_stones:20','wood','metal') THEN 3
			    WHEN surface IN ('sand','grass') THEN 5
			    ELSE 4
		    END)
	    END)
	    WHEN highway = 'road' THEN  (CASE
		    WHEN surface IN ('paved','asphalt','cobblestone:flattened','concrete:plates','paving_stones','paving_stones:30','paving_stones:20','paved','cobblestone','concrete ','concrete:lanes','paving_stones:30','paving_stones:20','wood','metal') THEN 3
		    WHEN surface IN ('sand','grass') THEN 5
		    ELSE 4
	    END)
	    WHEN highway IN ('cycleway','footway') THEN  (CASE						
		    WHEN surface IN ('unpaved','compacted','fine_gravel','grass_paver','gravel') THEN 3
		    WHEN surface IN ('dirt','earth','ground','mud','sand','grass') THEN 4
		    ELSE 1
	    END)
	    WHEN highway = 'steps' THEN 7
	    ELSE (CASE
		    WHEN surface IN ('paved','asphalt','cobblestone:flattened','concrete:plates','paving_stones','paving_stones:30','paving_stones:20','paved','cobblestone','concrete ','concrete:lanes','paving_stones:30','paving_stones:20','wood','metal') THEN 3
		    WHEN surface IN ('sand','grass') THEN 5
		    ELSE 4
	    END)
	END)   
    ";
}

function _isLinkSql() {
	$highwayCol = _getHighwayColSql();
	return "$highwayCol IN ('motorway_link','trunk_link','primary_link','secondary_link','tertiary_link')";
}

function sql_highway($cols = '0',$where = '1 = 1') {
    $layerSql = _getNewLayerSql();
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
		    COALESCE(junction,CAST('no' AS text)) AS				
	    junction,
		    (CASE WHEN highway = 'construction' THEN CAST('yes' AS text) ELSE CAST('no' AS text) END) AS
	    is_construction,
	    $layerSql AS layer,
	    osm_id,
		COALESCE(int_ref,CAST('no' AS text)) AS
	    int_ref,
		ST_Length(way) AS
	    way_length,
	    $cols			
    FROM highway
    WHERE
			highway IS NOT NULL
		AND ($where)
EOD;
}

function sql_highway_major($layer, $cols = '0',$order = 'grade') {
    return "SELECT * FROM highways WHERE layer = $layer AND grade < 6 ORDER BY $order";
}

function sql_highway_minor($layer, $cols = '0',$order = 'grade') {
    return "SELECT * FROM highways WHERE layer = $layer AND grade >= 6 ORDER BY $order";
}
