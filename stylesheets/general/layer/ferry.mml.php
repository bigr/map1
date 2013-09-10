<?php
	require_once "sql/ferry.sql.php";
?>
{
	"id": "ferry",
	"name": "ferry",
	"class": "ferry",
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_ferry());?>
}

