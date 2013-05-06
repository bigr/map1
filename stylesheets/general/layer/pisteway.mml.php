<?php
	require_once "sql/pisteway.sql.php";
	require_once "conf/sqlite.php";
?>
	
{
	"id": "pisteway-layer<?php echo $layer?>",
	"name": "pisteway-layer<?php echo $layer?>",
	"class": "pisteway layer<?php echo $layer?>",	
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_pisteway_short($layer));?>	
	
},
{
	"id": "pistearea-layer<?php echo $layer?>",
	"name": "pistearea-layer<?php echo $layer?>",
	"class": "pistearea layer<?php echo $layer?>",	
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_pistearea_short($layer));?>
	
}

