<?php
require_once "conf/common.conf.php";

/**
 * Power grade definition
 */
define('POWER_LINE'      , 1);
define('POWER_MINOR_LINE', 2);

$_POWER_COLOR = array( 14 => '#aa8888');

/**
 * Zoom => Power grade rail visibility maping 
 */
$POWER_GRADES = array (	 
 5 => array(),
 6 => array(),
 7 => array(),
 8 => array(),
 9 => array(),
10 => array(),
11 => array(),
12 => array(),
13 => array(),
14 => range(POWER_LINE, POWER_LINE),
15 => range(POWER_LINE, POWER_MINOR_LINE),
16 => range(POWER_LINE, POWER_MINOR_LINE),
17 => range(POWER_LINE, POWER_MINOR_LINE),
18 => range(POWER_LINE, POWER_MINOR_LINE),
);


/**
 * Power color grade x zoom maping
 */
$POWER_COLOR = array(
POWER_LINE       => $_POWER_COLOR,
POWER_MINOR_LINE => $_POWER_COLOR,
);



/**
 * Power width grade x zoom maping
 */
$POWER_WIDTH = array(
POWER_LINE        => array( 14 => 1.0, 15 => 1.5),
POWER_MINOR_LINE  => array( 15 => 1.0),
);


$POWERPOINT = array(	
	"[power='pole']" => array(
			'zooms' => range(15,18),
			'point-template' => 'power-pole',
			'point-file' => 'power-pole',						
			'size' => array(15 => 5,18 => 10),
			'color' => $_POWER_COLOR,
		),
	"[power='tower']" => array(
			'zooms' => range(14,18),
			'point-template' => 'power-pole',
			'point-file' => 'power-tower',						
			'size' => array(14 => 6,18 => 16),
			'color' => $_POWER_COLOR,
		),
);
