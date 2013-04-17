<?php
	require_once "conf/pgis.php";	
	require_once "sql/waters.sql.php";
	require_once "conf/sqlite.php";	
?>
<?php if ( $RENDER_WATERWAY ):?>
	{
		"id": "waterway-layer<?php echo $layer?>",
		"name": "waterway-layer<?php echo $layer?>",
		"class": "waterway layer<?php echo $layer?>",
		"srs": "<?php echo SRS900913?>",
		<?php if ( $TILE ): ?>	
		<?php echo ds_pgis(sql_waterway_short($layer));?>
		<?php else: ?>
		<?php echo ds_pgis(sql_waterway_short_notrect($layer));?>
		<?php endif; ?>	
	}
	<?php if ( $TILE ): ?>
	,
	{
		"id": "waterpoint-layer<?php echo $layer?>",
		"name": "waterpoint-layer<?php echo $layer?>",
		"class": "waterpoint layer<?php echo $layer?>",
		<?php if ( $TILE ): ?>
		"srs": "+proj=longlat +ellps=WGS84 +datum=WGS84 +no_defs",
		<?php echo ds_sqlite('water_point_layer_'.strtr($layer,'-','_'));?>
		<?php else: ?>
		"srs": "<?php echo SRS900913?>",
		<?php echo ds_pgis(sql_water_point_short($layer));?>
		<?php endif; ?>
		
	}
	<?php endif?>
	<?php if ( $RENDER_WATERAREA ) echo ","; ?>
<?php endif?>
<?php if ( $RENDER_WATERAREA ):?>
	{
		"id": "waterarea-layer<?php echo $layer?>",
		"name": "waterarea-layer<?php echo $layer?>",
		"class": "waterarea layer<?php echo $layer?>",		
		<?php if ( $TILE ): ?>	
		"srs": "+proj=longlat +ellps=WGS84 +datum=WGS84 +no_defs",
		<?php echo ds_sqlite('waterarea_layer_'.strtr($layer,'-','_'));?>
		<?php else: ?>
		"srs": "<?php echo SRS900913?>",
		<?php echo ds_pgis(sql_waterarea_short($layer));?>
		<?php endif; ?>		
	}
<?php endif?>

