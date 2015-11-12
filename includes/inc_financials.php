<?php
	require_once ('classes/reports.class.php');
	$sqlWhere= "WHERE source='".$oDocument->GUID."'";	
	$oReport = new Reports(Array('budget_scenario'=>$oDocument->budget->id));
	$oReport->masterByActivity($sqlWhere);
	$oReport->masterByYACT($sqlWhere);
	die();
?>