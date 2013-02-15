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
RAILWAY_MAIN    => array(  9 => '#444444', 13 => '#333333', 17 => '#222222'),
RAILWAY_BRANCH  => array( 10 => '#555555', 13 => '#444444', 17 => '#333333'),
RAILWAY_LIGHT   => array( 11 => '#666666', 13 => '#555555', 17 => '#444444'),
RAILWAY_SIDING  => array( 12 => '#666666', 13 => '#666666', 17 => '#555555'),
RAILWAY_DISUSED => array( 13 => '#888888', 13 => '#888888', 17 => '#888888'),
);


/**
 * Railway width grade x zoom maping
 */
$RAILWAY_WIDTH = array(
RAILWAY_MAIN    => array(  9 => 3.0, 13 => 4.5, 17 => 6.0),
RAILWAY_BRANCH  => array( 10 => 3.0, 13 => 4.0, 17 => 5.0),
RAILWAY_LIGHT   => array( 11 => 3.0, 13 => 3.5, 17 => 4.2),
RAILWAY_SIDING  => array( 12 => 3.0, 13 => 3.0, 17 => 3.5),
RAILWAY_DISUSED => array( 13 => 3.0, 13 => 3.0, 17 => 3.0),
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
RAILWAY_MAIN    => array(  9 => array(2,4), 13 => array(6,12), 17 => array(6,12)),
RAILWAY_BRANCH  => array( 10 => array(2,4), 13 => array(5,10), 17 => array(5,10)),
RAILWAY_LIGHT   => array( 11 => array(2,4), 13 => array(4,8), 17 => array(4,8)),
RAILWAY_SIDING  => array( 12 => array(2,4), 13 => array(3,6), 17 => array(3,6)),
RAILWAY_DISUSED => array(                   13 => array(2,2), 17 => array(2,2)),
);
