<?php
	require_once "conf/text-boundary.conf.php";
?>


<?php foreach ( $RENDER_ZOOMS as $zoom ):?>				
    <?php foreach( pixelarea2selector($PABOUNDARY_NAME_SIZE,$zoom) as $selector3 => $size ): ?>
	<?php $textSize = exponential($size,$zoom); ?>
	    <?php echo $selector3?> {	
		.textPaboundary.priority<?php echo paboundary_name_priority($textSize)?>[zoom = <?php echo $zoom?>] {
		    text-face-name: "<?php echo FONT_BOOK_SANS ?>";
		    text-name: "[name]";
		    text-opacity: <?php echo paboundary_name_opacity($textSize)?>;
		    text-placement: point;
		    
		    text-fill: darken(<?php echo linear($_BOUNDARY_PA_NATURAL_COLOR,$zoom)?>,10);
		    text-halo-fill:  rgba(255,255,255,0.35);
		    [protect_class=25] {
			text-fill: darken(<?php echo linear($_BOUNDARY_PA_MILITARY_COLOR,$zoom)?>,0);
			text-halo-fill:  rgba(255,255,255,0.35);
		    }
		    [protect_class=12] {
			text-fill: darken(<?php echo linear($_BOUNDARY_PA_WATER_COLOR,$zoom)?>,10);
			text-halo-fill:  rgba(255,255,255,0.35);
		    }			
		    text-halo-radius: <?php echo exponential($PABOUNDARY_NAME_HALO_RADIUS,$zoom)?>;
		    text-placement-type: simple;				
		    text-size: <?php echo text_limiter($textSize);?>;
		    text-wrap-width: <?php echo text_limiter($textSize)*4?>;
		    text-placements: "X,N,S,E,W,NE,SE,NW,SW,<?php echo text_limiter($textSize*0.9)?>,<?php echo text_limiter($textSize*0.8)?>,<?php echo text_limiter($textSize*0.7)?>,<?php echo text_limiter($textSize*0.62)?>";				
		    text-clip: false;
		}
	    }	
    <?php endforeach;?>
<?php endforeach;?>

