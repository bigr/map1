<?php
require_once("helper.php");
require_once('sql/symbol.sql.php');
createTable('symbols','sql_symbol',array('osm_id','leisure','historic','amenity','man_made','tourism','building','grade','name','type'));
?>

DROP TABLE IF EXISTS symbol_density;
CREATE TABLE symbol_density AS 
SELECT S1.osm_id,Count(S2.osm_id) FROM symbols S1
JOIN symbols S2 ON ST_DWithin(S1.way,S2.way,2500) AND S1.osm_id <> S2.osm_id AND 
  (S1.historic = S2.historic OR S1.amenity = S2.amenity OR S1.leisure = S2.leisure OR S1.man_made = S2.man_made OR S1.railway=S2.railway OR S1.aeroway = S2.aeroway OR S1.highway = S2.highway OR (S1.tourism = S2.tourism AND S1.tourism != 'attraction') OR (S1.building = S2.building AND S1.building IN ('church','chapel')))
GROUP BY S1.osm_id;

CREATE INDEX i__text_symbol_density__osm_id ON symbol_density(osm_id);
CREATE INDEX i__symbol_density__count ON symbol_density(count);
