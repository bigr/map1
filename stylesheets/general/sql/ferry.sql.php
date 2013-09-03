<?php
require_once "sql/_common.sql.php";
require_once "conf/sqlite.php";



function sql_ferry($cols = '0',$where = '1 = 1',$order = 'z_order') {
return <<<EOD
  SELECT * FROM ferry    
EOD;
}
