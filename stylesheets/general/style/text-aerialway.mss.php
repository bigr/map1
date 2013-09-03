<?php
	require_once "conf/text.conf.php";
	require_once "conf/aerialway.conf.php";
?>


<?php foreach ( $AERIALWAY_TEXT_ZOOMS as $zoom => $priority ): ?>
	.textAerialway.priority<?php echo $priority?>[zoom = <?php echo $zoom?>] {
		text-face-name: "<?php echo FONT_BOOK_SANS ?>";
		text-name: "[name]";		
		text-size: <?php echo text_limiter(exponential($AERIALWAY_TEXT_SIZE,$zoom))?>;
		text-halo-radius: 1;			
		text-placement: line;
		text-dy: <?php echo text_limiter(exponential($AERIALWAY_TEXT_SIZE,$zoom)) * 0.66?>;
		text-label-position-tolerance: 100;		
		text-fill: #000000;
		text-opacity: 0.66;	
		[difficulty = 'novice'] {
			text-fill: #00ff00;	
		}
		[difficulty = 'easy'] {
			text-fill: #0000ff;	
		}
		[difficulty = 'intermediate'] {
			text-fill: #ff0000;	
		}
		[difficulty = 'intermediate'] {
			text-fill: #ff0000;	
		}
		[difficulty = 'advanced'] {
			text-fill: #000000;	
		}
		[difficulty = 'expert'] {
			text-fill: #550000;	
		}
	}
			
<?php endforeach;?>

