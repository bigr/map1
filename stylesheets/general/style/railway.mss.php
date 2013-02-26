<?php
	require_once "conf/railway.conf.php";
	require_once "conf/highway.conf.php";
?>

<?php foreach ( $RENDER_ZOOMS as $zoom ):?>		
	<?php foreach ( $RAILWAY_GRADES[$zoom] as $grade ):?>
		.railway[type = 'train'][zoom = <?php echo $zoom?>][grade = <?php echo $grade?>] {
			::bridge-fill[is_bridge = 'yes'][way_length > <?php echo $MIN_BRIDGE_SIZE*getPixelSize($zoom)?>] {
				line-width: <?php echo exponential($ROAD_WIDTH[$grade],$zoom)+4?>;
				line-color: #000000;
			}
			::bridge-fill2[is_bridge = 'yes'][way_length > <?php echo $MIN_BRIDGE_SIZE*getPixelSize($zoom)?>] {
				line-width: <?php echo exponential($ROAD_WIDTH[$grade],$zoom)+2?>;
				line-color: #ffffff;
			}
										
			
			line-color: <?php echo linear($RAILWAY_DARK_COLOR[$grade],$zoom)?>;
			line-width: <?php echo exponential($RAILWAY_WIDTH[$grade],$zoom)?>;				
			line-cap: round; 
			line-join: round;
							
			[is_bridge = 'yes'][is_construction = 'no'] {
				line-cap: butt;
			}
			
			[is_tunnel = 'yes'][is_construction = 'no'][way_length > <?php echo $MIN_TUNNEL_SIZE*getPixelSize($zoom)?>] {
				line-color: lighten(<?php echo linear($RAILWAY_DARK_COLOR[$grade],$zoom)?>,50);
			}
			
			
			[is_construction = 'yes'] {
				line-color: lighten(<?php echo linear($RAILWAY_DARK_COLOR[$grade],$zoom)?>,75);
			}
				
			
									
			light/line-color: <?php echo linear($RAILWAY_LIGHT_COLOR[$grade],$zoom)?>;
			light/line-width: <?php echo (exponential($RAILWAY_WIDTH[$grade],$zoom) - 2 * exponential($RAILWAY_STROKE_WIDTH[$grade],$zoom))?>;				
			light/line-dasharray: <?php echo implode(exponential($RAILWAY_FILL_DASH[$grade],$zoom),',')?>;
			light/line-cap: round; 
			light/line-join: round;						
				
			[is_bridge = 'yes'][is_construction = 'no'] {
				light/line-cap: butt;
			}	
				
			[is_tunnel = 'yes'][is_construction = 'no'][way_length > <?php echo $MIN_TUNNEL_SIZE*getPixelSize($zoom)?>] {
				light/line-color: darken(<?php echo linear($RAILWAY_DARK_COLOR[$grade],$zoom)?>,5);
			}									
									
		}
	<?php endforeach;?>		
	
<?php endforeach;?>

