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
							[highway_grade = <?php echo $highway_grade?>][offsetside = <?php echo $offsetside?>] {
								line-offset: <?php echo $offsetside * (exponential($ROUTE_HIKING_WIDTH,$zoom) * ($offset-0.5) + exponential($ROAD_WIDTH[$highway_grade],$zoom)/2 + 1.0) ?>;
							}			
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
			line-color: <?php echo linear($ROUTE_BICYCLE_COLOR,$zoom)?>;
			line-width: <?php echo linear($ROUTE_BICYCLE_WIDTH,$zoom)?>;
			line-opacity: <?php echo linear($ROUTE_BICYCLE_OPACITY,$zoom)?>;
			<?php foreach( range(0,12) as $highway_grade ):?>
				<?php foreach( array(-1,1) as $offsetside ): ?>
					[highway_grade = <?php echo $highway_grade?>][offsetside = <?php echo $offsetside?>] {
						line-offset: <?php echo $offsetside * (exponential($ROUTE_BICYCLE_WIDTH,$zoom) * ($offset-0.5) + exponential($ROAD_WIDTH[$highway_grade],$zoom)/2 + 1.0)?>;
					}			
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
				
		.route<?php echo $offset;?>.ski[zoom = <?php echo $zoom?>] {
			line-color: <?php echo linear($ROUTE_SKI_COLOR,$zoom)?>;
			line-width: <?php echo linear($ROUTE_SKI_WIDTH,$zoom)?>;
			line-opacity: <?php echo linear($ROUTE_SKI_OPACITY,$zoom)?>;
			<?php foreach( range(0,12) as $highway_grade ):?>
				<?php foreach( array(-1,1) as $offsetside ): ?>
					[highway_grade = <?php echo $highway_grade?>][offsetside = <?php echo $offsetside?>] {
						line-offset: <?php echo $offsetside * (exponential($ROUTE_SKI_WIDTH,$zoom) * ($offset-0.5) + exponential($ROAD_WIDTH[$highway_grade],$zoom)/2 + 1.0)?>;
					}			
				<?php endforeach; ?>
			<?php endforeach; ?>		
		}
	<?php endforeach;?>
	
<?php endforeach;?>

