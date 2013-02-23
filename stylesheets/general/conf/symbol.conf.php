<?php
require_once "inc/utils.php";
require_once "conf/common.conf.php";
require_once "conf/waters.conf.php";

$_SYMBOL_ATTRACTIVE_COLOR = array(12 => '#aa00aa');

/**
 * Zoom x symbol look maping
 */
$SYMBOL = array(	
	"[historic='castle'][castle_type='no'][ruins='no'][grade<4.5],[historic='castle'][castle_type='stately'][ruins='no'][grade<4.5],[historic='castle'][castle_type='schloss'][ruins='no'][grade<4.5],[historic='castle'][castle_type='burg;schloss'][ruins='no'][grade<4.5]" => array(
			'zooms' => range(13,18),
			'symbol-file' => 'castle-stately',
			'symbol-size' => array(13=>10,15=>25),
		),
	"[historic='castle'][castle_type='no'][ruins='no'][grade>4.5][grade<6.0],[historic='castle'][castle_type='stately'][ruins='no'][grade>4.5][grade<6.0],[historic='castle'][castle_type='schloss'][ruins='no'][grade>4.5][grade<6.0],[historic='castle'][castle_type='burg;schloss'][ruins='no'][grade>4.5][grade<6.0]" => array(
			'zooms' => range(13,18),
			'symbol-file' => 'castle-stately',			
			'symbol-size' => array(12=>10,15=>35),
		),
	"[historic='castle'][castle_type='no'][ruins='no'][grade>6.0],[historic='castle'][castle_type='stately'][ruins='no'][grade>6.0],[historic='castle'][castle_type='schloss'][ruins='no'][grade>6.0],[historic='castle'][castle_type='burg;schloss'][ruins='no'][grade>6.0]" => array(
			'zooms' => range(12,18),
			'symbol-file' => 'castle-stately',
			'symbol-color' => $_SYMBOL_ATTRACTIVE_COLOR,
			'symbol-size' => array(12=>14,15=>40),
		),
	
	"[historic='castle'][castle_type='defensive'][grade<4.5],[historic='castle'][castle_type='burg'][grade<4.5],[historic='castle'][castle_type='fortress'][grade<4.5],[historic='castle'][castle_type='festung'][grade<4.5]" => array(
			'zooms' => range(13,18),
			'symbol-file' => 'castle-defensive',
			'symbol-size' => array(13=>11,15=>25),
		),
	"[historic='castle'][castle_type='defensive'][grade>4.5][grade<6.0],[historic='castle'][castle_type='burg'][grade>4.5][grade<6.0],[historic='castle'][castle_type='fortress'][grade>4.5][grade<6.0],[historic='castle'][castle_type='festung'][grade>4.5][grade<6.0]" => array(
			'zooms' => range(12,18),
			'symbol-file' => 'castle-defensive',			
			'symbol-size' => array(12=>11,15=>35),
		),
	"[historic='castle'][castle_type='defensive'][grade>6.0],[historic='castle'][castle_type='burg'][grade>6.0],[historic='castle'][castle_type='fortress'][grade>6.0],[historic='castle'][castle_type='festung'][grade>6.0]" => array(
			'zooms' => range(12,18),
			'symbol-file' => 'castle-defensive',
			'symbol-color' => $_SYMBOL_ATTRACTIVE_COLOR,
			'symbol-size' => array(12=>14,15=>40),
		),
		
	"[historic='ruins'][grade<4.5],[ruins!='no'][historic='castle'][grade<4.5],[ruins='castle'][grade<4.5]" => array(			
			'zooms' => range( 14,18),
			'symbol-file' => 'ruins',
			'symbol-size' => array(14=>14,15=>15),
		),
	"[historic='ruins'][grade>4.5][grade<6.0],[ruins!='no'][historic='castle'][grade>4.5][grade<6.0],[ruins='castle'][grade>4.5][grade<6.0]" => array(			
			'zooms' => range( 13,18),
			'symbol-file' => 'ruins',			
			'symbol-size' => array(13=>14,15=>25),
		),
	"[historic='ruins'][grade>6.0],[ruins!='no'][historic='castle'][grade>6.0],[ruins='castle'][grade>6.0]" => array(			
			'zooms' => range( 12,18),
			'symbol-file' => 'ruins',
			'symbol-color' => $_SYMBOL_ATTRACTIVE_COLOR,
			'symbol-size' => array(12=>14,15=>30),
		),
	
	"[building='church'][grade<4.5],[amenity='place_of_worship'][historic!='no'][historic!='monastery'][historic!='wayside_shrine'][historic!='wayside_cross'][building!='chapel'][\"place_of_worship:type\"!='chapel'][place_of_worship!='chapel'][\"place_of_worship:type\"!='monastery'][place_of_worship!='monastery'][grade<4.5]" => array(
			'zooms' => range( 13,18),
			'symbol-file' => 'church',
			'symbol-size' => array(13=>15,15=>20),
		),	
	"[building='church'][grade>4.5][grade<6.0],[amenity='place_of_worship'][historic!='no'][historic!='monastery'][historic!='wayside_shrine'][historic!='wayside_cross'][building!='chapel'][\"place_of_worship:type\"!='chapel'][place_of_worship!='chapel'][\"place_of_worship:type\"!='monastery'][place_of_worship!='monastery'][grade>4.5][grade<6.0]" => array(
			'zooms' => range( 13,18),
			'symbol-file' => 'church',			
			'symbol-size' => array(13=>17,15=>25),
		),	
	"[building='church'][grade>6.0],[amenity='place_of_worship'][historic!='no'][historic!='monastery'][historic!='wayside_shrine'][historic!='wayside_cross'][building!='chapel'][\"place_of_worship:type\"!='chapel'][place_of_worship!='chapel'][\"place_of_worship:type\"!='monastery'][place_of_worship!='monastery'][grade>6.0]" => array(
			'zooms' => range( 12,18),
			'symbol-file' => 'church',
			'symbol-color' => $_SYMBOL_ATTRACTIVE_COLOR,
			'symbol-size' => array(12=>17,15=>30),
		),	
	
		
	"[building='chapel'],[\"place_of_worship:type\"='chapel'],[place_of_worship='chapel']"=> array(			
			'zooms' => range( 13,18),
			'symbol-file' => 'chapel',
			'symbol-size' => array(13=>12,15=>16),
		),	
	"[historic='monastery'][grade<4.5],[\"place_of_worship:type\"='monastery'][grade<4.5],[place_of_worship='monastery'][grade<4.5]"=> array(			
			'zooms' => range( 13,18),
			'symbol-file' => 'monastery',
			'symbol-size' => array(13=>12,15=>20),
		),	
	"[historic='monastery'][grade>4.5][grade<6.0],[\"place_of_worship:type\"='monastery'][grade>4.5][grade<6.0],[place_of_worship='monastery'][grade>4.5][grade<6.0]"=> array(			
			'zooms' => range( 12,18),
			'symbol-file' => 'monastery',			
			'symbol-size' => array(14=>10,15=>26),
		),	
	"[historic='monastery'][grade>6.0],[\"place_of_worship:type\"='monastery'][grade>6.0],[place_of_worship='monastery'][grade>6.0]"=> array(			
			'zooms' => range( 12,18),
			'symbol-file' => 'monastery',
			'symbol-color' => $_SYMBOL_ATTRACTIVE_COLOR,
			'symbol-size' => array(14=>13,15=>32),
		),	
	
	"[historic='monument'][grade<4.5]" => array(			
			'zooms' => range( 13,18),
			'symbol-file' => 'monument',
			'symbol-size' => array(13=>12, 17 => 16),
		),
	"[historic='monument'][grade>4.5][grade<6.0]" => array(			
			'zooms' => range( 13,18),
			'symbol-file' => 'monument',
			'symbol-color' => array(12 => '#ff0000'),
			'symbol-size' => array(13=>15,15=>21),
		),
	"[historic='monument'][grade<6.0]" => array(			
			'zooms' => range( 13,18),
			'symbol-file' => 'monument',
			'symbol-color' => $_SYMBOL_ATTRACTIVE_COLOR,
			'symbol-size' => array(13=>15,15=>25),
		),
	"[historic='memorial']" => array(			
			'zooms' => range( 13,18),
			'symbol-file' => 'memorial',
			'symbol-size' => array(13=>11,17=>13),
		),
	"[historic='wayside_cross'],[amenity='place_of_worship'][historic='no'][building='no']" => array(			
			'zooms' => range( 13,18),
			'symbol-file' => 'waysidecross',
			'symbol-size' => array(13=>10,16=>12),
		),
	"[historic='wayside_shrine']" => array(			
			'zooms' => range( 13,18),
			'symbol-file' => 'waysideshrine',
			'symbol-size' => array(14=>10,16=>12),
		),
		
	"[man_made='tower'][\"tower:type\"='observation'][grade<4.5],[man_made='tower'][tourism='attraction'][grade<4.5]" => array(			
			'zooms' => range( 13,18),
			'symbol-file' => 'tower-observation',
			'symbol-size' => array(13=>14,15=>25),
		),
	"[man_made='tower'][\"tower:type\"='observation'][grade>4.5][grade<6.0],[man_made='tower'][tourism='attraction'][grade>4.5][grade<6.0]" => array(			
			'zooms' => range( 13,18),
			'symbol-file' => 'tower-observation',			
			'symbol-size' => array(13=>18,15=>35),
		),
	"[man_made='tower'][\"tower:type\"='observation'][grade>6.0],[man_made='tower'][tourism='attraction'][grade>6.0]" => array(			
			'zooms' => range( 13,18),
			'symbol-file' => 'tower-observation',
			'symbol-color' => $_SYMBOL_ATTRACTIVE_COLOR,
			'symbol-size' => array(13=>22,15=>40),
		),
	"[man_made='tower'][\"tower:type\"='communication']" => array(
			'zooms' => range( 13,18),
			'symbol-file' => 'tower-comunication',
			'symbol-size' => array(13=>12,15=>16),
		),	
	"[man_made='water_tower']" => array(
			'zooms' => range( 13,18),
			'symbol-file' => 'tower-water',
			'symbol-size' => array(13=>12,15=>16),
		),
	"[tourism='viewpoint']" => array(			
			'zooms' => range( 13,18),
			'symbol-file' => 'viewpoint',
			'symbol-color' => array('#CC0000'),
			'symbol-size' => array(13=>12,15=>16),
		),	
	"[tourism='museum'][grade<4.5]" => array(			
			'zooms' => range( 13,18),
			'symbol-file' => 'museum',			
			'symbol-size' => array(13=>12,15=>16),
		),
	"[tourism='museum'][grade>4.5][grade<6.0]" => array(			
			'zooms' => range( 13,18),
			'symbol-file' => 'museum',			
			'symbol-size' => array(12=>13,15=>20),
		),
	"[tourism='museum'][grade>6.0]" => array(			
			'zooms' => range( 13,18),
			'symbol-file' => 'museum',			
			'symbol-size' => array(13=>14,15=>24),
		),
		
	"[tourism='zoo'][grade<4.5]" => array(			
			'zooms' => range( 13,18),
			'symbol-file' => 'zoo',			
			'symbol-size' => array(13=>12,15=>16),
		),
	"[tourism='zoo'][grade>4.5][grade<6.0]" => array(			
			'zooms' => range( 13,18),
			'symbol-file' => 'zoo',
			'symbol-size' => array(13=>14,15=>21),
		),
	"[tourism='zoo'][grade>6.0]" => array(			
			'zooms' => range( 12,18),
			'symbol-file' => 'zoo',
			'symbol-color' => $_SYMBOL_ATTRACTIVE_COLOR,
			'symbol-size' => array(12=>15,15=>24),
		),
		
	"[tourism='camp_site']" => array(			
			'zooms' => range( 12,18),
			'symbol-file' => 'camp',
			'symbol-color' => array(15 => '#CC0000'),
			'symbol-size' => array(12=>14,15=>24),
		),	
	"[tourism='information'][information='guidepost']" => array(			
			'zooms' => range( 13,18),
			'symbol-file' => 'information-guidepost',
			'symbol-size' => array(13=>14,15=>18),
		),	
	"[tourism='information'][information='board']" => array(			
			'zooms' => range( 13,18),
			'symbol-file' => 'information-board',
			'symbol-size' => array(13=>14,15=>16),
		),	
	"[tourism='information'][information='map']" => array(			
			'zooms' => range( 13,18),
			'symbol-file' => 'information-map',
			'symbol-size' => array(13=>14,15=>16),
		),	
	"[tourism='information'][information='office']" => array(			
			'zooms' => range( 13,18),
			'symbol-file' => 'information-office',
			'symbol-size' => array(13=>15,15=>16),
		),	
	"[tourism='artwork']" => array(			
			'zooms' => range( 13,18),
			'symbol-file' => 'artwork-statue',
			'symbol-size' => array(13=>14,15=>16),
		),
	"[amenity='atm']" => array(			
			'zooms' => range( 14,18),
			'symbol-file' => 'atm',
			'symbol-size' => array(14=>12,17=>14),
		),
	"[amenity='bank']" => array(
			'zooms' => range( 14,18),
			'symbol-file' => 'bank',
			'symbol-size' => array(15=>16,17=>18),
		),
	"[amenity='bench']" => array(
			'zooms' => range( 15,18),
			'symbol-file' => 'bench',
			'symbol-size' => array(15=>11,17=>14),
		),
	"[natural='cave_entrance'][grade<4.5]" => array(
			'zooms' => range( 13,18),
			'symbol-file' => 'cave',
			'symbol-size' => array(13=>15,15=>20),
		),
	"[natural='cave_entrance'][grade>4.5]" => array(
			'zooms' => range( 13,18),
			'symbol-file' => 'cave',
			'symbol-color' => $_SYMBOL_ATTRACTIVE_COLOR,
			'symbol-size' => array(13=>14,15=>25),
		),
	"[amenity='doctors'],[amenity='dentist']" => array(
			'zooms' => range( 14,18),
			'symbol-file' => 'doctors',
			'symbol-color' => array(12 => '#ff0000'),
			'symbol-size' => array(14=>12,15=>16),
		),
	"[amenity='hospital']" => array(
			'zooms' => range( 14,18),
			'symbol-file' => 'hospital',
			'symbol-color' => array(12 => '#ff0000'),
			'symbol-size' => array(14=>14,17=>20),
		),
	"[amenity='clinic']" => array(
			'zooms' => range( 14,18),
			'symbol-file' => 'hospital',
			'symbol-color' => array(12 => '#ff0000'),
			'symbol-size' => array(14=>14,17=>18),
		),
	"[amenity='drinking_water']" => array(
			'zooms' => range( 13,18),
			'symbol-file' => 'drinking-water',
			'symbol-size' => array(13=>11,15=>16),
		),
	"[amenity='fuel']" => array(
			'zooms' => range( 12,18),
			'symbol-file' => 'fuel',
			'symbol-size' => array(12=>13,15=>14),
		),
	"[tourism='guest_house'],[tourism='hostel'],[tourism='motel'],[tourism='hut'],[tourism='alpine_hut']" => array(
			'zooms' => range( 13,18),
			'symbol-file' => 'guest-house',
			'symbol-size' => array(13=>10,15=>12),
		),
	"[tourism='hotel']" => array(
			'zooms' => range( 13,18),
			'symbol-file' => 'hotel',
			'symbol-size' => array(13=>11,15=>14),
		),
		
	"[man_made='hunting_stand'],[amenity='hunting_stand']" => array(
			'zooms' => range( 13,18),
			'symbol-file' => 'hunting-stand',
			'symbol-size' => array(13=>14,15=>18),
		),	
	"[amenity='parking']" => array(
			'zooms' => range( 14,18),
			'symbol-file' => 'parking',
			'symbol-color' => array(14 => '#0044DD'),
			'symbol-size' => array(14=>12,17=>14),
			'symbol-opacity' => array(14=>0.8),
		),
	"[amenity='pharmacy']" => array(
			'zooms' => range( 14,18),
			'symbol-file' => 'pharmacy',
			'symbol-color' => array(14 => '#00AA00'),
			'symbol-size' => array(14=>14,15=>14),
		),
	"[tourism='picnic_site'],[leisure='picnic_table']" => array(
			'zooms' => range( 13,18),
			'symbol-file' => 'picnic',			
			'symbol-size' => array(13=>12,15=>18),
		),
	"[amenity='post_box']" => array(
			'zooms' => range( 14,18),
			'symbol-file' => 'postbox',			
			'symbol-size' => array(14=>10,15=>12),
		),
	"[amenity='post_office']" => array(
			'zooms' => range( 13,18),
			'symbol-file' => 'postoffice',			
			'symbol-size' => array(13=>14,15=>18),
		),
	"[amenity='pub'],[amenity='bar']" => array(
			'zooms' => range( 15,18),
			'symbol-file' => 'pub',			
			'symbol-size' => array(15=>14),
		),
	"[amenity='restaurant']" => array(
			'zooms' => range( 16,18),
			'symbol-file' => 'restaurant',			
			'symbol-size' => array(16=>18),
		),
	"[amenity='shelter']" => array(
			'zooms' => range( 14,18),
			'symbol-file' => 'shelter',			
			'symbol-size' => array(14=>16,15=>18),
		),
	"[natural='spring']" => array(
			'zooms' => range( 13,18),
			'symbol-file' => 'spring',		
			'symbol-color' => $_WATER_COLOR,	
			'symbol-size' => array(13=>14,15 => 18),
		),
	"[amenity='theatre'][grade<4.5]" => array(
			'zooms' => range( 13,18),
			'symbol-file' => 'theatre',		
			'symbol-size' => array(13 => 14,17 => 20),
		),
	"[amenity='theatre'][grade>4.5][grade<6.0]" => array(
			'zooms' => range( 13,18),
			'symbol-file' => 'theatre',	
			'symbol-size' => array(13=>15,17 => 28),
		),
	"[amenity='theatre'][grade>6.0]" => array(
			'zooms' => range( 13,18),
			'symbol-file' => 'theatre',	
			'symbol-color' => $_SYMBOL_ATTRACTIVE_COLOR,	
			'symbol-size' => array(13=>16,17 => 32),
		),
	"[man_made='watermill']" => array(
			'zooms' => range( 13,18),
			'symbol-file' => 'watermill',		
			'symbol-size' => array(13=>14,15 => 20),
		),
	"[man_made='water_well']" => array(
			'zooms' => range( 15,18),
			'symbol-file' => 'waterwell',		
			'symbol-size' => array(15=>12),
		),
	"[man_made='windmill']" => array(
			'zooms' => range( 13,18),
			'symbol-file' => 'windmill',		
			'symbol-size' => array(13=>14,15 => 20),
		),	
	"[amenity='fountain'][grade<6.0]" => array(
			'zooms' => range( 14,18),
			'symbol-file' => 'fontain',		
			'symbol-size' => array(14=>16,15 => 18),
		),
	"[amenity='fountain'][grade>6.0]" => array(
			'zooms' => range( 13,18),
			'symbol-file' => 'fontain',		
			'symbol-color' => $_SYMBOL_ATTRACTIVE_COLOR,
			'symbol-size' => array(13=>22,15 => 24),
		),				
);
