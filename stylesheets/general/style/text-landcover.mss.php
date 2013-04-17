<?php
	require_once "conf/text-landcover.conf.php";
?>


<?php foreach ( $RENDER_ZOOMS as $zoom ):?>				
	<?php foreach( pixelarea2selector($LANDCOVER_NAME_SIZE,$zoom) as $selector3 => $size ): ?>
	    <?php $textSize = exponential($size,$zoom); ?>
			<?php echo $selector3?> {	
				.textLandcover.priority<?php echo landcover_name_priority($textSize)?>[zoom = <?php echo $zoom?>] {
					text-face-name: "<?php echo FONT_BOOK_SANS ?>";
					text-name: "[name]";
					text-opacity: <?php echo landcover_name_opacity($textSize)?>;
					text-placement: point;
					<?php foreach ( $LANDCOVER AS $selector => $a ): ?>
					    <?php if ( $a['level'] != '1' ) continue; ?>
						<?php echo $selector?> {			
							<?php $color = empty($a['color']) ? (empty($a['pattern-color']) ? $LANDCOVER_NAME_COLOR : $a['pattern-color']) : $a['color'];?> 
							text-fill: darken(<?php echo linear($color,$zoom)?>,50);
							text-halo-fill:  fadeout(lighten(<?php echo linear($color,$zoom)?>,20),50);					
						}
					<?php endforeach; ?>
					text-halo-radius: <?php echo exponential($LANDCOVER_NAME_HALO_RADIUS,$zoom)?>;					
					text-placement-type: simple;										
					text-size: <?php echo text_limiter($textSize);?>;
					text-wrap-width: <?php echo text_limiter($textSize)*4?>;							
					text-placements: "X,N,S,E,W,NE,SE,NW,SW,<?php echo text_limiter($textSize*0.9)?>,<?php echo text_limiter($textSize*0.8)?>,<?php echo text_limiter($textSize*0.7)?>,<?php echo text_limiter($textSize*0.62)?>";				
					text-clip: false;
				}
			}	
	<?php endforeach;?>
<?php endforeach;?>

