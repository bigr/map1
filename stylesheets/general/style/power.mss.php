<?php
	require_once "conf/power.conf.php";
?>

<?php foreach ( $RENDER_ZOOMS as $zoom ):?>		
	<?php foreach ( $POWER_GRADES[$zoom] as $grade ):?>
		.power[zoom = <?php echo $zoom?>][grade = <?php echo $grade?>] {
			line-color: <?php echo linear($POWER_COLOR[$grade],$zoom)?>;
			line-width: <?php echo exponential($POWER_WIDTH[$grade],$zoom)?>;
		}		
	<?php endforeach;?>		
	<?php foreach ( $POWERPOINT AS $selector => $a ): ?>
		.powerpoint[zoom = <?php echo $zoom?>] {
			<?php if ( !empty($a['zooms']) && in_array($zoom,$a['zooms']) ): ?>
				<?php echo $selector?> {
					<?php if ( !empty($a['point-file']) ): ?>			
						point-file: url('../../general/pattern/~<?php echo $a['point-file']?>-<?php echo $zoom?>.png');
					<?php endif; ?>
				}
			<?php endif; ?>
		}
	<?php endforeach; ?>
	
<?php endforeach;?>

