<?php
require_once "sql/_common.sql.php";


function sql_fishnet1000($cols = '0',$where = '1 = 1') {	
return <<<EOD
	SELECT 
		way,		
		$cols
	FROM fishnet1000
	WHERE
		($where)
		
EOD;
}

function sql_fishnet10000($cols = '0',$where = '1 = 1') {	
return <<<EOD
	SELECT 
		way,		
		$cols
	FROM fishnet10000
	WHERE
		($where)
		
EOD;
}
