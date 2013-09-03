<?php
  require_once "conf/highway.conf.php";
	require_once "sql/highway.sql.php";
	require_once "conf/sqlite.php";	
?>
<?php if ( $TILE ): ?>
<?php for ( $i = count($ROAD_GRADES[$RENDER_ZOOMS[0]])-1; $i>=0; --$i ):?>
{
	"id": "highway-bridge-layer<?php echo $layer?>-grade-<?php echo $ROAD_GRADES[$RENDER_ZOOMS[0]][$i]?>",
	"name": "highway-bridge-layer<?php echo $layer?>-grade-<?php echo $ROAD_GRADES[$RENDER_ZOOMS[0]][$i]?>",
	"class": "highway road bridge layer<?php echo $layer?> grade<?php echo $ROAD_GRADES[$RENDER_ZOOMS[0]][$i]?>",		
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_highway_bridge($layer,$ROAD_GRADES[$RENDER_ZOOMS[0]][$i]));?>	
},
<?php endfor; ?>

<?php for ( $i = count($ROAD_GRADES[$RENDER_ZOOMS[0]])-1; $i>=0; --$i ):?>
{
	"id": "highway-tunnel-layer<?php echo $layer?>-grade-<?php echo $ROAD_GRADES[$RENDER_ZOOMS[0]][$i]?>",
	"name": "highway-tunnel-layer<?php echo $layer?>-grade-<?php echo $ROAD_GRADES[$RENDER_ZOOMS[0]][$i]?>",
	"class": "highway road tunnel layer<?php echo $layer?> grade<?php echo $ROAD_GRADES[$RENDER_ZOOMS[0]][$i]?>",		
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_highway_tunnel($layer,$ROAD_GRADES[$RENDER_ZOOMS[0]][$i]));?>	
},
<?php endfor; ?>

<?php for ( $i = count($ROAD_GRADES[$RENDER_ZOOMS[0]])-1; $i>=0; --$i ):?>
{
	"id": "highway-pathbridge-layer<?php echo $layer?>-grade-<?php echo $ROAD_GRADES[$RENDER_ZOOMS[0]][$i]?>",
	"name": "highway-pathbridge-layer<?php echo $layer?>-grade-<?php echo $ROAD_GRADES[$RENDER_ZOOMS[0]][$i]?>",
	"class": "highway path bridge layer<?php echo $layer?> grade<?php echo $ROAD_GRADES[$RENDER_ZOOMS[0]][$i]?>",		
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_highway_path_bridge($layer,$ROAD_GRADES[$RENDER_ZOOMS[0]][$i]));?>	
},
<?php endfor; ?>

<?php for ( $i = count($ROAD_GRADES[$RENDER_ZOOMS[0]])-1; $i>=0; --$i ):?>
{
	"id": "highway-pathtunnel-layer<?php echo $layer?>-grade-<?php echo $ROAD_GRADES[$RENDER_ZOOMS[0]][$i]?>",
	"name": "highway-pathtunnel-layer<?php echo $layer?>-grade-<?php echo $ROAD_GRADES[$RENDER_ZOOMS[0]][$i]?>",
	"class": "highway path tunnel layer<?php echo $layer?> grade<?php echo $ROAD_GRADES[$RENDER_ZOOMS[0]][$i]?>",		
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_highway_path_tunnel($layer,$ROAD_GRADES[$RENDER_ZOOMS[0]][$i]));?>	
},
<?php endfor; ?>


{
	"id": "highway-steps-layer<?php echo $layer?>",
	"name": "highway-steps-layer<?php echo $layer?>",
	"class": "highway steps layer<?php echo $layer?>",		
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_highway_steps($layer));?>	
},
<?php for ( $i = count($ROAD_GRADES[$RENDER_ZOOMS[0]])+2; $i>=0; --$i ):?>
<?php if ( $i >=  3 ): ?>
{
	"id": "highway-path-layer<?php echo $layer?>-grade-<?php echo $ROAD_GRADES[$RENDER_ZOOMS[0]][$i-3]?>-stroke",
	"name": "highway-path-layer<?php echo $layer?>-grade-<?php echo $ROAD_GRADES[$RENDER_ZOOMS[0]][$i-3]?>-stroke",
	"class": "highway path layer<?php echo $layer?> grade<?php echo $ROAD_GRADES[$RENDER_ZOOMS[0]][$i-3]?> stroke",		
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_highway_path($layer,$ROAD_GRADES[$RENDER_ZOOMS[0]][$i-3]));?>	
},
{
	"id": "highway-road-layer<?php echo $layer?>-grade-<?php echo $ROAD_GRADES[$RENDER_ZOOMS[0]][$i-3]?>-stroke",
	"name": "highway-road-layer<?php echo $layer?>-grade-<?php echo $ROAD_GRADES[$RENDER_ZOOMS[0]][$i-3]?>-stroke",
	"class": "highway road layer<?php echo $layer?> grade<?php echo $ROAD_GRADES[$RENDER_ZOOMS[0]][$i-3]?> stroke",		
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_highway_road($layer,$ROAD_GRADES[$RENDER_ZOOMS[0]][$i-3]));?>	
},
<?php endif; ?>
<?php if ( $i <  count($ROAD_GRADES[$RENDER_ZOOMS[0]]) ): ?>
{
	"id": "highway-road-layer<?php echo $layer?>-grade-<?php echo $ROAD_GRADES[$RENDER_ZOOMS[0]][$i]?>-fill",
	"name": "highway-road-layer<?php echo $layer?>-grade-<?php echo $ROAD_GRADES[$RENDER_ZOOMS[0]][$i]?>-fill",
	"class": "highway road  layer<?php echo $layer?> grade<?php echo $ROAD_GRADES[$RENDER_ZOOMS[0]][$i]?> fill",		
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_highway_road($layer,$ROAD_GRADES[$RENDER_ZOOMS[0]][$i]));?>	
},
<?php endif; ?>
<?php endfor; ?>
{
	"id": "highway-oneway-layer<?php echo $layer?>",
	"name": "highway-oneway-layer<?php echo $layer?>",
	"class": "highway oneway layer<?php echo $layer?>",		
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_highway_oneway($layer));?>	
},
<?php else: ?>
{
	"id": "highway-major-layer<?php echo $layer?>",
	"name": "highway-major-layer<?php echo $layer?>",
	"class": "highway layer<?php echo $layer?>",	
	"srs": "<?php echo SRS900913?>",	
	<?php echo ds_pgis(sql_highway_norect($layer));?>
}
<?php endif; ?>
<?php if ( $TILE ): ?>
{
	"id": "highway-area-layer<?php echo $layer?>",
	"name": "highway-area-layer<?php echo $layer?>",
	"class": "highwayArea layer<?php echo $layer?>",		
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_highway_area_short($layer));?>	
},
{
	"id": "highwaypoint-layer<?php echo $layer?>",
	"name": "highwaypoint-layer<?php echo $layer?>",
	"class": "highwaypoint layer<?php echo $layer?>",	
	"srs": "<?php echo SRS900913?>",
	<?php echo ds_pgis(sql_highway_point($layer));?>	
}
<?php endif; ?>
