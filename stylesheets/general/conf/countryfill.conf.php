<?php
require_once "inc/utils.php";
require_once "conf/common.conf.php";
require_once "conf/text.conf.php";


define('COUNTRY_CZ',  -51684);
define('COUNTRY_SK',  -14296);
define('COUNTRY_AT',  -16239);
define('COUNTRY_PL',  -49715);
define('COUNTRY_HU',  -21335);
define('COUNTRY_SL', -218657);
define('COUNTRY_HR', -214885);
define('COUNTRY_NO', -1059668);
define('COUNTRY_SE',-52822);// | Sverige
define('COUNTRY_FI',-54224);// | Suomi
define('COUNTRY_UA',-60199);// | Україна
define('COUNTRY_TR',-174737);// | Türkiye
define('COUNTRY_FR',-1403916);// | France métropolitaine
define('COUNTRY_GB',-62149);// | United Kingdom
define('COUNTRY_DE',-51477);// | Deutschland
define('COUNTRY_IS',-299133);// | Ísland
define('COUNTRY_IT',-365331);// | Italia
define('COUNTRY_BY',-59065);// | Беларусь
define('COUNTRY_GR',-192307);// | Ελλάδα
define('COUNTRY_RO',-90689);// | România
define('COUNTRY_IE',-62273);// | Ireland
define('COUNTRY_DK',-50046);// | Danmark
define('COUNTRY_EE',-79510);// | Eesti
define('COUNTRY_LV',-72594);// | Latvija
define('COUNTRY_BG',-186382);// | България
define('COUNTRY_LT',-72596);// | Lietuva
define('COUNTRY_PT',-295480);// | Portugal
define('COUNTRY_RS',-1741311);// | Србија
define('COUNTRY_NL',-2323309);// | Nederland
define('COUNTRY_BA',-214908);// | Bosna i Hercegovina
define('COUNTRY_CH',-51701);// | Schweiz
define('COUNTRY_BE',-52411);// | België - Belgique - Belgien
define('COUNTRY_MD',-58974);// | Moldova
define('COUNTRY_AL',-53292);// | Shqipëria
define('COUNTRY_RU',-60189);// | Российская Федерация
define('COUNTRY_MK',-53293 );//| Македонија
define('COUNTRY_ES',-1311341);// | España
define('COUNTRY_ME',-53296);// | Crna Gora
define('COUNTRY_XX',-2088990);// | Косово и Метохија
define('COUNTRY_MT',-365307);// | Malta
define('COUNTRY_LU',-2171347);// | Luxembourg


/**
 * Countryfill zoom visibility maping
 */
$COUNTRYFILL_ZOOMS = range(5,9);


/**
 * Countryfill colors
 */
$COUNTRYFILL_COLORS = array(
	COUNTRY_CZ => '#3300bb',
	COUNTRY_SK => '#6600aa',
	COUNTRY_AT => '#dd0099',
	COUNTRY_PL => '#ee0000',
	COUNTRY_HU => '#33EE44',
	COUNTRY_SL => '#aabb00',
	COUNTRY_HR => '#66cccc',
	COUNTRY_DE => '#BB7700',
	COUNTRY_FR => '#0033bb',
	COUNTRY_IT => '#4499ff',
	COUNTRY_CH => '#aa0000',
	COUNTRY_NL => '#ff4400',
	COUNTRY_BE => '#88BB22',
	COUNTRY_LU => '#00AAFF',
	COUNTRY_RO => '#0011FF',
	COUNTRY_BG => '#00CC66',
	COUNTRY_GR => '#0088DD',
	COUNTRY_BA => '#FFAA33',
	COUNTRY_RS => '#EE0033',
	COUNTRY_ME => '#66EE00',
	COUNTRY_ES => '#CC2200',
	COUNTRY_PT => '#009000',
	COUNTRY_GB => '#7700AA',
	COUNTRY_DK => '#FF0055',
	COUNTRY_NO => '#00EEAA',
	COUNTRY_SE => '#FFDD00',
	COUNTRY_FI => '#22BBDD',
	COUNTRY_IE => '#77DD00',
	COUNTRY_MD => '#CC8822',	
	COUNTRY_AL => '#990000',
	COUNTRY_XX => '#EE77FF',
	COUNTRY_MK => '#DDAA00',
	COUNTRY_UA => '#DDCC33',
	COUNTRY_BY => '#33EE00',
	COUNTRY_TR => '#EE5500',
	COUNTRY_EE => '#0000CC',
	COUNTRY_LV => '#BB0000',
	COUNTRY_LT => '#00DD66',
	COUNTRY_RU => '#ff3355'
);       


/**
 * Countryfill opacity
 */
$COUNTRYFILL_OPACITY = array(5=>0.25, 6 => 0.15, 7 => 0.09, 8 => 0.04,9 => 0);
