#!/usr/bin/env bash
cd osm

unlink slovenia.osm.bz2
wget http://download.geofabrik.de/osm/europe/slovenia.osm.bz2



/usr/bin/osm2pgsql \
	-d gis_sl \
	--style "/home/klinger/mymap/osm2pgsql/default.style" \
	--create \
	--slim --cache 30 \
	slovenia.osm.bz2
