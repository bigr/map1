<?php
	require_once "conf/countryfill.conf.php";
?>



<?php foreach ( $RENDER_ZOOMS as $zoom ):?>		
    <?php if ( in_array($zoom, $COUNTRYFILL_ZOOMS) ):?>
	.countryfill[zoom = <?php echo $zoom?>] {
	    <?php foreach ( $COUNTRYFILL_COLORS as $osmId => $color ):?> 
		[osm_id = <?php echo $osmId ?>] {
		    polygon-fill: <?php echo $color ?>;	
		}
		polygon-opacity: <?php echo linear($COUNTRYFILL_OPACITY,$zoom)?>;
		
	    <?php endforeach ?>
	}
    <?php endif; ?>       
<?php endforeach;?>

