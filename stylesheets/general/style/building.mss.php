<?php
	require_once "conf/building.conf.php";
?>


<?php foreach ( $BUILDING_ZOOMS as $zoom ):?>
	.building[zoom = <?php echo $zoom?>] {		
		polygon-fill: <?php echo linear($BUILDING_COLOR,$zoom)?>;
	}	
<?php endforeach;?>

