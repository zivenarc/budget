<?php
$strGridName = ($grid->name? $grid->name : $strGridName);

$arrJS[] = "/common/easyGrid/easyGrid.js";
$arrJS[] = "/common/jquery/tablesorter/jquery.tablesorter.js";	

if ($arrUsrData["FlagUpdate"]){
	if ($arrUsrData["FlagCreate"]){
		$arrActions[] = Array(
		   "title" => ShowFieldTitle('New')
		   , "action" => "javascript:easyGridArrRow('".$strGridName."')"
		   , "class" => "new" 
		);
	}
	$arrActions[] = Array(
	   "title" => ShowFieldTitle('Save')
	   , "action" => "javascript:document.getElementById('".$strGridName."Form').submit()"
	   , "class" => "save"
	);
}
$arrActions[] = Array(
	   "title" => ShowFieldTitle('Print')
	   , "action" => "javascript:window.print()"
	   , "class" => 'print'
);
?>