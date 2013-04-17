<?php
require_once "conf/text.conf.php";
require_once "conf/building.conf.php";



/**
 * Building name text size pixelarea x zoom maping
 */
$BUILDING_NAME_SIZE = array(    
    330 => array( 8 =>  5),
   1000 => array( 8 =>  7),
   3300 => array( 8 =>  9),
  10000 => array( 8 => 14),
  33000 => array( 8 => 22),
 100000 => array( 8 => 36),
 330000 => array( 8 => 55),
1000000 => array( 8 => 90),
);

$BUILDING_NAME_COLOR = array(8 => '#ffffff');

function building_name_priority($sz) {
	
	if ( $sz > 50) return -1;				
	else if ( $sz > 25 ) return 2;	
	else return 3;
}

function building_name_opacity($sz) {
					
	if ( $sz > 35 ) return 0.5;	
	else return 0.7;		
}

/**
 * Building name text halo radius zoom maping
 */
$BUILDING_NAME_HALO_RADIUS = array( 8 => 2);
