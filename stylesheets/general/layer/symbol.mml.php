<?php
	require_once "sql/symbol.sql.php";
?>
{
	"id": "symbol",
	"name": "symbol",
	"class": "symbol",
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_symbol_short());?>
}


