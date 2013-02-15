<?php
require_once "conf/text.conf.php";
require_once "conf/symbol.conf.php";
$TEXT_SYMBOL = array(
	"[tourism='information'][information='guidepost']" => array(
			'zooms' => array(13 => 4, 14 => 3, 15 => 2,16 => 2, 17 => 2, 18 => 2),
			'size' => array(13 => 11,17=>20),
			'color' => array(15 => '#000000'),
		),
	"[grade>5]" => array(
			'zooms' => array(11 => 3, 12 => 2, 13 => 1, 14 => 0, 15 => 0,16 => 0, 17 => 0, 18 => 0),
			'size' => array(11 => 14, 17 => 28),
			'color' => array(15 => '#000000'),
			'halo-color' => array(15 => '#ffbbff'),
		),
	"[grade>5][grade>4]" => array(
			'zooms' => array(12 => 3, 13 => 2, 14 => 1, 15 => 0,16 => 0, 17 => 0, 18 => 0),
			'size' => array(12 => 14, 17 => 27),
			'color' => array(15 => '#000000'),
			'halo-color' => array(15 => '#ffbbff'),
		),
	"[grade<4][grade>3]" => array(
			'zooms' => array(13 => 3, 14 => 2, 15 => 1,16 => 0, 17 => 0, 18 => 0),
			'size' => array(13 => 13, 17 => 21),
			'color' => array(15 => '#000000'),
			'halo-color' => array(15 => '#ffbbff'),
		),
	"[grade<3][grade>2.0]" => array(
			'zooms' => array(14 => 3, 15 => 2,16 => 1, 17 => 0, 18 => 0),
			'size' => array(14 => 13, 17 => 18),
			'color' => array(15 => '#000000'),
		),
	"[grade<2.0][grade>0]" => array(
			'zooms' => array(15 => 3, 16 => 2, 17 => 1, 18 => 0),
			'size' => array(15 => 13, 17 => 17),
			'color' => array(15 => '#000000'),
		),
	"[historic='castle'][grade<2],[historic='ruins'][grade<2], [historic='monastery'][grade<2],[\"place_of_worship:type\"='monastery'][grade<2],[place_of_worship='monastery'][grade<2],[historic='monument'][grade<2],[man_made='tower'][\"tower:type\"='communication'][grade<2],[tourism='zoo'][grade<2],[natural='cave_entrance'][grade<2],[amenity='theatre'][grade<2],[tourism='museum'][grade<2]" => array(
			'zooms' => array(16 => 3, 17 => 2, 18 => 0),
			'size' => array(16 => 13, 17 => 16),
			'color' => array(15 => '#000000'),
		),
	"[tourism='hotel'], [tourism='hostel'], [tourism='motel'], [tourism='guest_house']" => array(
			'zooms' => array(13 => 5, 14 => 2, 15 => 1,16 => 1, 17 => 1, 18 => 1),
			'size' => array(13 => 12,17=>18),
			'color' => array(15 => '#000000'),
		),
	"[amenity='restaurant'], [amenity='fast_food'], [amenity='cafe'], [amenity='pub'], [amenity='bar']" => array(
			'zooms' => array(16 => 3, 17 => 1, 18 => 1),
			'size' => array(16 => 12,17=>18),
			'color' => array(16 => '#000000'),
		),
	"[amenity='hospital'], [amenity='university'], [amenity='school'], [amenity='library']" => array(
			'zooms' => array(14 => 3, 15 => 2, 16 => 1, 17 => 1, 18 => 1),
			'size' => array(15 => 12,17=>20),
			'color' => array(16 => '#000000'),
		),
	"[historic='memorial']" => array(
			'zooms' => array(14 => 3, 15 => 2, 16 => 1, 17 => 1, 18 => 1),
			'size' => array(15 => 12,17=>17),
			'color' => array(16 => '#000000'),
		),
	"[historic='monument']" => array(
			'zooms' => array(13 => 4, 14 => 3, 15 => 2, 16 => 1, 17 => 1, 18 => 1),
			'size' => array(13 => 12,17=>18),
			'color' => array(16 => '#000000'),
		),
	"[tourism='zoo']" => array(
			'zooms' => array(13 => 4, 14 => 3, 15 => 2, 16 => 1, 17 => 1, 18 => 1),
			'size' => array(13 => 12,17=>18),
			'color' => array(16 => '#000000'),
		),
	"[tourism='camp_site']" => array(
			'zooms' => array(13 => 4, 14 => 3, 15 => 2, 16 => 1, 17 => 1, 18 => 1),
			'size' => array(13 => 12,17=>18),
			'color' => array(16 => '#000000'),
		),
	"[amenity='bank']" => array(
			'zooms' => array(13 => 4, 14 => 3, 15 => 2, 16 => 1, 17 => 1, 18 => 1),
			'size' => array(13 => 12,17=>18),
			'color' => array(16 => '#000000'),
		),
);
