<?php
	require_once "conf/railway.conf.php";
	require_once "conf/highway.conf.php";
?>

<?php foreach ( $RENDER_ZOOMS as $zoom ):?>		
	<?php foreach ( $RAILWAY_GRADES[$zoom] as $grade ):?>
		.railway[type = 'train'][zoom = <?php echo $zoom?>][grade = <?php echo $grade?>] {
			::bridge-fill[is_bridge = 'yes'][way_length > <?php echo $MIN_BRIDGE_SIZE*getPixelSize($zoom)?>] {
				line-width: <?php echo exponential($RAILWAY_WIDTH[$grade],$zoom)+5?>;
				line-color: #444444;
			}
			::bridge-fill2[is_bridge = 'yes'][way_length > <?php echo $MIN_BRIDGE_SIZE*getPixelSize($zoom)?>] {
				line-width: <?php echo exponential($RAILWAY_WIDTH[$grade],$zoom)+3?>;
				line-color: #ffffff;
			}
			
			::tunnel-fill[is_tunnel = 'yes'][way_length > <?php echo $MIN_BRIDGE_SIZE*getPixelSize($zoom)?>] {
				line-width: <?php echo exponential($RAILWAY_WIDTH[$grade],$zoom)+6?>;
				line-color: #666666;
				line-dasharray: 1,3;
			}
			::tunnel-fill2[is_tunnel = 'yes'][way_length > <?php echo $MIN_BRIDGE_SIZE*getPixelSize($zoom)?>] {
				line-width: <?php echo exponential($RAILWAY_WIDTH[$grade],$zoom)+4?>;
				line-color: #eeeeee;
			}
										
			
			line-color: <?php echo linear($RAILWAY_DARK_COLOR[$grade],$zoom)?>;
			
			line-width: <?php echo exponential($RAILWAY_WIDTH[$grade],$zoom)?>;				
			[is_tunnel = 'yes'][way_length > <?php echo $MIN_BRIDGE_SIZE*getPixelSize($zoom)?>] {
					line-width: <?php echo exponential($RAILWAY_WIDTH[$grade],$zoom)*0.75?>;				
			}
			
			line-cap: round; 
			line-join: round;
							
			[is_bridge = 'yes'][is_construction = 'no'] {
				line-cap: butt;
			}
			
			[is_tunnel = 'yes'][is_construction = 'no'][way_length > <?php echo $MIN_TUNNEL_SIZE*getPixelSize($zoom)?>] {
				line-color: lighten(<?php echo linear($RAILWAY_DARK_COLOR[$grade],$zoom)?>,40);
			}
			
			
			[is_construction = 'yes'] {
				line-color: lighten(<?php echo linear($RAILWAY_DARK_COLOR[$grade],$zoom)?>,60);
			}
				
			
									
			light/line-color: <?php echo linear($RAILWAY_LIGHT_COLOR[$grade],$zoom)?>;
			light/line-width: <?php echo (exponential($RAILWAY_WIDTH[$grade],$zoom) - 2 * exponential($RAILWAY_STROKE_WIDTH[$grade],$zoom))?>;		
			[is_tunnel = 'yes'][way_length > <?php echo $MIN_BRIDGE_SIZE*getPixelSize($zoom)?>] {
					light/line-width: <?php echo (exponential($RAILWAY_WIDTH[$grade],$zoom)*0.75 - 2 * exponential($RAILWAY_STROKE_WIDTH[$grade],$zoom))?>;		
			}		
			light/line-dasharray: <?php echo implode(exponential($RAILWAY_FILL_DASH[$grade],$zoom),',')?>;
			light/line-cap: round; 
			light/line-join: round;
				
			[is_bridge = 'yes'][is_construction = 'no'] {
				light/line-cap: butt;
			}	
				
			[is_tunnel = 'yes'][is_construction = 'no'][way_length > <?php echo $MIN_TUNNEL_SIZE*getPixelSize($zoom)?>] {
				light/line-color: darken(<?php echo linear($RAILWAY_LIGHT_COLOR[$grade],$zoom)?>,10);
			}									
									
		}
							
	<?php endforeach;?>		
	
	
	<?php if ( in_array($zoom,$SUBWAY_ZOOMS) ):?>
	.railway[type = 'subway'][zoom = <?php echo $zoom?>] {			
		line-color: <?php echo linear($SUBWAY_COLOR,$zoom)?>;
		[colour = 'yellow'] {
			line-color: #FFC619;
		}
		[colour = 'red'] {
			line-color: #992E2E;
		}
		[colour = 'green'] {
			line-color: #42661F;
		}
		line-opacity: <?php echo linear($SUBWAY_OPACITY,$zoom)?>;
		line-width: <?php echo linear($SUBWAY_WIDTH,$zoom)?>;
	}
	<?php endif; ?>
	
	<?php if ( in_array($zoom,$FUNICULAR_ZOOMS) ):?>
	.railway[type = 'funicular'][zoom = <?php echo $zoom?>] {			
		line-color: <?php echo linear($FUNICULAR_COLOR,$zoom)?>;			
		line-opacity: <?php echo linear($FUNICULAR_OPACITY,$zoom)?>;
		line-width: <?php echo linear($FUNICULAR_WIDTH,$zoom)?>;
		b/line-color: <?php echo linear($FUNICULAR_COLOR,$zoom)?>;			
		b/line-opacity: <?php echo linear($FUNICULAR_OPACITY,$zoom)?>;
		b/line-width: <?php echo linear($FUNICULAR_WIDTH2,$zoom)?>;
		b/line-dasharray: <?php echo 2*linear($FUNICULAR_WIDTH2,$zoom)?>,<?php echo linear($FUNICULAR_WIDTH2,$zoom)?>;
	}
	<?php endif; ?>
	
	
	<?php if ( in_array($zoom,$TRAM_ZOOMS) ):?>
	.railway[type = 'tram'][zoom = <?php echo $zoom?>] {
		
		line-color: <?php echo linear($TRAM_COLOR,$zoom)?>;
		line-opacity: <?php echo linear($TRAM_OPACITY,$zoom)?>;
		line-width: <?php echo linear($TRAM_WIDTH1,$zoom)?>;
		
		cross/line-color: <?php echo linear($TRAM_COLOR,$zoom)?>;
		cross/line-width: <?php echo linear($TRAM_WIDTH2,$zoom)?>;
		cross/line-opacity: <?php echo linear($TRAM_OPACITY,$zoom)?>;
		cross/line-dasharray: <?php echo linear($TRAM_WIDTH1,$zoom)?>,<?php echo linear($TRAM_WIDTH2,$zoom)?>;
		
	}
	<?php endif; ?>
	
<?php endforeach;?>

