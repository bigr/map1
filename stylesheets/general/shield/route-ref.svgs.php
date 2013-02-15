<?php
if ( !defined('ROOT') ) {
	define('ROOT',dirname(dirname(dirname(__FILE__))));

	set_include_path (        
		get_include_path() . PATH_SEPARATOR .
		ROOT . '/general/'
	);
}	
require_once "conf/text-route.conf.php";

foreach ($RENDER_ZOOMS as $zoom ):
foreach (array_keys($ROUTE_REF_PRIORITIES[$zoom]) as $grade):
foreach (range(1,8) as $length):

$height = exponential($ROUTE_REF_SHIELD_HEIGHT[$grade],$zoom);
$width = $length * exponential($ROUTE_REF_SHIELD_LETTER_WIDTH[$grade],$zoom) + exponential($ROUTE_REF_SHIELD_PADDING_WIDTH[$grade],$zoom);
$fill = linear($ROUTE_REF_SHIELD_FILL[$grade],$zoom);

$svg = <<<EOD
<svg xmlns="http://www.w3.org/2000/svg" version="1.1">
  <rect x="0" y="0" width="$width" height="$height" style="fill:$fill;stroke:none;" />  
</svg>
EOD;

file_put_contents(ROOT."/general/shield/~route-ref-$zoom-$grade-$length.svg",$svg);

endforeach; //LENGTHS
endforeach; //GRADES
endforeach; //ZOOM


