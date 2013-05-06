<?php
	require_once "sql/building.sql.php";
?>
{
	"id": "text-building-priority<?php echo $priority?>",
	"name": "text-building-priority<?php echo $priority?>",
	"class": "textBuilding priority<?php echo $priority?>",	
	"srs": "<?php echo SRS900913?>",	
	<?php echo ds_pgis(sql_text_building_short($priority));?>		
}
