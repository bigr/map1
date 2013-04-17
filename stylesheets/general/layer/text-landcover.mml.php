<?php
	require_once "sql/text-landcover.sql.php";
?>
{
	"id": "text-landcover-priority<?php echo $priority?>",
	"name": "text-landcover-priority<?php echo $priority?>",
	"class": "textLandcover priority<?php echo $priority?>",
	<?php if ( $TILE ): ?>
	"srs": "+proj=longlat +ellps=WGS84 +datum=WGS84 +no_defs",
	<?php echo ds_sqlite('landcover_tbl','centroid');?>	
	<?php else: ?>
	"srs": "<?php echo SRS900913?>",	
	<?php echo ds_pgis(sql_landcover());?>
	<?php endif; ?>
	
}
