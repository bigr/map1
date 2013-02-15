<?php
	require_once "sql/landcover.sql.php";
	require_once "conf/shapefile.php";
	require_once "conf/sqlite.php";	
?>
<?php if ( $RENDER_COASTLINE ):?>
	{
		"id": "coastline-<?php echo $layer?>",
		"name": "coastline-layer<?php echo $layer?>",
		"class": "coastline layer<?php echo $layer?>",
		"srs": "<?php echo SRS900913?>",		
		<?php echo ds_shapefile('water_polygons');?>
	}
	<?php if ( $RENDER_PLACESCOVER || $RENDER_STD_LANDCOVER || $RENDER_RESIDENTIALCOVER_HACK ) echo ","; ?>
<?php endif?>

<?php if ( $RENDER_RESIDENTIALCOVER_HACK ):?>
{
	"id": "residentialcoverhack",
	"name": "residentialcoverhack",
	"class": "residentialcoverhack",
	"srs": "<?php echo SRS900913?>",
	<?php if ( $TILE ): ?>
	"srs": "+proj=longlat +ellps=WGS84 +datum=WGS84 +no_defs",
	<?php echo ds_sqlite('residentialcover');?>
	<?php else: ?>
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_residentialcover_hack());?>
	<?php endif; ?>
	
}
<?php if ( $RENDER_PLACESCOVER || $RENDER_STD_LANDCOVER) echo ","; ?>
<?php endif?>

<?php if ( $RENDER_PLACESCOVER ):?>
{
	"id": "placescover",
	"name": "placescover",
	"class": "placescover",
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_placescover());?>
}
<?php if ( $RENDER_STD_LANDCOVER) echo ","; ?>
<?php endif?>

<?php if ( $RENDER_STD_LANDCOVER ):?>
{
	"id": "landcover",
	"name": "landcover",
	"class": "landcover",
	<?php if ( $TILE ): ?>
	"srs": "+proj=longlat +ellps=WGS84 +datum=WGS84 +no_defs",
	<?php echo ds_sqlite('landcover_tbl');?>
	<?php else: ?>
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_landcover());?>
	<?php endif; ?>		
}
<?php endif?>


