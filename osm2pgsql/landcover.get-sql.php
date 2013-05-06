<?php
require_once("helper.php");
require_once('sql/landcover.sql.php');
createTable('landcovers','sql_landcover',array('way_area','z_order','name'),array('way','centroid'));


