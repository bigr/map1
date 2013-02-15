<?php
require_once "inc/utils.php";
require_once "conf/text.conf.php";

function shield_peak_priorities($zoom,$grade) {		
	$sz = shield_peak_text_size($zoom,$grade);
	$factor = linear(array(11 => 1, 12 => 1.3),$zoom);	
	if ( $sz > 40*$factor ) return 0;
	if ( $sz > 20*$factor ) return 1;
	if ( $sz > 10*$factor) return 2;
	if ( $sz > 8.0 ) return 3;
	if ( $sz > 5.5 ) return 4;		
	return false;
}

$SHIELD_PEAK_SIZE_ZOOM_EXPEX = array(4 => 1.72,5 => 1.30, 8 => 1.40, 9 => 1.45, 12 => 1.55,13 => 1.3);
$SHIELD_PEAK_SIZE_GRADE_EXPEX = array(10 => 1.075);

/**
 * Shield peak text size grade x zoom maping
 */
function shield_peak_text_size($zoom,$grade) {
	global $SHIELD_PEAK_SIZE_ZOOM_EXPEX, $SHIELD_PEAK_SIZE_GRADE_EXPEX;
	return expex($SHIELD_PEAK_SIZE_GRADE_EXPEX,$grade) * expex($SHIELD_PEAK_SIZE_ZOOM_EXPEX,$zoom) * 0.02;	
}


/**
 * Shield peak text halo radius grade x zoom maping
 */
function shield_peak_text_halo_radius($grade) {	
	return array(12 => 2);
}


$SHIELD_PEAK_COLOR = $_CONTOUR_COLOR;

$SHIELD_PEAK_TEXT_COLOR = $_CONTOUR_COLOR;


