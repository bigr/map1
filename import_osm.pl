#!/usr/bin/env bash
cd osm

unlink poland.osm.bz2
wget http://download.geofabrik.de/osm/europe/poland.osm.bz2

/usr/bin/osm2pgsql \
	-d gis_pl \
	--style "/home/klinger/mymap/osm2pgsql/default.style" \
	--create \
	--slim --cache 30 \
	poland.osm.bz2
