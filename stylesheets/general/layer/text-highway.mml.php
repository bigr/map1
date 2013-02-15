<?php
	require_once "sql/text-highway.sql.php";
	
?>
{
	"id": "text-highway-priority<?php echo $priority?>",
	"name": "text-highway-priority<?php echo $priority?>",
	"class": "textHighway priority<?php echo $priority?>",
	<?php if ( $TILE ): ?>
	"srs": "+proj=longlat +ellps=WGS84 +datum=WGS84 +no_defs",
	<?php echo ds_sqlite('highways_text');?>	
	<?php else: ?>
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_text_highway_short($priority));?>
	<?php endif; ?>
		
},
{
	"id": "text-highway-e-priority<?php echo $priority?>",
	"name": "text-highway-e-priority<?php echo $priority?>",
	"class": "textHighwayE priority<?php echo $priority?>",
	<?php if ( $TILE ): ?>
	"srs": "+proj=longlat +ellps=WGS84 +datum=WGS84 +no_defs",
	<?php echo ds_sqlite('highways_text');?>	
	<?php else: ?>
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_text_highway_e($priority));?>
	<?php endif; ?>		
}
