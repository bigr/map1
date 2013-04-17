<?php
require_once "inc/utils.php";
require_once "conf/common.conf.php";
require_once "conf/building.conf.php";
require_once "conf/landcover.conf.php";
require_once "conf/waters.conf.php";


$BARRIER_COLOR = darken_a($BUILDING_COLOR,35);

/**
 * Zoom x barrier look maping
 */
$BARRIER = array(	
	"[barrier='city_wall']" => array(
			'zooms' => range(12,18),
			'template-file' => 'city_wall',
			'pattern-file' => 'city_wall',
			'pattern-size' => array(13=>10,18=>24),
			'pattern-spacing' => array(13=>2.5,18=>6),
			'width' => array(13 => 2.5,18=>6),
			'color' => $BARRIER_COLOR,
		),
	"[barrier='wall']" => array(
			'zooms' => range(13,18),
			'template-file' => 'city_wall',
			'pattern-file' => 'wall',
			'pattern-size' => array(13=>7,18=>18),
			'pattern-spacing' => array(13=>2.3,18=>5),
			'width' => array(13 => 2,18=>4),
			'color' => $BARRIER_COLOR,
		),
	"[barrier='fence']" => array(
			'zooms' => range(14,18),
			'template-file' => 'fence',
			'pattern-file' => 'fence',
			'pattern-size' => array(14=>6,18=>14),
			'pattern-spacing' => array(14=>0,18=>0),
			'width' => array(14 => 1.2,18=>2.4),
			'color' => $BARRIER_COLOR,
		),
	"[barrier='hedge']" => array(
			'zooms' => range(14,18),
			'template-file' => 'fence',
			'pattern-file' => 'hedge',
			'pattern-size' => array(14=>6,18=>14),
			'pattern-spacing' => array(14=>0,18=>0),
			'width' => array(14 => 1.2,18=>2.4),
			'color' => darken_a($_PARK_COLOR,20),
		),
	"[barrier='ditch']" => array(
			'zooms' => range(14,18),
			'template-file' => 'fence',
			'pattern-file' => 'ditch',
			'pattern-size' => array(14=>6,18=>14),
			'pattern-spacing' => array(14=>0,18=>0),
			'width' => array(14 => 1.2,18=>2.4),
			'color' => $_WATER_COLOR,
		),
	"[barrier='bollard']" => array(
			'zooms' => range(14,18),
			'template-file' => 'fence',
			'pattern-file' => 'bollard',
			'pattern-size' => array(14=>4,18=>9),
			'pattern-spacing' => array(14=>0,18=>0),
			'width' => array(14 => 0.4,18=>0.8),
			'color' => $BARRIER_COLOR,
		),
	"[barrier='retaining_wall']" => array(
			'zooms' => range(14,18),
			'template-file' => 'cliff',
			'pattern-file' => 'retaining_wall',			
			'pattern-size' => array(14=>6,18=>14),
			'pattern-spacing' => array(14=>0,18=>0),
			'width' => array(14 => 1.2,18=>2.4),
			'color' => $BARRIER_COLOR,
		),
);


$BARRIERPOINT = array(	
	"[barrier='gate']" => array(
			'zooms' => range(15,18),
			'point-template' => 'gate',
			'point-file' => 'gate',						
			'size' => array(13 => 10,18 => 16),
			'color' => $BARRIER_COLOR,
		),
	"[barrier='lift_gate']" => array(
			'zooms' => range(15,18),
			'point-template' => 'lift_gate',
			'point-file' => 'lift_gate',						
			'size' => array(13 => 10,18 => 16),
			'color' => $BARRIER_COLOR,
		),
	"[barrier='bollard']" => array(
			'zooms' => range(15,18),
			'point-template' => 'bollard_point',
			'point-file' => 'bollard_point',						
			'size' => array(13 => 8,18 => 12),
			'color' => $BARRIER_COLOR,
		),
	"[barrier='block']" => array(
			'zooms' => range(15,18),
			'point-template' => 'block',
			'point-file' => 'block',						
			'size' => array(13 => 8,18 => 12),
			'color' => $BARRIER_COLOR,
		),	
);
