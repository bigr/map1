<?php
	require_once "sql/railway.sql.php";
?>
{
	"id": "railway-layer<?php echo $layer?>",
	"name": "railway-layer<?php echo $layer?>",
	"class": "railway layer<?php echo $layer?>",
	<?php if ( $TILE ): ?>
	"srs": "+proj=longlat +ellps=WGS84 +datum=WGS84 +no_defs",
	<?php echo ds_sqlite('railways_layer_'.strtr($layer,'-','_'));?>
	<?php else: ?>
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_railway_short($layer));?>
	<?php endif; ?>
}
