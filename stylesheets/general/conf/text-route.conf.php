<?php
require_once "conf/text.conf.php";
require_once "conf/route.conf.php";


/**
 * Zoom -> grade -> route ref visibility/render priority maping
 */
$ROUTE_REF_PRIORITIES = array (	 
 5 => array(),
 6 => array(),
 7 => array(),
 8 => array(),
 9 => array(),
10 => array(),
11 => array(),
12 => array(),
13 => array(
		ROUTE_BICYCLE_ICN     => 1,
		ROUTE_BICYCLE_NCN     => 1,
	),	
14 => array(
		ROUTE_BICYCLE_ICN     => 1,
		ROUTE_BICYCLE_NCN     => 1,
		ROUTE_BICYCLE_RCN     => 1,		
	),
15 => array(
		ROUTE_BICYCLE_ICN     => 1,
		ROUTE_BICYCLE_NCN     => 1,
		ROUTE_BICYCLE_RCN     => 1,
		ROUTE_BICYCLE_LCN     => 1,
	),
16 => array(
		ROUTE_BICYCLE_ICN     => 1,
		ROUTE_BICYCLE_NCN     => 1,
		ROUTE_BICYCLE_RCN     => 1,
		ROUTE_BICYCLE_LCN     => 1,
	),
17 => array(
		ROUTE_BICYCLE_ICN     => 1,
		ROUTE_BICYCLE_NCN     => 1,
		ROUTE_BICYCLE_RCN     => 1,
		ROUTE_BICYCLE_LCN     => 1,
	),
18 => array(
		ROUTE_BICYCLE_ICN     => 1,
		ROUTE_BICYCLE_NCN     => 1,
		ROUTE_BICYCLE_RCN     => 1,
		ROUTE_BICYCLE_LCN     => 1,
	),
);


/**
 * Zoom -> grade -> route name visibility/render priority maping
 */
$ROUTE_NAME_PRIORITIES = array (
 5 => array(),
 6 => array(),
 7 => array(),	 
 8 => array(),
 9 => array(),
10 => array(),
11 => array(),
12 => array(),
13 => array(
		ROUTE_HIKING_MAJOR   => 2,		
	),	
14 => array(
		ROUTE_HIKING_MAJOR   => 1,
		ROUTE_HIKING_LOCAL   => 1,
		ROUTE_HIKING_RUIN    => 1,
		ROUTE_HIKING_UNKNOWN => 1,
	),	
15 => array(
		ROUTE_HIKING_MAJOR   => 1,
		ROUTE_HIKING_LOCAL   => 1,
		ROUTE_HIKING_RUIN    => 1,
		ROUTE_HIKING_UNKNOWN => 1,
	),
16 => array(
		ROUTE_HIKING_MAJOR   => 1,
		ROUTE_HIKING_LOCAL   => 1,
		ROUTE_HIKING_RUIN    => 1,
		ROUTE_HIKING_UNKNOWN => 1,
	),
17 => array(
		ROUTE_HIKING_MAJOR   => 1,
		ROUTE_HIKING_LOCAL   => 1,
		ROUTE_HIKING_RUIN    => 1,
		ROUTE_HIKING_UNKNOWN => 1,
	),
18 => array(
		ROUTE_HIKING_MAJOR   => 1,
		ROUTE_HIKING_LOCAL   => 1,
		ROUTE_HIKING_RUIN    => 1,
		ROUTE_HIKING_UNKNOWN => 1,
	),
);


/**
 * Route ref text color grade x zoom maping
 */
$ROUTE_REF_COLOR = array(
ROUTE_BICYCLE_ICN  => array(13 => '#000000'),
ROUTE_BICYCLE_NCN  => array(13 => '#000000'),
ROUTE_BICYCLE_RCN  => array(13 => '#000000'),
ROUTE_BICYCLE_LCN  => array(13 => '#000000'),
);

/**
 * Route ref text size grade x zoom maping
 */
$ROUTE_REF_SIZE = array(
ROUTE_BICYCLE_ICN => array(13 =>  12),
ROUTE_BICYCLE_NCN => array(13 =>  12),
ROUTE_BICYCLE_RCN => array(13 =>  12),
ROUTE_BICYCLE_LCN => array(13 =>  12),
);

$ROUTE_REF_MINIMUM_DISTANCE  = array(
ROUTE_BICYCLE_ICN => array(15 => 150),
ROUTE_BICYCLE_NCN => array(15 => 150),
ROUTE_BICYCLE_RCN => array(15 => 150),
ROUTE_BICYCLE_LCN => array(15 => 150),
);
/**
 * Height of the route ref shield
 */
$ROUTE_REF_SHIELD_HEIGHT = array(
ROUTE_BICYCLE_ICN => array(13 => 12.5),
ROUTE_BICYCLE_NCN => array(13 => 12.5),
ROUTE_BICYCLE_RCN => array(13 => 12.5),
ROUTE_BICYCLE_LCN => array(13 => 12.5),
);

/**
 * Width of the one letter in route ref shield
 */
$ROUTE_REF_SHIELD_LETTER_WIDTH = array(
ROUTE_BICYCLE_ICN => array(13 =>  6),
ROUTE_BICYCLE_NCN => array(13 =>  6),
ROUTE_BICYCLE_RCN => array(13 =>  6),
ROUTE_BICYCLE_LCN => array(13 =>  6),
);

/**
 * Width padding of the route ref shield
 */
$ROUTE_REF_SHIELD_PADDING_WIDTH = $ROUTE_REF_SHIELD_LETTER_WIDTH;

/**
 * Background color of the route ref shield
 */
$ROUTE_REF_SHIELD_FILL = array(
ROUTE_BICYCLE_ICN => array(13 => '#f3ff00'),
ROUTE_BICYCLE_NCN => array(13 => '#f3ff00'),
ROUTE_BICYCLE_RCN => array(13 => '#f3ff00'),
ROUTE_BICYCLE_LCN => array(13 => '#f3ff00'),
);


/**
 * Route ref text size grade x zoom maping
 */
$ROUTE_NAME_SIZE = array(
ROUTE_HIKING_MAJOR   => array(13 => 12, 15 => 15),
ROUTE_HIKING_LOCAL   => array(13 => 12, 15 => 14),
ROUTE_HIKING_RUIN    => array(14 => 12, 15 => 13),
ROUTE_HIKING_UNKNOWN => array(14 => 12, 15 => 13),
);


/**
 * Route ref text size grade x zoom maping
 */
$ROUTE_NAME_SIZE = array(
ROUTE_HIKING_MAJOR   => array(13 => 12, 15 => 15),
ROUTE_HIKING_LOCAL   => array(13 => 12, 15 => 14),
ROUTE_HIKING_RUIN    => array(14 => 12, 15 => 13),
ROUTE_HIKING_UNKNOWN => array(14 => 12, 15 => 13),
);





/**
 * Zoom -> grade -> route osmcsymbol visibility/render priority maping
 */
$ROUTE_OSMCSYMBOL_PRIORITIES = array (
13 => 4,		
14 => 4,	
15 => 3,
16 => 3,
17 => 2,
18 => 2,
);



/**
 * Route osmcsymbol text size grade x zoom maping
 */
$ROUTE_OSMCSYMBOL_SIZE = array(13 => 12);

$ROUTE_REF_MINIMUM_DISTANCE  = array(
ROUTE_BICYCLE_ICN => array(15 => 150),
ROUTE_BICYCLE_NCN => array(15 => 150),
ROUTE_BICYCLE_RCN => array(15 => 150),
ROUTE_BICYCLE_LCN => array(15 => 150),
);
/**
 * Height of the route ref shield
 */
$ROUTE_REF_SHIELD_HEIGHT = array(
ROUTE_BICYCLE_ICN => array(13 => 12.5),
ROUTE_BICYCLE_NCN => array(13 => 12.5),
ROUTE_BICYCLE_RCN => array(13 => 12.5),
ROUTE_BICYCLE_LCN => array(13 => 12.5),
);

/**
 * Width of the one letter in route ref shield
 */
$ROUTE_REF_SHIELD_LETTER_WIDTH = array(
ROUTE_BICYCLE_ICN => array(13 =>  6),
ROUTE_BICYCLE_NCN => array(13 =>  6),
ROUTE_BICYCLE_RCN => array(13 =>  6),
ROUTE_BICYCLE_LCN => array(13 =>  6),
);

/**
 * Width padding of the route ref shield
 */
$ROUTE_REF_SHIELD_PADDING_WIDTH = $ROUTE_REF_SHIELD_LETTER_WIDTH;

/**
 * Minmial distance of route osmcsymbol shield
 */
$ROUTE_OSMCSYMBOL_MINDISTANCE = array(13=>15);

