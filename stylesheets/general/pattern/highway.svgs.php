<?php
if ( !defined('ROOT') ) {
	define('ROOT',dirname(dirname(dirname(__FILE__))));

	set_include_path (        
		get_include_path() . PATH_SEPARATOR .
		ROOT . '/general/'
	);
}
require_once "conf/highway.conf.php";	


foreach ( $RENDER_ZOOMS as $zoom ) {
	foreach ( $HIGHWAYPOINT AS $selector => $a ) {
		if ( !empty($a['point-file']) && !empty($a['zooms']) && in_array($zoom,$a['zooms']) ) {
			
			$size = exponential($a['size'],$zoom);
			$color = empty($a['color']) ? '#000000' : linear($a['color'],$zoom);

			if ( !empty($a['point-template']) )
				require "{$a['point-template']}.svg.tpl";
			else
				require "{$a['point-file']}.svg.tpl";
			svg2png(ROOT."/general/pattern/~{$a['point-file']}-$zoom.png",$svg);
		}
	}
	
	if ( in_array($zoom,$HIGHWAY_JUNCTION_ZOOMS) ) {			
			$size = exponential($HIGHWAY_JUNCTION_SIZE,$zoom)*2;
			$color = linear($HIGHWAY_JUNCTION_COLOR,$zoom);
			$opacity = 0.6;			
			require "$HIGHWAY_JUNCTION_FILE.svg.tpl";
			svg2png(ROOT."/general/pattern/~$HIGHWAY_JUNCTION_FILE-$zoom.png",$svg);
	}
}


