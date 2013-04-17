<?php
	require_once "sql/highway.sql.php";
	require_once "conf/sqlite.php";	
?>
<?php if ( $TILE ): ?>
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
<?php endif; ?>
{
	"id": "highway-major-layer<?php echo $layer?>",
	"name": "highway-major-layer<?php echo $layer?>",
	"class": "highway layer<?php echo $layer?>",	
	<?php if ( $TILE ): ?>	
	"srs": "+proj=longlat +ellps=WGS84 +datum=WGS84 +no_defs",
	<?php echo ds_sqlite('highways_major_layer_'.strtr($layer,'-','_'));?>
	<?php else: ?>
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_highway_norect($layer));?>
	<?php endif; ?>
}
<?php if ( $TILE ): ?>
,
{
	"id": "highway-area-layer<?php echo $layer?>",
	"name": "highway-area-layer<?php echo $layer?>",
	"class": "highwayArea layer<?php echo $layer?>",	
	<?php if ( $TILE ): ?>	
	"srs": "+proj=longlat +ellps=WGS84 +datum=WGS84 +no_defs",
	<?php echo ds_sqlite('highways_area_layer_'.strtr($layer,'-','_'));?>
	<?php else: ?>
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_highway_area_layer($layer));?>
	<?php endif; ?>
},
{
	"id": "highwaypoint-layer<?php echo $layer?>",
	"name": "highwaypoint-layer<?php echo $layer?>",
	"class": "highwaypoint layer<?php echo $layer?>",
	<?php if ( $TILE ): ?>
	"srs": "+proj=longlat +ellps=WGS84 +datum=WGS84 +no_defs",
	<?php echo ds_sqlite('highway_point_layer_'.strtr($layer,'-','_'));?>
	<?php else: ?>
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_highway_point_short($layer));?>
	<?php endif; ?>	
}
<?php endif; ?>
