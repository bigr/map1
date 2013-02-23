<?php
	require_once "sql/pisteway.sql.php";
	require_once "conf/sqlite.php";
?>
{
	"id": "pisteway-layer<?php echo $layer?>",
	"name": "pisteway-layer<?php echo $layer?>",
	"class": "pisteway layer<?php echo $layer?>",
	<?php if ( $TILE ): ?>	
	"srs": "+proj=longlat +ellps=WGS84 +datum=WGS84 +no_defs",
	<?php echo ds_sqlite('pisteway_layer_'.strtr($layer,'-','_'));?>
	<?php else: ?>
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_pisteway_short($layer));?>
	<?php endif; ?>
	
},
{
	"id": "pistearea-layer<?php echo $layer?>",
	"name": "pistearea-layer<?php echo $layer?>",
	"class": "pistearea layer<?php echo $layer?>",
	<?php if ( $TILE ): ?>	
	"srs": "+proj=longlat +ellps=WGS84 +datum=WGS84 +no_defs",
	<?php echo ds_sqlite('pistearea_layer_'.strtr($layer,'-','_'));?>
	<?php else: ?>
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_pistearea_short($layer));?>
	<?php endif; ?>
	
}
