<?php
	require_once "sql/gridinfo.sql.php";
?>
{
	"id": "gridinfo-highway-layer",
	"name": "gridinfo-highway-layer",
	"class": "gridinfoHighway",
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_gridinfoHighway());?>
},
{
	"id": "gridinfo-symbol-layer",
	"name": "gridinfo-symbol-layer",
	"class": "gridinfoSymbol",
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_gridinfoSymbol());?>
}


