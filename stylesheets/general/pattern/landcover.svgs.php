<?php
if ( !defined('ROOT') ) {
	define('ROOT',dirname(dirname(dirname(__FILE__))));

	set_include_path (        
		get_include_path() . PATH_SEPARATOR .
		ROOT . '/general/'
	);
}
require_once "conf/landcover.conf.php";	


foreach ( $RENDER_ZOOMS as $zoom ) {
	foreach ( $LANDCOVER AS $selector => $a ) {
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
	
	foreach ( $LANDCOVER_LINE AS $selector => $a ) {
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
	
			file_put_contents(ROOT."/general/pattern/~{$a['pattern-file']}-$zoom.svg",$svg);
	
			svg2png(ROOT."/general/pattern/~{$a['pattern-file']}-$zoom.png",$svg);
		}
	}
	
	foreach ( $PLACESCOVER as $grade => $a ) {
		try {
			$size = exponential($a['size'],$zoom);
			$color = linear($a['color'],$zoom);

			if ( $size < 1 ) $size = 1;
					
			require "place.svg.tpl";
			
			svg2png(ROOT."/general/pattern/~place-$zoom-$grade.png",$svg);
		} catch( Exception $ex ) {
			echo "Error while makeing placecover '~place-$zoom-$grade.png', color = '$color', size = '$size'\n";
		}
	}
}


