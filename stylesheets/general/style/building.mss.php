<?php
	require_once "conf/building.conf.php";
?>


<?php foreach ( $BUILDING_ZOOMS as $zoom ):?>
	.building[zoom = <?php echo $zoom?>] {		
		polygon-fill: <?php echo linear($BUILDING_COLOR,$zoom)?>;
		line-width: 0.5px;
		line-color: darken(<?php echo linear($BUILDING_COLOR,$zoom)?>,15);
	}	
<?php endforeach;?>

