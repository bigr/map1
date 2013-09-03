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
	foreach ( $WATERPOINT AS $selector => $a ) {				
		if ( !empty($a['symbol-file']) && !empty($a['zooms']) && in_array($zoom,$a['zooms']) ) {						
			
			$vSize = 26880;
			
			$size = exponential($a['symbol-size'],$zoom);			
			$color = empty($a['symbol-color']) ? '#000000' : linear($a['symbol-color'],$zoom);
			$opacity = empty($a['symbol-opacity']) ? '1' : linear($a['symbol-opacity'],$zoom);
			$haloColor = empty($a['halo-color']) ? '#ffffff' : linear($a['halo-color'],$zoom);
			$haloOpacity = empty($a['halo-opacity']) ? 0.66 : linear($a['halo-opacity'],$zoom);
			$haloRadius = empty($a['halo-radius']) ? 2 : linear($a['halo-radius'],$zoom);
			
			$size += 2*$haloRadius;
			
			$c_r = hexdec(substr($haloColor,1,2))/256;
			$c_g = hexdec(substr($haloColor,3,2))/256;
			$c_b = hexdec(substr($haloColor,5,2))/256;
			
			$scale = 1-2*$haloRadius/$size;
			$haloRadius *= $vSize/$size;			
			$translate = $haloRadius;
			$filterPos = 100 - 100*$scale;
			$filterSize = 100 + $filterPos*2;
			
			
			$pre = <<<EOD
	<defs>
    <filter id="halo" filterUnits="objectBoundingBox" x="-$filterPos%" y="-$filterPos%" width="$filterSize%" height="$filterSize%">
      <feColorMatrix type="matrix" values=
            "0 0 0 $c_r 0
             0 0 0 $c_g 0 
             0 0 0 $c_b 0 
             0 0 0 $haloOpacity 0"
        result="_"/>
      <feMorphology operator="dilate" in="_" result="halo" radius="$haloRadius" />
      <feMerge>
        <feMergeNode in="halo"/>
        <feMergeNode in="SourceGraphic"/>
    </feMerge>
    </filter>
  </defs>
  <g style="filter: url(#halo);">		
  <g transform="translate($translate,$translate) scale($scale)">
EOD;
			$post = "</g></g>";												
						
			require "{$a['symbol-file']}.svg.tpl";
			
			
			//file_put_contents("/tmp/svgs/{$a['symbol-file']}.svg",$svg);
			
			svg2png(ROOT."/general/symbol/~{$a['symbol-file']}-$zoom-$color.png",$svg);
		}
	}
}


