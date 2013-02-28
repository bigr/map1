<?php
    require_once "conf/symbol.conf.php";
?>

<?php foreach ( $RENDER_ZOOMS as $zoom ):?>
    .symbol[zoom = <?php echo $zoom?>][count < <?php echo linear($SYMBOL_DENSITY,$zoom)?>] {
	<?php foreach ( $SYMBOL AS $selector => $a ): ?>	    
	    <?php if ( !empty($a['zooms']) && in_array($zoom,$a['zooms']) ): ?>
		<?php echo $selector?> {
		    <?php if ( !empty($a['symbol-file']) ): ?>
                         point-file: url('../../general/symbol/~<?php echo $a['symbol-file']?>-<?php echo $zoom?>-<?php echo empty($a['symbol-color']) ? '#000000' : linear($a['symbol-color'],$zoom)?>.png');			 
		    <?php endif; ?>
                }
	    <?php endif; ?>
	<?php endforeach; ?>
    }    
<?php endforeach;?>

