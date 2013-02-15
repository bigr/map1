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
foreach (array_keys($ROAD_REF_PRIORITIES[$zoom]) as $grade):
foreach (range(1,8) as $length):

$height = exponential($ROAD_REF_SHIELD_HEIGHT[$grade],$zoom);
$width = $length * exponential($ROAD_REF_SHIELD_LETTER_WIDTH[$grade],$zoom) + exponential($ROAD_REF_SHIELD_PADDING_WIDTH[$grade],$zoom);
$fill = linear($ROAD_REF_SHIELD_FILL[$grade],$zoom);
$bordercolor = linear($ROAD_REF_SHIELD_BORDER_COLOR[$grade],$zoom);
$borderwidth = exponential($ROAD_REF_SHIELD_BORDER_WIDTH[$grade],$zoom);
if (  is_nan($borderwidth) ) $borderwidth = 0;
$margin = exponential($ROAD_REF_SHIELD_MARGIN[$grade],$zoom);
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

file_put_contents(ROOT."/general/shield/~highway-ref-$zoom-$grade-$length.svg",$svg);

endforeach; //LENGTHS
endforeach; //GRADES
endforeach; //ZOOM


