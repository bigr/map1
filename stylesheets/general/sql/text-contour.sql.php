<?php
require_once "sql/contour.sql.php";

function sql_textContour($cols = '0',$where = '1 = 1') {
	$contourModuloSql = _getContourModuloSql();
return <<<EOD
	SELECT
		way,
		height::integer,
			$contourModuloSql AS
		modulo,
		$cols
	FROM {$GLOBALS['PGIS_TBL_CONTOUR']}
	WHERE
		    $contourModuloSql IN (100,200,500)
		AND ($where)		
EOD;
}
