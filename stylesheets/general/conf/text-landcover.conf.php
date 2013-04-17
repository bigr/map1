<?php
require_once "conf/text.conf.php";
require_once "conf/landcover.conf.php";



/**
 * Waterarea name text size pixelarea x zoom maping
 */
$LANDCOVER_NAME_SIZE = array(    
    3300 => array( 8 =>  9),
   10000 => array( 8 => 14),
   33000 => array( 8 => 22),
  100000 => array( 8 => 36),
  330000 => array( 8 => 55),
 1000000 => array( 8 => 90),
 3300000 => array( 8 => 150),
10000000 => array( 8 => 220),
);

$LANDCOVER_NAME_COLOR = array(8 => '#ffffff');

function landcover_name_priority($sz) {
	
	if ( $sz > 35) return -1;				
	else if ( $sz > 12 ) return 2;	
	else return 3;
}

function landcover_name_opacity($sz) {
					
	if ( $sz > 35 ) return 0.5;	
	else return 0.7;		
}

/**
 * Waterarea name text halo radius zoom maping
 */
$LANDCOVER_NAME_HALO_RADIUS = array( 8 => 2);
