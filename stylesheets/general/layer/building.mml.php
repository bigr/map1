<?php
	require_once "sql/building.sql.php";
	require_once "conf/sqlite.php";
?>
{
	"id": "building",
	"name": "building",
	"class": "building",
	"srs": "<?php echo SRS900913?>",	
	<?php if ( $TILE ): ?>	
	"srs": "+proj=longlat +ellps=WGS84 +datum=WGS84 +no_defs",
	<?php echo ds_sqlite('building_tbl');?>
	<?php else: ?>
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_building_short());?>
	<?php endif; ?>
}

