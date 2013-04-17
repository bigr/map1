<?php
require_once "inc/utils.php";
require_once "conf/common.conf.php";
require_once "conf/text-place.conf.php";

$_FOREST_BASE_COLOR = '#B3D998';
$_WOOD_BASE_COLOR = '#A3D998';
$_NATURAL_SCRUB_COLOR = '#CDEBC7';
$_LANDUSE_SCRUB_COLOR = '#D6EBC7';
$_NATURAL_GRASS_COLOR = '#EBFAE8';
$_LANDUSE_GRASS_COLOR = '#F0FAE8';
$_LEISURE_PARK_COLOR = '#DEEBC7';
$_FARM_GRAIN_COLOR = '#F9FAE8';
$_RESIDENTIAL_BASE_COLOR ='#D9C5CA';
$_RESIDENTIAL_BASE2_COLOR ='#B3ADAE';
$_RESIDENTIAL_COLOR = array( 5 => '#aaaaaa',6 =>'#888888',10 => $_RESIDENTIAL_BASE2_COLOR, 12 => $_RESIDENTIAL_BASE_COLOR, 18 => '#F2EEEF');

$_PARK_COLOR = array( 10 => $_RESIDENTIAL_BASE2_COLOR, 14 => $_LEISURE_PARK_COLOR);

$_LANDCOVER_PATTERN_DARKEN = 55;
$_LANDCOVER_PATTERN_OPACITY = 0.2;

/**
 * Zoom x landcover look maping
 */
$LANDCOVER = array(

	"[place='island'],[place='islet']" => array(
		'level' => 1,
		'zooms' => range( 9,18),
		'color' => array( 7 => '#f5f5f5', 13 => '#bdd9ad'),			
		),
	"[landuse='forest'],[landuse='wood']" => array(
			'level' => 1,
			'zooms' => range( 9,18),
			'color' => array( 7 => '#f5f5f5',11 => '#D8E6CF', 14 => $_FOREST_BASE_COLOR),	
			'smooth' => 1,
		),
	"[natural='wood']" => array(
			'level' => 1,
			'zooms' => range( 9,18),
			'color' => array( 7 => '#f5f5f5', 11 => '#D2E6CF', 14 => $_WOOD_BASE_COLOR),
			'smooth' => 1,
		),
	"[natural='scrub'],[natural='heath']" => array(
			'level' => 1,
			'zooms' => range( 9,18),
			'color' => array( 7 => '#f5f5f5', 14 => $_NATURAL_SCRUB_COLOR),
			'smooth' => 1,
		),
	"[landuse='scrub']" => array(
			'level' => 1,
			'zooms' => range( 9,18),
			'color' => array( 7 => '#f5f5f5', 14 => $_LANDUSE_SCRUB_COLOR),
			'smooth' => 1,
		),
	"[landuse='grass'],[landuse='grassland'],[landuse='meadow']" => array(
			'level' => 1,
			'zooms' => range(10,18),
			'color' => array( 9 => '#f5f5f5', 14 => $_LANDUSE_GRASS_COLOR),
			'smooth' => 1,
	),
	"[natural='grass'],[natural='grassland'],[natural='meadow'],[natural='fell']" => array(
			'level' => 1,
			'zooms' => range(10,18),
			'color' => array( 9 => '#f5f5f5', 14 => $_NATURAL_GRASS_COLOR),
			'smooth' => 1,
	),
	"[natural='sand'],[natural='beach'],[leisure='beach_resort']" => array(
			'level' => 1,
			'zooms' => range( 9,18),
			'color' => array( 7 => '#f5f5f5', 14 => '#FAF2DC'),
			'smooth' => 1,
		),
	"[natural='glacier']" => array(
			'level' => 1,
			'zooms' => range( 9,18),
			'color' => array( 7 => '#f5f5f5', 14 => '#DCF6FA'),
			'smooth' => 1,
		),	
	"[natural='scree']" => array(
			'level' => 1,
			'zooms' => range( 9,18),
			'color' => array( 7 => '#f5f5f5', 14 => '#DEDEDE'),
			'smooth' => 1,
		),	
	"[leisure='park'],[landuse='park'],[landuse='allotments'],[landuse='cemetery'],[amenity='grave_yard'],[leisure='garden'],[landuse='orchard'],[leisure='orchard'],[landuse='recreation_ground'],[landuse='village_green'],[landuse='vineyard'],[leisure='golf_course'],[tourism='zoo']" => array(
			'level' => 1,
			'zooms' => range(11,18),
			'color' => $_PARK_COLOR,
		),	
	"[landuse='farm'],[landuse='farmland'],[landuse='plant_nursery'],[landuse='field']" => array(
			'level' => 1,
			'zooms' => range(9,18),
			'color' => array( 9 => '#f5f5f5', 14 => $_FARM_GRAIN_COLOR),
		),
	"[landuse='farmyard'],[landuse='greenhouse_horticulture']" => array(
			'level' => 1,
			'zooms' => range( 10,18),
			'color' => array( 10 => $_RESIDENTIAL_BASE2_COLOR, 12 => '#D7D9C5',18=>'#F2F2EE'),
		),
	"[landuse='industrial'],[landuse='industrial;retail'],[power='station'],[power='sub_station'],[power='generator']" => array(
			'level' => 1,
			'zooms' => range( 10,18),
			'color' => array( 10 => $_RESIDENTIAL_BASE2_COLOR, 12 => '#D9C5C5',18=>'#F2EEEE'),
		),	
	"[landuse='landfill']" => array(
			'level' => 1,
			'zooms' => range( 10,18),
			'color' => array( 10 => $_RESIDENTIAL_BASE2_COLOR, 12 => '#C9C2A3'),
		),	
	"[landuse='commercial'],[landuse='retail']" => array(
			'level' => 1,
			'zooms' => range( 10,18),
			'color' => array( 10 => $_RESIDENTIAL_BASE2_COLOR, 12 => '#D9C5D9',18 => '#F2EEF2'),
		),	
	"[landuse='railway']" => array(
			'level' => 1,
			'zooms' => range(10,18),
			'color' => array(10 => $_RESIDENTIAL_BASE2_COLOR, 12 => '#D9D9D9',18 => '#F2F2F2'),
		),
	"[landuse='residential'],[landuse='brownfield'],[landuse='construction'],[landuse='garages'],[landuse='greenfield'][historic='castle']" => array(
			'level' => 1,
			'zooms' => range( 9,18),
			'color' => $_RESIDENTIAL_COLOR,
		),
	"[landuse='quarry'],[landuse='salt_pond'],[landuse='pond'],[landuse='mine']" => array(
			'level' => 1,
			'zooms' => range( 10,18),
			'color' => array( 10 => $_RESIDENTIAL_BASE2_COLOR, 12 => '#D9D0C5'),
		),	
		
	"[natural='wood'][wood='mixed']" => array(
			'level'           => 2,
			'pattern-zooms'   => range(13,18),
			'pattern-file'    => 'forest-mixed',
			'pattern-size'    => array(14 => 20),
			'pattern-margin'  => array(14 => 2.0),
			'pattern-opacity' => array(14 => $_LANDCOVER_PATTERN_OPACITY),
			'pattern-color'   => array( 7 => '#f5f5f5', 13 => darken($_WOOD_BASE_COLOR,$_LANDCOVER_PATTERN_DARKEN)),
			'smooth' => 1
		),
	"[landuse='forest'][wood='mixed']" => array(
			'level'           => 2,
			'pattern-zooms'   => range(13,18),
			'pattern-file'    => 'forest-mixed',
			'pattern-size'    => array(14 => 20),
			'pattern-margin'  => array(14 => 2.0),
			'pattern-opacity' => array(14 => $_LANDCOVER_PATTERN_OPACITY),
			'pattern-color'   => array( 7 => '#f5f5f5', 13 => darken($_FOREST_BASE_COLOR,$_LANDCOVER_PATTERN_DARKEN)),
			'smooth' => 1
		),
	"[natural='wood'][wood='coniferous']" => array(
			'level' => 1,
			'pattern-zooms'   => range(13,18),
			'pattern-file'    => 'forest-coniferous',
			'pattern-size'    => array(14 => 20),
			'pattern-margin'  => array(14 => 2.0),
			'pattern-opacity' => array(14 => $_LANDCOVER_PATTERN_OPACITY),
			'pattern-color'   => array( 7 => '#f5f5f5', 13 => darken($_WOOD_BASE_COLOR,$_LANDCOVER_PATTERN_DARKEN)),			
			'smooth' => 1
		),
	"[landuse='forest'][wood='coniferous']" => array(
			'level'           => 2,
			'pattern-zooms'   => range(13,18),
			'pattern-file'    => 'forest-coniferous',
			'pattern-size'    => array(14 => 20),
			'pattern-margin'  => array(14 => 2.0),
			'pattern-opacity' => array(14 => $_LANDCOVER_PATTERN_OPACITY),
			'pattern-color'   => array( 7 => '#f5f5f5', 13 => darken($_FOREST_BASE_COLOR,$_LANDCOVER_PATTERN_DARKEN)),
			'smooth' => 1
		),
	"[landuse='forest'][wood='deciduous']" => array(
			'level'           => 2,
			'pattern-zooms'   => range(13,18),
			'pattern-file'    => 'forest-deciduous',
			'pattern-size'    => array(14 => 20),
			'pattern-margin'  => array(14 => 2.0),
			'pattern-opacity' => array(14 => $_LANDCOVER_PATTERN_OPACITY),
			'pattern-color'   => array( 7 => '#f5f5f5', 13 => darken($_FOREST_BASE_COLOR,$_LANDCOVER_PATTERN_DARKEN)),
			'smooth' => 1
		),
		
	"[natural='wood'][wood='deciduous']" => array(
			'level'           => 2,
			'pattern-zooms'   => range(13,18),
			'pattern-file'    => 'forest-deciduous',
			'pattern-size'    => array(14 => 20),
			'pattern-margin'  => array(14 => 2.0),
			'pattern-opacity' => array(14 => $_LANDCOVER_PATTERN_OPACITY),
			'pattern-color'   => array( 7 => '#f5f5f5', 13 => darken($_WOOD_BASE_COLOR,$_LANDCOVER_PATTERN_DARKEN)),
			'smooth' => 1
		),
	
	"[landuse='grass'],[landuse='grassland'],[landuse='meadow'],.x2" => array(
			'level'           => 2,
			'pattern-zooms'   => range(13,18),
			'pattern-file'    => 'landuse-grass',
			'pattern-size'    => array(13 => 11,18 => 15),
			'pattern-margin'  => array(13 => 1.8),
			'pattern-opacity' => array(13 => $_LANDCOVER_PATTERN_OPACITY),
			'pattern-color'   => array( 7 => '#f5f5f5', 13 => darken($_LANDUSE_GRASS_COLOR,$_LANDCOVER_PATTERN_DARKEN)),
			'smooth' => 1
		),
	
	"[natural='grassland'],[natural='meadow'],[natural='fell'],.x2" => array(
			'level'           => 2,
			'pattern-zooms'   => range(13,18),
			'pattern-file'    => 'landuse-grass',
			'pattern-size'    => array(13 => 11,18 => 15),
			'pattern-margin'  => array(13 => 1.8),
			'pattern-opacity' => array(13 => $_LANDCOVER_PATTERN_OPACITY),
			'pattern-color'   => array( 7 => '#f5f5f5', 13 => darken($_NATURAL_GRASS_COLOR,$_LANDCOVER_PATTERN_DARKEN)),
			'smooth' => 1
		),
	"[natural='heath'],[natural='scrub'],.x2" => array(
			'level'           => 2,
			'pattern-zooms'   => range(13,18),
			'pattern-file'    => 'landuse-scrub',
			'pattern-size'    => array(13 => 12,18 => 17),
			'pattern-margin'  => array(14 => 1.5),
			'pattern-opacity' => array(14 => $_LANDCOVER_PATTERN_OPACITY),		
			'pattern-color'   => array( 7 => '#f5f5f5', 13 => darken($_NATURAL_SCRUB_COLOR,$_LANDCOVER_PATTERN_DARKEN)),
			'smooth' => 1	
		),
	"[landuse='scrub'],.x2" => array(
			'level' => 2,
			'pattern-zooms'   => range(13,18),
			'pattern-file'    => 'landuse-scrub',
			'pattern-size'    => array(13 => 12,18 => 17),
			'pattern-margin'  => array(14 => 1.5),
			'pattern-opacity' => array(14 => $_LANDCOVER_PATTERN_OPACITY),		
			'pattern-color'   => array( 7 => '#f5f5f5', 13 => darken($_LANDUSE_SCRUB_COLOR,$_LANDCOVER_PATTERN_DARKEN)),
			'smooth'          => 1	
		),	
	"[landuse='vineyard'],.x2" => array(
			'level'           => 2,
			'pattern-zooms'   => range(13,18),
			'pattern-file'    => 'vineyard',
			'pattern-size'    => array(13 => 12,18 => 17),
			'pattern-margin'  => array(14 => 1.5),
			'pattern-opacity' => array(14 => $_LANDCOVER_PATTERN_OPACITY),		
			'pattern-color'   => array( 7 => '#f5f5f5', 13 => darken($_LEISURE_PARK_COLOR,$_LANDCOVER_PATTERN_DARKEN)),
			'smooth'          => 1	
		),
		
	"[landuse='landfill'],.x2" => array(
			'level'           => 2,
			'pattern-zooms'   => range(13,18),
			'pattern-file'    => 'landfill',
			'pattern-size'    => array(13 => 12,18 => 20),
			'pattern-margin'  => array(14 => 1.3),
			'pattern-opacity' => array(14 => $_LANDCOVER_PATTERN_OPACITY),		
			'pattern-color'   => array( 7 => '#f5f5f5', 12 => darken('#C9C2A3',$_LANDCOVER_PATTERN_DARKEN)),			
		),
	"[landuse='orchard'],.x2" => array(
			'level'           => 2,
			'pattern-zooms'   => range(13,18),
			'pattern-file'    => 'forest-deciduous',
			'pattern-size'    => array(14 => 20),
			'pattern-margin'  => array(14 => 2.0),
			'pattern-opacity' => array(14 => $_LANDCOVER_PATTERN_OPACITY),
			'pattern-color'   => array(10 => $_RESIDENTIAL_BASE2_COLOR, 13 => darken($_LEISURE_PARK_COLOR,$_LANDCOVER_PATTERN_DARKEN)),
			'smooth' => 1
		),
	"[power='station'],[power='sub_station'],[power='generator']" => array(
			'level'           => 2,
			'pattern-zooms'   => range(13,18),
			'pattern-file'    => 'power-generator',
			'pattern-size'    => array(13 => 12,18 => 17),
			'pattern-margin'  => array(14 => 1.5),
			'pattern-opacity' => array(14 => $_LANDCOVER_PATTERN_OPACITY),		
			'pattern-color'   => array( 7 => '#f5f5f5', 12 => darken('#D9C5C5',$_LANDCOVER_PATTERN_DARKEN),12 => darken('#F2EEEE',$_LANDCOVER_PATTERN_DARKEN)),			
		),
	
	"[landuse='farm'],[landuse='farmland'],[landuse='plant_nursery'],[landuse='field'],.x2" => array(
			'level' => 2,
			'pattern-zooms'   => range(13,18),
			'pattern-file'    => 'landuse-farm',
			'pattern-size'    => array(13 => 13,18 => 17),
			'pattern-margin'  => array(13 => 1.5),
			'pattern-opacity' => array(13 => $_LANDCOVER_PATTERN_OPACITY),			
			'pattern-color'   => array(10 => $_RESIDENTIAL_BASE2_COLOR, 12 => darken($_FARM_GRAIN_COLOR,$_LANDCOVER_PATTERN_DARKEN)),
			'smooth'          => 1
		),
	
	"[leisure='pitch'],[leisure='track'],[leisure='sports_centre'],[leisure='stadium']" => array(
			'level' => 2,
			'zooms' => range(14,18),
			'color' => array( 13 => $_RESIDENTIAL_BASE_COLOR, 15 => '#e8937c'),			
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
	
	"[landuse='cemetery'][religion!='christian'][religion!='jewish'][religion!='muslim'],[amenity='grave_yard'][religion!='christian'][religion!='jewish'][religion!='muslim']" => array(
			'level' => 2,
			'pattern-zooms'   => range(13,18),
			'pattern-file'    => 'cemetery',
			'pattern-size'    => array(13 => 9, 18 => 20),
			'pattern-margin'  => array(14 => 2.1),
			'pattern-opacity' => array(14 => 0.15),			
		),
		
	"[landuse='cemetery'][religion='christian'],[amenity='grave_yard'][religion='christian'],.x2" => array(
			'level' => 2,
			'pattern-zooms'   => range(13,18),
			'pattern-file'    => 'cemetery-christian',
			'pattern-size'    => array(13 => 9, 18 => 20),
			'pattern-margin'  => array(14 => 2.1),
			'pattern-opacity' => array(14 => 0.15),
		),
	"[landuse='cemetery'][religion='jewish'],[amenity='grave_yard'][religion='jewish'],.x2" => array(
			'level' => 2,
			'pattern-zooms'   => range(13,18),
			'pattern-file'    => 'cemetery-jewish',
			'pattern-size'    => array(13 => 9, 18 => 20),
			'pattern-margin'  => array(14 => 2.1),
			'pattern-opacity' => array(14 => 0.15),
		),
	"[landuse='cemetery'][religion='muslim'],[amenity='grave_yard'][religion='muslim']" => array(
			'level' => 2,
			'pattern-zooms'   => range(13,18),
			'pattern-file'    => 'cemetery-muslim',
			'pattern-size'    => array(13 => 9, 18 => 20),
			'pattern-margin'  => array(14 => 2.1),
			'pattern-opacity' => array(14 => 0.15),
		),
	
	"[tourism='zoo']" => array(
			'level' => 2,
			'pattern-zooms'   => range(13,18),
			'pattern-file'    => 'tourism-zoo',
			'pattern-size'    => array(14 => 20),
			'pattern-margin'  => array(14 => 2.0),
			'pattern-opacity' => array(14 => $_LANDCOVER_PATTERN_OPACITY),
			'pattern-color'   => array(10 => $_RESIDENTIAL_BASE2_COLOR, 13 => darken($_LEISURE_PARK_COLOR,$_LANDCOVER_PATTERN_DARKEN)),
			'smooth' => 1
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
			'pattern-zooms'    => range(14,18),
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
			'color' => array( 13 => $_RESIDENTIAL_BASE_COLOR, 15 => '#e8aa80'),
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
		'zooms' => range(13,18),
		'pattern-file' => 'rock',
		'pattern-size' => array(13=>13,18=>28),
		'pattern-spacing' => array(14=>20),
		'width' => array(14 => 0.0),
		'color' => $_CONTOUR_COLOR,
	),
	"[natural='tree_row']" => array(
		'zooms' => range(13,18),
		'pattern-file' => 'tree_row',
		'pattern-size' => array(13=>4,18=>8),
		'pattern-spacing' => array(13=>4,18=>8),
		'width' => array(14 => 0.0),
		'color' => array( 7 => '#f5f5f5', 13 => darken($_FOREST_BASE_COLOR,40)),
	),
);


/**
* Zoom x landcover point look maping
*/
$LANDCOVER_POINT = array(
	"[natural='tree']" => array(
		'zooms' => range(13,18),
		'symbol-file' => 'tree',
		'symbol-color' => array( 7 => '#f5f5f5', 13 => darken($_FOREST_BASE_COLOR,40)),
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

