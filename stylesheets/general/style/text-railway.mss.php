<?php
	require_once "conf/text.conf.php";
	require_once "conf/railway.conf.php";
?>


<?php foreach ( $RAILWAY_TEXT_ZOOMS as $zoom => $priority ): ?>
	.textRailway.priority<?php echo $priority?>[zoom = <?php echo $zoom?>] {
		text-face-name: "<?php echo FONT_BOOK_SANS ?>";
		text-name: "[name]";		
		text-size: <?php echo text_limiter(exponential($RAILWAY_TEXT_SIZE,$zoom))?>;
		text-halo-radius: 1;			
		text-placement: line;
		text-dy: <?php echo text_limiter(exponential($RAILWAY_TEXT_SIZE,$zoom)) * 0.66?>;
		text-label-position-tolerance: 100;		
		text-fill: #000000;
		text-opacity: 0.66;
	}
			
<?php endforeach;?>

