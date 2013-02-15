<?php
    if ( !defined('ROOT') ) {
        define('ROOT',dirname(dirname(dirname(__FILE__))));
    
        set_include_path (        
            get_include_path() . PATH_SEPARATOR .
            ROOT . '/general/'
        );
    }
    
    require_once 'place_short_names.list.php';
    
    require_once 'river_names.list.php';
    
    $sqls = array(
        array('symbol','symbols',sql_symbol),
        array('text-symbol','text_symbol',sql_text_symbol),
        array('shield-peak','peak',sql_shieldPeak),
        array('text-place','place',sql_text_place),
        array('text-highway','text_highway',sql_text_highway),
        array('highway','highways',sql_highway),
        array('railway','railways',sql_railway),
        array('waters','waterways',sql_waterway),
        array('text-waters','text_waterway',sql_text_waterway),
    );
    
    foreach ( $sqls as $sql ) {
        require_once "sql/{$sql[0]}.sql.php";
        echo "DROP TABLE IF EXISTS {$sql[1]};\n";    
        echo "CREATE TABLE {$sql[1]} AS (" . $sql[2]() . ");\n";
    }
    
    foreach ( $PLACE_SHORT_NAMES as $pattern => $__tmp ) {
        list($shortName,$veryShortName) = $__tmp;
        if (empty($veryShortName) ) $veryShortName = $shortName;
        echo "UPDATE place SET name_short = regexp_replace(name_short,'$pattern','$shortName') WHERE name_short ~ '$pattern';\n";
        echo "UPDATE place SET name_very_short = regexp_replace(name_very_short,'$pattern','$veryShortName') WHERE name_very_short ~ '$pattern';\n";        
    }
    
?>

DROP TABLE highway_e;
CREATE TABLE highway_e AS (
SELECT
	ST_Collect(way) AS way,
    SUBSTRING(int_ref FROM 'E[ 0-]*([0-9]*)') AS number  
  FROM highway
  WHERE int_ref ~ 'E[ 0-]*[0-9]*' AND highway IS NOT NULL
  GROUP BY SUBSTRING(int_ref FROM 'E[ 0-]*([0-9]*)')
);
