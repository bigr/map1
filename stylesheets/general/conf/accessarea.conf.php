<?php
require_once "inc/utils.php";
require_once "conf/common.conf.php";
require_once "conf/text-place.conf.php";



/**
 * Zoom x access look maping
 */
$ACCESSAREA = array(	
	"[access='private'],[access='no']" => array(
			'level' => 1,
			'pattern-zooms'   => range(10,18),
			'pattern-file'    => 'access-no',
			'pattern-size'    => array(10 => 9,18 => 12),
			'pattern-margin'  => array(10 => 1.4,15 => 1.5),
			'pattern-opacity' => array(10 => 0.6,13 => 0.3,15=>0.2),
			'pattern-color'   => array( 7 => '#cc0000'),
		),
		
	"[access='customers']" => array(
			'level' => 1,
			'pattern-zooms'   => range(13,18),
			'pattern-file'    => 'access-customers',
			'pattern-size'    => array(10 => 10,18 => 14),
			'pattern-margin'  => array(14 => 1.5),
			'pattern-opacity' => array(14 => 0.15),
			'pattern-color'   => array( 7 => '#cc0000'),
		),
		
);

$ACCESSAREA_MINIMAL_AREA = $_MINIMAL_AREA;
