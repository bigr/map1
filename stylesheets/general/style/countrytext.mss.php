<?php
	require_once "conf/countrytext.conf.php";
?>



<?php foreach ( $RENDER_ZOOMS as $zoom ):?>		
    <?php if ( in_array($zoom, $COUNTRYTEXT_ZOOMS) ):?>
	
	.countrytext[zoom = <?php echo $zoom?>][text_path="country"] {
	    <?php foreach ( range(0,4) as $size ):?>	    
		[size = '<?php echo $size?>'] {
		    text-face-name: "<?php echo FONT_BOLD_SANS_NARROW ?>";
		    text-name: "[text]";
		    text-fill: #ffffff;
		    
		    text-size: <?php echo pow(2,$zoom-5) * $COUNTRYTEXT_SIZE[$size]?>;
		    text-opacity: <?php echo linear($COUNTRYTEXT_OPACITY,$zoom)?>;
		    
		    text-placement: line;
		    text-transform: uppercase;
		    text-halo-radius: 2;
		    text-halo-fill: rgba(0,0,0,0.2);
		    
		    text-allow-overlap: true;
		    
		}		
		
	    <?php endforeach ?>
	}
	
	.countrytext[zoom = <?php echo $zoom?>][text_path="sea"] {
	    <?php foreach ( range(0,4) as $size ):?>	    
		[size = '<?php echo $size?>'] {
		    text-face-name: "<?php echo FONT_ITALIC_SANS ?>";
		    text-name: "[text]";
		    text-fill: #ffffff;
		    
		    text-size: <?php echo pow(2,$zoom-5) * $SEATEXT_SIZE[$size]?>;
		    text-opacity: <?php echo linear($SEATEXT_OPACITY,$zoom)?>;
		    
		    text-placement: line;
		    text-transform: uppercase;		    
		    
		    text-allow-overlap: true;
		    
		}		
		
	    <?php endforeach ?>
	}
    <?php endif; ?>
<?php endforeach;?>

