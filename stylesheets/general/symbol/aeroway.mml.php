<?php
	require_once "sql/aeroway.sql.php";
	require_once "conf/sqlite.php";
?>
{
	"id": "aeroway-layer<?php echo $layer?>",
	"name": "aeroway-layer<?php echo $layer?>",
	"class": "aeroway layer<?php echo $layer?>",
	<?php if ( $TILE ): ?>	
	"srs": "+proj=longlat +ellps=WGS84 +datum=WGS84 +no_defs",
	<?php echo ds_sqlite('aeroway_layer_'.strtr($layer,'-','_'));?>
	<?php else: ?>
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_aeroway_short($layer));?>
	<?php endif; ?>
	
},
{
	"id": "aeroarea-layer<?php echo $layer?>",
	"name": "aeroarea-layer<?php echo $layer?>",
	"class": "aeroarea layer<?php echo $layer?>",
	<?php if ( $TILE ): ?>	
	"srs": "+proj=longlat +ellps=WGS84 +datum=WGS84 +no_defs",
	<?php echo ds_sqlite('aeroarea_layer_'.strtr($layer,'-','_'));?>
	<?php else: ?>
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_aeroarea_short($layer));?>
	<?php endif; ?>
	
}
