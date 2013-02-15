<?php
	require_once "conf/fishnet.conf.php";
?>

<?php foreach ( $FISHNET1000_ZOOMS as $zoom ):?>	
	.fishnet1000[zoom = <?php echo $zoom?>] {		
		line-color: <?php echo linear($FISHNET1000_COLOR,$zoom)?>;
		line-width: <?php echo linear($FISHNET1000_WIDTH,$zoom)?>;
		line-opacity: <?php echo linear($FISHNET1000_OPACITY,$zoom)?>;			
	}		
<?php endforeach;?>

<?php foreach ( $FISHNET10000_ZOOMS as $zoom ):?>	
	.fishnet10000[zoom = <?php echo $zoom?>] {		
		line-color: <?php echo linear($FISHNET10000_COLOR,$zoom)?>;
		line-width: <?php echo linear($FISHNET10000_WIDTH,$zoom)?>;
		line-opacity: <?php echo linear($FISHNET10000_OPACITY,$zoom)?>;			
	}		
<?php endforeach;?>

<?php foreach ( $GRATICULES_ZOOMS as $zoom ):?>	
	.graticules[zoom = <?php echo $zoom?>] {		
		line-color: <?php echo linear($GRATICULES_COLOR,$zoom)?>;
		line-width: <?php echo linear($GRATICULES_WIDTH,$zoom)?>;
		line-opacity: <?php echo linear($GRATICULES_OPACITY,$zoom)?>;			
	}		
<?php endforeach;?>

