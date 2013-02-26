<?php
	require_once "conf/text-route.conf.php";
?>



<?php foreach ( $RENDER_ZOOMS as $zoom ):?>		
	
	<?php foreach ( $ROUTE_REF_PRIORITIES[$zoom] as $grade => $priority ):?>
		/*.textRouteRef.priority<?php echo $priority?>[zoom = <?php echo $zoom?>][grade = <?php echo $grade?>][ref_length > 0] {			
			shield-face-name: "<?php echo FONT_BOOK_SANS ?>";
			shield-name: "[ref]";
			shield-fill: <?php echo linear($ROUTE_REF_COLOR[$grade],$zoom)?>;
			shield-size: <?php echo round(exponential($ROUTE_REF_SIZE[$grade],$zoom))?>;
			shield-placement: line;
			shield-opacity: 0.9;
			shield-min-distance: <?php echo round(exponential($ROUTE_REF_MINIMUM_DISTANCE[$grade],$zoom))?>;
			shield-spacing: 200;			
			shield-file: url('../../general/shield/~route-ref-<?php echo $zoom?>-<?php echo $grade?>-[ref_length].svg');			
		}*/
	<?php endforeach;?>	
	<?php foreach ( $ROUTE_NAME_PRIORITIES[$zoom] as $grade => $priority ):?>	
		/*.textRouteName.priority<?php echo $priority?>[zoom = <?php echo $zoom?>][grade = <?php echo $grade?>] {
			text-face-name: "<?php echo FONT_BOOK_SANS ?>";
			text-name: "[name]";
			<?php foreach ( $ROUTE_HIKING_COLORS as $color ):?>
				[color = '<?php echo $color?>'] {
					text-fill: <?php echo linear($ROUTE_HIKING_COLOR[$color],$zoom)?>;
				}
			<?php endforeach; ?>
			text-size: <?php echo round(exponential($ROUTE_NAME_SIZE[$grade],$zoom))?>;
			text-placement: line;
			text-dy: 8;
		}*/
	<?php endforeach;?>
	<?php if ( !empty($ROUTE_OSMCSYMBOL_PRIORITIES[$zoom]) ): ?>
		<?php $priority = $ROUTE_OSMCSYMBOL_PRIORITIES[$zoom];?>
		.textOsmcsymbol.priority<?php echo $priority?>[zoom = <?php echo $zoom?>] {			
			shield-face-name: "<?php echo FONT_BOOK_SANS ?>";		
			shield-placement: line;
			shield-opacity: 0.9;
			shield-min-distance: <?php echo round(exponential($ROUTE_OSMCSYMBOL_MINDISTANCE,$zoom))?>;
			shield-spacing: 300;			
			shield-file: url('../../../osmcsymbol/generated/[file].png');
		}
	<?php endif; ?>
<?php endforeach;?>

