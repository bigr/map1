<?php
if ( !defined('ROOT') ) {
	define('ROOT',dirname(dirname(dirname(__FILE__))));

	set_include_path (        
		get_include_path() . PATH_SEPARATOR .
		ROOT . '/general/'
	);
}
require_once "conf/shield-peak.conf.php";

foreach ($RENDER_ZOOMS as $zoom ):
foreach (range(0,25) as $grade):

$radius = max(2,min(0.5,shield_peak_text_size($zoom,$grade)/10));
$color = linear($SHIELD_PEAK_COLOR,$zoom);

$svg = <<<EOD
<svg xmlns="http://www.w3.org/2000/svg" version="1.1">
	<circle cx="$radius" cy="$radius" r="$radius" style="fill:$color;stroke:none;" />  
</svg>
EOD;

file_put_contents(ROOT."/general/shield/~peak-$zoom-$grade.svg",$svg);

endforeach; //PRIORITIES
endforeach; //ZOOM


