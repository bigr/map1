<?php
if ( !defined('ROOT') ) {
	define('ROOT',dirname(dirname(dirname(__FILE__))));

	set_include_path (        
		get_include_path() . PATH_SEPARATOR .
		ROOT . '/general/'
	);
}	
require_once "conf/text-highway.conf.php";

foreach ($RENDER_ZOOMS as $zoom ):
foreach (range(1,8) as $length):

$height = exponential($ROAD_INTREF_SHIELD_HEIGHT,$zoom);
$width = $length * exponential($ROAD_INTREF_SHIELD_LETTER_WIDTH,$zoom) + exponential($ROAD_INTREF_SHIELD_PADDING_WIDTH,$zoom);
$fill = linear($ROAD_INTREF_SHIELD_FILL,$zoom);
$bordercolor = linear($ROAD_INTREF_SHIELD_BORDER_COLOR,$zoom);
$borderwidth = exponential($ROAD_INTREF_SHIELD_BORDER_WIDTH,$zoom);
if (  is_nan($borderwidth) ) $borderwidth = 0;
$margin = exponential($ROAD_INTREF_SHIELD_MARGIN,$zoom);
if (  is_nan($margin) ) $margin = 0;
$width2 = $width - 2*$margin - $borderwidth;
$height2 = $height - 2*$margin - $borderwidth;
$shift = $margin + $borderwidth/2;

$svg = <<<EOD
<svg xmlns="http://www.w3.org/2000/svg" version="1.1">
  <rect x="0" y="0" width="$width" height="$height" style="fill:$fill;stroke:none;" />
  <rect x="$shift" y="$shift" width="$width2" height="$height2" style="fill:none;stroke-width:$borderwidth;stroke:$bordercolor" />  
</svg>
EOD;

file_put_contents(ROOT."/general/shield/~highway-intref-$zoom-$length.svg",$svg);
endforeach; //LENGTHS

endforeach; //ZOOM


