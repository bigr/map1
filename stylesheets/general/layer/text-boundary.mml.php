<?php
	require_once "sql/boundary.sql.php";
?>
{
	"id": "text-paboundary-priority<?php echo $priority?>",
	"name": "text-paboundary-priority<?php echo $priority?>",
	"class": "textPaboundary priority<?php echo $priority?>",
	<?php if ( $TILE ): ?>
	"srs": "+proj=longlat +ellps=WGS84 +datum=WGS84 +no_defs",
	<?php echo ds_sqlite('paboundary_tbl','centroid');?>	
	<?php else: ?>
	"srs": "<?php echo SRS900913?>",	
	<?php echo ds_pgis(sql_boundary_pa_short());?>
	<?php endif; ?>
	
}
