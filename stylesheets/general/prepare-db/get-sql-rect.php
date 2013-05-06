<?php
/*
    $LON_START = $argv[1] - ($argv[3] - $argv[1]) * 0.15;
    $LAT_START = $argv[2] - ($argv[4] - $argv[2]) * 0.05;
    $LON_END = $argv[3] + ($argv[3] - $argv[1]) * 0.15;
    $LAT_END = $argv[4] + ($argv[4] - $argv[2]) * 0.05;

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
        //array('shield-peak','peak',sql_shieldPeak),
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
  

DROP INDEX IF EXISTS i__symbols__way;
CREATE INDEX i__symbols__way ON symbols USING GIST ( way );
DROP INDEX IF EXISTS i__symbols__osm_id;
CREATE INDEX i__symbols__osm_id ON symbols ( osm_id );
DROP INDEX IF EXISTS i__symbols__leisure;
CREATE INDEX i__symbols__leisure ON symbols ( leisure );
DROP INDEX IF EXISTS i__symbols__historic;
CREATE INDEX i__symbols__historic ON symbols ( historic );
DROP INDEX IF EXISTS i__symbols__amenity;
CREATE INDEX i__symbols__amenity ON symbols ( amenity );
DROP INDEX IF EXISTS i__symbols__man_made;
CREATE INDEX i__symbols__man_made ON symbols ( man_made );
DROP INDEX IF EXISTS i__symbols__tourism;
CREATE INDEX i__symbols__tourism ON symbols ( tourism );
DROP INDEX IF EXISTS i__symbols__building;
CREATE INDEX i__symbols__building ON symbols ( building );

DROP TABLE IF EXISTS symbol_density;
CREATE TABLE symbol_density AS 
SELECT S1.osm_id,Count(S2.osm_id) FROM symbols S1
JOIN symbols S2 ON ST_Distance(S1.way,S2.way) < 2500  AND S1.osm_id <> S2.osm_id AND 
  (S1.historic = S2.historic OR S1.amenity = S2.amenity OR S1.leisure = S2.leisure OR S1.man_made = S2.man_made OR S1.railway=S2.railway OR S1.aeroway = S2.aeroway OR S1.highway = S2.highway OR (S1.tourism = S2.tourism AND S1.tourism != 'attraction') OR (S1.building = S2.building AND S1.building IN ('church','chapel')))
GROUP BY S1.osm_id;


  */
?>
