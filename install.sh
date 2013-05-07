#!/usr/bin/env bash
USR=klinger
VERSION=v0.2

export DEBIAN_FRONTEND=noninteractive
set -e
set -o pipefail

function makeGisDb {	
	su postgres -c "createdb -E UTF8 -O $2 $1"	
	set +e
	su postgres -c "createlang plpgsql $1"
	set -e
	su postgres -c "psql -d $1 -f /usr/local/pgsql/share/contrib/postgis-2.0/postgis.sql"
	su postgres -c "psql -d $1 -f /usr/local/pgsql/share/contrib/postgis-2.0/spatial_ref_sys.sql"
	su postgres -c "psql $1 -c \"ALTER TABLE geometry_columns OWNER TO $2\""
	su postgres -c "psql $1 -c \"ALTER TABLE geography_columns OWNER TO $2\""
	su postgres -c "psql $1 -c \"ALTER TABLE spatial_ref_sys OWNER TO $2\""
}

apt-get -y update
apt-get -y upgrade
apt-get -y install screen mc htop git gcc g++ python-dev zlib1g-dev libjpeg8-dev libfreetype6-dev build-essential libxml2-dev libbz2-dev libtool automake libprotobuf-c0-dev protobuf-c-compiler libtiff5-dev libpng12-dev libgif-dev libgeotiff2 libproj-dev flex bison libreadline6-dev xsltproc libicu-dev pkg-config libcurl3-dev libagg-dev python-imaging python-cairo swig check uthash-dev subversion php5-cli rsync imagemagick php5-imagick php5-pgsql ttf-liberation nginx python-numpy

su $USR -c "git clone https://github.com/bigr/map1 /home/$USR/mymap"
cd "/home/$USR/mymap"
su $USR -c "git checkout $VERSION"

su $USR -c "mkdir src"
cd src

su $USR -c "wget http://downloads.sourceforge.net/project/boost/boost/1.52.0/boost_1_52_0.tar.gz"
su $USR -c "tar -xf boost_1_52_0.tar.gz"
su $USR -c "unlink boost_1_52_0.tar.gz"
cd boost_1_52_0
su $USR -c "./bootstrap.sh"
su $USR -c "./b2 --with-python"
./b2 install
cd ..
ldconfig


su $USR -c "wget http://www.sqlite.org/sqlite-autoconf-3071502.tar.gz"
su $USR -c "tar -xf sqlite-autoconf-3071502.tar.gz"
su $USR -c "unlink sqlite-autoconf-3071502.tar.gz"
cd "sqlite-autoconf-3071502"
su $USR -c "CFLAGS='-DSQLITE_ENABLE_RTREE=1' ./configure"
su $USR -c "make"
make install
cd ..
ldconfig


su $USR -c "wget http://download.osgeo.org/geos/geos-3.3.8.tar.bz2"
su $USR -c "tar -xf geos-3.3.8.tar.bz2"
su $USR -c "unlink geos-3.3.8.tar.bz2"
cd "geos-3.3.8"
su $USR -c "./configure --enable-python"
su $USR -c "make"
make install
cd ..
ldconfig

su $USR -c "wget http://download.osgeo.org/gdal/gdal-1.9.2.tar.gz"
su $USR -c "tar -xf gdal-1.9.2.tar.gz"
su $USR -c "unlink gdal-1.9.2.tar.gz"
cd "gdal-1.9.2"
su $USR -c "./configure --with-python"
su $USR -c "make"
make install
cd ..
ldconfig

su $USR -c "wget http://pysqlite.googlecode.com/files/pysqlite-2.6.3.tar.gz"
su $USR -c "tar -xf pysqlite-2.6.3.tar.gz"
su $USR -c "unlink pysqlite-2.6.3.tar.gz"
cd "pysqlite-2.6.3"
su $USR -c "sed -i '/^define=SQLITE_OMIT_LOAD_EXTENSION/ s/^/#/' setup.cfg"
su $USR -c "python setup.py build"
python setup.py install
cd ..
ldconfig


su $USR -c "wget http://www.gaia-gis.it/gaia-sins/freexl-1.0.0e.tar.gz"
su $USR -c "tar -xf freexl-1.0.0e.tar.gz"
su $USR -c "unlink freexl-1.0.0e.tar.gz"
cd "freexl-1.0.0e"
su $USR -c "./configure"
su $USR -c "make"
make install
cd ..
ldconfig


su $USR -c "wget http://www.gaia-gis.it/gaia-sins/libspatialite-sources/libspatialite-3.0.1.tar.gz"
su $USR -c "tar -xf libspatialite-3.0.1.tar.gz"
su $USR -c "unlink libspatialite-3.0.1.tar.gz"
cd "libspatialite-3.0.1"
su $USR -c "./configure"
su $USR -c "make"
make install
cd ..
ldconfig

su $USR -c "wget http://ftp.postgresql.org/pub/source/v9.2.3/postgresql-9.2.3.tar.gz"
su $USR -c "tar -xf postgresql-9.2.3.tar.gz"
su $USR -c "unlink postgresql-9.2.3.tar.gz"
cd "postgresql-9.2.3"
su $USR -c "./configure"
su $USR -c "make"
make install
useradd -M -p "" postgres
mkdir /usr/local/pgsql/data
chown postgres /usr/local/pgsql/data
su postgres -c "/usr/local/pgsql/bin/initdb -D /usr/local/pgsql/data"
ln -s /usr/local/pgsql/bin/* /usr/local/bin
ln -s /usr/local/pgsql/lib/lib* /usr/local/lib
cd ..
ldconfig

su postgres -c "pg_ctl start -D /usr/local/pgsql/data"
sleep 15
su postgres -c "psql -c 'CREATE USER klinger'"
su postgres -c "psql -c 'ALTER USER klinger WITH CREATEDB'"
su postgres -c "psql -c 'ALTER USER klinger WITH SUPERUSER'"


su $USR -c "wget http://download.osgeo.org/postgis/source/postgis-2.0.3.tar.gz"
su $USR -c "tar -xf postgis-2.0.3.tar.gz"
su $USR -c "unlink postgis-2.0.3.tar.gz"
cd "postgis-2.0.3"
su $USR -c "./configure"
su $USR -c "make"
make install
cd ..
ldconfig


su $USR -c "wget http://initd.org/psycopg/tarballs/PSYCOPG-2-4/psycopg2-2.4.6.tar.gz"
su $USR -c "tar -xf psycopg2-2.4.6.tar.gz"
su $USR -c "unlink psycopg2-2.4.6.tar.gz"
cd "psycopg2-2.4.6"
su $USR -c "python setup.py build"
python setup.py install
cd ..
ldconfig



su $USR -c "git clone -b '2.1.x' https://github.com/mapnik/mapnik.git mapnik-v2.1.0"
cd "mapnik-v2.1.0"
su $USR -c "./configure"
su $USR -c "make"
make install
cd ..
ldconfig


su $USR -c "wget http://nodejs.org/dist/v0.8.22/node-v0.8.22.tar.gz"
su $USR -c "tar -xf node-v0.8.22.tar.gz"
su $USR -c "unlink node-v0.8.22.tar.gz"
cd "node-v0.8.22"
su $USR -c "./configure"
su $USR -c "make"
make install
cd ..
ldconfig


npm install --global millstone carto

su $USR -c "git clone https://github.com/bigr/o5mreader"
cd "o5mreader"
su $USR -c "./configure"
su $USR -c "make"
make install
cd ..
ldconfig


su $USR -c "git clone https://github.com/bigr/o5m2sqlite"
cd "o5m2sqlite"
su $USR -c "./configure"
su $USR -c "make"
make install
cd ..
ldconfig

su $USR -c "git clone https://github.com/openstreetmap/osm2pgsql.git" 
cd osm2pgsql
su $USR -c "./autogen.sh"
su $USR -c "./configure"
#su $USR -c "sed -i 's/-g -O2/-O2 -march=native -fomit-frame-pointer/' Makefile"
su $USR -c "make"
make install
cd ..
ldconfig


cd ..
makeGisDb gis_eu $USR
makeGisDb gis_eu_1000 $USR

wget -O - http://m.m.i24.cc/osmconvert.c | cc -x c - -lz -O3 -o /usr/local/bin/osmconvert

su $USR -c "./get_data_pgis"

cd vodak
su $USR -c "./vodak.py gis_eu > tmp.out"
su $USR -c "psql -d gis_eu < tmp.out"
su $USR -c "unlink tmp.out"
cd ..

cd stylesheets/general/prepare-db

su $USR -c "php ./get-sql.php | psql -d gis_eu"

cd ../../..

cp /usr/share/fonts/truetype/liberation/* /usr/local/lib/mapnik/fonts
