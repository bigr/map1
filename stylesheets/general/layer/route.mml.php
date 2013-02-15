<?php
	require_once "sql/route.sql.php";
?>
<?php foreach(range(0,$ROUTE_MAX_COUNT) as $offset):?>
{
	"id": "route<?php echo $offset?>_hiking",
	"name": "route<?php echo $offset?>_hiking",
	"class": "route<?php echo $offset?> hiking",
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_route_hiking($offset));?>
},
{
	"id": "route<?php echo $offset?>_bicycle",
	"name": "route<?php echo $offset?>_bicycle",
	"class": "route<?php echo $offset?> bicycle",
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_route_bicycle($offset));?>
},
{
	"id": "route<?php echo $offset?>_ski",
	"name": "route<?php echo $offset?>_ski",
	"class": "route<?php echo $offset?> ski",
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_route_ski($offset));?>
}
<?php if ( $offset < $ROUTE_MAX_COUNT ) echo ',';?>
<?php endforeach; ?>

