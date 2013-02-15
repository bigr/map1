<?php
require_once "inc/utils.php";
require_once "conf/common.conf.php";


$CONTOUR_MODULOS = array (	 
 5 => array(),
 6 => array(),
 7 => array(),
 8 => array(),
 9 => array(),
10 => array(),
11 => array(),
12 => array(500,200,100,50),
13 => array(500,200,100,20),
14 => array(500,200,100,50,20,10),
15 => array(500,200,100,50,20,10,5),
16 => array(500,200,100,50,20,10,5),
17 => array(500,200,100,50,20,10,5),
18 => array(500,200,100,50,20,10,5),
);


$CONTOUR_COLOR = array (
500 => $_CONTOUR_COLOR,
200 => $_CONTOUR_COLOR,
100 => $_CONTOUR_COLOR,
 50 => $_CONTOUR_COLOR,
 20 => $_CONTOUR_COLOR,
 10 => $_CONTOUR_COLOR,
  5 => $_CONTOUR_COLOR,
);

$CONTOUR_WIDTH = array (
500 => array(12=>1),
200 => array(12=>1),
100 => array(12=>1),
 50 => array(12=>1),
 20 => array(13=>1),
 10 => array(14=>1),
  5 => array(15=>1),
);

$CONTOUR_OPACITY = array (
500 => array(12=>0.3, 13=>0.5,          15 => 0.6),
200 => array(12=>0.3, 13=>0.5,          15 => 0.6),
100 => array(12=>0.3, 13=>0.5,          15 => 0.6),
 50 => array(12=>0.2, 13=>0.0, 14=>0.3, 15 => 0.5),
 20 => array(         13=>0.3, 14=>0.3,  5 => 0.4),
 10 => array(                  14=>0.3, 15 => 0.4),
  5 => array(                           15 => 0.2),
);


