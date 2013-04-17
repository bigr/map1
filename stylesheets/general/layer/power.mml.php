<?php
	require_once "sql/power.sql.php";
?>
<?php if ( $TILE ): ?>	
{
	"id": "power-layer<?php echo $layer?>",
	"name": "power-layer<?php echo $layer?>",
	"class": "power layer<?php echo $layer?>",
	<?php if ( $TILE ): ?>
	"srs": "+proj=longlat +ellps=WGS84 +datum=WGS84 +no_defs",
	<?php echo ds_sqlite('power_layer_'.strtr($layer,'-','_'));?>
	<?php else: ?>
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_power_short($layer));?>
	<?php endif; ?>
	
},
{
	"id": "powerpoint-layer<?php echo $layer?>",
	"name": "powerpoint-layer<?php echo $layer?>",
	"class": "powerpoint layer<?php echo $layer?>",
	<?php if ( $TILE ): ?>
	"srs": "+proj=longlat +ellps=WGS84 +datum=WGS84 +no_defs",
	<?php echo ds_sqlite('power_point_layer_'.strtr($layer,'-','_'));?>
	<?php else: ?>
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_power_point_short($layer));?>
	<?php endif; ?>
	
}
<?php endif; ?>
