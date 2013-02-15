<?php
if ( !defined('ROOT') ) {
	define('ROOT',dirname(dirname(dirname(__FILE__))));

	set_include_path (        
		get_include_path() . PATH_SEPARATOR .
		ROOT . '/general/'
	);
}
require_once "conf/aerialway.conf.php";	


foreach ( $RENDER_ZOOMS as $zoom ) {
	foreach ( $AERIALWAY AS $selector => $a ) {
		if ( !empty($a['pattern-file']) && !empty($a['zooms']) && in_array($zoom,$a['zooms']) ) {
			
			$size = exponential($a['pattern-size'],$zoom);			
			$opacity = empty($a['opacity']) ? 1.0 : linear($a['opacity'],$zoom);
			$spacing = empty($a['pattern-spacing']) ? 30 : linear($a['pattern-spacing'],$zoom);
			$color = empty($a['color']) ? '#000000' : linear($a['color'],$zoom);
			
			$viewboxX = 256 * ($size + $spacing)/$size;
			$viewboxY = 256;
			$sizeX = $size + $spacing;
			$sizeY = $size;
			
			if ( !empty($a['template-file']) )
				require "{$a['template-file']}.svg.tpl";
			else
				require "{$a['pattern-file']}.svg.tpl";

			svg2png(ROOT."/general/pattern/~{$a['pattern-file']}-$zoom.png",$svg);
		}
	}
	
	foreach ( $AERIALWAYPOINT AS $selector => $a ) {		
		if ( !empty($a['point-file']) && !empty($a['zooms']) && in_array($zoom,$a['zooms']) ) {	
			$size = exponential($a['size'],$zoom);
			
			if ( $size < 1 ) $size = 1;
			
			$color = empty($a['color']) ? '#000000' : linear($a['color'],$zoom);

			if ( !empty($a['point-template']) )
				require "{$a['point-template']}.svg.tpl";
			else
				require "{$a['point-file']}.svg.tpl";
				
			
			svg2png(ROOT."/general/pattern/~{$a['point-file']}-$zoom.png",$svg);
		}
	}
}


