#!/usr/bin/env bash

PREP_TABLE="1"
for X in *.tif.bz2; do
	bunzip2 $X
	
	# Import 10m contours
	
	gdal_contour -i 5 -snodata 32767 -a height "${X%%.bz2}" "${X%%.tif.bz2}.shp"
	[ "$PREP_TABLE" ] && shp2pgsql -p -I -g way "${X%%.tif.bz2}" contours | psql -q gis
	shp2pgsql -a -g way "${X%%.tif.bz2}" contours | psql -q gis
	
	rm -f "${X%%.tif.bz2}.shp" "${X%%.tif.bz2}.shx" "${X%%.tif.bz2}.dbf"
	rm -f "${X%%.tif.bz2}.bil"
	rm -f "${X%%.tif.bz2}.hdr"
	rm -f "${X%%.tif.bz2}.prj"
	bzip2 "${X%%.bz2}"
	unset PREP_TABLE
done
