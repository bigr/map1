print """
UPDATE wiki W
SET osm_id = P.osm_id
FROM planet_osm_point P
WHERE 
      P.place IN ('city','town','village','hamlet','isolated_dwelling','suburb','neighbourhood')
  AND COALESCE(W.name,W.title) = P.name
  AND ST_DWithin(W.way,P.way,3000)
  AND W.population IS NOT NULL;
  
UPDATE wiki W
SET osm_id = P.osm_id
FROM planet_osm_point P
WHERE 
      P.natural = 'peak'
  AND W.infobox = 'hora'
  AND (
       (ST_DWithin(W.way,P.way,300) AND COALESCE(W.name,W.title) = P.name)
    OR (ST_DWithin(W.way,P.way,100) AND (W.name IS NULL OR P.name IS NULL))
    OR ST_DWithin(W.way,P.way,30)
  );
  
UPDATE wiki W
SET osm_id = P.osm_id
FROM
  (      SELECT osm_id,name,way,historic FROM planet_osm_point
   UNION SELECT osm_id,name,way,historic FROM planet_osm_polygon) P
WHERE 
      P.historic IN ('castle','ruins')
  AND (
	   W.infobox in ('Hrad','hrad')
    OR W.cats LIKE ('%Hrady %')
    OR W.cats LIKE ('%Z_mky %')
    OR W.cats LIKE ('%Z__ceniny hrad_ %')
  )
  AND (
       (ST_DWithin(W.way,P.way,2000) AND COALESCE(W.name,W.title) = P.name)    
    OR ST_DWithin(W.way,P.way,200)
  );

UPDATE wiki W
SET osm_id = P.osm_id
FROM
  (      SELECT osm_id,name,way,historic FROM planet_osm_point
   UNION SELECT osm_id,name,way,historic FROM planet_osm_polygon) P
WHERE 
      P.historic IN ('castle','ruins')
  AND (
	   W.infobox in ('Hrad','hrad')
    OR W.cats LIKE ('%Hrady %')
    OR W.cats LIKE ('%Z_mky %')
    OR W.cats LIKE ('%Tvrze %')
    OR W.cats LIKE ('%Z__ceniny hrad_ %')
  )
  AND (
       (ST_DWithin(W.way,P.way,2000) AND COALESCE(W.name,W.title) = P.name)    
    OR ST_DWithin(W.way,P.way,200)
  );


UPDATE wiki W
SET osm_id = P.osm_id
FROM
  (      SELECT osm_id,name,way,amenity FROM planet_osm_point
   UNION SELECT osm_id,name,way,amenity FROM planet_osm_polygon) P
WHERE 
      P.amenity = 'place_of_worship'
  AND (
	   W.infobox in ('kostel','Kostel')
    OR W.cats LIKE ('%Kostely %')
    OR W.cats LIKE ('%Kaple %')
    OR W.cats LIKE ('%Kl__tery %')
    OR W.cats LIKE ('%Me_ity %')
    OR W.cats LIKE ('%Synagogy %')
    
  )
  AND (
       (ST_DWithin(W.way,P.way,750) AND COALESCE(W.name,W.title) = P.name)    
    OR ST_DWithin(W.way,P.way,100)
  );

UPDATE wiki W
SET osm_id = P.osm_id
FROM
  (      SELECT osm_id,name,way,amenity FROM planet_osm_point
   UNION SELECT osm_id,name,way,amenity FROM planet_osm_polygon) P
WHERE 
      P.amenity = 'theatre'
  AND (
       W.cats LIKE ('%Divadla %')    
  )
  AND (
       (ST_DWithin(W.way,P.way,500) AND COALESCE(W.name,W.title) = P.name)    
    OR ST_DWithin(W.way,P.way,100)
  );


UPDATE wiki W
SET osm_id = P.osm_id
FROM
  (      SELECT osm_id,name,way,tourism FROM planet_osm_point
   UNION SELECT osm_id,name,way,tourism FROM planet_osm_polygon) P
WHERE 
      P.tourism IN ('museum','gallery')
  AND (
          W.cats LIKE ('%Muzea %')
       OR W.cats LIKE ('%Galerie %')   
  )
  AND (
       (ST_DWithin(W.way,P.way,500) AND COALESCE(W.name,W.title) = P.name)    
    OR ST_DWithin(W.way,P.way,100)
  );
  
UPDATE wiki W
SET osm_id = P.osm_id
FROM
  (      SELECT osm_id,name,way,historic FROM planet_osm_point
   UNION SELECT osm_id,name,way,historic FROM planet_osm_polygon) P
WHERE 
      P.historic IN ('memorial','monument')
  AND (
          W.cats LIKE ('%Pomn_ky a pam_tn_ky %')       
  )
  AND (
       (ST_DWithin(W.way,P.way,500) AND COALESCE(W.name,W.title) = P.name)    
    OR ST_DWithin(W.way,P.way,100)
  );


UPDATE wiki W
SET natural = 'peak'
WHERE W.infobox = 'hora';
 
UPDATE wiki W
SET
  historic = 'castle',
  castle_type = (CASE
    WHEN W.cats LIKE ('%Hrady %') OR W.cats LIKE ('%Z__ceniny hrad_ %') THEN 'defensive'
    WHEN W.cats LIKE ('%Z_mky %') THEN 'stately'
    ELSE NULL    
  END),
  ruins = (CASE
    WHEN W.cats LIKE ('%Z__ceniny %') THEN 1
    ELSE NULL
  END)
WHERE
     W.infobox in ('Hrad','hrad')
  OR W.cats LIKE ('%Hrady %')
  OR W.cats LIKE ('%Z_mky %')
  OR W.cats LIKE ('%Z__ceniny hrad_ %');
  
UPDATE wiki W
SET
  amenity = 'place_of_worship',
  religion = (CASE
    WHEN W.cats LIKE ('%Me_ity %') THEN 'christian'
    WHEN W.cats LIKE ('%Synagogy %') THEN 'jewish'
    ELSE 'muslim'    
  END),
  place_of_worship = (CASE
    WHEN W.cats LIKE ('%Kaple %') THEN 'chapel'
    WHEN W.cats LIKE ('%Kl__tery %') THEN 'monastery'
    ELSE 'church'    
  END)
WHERE    
     W.infobox in ('kostel','Kostel')
  OR W.cats LIKE ('%Kostely %')
  OR W.cats LIKE ('%Kaple %')
  OR W.cats LIKE ('%Kl__tery %')
  OR W.cats LIKE ('%Me_ity %')
  OR W.cats LIKE ('%Synagogy %');

UPDATE wiki W
SET amenity = 'theatre'
WHERE 
  W.cats LIKE ('%Divadla %');

UPDATE wiki W
SET tourism = 'museum'
WHERE 
     W.cats LIKE ('%Muzeua %')  
  OR W.cats LIKE ('%Galerie %');


UPDATE wiki W
SET nkp = 1
WHERE 
    W.cats LIKE ('%N_rodn_ kulturn_ p_m_tky %');
    
UPDATE wiki W
SET kp = 1
WHERE 
    W.cats LIKE ('%Kulturn_ p_m_tky %');
 

"""
