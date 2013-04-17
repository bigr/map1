<?php
	require_once "sql/building.sql.php";
?>
{
	"id": "text-building-priority<?php echo $priority?>",
	"name": "text-building-priority<?php echo $priority?>",
	"class": "textBuilding priority<?php echo $priority?>",
	<?php if ( $TILE ): ?>
	"srs": "+proj=longlat +ellps=WGS84 +datum=WGS84 +no_defs",
	<?php echo ds_sqlite('building_tbl','centroid');?>	
	<?php else: ?>
	"srs": "<?php echo SRS900913?>",	
	<?php echo ds_pgis(sql_building_short());?>
	<?php endif; ?>
	
}
