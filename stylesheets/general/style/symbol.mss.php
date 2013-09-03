<?php
    require_once "conf/symbol.conf.php";
?>

<?php foreach ( $RENDER_ZOOMS as $zoom ):?>
    .symbol[zoom = <?php echo $zoom?>] {
	<?php $i = 0; foreach ( $SYMBOL AS $selector => $a ): ++$i; ?>
	     <?php if ( !empty($a['zooms']) && array_key_exists($zoom, $a['zooms']) ): ?>
		<?php $pr = $a['zooms'][$zoom] > 2 ? $a['zooms'][$zoom] - 2 : 0 ?>
		.priority<?php echo $pr ?> {
		    [type = <?php echo $i?>] {
			<?php if ( !empty($a['symbol-file']) ): ?>
			     point-file: url('../../general/symbol/~<?php echo $a['symbol-file']?>-<?php echo $zoom?>-<?php echo empty($a['symbol-color']) ? '#000000' : linear($a['symbol-color'],$zoom)?>.png');			 
			<?php endif; ?>
		    }
		}
	    <?php endif; ?>
	<?php endforeach; ?>
    }    
<?php endforeach;?>

