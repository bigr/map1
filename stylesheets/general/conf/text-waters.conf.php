<?php
require_once "conf/text.conf.php";
require_once "conf/waters.conf.php";


/**
 * Zoom -> grade -> waterway name visibility/render priority maping
 */
function waterway_name_priorities($zoom,$grade) {	
	if ( $zoom < 7 ) return false;
	$width = waterway_width($zoom,$grade);	
	if ( $width > 8.0 ) return 2;
	if ( $width > 1.5 ) return 3;
	return false;
}


/**
 * Zoom -> pixel area -> waterarea name priorities 
 */
$WATERAREA_NAME_PRIORITIES = array (	
 5 => array(
	 	 2200    => 3,
		 10000    => 2,
	), 
 6 => array(
	 	 2200     => 3,
		 10000    => 2,
	), 
 7 => array(
	 	 2200    => 3,
		10000    => 2,
	), 
 8 => array(
	 	 2200    => 3,
		10000    => 2,
	),
 9 => array(
	 	 2200    => 3,
		10000    => 2,
	),
10 => array(
	 	 2200    => 3,
		10000    => 2,
	),
11 => array(
	 	 2200    => 3,
		10000    => 2,
	),
12 => array(
	 	 2200    => 3,
		10000    => 2,
	),
13 => array(
	 	 2200    => 3,
		10000    => 2,
	),
14 => array(
	 	 2200    => 3,
		10000    => 2,
	),
15 => array(
	 	 2200    => 3,
		10000    => 2,
	),
16 => array(
	 	 2200    => 3,
		10000    => 2,
	),
17 => array(
	 	 2200    => 3,
		10000    => 2,
	),
18 => array(
	 	 2200    => 3,
		10000    => 2,
	),
);


/**
 * Waterway name text color grade x zoom maping
 */
function waterway_name_color($grade) {
	global $_WATER_COLOR;
	return $_WATER_COLOR;
}

$WATERWAY_NAME_SIZE_ZOOM_EXPEX = array ( 5 => 1.25 );

$WATERWAY_NAME_SIZE_GRADE_EXPEX = array ( 5 => 1.17 );

/**
 * Waterway name text size grade x zoom maping
 */
function waterway_name_size($zoom,$grade) {
	global $WATERWAY_NAME_SIZE_ZOOM_EXPEX, $WATERWAY_NAME_SIZE_GRADE_EXPEX;
	return expex($WATERWAY_NAME_SIZE_GRADE_EXPEX,$grade) * expex($WATERWAY_NAME_SIZE_ZOOM_EXPEX,$zoom) * 0.035;
}

/**
 * Waterway text dy grade x zoom maping
 */
function waterway_name_dy($zoom,$grade) {
	return 0.5*waterway_name_size($zoom,$grade) + 4;
}

/**
 * Waterway name text halo radius grade x zoom maping
 */
function waterway_name_halo_radius($grade) {	
	return array( 8 => 2);
}

/**
 * Waterway name text halo fill grade x zoom maping
 */
function waterway_name_halo_fill($grade) {	
	return 'rgba(255,255,255,0.4)';
}

$WATERWAY_NAME_SPACING = array(8 => 7, 11 => 15, 13 => 30, 18 => 100);


/**
 * Waterarea name text color zoom maping
 */
$WATERAREA_NAME_COLOR = array(8 => '#ffffff');

/**
 * Waterarea name text size pixelarea x zoom maping
 */
$WATERAREA_NAME_SIZE = array(    
    2200 => array( 8 => 13),
    4700 => array( 8 => 14),
   10000 => array( 8 => 15),
   22000 => array( 8 => 17),
   47000 => array( 8 => 19),
  100000 => array( 8 => 22),
  220000 => array( 8 => 25),
  470000 => array( 8 => 28),
 1000000 => array( 8 => 31), 
 2200000 => array( 8 => 35), 
 4700000 => array( 8 => 40), 
10000000 => array( 8 => 45), 
);

/**
 * Waterarea name text halo radius zoom maping
 */
$WATERAREA_NAME_HALO_RADIUS = array( 8 => 2);

/**
 * Waterarea name text halo radius zoom maping
 */
$WATERAREA_NAME_HALO_FILL = $_WATER_COLOR;
