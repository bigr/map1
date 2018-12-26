#!/usr/bin/env bash
DIR_MAPNIK="/root/map1/mapnik"


DIR_BACKUP=`pwd`

cd $DIR_MAPNIK
rm -rf "../map/tiles-std"
mkdir "../map/tiles-std"
MAPNIK_MAP_FILE="osm-mod.xml" MAPNIK_TILE_DIR="../map/tiles-std/" ./generate_tiles.py



cd $DIR_BACKUP
