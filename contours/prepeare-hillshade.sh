gdal_merge.py -o srtm_tmp.tif srtm_39_02.tif srtm_39_03.tif srtm_40_02.tif srtm_40_03.tif
gdalwarp -of GTiff -co "TILED=YES" -t_srs "+proj=merc +ellps=sphere +R=6378137 +a=6378137 +units=m" -r bilinear srtm_tmp.tif srtm2_tmp.tif
#gdal_translate -of GTiff -co "TILED=YES" -a_srs "+proj=latlong" srtm_tmp.tif srtm2_tmp.tif
gdaldem hillshade -of gtiff -compute_edges -z 4 -az 330 -alt 60 'srtm2_tmp.tif'  'hillshade2_tmp.tif'



gdalwarp -dstnodata 255 -cutline "PG:dbname=gis" -csql "SELECT way FROM planet_osm_polygon WHERE admin_level='2'" -of GTiff hillshade2_tmp.tif hillshade.tif

