<?php
	require_once "sql/text-waters.sql.php";
?>
<?php if ( $TILE ): ?>
{
	"id": "text-waterarea-priority<?php echo $priority?>",
	"name": "text-waterarea-priority<?php echo $priority?>",
	"class": "textWaterarea priority<?php echo $priority?>",	
	"srs": "<?php echo SRS900913?>",	
	<?php echo ds_pgis(sql_text_waterarea_short($priority),'centroid');?>
}
,
<?php endif; ?>

{
	"id": "text-waterway-priority<?php echo $priority?>",
	"name": "text-waterway-priority<?php echo $priority?>",
	"class": "textWaterway priority<?php echo $priority?> dy",
	"srs": "<?php echo SRS900913?>",	
	<?php echo ds_pgis(sql_text_waterway_short($priority),'way',true);?>	
}

