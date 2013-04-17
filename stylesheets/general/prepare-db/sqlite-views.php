<?php

$highway_tags = array (
			'highway'       => 'text',
			'ref'           => 'text',
			'int_ref'       => 'text',
			'bridge'        => 'text',
			'tunnel'        => 'text',
			'construction'  => 'text',
			'junction'      => 'text',
			'smoothness'    => 'text',
			'surface'       => 'text',
			'layer'         => 'integer',
			'tracktype'     => 'text',
			'service'       => 'text',
			'area'          => 'text',
			'access'        => 'text',
			'foot'          => 'text',
			'ski'           => 'text',
			'ski:nordic'    => 'text',
			'ski:alpine'    => 'text',
			'ski:telemark'  => 'text',	
			'inline_skates' => 'text',		
			'ice_skates'    => 'text',
			'horse'         => 'text',
			'vehicle'       => 'text',
			'bicycle'       => 'text',
			'carriage'      => 'text',
			'trailer'       => 'text',
			'caravan'       => 'text',
			'motor_vehicle' => 'text',
			'motorcycle'    => 'text',
			'moped'         => 'text',
			'mofa'          => 'text',
			'motorcar'      => 'text',
			'motorhome'     => 'text',
			'psv'           => 'text',
			'bus'           => 'text',
			'taxi'          => 'text',
			'tourist_bus'   => 'text',
			'goods'         => 'text',
			'hgv'           => 'text',
			'agricultural'  => 'text',
			'ATV'           => 'text',
			'snowmobile'    => 'text',
			'name'          => 'text',
			'oneway'        => 'text',
		);

$definitions = array (
	'highway' => array (
		'filter' => array('highway'),
		'tags' => $highway_tags,
		'table' => 'way'
		
	),
	
	'highway_area' => array (
		'filter' => array('highway'),
		'tags' => $highway_tags,
		'table' => 'polygon'		
	),
	
	'highway_text' => array (
		'filter' => array('highway'),
		'tags' => array (
			'highway'      => 'text',
			'ref'          => 'text',
			'int_ref'      => 'text',
			'name'         => 'text',
			'bridge'       => 'text',
			'tunnel'       => 'text',
			'construction' => 'text',
			'junction'     => 'text',
			'smoothness'   => 'text',
			'surface'      => 'text',			
			'tracktype'    => 'text',
			'area'         => 'text',
		),
		'table' => 'way'		
	),
	'highway_point' => array(
		'filter' => array('highway'),
		'tags' => array (
			'highway'      => 'text',
			'construction' => 'text',
			'ref'          => 'text',			
			'layer'        => 'integer',
		),
		'table' => 'node'
	),	
	'landcover' => array(
		'filter' => array('natural','landuse','leisure','amenity','place','power','tourism','historic'),
		'tags' => array (
			'natural'  => 'text',
			'place'    => 'text',
			'landuse'  => 'text',
			'leisure'  => 'text',
			'amenity'  => 'text',
			'sport'    => 'text',
			'name'     => 'text',
			'wood'     => 'text',
			'type'     => 'text',
			'religion' => 'text',
			'building' => 'text',
			'power'    => 'text',
			'tourism'  => 'text',
			'historic' => 'text',
			'area'     => 'text',
		),
		'table' => 'polygon'
	),
	'landcover_line' => array(
		'filter' => array('natural','landuse','leisure','amenity'),
		'tags' => array (
			'natural' => 'text',
			'landuse' => 'text',
			'leisure' => 'text',
			'amenity' => 'text',
			'sport'   => 'text',
			'name'    => 'text',
			'wood'    => 'text',
			'type'    => 'text',
		),
		'table' => 'way'
	),
	'landcover_point' => array(
		'filter' => array('natural','landuse','leisure','amenity'),
		'tags' => array (
			'natural' => 'text',
			'landuse' => 'text',
			'leisure' => 'text',
			'amenity' => 'text',
			'sport'   => 'text',
			'name'    => 'text',
			'wood'    => 'text',
			'type'    => 'text',
		),
		'table' => 'node'
	),
	'paboundary' => array(
		'filter' => array('boundary','landuse','military','leisure'),
		'tags' => array(
			'boundary'         => 'text',
			'landuse'          => 'text',
			'military'         => 'text',
			'protect_class'    => 'integer',
			'name'             => 'text',
			'leisure'          => 'text',
			'protection_title' => 'text',
			'iucn_level'       => 'text',
		),
		'table' => 'polygon'
	),	
	'waterarea' => array(
		'filter' => array('waterway','landuse','natural'),
		'tags' => array (
			'natural'  => 'text',
			'landuse'  => 'text',
			'waterway' => 'text',
			'name'     => 'text',
			'layer'    => 'integer',
			'bridge'   => 'text',
			'tunnel'   => 'text',
			'building' => 'text',
		),
		'table' => 'polygon'
	),
	'waterarea_text' => array(
		'filter' => array('waterway','landuse','natural'),
		'tags' => array (
			'natural'  => 'text',
			'landuse'  => 'text',
			'waterway' => 'text',
			'name'     => 'text',			
			'building' => 'text',
		),
		'table' => 'polygon'
	),
	'railway' => array(
		'filter' => array('railway'),
		'tags' => array (
			'railway'      => 'text',
			'ref'          => 'text',
			'bridge'       => 'text',
			'tunnel'       => 'text',
			'construction' => 'text',
			'layer'        => 'integer',
			'usage'        => 'text',
			'service'      => 'text'
		),
		'table' => 'way'
	),	
	'aeroway' => array(
		'filter' => array('aeroway'),
		'tags' => array(
			'aeroway'   => 'text',
			'surface'   => 'text',
			'layer'     => 'integer',
			'name'      => 'text',
			'bridge'    => 'text',
			'tunnel'    => 'text',
			'area'      => 'text',
		),
		'table' => 'way'
	),
	'aeroarea' => array(
		'filter' => array('aeroway'),
		'tags' => array(
			'aeroway'   => 'text',
			'surface'   => 'text',
			'layer'     => 'integer',
			'name'      => 'text',		
			'bridge'    => 'text',
			'tunnel'    => 'text',
			'area'      => 'text',
		),
		'table' => 'polygon'
	),
	'aerialway' => array(
		'filter' => array('aerialway'),
		'tags' => array (
			'aerialway'    => 'text',
			'piste:lift'   => 'text',
			'layer'        => 'integer',
			'name'         => 'text',
			'bridge'       => 'text',
			'tunnel'       => 'text',
		),
		'table' => 'way'
	),
	'aerialway_point' => array(
		'filter' => array('aerialway'),
		'tags' => array (
			'aerialway'    => 'text',
			'piste:lift' => 'text',
			'layer'        => 'integer',
			'bridge'       => 'text',
			'tunnel'       => 'text',
		),
		'table' => 'node'
	),
	'pisteway' => array(
		'filter' => array('piste:type'),
		'tags' => array (
			'piste:type'       => 'text',
			'piste:difficulty' => 'text',
			'piste:grooming'   => 'integer',
			'piste:name'       => 'text',	
			'layer'            => 'integer',
			'bridge'           => 'text',
			'tunnel'           => 'text',
			'area'             => 'text',
		),
		'table' => 'way'
	),
	'pistearea' => array(
		'filter' => array('piste:type'),
		'tags' => array (
			'piste:type'       => 'text',
			'piste:difficulty' => 'text',
			'piste:grooming'   => 'integer',
			'piste:name'       => 'text',
			'layer'            => 'integer',
			'bridge'           => 'text',			
			'tunnel'           => 'text',
			'area'             => 'text',
		),
		'table' => 'polygon'
	),
	'barrier' => array(
		'filter' => array('barrier'),
		'tags' => array (
			'barrier'    => 'text',
			'layer'      => 'integer',
			'bridge'     => 'text',
			'tunnel'     => 'text',
			'area'       => 'text',
		),
		'table' => 'way'
	),
	'adminboundary' => array(
		'filter' => array('admin_level'),		
		'tags' => array (
			'admin_level'  => 'integer',			
			'layer'        => 'integer',
			'name'         => 'text',
		),
		'table' => 'way'
	),
	'building' => array(
		'filter' => array('building'),
		'tags' => array (
			'building'  => 'text',
			'bridge'    => 'text',
			'tunnel'    => 'text',	
			'name'      => 'text',		
		),
		'table' => 'polygon'
	),
	'power' => array(
		'filter' => array('power'),
		'tags' => array (
			'power'        => 'text',
			'construction' => 'text',
			'bridge'       => 'text',
			'tunnel'       => 'text',
			'layer'        => 'integer',
		),
		'table' => 'way'
	),
	'power_point' => array(
		'filter' => array('power'),
		'tags' => array (
			'power'        => 'text',
			'construction' => 'text',
			'bridge'       => 'text',
			'tunnel'       => 'text',
			'layer'        => 'integer',
		),
		'table' => 'node'
	),
	'barrier_point' => array(
		'filter' => array('barrier'),
		'tags' => array (
			'barrier'      => 'text',
			'construction' => 'text',
			'bridge'       => 'text',
			'tunnel'       => 'text',
			'layer'        => 'integer',
			'name'         => 'text',
		),
		'table' => 'node'
	),		
	'water_point' => array(
		'filter' => array('waterway'),
		'tags' => array (
			'waterway'        => 'text',
			'construction' => 'text',
			'bridge'       => 'text',
			'tunnel'       => 'text',
			'layer'        => 'integer',
			'name'         => 'text',
		),
		'table' => 'node'
	),		
	'access_area' => array(
		'filter' => array('access'),
		'tags' => array (
			'access' => 'text',
			'name' => 'text'
		),
		'table' => 'polygon'
	)
);

?>

SELECT load_extension('libspatialite.so');

REPLACE INTO spatial_ref_sys (srid, auth_name, auth_srid, ref_sys_name, proj4text) values (900913,'EPSG',900913,'Google Maps Global Mercator','+proj=merc +a=6378137 +b=6378137 +lat_ts=0.0 +lon_0=0.0 +x_0=0.0 +y_0=0 +k=1.0 +units=m +nadgrids=@null +no_defs');

<?php foreach ( $definitions as $name => $def  ): ?>
DROP VIEW IF EXISTS <?php echo $name ?>;
CREATE VIEW <?php echo $name ?> AS
SELECT * FROM 
<?php if ( "node" == $def['table'] ):?>
(
SELECT
	N.id AS osm_id,
	N.geom AS way
	<?php foreach ( $def['tags'] as $tag => $type ): ?>
		,CAST((SELECT v FROM ntag NT2 WHERE NT2.id = N.id AND NT2.k = '<?php echo $tag ?>' LIMIT 1) AS <?php echo $type ?>) AS "<?php echo $tag ?>"
	<?php endforeach; ?>
FROM <?php echo $def['table']?> N
JOIN ntag NT ON NT.id = N.id AND NT.k IN
	(
		<?php echo implode(',',array_map(function($x) { return "'".$x."'";},$def['filter'])) ?>
	)
WHERE IsValid(N.geom) AND NOT IsEmpty(N.geom)
GROUP BY NT.id
);
<?php else: ?>
(
SELECT
	W.id AS osm_id,
	W.geom AS way
	<?php if ( $def['table'] == 'polygon' ): ?>
		,Area(Transform(W.geom,900913)) AS way_area
	<?php endif ?>
	<?php foreach ( $def['tags'] as $tag => $type ): ?>
		<?php if ( $def['table'] == 'rel' ): ?>			
			,CAST(
				COALESCE(
					(SELECT v FROM rtag RT2 WHERE RT2.id = RW.rel_id AND RT2.k = '<?php echo $tag ?>' LIMIT 1),
					(SELECT v FROM wtag WT2 WHERE WT2.id = W.id AND WT2.k = '<?php echo $tag ?>' LIMIT 1)
				)
			AS <?php echo $type ?>) AS "<?php echo $tag ?>"
		<?php else:	?>
			,CAST((SELECT v FROM wtag WT2 WHERE WT2.id = W.id AND WT2.k = '<?php echo $tag ?>' LIMIT 1) AS <?php echo $type ?>) AS "<?php echo $tag ?>"
		<?php endif; ?>
	<?php endforeach; ?>
<?php if ( $def['table'] == 'rel' ): ?>		
FROM rel_way RW
JOIN way W ON W.id = RW.way_id
<?php else:	?>
	FROM <?php echo $def['table']?> W
<?php endif; ?>
JOIN <?php echo $def['table'] == 'rel' ? 'rtag' : 'wtag'  ?> WT ON WT.id = W.id AND WT.k IN 
	( 
		<?php echo implode(',',array_map(function($x) { return "'".$x."'";},$def['filter'])) ?>
	)
<?php if ( $def['table'] == 'polygon' ): ?>
WHERE W.is_rel = 0  AND IsValid(W.geom) AND NOT IsEmpty(W.geom)
<?php endif; ?>
GROUP BY WT.id)
<?php if ( $def['table'] == 'polygon' ): ?>
UNION
SELECT * FROM 
(SELECT
	P.id AS osm_id,
	P.geom AS way,	
	Area(Transform(P.geom,900913)) AS way_area	
	<?php foreach ( $def['tags'] as $tag => $type ): ?>
		,CAST((SELECT v FROM rtag RT2 WHERE RT2.id = P.id AND RT2.k = '<?php echo $tag ?>' LIMIT 1) AS <?php echo $type ?>) AS "<?php echo $tag ?>"
	<?php endforeach; ?>
FROM polygon P
JOIN rtag RT ON RT.id = P.id AND RT.k IN 
	( 
		<?php echo implode(',',array_map(function($x) { return "'".$x."'";},$def['filter'])) ?>
	)
WHERE P.is_rel = 1 AND IsValid(P.geom) AND NOT IsEmpty(P.geom)
GROUP BY RT.id)
<?php endif; ?>
;
<?php endif; ?>
<?php endforeach; ?>

