<?php

    $LON_START = $argv[1];
    $LAT_START = $argv[2];
    $LON_END = $argv[3];
    $LAT_END = $argv[4];

    if ( !defined('ROOT') ) {
        define('ROOT',dirname(dirname(dirname(__FILE__))));
    
        set_include_path (        
            get_include_path() . PATH_SEPARATOR .
            ROOT . '/general/'
        );
    }        
    
    $sqls = array(
        array('symbol','symbols',sql_symbol),
        array('text-symbol','text_symbol',sql_text_symbol),
        array('shield-peak','peak',sql_shieldPeak),
        array('text-place','place',sql_text_place),        
        array('waters','waterways',sql_waterway),
        array('boundary','adminboundaries',sql_boundary),
        array('text-waters','text_waterway',sql_text_waterway),
    );
    
    foreach ( $sqls as $sql ) {
        require_once "sql/{$sql[0]}.sql.php";
        echo "DROP TABLE IF EXISTS {$sql[1]};\n";    
        echo "CREATE TABLE {$sql[1]} AS (SELECT * FROM (" . $sql[2]() . ") T WHERE ST_Intersects(way,ST_Transform(ST_SetSRID(ST_MakeBox2D(ST_GeomFromEWKT('SRID=4326;POINT($LON_START $LAT_START)'), ST_GeomFromEWKT('SRID=4326;POINT($LON_END $LAT_END)')), 4326),900913)));\n";
    }
    
