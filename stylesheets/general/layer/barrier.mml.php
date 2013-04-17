<?php
	require_once "sql/barrier.sql.php";
?>
{
	"id": "barrier-layer<?php echo $layer?>",
	"name": "barrier-layer<?php echo $layer?>",
	"class": "barrier layer<?php echo $layer?>",
	"srs": "<?php echo SRS900913?>",
	
	<?php if ( $TILE ): ?>	
	"srs": "+proj=longlat +ellps=WGS84 +datum=WGS84 +no_defs",
	<?php echo ds_sqlite('barrier_layer_'.strtr($layer,'-','_'));?>
	<?php else: ?>
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_barrier_short($layer));?>
	<?php endif; ?>
},
{
	"id": "barrierpoint-layer<?php echo $layer?>",
	"name": "barrierpoint-layer<?php echo $layer?>",
	"class": "barrierpoint layer<?php echo $layer?>",
	<?php if ( $TILE ): ?>
	"srs": "+proj=longlat +ellps=WGS84 +datum=WGS84 +no_defs",
	<?php echo ds_sqlite('barrier_point_layer_'.strtr($layer,'-','_'));?>
	<?php else: ?>
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_barrier_point_short($layer));?>
	<?php endif; ?>
	
}
