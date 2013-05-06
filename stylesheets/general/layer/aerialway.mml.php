<?php
	require_once "sql/aerialway.sql.php";
?>
{
	"id": "aerialway-layer<?php echo $layer?>",
	"name": "aerialway-layer<?php echo $layer?>",
	"class": "aerialway layer<?php echo $layer?>",	
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_aerialway_short($layer));?>	
},
{
	"id": "aerialwaypoint-layer<?php echo $layer?>",
	"name": "aerialwaypoint-layer<?php echo $layer?>",
	"class": "aerialwaypoint layer<?php echo $layer?>",	
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_aerialpoint_short($layer));?>
	
}
