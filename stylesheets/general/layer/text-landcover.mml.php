<?php
	require_once "sql/text-landcover.sql.php";
?>
{
	"id": "text-landcover-priority<?php echo $priority?>",
	"name": "text-landcover-priority<?php echo $priority?>",
	"class": "textLandcover priority<?php echo $priority?>",	
	"srs": "<?php echo SRS900913?>",	
	<?php echo ds_pgis(sql_text_landcover_short());?>	
}
