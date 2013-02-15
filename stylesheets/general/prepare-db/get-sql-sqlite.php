<?php
if ( !defined('ROOT') ) {
    define('ROOT',dirname(dirname(dirname(__FILE__))));

    set_include_path (        
        get_include_path() . PATH_SEPARATOR .
        ROOT . '/general/'
    );
}
require_once "conf/common.conf.php";
?>
SELECT load_extension('libspatialite.so');
<?php
    include(dirname(__FILE__) . '/sqlite-views.php'); 
    
    $sqls = array(
        array('highway','highways',sql_highway,'VIEW'),
        array('text-highway','highway_texts',sql_text_highway,'VIEW'),
        array('railway','railways',sql_railway,'VIEW'),
        array('aerialway','aerialways',sql_aerialway,'VIEW'),
        array('aerialway','aerialway_points',sql_aerialway_point,'VIEW'),
        array('barrier','barriers',sql_barrier,'VIEW'),
        array('power','powers',sql_power,'VIEW'),
        array('power','power_points',sql_power_point,'VIEW'),
        array('building','buildings',sql_building,'VIEW'),
        array('waters','waterareas',sql_waterarea,'VIEW'),    
        array('text-waters','waterarea_texts',sql_text_waterarea,'VIEW'),        
    );
    
    foreach ( $sqls as $sql ) {        
        require_once "sql/{$sql[0]}.sql.php";
        $query = $sql[2]();        
        echo "DROP ${sql[3]} IF EXISTS {$sql[1]};\n";    
        echo "CREATE ${sql[3]} {$sql[1]} AS " . $query . ";\n";
    }    
?>

<?php foreach ($RENDER_LAYERS as $layer): ?>
DROP TABLE IF EXISTS highways_major_layer_<?php echo strtr($layer,'-','_'); ?>;
CREATE TABLE highways_major_layer_<?php echo strtr($layer,'-','_'); ?> AS
    SELECT * FROM highways WHERE grade < 6 AND layer = <?php echo $layer; ?> ORDER BY grade DESC;
DROP TABLE IF EXISTS highways_minor_layer_<?php echo strtr($layer,'-','_'); ?>;
CREATE TABLE highways_minor_layer_<?php echo strtr($layer,'-','_'); ?> AS
    SELECT * FROM highways WHERE grade >= 6 AND layer = <?php echo $layer; ?> ORDER BY grade DESC;

DROP TABLE IF EXISTS railways_layer_<?php echo strtr($layer,'-','_'); ?>;
CREATE TABLE railways_layer_<?php echo strtr($layer,'-','_'); ?> AS
    SELECT * FROM railways WHERE layer = <?php echo $layer; ?> ORDER BY grade DESC;

DROP TABLE IF EXISTS aerialway_layer_<?php echo strtr($layer,'-','_'); ?>;
CREATE TABLE aerialway_layer_<?php echo strtr($layer,'-','_'); ?> AS
    SELECT * FROM aerialways WHERE layer = <?php echo $layer; ?>;   
    
DROP TABLE IF EXISTS aerialway_point_layer_<?php echo strtr($layer,'-','_'); ?>;
CREATE TABLE aerialway_point_layer_<?php echo strtr($layer,'-','_'); ?> AS
    SELECT * FROM aerialway_points WHERE layer = <?php echo $layer; ?>;    
    
DROP TABLE IF EXISTS barrier_layer_<?php echo strtr($layer,'-','_'); ?>;
CREATE TABLE barrier_layer_<?php echo strtr($layer,'-','_'); ?> AS
    SELECT * FROM barriers WHERE layer = <?php echo $layer; ?>;    
    
DROP TABLE IF EXISTS power_layer_<?php echo strtr($layer,'-','_'); ?>;
CREATE TABLE power_layer_<?php echo strtr($layer,'-','_'); ?> AS
    SELECT * FROM powers WHERE layer = <?php echo $layer; ?>;   
    
DROP TABLE IF EXISTS power_point_layer_<?php echo strtr($layer,'-','_'); ?>;
CREATE TABLE power_point_layer_<?php echo strtr($layer,'-','_'); ?> AS
    SELECT * FROM power_points WHERE layer = <?php echo $layer; ?>;    
    
DROP TABLE IF EXISTS waterarea_layer_<?php echo strtr($layer,'-','_'); ?>;
CREATE TABLE waterarea_layer_<?php echo strtr($layer,'-','_'); ?> AS 
    SELECT * FROM waterareas WHERE layer = <?php echo $layer; ?>;
<?php endforeach; ?>

DROP TABLE IF EXISTS waterarea_texts_tbl;
CREATE TABLE waterarea_texts_tbl AS  SELECT * FROM waterarea_texts;


DROP TABLE IF EXISTS highways_text;
CREATE TABLE highways_text AS 
SELECT * FROM highway_texts;

DROP TABLE IF EXISTS landcover_tbl;
CREATE TABLE landcover_tbl AS SELECT * FROM landcover;


DROP TABLE IF EXISTS building_tbl;
CREATE TABLE building_tbl AS SELECT * FROM buildings;

DROP TABLE IF EXISTS residentialcover;
CREATE TABLE residentialcover AS SELECT * FROM highways_minor_layer_0 WHERE highway='residential';


