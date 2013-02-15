#!/usr/bin/env bash

X1=$1
Y1=$2
X2=$3
Y2=$4
nm=$5

export LD_LIBRARY_PATH=/usr/local/lib

#gdal_translate -of GTiff -projwin "$X1" "$Y1" "$X2" "$Y2" '/home/klinger/mymap/contours/srtm_czech_republic.tif' '/tmp/adapted.tif'

#gdalwarp -of GTiff -srcnodata -32767 -ts "$widh" "$height" -rpc order=3 -wt Float32 -ot Float32 -multi '/tmp/adapted.tif' '/tmp/warped.tif'

#unlink '/tmp/adapted.tif'

#gdaldem hillshade -of png -compute_edges -z 4 -az 180 -alt 80 '/tmp/adapted.tif'  '/tmp/hillshade.png'

gdal_translate -of png -projwin "$X1" "$Y1" "$X2" "$Y2" "/home/klinger/mymap/contours/hillshade.eu.900913.tif" "/tmp/hillshade-$nm.png"

#unlink '/tmp/adapted.tif'

#unlink '/tmp/warped.tif'
