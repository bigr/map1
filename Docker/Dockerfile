FROM ubuntu:18.04

ENV TZ=Europe/Prague
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update && apt-get install -y \  
	wget \
	git \	
	python \
	python-dev \
	python-nose \
	python-pip \
	libboost-filesystem-dev \
    libboost-program-options-dev \
    libboost-python-dev \
    libboost-regex-dev \
    libboost-system-dev \
    libboost-thread-dev \    
    libicu-dev \
    libxml2 \
    libxml2-dev \
    libfreetype6 \
    libfreetype6-dev \
    libjpeg-dev \
    libpng-dev \
    libproj-dev \
    libtiff-dev \
    libcairo2 \
    libcairo2-dev \
    python-cairo \
    python-cairo-dev \
    libcairomm-1.0-1v5 \
    libcairomm-1.0-dev \
    ttf-unifont \
    ttf-dejavu \
    ttf-dejavu-core \
    ttf-dejavu-extra \
    git build-essential \    
    libgdal-dev \
    python-gdal \
    postgresql-10 \
    postgresql-server-dev-10 \
    postgresql-contrib-10 \
    postgis \
    libsqlite3-dev \
    osm2pgsql \
    npm \
    uthash-dev \
    sqlite3 \
    spatialite-bin \
    gdal-bin \
    fonts-liberation

RUN pip2 install --upgrade pip
RUN pip2 install psycopg2 pysqlite

RUN cd /tmp && \
	git clone https://github.com/mapnik/mapnik mapnik-2.3.x -b 2.3.x --depth 10 && \
	cd mapnik-2.3.x && \
	./configure && \
	make && \
	make install && \	
	ldconfig && \
	rm -rf /tmp/mapnik-2.3.x
	
	
RUN npm install --global millstone carto

RUN wget -O - http://m.m.i24.cc/osmconvert.c | cc -x c - -lz -O3 -o /usr/local/bin/osmconvert

RUN cd /tmp && \
	git clone https://github.com/bigr/o5mreader && \
	cd o5mreader && \
	./configure && \
	make && \
	make install && \
	ldconfig && \
	rm -rf /tmp/o5mreader
	
	
RUN cd /tmp && \
	git clone https://github.com/bigr/o5m2sqlite && \
	cd o5m2sqlite && \
	./configure && \
	make && \
	make install && \	
	ldconfig && \
	rm -rf /tmp/o5msqlite

RUN cp /usr/share/fonts/truetype/liberation/* /usr/local/lib/mapnik/fonts

RUN cd /root && \
	git clone https://github.com/bigr/map1.git && \
	chmod -R 777 /root/map1
	

RUN /etc/init.d/postgresql start && \
	cd /root/map1 && \
	git pull && \
	chmod -R 777 /root/map1 && \
	su postgres -c "createdb -E UTF8 -O postgres gis_eu" && \	
	su postgres -c "psql gis_eu -c \"CREATE EXTENSION postgis;\"" && \
	su postgres -c "psql gis_eu -c \"CREATE EXTENSION hstore;\"" && \
	su postgres -c "createdb -E UTF8 -O postgres gis_eu_1000" && \
	su postgres -c "psql gis_eu_1000 -c \"CREATE EXTENSION postgis;\"" && \
	su postgres -c "psql gis_eu_1000 -c \"CREATE EXTENSION hstore;\"" && \
	cd /root/map1 && \	 
	su postgres -c "./get_data_pgis"
	
RUN	/etc/init.d/postgresql start && \
	cd /root/map1 && \
	git pull && \
	cd /root/map1/vodak && \
	su postgres -c "./vodak.py gis_eu > /tmp/vodak.sql" && \
	su postgres -c "psql -d gis_eu < vodak.sql" && \
	unlink /tmp/vodak.sql
	
RUN	cd /root/map1/stylesheets/general/prepare-db && \
	cd /root/map1 && \
	git pull && \
	su postgres -c "php ./get-sql.php | psql -d gis_eu"

COPY srtm /root/map1/data/dem/
	
	
