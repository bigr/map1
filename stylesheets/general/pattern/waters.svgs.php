<?php
if ( !defined('ROOT') ) {
	define('ROOT',dirname(dirname(dirname(__FILE__))));

	set_include_path (        
		get_include_path() . PATH_SEPARATOR .
		ROOT . '/general/'
	);
}
require_once "conf/waters.conf.php";	


foreach ( $RENDER_ZOOMS as $zoom ) {
	foreach ( $WATERAREA as $selector => $a ) {
		if ( !empty($a['pattern-file']) && !empty($a['pattern-zooms']) && in_array($zoom,$a['pattern-zooms']) ) {
			
			$size = exponential($a['pattern-size'],$zoom);
			$margin = linear($a['pattern-margin'],$zoom);
			$opacity = linear($a['pattern-opacity'],$zoom);
			$color = empty($a['pattern-color']) ? '#000000' : linear($a['pattern-color'],$zoom);
			
			$viewbox = 256*$margin;
			$size *= $margin;
			
			require "{$a['pattern-file']}.svg.tpl";						
			
			svg2png(ROOT."/general/pattern/~{$a['pattern-file']}-$zoom.png",$svg);
		}
	}
}


