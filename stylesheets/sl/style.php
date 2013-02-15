<?php
	if ( !defined('ROOT') ) {
		define('ROOT',dirname(dirname(__FILE__)));
	
		set_include_path (        
			get_include_path() . PATH_SEPARATOR .
			ROOT . '/sl/' . PATH_SEPARATOR .
			ROOT . '/general/'
		);
	}
		
	require_once ROOT.'/general/style.php';
?>
