<?php
    require_once "conf/text-symbol.conf.php";
?>

<?php foreach ( $RENDER_ZOOMS as $zoom ):?>
    .textSymbol[zoom = <?php echo $zoom?>][count < <?php echo linear($TEXT_SYMBOL_DENSITY,$zoom)?>] {
	<?php foreach ( $TEXT_SYMBOL as $selector => $a ): ?>
	    <?php if ( !empty($a['zooms']) && array_key_exists($zoom, $a['zooms']) ): ?>
		.priority<?php echo $a['zooms'][$zoom] ?><?php echo $selector?> {
		    text-face-name: "<?php echo FONT_ITALIC_SERIF ?>";
		    text-name: "[name]";		    
		    text-fill: <?php echo linear($a['color'],$zoom)?>;
		    text-size: <?php echo round(exponential($a['size'],$zoom))?>;
		    <?php if ( !empty($a['opacity']) ): ?>
			text-opacity: <?php echo round(linear($a['opacity'],$zoom))?>;
		    <?php else: ?>
			text-opacity: 0.7;
		    <?php endif; ?>
		    <?php if ( !empty($a['halo-radius']) ): ?>
			text-halo-radius: <?php echo round(exponential($a['halo-radius'],$zoom))?>;
		    <?php else: ?>
			text-halo-radius: 5;
		    <?php endif; ?>		    
		    <?php if ( !empty($a['halo-color']) ): ?>
			text-halo-fill: <?php echo linear($a['halo-color'],$zoom)?>;
		    <?php else: ?>
			text-halo-fill: rgba(255,245,200,0.33);
		    <?php endif; ?>
		    <?php if ( !empty($a['dy']) ): ?>
			text-dy: <?php echo linear($a['dy'],$zoom)?>;
		    <?php else: ?>
			text-dy: 0;
		    <?php endif; ?>
		    <?php if ( !empty($a['vertical-alignment'][$zoom]) ): ?>
			text-vertical-alignment: <?php echo $a['vertical-alignment'][$zoom]?>;
		    <?php else: ?>
			text-vertical-alignment: middle;
		    <?php endif; ?>
		    <?php if ( !empty($a['dx']) ): ?>
			text-dx: <?php echo linear($a['dx'],$zoom)?>;
		    <?php else: ?>
			text-dx: <?php echo round(exponential($a['size'],$zoom)) + 2?>;
		    <?php endif; ?>
		    <?php if ( !empty($a['horizontal-alignment'][$zoom]) ): ?>
			text-horizontal-alignment: <?php echo $a['horizontal-alignment'][$zoom]?>;
		    <?php else: ?>
			text-horizontal-alignment: right;
		    <?php endif; ?>
		    <?php if ( !empty($a['minimum-distance'][$zoom]) ): ?>
			text-min-distance: <?php echo $a['minimum-distance'][$zoom]?>;
		    <?php else: ?>
			text-min-distance: 0;
		    <?php endif; ?>
		    <?php if ( !empty($a['wrap-width']) ): ?>
			text-wrap-width: <?php echo round(linear($a['wrap-width'],$zoom)*$a['size'])?>;
		    <?php endif; ?>
		}		
	    <?php endif; ?>
	<?php endforeach; ?>
    }		
<?php endforeach;?>

