<?php
	require_once "sql/aerialway.sql.php";
?>
{
	"id": "aerialway-layer<?php echo $layer?>",
	"name": "aerialway-layer<?php echo $layer?>",
	"class": "aerialway layer<?php echo $layer?>",
	<?php if ( $TILE ): ?>	
	"srs": "+proj=longlat +ellps=WGS84 +datum=WGS84 +no_defs",
	<?php echo ds_sqlite('aerialway_layer_'.strtr($layer,'-','_'));?>
	<?php else: ?>
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_aerialway_short($layer));?>
	<?php endif; ?>
	
},
{
	"id": "aerialwaypoint-layer<?php echo $layer?>",
	"name": "aerialwaypoint-layer<?php echo $layer?>",
	"class": "aerialwaypoint layer<?php echo $layer?>",
	<?php if ( $TILE ): ?>	
	"srs": "+proj=longlat +ellps=WGS84 +datum=WGS84 +no_defs",
	<?php echo ds_sqlite('aerialway_point_layer_'.strtr($layer,'-','_'));?>
	<?php else: ?>
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_aerialway_point($layer));?>
	<?php endif; ?>
	
}
