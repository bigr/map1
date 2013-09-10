<?php
	require_once "conf/route.conf.php";
	require_once "conf/highway.conf.php";
?>

<?php foreach ( $RENDER_ZOOMS as $zoom ):?>	
	<?php if ( $zoom < 12 ) continue; ?>
	<?php foreach ( range(0,8) as $offset ):?>
	
		.route<?php echo $offset;?>.hiking[zoom = <?php echo $zoom?>] {
			<?php foreach ($ROUTE_HIKING_COLORS as $color): ?>
				[color = '<?php echo $color?>'] {
					line-color: <?php echo linear($ROUTE_HIKING_COLOR[$color],$zoom)?>; 
					line-width: <?php echo exponential($ROUTE_HIKING_WIDTH,$zoom)?>;
					line-opacity: <?php echo linear($ROUTE_HIKING_OPACITY,$zoom)?>;
					
					<?php foreach( range(0,13) as $highway_grade ):?>
						<?php foreach( array(-1,1) as $offsetside ): ?>
							<?php $offset_value = exponential($ROAD_WIDTH[$highway_grade],$zoom) - exponential($ROAD_STROKE_WIDTH[$highway_grade],$zoom) - 0.5 < 2.0 * exponential($ROUTE_HIKING_WIDTH,$zoom) 
									? $offsetside * (exponential($ROUTE_HIKING_WIDTH,$zoom) * ($offset-0.5) + exponential($ROAD_WIDTH[$highway_grade],$zoom)*0.5 + 0.5)
									: (
											$offset == 1
												? $offsetside * (exponential($ROAD_WIDTH[$highway_grade],$zoom)/2 - exponential($ROUTE_HIKING_WIDTH,$zoom)*0.5 - exponential($ROAD_STROKE_WIDTH[$highway_grade],$zoom)/2 - 0.5)
												: $offsetside * (exponential($ROUTE_HIKING_WIDTH,$zoom) * ($offset-1.5) + exponential($ROAD_WIDTH[$highway_grade],$zoom)*0.5 + 0.5)
										);
								?>
							<?php if ( abs($offset_value) > 0.01 ): ?>
							[highway_grade = <?php echo $highway_grade?>][offsetside = <?php echo $offsetside?>] {
								line-offset: <?php echo $offset_value ?>;
							}			
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endforeach; ?>
					
					[sac_scale = 'mountain_hiking'] {
						line-dasharray: 8,3;
					}
					
					[sac_scale = 'demanding_mountain_hiking'] {
						line-dasharray: 6,3;
					}
					
					[sac_scale = 'alpine_hiking'] {
						line-dasharray: 4,3;
					}												
					
					[sac_scale = 'demanding_alpine_hiking'] {
						line-dasharray: 3,3;
					}
					
					[sac_scale = 'difficult_alpine_hiking'] {
						line-dasharray: 2,3;
					}

				}
			<?php endforeach; ?>
		}
		
		.route<?php echo $offset;?>.bicycle[zoom = <?php echo $zoom?>] {
			[network='lcn'][density < <?php echo $ROUTE_BICYCLE_LCN_DENSITY[$zoom] ?>],[network='rcn'][density < <?php echo $ROUTE_BICYCLE_RCN_DENSITY[$zoom] ?>],[network!='lcn'][network!='rcn'] {
				line-color: <?php echo linear($BICYCLE_ROUTE_LCN_COLOR,$zoom)?>;
				[network='lcn'],[network='lwn'] {
					line-color: <?php echo linear($BICYCLE_ROUTE_LCN_COLOR,$zoom)?>;
				}
				[network='rcn'],[network='rwn'] {
					line-color: <?php echo linear($BICYCLE_ROUTE_RCN_COLOR,$zoom)?>;
				}
				[network='ncn'],[network='nwn'] {
					line-color: <?php echo linear($BICYCLE_ROUTE_NCN_COLOR,$zoom)?>;
				}
				[network='icn'],[network='iwn'] {
					line-color: <?php echo linear($BICYCLE_ROUTE_ICN_COLOR,$zoom)?>;
				}
				line-width: <?php echo linear($ROUTE_BICYCLE_WIDTH,$zoom)?>;
				line-opacity: <?php echo linear($ROUTE_BICYCLE_OPACITY,$zoom)?>;
				<?php foreach( range(0,13) as $highway_grade ):?>
					<?php foreach( array(-1,1) as $offsetside ): ?>
						<?php 
						
									$offset_value = exponential($ROAD_WIDTH[$highway_grade],$zoom) - exponential($ROAD_STROKE_WIDTH[$highway_grade],$zoom) - 0.5 < 2.0 * exponential($ROUTE_BICYCLE_WIDTH,$zoom) 
									? $offsetside * (exponential($ROUTE_BICYCLE_WIDTH,$zoom) * ($offset-0.5) + exponential($ROAD_WIDTH[$highway_grade],$zoom)*0.5 + 0.5)
									: (
											$offset == 1
												? $offsetside * (exponential($ROAD_WIDTH[$highway_grade],$zoom)/2 - exponential($ROUTE_BICYCLE_WIDTH,$zoom)*0.5 - exponential($ROAD_STROKE_WIDTH[$highway_grade],$zoom)/2 - 0.5)
												: $offsetside * (exponential($ROUTE_BICYCLE_WIDTH,$zoom) * ($offset-1.5) + exponential($ROAD_WIDTH[$highway_grade],$zoom)*0.5 + 0.5)
										);
								?>
						<?php if ( abs($offset_value) > 0.01 ): ?>
						[highway_grade = <?php echo $highway_grade?>][offsetside = <?php echo $offsetside?>][oneway='no'], 
						<?php if ( $offsetside == -1 ):?>
							[highway_grade = <?php echo $highway_grade?>][oneway='yes']
						<?php else: ?>
							[highway_grade = <?php echo $highway_grade?>][oneway='-1']
						<?php endif; ?>	{
							line-offset: <?php echo $offset_value ?>;
						}
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endforeach; ?>
				
				['mtb:scale' = '0+'] {
					line-dasharray: 10,3;
				}
				
				['mtb:scale' = '1'] {
					line-dasharray: 8,3;
				}
				
				['mtb:scale' = '2'] {
					line-dasharray: 6,3;
				}												
				
				['mtb:scale' = '3'] {
					line-dasharray: 5,3;
				}
				
				['mtb:scale' = '4'] {
					line-dasharray: 4,3;
				}
				
				['mtb:scale' = '5'] {
					line-dasharray: 3,3;
				}
				
				['mtb:scale' = '6'] {
					line-dasharray: 2,3;
				}
				
			}
		}
				
		.route<?php echo $offset;?>.ski[zoom = <?php echo $zoom?>] {
			line-color: <?php echo linear($ROUTE_SKI_COLOR,$zoom)?>;
			line-width: <?php echo linear($ROUTE_SKI_WIDTH,$zoom)?>;
			line-opacity: <?php echo linear($ROUTE_SKI_OPACITY,$zoom)?>;
			<?php foreach( range(0,13) as $highway_grade ):?>
				<?php foreach( array(-1,1) as $offsetside ): ?>
					<?php $offset_value = exponential($ROAD_WIDTH[$highway_grade],$zoom) - exponential($ROAD_STROKE_WIDTH[$highway_grade],$zoom) - 0.5 < 2.0 * exponential($ROUTE_SKI_WIDTH,$zoom) 
									? $offsetside * (exponential($ROUTE_SKI_WIDTH,$zoom) * ($offset-0.5) + exponential($ROAD_WIDTH[$highway_grade],$zoom)*0.5 + 0.5)
									: (
											$offset == 1
												? $offsetside * (exponential($ROAD_WIDTH[$highway_grade],$zoom)/2 - exponential($ROUTE_SKI_WIDTH,$zoom)*0.5 - exponential($ROAD_STROKE_WIDTH[$highway_grade],$zoom)/2 - 0.5)
												: $offsetside * (exponential($ROUTE_SKI_WIDTH,$zoom) * ($offset-1.5) + exponential($ROAD_WIDTH[$highway_grade],$zoom)*0.5 + 0.5)
										);
								?>
					<?php if ( abs($offset_value) > 0.01 ): ?>
					[highway_grade = <?php echo $highway_grade?>][offsetside = <?php echo $offsetside?>] {
						line-offset: <?php echo $offset_value;?>;
					}
					<?php endif;?>		
				<?php endforeach; ?>
			<?php endforeach; ?>		
		}
	<?php endforeach;?>
	
<?php endforeach;?>

