<?php
require_once "inc/utils.php";
require_once "conf/pgis.php";
require_once "conf/countryfill.conf.php";
require_once "sql/_common.sql.php";

function sql_countryfill($cols = '0',$where = '1 = 1') {    
return "   
    SELECT way,osm_id FROM adminboundary WHERE admin_level=2
";
}
