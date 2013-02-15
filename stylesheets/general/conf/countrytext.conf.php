<?php
require_once "inc/utils.php";
require_once "conf/text.conf.php";


/**
 * Countrytext size zoom mapping
 */
$COUNTRYTEXT_SIZE = array(
	4 => 26,
	3 => 22,
	2 => 17,
	1 => 13,
	0 => 8,
);


/**
 * Countrytext zoom visibility maping
 */
$COUNTRYTEXT_ZOOMS = range(5,9);


/**
 * Countrytext opacity
 */
$COUNTRYTEXT_OPACITY = array(5=>0.6,10=>0);


/**
 * Countrytext size zoom mapping
 */
$SEATEXT_SIZE = array(
	4 => 35,
	3 => 26,
	2 => 18,
	1 => 14,
	0 => 7,
);


/**
 * Seatext zoom visibility maping
 */
$SEATEXT_ZOOMS = range(5,9);


/**
 * Seatext opacity
 */
$SEATEXT_OPACITY = array(5=>0.4,10=>0);
