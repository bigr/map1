<?php
	require_once "conf/railway.conf.php";
?>

<?php foreach ( $RENDER_ZOOMS as $zoom ):?>		
	<?php foreach ( $RAILWAY_GRADES[$zoom] as $grade ):?>
		.railway[type = 'train'][zoom = <?php echo $zoom?>][grade = <?php echo $grade?>] {								
			::dark {
				line-color: <?php echo linear($RAILWAY_DARK_COLOR[$grade],$zoom)?>;
				line-width: <?php echo exponential($RAILWAY_WIDTH[$grade],$zoom)?>;				
				line-cap: round; 
				line-join: round;
								
				[is_bridge = 'yes'][is_construction = 'no'] {
					line-cap: butt;
				}
				
				<?php if ( $grade <= 3 ): ?>
					[is_construction = 'yes'] {
						line-opacity: 0.1;
					}
				<?php endif; ?>
			}		
			::light {								
				line-color: <?php echo linear($RAILWAY_LIGHT_COLOR[$grade],$zoom)?>;
				line-width: <?php echo (exponential($RAILWAY_WIDTH[$grade],$zoom) - 2 * exponential($RAILWAY_STROKE_WIDTH[$grade],$zoom))?>;				
				line-dasharray: <?php echo implode(exponential($RAILWAY_FILL_DASH[$grade],$zoom),',')?>;
				line-cap: round; 
				line-join: round;
				
				<?php if ( $grade <= 3 ): ?>
					[is_construction = 'yes'] {
						line-opacity: 0.07;
					}
				<?php endif; ?>
				
			}						
		}
	<?php endforeach;?>		
	
<?php endforeach;?>

