<?php
	require_once "sql/boundary.sql.php";
?>
{
	"id": "text-paboundary-priority<?php echo $priority?>",
	"name": "text-paboundary-priority<?php echo $priority?>",
	"class": "textPaboundary priority<?php echo $priority?>",	
	"srs": "<?php echo SRS900913?>",	
	<?php echo ds_pgis(sql_boundary_pa_text_short());?>		
}
