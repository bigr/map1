<?php
require_once "conf/pgis.php";
require_once "sql/landcover.sql.php";
require_once "conf/sqlite.php";

function sql_text_landcover_short($cols = '0',$where = '1 = 1',$order = 'z_order') {
	return 'SELECT * FROM landcovers WHERE name IS NOT NULL ORDER BY way_area DESC';
}
