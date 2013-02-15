<?php
	require_once "conf/boundary.conf.php";
	require_once "sql/boundary.sql.php";
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
