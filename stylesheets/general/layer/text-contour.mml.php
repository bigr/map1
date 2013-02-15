<?php
	require_once "sql/text-contour.sql.php";
	require_once "conf/shapefile.php";
?>
{
	"id": "textContour-priority<?php echo $priority?>",
	"name": "textContour-priority<?php echo $priority?>",
	"class": "textContour priority<?php echo $priority?>",
	"srs": "<?php echo SRS900913?>",
	<?php if ( $TILE ): ?>
	<?php echo ds_shapefile_raw("/home/klinger/mymap/data/tiles/aster/~$TILE.contours.shp");?>
	<?php else: ?>
	<?php echo ds_pgis(sql_textContour());?>
	<?php endif; ?>
	
}

