<?php
require_once "conf/common.conf.php";

/**
 * Railway grade definition
 */
define('RAILWAY_MAIN'    , 1);
define('RAILWAY_BRANCH'  , 2);
define('RAILWAY_LIGHT'   , 3);
define('RAILWAY_SIDING'  , 4);
define('RAILWAY_DISUSED' , 5);


/**
 * Zoom => Railway grade rail visibility maping 
 */
$RAILWAY_GRADES = array (	 
 5 => array(),
 6 => array(),
 7 => array(),
 8 => array(),
 9 => range(RAILWAY_MAIN, RAILWAY_MAIN),
10 => range(RAILWAY_MAIN, RAILWAY_BRANCH),
11 => range(RAILWAY_MAIN, RAILWAY_LIGHT),
12 => range(RAILWAY_MAIN, RAILWAY_SIDING),
13 => range(RAILWAY_MAIN, RAILWAY_DISUSED),
14 => range(RAILWAY_MAIN, RAILWAY_DISUSED),
15 => range(RAILWAY_MAIN, RAILWAY_DISUSED),
16 => range(RAILWAY_MAIN, RAILWAY_DISUSED),
17 => range(RAILWAY_MAIN, RAILWAY_DISUSED),
18 => range(RAILWAY_MAIN, RAILWAY_DISUSED),
);


/**
 * Railway light color grade x zoom maping
 */
$RAILWAY_LIGHT_COLOR = array(
RAILWAY_MAIN    => array( 10 => '#ffffff'),
RAILWAY_BRANCH  => array( 10 => '#ffffff'),
RAILWAY_LIGHT   => array( 10 => '#ffffff'),
RAILWAY_SIDING  => array( 10 => '#ffffff'),
RAILWAY_DISUSED => array( 10 => '#ffffff'),
);


/**
 * Railway dark color grade x zoom maping
 */
$RAILWAY_DARK_COLOR = array(
RAILWAY_MAIN    => array(  9 => '#555555', 13 => '#555555', 17 => '#555555'),
RAILWAY_BRANCH  => array( 10 => '#555555', 13 => '#555555', 17 => '#555555'),
RAILWAY_LIGHT   => array( 11 => '#555555', 13 => '#555555', 17 => '#555555'),
RAILWAY_SIDING  => array( 12 => '#666666', 13 => '#666666', 17 => '#666666'),
RAILWAY_DISUSED => array( 13 => '#999999', 13 => '#999999', 17 => '#999999'),
);


/**
 * Railway width grade x zoom maping
 */
$RAILWAY_WIDTH = array(
RAILWAY_MAIN    => array(  9 => 3.0, 11 => 5.5, 18 => 8.0),
RAILWAY_BRANCH  => array( 10 => 3.0, 11 => 5.0, 18 => 7.0),
RAILWAY_LIGHT   => array( 11 => 3.0, 11 => 4.5, 18 => 6.2),
RAILWAY_SIDING  => array( 12 => 3.0, 11 => 4.0, 18 => 5.5),
RAILWAY_DISUSED => array( 13 => 3.0, 11 => 3.5, 18 => 4.0),
);


/**
 * Railway stroke width grade x zoom maping
 */
$RAILWAY_STROKE_WIDTH = array(
RAILWAY_MAIN    => array(  9 => 0.5, 13 => 0.8, 17 => 1.0),
RAILWAY_BRANCH  => array( 10 => 0.5, 13 => 0.7, 17 => 0.9),
RAILWAY_LIGHT   => array( 11 => 0.5, 13 => 0.6, 17 => 0.8),
RAILWAY_SIDING  => array( 12 => 0.5, 13 => 0.5, 17 => 0.6),
RAILWAY_DISUSED => array(            13 => 0.5, 17 => 0.5),
);

/**
 * Railway fill dash grade x zoom maping
 */
$RAILWAY_FILL_DASH = array(
RAILWAY_MAIN    => array(  9 => array(2,4), 13 => array(7,14), 17 => array(8,16)),
RAILWAY_BRANCH  => array( 10 => array(2,4), 13 => array(6,12), 17 => array(7,14)),
RAILWAY_LIGHT   => array( 11 => array(2,4), 13 => array(5,10), 17 => array(6,12)),
RAILWAY_SIDING  => array( 12 => array(2,4), 13 => array(4,8), 17 => array(5,10)),
RAILWAY_DISUSED => array(                   13 => array(3,3), 17 => array(4,4)),
);

$TRAM_ZOOMS = range(14,18);
$TRAM_COLOR = array(16=>'#773333');
$TRAM_OPACITY = array(14=>0.2,15=>0.4,18=>1.0);
$TRAM_WIDTH1 = array(16=>1);
$TRAM_WIDTH2 = array(14=>2,18=>7);

$FUNICULAR_ZOOMS = range(13,18);
$FUNICULAR_COLOR = array(16=>'#444444');
$FUNICULAR_OPACITY = array(13=>1.0);
$FUNICULAR_WIDTH = array(13=>2);
$FUNICULAR_WIDTH2 = array(13=>5,18=>12);


$SUBWAY_ZOOMS = array();
$SUBWAY_COLOR = array(16=>'#009900');
$SUBWAY_OPACITY = array(14=>0.2,15=>0.15,18=>0.2);
$SUBWAY_WIDTH = array(14=>10,18=>15);

$RAILWAY_TEXT_ZOOMS = array(
	13 => 3, 14 => 2, 15 => 2, 16 =>1, 17 => 1, 18 => 1
);

$RAILWAY_TEXT_SIZE = array(13 => 6, 18 => 15);

