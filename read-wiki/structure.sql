CREATE TABLE "wiki" (
"id" BIGINT PRIMARY KEY,
"title" VARCHAR(511),
"name" VARCHAR(511),
"infobox" VARCHAR(127),
"status" VARCHAR(127),
"ele" INT,
"population" INT,
"cats" VARCHAR(1023),
"osm_id" BIGINT
);
SELECT AddGeometryColumn('wiki', 'way', 900913, 'POINT', 2);
