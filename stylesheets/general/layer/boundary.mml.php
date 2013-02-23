<?php
	require_once "conf/boundary.conf.php";
	require_once "sql/boundary.sql.php";
	require_once "conf/sqlite.php";
?>
<?php foreach($RENDER_BOUNDARY_LEVELS as $level): ?>
{
	"id": "boundary-level<?php echo $level?>",
	"name": "boundary-level<?php echo $level?>",
	"class": "boundary level<?php echo $level?>",
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_boundary_short($level));?>
}
<?php if ($level != end($RENDER_BOUNDARY_LEVELS)) echo ",";?>
<?php endforeach; ?>
,
<?php foreach($RENDER_BOUNDARY_PA_CLASSES as $class): ?>
{
	"id": "paboundary-class<?php echo $class?>",
	"name": "paboundary-class<?php echo $class?>",
	"class": "paboundary class<?php echo $class?>",	
	<?php if ( $TILE ): ?>
	"srs": "+proj=longlat +ellps=WGS84 +datum=WGS84 +no_defs",
	<?php echo ds_sqlite('paboundary_tbl_'.$class);?>
	<?php else: ?>
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_boundary_pa_short($class));?>
	<?php endif; ?>
	
}
<?php if ($class != end($RENDER_BOUNDARY_PA_CLASSES)) echo ",";?>
<?php endforeach; ?>
