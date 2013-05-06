<?php
require_once "inc/utils.php";

$TILE = getenv('TILE');
$UTFGRID = getenv('UTFGRID');

/**
 * Which zooms should be rendered to render all use range(0,18)
 */
$RENDER_ZOOMS = range(8,16);

/**
 * Which layers should be rendered to render all use range(-5,5)
 */  
$RENDER_LAYERS = empty($UTFGRID)?range(-2,2):array(0);

/**
 * Which text priorities should be rendered bigger means less important,
 * to render all use (0,3)
 */
$RENDER_TEXT_PRIORITIES = range(0,4);


/////////////////////////////////
/////     RENDER ITEMS      /////
/////////////////////////////////




$RENDER_LAYER = getenv('RENDER_LAYER');
if ( !empty($RENDER_LAYER) ) {
	$RENDER_LANDCOVER  = $RENDER_ACCESSAREA = $RENDER_COUNTRYFILL = $RENDER_BUILDING = $RENDER_BOUNDARY = $RENDER_WAY = $RENDER_ROUTE = $RENDER_CONTOUR = $RENDER_FISHNET = $RENDER_TEXT = $RENDER_COUNTRYTEXT = $RENDER_GRIDINFO = false;
	foreach ( explode(',',strtoupper($RENDER_LAYER)) as $LAYER ) {
		eval("\$RENDER_$LAYER = true;");
	}
}
else {
	
/**
 * Enable/Disable landcover (include residentialcover hack and placescover) rendering
 */
$RENDER_LANDCOVER = true;


$RENDER_ACCESSAREA= true;

/**
 * Enable/Disable countryfill rendering
 */
$RENDER_COUNTRYFILL = true;

/**
 * Enable/Disable buildings rendering
 */
$RENDER_BUILDING = true;

/**
 * Enable/Disable boundaries rendering
 */
$RENDER_BOUNDARY = true;

/**
 * Enable/Disable *way rendering
 */
$RENDER_WAY = true;

/**
 * Enable/Disable routes rendering
 */
$RENDER_ROUTE = true;

/**
 * Enable/Disable contours rendering
 */
$RENDER_CONTOUR = true;

/**
 * Enable/Disable fishnet rendering
 */
$RENDER_FISHNET = true;


/**
 * Enable/Disable text/shield rendering
 */
$RENDER_TEXT = true;

/**
 * Enable/Disable countrytext rendering
 */
$RENDER_COUNTRYTEXT = true;


/**
 * Enable/Disable render for utfgrid
 */
$RENDER_GRIDINFO = true;

}
unset($RENDER_LAYER);


//
// LANDCOVER RENDERING SUBITEMS
//

/**
 * Enable/Disable coastline rendering
 */
$RENDER_COASTLINE = true;

/**
 * Enable/Disable residential cover hack rendering
 */
$RENDER_RESIDENTIALCOVER_HACK = true;

/**
 * Enable/Disable places cover rendering
 */
$RENDER_PLACESCOVER = true;

/**
 * Enable/Disable landcover rendering
 */
$RENDER_STD_LANDCOVER = true;

/**
 * Enable/Disable line landcover rendering
 */
$RENDER_LINE_LANDCOVER = true;

/**
* Enable/Disable point landcover rendering
*/
$RENDER_POINT_LANDCOVER = true;

//
// WAY RENDERING SUBITEMS
//


// HIGHWAYS

/**
 * Enable/Disable highway rendering
 */
$RENDER_HIGHWAY = true;


// WATERS

/**
 * Enable/Disable waterway and waterarea rendering
 */
$RENDER_WATERS = true;

/**
 * Enable/Disable waterway rendering
 */
$RENDER_WATERWAY = true;

/**
 * Enable/Disable waterarea rendering
 */
$RENDER_WATERAREA = true;


/**
 * Enable/Disable aeroway rendering
 */
$RENDER_AEROWAY = true;

/**
 * Enable/Disable pisteway rendering
 */
$RENDER_PISTEWAY = true;

// RAILWAYS

/**
 * Enable/Disable railway rendering
 */
$RENDER_RAILWAY = true;

/**
 * Enable/Disable barrier rendering
 */
$RENDER_BARRIER = true;


/**
 * Enable/Disable power rendering
 */
$RENDER_POWER = true;

/**
 * Enable/Disable aerialway rendering
 */
$RENDER_AERIALWAY = true;


//
// TEXT RENDERING SUBITEMS
//

// HIGHWAYS

/**
 * Enable/Disable highway text/shield rendering
 */
$RENDER_TEXT_HIGHWAY = true;

/**
 * Enable/Disable symbol rendering
 */
$RENDER_SYMBOL = true;


/**
 * Enable/Disable symbol text/shield rendering
 */
$RENDER_TEXT_SYMBOL = true;

/**
 * Enable/Disable route text/shield rendering
 */
$RENDER_TEXT_ROUTE = true;

/**
 * Enable/Disable place text rendering
 */
$RENDER_TEXT_PLACE = true;

/**
 * Enable/Disable waters text rendering
 */
$RENDER_TEXT_WATERS = true;


/**
 * Enable/Disable landcover text rendering
 */
$RENDER_TEXT_LANDCOVER = true;

/**
 * Enable/Disable building text rendering
 */
$RENDER_TEXT_BUILDING = true;


/**
 * Enable/Disable boundary text rendering
 */
$RENDER_TEXT_BOUNDARY = true;

/**
 * Enable/Disable peak shield rendering
 */
$RENDER_SHIELD_PEAK = true;

/**
 * Enable/Disable contour text rendering
 */
$RENDER_TEXT_CONTOUR = true;


/**
 * Minimal rendered area in given zoom in pixels^2
 */
$_MINIMAL_AREA = array(5 => 80, 9 => 90, 13 => 0);

$_CONTOUR_COLOR = array(12=>'#593A0D');

$__zooms = getenv('ZOOMS');
if ( !empty($__zooms) ) {
	$RENDER_ZOOMS = array_map(function ($x) {return intval($x);},explode(',',$__zooms));
}
unset($__zooms);


