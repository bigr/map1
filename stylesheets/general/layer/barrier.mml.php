<?php
	require_once "sql/barrier.sql.php";
?>
{
	"id": "barrier-layer<?php echo $layer?>",
	"name": "barrier-layer<?php echo $layer?>",
	"class": "barrier layer<?php echo $layer?>",
	"srs": "<?php echo SRS900913?>",			
	<?php echo ds_pgis(sql_barrier_short($layer));?>
},
{
	"id": "barrierpoint-layer<?php echo $layer?>",
	"name": "barrierpoint-layer<?php echo $layer?>",
	"class": "barrierpoint layer<?php echo $layer?>",	
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_barrierpoint_short($layer));?>
	
}
