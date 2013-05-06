<?php
	require_once "sql/landcover.sql.php";
	require_once "conf/shapefile.php";
	require_once "conf/sqlite.php";	
?>
<?php if ( $RENDER_COASTLINE ):?>
	{
		"id": "coastline",
		"name": "coastline",
		"class": "coastline",
		"srs": "<?php echo SRS900913?>",		
		<?php echo ds_shapefile('water_polygons');?>
	}
	<?php if ( $RENDER_PLACESCOVER || $RENDER_STD_LANDCOVER || $RENDER_RESIDENTIALCOVER_HACK || $RENDER_LINE_LANDCOVER || $RENDER_POINT_LANDCOVER) echo ","; ?>
<?php endif?>

<?php if ( $RENDER_RESIDENTIALCOVER_HACK ):?>
{
	"id": "residentialcoverhack",
	"name": "residentialcoverhack",
	"class": "residentialcoverhack",
	"srs": "<?php echo SRS900913?>",	
	<?php echo ds_pgis(sql_residentialcover_hack());?>
}
<?php if ( $RENDER_PLACESCOVER || $RENDER_STD_LANDCOVER || $RENDER_LINE_LANDCOVER || $RENDER_POINT_LANDCOVER) echo ","; ?>
<?php endif?>

<?php if ( $RENDER_PLACESCOVER ):?>
{
	"id": "placescover",
	"name": "placescover",
	"class": "placescover",
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_placescover());?>
}
<?php if ( $RENDER_STD_LANDCOVER || ($TILE && ($RENDER_LINE_LANDCOVER || $RENDER_POINT_LANDCOVER)) ) echo ","; ?>
<?php endif?>

<?php if ( $RENDER_STD_LANDCOVER ):?>
{
	"id": "landcover",
	"name": "landcover",
	"class": "landcover",	
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_landcover_short());?>	
}
<?php if ( $TILE && ($RENDER_LINE_LANDCOVER || $RENDER_POINT_LANDCOVER) ) echo ","; ?>
<?php endif?>


<?php if ( $TILE && $RENDER_LINE_LANDCOVER ):?>
{
	"id": "landcover_line",
	"name": "landcover_line",
	"class": "landcover_line",	
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_landcover_line_short());?>	
}
<?php if ( $RENDER_POINT_LANDCOVER ) echo ","; ?>
<?php endif?>

<?php if ( $TILE && $RENDER_POINT_LANDCOVER ):?>
{
	"id": "landcover_point",
	"name": "landcover_point",
	"class": "landcover_point",	
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_landcover_point_short());?>
}
<?php endif?>


