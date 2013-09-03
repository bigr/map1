<?php

define('LEGENT_TYPE_LINE',1);
define('LEGENT_TYPE_AREA',2);

class OSM {
  
  var $_file;
  var $_nodes = array();
  var $_ways = array();
  var $_relations = array();
  
  function __construct($file) {
    $this->_file = fopen($file,"w");    
  }
  
  function __destruct() {   
    fclose($this->_file);
  }
  
  function addNode($id,$lat,$lon,$tags=array()) {
    $this->_nodes[] = array('id' => $id, 'lon' => $lon, 'lat' => $lat, 'tags' => $tags);    
  }
  
  function addWay($id,$nodes,$tags = array()) {
    $nds = array();
    foreach ( $nodes as $node ) {
      if ( !empty($node['lon']) && !empty($node['lat']) ) {
        $this->addNode($node['id'],$node['lon'],$node['lat']);
      }
      $nds[] = $node['id'];
    }
    $this->_ways[] = array('id' => $id, 'nds' => $nds, 'tags' => $tags);
  }
  
  function addRelation($id,$members, $tags = array()) {    
    $this->_relations[] = array('id' => $id, 'members' => $members, 'tags' => $tags);
  }
  
  function generate() {
    $this->_write("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n");
    $this->_write("<osm version=\"0.6\">\n");
    foreach ( $this->_nodes as $node ) {
      $this->_node($node['id'],$node['lon'],$node['lat'],$node['tags']);
    }
    foreach ( $this->_ways as $way ) {
      $this->_way($way['id'],$way['nds'],$way['tags']);
    }
    foreach ( $this->_relations as $relation ) {
      $this->_relation($relation['id'],$relation['members'],$relation['tags']);
    }
    $this->_write("</osm>");
  }
  
  function _tags($tags) {
    foreach ( $tags as $k => $v ) {
      $this->_write("    <tag k=\"$k\" v=\"$v\"/>\n");
    }
  }
  
  function _node($id,$lon,$lat,$tags = array()) {
    if ( empty($tags) ) {
      $this->_write("  <node id=\"$id\" lon=\"$lon\" lat=\"$lat\"/>\n");
    }
    else {
      $this->_write("  <node id=\"$id\" lon=\"$lon\" lat=\"$lat\">\n");      
      $this->_tags($tags);
      $this->_write("  </node>\n");
    }
  }
  
  function _way($id,$nds,$tags = array()) {
    $this->_write("  <way id=\"$id\">\n");
    foreach ( $nds as $nd ) {
      $this->_write("    <nd ref=\"$nd\">\n");
    }
    $this->_tags($tags);
    $this->_write("  </way>\n");
  }
  
  function _relation($id,$members,$tags = array()) {
    $this->_write("  <relation id=\"$id\">\n");
    foreach ( $members as $member ) {
      $this->_write("    <member type=\"{$member['type']}\" ref=\"{$member['ref']}\" role=\"{$member['role']}\" >\n");
    }
    $this->_tags($tags);
    $this->_write("  </relation>\n");
  }
  
  function _write($str) {
    $ret = fwrite($this->_file,$str);
    if ( $ret === false ) {
      throw new Exception("Error writing");
    }
    if ( strlen($str) != $ret ) {
      throw new Exception("Error writing");
    }
  }
}//OSM

class Legend {
  
  var $_id = -1;
  var $_osm;
  
  function __construct($file,$zoom,$lon = 0,$lat = 45) {
    $this->_cx = 256*((($lon + 180) / 360) * pow(2, $zoom));
    $this->_cy = 256*((1 - log(tan(deg2rad($lat)) + 1 / cos(deg2rad($lat))) / pi()) /2 * pow(2, $zoom));    
    $this->_zoom = $zoom;
    $this->_osm = new OSM($file);
    $this->_lineHeight = 30;
    $this->_ymargin = 3;
    $this->_rectRatio = 0.5;
  }
  
  
  function _line($x1,$y1,$x2,$y2,$tags = array()) {
    $nodes = array();
    $nodes[] = array(
      'id' => $this->_id(),
      'lon' => $this->_lon($x1),
      'lat' => $this->_lat($y1)
    );
    $nodes[] = array(
      'id' => $this->_id(),
      'lon' => $this->_lon($x2),
      'lat' => $this->_lat($y2)
    );
    
    $this->_osm->addWay($this->_id(),$nodes,$tags);
  }
  
  function _rect($x1,$y1,$x2,$y2,$tags = array()) {
    $nodes = array();
    $start = $this->_id();
    $nodes[] = array(
      'id' => $start,
      'lon' => $this->_lon($x1),
      'lat' => $this->_lat($y1)
    );
    $nodes[] = array(
      'id' => $this->_id(),
      'lon' => $this->_lon($x2),
      'lat' => $this->_lat($y1)
    );
    $nodes[] = array(
      'id' => $this->_id(),
      'lon' => $this->_lon($x2),
      'lat' => $this->_lat($y2)
    );
    $nodes[] = array(
      'id' => $this->_id(),
      'lon' => $this->_lon($x1),
      'lat' => $this->_lat($y2)
    );
    $nodes[] = array(
      'id' => $start      
    );
    
    $this->_osm->addWay($this->_id(),$nodes,$tags);
  }
  
  function _id() {
    return $this->_id--;
  }
    
  function _lon($x) {
    return (($x+$this->_cx)/256.0) / pow(2, $this->_zoom) * 360.0 - 180.0;
  }
  
  function _lat($y) {    
    return rad2deg(atan(sinh(pi() * (1 - 2 * (($y+$this->_cy)/256) / pow(2, $this->_zoom)))));
  }
  
  function draw($width, $legend) {
    $y = 0;
    $x1 = 0;
    $x2 = $x1 + $width;
    foreach ( $legend as $l ) {
      $y += $this->_lineHeight;
      switch ( $l['type'] ) {
        case LEGENT_TYPE_LINE:
          $this->_line($x1,$y+$this->_lineHeight/2,$x2,$y+$this->_lineHeight/2);
          break;
        case LEGENT_TYPE_AREA:
          $this->_rect($x1+$this->_rectRatio*($x2-$x1)/2,$y+$this->_ymargin/2,$x2-$this->_rectRatio*($x2-$x1)/2,$y+$this->_lineHeight-$this->_ymargin/2);
          break;
        default:
          throw new Exception("Unknown type {$l['type']}");
      } 
    }
  }
  
  function generate() {
    $this->_osm->generate();
  }
}


$legend = new Legend('/tmp/test.osm',9,15,50);
$legend->draw(100,array(
 array('type' => LEGENT_TYPE_LINE),
 array('type' => LEGENT_TYPE_AREA), 
));
  
$legend->generate();

#echo $legend->_lon(256,1);
#echo $legend->_lat(0);
#echo "\n";
#echo $legend->_lat(100);
#echo "\n";
#echo $legend->_lat(200);
#echo "\n";

#$osm = new OSM('/tmp/test');
#$osm->addNode(-1,23.4,24.5,array('test'=>'aaa'));
#$osm->generate();


