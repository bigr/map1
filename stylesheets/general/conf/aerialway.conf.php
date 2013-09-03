<?php
require_once "inc/utils.php";
require_once "common.conf.php";

$_AERIALWAY_COLOR = array(15 => '#333333');

/**
 * Zoom x aerialway look maping
 */
$AERIALWAY = array(	
	"[aerialway='cable_car']" => array(
			'zooms' => range(13,18),
			'pattern-file' => 'cable_car',
			'pattern-size' => array(13=>14,18=>32),
			'pattern-spacing' => array(13 => 20, 15=>70),
			'width' => array(14 => 1.0),
			'color' => $_AERIALWAY_COLOR,
		),
	"[aerialway='gondola']" => array(
			'zooms' => range(13,18),
			'pattern-file' => 'gondola',
			'pattern-size' => array(13=>14,18=>32),
			'pattern-spacing' => array(13 => 20, 15=>70),
			'width' => array(14 => 1.0),
			'color' => $_AERIALWAY_COLOR,
		),
	"[aerialway='chair_lift']" => array(
			'zooms' => range(13,18),
			'pattern-file' => 'chair_lift',
			'pattern-size' => array(14=>16,18=>32),
			'pattern-spacing' => array(13=>15,15=>50),
			'width' => array(14 => 1.0),
			'color' => $_AERIALWAY_COLOR,
		),
	"[aerialway='drag_lift'][\"piste:lift\"!='t-bar'][\"piste:lift\"!='j-bar'],[aerialway='platter'],[aerialway='rope_tow'],[aerialway='magic_carpet']" => array(
			'zooms' => range(13,18),
			'pattern-file' => 'drag_lift',
			'pattern-size' => array(15=>7,18=>12),
			'pattern-spacing' => array(13 => 8,15=>15),
			'width' => array(15 => 1.0),
			'color' => $_AERIALWAY_COLOR,
		),
	"[aerialway='t-bar'],[aerialway='drag_lift'][\"piste:lift\"='t-bar']" => array(
			'zooms' => range(13,18),
			'pattern-file' => 't-bar',
			'pattern-size' => array(15=>7,18=>12),
			'pattern-spacing' => array(13 => 15,15=>50),
			'width' => array(15 => 1.0),
			'color' => $_AERIALWAY_COLOR,
		),
	"[aerialway='j-bar'],[aerialway='drag_lift'][\"piste:lift\"='j-bar']" => array(
			'zooms' => range(13,18),
			'pattern-file' => 'j-bar',
			'pattern-size' => array(15=>7,18=>12),
			'pattern-spacing' => array(13 => 15, 15=>50),
			'width' => array(15 => 1.0),
			'color' => $_AERIALWAY_COLOR,
		),
);

$AERIALWAYPOINT = array(	
	"[aerialway='pylon']" => array(
			'zooms' => range(14,18),
			'point-template' => 'power-pole',
			'point-file' => 'aerial-pylon',						
			'size' => array(15 => 6,18 => 12),
			'color' => $_AERIALWAY_COLOR,
		),	
);

$AERIALWAY_TEXT_ZOOMS = array(
	13 => 3, 14 => 2, 15 => 2, 16 =>1, 17 => 1, 18 => 1
);

$AERIALWAY_TEXT_SIZE = array(13 => 6, 18 => 15);
