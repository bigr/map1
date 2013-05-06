<?php
require_once("helper.php");
require_once('sql/accessarea.sql.php');
createTable('accessareas','sql_accessarea',array('way_area','z_order'),array('way','centroid'));


