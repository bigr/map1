<?php
require_once "conf/pgis.php";
require_once "sql/highway.sql.php";
require_once "conf/sqlite.php";


function sql_text_highway_e($priority = null) {
    return "
	SELECT way,int_ref AS number,(CHAR_LENGTH(int_ref::text)+1) AS number_length FROM highways
    ";
}

function sql_text_highway_short($priority,$cols = '0',$order = 'grade') {
    return "SELECT * FROM highways WHERE (ref IS NOT NULL OR name IS NOT NULL OR int_ref IS NOT NULL) ORDER BY $order";
}


function sql_text_highway_access($priority = 0, $cols = '0',$where = '1 = 1',$order = 'ST_LENGTH(way) DESC') {
return <<<EOD
    SELECT
	way,
	H.osm_id AS osm_id,
	file
    FROM highway H
    JOIN highway_access A ON H.osm_id = A.osm_id
    WHERE 
	NOT EXISTS (
	    SELECT * FROM accessareas AA
	    WHERE St_Intersects(AA.way,H.way) AND AA.access = H.access
	    LIMIT 1
	)
    ORDER BY $order
EOD;
}


function sql_text_highway_access_short($priority = 0, $cols = '0',$where = '1 = 1',$order = 'ST_LENGTH(way) DESC') {
    return "SELECT * FROM highways_access";
}
