<?php
require_once "inc/utils.php";
require_once "conf/pgis.php";
require_once "conf/sqlite.php";
require_once "conf/aerialway.conf.php";
require_once "sql/_common.sql.php";


function sql_aerialway($where = '1 = 1',$order = 'z_order') {
	global $AERIALWAY;
	$layerSql = _getLayerSql();
	$propertyWhereQuery = getPropertyWhereQuery($AERIALWAY);
return <<<EOD
    SELECT
	way,
	aerialway,
	    COALESCE("piste:lift",'no') AS
	"piste:lift",
	    $layerSql as 
	layer,
	name,
	osm_id
    FROM aerialway
    WHERE
		    ($propertyWhereQuery)
	    AND ($where)
EOD;
}

function sql_aerialway_short($layer,$where = '1 = 1',$order = 'z_order') {
    return "SELECT * FROM aerialways WHERE layer = $layer";
}

function sql_aerialway_text($priority,$where = '1 = 1',$order = 'z_order') {
    $layerSql = _getLayerSql();
    return "
	SELECT way,name,osm_id,'' AS difficulty FROM aerialway WHERE COALESCE(name,'') <> ''
	UNION
	SELECT way,COALESCE(name,\"piste:name\") AS name,osm_id,\"piste:difficulty\" AS difficulty FROM pisteway WHERE  COALESCE(name,'') <> ''
    ";
}


function sql_aerialpoint($cols = '0',$where = '1 = 1',$order = 'z_order') {
	$layerSql = _getLayerSql();
return <<<EOD
    SELECT
	way,	  
	aerialway,
	    COALESCE("piste:lift",'no') AS
	"piste:lift",
	(($layerSql) - 1) AS layer,
	osm_id,
	$cols
    FROM aerialpoint
    WHERE
	    aerialway IN ('pylon')
	AND ($where)
EOD;
}


function sql_aerialpoint_short($layer, $cols = '0',$where = '1 = 1',$order = 'z_order') {
    return "SELECT * FROM aerialpoints WHERE layer = $layer";
}
