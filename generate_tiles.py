#!/usr/bin/env bash
DIR_BACKUP=`pwd`
cd mapnik
rm -rf "../map/tiles"
mkdir "../map/tiles"
MAPNIK_MAP_FILE="../stylesheet/my-map.xml" MAPNIK_TILE_DIR="../map/tiles/" ./generate_tiles.py

cd $DIR_BACKUP
