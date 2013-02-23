<?php
require_once "inc/utils.php";
require_once "conf/common.conf.php";
require_once "conf/text-place.conf.php";

$_RESIDENTIAL_COLOR = array( 5 => '#666666', 9 => '#bbaaaa', 11 => '#bbaaaa', 18 => '#d7d4d4');

$_PARK_COLOR = array( 11 => '#bbaaaa', 13 => '#d8e5d0');

/**
 * Zoom x landcover look maping
 */
$LANDCOVER = array(

	"[place='island'],[place='islet']" => array(
		'level' => 1,
		'zooms' => range( 9,18),
		'color' => array( 7 => '#f5f5f5', 13 => '#bdd9ad'),			
		),
	"[landuse='forest']" => array(
			'level' => 1,
			'zooms' => range( 9,18),
			'color' => array( 7 => '#f5f5f5', 13 => '#bdd9ad'),	
			'smooth' => 1,
		),
	"[landuse='forest'][wood='mixed'],[natural='wood'][wood='mixed']" => array(
			'level' => 1,
			'pattern-zooms'   => range(13,18),
			'pattern-file'    => 'forest-mixed',
			'pattern-size'    => array(14 => 20),
			'pattern-margin'  => array(14 => 2.0),
			'pattern-opacity' => array(14 => 0.1),
			'smooth' => 1
		),
	"[landuse='forest'][wood='coniferous'],[natural='wood'][wood='coniferous']" => array(
			'level' => 1,
			'pattern-zooms'   => range(13,18),
			'pattern-file'    => 'forest-coniferous',
			'pattern-size'    => array(14 => 20),
			'pattern-margin'  => array(14 => 2.0),
			'pattern-opacity' => array(14 => 0.5),
			'pattern-color'   => array( 7 => '#f5f5f5', 13 => '#7ab259'),	
			'smooth' => 1
		),
	"[landuse='forest'][wood='deciduous'],[natural='wood'][wood='deciduous']" => array(
			'level' => 1,
			'pattern-zooms'   => range(13,18),
			'pattern-file'    => 'forest-deciduous',
			'pattern-size'    => array(14 => 20),
			'pattern-margin'  => array(14 => 2.0),
			'pattern-opacity' => array(14 => 0.5),
			'pattern-color'   => array( 7 => '#f5f5f5', 13 => '#7ab259'),
			'smooth' => 1
		),
	"[landuse='grass'],[landuse='grassland'],[natural='grassland'],[natural='meadow'],[landuse='meadow']" => array(
			'level' => 1,
			'zooms' => range(10,18),
			'color' => array( 9 => '#f5f5f5', 13 => '#ecfae3'),
			'smooth' => 1,
		),
	"[landuse='grass'],[landuse='grassland'],[natural='grassland'],[natural='meadow'],[landuse='meadow'],.x2" => array(
			'level' => 1,
			'pattern-zooms'   => range(13,18),
			'pattern-file'    => 'landuse-grass',
			'pattern-size'    => array(13 => 11,18 => 15),
			'pattern-margin'  => array(13 => 1.5),
			'pattern-opacity' => array(13 => 0.5),
			'pattern-color'   => array( 7 => '#f5f5f5', 13 => '#b3e695'),
			'smooth' => 1
		),
	"[landuse='residential']" => array(
			'level' => 1,
			'zooms' => range( 9,15),
			'color' => $_RESIDENTIAL_COLOR,
		),
	"[landuse='farm']" => array(
			'level' => 1,
			'zooms' => range(10,18),
			'color' => array( 9 => '#eeeeee', 13 => '#f7fae3'),
		),
	"[landuse='farm'],.x2" => array(
			'level' => 1,
			'pattern-zooms'   => range(13,18),
			'pattern-file'    => 'landuse-farm',
			'pattern-size'    => array(13 => 13,18 => 17),
			'pattern-margin'  => array(13 => 1.5),
			'pattern-opacity' => array(13 => 1.0),
			'pattern-color'   => array( 7 => '#f5f5f5', 13 => '#dbe695'),
		),
	"[landuse='farmyard']" => array(
			'level' => 1,
			'zooms' => range( 9,18),
			'color' => array( 9 => '#bbaaaa', 13 => '#bbbaa1'),
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
			'color' => array( 7 => '#eeeeee', 13 => '#C0E0BB'),
			'smooth' => 1,
		),
	"[natural='scrub']" => array(
			'level' => 1,
			'zooms' => range( 9,18),
			'color' => array( 7 => '#eeeeee', 13 => '#d8e6d0'),
			'smooth' => 1,
		),
	"[landuse='scrub'],.x2" => array(
			'level' => 1,
			'pattern-zooms'   => range(13,18),
			'pattern-file'    => 'landuse-scrub',
			'pattern-size'    => array(14 => 20),
			'pattern-margin'  => array(14 => 2.0),
			'pattern-opacity' => array(14 => 0.1),			
		),
	"[natural='beach']" => array(
			'level' => 1,
			'zooms' => range(11,18),
			'color' => array(10 => '#eeeeee', 13 => '#e8e3ab'),
		),
	"[natural='heath']" => array(
			'level' => 1,
			'zooms' => range( 9,18),
			'color' => array( 7 => '#eeeeee', 13 => '#a5d4bb'),
		),
	"[natural='glacier']" => array(
			'level' => 1,
			'zooms' => range( 9,18),
			'color' => array( 7 => '#eeeeee', 13 => '#ccffff'),
			'smooth' => 1,
		),
	"[natural='sand']" => array(
			'level' => 1,
			'zooms' => range( 9,18),
			'color' => array( 7 => '#eeeeee', 13 => '#e8e3ab'),
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
	"[landuse='cemetery']" => array(
			'level' => 2,
			'pattern-zooms'   => range(13,18),
			'pattern-file'    => 'cemetery',
			'pattern-size'    => array(13 => 9, 18 => 20),
			'pattern-margin'  => array(14 => 1.5),
			'pattern-opacity' => array(14 => 0.1),			
		),
	"[landuse='garden']" => array(
			'level' => 2,
			'pattern-zooms'   => range(13,18),
			'pattern-file'    => 'landuse-garden',
			'pattern-size'    => array(14 => 20),
			'pattern-margin'  => array(14 => 2.0),
			'pattern-opacity' => array(14 => 0.1),			
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
 * Zoom x landcover line look maping
 */
$LANDCOVER_LINE = array(
	"[natural='cliff']" => array(
		'zooms' => range(12,18),
		'pattern-file' => 'cliff',
		'pattern-size' => array(12=>6,18=>18),
		'pattern-spacing' => array(14=>0),
		'width' => array(14 => 0.0),
		'color' => $_CONTOUR_COLOR,
		'opacity' => array(12 => 0.5, 15 => 0.8),
	),
	"[natural='rock']" => array(
		'zooms' => range(12,18),
		'pattern-file' => 'rock',
		'pattern-size' => array(13=>14,18=>32),
		'pattern-spacing' => array(14=>20),
		'width' => array(14 => 0.0),
		'color' => $_CONTOUR_COLOR,
	),
	"[natural='tree_row']" => array(
		'zooms' => range(13,18),
		'pattern-file' => 'tree_row',
		'pattern-size' => array(13=>4,18=>20),
		'pattern-spacing' => array(14=>20),
		'width' => array(14 => 0.0),
		'color' => array(13 => '#6d8c5b'),	
	),
);


/**
* Zoom x landcover point look maping
*/
$LANDCOVER_POINT = array(
	"[natural='tree']" => array(
		'zooms' => range(13,18),
		'symbol-file' => 'tree',
		'symbol-color' => array('#6d8c5b'),
		'symbol-size' => array(13=>20,17=>35),		
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
