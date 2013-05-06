<?php
	require_once "sql/accessarea.sql.php";
	require_once "conf/shapefile.php";
	require_once "conf/sqlite.php";	
?>

{
	"id": "accessarea",
	"name": "accessarea",
	"class": "accessarea",	
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_accessarea());?>	
}

