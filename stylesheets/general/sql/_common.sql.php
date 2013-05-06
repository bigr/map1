<?php
require_once "conf/pgis.php";

function _isBridgeSql() {
	return "(bridge IS NOT NULL AND bridge IN ('yes','true','1','viaduct'))";
}

function _isTunnelSql() {
	return "tunnel IS NOT NULL AND tunnel IN ('culvert','yes','true','1')";
}

function _getLayerSql() {
	$isBridgeSql = _isBridgeSql();
	$isTunnelSql = _isTunnelSql();
	return "	
		(
			CASE 
				WHEN layer IN ('-5','-4','-3','-2','-1','0','1','2','3','4','5') THEN CAST(round(CAST(layer AS float)) AS integer)
				WHEN $isBridgeSql THEN 1
				WHEN $isTunnelSql THEN -1
				ELSE 0
			END
		)
	";
}

function _getnewLayerSql() {
	$isBridgeSql = _isBridgeSql();
	$isTunnelSql = _isTunnelSql();
	return "	
		COALESCE(
			layer,
			CASE 				
				WHEN $isBridgeSql THEN 1
				WHEN $isTunnelSql THEN -1
				ELSE 0
			END
		)
	";
}
