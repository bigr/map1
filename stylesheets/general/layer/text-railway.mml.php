<?php
	require_once "sql/railway.sql.php";
	
?>
{
	"id": "text-railway-priority<?php echo $priority?>",
	"name": "text-railway-priority<?php echo $priority?>",
	"class": "textRailway priority<?php echo $priority?>",	
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_text_railway($priority));?>		
}
