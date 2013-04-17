<?php
	require_once "conf/text-place.conf.php";
?>



<?php foreach ( $RENDER_ZOOMS as $zoom ):?>			
	<?php foreach ( range(0,40) as $grade ):?>
		<?php $priority = urb_priorities($zoom,$grade); if ( $priority === false ) continue; ?>
		
			.textPlace.priority<?php echo $priority?>[zoom = <?php echo $zoom?>][grade = <?php echo $grade?>][type = 'urb'] {
				<?php $size = urb_name_size($zoom,$grade) * (urb_name_size($zoom,$grade) > linear($URB_NAME_UPPERCASE_SIZE,$zoom) ? 0.9 : 1) ?>
				<?php if( $priority == 4 ): ?>
					text-face-name: "<?php echo FONT_BOOK_SANS_NARROW ?>";
				<?php else: ?>
					text-face-name: "<?php echo FONT_BOLD_SANS_NARROW ?>";
				<?php endif; ?>
				
				text-name: "[<?php echo $URB_NAME_COLUMN[$zoom]?>]";
				text-fill: <?php echo linear(urb_name_color($grade),$zoom)?>;
				text-size: <?php echo text_limiter($size) ?>;
				text-halo-radius: <?php echo exponential(urb_name_halo_radius($grade),$zoom)?>;				
				text-halo-fill: rgba(255,255,255,<?php echo linear($URB_NAME_HALO_OPACITY,$zoom)?>);
				text-dy: <?php echo urb_name_dy($zoom,$grade)?>;
				text-wrap-width: <?php echo round(urb_name_wrap_width($zoom,$grade))?>;
				<?php if( urb_name_size($zoom,$grade) > linear($URB_NAME_UPPERCASE_SIZE,$zoom) ): ?>
					text-transform: uppercase;
				<?php endif; ?>
				text-opacity: <?php echo urb_name_opacity($zoom,$grade)?>;
				text-placement-type: simple;
				text-placements: "X,N,S,E,W,NE,SE,NW,SW,<?php echo text_limiter($size*0.9)?>,<?php echo text_limiter($size*0.8)?>,<?php echo text_limiter($size*0.7)?>,<?php echo text_limiter($size*0.62)?>";
				<?php if( $priority == 4 ): ?>
					text-min-distance: 25px;
				<?php endif; ?>
				text-clip: false;
			}
		
	<?php endforeach; ?>
	<?php foreach ( range(0,40) as $grade ):?>
		<?php $priority = suburb_priorities($zoom,$grade); if ( $priority === false ) continue; ?>
		
			.textPlace.priority<?php echo $priority?>[zoom = <?php echo $zoom?>][grade = <?php echo $grade?>][type = 'suburb'] {
				<?php $size = suburb_name_size($zoom,$grade) * (suburb_name_size($zoom,$grade) > linear($SUBURB_NAME_UPPERCASE_SIZE,$zoom) ? 0.9 : 1) ?>
				<?php if( $priority == 4 ): ?>
					text-face-name: "<?php echo FONT_ITALIC_SANS_NARROW ?>";
				<?php else: ?>
					text-face-name: "<?php echo FONT_BOLD_ITALIC_SANS_NARROW ?>";
				<?php endif; ?>
				
				text-name: "[name]";
				text-fill: <?php echo linear(suburb_name_color($grade),$zoom)?>;
				text-size: <?php echo text_limiter($size)?>;
				text-halo-radius: <?php echo exponential(suburb_name_halo_radius($grade),$zoom)?>;				
				text-halo-fill: rgba(255,255,255,0.33);
				text-dy: 0;
				text-wrap-width: <?php echo round(suburb_name_wrap_width($zoom,$grade))?>;
				<?php if( suburb_name_size($zoom,$grade) > linear($SUBURB_NAME_UPPERCASE_SIZE,$zoom) ): ?>
					text-transform: uppercase;
				<?php endif; ?>
				text-opacity: <?php echo suburb_name_opacity($zoom, $grade)?>;
				text-placement-type: simple;
				text-placements: "X,N,S,E,W,NE,SE,NW,SW,<?php echo text_limiter($size*0.9)?>,<?php echo text_limiter($size*0.8)?>,<?php echo text_limiter($size*0.7)?>,<?php echo text_limiter($size*0.62)?>";
				<?php if( $priority == 4 ): ?>
					text-min-distance: 30px;
				<?php endif; ?>
				text-clip: false;
			}
		
	<?php endforeach; ?>
	
	<?php $priority = locality_priorities($zoom); if ( $priority !== false ): ?>		
		.textPlace.priority<?php echo $priority?>[zoom = <?php echo $zoom?>][type = 'locality'] {			
			text-face-name: "<?php echo FONT_BOOK_SANS_NARROW ?>";
			text-name: "[name]";
			text-fill: <?php echo locality_name_color($zoom)?>;
			text-size: <?php echo text_limiter(locality_name_size($zoom))?>;
			text-halo-radius: <?php echo exponential(locality_name_halo_radius(),$zoom)?>;
			text-halo-fill: rgba(255,255,255,0.4);			
			text-wrap-width: <?php echo round(locality_name_wrap_width($zoom))?>;			
			text-opacity: <?php echo locality_name_opacity($zoom)?>;
			<?php if( $priority == 4 ): ?>
				text-min-distance: 30px;
			<?php endif; ?>
			text-clip: false;	
		}		
	<?php endif;?>	
<?php endforeach;?>

