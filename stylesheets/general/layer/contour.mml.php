<?php
	require_once "sql/contour.sql.php";
	require_once "conf/shapefile.php";
?>
{
	"id": "contour",
	"name": "contour",
	"class": "contour",
	"srs": "<?php echo SRS900913?>",
	<?php if ( $TILE ): ?>	
	<?php echo ds_shapefile_raw("/home/klinger/mymap/data/tiles/aster/~$TILE.contours.shp");?>
	<?php else: ?>
	<?php echo ds_pgis(sql_contour());?>
	<?php endif; ?>
}

