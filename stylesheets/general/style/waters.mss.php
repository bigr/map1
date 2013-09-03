<?php
	require_once "inc/patterns.php";
	require_once "conf/waters.conf.php";
?>

<?php foreach ( $RENDER_ZOOMS as $zoom ):?>	
	[zoom = <?php echo $zoom?>] {		
		<?php if ( $RENDER_WATERWAY ):?>
			<?php foreach ( array_filter(range(0,35), function($x) use ($zoom) { return waterway_grades($zoom,$x); }) as $grade ):?>
				.waterway[grade = <?php echo $grade?>] {			
					line-color: <?php echo linear(waterway_color($grade),$zoom)?>;
					line-width: <?php echo waterway_width($zoom,$grade)?>;				
					line-cap: round; 
					line-join: round;	
					line-smooth: 1;				
				}
			<?php endforeach;?>	
		<?php endif ?>
		
		<?php if ( $RENDER_WATERAREA ):?>
			.waterarea[way_area >= <?php echo pixelareas($WATERAREA_MINIMAL_AREA,$zoom)?>] {
				<?php foreach ( $WATERAREA AS $selector => $a ): ?>
					<?php if ( !empty($a['zooms']) &&  in_array($zoom,$a['zooms']) ):?>
						<?php echo $selector?>::level<?php echo $a['level']?> {
							polygon-fill: <?php echo linear($a['color'],$zoom)?>;
							<?php if ( !empty($a['stroke']) ):?>
								line-color: <?php echo linear($a['stroke-color'],$zoom)?>;
								line-width: <?php echo exponential($a['stroke'],$zoom)?>;
							<?php endif; ?>
						}
					<?php endif;?>
					<?php if ( !empty($a['pattern-zooms']) && in_array($zoom,$a['pattern-zooms']) ): ?>
							
						<?php echo $selector?>::level<?php echo $a['level']?> {
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
						}
					<?php endif; ?>
				<?php endforeach; ?>
			}
		<?php endif; ?>
		
		.waterpoint {
		<?php foreach ( $WATERPOINT AS $selector => $a ): ?>	    
			<?php if ( !empty($a['zooms']) && in_array($zoom,$a['zooms']) ): ?>
			<?php echo $selector?> {
				<?php if ( !empty($a['symbol-file']) ): ?>
							 point-file: url('../../general/symbol/~<?php echo $a['symbol-file']?>-<?php echo $zoom?>-<?php echo empty($a['symbol-color']) ? '#000000' : linear($a['symbol-color'],$zoom)?>.png');			 
				<?php endif; ?>
					}
			<?php endif; ?>
		<?php endforeach; ?>
		}
		
		<?php if ( in_array($zoom,$WATERWAY_WEIR) ): ?>
		.waterway2[waterway='weir'] {
			line-color: lighten(<?php echo linear($_WATER_COLOR,$zoom)?>,20);
			line-width: <?php echo exponential($WATERWAY_WEIR_LINE_WIDTH,$zoom) ?>;
			b/line-color: lighten(<?php echo linear($_WATER_COLOR,$zoom)?>,20);
			b/line-width: <?php echo exponential($WATERWAY_WEIR_WIDTH,$zoom) ?>;
			b/line-dasharray: <?php echo round(exponential($WATERWAY_WEIR_WIDTH,$zoom) - exponential($WATERWAY_WEIR_LINE_WIDTH,$zoom)) ?>,<?php echo round(exponential($WATERWAY_WEIR_WIDTH,$zoom) - exponential($WATERWAY_WEIR_LINE_WIDTH,$zoom)) ?>;
		}
		<?php endif; ?>
		
		<?php if ( in_array($zoom,$WATERWAY_DAM) ): ?>
		.waterway2[waterway='dam'] {
			line-color: lighten(<?php echo linear($_WATER_COLOR,$zoom)?>,20);
			line-width: <?php echo exponential($WATERWAY_DAM_LINE_WIDTH,$zoom) ?>;
			b/line-color: lighten(<?php echo linear($_WATER_COLOR,$zoom)?>,20);
			b/line-width: <?php echo exponential($WATERWAY_DAM_WIDTH,$zoom) ?>;
			b/line-dasharray: <?php echo round(exponential($WATERWAY_DAM_WIDTH,$zoom) - exponential($WATERWAY_DAM_LINE_WIDTH,$zoom)) ?>,<?php echo round(exponential($WATERWAY_DAM_WIDTH,$zoom) - exponential($WATERWAY_DAM_LINE_WIDTH,$zoom)) ?>;
		}
		<?php endif; ?>
		    
	}
<?php endforeach;?>

