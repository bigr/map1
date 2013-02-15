<?php
	require_once "sql/countryfill.sql.php";
?>

<?php if ( $RENDER_COUNTRYFILL ):?>
{
	"id": "countryfill",
	"name": "countryfill",
	"class": "countryfill",
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_countryfill());?>
}
<?php endif?>


