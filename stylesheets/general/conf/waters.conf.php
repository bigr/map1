<?php
require_once "conf/common.conf.php";


function waterway_grade2dist($grade) {
	return pow(10,($grade + 17.0)/7.0);
}

/**
 * Zoom => Waterway grade water visibility maping 
 */
function waterway_grades($zoom,$grade) {	
	if ( $zoom < 7 ) return false;
	return  waterway_width($zoom,$grade) > linear(array(7 => 0.5, 9 => 1.0, 11 => 0.35, 12 => 0.25),$zoom);
}

$_WATER_COLOR = array( 7 => '#5195cd', 10 => '#0066bb');

/**
 * Waterway color grade x zoom maping
 */
function waterway_color($grade) {
	global $_WATER_COLOR;
	return $_WATER_COLOR;
}

$WATERWAY_WIDTH_ZOOM_EXPEX = array ( 5 => 1.5, 8 => 1.5, 9 => 1.3);
$WATERWAY_WIDTH_GRADE_EXPEX = array ( 5 => 1.29, 12 => 1.28, 35 => 1.05 );


/**
 * Waterway width grade x zoom maping
 */
function waterway_width($zoom,$grade) {
	global $WATERWAY_WIDTH_ZOOM_EXPEX, $WATERWAY_WIDTH_GRADE_EXPEX;
	return expex($WATERWAY_WIDTH_GRADE_EXPEX,$grade) * expex($WATERWAY_WIDTH_ZOOM_EXPEX,$zoom) * 0.0003;
}


/**
 * Zoom x landcover visibillity maping
 */
$WATERAREA = array(
	"[landuse='basin'],[landuse='reservoir'],[natural='water'],[waterway='dock'],[waterway='riverbank'],[waterway='dam']" => array(
			'level' => 1,
			'zooms' => range( 7,18),
			'color' => $_WATER_COLOR,
		),
	"[natural='wetland'],[natural='marsh']" => array(
			'level'            => 1,
			'pattern-zooms'    => range(8,18),
			'pattern'          => 'hatch',
			'pattern-size'     => array(14 => 9),
			'pattern-rotation' => array(14 => 45),
			'pattern-opacity'  => array(14 => 0.5),
			'pattern-color'    => $_WATER_COLOR,
			'pattern-stroke'   => array(14 => 1),
		),		
);


/**
 * Minimal rendered area in given zoom in pixels^2
 */
$WATERAREA_MINIMAL_AREA = $_MINIMAL_AREA;
