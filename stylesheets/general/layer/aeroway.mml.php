<?php
	require_once "sql/aeroway.sql.php";
	require_once "conf/sqlite.php";
?>
{
	"id": "aeroway-layer<?php echo $layer?>",
	"name": "aeroway-layer<?php echo $layer?>",
	"class": "aeroway layer<?php echo $layer?>",	
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_aeroway_short($layer));?>		
},
{
	"id": "aeroarea-layer<?php echo $layer?>",
	"name": "aeroarea-layer<?php echo $layer?>",
	"class": "aeroarea layer<?php echo $layer?>",	
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_aeroarea_short($layer));?>
	
}
