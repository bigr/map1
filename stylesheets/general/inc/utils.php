<?php
require_once dirname(__FILE__)."/colors.php";

function getPixelSize($zoom) {
	return 40079171.1277036*cos(0.0174532925*50)/pow(2,($zoom+8));
}

function interpolate($def,$zoom, $transport, $transportI)  {
	
	if ( !is_array($def) )
		throw new Exception("Need definition");	
		
	$convert = function ($z,$a) use($transport) {
		
		if ( is_array($a) ) {
			return array_map(function($x) use($transport,$z) {return $transport($z,floatval($x));}, $a);	
		}
		else if ( $a[0] == '#' )
			return array_map(function($x) use($transport,$z) {return $transport($z,floatval(hexdec($x)));}, str_split(substr($a,1),2));		
		else
			return array($transport($z,floatval($a)));
	};
	
	$deconvert = function ($z,$a) use($transportI) {
		if ( count($a) == 3 )
			return '#'.implode(array_map(function ($x) use($transportI,$z) {return str_pad(dechex(intval($transportI($z,$x))),2,'0',STR_PAD_LEFT);},$a),'');
		else if ( count($a) == 1 ) {
			return $transportI($z,$a[0]);
		}
		else
			return array_map(function ($x) use($transportI,$z) {return ceil($transportI($z,$x));},$a);
	};
	
	$lv = null;	
	$lk = ~PHP_INT_MAX;
	
	if ( empty($def) ) {
		throw new Exception('Empty definition in interpolate.');
	}	
	
	foreach ( $def as $k => $v ) {
		$hex = $v[0] == '#';			
		$v = $convert($k,$v);
		if ( $lv == null )
			$lv = $v;		
		if ( $zoom > $lk and $zoom <= $k ) {
			for ( $i = 0; $i < count($v); ++$i ) {				
				$ret[$i] = ($lv[$i] * ($k-$zoom))/($k - $lk) + ($v[$i] * ($zoom-$lk))/($k - $lk);
			}
			return $deconvert($zoom,$ret);
		}
		$lk = $k;
		$lv = $v;
	}
	return $deconvert($zoom,$convert($lk,$def[$lk]));
}

function blackandwhite($color) {
	$rgb = array_map(function($x) {return floatval(hexdec($x));}, str_split(substr($color,1),2));
	$c = str_pad(dechex(intval((0.3 * $rgb[0] + 0.59*$rgb[1] + 0.11 * $rgb[2]))),2,'0',STR_PAD_LEFT);
	return "#$c$c$c";
}

function darken($color,$percent) {	
	$hsl = RGBToHSL(HTMLToRGB($color));
	$l = ($hsl & 0xFF) * (1 - $percent/100.0);
	if ( $l > 0xFF ) $l = 0xFF;
	$hsl = $hsl & (0xFFFF00 & $hsl) | $l;
	return RGBToHTML(HSLToRGB($hsl));
}

function darken_a($color_a,$percent) {
	return array_map(function($_c) use($percent) { return darken($_c,$percent); },$color_a);
}

function linear($def,$zoom) {
	return interpolate(
		$def, $zoom,
		function($zoom,$x) {return $x;},
		function($zoom,$x) {return $x;}
	); 
}

function exponential($def,$zoom) {
	return interpolate(
		$def, $zoom,
		function($zoom,$x) {return $x < 0.01 ? log(0.01) : log($x);},
		function($zoom,$x) {return exp($x);}
	); 
}

function meterlengthes($def,$zoom) {
	return interpolate(
		$def, $zoom,
		function($z,$x) {return $x;},
		function($z,$x) {return $x/getPixelSize($z);}
	);
}

function pixelareas($def,$zoom) {
	return interpolate(
		$def, $zoom,
		function($z,$x) {return $x;},
		function($z,$x) {return $x*pow(getPixelSize($z),2);}
	);
}

function svg2png($file, $svg) {
	$im = new Imagick();
	$im->setBackgroundColor(new ImagickPixel('transparent'));
	$im->readImageBlob($svg);
	$im->setImageFormat("png24");
	$im->writeImage($file);
	$im->clear();
	$im->destroy();	
}

function propertyToSql($string) {
	$array = explode(',',$string);	
	$query = array();
	foreach ( $array as $item) {
		$item = ltrim($item,'[');
		$item = rtrim($item,']');
		$subarray = explode('][',$item);
		$subquery = array();
		foreach( $subarray as $subitem ) {
			if ( $subitem[0] == '.' )
				continue;
			if ( !preg_match('/[\"]?([\w:]+)[\"]?\s*(=|\!=|\<|\>)\s*[\']?([^\']+)[\']?/',$subitem, $matches) ) {
				throw new Exception("Error during parsint properties: $subitem");
			}
			
			$operator = $matches[2];
			$column = $matches[1];
			$value = addslashes($matches[3]);
			if ( $value == 'no' && $operator == '=' ) {
					$subquery[] = "( \"$column\" IS NULL OR \"$column\" = 'no' )"; 
			}
			else if ( $value == 'no' && $operator == '!=' ) {
					$subquery[] = "( \"$column\" IS NOT NULL AND \"$column\" <> 'no' )"; 
			}
			else {
				if ( $operator == '!=' ) $operator = '<>';				
				$subquery[] = "(\"$column\" $operator '$value')";
			}						
			
		}		
		if ( !empty($subquery) ) {			
			$query[] = '('.implode(" AND ",$subquery).')';
		}
		
		$ret = '('.implode(" OR ",$query).')';
	}
	return $ret;
}


function getPropertyWhereQuery($conf) {		
	$query = array();
	foreach ( array_keys($conf) as $string ) {			
		$query[] = '('.propertyToSql($string).')';
	}
	$query = implode(' OR ',$query);
	return $query;
}


function getPropertyTypeQuery($conf) {
	$ret = " (CASE ";	
	$i = 0;
	foreach ( array_keys($conf) as $string ) {		
		$ret .= " WHEN ";
		$ret .= '('.propertyToSql($string).')';
		$ret .= " THEN " . ($i+1) ."\n";
		++$i;
	}
	$ret .= " END) ";
	
	return $ret;
}

function interval2selector($intervals,$field, $function = null) {
	if ( empty($function) ) {
		$function = function($x) {return $x;};
	}
	list($values,$items) = array(array_keys($intervals), array_values($intervals));
	$ret = array();
	for ( $i = 1; $i<count($values); ++$i ) {		
		$from = round($function($values[$i-1])) .'.1';
		$to = round($function($values[$i])) .'.1';
		
		$ret["[$field >= $from][$field < $to]"] = $items[$i-1];
	}
	$from = round($function(end($values))) .'.1';
	
	$ret["[$field >= $from]"] = end($items);
	
	return $ret;
}

function pixelarea2selector($areas,$zoom) {
	return interval2selector($areas, 'way_area',function($x) use($zoom) { return $x*pow(getPixelSize($zoom),2); });
}

function expex($coefs,$value) {
	$ret = 1;
	for ( $i = 0; $i <= $value; ++$i ) {
		$ret *= linear($coefs,$i);
	}
	return $ret;
}

function text_limiter($size) {
	$size = $size >= 19
		? $size
		: 19 + 0.4 * ($size - 19);
	
	$size = $size >= 14
		? $size
		: 14 + 0.3 * ($size - 14);
		
	$size = $size >= 12
		? $size
		: 12 + 0.2 * ($size - 12);
		
	$size = $size <= 30.0
		? $size
		: 30.0 + 0.7 * ($size - 30.0);
	
	$size = $size <= 45.0
		? $size
		: 45.0 + 0.8 * ($size - 45.0);
		
		
	$size = $size <= 120.0
		? $size
		: 120.0 + 0.75 * ($size - 120.0);
		
	return $size;
	
}


function justModulo($col,$modulo) {
	switch ( $modulo ) {
	case 2:	
		return "$col =~ \"^\\d*[2468](\\.[0]*$|$)\"";
	case 5:
		return "$col =~ \"^\\d*[5](\\.[0]*$|$)\"";
	case 10:
		return "$col =~ \"^\\d*[1379]0(\\.[0]*$|$)\"";
	case 20:
		return "$col =~ \"^\\d*[2468]0(\\.[0]*$|$)\"";
	case 50:
		return "$col =~ \"^\\d*[5]0(\\.[0]*$|$)\"";
	case 100:
		return "$col =~ \"^\\d*[1379]00(\\.[0]*$|$)\"";
	case 200:
		return "$col =~ \"^\\d*[2468]00(\\.[0]*$|$)\"";
	case 500:
		return "$col =~ \"^\\d*[5]00(\\.[0]*$|$)\"";
	}
}
