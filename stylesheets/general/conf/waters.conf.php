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
	return  waterway_width($zoom,$grade) > linear(array(7 => 0.6, 9 => 1.1, 11 => 0.25, 12 => 0.15, 13 => 0),$zoom);
}

$_WATER_COLOR = array( 7 => '#5195cd', 10 => '#0066bb',12 => '#0066bb',15=>'#4387bf');
$_WATER_COLOR_STROKE = array( 7 => '#5195cd', 10 => '#0066bb');

/**
 * Waterway color grade x zoom maping
 */
function waterway_color($grade) {
	global $_WATER_COLOR;
	return $_WATER_COLOR;
}

$WATERWAY_WIDTH_ZOOM_EXPEX = array ( 5 => 1.5, 8 => 1.5, 9 => 1.3, 12 => 1.3, 15 => 1.7);
$WATERWAY_WIDTH_GRADE_EXPEX = array ( 0 => 1.6, 3 => 1.3, 15 => 1.2, 35 => 1.05 );


/**
 * Waterway width grade x zoom maping
 */
function waterway_width($zoom,$grade) {
	global $WATERWAY_WIDTH_ZOOM_EXPEX, $WATERWAY_WIDTH_GRADE_EXPEX;
	return expex($WATERWAY_WIDTH_GRADE_EXPEX,$grade) * expex($WATERWAY_WIDTH_ZOOM_EXPEX,$zoom) * 0.0003 + exponential(array(7 => 0, 12 => 0.1,13 => 0.3,14=>0.6,18 => 1.5),$zoom);
}


/**
 * Zoom x landcover visibillity maping
 */
$WATERAREA = array(
	"[landuse='basin'],[landuse='reservoir'],[natural='water'],[waterway='dock'],[waterway='riverbank']" => array(
			'level' => 1,
			'zooms' => range( 7,18),
			'color' => $_WATER_COLOR,
			'stroke' => array(5=>0,12=>0,13=>1,18=>2),
			'stroke-color' => $_WATER_COLOR_STROKE,
			'smooth' => 1,
		),
	"[waterway='dam'],[waterway='weir']" => array(
			'level' => 1,
			'zooms' => range(12,18),
			'color' => array(13 => '#eeeeee'),
		),
	"[natural='wetland'],[natural='marsh']" => array(
			'level'           => 1,
			'pattern-zooms'   => range(10,18),
			'pattern-file'    => 'landuse-wetland',
			'pattern-size'    => array(13 => 18, 15 => 24),
			'pattern-margin'  => array(14 => 1.0),
			'pattern-opacity' => array(14 => 1.0),
			'pattern-color'   => $_WATER_COLOR,
			'smooth' => 1,
		),		
);


/**
 * Minimal rendered area in given zoom in pixels^2
 */
$WATERAREA_MINIMAL_AREA = $_MINIMAL_AREA;



$WATERPOINT = array(	
	"[waterway='weir']" => array(
			'zooms' => range(13,18),			
			'symbol-file' => 'weir',						
			'symbol-size' => array(13 => 12,18 => 24),			
			'symbol-color' => array(14 => '#003399'),
			'halo-color' => array(14 => '#eef5ff'),
		),	
		/*
	"[waterway='lock_gate']" => array(
			'zooms' => range(13,18),
			'symbol-file' => 'lock_gate',
			'symbol-size' => array(13 => 10,18 => 16),
			'symbol-color' => array(14 => '#ffffff'),
			'halo-color' => $_WATER_COLOR,
		),
		*/ 
	"[waterway='dam']" => array(
			'zooms' => range(12,18),			
			'symbol-file' => 'dam',
			'symbol-size' => array(13 => 16,18 => 32),			
			'symbol-color' => array(14 => '#003399'),
			'halo-color' => array(14 => '#eef5ff'),
		),	
);

$WATERWAY_WEIR = range(14,18);
$WATERWAY_WEIR_LINE_WIDTH = array(14 => 2, 18 => 6);
$WATERWAY_WEIR_WIDTH = array(14 => 4, 18 => 12);


$WATERWAY_DAM = range(14,18);
$WATERWAY_DAM_LINE_WIDTH = array(13 => 4, 18 => 12);
$WATERWAY_DAM_WIDTH = array(13 => 6, 18 => 16);
