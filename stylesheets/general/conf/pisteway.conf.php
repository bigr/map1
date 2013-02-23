<?php
require_once "inc/utils.php";
require_once "common.conf.php";


$_PISTE_OPACITY = array(13 => 0.15, 15 => 0.2);
$_PISTE_PATTERN_OPACITY = array(13 => 0.6, 15 => 0.8);

/**
 * Zoom x pisteway look maping
 */
$PISTEWAY = array(
	"[pisteway='downhill'][difficulty='no']" => array(
			'zooms' => range(13,18),
			'pattern-file' => 'piste',
			'pattern-size' => array(13=>12,18=>32),
			'pattern-spacing' => array(14=>10),
			'pattern-color' => array(13 => '#777777'),
			'pattern-opacity' => $_PISTE_PATTERN_OPACITY,
			'opacity' => $_PISTE_OPACITY,
			'width' => array(13 => 14,18=>32),
			'color' => array(13 => '#777777'),
	),
	"[pisteway='downhill'][difficulty='novice']" => array(
			'zooms' => range(13,18),
			'pattern-file' => 'piste',
			'pattern-size' => array(13=>12,18=>32),
			'pattern-spacing' => array(14=>10),
			'pattern-color' => array(13 => '#00ff00'),
			'pattern-opacity' => $_PISTE_PATTERN_OPACITY,
			'opacity' => $_PISTE_OPACITY,
			'width' => array(13 => 14,18=>32),
			'color' => array(13 => '#00ff00'),
	),
	"[pisteway='downhill'][difficulty='easy']" => array(
			'zooms' => range(13,18),
			'pattern-file' => 'piste',
			'pattern-size' => array(13=>12,18=>32),
			'pattern-spacing' => array(14=>10),
			'opacity' => $_PISTE_OPACITY,
			'width' => array(13 => 14,18=>32),
			'color' => array(13 => '#0000ff'),
	),
	"[pisteway='downhill'][difficulty='intermediate']" => array(
			'zooms' => range(13,18),
			'pattern-file' => 'piste',
			'pattern-size' => array(13=>12,18=>32),
			'pattern-color' => array(13 => '#ff0000'),
			'pattern-spacing' => array(14=>10),
			'pattern-opacity' => $_PISTE_PATTERN_OPACITY,
			'opacity' => $_PISTE_OPACITY,
			'width' => array(13 => 14,18=>32),
			'color' => array(13 => '#ff0000'),
	),
	"[pisteway='downhill'][difficulty='advanced']" => array(
			'zooms' => range(13,18),
			'pattern-file' => 'piste',
			'pattern-size' => array(13=>12,18=>32),
			'pattern-color' => array(13 => '#000000'),
			'pattern-spacing' => array(14=>10),
			'pattern-opacity' => $_PISTE_PATTERN_OPACITY,
			'opacity' => $_PISTE_OPACITY,
			'width' => array(13 => 14,18=>32),
			'color' => array(13 => '#000000'),
	),
	"[pisteway='downhill'][difficulty='expert']" => array(
			'zooms' => range(13,18),
			'pattern-file' => 'piste',
			'pattern-size' => array(13=>12,18=>32),
			'pattern-color' => array(13 => '#550000'),
			'pattern-spacing' => array(14=>10),
			'pattern-opacity' => $_PISTE_PATTERN_OPACITY,
			'opacity' => $_PISTE_OPACITY,
			'width' => array(13 => 14,18=>32),
			'color' => array(13 => '#550000'),
	),
);

/**
* Zoom x pistearea look maping
*/
$PISTEAREA = array(
	"[pisteway='downhill'][difficulty='no']" => array(
			'zooms' => range(13,18),
			'pattern-file' => 'piste',
			'pattern-size' => array(13=>14,18=>32),
			'pattern-spacing' => array(14=>70),
			'width' => array(13 => 14,18=>32),
			'color' => array('#777777'),
	),
	"[pisteway='downhill'][difficulty='novice']" => array(
		'zooms' => range(13,18),
		'pattern-file' => 'piste_novice',
		'pattern-size' => array(13=>14,18=>32),
		'pattern-spacing' => array(14=>70),
		'width' => array(13 => 14,18=>32),
		'color' => array('#00ff00'),
	),
	"[pisteway='downhill'][difficulty='easy']" => array(
			'zooms' => range(13,18),
			'pattern-file' => 'piste_easy',
			'pattern-size' => array(13=>14,18=>32),
			'pattern-spacing' => array(14=>70),
			'width' => array(13 => 14,18=>32),
			'color' => array('#0000ff'),
	),
	"[pisteway='downhill'][difficulty='intermediate']" => array(
			'zooms' => range(13,18),
			'pattern-file' => 'piste_intermediate',
			'pattern-size' => array(13=>14,18=>32),
			'pattern-spacing' => array(14=>70),
			'width' => array(13 => 14,18=>32),
			'color' => array('#ff0000'),
	),
	"[pisteway='downhill'][difficulty='advanced']" => array(
			'zooms' => range(13,18),
			'pattern-file' => 'piste_advanced',
			'pattern-size' => array(13=>14,18=>32),
			'pattern-spacing' => array(14=>70),
			'width' => array(13 => 14,18=>32),
			'color' => array('#000000'),
	),
	"[pisteway='downhill'][difficulty='expert']" => array(
			'zooms' => range(13,18),
			'pattern-file' => 'piste_expert',
			'pattern-size' => array(13=>14,18=>32),
			'pattern-spacing' => array(14=>70),
			'width' => array(13 => 14,18=>32),
			'color' => array('#550000'),
	),
);
