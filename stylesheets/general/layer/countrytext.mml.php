<?php
	require_once "conf/shapefile.php";
?>

<?php if ( $RENDER_COUNTRYTEXT ):?>
{
	"id": "countrytext",
	"name": "countrytext",
	"class": "countrytext",
	"srs": "<?php echo SRS4326?>",		
	<?php echo ds_osmfile('countries');?>
}
<?php endif?>


