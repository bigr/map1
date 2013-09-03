<?php
	require_once "conf/shield-peak.conf.php";
?>

<?php foreach ( $RENDER_ZOOMS as $zoom ):?>	
	<?php foreach ( range(25,0) as $grade ):?>
		<?php $priority = shield_peak_priorities($zoom,$grade); if ( $priority === false ) continue; ?>
		.shieldPeak.priority<?php echo $priority?>[zoom = <?php echo $zoom?>][grade = <?php echo $grade?>] {	
			shield-face-name: "<?php echo FONT_BOOK_SANS ?>";
			shield-name: "[name] + '\a' + [ele]";
			shield-fill: <?php echo linear($SHIELD_PEAK_COLOR,$zoom)?>;
			shield-size: <?php echo text_limiter(shield_peak_text_size($zoom,$grade)) ?>;			
			shield-placement: point;
			shield-halo-fill: rgba(255,255,255,0.4);
			shield-halo-radius: <?php echo exponential(shield_peak_text_halo_radius($grade),$zoom)?>;	
			<?php if( $priority == 4 ): ?>					
				shield-min-distance: 25px;
			<?php endif; ?>		
			shield-file: url('../../general/shield/~peak-<?php echo $zoom?>-<?php echo $grade?>.svg');
			shield-line-spacing: 6;
			shield-dy: -1;
		}
	<?php endforeach;?>
<?php endforeach;?>

