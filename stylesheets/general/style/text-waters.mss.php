<?php
	require_once "conf/text-waters.conf.php";
?>


<?php foreach ( $RENDER_ZOOMS as $zoom ):?>		
	<?php foreach ( range(0,35) as $grade ):?>
		<?php $priority = waterway_name_priorities($zoom,$grade); if ( $priority === false ) continue; ?>
		
		<?php foreach ( array(1,-1) as $dySign ): ?>
		.textWaterway.priority<?php echo $priority?>.dy<?php echo $dySign == -1 ? '2' : ''?>[zoom = <?php echo $zoom?>][grade = <?php echo $grade?>]::name {			
			
			text-face-name: "<?php echo FONT_BOOK_SANS ?>";
			text-name: "[name]";			
			text-fill: darken(<?php echo linear(waterway_name_color($grade),$zoom)?>,15);
			text-size: <?php echo text_limiter(waterway_name_size($zoom,$grade))?>;
			text-halo-radius: <?php echo exponential(waterway_name_halo_radius($grade),$zoom)?>;
			text-halo-fill: <?php echo waterway_name_halo_fill($grade)?>;
			text-placement: line;
			text-dy: <?php echo $dySign * waterway_name_dy($zoom,$grade)?>;
			text-label-position-tolerance: 100;
			text-spacing: <?php echo round(waterway_name_size($zoom,$grade) * linear($WATERWAY_NAME_SPACING, $zoom)) ?>;
			<?php if ( $dySign == -1 ):?>
				text-min-distance: <?php echo ceil(waterway_name_dy($zoom,$grade)); ?>;
			<?php endif; ?>
			text-max-char-angle-delta: 40;
			
		}
		<?php endforeach; ?>
		
	<?php endforeach;?>
	
	<?php foreach( pixelarea2selector($WATERAREA_NAME_PRIORITIES[$zoom],$zoom) as $selector => $priority ): ?>  
	/*
		.textWaterarea.priority<?php echo $priority?>[zoom = <?php echo $zoom?>]<?php echo $selector?> {
			text-face-name: "<?php echo FONT_BOOK_SANS ?>";
			text-name: "[name]";
			text-placement: interior;
			text-fill: <?php echo linear($WATERAREA_NAME_COLOR,$zoom)?>;
			text-halo-radius: <?php echo exponential($WATERAREA_NAME_HALO_RADIUS,$zoom)?>;
			text-halo-fill: <?php echo linear($WATERAREA_NAME_HALO_FILL,$zoom)?>;			
			<?php foreach( pixelarea2selector($WATERAREA_NAME_SIZE,$zoom) as $selector2 => $size ): ?>
				<?php echo $selector2?> {
					text-size: <?php echo exponential($size,$zoom)?>;
					text-wrap-width: <?php echo exponential($size,$zoom)*2?>;
				}
			<?php endforeach;?>			
		}
		*/
	<?php endforeach;?>
<?php endforeach;?>

