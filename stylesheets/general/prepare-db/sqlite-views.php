<?php

$definitions = array (
	'highway' => array (
		'filter' => array('highway'),
		'tags' => array (
			'highway'      => 'text',
			'ref'          => 'text',
			'int_ref'      => 'text',
			'bridge'       => 'text',
			'tunnel'       => 'text',
			'construction' => 'text',
			'junction'     => 'text',
			'smoothness'   => 'text',
			'surface'      => 'text',
			'layer'        => 'integer',
			'tracktype'    => 'text'
		),
		'table' => 'way'
		
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
			'tracktype'    => 'text'
		),
		'table' => 'way'		
	),
	'landcover' => array(
		'filter' => array('natural','landuse','leisure','amenity','sport'),
		'tags' => array (
			'natural' => 'text',
			'landuse' => 'text',
			'leisure' => 'text',
			'amenity' => 'text',
			'sport'   => 'text',			
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
	'aerialway' => array(
		'filter' => array('aerialway'),
		'tags' => array (
			'aerialway'    => 'text',
			'"piste:lift"' => 'text',
			'layer'        => 'integer',
			'bridge'       => 'text',
			'tunnel'       => 'text',
		),
		'table' => 'way'
	),
	'aerialway_point' => array(
		'filter' => array('aerialway'),
		'tags' => array (
			'aerialway'    => 'text',
			'"piste:lift"' => 'text',
			'layer'        => 'integer',
			'bridge'       => 'text',
			'tunnel'       => 'text',
		),
		'table' => 'node'
	),
	'barrier' => array(
		'filter' => array('barrier'),
		'tags' => array (
			'barrier'    => 'text',
			'layer'      => 'integer',
			'bridge'     => 'text',
			'tunnel'     => 'text',
		),
		'table' => 'way'
	),
	'adminboundary' => array(
		'filter' => array('admin_level'),		
		'tags' => array (
			'admin_level'  => 'integer',			
			'layer'        => 'integer',
		),
		'table' => 'way'
	),
	'building' => array(
		'filter' => array('building'),
		'tags' => array (
			'building'  => 'text',
			'bridge'    => 'text',
			'tunnel'    => 'text',
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
		'table' => 'way'
	),
);

?>

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
		,CAST((SELECT v FROM ntag NT2 WHERE NT2.id = N.id AND NT2.k = '<?php echo $tag ?>' LIMIT 1) AS <?php echo $type ?>) AS <?php echo $tag ?>
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
		,Area(Transform(BuildArea(W.geom),900913)) AS way_area
	<?php endif ?>
	<?php foreach ( $def['tags'] as $tag => $type ): ?>
		<?php if ( $def['table'] == 'rel' ): ?>			
			,CAST(
				COALESCE(
					(SELECT v FROM rtag RT2 WHERE RT2.id = RW.rel_id AND RT2.k = '<?php echo $tag ?>' LIMIT 1),
					(SELECT v FROM wtag WT2 WHERE WT2.id = W.id AND WT2.k = '<?php echo $tag ?>' LIMIT 1)
				)
			AS <?php echo $type ?>) AS <?php echo $tag ?> 		
		<?php else:	?>
			,CAST((SELECT v FROM wtag WT2 WHERE WT2.id = W.id AND WT2.k = '<?php echo $tag ?>' LIMIT 1) AS <?php echo $type ?>) AS <?php echo $tag ?>
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
WHERE W.is_rel = 0  AND IsValid(W.geom) AND NOT IsEmpty(W.geom) AND NOT NumPoints(W.geom) < 4
<?php endif; ?>
GROUP BY WT.id)
<?php if ( $def['table'] == 'polygon' ): ?>
UNION
SELECT * FROM 
(SELECT
	P.id AS osm_id,
	P.geom AS way,	
	Area(Transform(BuildArea(P.geom),900913)) AS way_area	
	<?php foreach ( $def['tags'] as $tag => $type ): ?>
		,CAST((SELECT v FROM rtag RT2 WHERE RT2.id = P.id AND RT2.k = '<?php echo $tag ?>' LIMIT 1) AS <?php echo $type ?>) AS <?php echo $tag ?> 
	<?php endforeach; ?>
FROM polygon P
JOIN rtag RT ON RT.id = P.id AND RT.k IN 
	( 
		<?php echo implode(',',array_map(function($x) { return "'".$x."'";},$def['filter'])) ?>
	)
WHERE P.is_rel = 1 AND IsValid(P.geom) AND NOT IsEmpty(P.geom) AND NOT NumPoints(P.geom) < 4
GROUP BY RT.id)
<?php endif; ?>
;
<?php endif; ?>
<?php endforeach; ?>

