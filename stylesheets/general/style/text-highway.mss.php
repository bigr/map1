<?php
	require_once "conf/text-highway.conf.php";
?>

<?php foreach ( $RENDER_ZOOMS as $zoom ):?>

	<?php foreach ( $ROAD_NAME_PRIORITIES[$zoom] as $grade => $priority ):?>
		.textHighway.priority<?php echo $priority?>[zoom = <?php echo $zoom?>][grade = <?php echo $grade?>]::name {
			text-face-name: "<?php echo FONT_BOOK_SANS ?>";
			text-name: "[name]";
			
			text-size: <?php echo round(exponential($ROAD_NAME_SIZE[$grade],$zoom))?>;						
			
			text-halo-radius: <?php echo exponential($ROAD_NAME_HALO_RADIUS[$grade],$zoom)?>;
			[is_construction = 'no'][is_tunnel = 'no'] {
				text-fill: <?php echo linear($ROAD_NAME_COLOR[$grade],$zoom)?>;
				text-halo-fill: fadeout(<?php echo linear($ROAD_FILL_COLOR[$grade],$zoom)?>,60);
			}
			text-placement: line;
			text-dy: 1;
			text-label-position-tolerance: 100;
			[is_tunnel = 'yes'][is_construction = 'no'] {
				text-halo-fill: fadeout(lighten(desaturate(<?php echo linear($ROAD_FILL_COLOR[$grade],$zoom)?>,50),15),60);
				text-fill: lighten(desaturate(<?php echo linear($ROAD_NAME_COLOR[$grade],$zoom)?>,50),15);
			}									
			
			[is_construction = 'yes'] {
				text-halo-fill: lighten(desaturate(<?php echo linear($ROAD_FILL_COLOR[$grade],$zoom)?>,70),35);
				text-fill: lighten(desaturate(<?php echo linear($ROAD_NAME_COLOR[$grade],$zoom)?>,70),45);
			}
		}
	<?php endforeach;?>
	
	<?php if ( array_key_exists($zoom,$ROAD_INTREF_PRIORITIES) ):?>
		<?php $priority = $ROAD_INTREF_PRIORITIES[$zoom];?>
		.textHighwayE.priority<?php echo $priority?>[zoom = <?php echo $zoom?>]::ref {
			shield-face-name: "<?php echo FONT_BOOK_SANS ?>";
			shield-name: "[number]";
			shield-fill: <?php echo linear($ROAD_INTREF_COLOR,$zoom)?>;
			shield-size: <?php echo round(exponential($ROAD_INTREF_SIZE,$zoom))?>;
			shield-placement: line;		
			shield-min-distance: <?php echo round(exponential($ROAD_INTREF_MINIMUM_DISTANCE,$zoom))?>;
			shield-spacing: <?php echo round(exponential($ROAD_INTREF_SPACING,$zoom))?>;
			shield-file: url('../../general/shield/~highway-intref-<?php echo $zoom?>-[number_length].svg');
		}
	<?php endif; ?>
	
	
	<?php foreach ( $ROAD_REF_PRIORITIES[$zoom] as $grade => $priority ):?>
		.textHighway.priority<?php echo $priority?>[zoom = <?php echo $zoom?>][grade = <?php echo $grade?>][ref_length > 0]::ref {
			shield-face-name: "<?php echo FONT_BOOK_SANS ?>";
			shield-name: "[ref]";
			shield-fill: <?php echo linear($ROAD_REF_COLOR[$grade],$zoom)?>;
			shield-size: <?php echo round(exponential($ROAD_REF_SIZE[$grade],$zoom))?>;
			shield-placement: line;
			[is_construction = 'no'] {
				shield-opacity: 0.9;
			}
			[is_construction = 'yes'] {
				shield-opacity: 0.33;
			}
			shield-min-distance: <?php echo round(exponential($ROAD_REF_MINIMUM_DISTANCE[$grade],$zoom))?>;
			shield-spacing: 500;
			shield-file: url('../../general/shield/~highway-ref-<?php echo $zoom?>-<?php echo $grade?>-[ref_length].svg');
		}
	<?php endforeach;?>	
	
	<?php if ( !empty($HIGHWAY_ACCESS_PRIORITIES[$zoom]) ): ?>
		<?php $priority = $HIGHWAY_ACCESS_PRIORITIES[$zoom];?>
		.textHighwayAccess.priority<?php echo $priority?>[zoom = <?php echo $zoom?>][density<<?php echo $HIGHWAY_ACCESS_DENSITY[$zoom]; ?>] {			
			shield-face-name: "<?php echo FONT_BOOK_SANS ?>";		
			shield-placement: point;
			shield-opacity: 0.66;
			/*shield-min-distance: <?php echo round(exponential($HIGHWAY_ACCESS_MINDISTANCE,$zoom))?>;*/
			shield-spacing: 300;			
			shield-file: url('../../../../highway_access/generated/[file].png');
		}
	<?php endif; ?>
<?php endforeach;?>

