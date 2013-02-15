<?php
require_once "inc/utils.php";
require_once "conf/common.conf.php";
require_once "conf/text-place.conf.php";

$_RESIDENTIAL_COLOR = array( 5 => '#666666', 9 => '#bbaaaa', 11 => '#bbaaaa', 18 => '#d7d4d4');

$_PARK_COLOR = array( 11 => '#bbaaaa', 15 => '#b5e0b0');

/**
 * Zoom x landcover look maping
 */
$LANDCOVER = array(
	"[landuse='forest']" => array(
			'level' => 1,
			'zooms' => range( 9,18),
			'color' => array( 7 => '#eeeeee', 13 => '#c3e3bb'),			
		),
	"[landuse='grass'],[landuse='grassland'],[natural='grassland']" => array(
			'level' => 1,
			'zooms' => range(10,18),
			'color' => array( 9 => '#eeeeee', 17 => '#e5f5e5'),
		),
	"[landuse='residential']" => array(
			'level' => 1,
			'zooms' => range( 9,15),
			'color' => $_RESIDENTIAL_COLOR,
		),
	"[landuse='farm']" => array(
			'level' => 1,
			'zooms' => range(10,18),
			'color' => array( 9 => '#eeeeee', 17 => '#eaf2ea'),
		),
	"[landuse='farmyard']" => array(
			'level' => 1,
			'zooms' => range( 9,18),
			'color' => array( 9 => '#bbaaaa', 17 => '#aabbaa'),
		),
	"[landuse='industrial']" => array(
			'level' => 1,
			'zooms' => range( 9,18),
			'color' => array( 9 => '#bbaaaa', 17 => '#b6a6b6'),
		),	
	"[landuse='commercial']" => array(
			'level' => 1,
			'zooms' => range( 9,18),
			'color' => array( 9 => '#bbaaaa', 17 => '#aaaabb'),
		),	
	"[landuse='railway']" => array(
			'level' => 1,
			'zooms' => range(12,18),
			'color' => array(11 => '#eeeeee', 17 => '#c3e3bb'),
		),
	"[natural='wood']" => array(
			'level' => 1,
			'zooms' => range( 9,18),
			'color' => array( 7 => '#eeeeee', 17 => '#70b080'),
		),
	"[natural='scrub']" => array(
			'level' => 1,
			'zooms' => range( 9,18),
			'color' => array( 7 => '#eeeeee', 17 => '#d4f3cc'),
		),
	"[natural='beach']" => array(
			'level' => 1,
			'zooms' => range(11,18),
			'color' => array(10 => '#eeeeee', 15 => '#e8e3ab'),
		),
	"[natural='heath']" => array(
			'level' => 1,
			'zooms' => range( 9,18),
			'color' => array( 7 => '#eeeeee', 15 => '#a5d4bb'),
		),
	"[natural='glacier']" => array(
			'level' => 1,
			'zooms' => range( 9,18),
			'color' => array( 7 => '#eeeeee', 15 => '#eeffff'),
		),
	"[natural='sand']" => array(
			'level' => 1,
			'zooms' => range( 9,18),
			'color' => array( 7 => '#eeeeee', 15 => '#e8e3ab'),
		),
	"[leisure='pitch'],[leisure='track'],[leisure='sports_centre'],[leisure='stadium']" => array(
			'level' => 2,
			'zooms' => range(14,18),
			'color' => array( 13 => '#bbaaaa', 15 => '#e8937c'),			
		),/*
	"[leisure='pitch'][sport='soccer']" => array(
			'level' => 2,
			'pattern-zooms'   => range(14,15),
			'pattern-file'    => 'soccer',
			'pattern-size'    => array(14 => 24),
			'pattern-margin'  => array(14 => 1.2),
			'pattern-opacity' => array(14 => 0.1),
		),
	"[leisure='pitch'][sport='tennis']" => array(
			'level' => 2,
			'pattern-zooms'   => range(14,15),
			'pattern-file'    => 'tennis',
			'pattern-size'    => array(14 => 24),
			'pattern-margin'  => array(14 => 1.2),
			'pattern-opacity' => array(14 => 0.1),
		),
	"[leisure='pitch'][sport='athletics'],[leisure='track']" => array(
			'level' => 2,
			'pattern-zooms'   => range(14,15),
			'pattern-file'    => 'runner',
			'pattern-size'    => array(14 => 24),
			'pattern-margin'  => array(14 => 1.2),
			'pattern-opacity' => array(14 => 0.1),
		),*/
	"[leisure='park'],[landuse='park'],[landuse='allotments'],[landuse='cemetery'],[leisure='garden'][landuse='orchard']" => array(
			'level' => 2,
			'zooms' => range(11,18),
			'color' => $_PARK_COLOR,
		),
	"[landuse='allotments']" => array(
			'level'            => 2,
			'pattern-zooms'   => range(14,18),
			'pattern'          => 'hatch',
			'pattern-size'     => array(10 => 5),
			'pattern-rotation' => array(10 => 0),
			'pattern-opacity'  => array(11 => 0.0, 15 => 0.3),
			'pattern-color'    => array(11 => '#dddddd'),
			'pattern-stroke'   => array(10 => 1),
		),
	"[leisure='playground']" => array(
			'level' => 2,
			'zooms' => range(14,18),
			'color' => array( 13 => '#bbaaaa', 15 => '#e8aa80'),
			'pattern-zooms'   => range(14,18),
			'pattern-file'    => 'playground',
			'pattern-size'    => array(14 => 16),
			'pattern-margin'  => array(14 => 1),
			'pattern-opacity' => array(14 => 0.1),
		),	
	"[amenity='parking']" => array(
			'level' => 2,
			'zooms' => range(13,18),
			'color' => array( 13 => '#ffffff'),
		),	
);

/**
 * Sizes and color of urb discs
 */
function  placescover() {
	global $_RESIDENTIAL_COLOR;
	$ret = array();
	foreach ( range(0,40) as $grade ) {
		$ret[$grade] = array(
			'color' => $_RESIDENTIAL_COLOR,
			'size' => array()
		);
		foreach ( range(5,18) as $zoom ) {
			$ret[$grade]['size'][$zoom] = ceil(urb_name_dy($zoom,$grade) * linear(array(6 => 1.8,9 => 1.8, 11 => 0.6, 13 => 0.0 ),$zoom));
		}		
	}
	return $ret;
}
$PLACESCOVER = placescover();


/**
 * Minimal rendered area in given zoom in pixels^2
 */
$LANDCOVER_MINIMAL_AREA = $_MINIMAL_AREA;

/**
 * Residentialcover hack zoom visibility maping
 */
$RESIDENTIALCOVER_HACK_ZOOMS = range(9,18);

/**
 * Residentialcover hack color
 */
$RESIDENTIALCOVER_HACK_COLOR = $_RESIDENTIAL_COLOR;

/**
 * Residentialcover hack width [meters]
 */
$RESIDENTIALCOVER_HACK_WIDTH = array(8 => 250);
