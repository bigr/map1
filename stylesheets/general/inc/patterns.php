<?php
require_once 'inc/utils.php';

function getPatternFile($pattern) {
	$params = func_get_args();
	array_shift($params);
	return call_user_func_array("pattern_$pattern",$params);	
}

function pattern_hatch($size, $rotation, $opacity, $color, $stroke) {
	$sizehalf = $size/2;
	require ROOT."/general/pattern/hatch.svg.tpl";	
	$file = ROOT."/general/pattern/~hatch-$size-$rotation-$opacity-$color-$stroke.png";					
	svg2png($file,$svg);	
	return $file;
}
