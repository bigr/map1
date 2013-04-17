<?php
	require_once "sql/accessarea.sql.php";
	require_once "conf/shapefile.php";
	require_once "conf/sqlite.php";	
?>



{
	"id": "accessarea",
	"name": "accessarea",
	"class": "accessarea",
	<?php if ( $TILE ): ?>
	"srs": "+proj=longlat +ellps=WGS84 +datum=WGS84 +no_defs",
	<?php echo ds_sqlite('access_areas');?>
	<?php else: ?>
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_accessarea());?>
	<?php endif; ?>		
}

