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
			[is_construction = 'no'] {
				text-fill: <?php echo linear($ROAD_NAME_COLOR[$grade],$zoom)?>;
				text-halo-fill: <?php echo linear($ROAD_FILL_COLOR[$grade],$zoom)?>;
			}
			text-placement: line;
			text-dy: 1;
			text-label-position-tolerance: 100;
			[is_construction = 'yes'] {
				line-opacity: 0.3;
				text-halo-fill: #777777;
				text-fill: #ffffff;
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
<?php endforeach;?>

