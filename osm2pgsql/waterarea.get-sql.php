<?php
require_once("helper.php");
require_once('sql/waters.sql.php');
createTable('waterareas','sql_waterarea',array('layer','way_area','z_order','waterway','name'),array('way','centroid'));


