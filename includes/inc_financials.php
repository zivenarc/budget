<?php
	require_once ('classes/reports.class.php');
	$sqlWhere= "WHERE source='".$oDocument->GUID."'";			
	Reports::masterByActivity($sqlWhere);
	Reports::masterByYACT($sqlWhere);
	die();
?>