<?php
require_once "inc/utils.php";
require_once "common.conf.php";

$_AEROWAY_COLOR = array(15 => '#999999');

/**
 * Zoom x aeroway look maping
 */
$AEROWAY = array(
	"[aeroway='taxiway']" => array(
			'zooms' => range(13,18),			
			'width' => array(13 => 1.0,14 => 1.5, 18 => 5.0),
			'color' => $_AEROWAY_COLOR,
	),
	"[aeroway='runway']" => array(
			'zooms' => range(12,18),			
			'width' => array(12 => 3,14 => 4.0, 18 => 15.0),
			'color' => $_AEROWAY_COLOR,
	),
);

$AEROAREA = array(
	"[aeroway='apron'],[aeroway='taxiway'],[aeroway='runway']" => array(
			'zooms' => range(13,18),			
			'color' => $_AEROWAY_COLOR,
	),
);
