<?php
require_once "inc/utils.php";
require_once "conf/pgis.php";
require_once "conf/shield-peak.conf.php";
require_once "sql/_common.sql.php";

function sql_shieldPeak_short() {
    return "
	SELECT way,name,ele,round(grade) as grade FROM peak ORDER BY grade DESC
    ";
}

function sql_shiledPeakGrade() {
    $wayC = 'P.way';
    $eleC = 'P.ele';
    $wayC2 = 'P2.way';
    $eleC2 = 'P2.ele';
return <<<EOD
    (-20 + 2/log(2) * log((
	SELECT
	    SUM(d/3.318)
	FROM (
		SELECT 
		    ST_Distance($wayC2,$wayC)/(row_number() over (order by ST_Distance(P2.way,P.way) nulls last)) as d
		FROM peaks P2		
		WHERE $eleC2 > $eleC
		ORDER BY ST_Distance($wayC2,$wayC2) ASC 
		LIMIT 14
	     ) AS foo
    )))
EOD;
}


function sql_shieldPeak($cols = '0',$where = '1 = 1') {
    $gradeSQL = sql_shiledPeakGrade();
return <<<EOD
	SELECT
		P.way AS way,
		P.ele AS ele,
		P.name AS name,
		P.osm_id,
		    $gradeSQL AS
		grade
	FROM peaks P	
	WHERE 
		    P."natural" = 'peak'
		AND (P.name IS NOT NULL OR P.ele IS NOT NULL)
		AND ($where)
	ORDER BY P.ele IS NULL, P.ele DESC	
EOD;
}
