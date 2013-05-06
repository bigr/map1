<?php
	require_once "sql/power.sql.php";
?>
<?php if ( $TILE ): ?>	
{
	"id": "power-layer<?php echo $layer?>",
	"name": "power-layer<?php echo $layer?>",
	"class": "power layer<?php echo $layer?>",	
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_power_short($layer));?>	
},
{
	"id": "powerpoint-layer<?php echo $layer?>",
	"name": "powerpoint-layer<?php echo $layer?>",
	"class": "powerpoint layer<?php echo $layer?>",	
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_powerpoint_short($layer));?>
}
<?php endif; ?>
