<?php
	require_once "conf/highway.conf.php";
	require_once "conf/symbol.conf.php";
?>



<?php foreach ( $RENDER_ZOOMS as $zoom ):?>
	<?php foreach ( $ROAD_GRADES[$zoom] as $grade ):?>
		.gridinfoHighway[type = 'road'][zoom = <?php echo $zoom?>][grade = <?php echo $grade?>] {	
			line-width: <?php echo max(10,exponential($ROAD_WIDTH[$grade],$zoom))?>
		}
	<?php endforeach;?>
	
	.gridinfoSymbol[zoom = <?php echo $zoom?>] {
		<?php foreach ( $SYMBOL AS $selector => $a ): ?>	    
			<?php if ( !empty($a['zooms']) && in_array($zoom,$a['zooms']) ): ?>
			<?php echo $selector?> {
				<?php if ( !empty($a['symbol-file']) ): ?>
					point-file: url('symbol/~<?php echo $a['symbol-file']?>-<?php echo $zoom?>-<?php echo empty($a['symbol-color']) ? '#000000' : linear($a['symbol-color'],$zoom)?>.png');
				<?php endif; ?>
			}
			<?php endif; ?>
		<?php endforeach; ?>
    }    
	
<?php endforeach;?>

