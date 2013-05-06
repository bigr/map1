<?php
require_once("helper.php");
require_once('sql/building.sql.php');
createTable('buildings','sql_building',array('way_area','z_order','name'),array('way','centroid'));


