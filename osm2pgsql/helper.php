<?php
if ( !defined('ROOT') ) {
	define('ROOT',dirname(dirname(__FILE__)));

	set_include_path (        
		get_include_path() . PATH_SEPARATOR .
		ROOT . '/stylesheets/general/'
	);
}

function createTable($name,$function,$indexes = array(),$spatialIndexes = array('way')) {	
	$sql = $function();
	foreach( $indexes as $index) {
		echo "DROP INDEX IF EXISTS i__{$name}__{$index};\n";
	}
	foreach( $spatialIndexes as $index) {
		echo "DROP INDEX IF EXISTS i__{$name}__{$index};\n";
	}
	echo "DROP TABLE IF EXISTS $name;\n";
	echo "CREATE TABLE $name AS $sql;\n";
	foreach( $spatialIndexes as $index) {
		echo "CREATE INDEX i__{$name}__{$index} ON $name USING GIST ( $index );\n";
	}
	foreach( $indexes as $index) {
		echo "CREATE INDEX i__{$name}__{$index} ON $name ( $index );\n";
	}
	
	
}
