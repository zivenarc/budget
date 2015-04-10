<?php
//------------------------------------------- Determine report scenario ------------------------------------//
if (isset($_GET['budget_scenario'])) {
	$budget_scenario = $_GET['budget_scenario'];
} elseif (isset($_COOKIE['report_scenario'])) {
	$budget_scenario = $_COOKIE['report_scenario'];
} else {
	$budget_scenario = $budget_scenario;
}

SetCookie('report_scenario',$budget_scenario,0,'/budget/');

//------------------------------------------- Determine report currency ----------------------------------//
if (isset($_GET['currency'])) {
	$currency = $_GET['currency'];
} elseif (isset($_COOKIE['report_currency'])) {
	$currency = $_COOKIE['report_currency'];
} else {
	$currency = 643;
}
SetCookie('report_currency',$currency,0,'/budget/');

//------------------------------------- type of report details -------------------------------------------//
if (isset($_GET['type'])){
	$type = $_GET['type'];
	SetCookie('pnl_type',$type,0,'/budget/');
} elseif (isset($_COOKIE['pnl_type'])) {
	$type = $_COOKIE['pnl_type'];
} else {
	switch ($_GET['pccGUID']){
		case 'f865db6b-d328-102e-9d25-5de97ba9df63':
		case 'f865e1de-d328-102e-9d25-5de97ba9df63':
		case '48b5ae6c-e650-11de-959c-00188bc729d2':
			$type = 'activity';			
			break;
		case 'all':
			$type = 'ghq';			
		break;
		case 'f865e855-d328-102e-9d25-5de97ba9df63':
			$type = 'customer';
			//$sqlWhere = "WHERE (pc in (SELECT pccID FROM vw_profit WHERE pccGUID=".$oSQL->e($_GET['pccGUID']).") OR (customer=9907 AND Group_code=94))";
		default:
			$type = 'customer';			
			break;
	}
}
SetCookie('pnl_type',$type,0,'/budget/');

if (isset($_GET['denominator'])) {
	$denominator = $_GET['denominator'];
} elseif (isset($_COOKIE['report_denominator'])){
	$denominator = $_COOKIE['report_denominator'];
} else {
	$denominator = 1;
}
SetCookie('report_denominator',$denominator,0,'/budget/');

?>