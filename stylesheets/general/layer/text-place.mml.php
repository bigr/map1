<?php
	require_once "sql/text-place.sql.php";
?>
{
	"id": "text-place-priority<?php echo $priority?>",
	"name": "text-place-priority<?php echo $priority?>",
	"class": "textPlace priority<?php echo $priority?>",
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_text_place_short($priority));?>
	<?php if( $priority < 0 || $clearCache ): $clearCache = false; ?>
	,"properties" : {
		 "clear-label-cache": "true"
	}
	<?php endif; ?>
}
