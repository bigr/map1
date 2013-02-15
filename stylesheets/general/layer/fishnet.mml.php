<?php
	require_once "sql/fishnet.sql.php";
	require_once "conf/shapefile.php";
?>
{
	"id": "fishnet1000",
	"name": "fishnet1000",
	"class": "fishnet1000",
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_fishnet1000());?>
},

{
	"id": "fishnet10000",
	"name": "fishnet10000",
	"class": "fishnet10000",
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_fishnet10000());?>
},
{
	"id": "graticules",
	"name": "graticules",
	"class": "graticules",
	"srs": "<?php echo SRS4326?>",		
	<?php echo ds_shapefile('ne_10m_graticules_1');?>
}

