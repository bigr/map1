<?php
	require_once "sql/aerialway.sql.php";
	
?>
{
	"id": "text-aerialway-priority<?php echo $priority?>",
	"name": "text-aerialway-priority<?php echo $priority?>",
	"class": "textAerialway priority<?php echo $priority?>",	
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_aerialway_text($priority));?>		
}

