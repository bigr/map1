<?php
	require_once "conf/highway.conf.php";
?>


<?php foreach ( $RENDER_ZOOMS as $zoom ):?>		
	<?php foreach ( $ROAD_GRADES[$zoom] as $grade ):?>
	
		.highwayArea[grade = <?php echo $grade?>][way_area >= <?php echo pixelareas($HIGHWAY_MINIMAL_AREA,$zoom)?>] {
			line-color: <?php echo linear($ROAD_STROKE_COLOR[$grade],$zoom)?>;
			line-width: <?php echo exponential($ROAD_STROKE_WIDTH[$grade],$zoom)?>;
			polygon-fill: <?php echo linear($ROAD_FILL_COLOR[$grade],$zoom)?>;
		}
				
		.highway.grade<?php echo $grade?>.road[zoom = <?php echo $zoom?>] {
			
			<?php if ($zoom <= 8):?>			 	
				::body[int_ref = 'no'] {
					line-color: #cc8888;
					line-width: <?php echo exponential($ROAD_WIDTH[$grade],$zoom)*exponential($ROAD_DRAFT_RATIO,$zoom)?>;
					line-cap: round;
					line-join: round;
				}			
			<?php endif;?>
			
			<?php if ($zoom <= 8):?>
				[int_ref != 'no'] {
			<?php endif;?>
															
			<?php if ( !in_array($grade,$ROAD_DRAFT_DRAW[$zoom]) ): ?>
			.bridge {
				::bridge-fill[is_bridge = 'yes'][way_length > <?php echo $MIN_BRIDGE_SIZE*getPixelSize($zoom)?>] {
					line-width: <?php echo exponential($ROAD_WIDTH[$grade],$zoom)+5?>;
					line-color: #444444;
				}
				::bridge-fill2[is_bridge = 'yes'][way_length > <?php echo $MIN_BRIDGE_SIZE*getPixelSize($zoom)?>] {
					line-width: <?php echo exponential($ROAD_WIDTH[$grade],$zoom)+3?>;
					line-color: #ffffff;
				}						
			}
			
			.tunnel {
				::tunnel-fill[is_tunnel = 'yes'][way_length > <?php echo $MIN_BRIDGE_SIZE*getPixelSize($zoom)?>] {
					line-width: <?php echo exponential($ROAD_WIDTH[$grade],$zoom)+6?>;
					line-color: #666666;
					line-dasharray: 1,3;
				}
				::tunnel-fill2[is_tunnel = 'yes'][way_length > <?php echo $MIN_BRIDGE_SIZE*getPixelSize($zoom)?>] {
					line-width: <?php echo exponential($ROAD_WIDTH[$grade],$zoom)+4?>;
					line-color: #eeeeee;
				}						
			}
			
			.stroke {
				<?php if ( $zoom >= 13): ?>					
					glow/line-color: <?php echo linear($ROAD_FILL_COLOR[$grade],$zoom)?>;
					glow/line-width: <?php echo exponential($ROAD_WIDTH[$grade],$zoom) + 2?>;
					glow/line-opacity: <?php echo linear($PATH_GLOW_OPACITY,$zoom)?>;
					[is_tunnel = 'yes'],[is_construction = 'yes'] {
						glow/line-opacity: 0;
						glow/line-width: 0;
					}					
				<?php endif; ?>
				line-color: <?php echo linear($ROAD_STROKE_COLOR[$grade],$zoom)?>;
				line-width: <?php echo exponential($ROAD_WIDTH[$grade],$zoom)?>;
				[is_tunnel = 'yes'][way_length > <?php echo $MIN_BRIDGE_SIZE*getPixelSize($zoom)?>] {
					line-width: <?php echo exponential($ROAD_WIDTH[$grade],$zoom)*0.75?>;
				}
				<?php if ( $grade == 8 and $zoom >= 13 ): ?>
				[highway = 'footway'] {
					line-width: <?php echo exponential($ROAD_WIDTH[HIGHWAY_RESIDENTIAL],$zoom)*($zoom>14?0.33:0.6)?>;
					[is_tunnel = 'yes'][way_length > <?php echo $MIN_BRIDGE_SIZE*getPixelSize($zoom)?>] {
						line-width: <?php echo exponential($ROAD_WIDTH[HIGHWAY_RESIDENTIAL],$zoom)*($zoom>14?0.33:0.6)*0.75?>;
					}
				}				
				<?php endif; ?>	
				
				<?php if ( $grade == HIGHWAY_SERVICE ): ?>
				[service = 'parking_aisle'],[service='drive-through'] {
					line-width: <?php echo exponential($ROAD_WIDTH[HIGHWAY_RESIDENTIAL],$zoom)*($zoom>14?0.4:0.75)?>;
					[is_tunnel = 'yes'][way_length > <?php echo $MIN_BRIDGE_SIZE*getPixelSize($zoom)?>] {
						line-width: <?php echo exponential($ROAD_WIDTH[HIGHWAY_RESIDENTIAL],$zoom)*($zoom>14?0.4:0.75)*0.75?>;
					}
				}			
				<?php endif; ?>
				
				<?php if ( $zoom > 14 ): ?>
				[oneway='yes'],[oneway='-1'] {
					line-width: <?php echo exponential($ROAD_WIDTH[$grade],$zoom)*($zoom>14?0.66:1.0)?>;
					[is_tunnel = 'yes'][way_length > <?php echo $MIN_BRIDGE_SIZE*getPixelSize($zoom)?>] {
						line-width: <?php echo exponential($ROAD_WIDTH[$grade],$zoom)*($zoom>14?0.66:1.0)*0.75?>;
					}
				}
				<?php endif; ?>				
				<?php if ( $grade == HIGHWAY_RESIDENTIAL and $zoom > 14 ): ?>				
				[has_name='no'] {
					line-width: <?php echo exponential($ROAD_WIDTH[$grade],$zoom)*($zoom>14?0.66:1.0)?>;
					[is_tunnel = 'yes'][way_length > <?php echo $MIN_BRIDGE_SIZE*getPixelSize($zoom)?>] {
						line-width: <?php echo exponential($ROAD_WIDTH[$grade],$zoom)*($zoom>14?0.66:1.0)*0.75?>;
					}
				}				
				<?php endif; ?>
				<?php if ( $grade >= 1 && $zoom >= 12): ?>
					.layer0[is_link != 'yes'][is_bridge != 'yes'][junction = 'no'][is_construction = 'no'] {
						<?php foreach ( range(2,7) as $smoothness ): ?>					
							[smoothness = <?php echo $smoothness?>] {
								line-dasharray: <?php echo implode(exponential($HIGHWAY_SMOOTHNESS_CASING[$smoothness],$zoom),',')?>;
							}
						<?php endforeach;?>
					}
				<?php endif; ?>
				
				<?php if ( $grade <= 3 && $zoom >= 12 ):?>
					[is_link = 'yes'],[junction = 'roundabout'] {
						line-width: <?php echo exponential($ROAD_WIDTH[$grade],$zoom) * linear($LINK_WIDTH_RATIO[$grade],$zoom)?>;
					}
				<?php endif;?>				
				line-join: round;
				[is_bridge = 'no'][layer = 0] {															
					line-cap: round;
				}
				[is_tunnel = 'yes'][is_construction = 'no'][way_length > <?php echo $MIN_TUNNEL_SIZE*getPixelSize($zoom)?>] {
					line-color: lighten(desaturate(<?php echo linear($ROAD_STROKE_COLOR[$grade],$zoom)?>,50),15);
				}	
				[is_construction = 'yes'] {
					line-color: lighten(desaturate(<?php echo linear($ROAD_STROKE_COLOR[$grade],$zoom)?>,70),45);
				}							
			}
			<?php endif;?>	
			
			<?php if ( !in_array($grade,$ROAD_NOT_DRAW_FILL[$zoom]) ): ?>	
			.fill {
				[is_construction = 'no'] {	
					<?php if ( in_array($grade,$ROAD_DRAFT_DRAW[$zoom]) ): ?>
						line-color: <?php echo linear(array(1 => linear($ROAD_STROKE_COLOR[$grade],$zoom),4 => linear($ROAD_FILL_COLOR[$grade],$zoom)),3)?>;
					<?php else: ?>
						line-color: <?php echo linear($ROAD_FILL_COLOR[$grade],$zoom)?>;
					<?php endif; ?>
				}
				<?php $width = (exponential($ROAD_WIDTH[$grade],$zoom) - 2 * exponential($ROAD_STROKE_WIDTH[$grade],$zoom)) * (in_array($grade,$ROAD_DRAFT_DRAW[$zoom]) ? linear($ROAD_DRAFT_RATIO,$zoom) : 1); ?>
				<?php if ( $width < 0.01 ) $width = 0; ?>
				line-width: <?php echo $width?>;
				[is_tunnel = 'yes'][way_length > <?php echo $MIN_BRIDGE_SIZE*getPixelSize($zoom)?>] {
					line-width: <?php echo $width*0.75?>;
				}
				<?php if ( $grade == 8 and $zoom >= 13): ?>
				[highway = 'footway'] {
					line-width: <?php echo exponential($ROAD_WIDTH[HIGHWAY_RESIDENTIAL],$zoom)*($zoom>14?0.33:0.6)-0.3?>;
					[is_tunnel = 'yes'][way_length > <?php echo $MIN_BRIDGE_SIZE*getPixelSize($zoom)?>] {
						line-width: <?php echo (exponential($ROAD_WIDTH[HIGHWAY_RESIDENTIAL],$zoom)*($zoom>14?0.33:0.6)-0.3)*0.75?>;
					}
				}			
				<?php endif; ?>
				
				<?php if ( $grade == HIGHWAY_SERVICE ): ?>
				[service = 'parking_aisle'],[service='drive-through'] {
					line-width: <?php echo exponential($ROAD_WIDTH[HIGHWAY_RESIDENTIAL],$zoom)*($zoom>14?0.4:0.75)-0.2?>;
					[is_tunnel = 'yes'][way_length > <?php echo $MIN_BRIDGE_SIZE*getPixelSize($zoom)?>] {
						line-width: <?php echo (exponential($ROAD_WIDTH[HIGHWAY_RESIDENTIAL],$zoom)*($zoom>14?0.4:0.75)-0.2)*0.75?>;
					}
				}			
				<?php endif; ?>
				
				<?php if ( $zoom > 14 ): ?>
				[oneway='yes'],[oneway='-1'] {
					line-width: <?php echo exponential($ROAD_WIDTH[$grade],$zoom)*($zoom>14?0.66:1.0) - 2 * exponential($ROAD_STROKE_WIDTH[$grade],$zoom) ?>;
					[is_tunnel = 'yes'][way_length > <?php echo $MIN_BRIDGE_SIZE*getPixelSize($zoom)?>] {
						line-width: <?php echo (exponential($ROAD_WIDTH[$grade],$zoom)*($zoom>14?0.66:1.0) - 2 * exponential($ROAD_STROKE_WIDTH[$grade],$zoom))*0.75?>;
					}
				}
				<?php endif; ?>
				
				<?php if ( $grade == HIGHWAY_RESIDENTIAL and $zoom > 14 ): ?>
				[has_name='no'] {
					line-width: <?php echo exponential($ROAD_WIDTH[$grade],$zoom)*($zoom>14?0.66:1.0) - 2 * exponential($ROAD_STROKE_WIDTH[$grade],$zoom) ?>;
					[is_tunnel = 'yes'][way_length > <?php echo $MIN_BRIDGE_SIZE*getPixelSize($zoom)?>] {
						line-width: <?php echo (exponential($ROAD_WIDTH[$grade],$zoom)*($zoom>14?0.66:1.0) - 2 * exponential($ROAD_STROKE_WIDTH[$grade],$zoom))*0.75?>;
					}
				}
				<?php endif; ?>				
				<?php if ( $grade <= 3 && $zoom >= 12): ?>
					[is_link = 'yes'],[junction = 'roundabout'] {
						line-width: <?php echo $width * linear($LINK_WIDTH_RATIO[$grade],$zoom)?>;						
					}
				<?php endif;?>
				line-cap: round; 
				line-join: round;
				
				[is_tunnel = 'yes'][is_construction = 'no'][way_length > <?php echo $MIN_TUNNEL_SIZE*getPixelSize($zoom)?>] {
					line-color: lighten(desaturate(<?php echo linear($ROAD_FILL_COLOR[$grade],$zoom)?>,50),15);
				}
				
				
				[is_construction = 'yes'] {
					line-color: lighten(desaturate(<?php echo linear($ROAD_FILL_COLOR[$grade],$zoom)?>,70),35);
				}
				
				
			}			
			<?php endif;?>			
			<?php if ( !empty($ROAD_LINE_GRADES[$zoom]) && in_array($grade,$ROAD_LINE_GRADES[$zoom]) ):?>
			/*
				::line[is_link = 'no'] {						
					line-color: <?php echo linear($ROAD_LINE_COLOR[$grade],$zoom)?>;
					line-width: <?php echo exponential($ROAD_LINE_WIDTH[$grade],$zoom)?>;
					line-cap: round; 
					line-join: round;					
					
					<?php if ( $grade <= 3 ): ?>
						[is_construction = 'yes'] {
							line-opacity: 0.1;
						}
					<?php endif; ?>
				}
			*/
			<?php endif;?>	
			
			<?php if ($zoom <= 8):?>	
			}	
			<?php endif;?>				
						
		}
	<?php endforeach;?>
  .oneway {	
			[is_construction = 'no'] {
			<?php foreach ( $ONEWAY AS $selector => $a ): ?>	    
				<?php if ( !empty($a['zooms']) && in_array($zoom,$a['zooms']) ): ?>
				<?php echo $selector?> {
					<?php if ( !empty($a['pattern-file']) ): ?>			
					line-pattern-file: url('../../general/pattern/~<?php echo $a['pattern-file']?>-<?php echo $zoom?>.png');
					<?php endif; ?>					
				}
				<?php endif; ?>
			<?php endforeach; ?>
			}
		}
	<?php if ( in_array($zoom,$PATH_ZOOMS) ):?>
		.highway.path[zoom = <?php echo $zoom?>][is_construction = 'no'][highway!='steps'] {
			.bridge {
				::bridge-fill[is_bridge = 'yes'][way_length > <?php echo $MIN_BRIDGE_SIZE*getPixelSize($zoom)?>] {
					line-width: <?php echo exponential($ROAD_WIDTH[$grade],$zoom)+5?>;
					line-color: #000000;
				}
				::bridge-fill2[is_bridge = 'yes'][way_length > <?php echo $MIN_BRIDGE_SIZE*getPixelSize($zoom)?>] {
					line-width: <?php echo exponential($ROAD_WIDTH[$grade],$zoom)+3?>;
					line-color: #cccccc;
				}						
			}
			
			.tunnel {
				::tunnel-fill[is_tunnel = 'yes'][way_length > <?php echo $MIN_BRIDGE_SIZE*getPixelSize($zoom)?>] {
					line-width: <?php echo exponential($ROAD_WIDTH[$grade],$zoom)+6?>;
					line-color: #666666;
					line-dasharray: 1,3;
				}
				::tunnel-fill2[is_tunnel = 'yes'][way_length > <?php echo $MIN_BRIDGE_SIZE*getPixelSize($zoom)?>] {
					line-width: <?php echo exponential($ROAD_WIDTH[$grade],$zoom)+4?>;
					line-color: #eeeeee;
				}						
			}
			
			
			.stroke {
				glow/line-color: <?php echo linear($PATH_GLOW_COLOR,$zoom)?>;
				glow/line-width: <?php echo exponential($PATH_GLOW_WIDTH,$zoom)?>;
				.layer0[smoothness < 2] {
					glow/line-opacity: <?php echo linear($PATH_GLOW_OPACITY_SOLID,$zoom)?>;
				}
				.layer0[smoothness >= 2] {
					glow/line-opacity: <?php echo linear($PATH_GLOW_OPACITY,$zoom)?>;
				}
				line-color: <?php echo linear($PATH_COLOR,$zoom)?>;
				line-width: <?php echo exponential($PATH_WIDTH,$zoom)?>;
				<?php foreach ( range(2,7) as $smoothness ):?>
					.layer0[smoothness = <?php echo $smoothness?>][is_bridge != 'yes'] {
						line-dasharray: <?php echo implode(exponential($HIGHWAY_SMOOTHNESS_CASING[$smoothness],$zoom),',')?>;
					}
				<?php endforeach;?>
			}
		}
		
		.highway.steps[zoom = <?php echo $zoom?>][is_construction = 'no'] {														
			::stroke {
				glow/line-color: <?php echo linear($PATH_GLOW_COLOR,$zoom)?>;
				glow/line-width: <?php echo exponential($ROAD_WIDTH[HIGHWAY_TRACK1],$zoom)?>;				
				glow/line-opacity: <?php echo linear($PATH_GLOW_OPACITY_SOLID,$zoom)?>;			
				line-color: <?php echo linear($PATH_COLOR,$zoom)?>;
				line-width: <?php echo exponential($ROAD_WIDTH[HIGHWAY_TRACK1],$zoom)?>;				
				line-dasharray: 1,2;
			}
		}
		
	<?php endif;?>		
			
	
	<?php foreach ( $HIGHWAYPOINT as $selector => $a ): ?>
		.highwaypoint[zoom = <?php echo $zoom?>] {
			<?php if ( !empty($a['zooms']) && in_array($zoom,$a['zooms']) ): ?>
				<?php echo $selector?> {
					<?php if ( !empty($a['point-file']) ): ?>			
						point-file: url('../../general/pattern/~<?php echo $a['point-file']?>-<?php echo $zoom?>.png');
					<?php endif; ?>
				}
			<?php endif; ?>
		}
	<?php endforeach; ?>
		
<?php endforeach;?>


