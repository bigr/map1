DROP VIEW IF EXISTS highway_access_view;
DROP TABLE IF EXISTS highway_access;

<?php
require_once("helper.php");
require_once('sql/highway.sql.php');
createTable('highways','sql_highway',array('grade','type','layer','is_bridge','oneway','highway'));
?>

DROP TABLE IF EXISTS highway_access_centroids;
CREATE TABLE highway_access_centroids AS
SELECT H1.osm_id,St_Centroid(ST_Envelope(H1.way)) AS centroid FROM highways H1
WHERE COALESCE(H1.access,H1.bicycle,H1.horse,H1.inline_skates,H1.motorcar,H1.motorcycle,H1.motor_vehicle,H1.foot,H1.ski,H1.bus) IS NOT NULL;

CREATE INDEX i__highway_access_centroids__centroid ON highway_access_centroids USING GIST ( centroid );

DROP TABLE IF EXISTS highway_access_density;
CREATE TABLE highway_access_density AS 
SELECT H1.osm_id AS osm_id,Count(H2.osm_id) AS density FROM highway_access_centroids H1
JOIN highway_access_centroids H2 ON ST_DWithin(H1.centroid,H2.centroid,1000)  AND H1.osm_id <> H2.osm_id
GROUP BY H1.osm_id;


