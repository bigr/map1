<?php
require_once "inc/utils.php";
require_once "conf/common.conf.php";

$ROUTE_MAX_COUNT = 4;

/**
 * Hiking route grade definition
 */
define('ROUTE_HIKING_MAJOR'  , 0);
define('ROUTE_HIKING_LOCAL'  , 1);
define('ROUTE_HIKING_RUIN'   , 2);
define('ROUTE_HIKING_UNKNOWN', 3);


/**
 * Bicycle route grade definition
 */
define('ROUTE_BICYCLE_ICN'    , 0);
define('ROUTE_BICYCLE_NCN'    , 1);
define('ROUTE_BICYCLE_RCN'    , 2);
define('ROUTE_BICYCLE_LCN'    , 3);
define('ROUTE_BICYCLE_UNKNOWN', 4);


$_KCT_BLUE   = array( 13 => '#0000bb');
$_KCT_RED    = array( 13 => '#dd0000');
$_KCT_GREEN  = array( 13 => '#008000');
$_KCT_YELLOW = array( 13 => '#e7c500');
$_ROUTE_ORANGE = array( 13 => '#E77B00');
$_ROUTE_BROWN = array( 13 => '#963011');
$_ROUTE_BLACK = array( 13 => '#273561');
$_ROUTE_WHITE = array( 13 => '#9EA3A3');
$_ROUTE_PURPLE = array( 13 => '#5819B5');


$BICYCLE_ROUTE_ICN_COLOR = array(12 => '#8041A3');
$BICYCLE_ROUTE_NCN_COLOR = array(12 => '#9259B3');
$BICYCLE_ROUTE_RCN_COLOR = array(12 => '#B683D4');
$BICYCLE_ROUTE_LCN_COLOR = array(12 => '#D1ACE6');

$_SKI_ROUTE_COLOR = array(12 => '#36D9C8');

$_ROUTE_WIDTH = array(12 => 1,13=>2.1,15 => 2.5, 18=>3.2);

/**
 * Zoom => Hiking route grade zoom visibility maping 
 */
$ROUTE_HIKING_GRADES = array (	 
 5 => array(),
 6 => array(),
 7 => array(),
 8 => array(),
 9 => array(),
10 => array(),
11 => array(),
12 => range(ROUTE_HIKING_MAJOR, ROUTE_HIKING_UNKNOWN),
13 => range(ROUTE_HIKING_MAJOR, ROUTE_HIKING_UNKNOWN),
14 => range(ROUTE_HIKING_MAJOR, ROUTE_HIKING_UNKNOWN),
15 => range(ROUTE_HIKING_MAJOR, ROUTE_HIKING_UNKNOWN),
16 => range(ROUTE_HIKING_MAJOR, ROUTE_HIKING_UNKNOWN),
17 => range(ROUTE_HIKING_MAJOR, ROUTE_HIKING_UNKNOWN),
18 => range(ROUTE_HIKING_MAJOR, ROUTE_HIKING_UNKNOWN),
);

/**
 * Zoom => Bicycle route grade zoom visibility maping 
 */
$ROUTE_BICYCLE_GRADES = array (	 
 5 => array(),
 6 => array(),
 7 => array(),
 8 => array(),
 9 => array(),
10 => array(),
11 => array(),
12 => range(ROUTE_BICYCLE_ICN,ROUTE_BICYCLE_NCN),
13 => range(ROUTE_BICYCLE_ICN,ROUTE_BICYCLE_NCN),
14 => range(ROUTE_BICYCLE_ICN, ROUTE_BICYCLE_RCN),
15 => range(ROUTE_BICYCLE_ICN, ROUTE_BICYCLE_LCN),
16 => range(ROUTE_BICYCLE_ICN, ROUTE_BICYCLE_LCN),
17 => range(ROUTE_BICYCLE_ICN, ROUTE_BICYCLE_LCN),
18 => range(ROUTE_BICYCLE_ICN, ROUTE_BICYCLE_LCN),
);

/**
 * Hiking route width grade x zoom maping
 */
$ROUTE_HIKING_WIDTH = $_ROUTE_WIDTH;

/**
 * Hiking route opacity grade x zoom maping
 */
$ROUTE_HIKING_OPACITY = array(12 => 0.5,13 => 1.0);


/**
 * Hiking routes available colors
 */
$ROUTE_HIKING_COLORS = array('red','green','blue','yellow','orange','brown','black','white','purple','unknown');

/**
 * Hiking route kct color
 */
$ROUTE_HIKING_COLOR = array(
'red' => $_KCT_RED,
	

'green' =>  $_KCT_GREEN,
	

'blue' => $_KCT_BLUE,
	

'yellow' => $_KCT_YELLOW,
	

'orange' => $_ROUTE_ORANGE,
	

'brown' => $_ROUTE_BROWN,
	

'black' => $_ROUTE_BLACK,

'white' => $_ROUTE_WHITE,
	
'purple' => $_ROUTE_PURPLE,
	

'unknown' => $_KCT_RED,
	
); //ROUTE_HIKING_COLOR;


/**
 * Bicycle route width grade x zoom maping
 */
$ROUTE_BICYCLE_WIDTH = $_ROUTE_WIDTH;

/**
 * Bicycle route opacity grade x zoom maping
 */
$ROUTE_BICYCLE_OPACITY = array(12 => 0.5,13 => 1.0);



$ROUTE_BICYCLE_LCN_DENSITY = array(12 => 15,13 => 15,14 => 30, 15 => 1000, 16 => 1000, 17 => 1000, 18 => 1000);

$ROUTE_BICYCLE_RCN_DENSITY = array(12 => 30,13 => 30,14 => 60, 15 => 1000, 16 => 1000, 17 => 1000, 18 => 1000);

/**
 * Ski route width grade x zoom maping
 */
$ROUTE_SKI_WIDTH = $_ROUTE_WIDTH;

/**
 * Ski route opacity grade x zoom maping
 */
$ROUTE_SKI_OPACITY = array(12 => 0.5,13 => 1.0);

/**
 * Ski route kct blue color
 */
$ROUTE_SKI_COLOR = $_SKI_ROUTE_COLOR;
