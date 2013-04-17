<?php
	require_once "conf/text-building.conf.php";
?>


<?php foreach ( $RENDER_ZOOMS as $zoom ):?>				
    <?php foreach( pixelarea2selector($BUILDING_NAME_SIZE,$zoom) as $selector3 => $size ): ?>
	<?php $textSize = exponential($size,$zoom); ?>
	    <?php echo $selector3?> {
		.textBuilding.priority<?php echo building_name_priority($textSize)?>[zoom = <?php echo $zoom?>] {
		    text-face-name: "<?php echo FONT_BOOK_SANS ?>";
		    text-name: "[name]";
		    text-opacity: <?php echo building_name_opacity($textSize)?>;
		    text-placement: point;
		    text-fill: darken(<?php echo linear($BUILDING_COLOR,$zoom)?>,50);
		    text-halo-fill:  rgba(255,255,255,0.35);
		    text-halo-radius: <?php echo exponential($BUILDING_NAME_HALO_RADIUS,$zoom)?>;
		    text-placement-type: simple;
		    text-size: <?php echo text_limiter($textSize);?>;
		    text-wrap-width: <?php echo text_limiter($textSize)*4?>;
		    text-placements: "X,N,S,E,W,NE,SE,NW,SW,<?php echo text_limiter($textSize*0.9)?>,<?php echo text_limiter($textSize*0.8)?>,<?php echo text_limiter($textSize*0.7)?>,<?php echo text_limiter($textSize*0.62)?>";
		    text-clip: false;
		}
	    }	
    <?php endforeach;?>
<?php endforeach;?>

