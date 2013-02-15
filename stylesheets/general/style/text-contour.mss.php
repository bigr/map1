<?php
	require_once "conf/text-contour.conf.php";
?>

<?php foreach ( $RENDER_ZOOMS as $zoom ):?>		
	<?php foreach ( $TEXT_CONTOUR_PRIORITIES[$zoom] as $modulo => $priority ):?>
		.textContour.priority<?php echo $priority?>[zoom = <?php echo $zoom?>][<?php echo justModulo('ele',$modulo) ?>]::modulo-<?php echo $modulo?> {	
			text-face-name: "<?php echo FONT_BOOK_SANS ?>";
			text-name: "[ele]";
			text-fill: <?php echo linear($TEXT_CONTOUR_COLOR[$modulo],$zoom)?>;
			text-size: <?php echo round(exponential($TEXT_CONTOUR_SIZE[$modulo],$zoom))?>;	
			text-halo-fill: rgba(255,255,255,0.2);
			text-halo-radius: 2;
			text-placement: line;
			text-label-position-tolerance: 75;
			text-spacing: 250;	
			text-opacity: 0.6;		
		}
	<?php endforeach;?>
<?php endforeach;?>

