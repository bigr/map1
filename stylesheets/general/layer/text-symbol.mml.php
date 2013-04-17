<?php
	require_once "sql/text-symbol.sql.php";
?>
{
	"id": "text-symbol-priority<?php echo $priority?>",
	"name": "text-symbol-priority<?php echo $priority?>",
	"class": "textSymbol priority<?php echo $priority?>",
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_symbol_short($priority));?>	
}


