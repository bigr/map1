<?php
require_once "inc/utils.php";
require_once "conf/common.conf.php";
require_once "conf/building.conf.php";
require_once "conf/landcover.conf.php";
require_once "conf/waters.conf.php";


/**
 * Zoom x barrier look maping
 */
$BARRIER = array(	
	"[barrier='city_wall']" => array(
			'zooms' => range(14,18),
			'template-file' => 'city_wall',
			'pattern-file' => 'city_wall',
			'pattern-size' => array(14=>6,18=>14),
			'pattern-spacing' => array(14=>0),
			'width' => array(14 => 2.0,18=>8.0),
			'color' => $BUILDING_COLOR,
		),
	"[barrier='wall']" => array(
			'zooms' => range(15,18),
			'template-file' => 'city_wall',
			'pattern-file' => 'wall',
			'pattern-size' => array(15=>4,18=>8),
			'pattern-spacing' => array(15=>1,18=>3),
			'width' => array(15 => 1.5,18=>4.5),
			'color' => $BUILDING_COLOR,
		),
	"[barrier='fence']" => array(
			'zooms' => range(16,18),
			'template-file' => 'fence',
			'pattern-file' => 'fence',
			'pattern-size' => array(16=>4,18=>7),
			'pattern-spacing' => array(16=>1,18=>3),
			'width' => array(16 => 1,18=>2.5),
			'color' => $BUILDING_COLOR,
		),
	"[barrier='hedge']" => array(
			'zooms' => range(16,18),
			'template-file' => 'fence',
			'pattern-file' => 'hedge',
			'pattern-size' => array(16=>4,18=>7),
			'pattern-spacing' => array(15=>1,18=>3),
			'width' => array(16 => 1,18=>2.5),
			'color' => $_PARK_COLOR,
		),
	"[barrier='ditch']" => array(
			'zooms' => range(16,18),
			'template-file' => 'fence',
			'pattern-file' => 'ditch',
			'pattern-size' => array(16=>5,18=>8),
			'pattern-spacing' => array(16=>1,18=>3),
			'width' => array(16 => 1.5,18=>4.0),
			'color' => $_WATER_COLOR,
		),
);
