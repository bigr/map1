<?php
    require_once "conf/barrier.conf.php";
?>

<?php foreach ( $RENDER_ZOOMS as $zoom ):?>
    .barrier[zoom = <?php echo $zoom?>] {
	<?php foreach ( $BARRIER AS $selector => $a ): ?>	    
	    <?php if ( !empty($a['zooms']) && in_array($zoom,$a['zooms']) ): ?>
		<?php echo $selector?> {
		    <?php if ( !empty($a['pattern-file']) ): ?>			
			line-pattern-file: url('../../general/pattern/~<?php echo $a['pattern-file']?>-<?php echo $zoom?>.png');
		    <?php endif; ?>
		    line-color: <?php echo empty($a['color']) ? '#000000' : linear($a['color'],$zoom)?>;
		    line-width: <?php echo empty($a['width']) ? 1.0 : linear($a['width'],$zoom)?>;
		    line-opacity: <?php echo empty($a['opacity']) ? 1.0 : linear($a['opacity'],$zoom)?>;		    
                }
	    <?php endif; ?>
	<?php endforeach; ?>
    }
    .barrierpoint[zoom = <?php echo $zoom?>] {
		<?php foreach ( $BARRIERPOINT AS $selector => $a ): ?>	    
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

