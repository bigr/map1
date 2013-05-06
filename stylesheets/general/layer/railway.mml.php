<?php
	require_once "sql/railway.sql.php";
	require_once "conf/sqlite.php";	
?>
{
	"id": "railway-layer<?php echo $layer?>",
	"name": "railway-layer<?php echo $layer?>",
	"class": "railway layer<?php echo $layer?>",	
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_railway_short($layer));?>	
}
