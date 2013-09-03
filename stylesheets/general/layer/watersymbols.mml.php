<?php
	require_once "conf/pgis.php";	
	require_once "sql/waters.sql.php";
	require_once "conf/sqlite.php";	
?>
<?php if ( $RENDER_WATERWAY && $TILE ): ?>	
	{
		"id": "waterpoint-layer<?php echo $layer?>",
		"name": "waterpoint-layer<?php echo $layer?>",
		"class": "waterpoint layer<?php echo $layer?>",		
		"srs": "<?php echo SRS900913?>",
		<?php echo ds_pgis(sql_waterpoint_short($layer));?>		
		
	}
<?php endif?>

