<?php
	require_once "sql/text-route.sql.php";
?>
<?php if ( $TILE ): ?>
{
	"id": "text-route-ref-priority<?php echo $priority?>",
	"name": "text-route-ref-priority<?php echo $priority?>",
	"class": "textRouteRef priority<?php echo $priority?>",
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_text_route_ref($priority));?>
},
{
	"id": "text-route-name-priority<?php echo $priority?>",
	"name": "text-route-name-priority<?php echo $priority?>",
	"class": "textRouteName priority<?php echo $priority?>",
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_text_route_name($priority));?>
},
{
	"id": "text-osmcsymbol<?php echo $priority?>",
	"name": "text-osmcsymbol-priority<?php echo $priority?>",
	"class": "textOsmcsymbol priority<?php echo $priority?>",
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_text_osmcsymbol($priority));?>
}
<?php endif; ?>
