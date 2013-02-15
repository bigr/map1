#!/usr/bin/env bash

X=$1
DBNAME=$2

PREP_TABLE="1"


#bunzip2 $X

# Import 10m contours

gdal_contour -i 5 -snodata 32767 -a height "$X" "$X.shp"
[ "$PREP_TABLE" ] && shp2pgsql -p -I -g way "$X.shp" contours | psql -q $DBNAME
shp2pgsql -a -g way "$X.shp" contours | psql -q $DBNAME

#rm -f "$X.shp" "$X.shx" "$X.dbf"
#rm -f "$X.bil"
#rm -f "$X.hdr"
#rm -f "$X.prj"
#bzip2 "${X%%.bz2}"
unset PREP_TABLE

