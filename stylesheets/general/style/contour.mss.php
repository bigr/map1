<?php
	require_once "conf/contour.conf.php";
	require_once "inc/utils.php";
?>

<?php foreach ( $CONTOUR_MODULOS as $zoom => $modulos ):?>
	<?php foreach ( $modulos as $modulo ):?>
		.contour[zoom = <?php echo $zoom?>][<?php echo justModulo('ele',$modulo) ?>]::modulo-<?php echo $modulo?> {		
			line-color: <?php echo linear($CONTOUR_COLOR[$modulo],$zoom)?>;
			line-width: <?php echo linear($CONTOUR_WIDTH[$modulo],$zoom)?>;
			line-opacity: <?php echo linear($CONTOUR_OPACITY[$modulo],$zoom)?>;
			line-smooth: 1;			
		}
	<?php endforeach;?>
<?php endforeach;?>

