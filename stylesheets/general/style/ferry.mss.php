<?php
	require_once "conf/ferry.conf.php";	
?>

<?php foreach ( $RENDER_ZOOMS as $zoom ):?>					
	.ferry[zoom = <?php echo $zoom?>] {
		line-color: lighten(<?php echo linear($FERRY_COLOR,$zoom)?>,20);
		line-width: <?php echo linear($FERRY_WIDTH,$zoom)?>;		
		line-dasharray: <?php echo 3*linear($FERRY_WIDTH,$zoom)?>,<?php echo 2*linear($FERRY_WIDTH,$zoom)?>;
	}
<?php endforeach;?>

