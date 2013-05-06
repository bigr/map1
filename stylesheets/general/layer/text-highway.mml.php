<?php
	require_once "sql/text-highway.sql.php";
	
?>
{
	"id": "text-highway-priority<?php echo $priority?>",
	"name": "text-highway-priority<?php echo $priority?>",
	"class": "textHighway priority<?php echo $priority?>",	
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_text_highway_short($priority));?>		
},
{
	"id": "text-highway-e-priority<?php echo $priority?>",
	"name": "text-highway-e-priority<?php echo $priority?>",
	"class": "textHighwayE priority<?php echo $priority?>",	
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_text_highway_e($priority));?>	
},
{
	"id": "text-highway-access-priority<?php echo $priority?>",
	"name": "text-highway-access-priority<?php echo $priority?>",
	"class": "textHighwayAccess priority<?php echo $priority?>",	
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_text_highway_access_short($priority));?>	
}
