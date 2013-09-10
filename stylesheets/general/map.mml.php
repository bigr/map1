<?php
	if ( !defined('ROOT') ) {
		define('ROOT',dirname(dirname(__FILE__)));
	
		set_include_path (        
			get_include_path() . PATH_SEPARATOR .
			ROOT . '/general/'
		);
	}
	
	require_once "inc/projections.php";
	require_once "conf/common.conf.php";
?>
{
	"meta-writer": [
		{
			"name": "points",
			"type": "json",
			"file": "[tile_dir]/[z]/[x]/[y].json",
			"pixel-coordinates": "true",
			"output-empty": "true",
			"default-output": "name"
		}
	],
		
	"Stylesheet": [
	
		"style/~_common.mss"
		<?php if ( $RENDER_LANDCOVER ): ?>
			,"style/~landcover.mss"
		<?php endif; ?>
		<?php if ( $RENDER_ACCESSAREA ): ?>
			,"style/~accessarea.mss"
		<?php endif; ?>	
		<?php if ( $RENDER_COUNTRYFILL ): ?>
			,"style/~countryfill.mss"
		<?php endif; ?>	
		<?php if ( $RENDER_BUILDING ): ?>
			,"style/~building.mss"
		<?php endif; ?>
		<?php if ( $RENDER_BOUNDARY ): ?>
			,"style/~boundary.mss"
		<?php endif; ?>
		<?php if ( $RENDER_WAY ): ?>			
			<?php if ( $RENDER_WATERS ): ?>
				,"style/~waters.mss"
			<?php endif; ?>
			<?php if ( $RENDER_AEROWAY ): ?>
				,"style/~aeroway.mss"
			<?php endif; ?>
			<?php if ( $RENDER_PISTEWAY ): ?>
				,"style/~pisteway.mss"
			<?php endif; ?>
			<?php if ( $RENDER_HIGHWAY ): ?>
				,"style/~highway.mss"
			<?php endif; ?>
			<?php if ( $RENDER_RAILWAY ): ?>
				,"style/~railway.mss"
			<?php endif; ?>
			<?php if ( $RENDER_BARRIER ): ?>
				,"style/~barrier.mss"
			<?php endif; ?>
			<?php if ( $RENDER_POWER ): ?>
				,"style/~power.mss"
			<?php endif; ?>
			<?php if ( $RENDER_AERIALWAY ): ?>
				,"style/~aerialway.mss"
			<?php endif; ?>			
		<?php endif; ?>
		<?php if ( $RENDER_CONTOUR ): ?>
			,"style/~contour.mss"
		<?php endif; ?>
		<?php if ( $RENDER_FISHNET ): ?>
			,"style/~fishnet.mss"
		<?php endif; ?>
		<?php if ( $RENDER_ROUTE ): ?>
			,"style/~route.mss"
		<?php endif; ?>	
		<?php if ( $RENDER_FERRY ): ?>
			,"style/~ferry.mss"
		<?php endif; ?>	
		
		
		<?php if ( $RENDER_TEXT ): ?>
			<?php if ( $RENDER_SYMBOL ): ?>
				,"style/~symbol.mss"
			<?php endif; ?>		
			<?php if ( $RENDER_TEXT_PLACE ): ?>
				,"style/~text-place.mss"
			<?php endif; ?>
			<?php if ( $RENDER_SHIELD_PEAK ): ?>
				,"style/~shield-peak.mss"
			<?php endif; ?>
			<?php if ( $RENDER_TEXT_SYMBOL ): ?>
				,"style/~text-symbol.mss"
			<?php endif; ?>
			<?php if ( $RENDER_TEXT_ROUTE ): ?>
				,"style/~text-route.mss"
			<?php endif; ?>			
			<?php if ( $RENDER_TEXT_HIGHWAY ): ?>
				,"style/~text-highway.mss"
			<?php endif; ?>
			<?php if ( $RENDER_TEXT_AERIALWAY ): ?>
				,"style/~text-railway.mss"
			<?php endif; ?>
			<?php if ( $RENDER_TEXT_AERIALWAY ): ?>
				,"style/~text-aerialway.mss"
			<?php endif; ?>
			<?php if ( $RENDER_TEXT_WATERS ): ?>
				,"style/~text-waters.mss"
			<?php endif; ?>
			<?php if ( $RENDER_TEXT_LANDCOVER ): ?>
				,"style/~text-landcover.mss"
			<?php endif; ?>
			<?php if ( $RENDER_TEXT_BUILDING ): ?>
				,"style/~text-building.mss"
			<?php endif; ?>
			<?php if ( $RENDER_TEXT_BOUNDARY ): ?>
				,"style/~text-boundary.mss"
			<?php endif; ?>
			<?php if ( $RENDER_TEXT_CONTOUR ): ?>
				,"style/~text-contour.mss"
			<?php endif; ?>			
		<?php endif; ?>
		<?php if ( $RENDER_COUNTRYTEXT ): ?>
			,"style/~countrytext.mss"
		<?php endif; ?>	
		<?php if ( $RENDER_GRIDINFO ): ?>
			,"style/~gridinfo.mss"
		<?php endif; ?>
	],
	
	"Layer": [
		
		<?php
			$first = true;
			
			if ( $RENDER_LANDCOVER ) {
				if ( !$first ) echo ','; $first = false;
				require "layer/landcover.mml.php";
			}
			
			if ( $RENDER_ACCESSAREA ) {
				if ( !$first ) echo ','; $first = false;
				require "layer/accessarea.mml.php";
			}
			
			if ( $RENDER_COUNTRYFILL ) {
				if ( !$first ) echo ','; $first = false;
				require "layer/countryfill.mml.php";
			}
			
			if ( $RENDER_BUILDING ) {
				if ( !$first ) echo ','; $first = false;
				require "layer/building.mml.php";
			}
			
			if ( $RENDER_BOUNDARY ) {
				if ( !$first ) echo ','; $first = false;
				require "layer/boundary.mml.php";
			}
			
			if ( $RENDER_ROUTE ) {
				if ( !$first ) echo ','; $first = false;
				require "layer/route.mml.php";
			}
			
			if ( $RENDER_WAY ) {			
				foreach ($RENDER_LAYERS as $layer) {
					
					if ( $RENDER_WATERS ) {
						if ( !$first ) echo ','; $first = false;
						require "layer/waters.mml.php";
					}
					if ( $RENDER_PISTEWAY && $TILE ) {
						if ( !$first ) echo ','; $first = false;
						require "layer/pisteway.mml.php";
					}
					if ( $RENDER_AEROWAY && $TILE ) {
						if ( !$first ) echo ','; $first = false;
						require "layer/aeroway.mml.php";
					}					
					if ( $RENDER_HIGHWAY ) {
						if ( !$first ) echo ','; $first = false;
						require "layer/highway.mml.php";
					}
					if ( $RENDER_RAILWAY && $TILE ) {
						if ( !$first ) echo ','; $first = false;
						require "layer/railway.mml.php";
					}
					if ( $RENDER_BARRIER && $TILE ) {
						if ( !$first ) echo ','; $first = false;
						require "layer/barrier.mml.php";
					}
					if ( $RENDER_POWER && $TILE ) {
						if ( !$first ) echo ','; $first = false;
						require "layer/power.mml.php";
					}					
					if ( $RENDER_AERIALWAY && $TILE ) {
						if ( !$first ) echo ','; $first = false;
						require "layer/aerialway.mml.php";
					}
					if ( $RENDER_WATERS ) {
						if ( !$first ) echo ','; $first = false;
						require "layer/watersymbols.mml.php";
					}
				}
			}
			
			if ( $RENDER_FERRY ) {
				if ( !$first ) echo ','; $first = false;
				require "layer/ferry.mml.php";
			}
									
			if ( $RENDER_CONTOUR ) {
				if ( !$first ) echo ','; $first = false;
				require "layer/contour.mml.php";
			}
			
			if ( $RENDER_FISHNET ) {
				if ( !$first ) echo ','; $first = false;
				require "layer/fishnet.mml.php";
			}						
			
														
			if ( $RENDER_TEXT ) {
				$clearCache = true;
				foreach (array_merge($RENDER_TEXT_PRIORITIES ,array(-1)) as $priority) {					
					if ( $RENDER_TEXT_PLACE ) {
						if ( !$first ) echo ','; $first = false;
						require "layer/text-place.mml.php";
					}
					if ( $RENDER_SYMBOL && $TILE ) {
						if ( !$first ) echo ','; $first = false;
						require "layer/symbol.mml.php";
					}										
					if ( $RENDER_SHIELD_PEAK && $TILE  ) {
						if ( !$first ) echo ','; $first = false;
						require "layer/shield-peak.mml.php";
					}					
					if ( $RENDER_TEXT_ROUTE && $TILE  ) {
						if ( !$first ) echo ','; $first = false;
						require "layer/text-route.mml.php";
					}
					if ( $RENDER_TEXT_HIGHWAY && $TILE  ) {
						if ( !$first ) echo ','; $first = false;
						require "layer/text-highway.mml.php";
					}
					if ( $RENDER_TEXT_RAILWAY && $TILE  ) {
						if ( !$first ) echo ','; $first = false;
						require "layer/text-railway.mml.php";
					}
					if ( $RENDER_TEXT_AERIALWAY && $TILE  ) {
						if ( !$first ) echo ','; $first = false;
						require "layer/text-aerialway.mml.php";
					}
					if ( $RENDER_TEXT_WATERS ) {
						if ( !$first ) echo ','; $first = false;
						require "layer/text-waters.mml.php";
					}
					if ( $RENDER_TEXT_LANDCOVER  && $TILE ) {
						if ( !$first ) echo ','; $first = false;
						require "layer/text-landcover.mml.php";
					}
					if ( $RENDER_TEXT_BOUNDARY && $TILE ) {
						if ( !$first ) echo ','; $first = false;
						require "layer/text-boundary.mml.php";
					}
					if ( $RENDER_TEXT_BUILDING && $TILE  ) {
						if ( !$first ) echo ','; $first = false;
						require "layer/text-building.mml.php";
					}
					if ( $RENDER_TEXT_SYMBOL && $TILE  ) {
						if ( !$first ) echo ','; $first = false;
						require "layer/text-symbol.mml.php";
					}
					if ( $RENDER_TEXT_CONTOUR && $TILE  ) {
						if ( !$first ) echo ','; $first = false;
						require "layer/text-contour.mml.php";
					}										
				}
			}
			
			
			
			if ( $RENDER_COUNTRYTEXT ) {
				if ( !$first ) echo ','; $first = false;
				require "layer/countrytext.mml.php";
			}
			
			if ( $RENDER_GRIDINFO ) {
				if ( !$first ) echo ','; $first = false;
				require "layer/gridinfo.mml.php";
			}
		?>
	],
	"srs": "<?php echo SRS900913?>"
}
