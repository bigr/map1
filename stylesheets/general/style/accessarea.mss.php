<?php
	require_once "inc/patterns.php";
	require_once "conf/accessarea.conf.php";
	require_once "conf/waters.conf.php";
?>



<?php foreach ( $RENDER_ZOOMS as $zoom ):?>
	
	.accessarea[zoom = <?php echo $zoom?>][way_area >= <?php echo pixelareas($ACCESSAREA_MINIMAL_AREA,$zoom)?>] {
		<?php foreach ( $ACCESSAREA AS $selector => $a ): ?>
		    <?php if ( !empty($a['zooms']) &&  in_array($zoom,$a['zooms']) ):?>
			<?php echo $selector?> {
			    ::level<?php echo $a['level']?> {					
				polygon-fill: <?php echo linear($a['color'],$zoom)?>;
				polygon-smooth: <?php echo !empty($a['smooth']) ? $a['smooth'] : 0  ?>;
			    }
			}
		    <?php endif;?>
		    <?php if ( !empty($a['pattern-zooms']) && in_array($zoom,$a['pattern-zooms']) ): ?>
			<?php echo $selector?> {
			    ::level<?php echo $a['level']?> {
				<?php if ( !empty($a['pattern-file']) ): ?>
				    polygon-pattern-file: url('../../general/pattern/~<?php echo $a['pattern-file']?>-<?php echo $zoom?>.png');
				<?php else: ?>
				    polygon-pattern-file: url('<?php echo
					    getPatternFile($a['pattern'],
						    exponential($a['pattern-size'],$zoom),
						    linear($a['pattern-rotation'],$zoom),
						    linear($a['pattern-opacity'],$zoom),
						    linear($a['pattern-color'],$zoom),
						    exponential($a['pattern-stroke'],$zoom)
					    )
				    ?>');
				<?php endif; ?>
				polygon-pattern-smooth: <?php echo !empty($a['smooth']) ? $a['smooth'] : 0  ?>;
			    }
			}
		    <?php endif; ?>
		<?php endforeach; ?>
	}
		
	
<?php endforeach;?>

