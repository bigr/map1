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
			WHEN $highwayCol IN ('footway','cycleway') THEN 8 
			WHEN $highwayCol IN ('bridleway','steps') THEN 9 
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
	    WHEN highway = 'bridleway' THEN  (CASE						
		    WHEN surface IN ('paved','asphalt','cobblestone:flattened','concrete:plates','paving_stones','paving_stones:30','paving_stones:20','paved','cobblestone','concrete ','concrete:lanes','paving_stones:30','paving_stones:20','wood','metal') THEN 2
		    ELSE 4
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

function sql_highway_query($cols = '0',$where = '1 = 1',$table='highway',$simple = false) {
    $layerSql = _getNewLayerSql();
    $isBridgeSql = _isBridgeSql();
    $isTunnelSql = _isTunnelSql();
    $isLinkSql = _isLinkSql();
    $highwayCol = _getHighwayColSql();
    $highwayGradeSql = _getHighwayGradeSql();
    $highwaySql = _getHighwaySql();
    $smoothnessSql = _getSmoothnessSql();
    $onewaySql = $simple ? '' : "(CASE 
		    WHEN oneway IN ('false','0','no') THEN 'no'
		    WHEN oneway IN ('true','1','yes') THEN 'yes'
		    ELSE COALESCE(oneway,CAST('no' AS text))
		END) AS 
	    oneway,";
    $accessSql = $simple ? '' : "access,foot,ski,\"ski:nordic\",\"ski:alpine\",\"ski:telemark\",ice_skates,inline_skates,horse,
	    vehicle,bicycle,carriage,trailer,caravan,motor_vehicle,motorcycle,moped,mofa,motorcar,motorhome,
	    psv,bus,taxi,tourist_bus,goods,hgv,agricultural,ATV,snowmobile,";
return <<<EOD
	SELECT
	    way,
		    (CASE
			    WHEN $highwayCol = 'footway' AND ($smoothnessSql) > 2 THEN 'path'
			    WHEN $highwayCol IN ('footway','cycleway','bridleway','motorway','motorway_link','trunk','trunk_link','primary','primary_link','secondary','secondary_link','tertiary','tertiary_link','unclassified','minor','service','residential','living_street','pedestrian','track') THEN 'road'
			    WHEN $highwayCol IN ('path','steps') THEN 'path'
			    ELSE 'unknown'
		    END) AS
	    type,
	    construction,
	    footway,
	    cycleway,
	    service,
	    tracktype,
	    bridge,
	    tunnel,
		    $highwayGradeSql AS
	    grade,
		    $smoothnessSql AS
	    smoothness,	
	    surface,
	    "mtb:scale",
	    sac_scale,
	    attribution,
	    lanes,
	    lit,
	    sidewalk,
	    width,
	    maxspeed,    
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
	  ref,		
	  int_ref,
		LENGTH(ref) AS
	    ref_length,
		LENGTH(int_ref) AS
	    intref_length,
	    $onewaySql		
		(CASE 
		    WHEN name IS NULL THEN 'no'
		    WHEN name = '' THEN 'no'
		    ELSE 'yes'
		END) AS
	    has_name,
	  name,
		ST_Length(ST_Transform(way,900913)) AS
	    way_length,	    
	    $accessSql
	    $cols			
    FROM $table
    WHERE
			highway IS NOT NULL AND ($where)
EOD;
}

function sql_highway($cols = '0',$where = '1 = 1') {
    return sql_highway_query($cols,$where,'highway');
}

function sql_highway_norect($layer) {
    $layerSql = _getNewLayerSql();
    return sql_highway_query('0',"	
		($layerSql) = $layer
    ",'highway',true);
}

function sql_highway_area($cols = '0',$where = '1 = 1') {
    return sql_highway_query('way_area,'.$cols,$where,'highway_area');
}

function sql_highway_area_short($layer,$cols = '0',$where = '1 = 1') {
    return "SELECT * FROM highway_areas WHERE layer = $layer ORDER BY way_area";
}

function sql_highway_road($layer, $grade, $cols = '0',$order = 'grade') {
    return "SELECT * FROM highways WHERE layer = $layer AND grade = $grade AND type = 'road'";
}

function sql_highway_bridge($layer, $grade, $cols = '0',$order = 'grade') {
    return "SELECT * FROM highways WHERE layer = $layer AND grade = $grade AND is_bridge = 'yes' AND type = 'road'";
}

function sql_highway_tunnel($layer, $grade, $cols = '0',$order = 'grade') {
    return "SELECT * FROM highways WHERE layer = $layer AND grade = $grade AND is_tunnel = 'yes' AND type = 'road'";
}

function sql_highway_path_bridge($layer, $grade, $cols = '0',$order = 'grade') {
    return "SELECT * FROM highways WHERE layer = $layer AND grade = $grade AND is_bridge = 'yes' AND type = 'path'";
}

function sql_highway_path_tunnel($layer, $grade, $cols = '0',$order = 'grade') {
    return "SELECT * FROM highways WHERE layer = $layer AND grade = $grade AND is_tunnel = 'yes' AND type = 'path'";
}

function sql_highway_oneway($layer, $cols = '0',$order = 'grade') {
    return "SELECT * FROM highways WHERE layer = $layer AND oneway IN ('yes','-1')";
}

function sql_highway_path($layer, $grade, $cols = '0',$order = 'grade') {
    return "SELECT * FROM highways WHERE layer = $layer AND grade = $grade AND type = 'path' AND highway != 'steps'";
}

function sql_highway_steps($layer, $cols = '0',$order = 'grade') {
    return "SELECT * FROM highways WHERE layer = $layer AND type = 'path' AND highway = 'steps'";
}

function sql_highway_point($layer) {
    return "SELECT * FROM highway_point";
}

function sql_highway_infogrid($layer) {
		global $RENDER_ZOOMS,$ROAD_GRADES;
		$zoom = $RENDER_ZOOMS[0];
		$grades = $ROAD_GRADES[$zoom];		
		$grades = implode(',',$grades);		
		return "SELECT * FROM highways WHERE layer = $layer AND grade IN ($grades)";
}
