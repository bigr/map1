<?php
require_once "inc/utils.php";
require_once "common.conf.php";


$_PISTE_OPACITY = array(13 => 0.2, 17 => 0.4);
$_PISTE_PATTERN_OPACITY = array(13 => 0.6, 15 => 0.8);

/**
 * Zoom x pisteway look maping
 */
$PISTEWAY = array(
	"[pisteway='downhill'][difficulty='no']" => array(
			'zooms' => range(13,18),
			'pattern-file' => 'piste',
			'pattern-file-png' => 'piste',
			'pattern-size' => array(13=>6,18=>18),
			'pattern-spacing' => array(13=>8,18=>24),
			'opacity' => $_PISTE_OPACITY,
			'width' => array(13 => 2,18=>6),
			'color' => array(13 => '#777777'),
	),
	"[pisteway='downhill'][difficulty='novice']" => array(
			'zooms' => range(13,18),
			'pattern-file' => 'piste',
			'pattern-file-png' => 'piste-novice',
			'pattern-size' => array(13=>6,18=>18),
			'pattern-spacing' => array(13=>12,18=>36),
			'opacity' => $_PISTE_OPACITY,
			'width' => array(13 => 2,18=>6),
			'color' => array(13 => '#00ff00'),
	),
	"[pisteway='downhill'][difficulty='easy']" => array(
			'zooms' => range(13,18),
			'pattern-file' => 'piste',
			'pattern-file-png' => 'piste-easy',
			'pattern-size' => array(13=>6,18=>18),
			'pattern-spacing' => array(13=>10,18=>30),
			'opacity' => $_PISTE_OPACITY,
			'width' => array(13 => 2,18=>6),
			'color' => array(13 => '#0000ff'),
	),
	"[pisteway='downhill'][difficulty='intermediate']" => array(
			'zooms' => range(13,18),
			'pattern-file' => 'piste',
			'pattern-file-png' => 'piste-intermediate',
			'pattern-size' => array(13=>6,18=>18),			
			'pattern-spacing' => array(13=>8,18=>24),
			'opacity' => $_PISTE_OPACITY,
			'width' => array(13 => 2,18=>6),
			'color' => array(13 => '#ff0000'),
	),
	"[pisteway='downhill'][difficulty='advanced']" => array(
			'zooms' => range(13,18),
			'pattern-file' => 'piste',
			'pattern-file-png' => 'piste-advanced',
			'pattern-size' => array(13=>6,18=>18),			
			'pattern-spacing' => array(13=>6,18=>18),
			'opacity' => $_PISTE_OPACITY,
			'width' => array(13 => 2,18=>6),
			'color' => array(13 => '#000000'),
	),
	"[pisteway='downhill'][difficulty='expert']" => array(
			'zooms' => range(13,18),
			'pattern-file' => 'piste',
			'pattern-file-png' => 'piste-expert',
			'pattern-size' => array(13=>6,18=>18),			
			'pattern-spacing' => array(13=>4,18=>12),
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
