<?php
require_once "conf/pgis.php";
require_once "sql/route.sql.php";

function sql_text_route_ref($priority, $cols = '0',$where = '1 = 1',$order = 'ST_LENGTH(way) DESC') {
    $grade = _getBicycleGradeSql('network');
return <<<EOD
	SELECT
		way,				
			$grade AS
		grade,
		    COALESCE(ncn_ref,nwn_ref,rcn_ref,rwn_ref,lcn_ref,lwn_ref,ref) AS
		ref,
		    CHAR_LENGTH(COALESCE(ncn_ref,rcn_ref,lcn_ref,ref)) AS
		ref_length,
		route,
		$cols			
	FROM route
	WHERE
		    route IN ('bicycle','mtb')
	    AND COALESCE(ncn_ref,rcn_ref,lcn_ref,ref) IS NOT NULL
	    AND ($where)
	ORDER BY $grade, $order
EOD;
}


function sql_text_route_name($priority, $cols = '0',$where = '1 = 1',$order = 'ST_LENGTH(way) DESC') {
    $color = _getHikingRouteColorSql('"osmc:symbol"');
    $grade = _getHikingGradeSql('"osmc:symbol"');
return <<<EOD
	SELECT
		way,
		    $grade AS
		grade,
		    $color AS
		color,		    
		name,		    
		route,
		$cols			
	FROM route
	WHERE
		    route IN ('hiking','foot')
	    AND name IS NOT NULL
	    AND ($where)
	ORDER BY $order
EOD;
}
