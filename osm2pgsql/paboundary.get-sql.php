<?php
require_once("helper.php");
require_once('sql/boundary.sql.php');
createTable('paboundaries','sql_boundary_pa',array('way_area','z_order','protect_class','name'),array('way','centroid'));


