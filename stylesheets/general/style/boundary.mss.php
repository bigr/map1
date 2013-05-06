<?php
	require_once "conf/boundary.conf.php";
	require_once "inc/patterns.php";
?>

<?php foreach ( $RENDER_ZOOMS as $zoom ):?>		
	<?php foreach ( $BOUNDARY_LEVELS[$zoom] as $level ):?>
		.boundary.level<?php echo $level;?>[zoom = <?php echo $zoom?>] {						
			<?php if ( in_array($level,$BOUNDARY_BACKGROUND[$zoom]) ):?>
			line-color: #ffffff;
			line-width: <?php echo exponential($BOUNDARY_WIDTH[$level],$zoom); ?>;
			<?php endif; ?>						
			
			xxx/line-width: <?php echo exponential($BOUNDARY_WIDTH[$level],$zoom); ?>;
			xxx/line-color: <?php echo linear($BOUNDARY_COLOR[$level],$zoom); ?>;
			<?php if ( in_array($level,$BOUNDARY_RENDER_DASH[$zoom]) ):?>
				xxx/line-dasharray: <?php echo implode(',',exponential($BOUNDARY_DASH[$level],$zoom)); ?>;
			<?php endif;?>
			xxx/line-opacity: <?php echo exponential($BOUNDARY_OPACITY[$level],$zoom); ?>;
			
			<?php if ( in_array($level,$BOUNDARY_GLOW[$zoom]) ):?>
			::glow {
				line-width: <?php echo exponential($BOUNDARY_GLOW_WIDTH[$level],$zoom); ?>;
				line-color: <?php echo linear($BOUNDARY_GLOW_COLOR[$level],$zoom); ?>;				
				line-opacity: <?php echo exponential($BOUNDARY_GLOW_OPACITY[$level],$zoom); ?>;
			}
			<?php endif; ?>
		}
	<?php endforeach;?>
	
	
	<?php foreach ( $BOUNDARY_PA_CLASSES[$zoom] as $class ):?>
		.paboundary.class<?php echo $class;?>[zoom = <?php echo $zoom?>][way_area >= <?php echo pixelareas($BOUNDARY_PA_MINIMAL_AREA,$zoom)?>] {
			<?php foreach( pixelarea2selector($BOUNDARY_PA_WIDTH,$zoom) as $selector3 => $width ): ?>
				<?php echo $selector3?> {
					<?php if ( empty($UTFGRID) ): ?>
						<?php if ( in_array($class,$BOUNDARY_PA_BACKGROUND[$zoom]) ):?>
							line-color: #ffffff;
							line-width: <?php echo exponential($width,$zoom); ?>;
						<?php endif; ?>						
						
						xxx/line-width: <?php echo exponential($width,$zoom); ?>;
						xxx/line-color: <?php echo linear($BOUNDARY_PA_COLOR[$class],$zoom); ?>;
						<?php if ( in_array($class,$BOUNDARY_PA_RENDER_DASH[$zoom]) ):?>
							xxx/line-dasharray: <?php echo implode(',',array_map(function($a) use($width,$zoom) { return round(floatval($a)*floatval(exponential($width,$zoom)/5.0)); },exponential($BOUNDARY_PA_DASH[$class],$zoom))); ?>;
						<?php endif;?>
						xxx/line-opacity: <?php echo exponential($BOUNDARY_PA_OPACITY[$class],$zoom); ?>;
						
						<?php //if ( in_array($class,$BOUNDARY_PA_GLOW[$zoom]) ):?>
						::glow {
							line-width: <?php echo exponential($width,$zoom)*2.5; ?>;
							line-color: <?php echo linear($BOUNDARY_PA_GLOW_COLOR[$class],$zoom); ?>;				
							line-opacity: 0.05;
						}
						<?php //endif; ?>
					<?php else: ?>
							polygon-fill: #ffffff;							
					<?php endif; ?>
				}			
			<?php endforeach;?>
		}
	<?php endforeach;?>
	
<?php endforeach;?>

