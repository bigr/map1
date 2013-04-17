<?php
	require_once "sql/text-waters.sql.php";
?>
<?php if ( $TILE ): ?>
{
	"id": "text-waterarea-priority<?php echo $priority?>",
	"name": "text-waterarea-priority<?php echo $priority?>",
	"class": "textWaterarea priority<?php echo $priority?>",
	<?php if ( $TILE ): ?>
	"srs": "+proj=longlat +ellps=WGS84 +datum=WGS84 +no_defs",
	<?php echo ds_sqlite('waterarea_texts_tbl','centroid');?>	
	<?php else: ?>
	"srs": "<?php echo SRS900913?>",	
	<?php echo ds_pgis(sql_text_waterarea_short($priority),'centroid');?>
	<?php endif; ?>
	
	
}
,
<?php endif; ?>
{
	"id": "text-waterway-priority<?php echo $priority?>-1",
	"name": "text-waterway-priority<?php echo $priority?>-1",
	"class": "textWaterway priority<?php echo $priority?> dy",
	"srs": "<?php echo SRS900913?>",
	<?php if ( $TILE ): ?>
	<?php echo ds_pgis(sql_text_waterway_short($priority));?>
	<?php else: ?>
	<?php echo ds_pgis(sql_text_waterway($priority));?>
	<?php endif; ?>
}


