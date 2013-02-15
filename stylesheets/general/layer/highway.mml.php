<?php
	require_once "sql/highway.sql.php";
	require_once "conf/sqlite.php";	
?>
{
	"id": "highway-minor-layer<?php echo $layer?>",
	"name": "highway-minor-layer<?php echo $layer?>",
	"class": "highway layer<?php echo $layer?>",	
	<?php if ( $TILE ): ?>	
	"srs": "+proj=longlat +ellps=WGS84 +datum=WGS84 +no_defs",
	<?php echo ds_sqlite('highways_minor_layer_'.strtr($layer,'-','_'));?>
	<?php else: ?>
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_highway_minor($layer));?>
	<?php endif; ?>
},
{
	"id": "highway-major-layer<?php echo $layer?>",
	"name": "highway-major-layer<?php echo $layer?>",
	"class": "highway layer<?php echo $layer?>",	
	<?php if ( $TILE ): ?>	
	"srs": "+proj=longlat +ellps=WGS84 +datum=WGS84 +no_defs",
	<?php echo ds_sqlite('highways_major_layer_'.strtr($layer,'-','_'));?>
	<?php else: ?>
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_highway_major($layer));?>
	<?php endif; ?>
}

