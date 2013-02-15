<?php
require_once "inc/utils.php";
require_once "conf/text.conf.php";
require_once "conf/contour.conf.php";


$TEXT_CONTOUR_PRIORITIES = array (
 5 => array(),
 6 => array(),
 7 => array(),
 8 => array(),
 9 => array(),
10 => array(),
11 => array(),
12 => array(
		500 => 3,
		200 => 3,
	),
13 => array(
		500 => 3,
		200 => 3,
		100 => 3,
	),
14 => array(
		500 => 3,
		200 => 3,
		 50 => 3,
	),	
15 => array(
		500 => 3,
		200 => 3,
		100 => 3,
		 50 => 3,
		 20 => 3,
	),	
16 => array(
		500 => 3,
		200 => 3,
		100 => 3,
		 50 => 3,
		 20 => 3,
		 10 => 3,
	),		
17 => array(
		500 => 3,
		200 => 3,
		100 => 3,
		 50 => 3,
		 20 => 3,
		 10 => 3,
	),		
18 => array(
		500 => 3,
		200 => 3,
		100 => 3,
		 50 => 3,
		 20 => 3,
		 10 => 3,
	),
);


$TEXT_CONTOUR_COLOR = array (
500 => $_CONTOUR_COLOR,
200 => $_CONTOUR_COLOR,
100 => $_CONTOUR_COLOR,
 50 => $_CONTOUR_COLOR,
 20 => $_CONTOUR_COLOR,
 10 => $_CONTOUR_COLOR,
);

$TEXT_CONTOUR_SIZE = array (
500 => array(12=>11.0,17=>13),
200 => array(12=>11.0,17=>13),
100 => array(12=>11.0,17=>13),
 50 => array(12=>11.0,17=>13),
 20 => array(12=>11.0,17=>13),
 10 => array(12=>11.0,17=>13),
);

