<?php
require_once "sql/_common.sql.php";

function _getContourModuloSql() {	
	return "
		(CASE
			WHEN height::integer % 500 = 0 THEN 500 
			WHEN height::integer % 200 = 0 THEN 200
			WHEN height::integer % 100 = 0 THEN 100
			WHEN height::integer %  50 = 0 THEN  50
			WHEN height::integer %  20 = 0 THEN  20
			WHEN height::integer %  10 = 0 THEN  10
			WHEN height::integer %   5 = 0 THEN   5
			ELSE 5 
		END)
	";
}


function sql_contour($cols = '0',$where = '1 = 1') {
	$contourModuloSql = _getContourModuloSql();
return <<<EOD
	SELECT 
		ST_SetSRID(way, 900913) AS way,
			$contourModuloSql AS
		modulo,
		$cols
	FROM {$GLOBALS['PGIS_TBL_CONTOUR']}
	WHERE
		($where)
		
EOD;
}
