<?php
$arrActions[] = Array("title" => ShowFieldTitle('Print'), "class" => "print", "action" => "javascript:window.print();");

//------------------------------------------- Determine report scenario ------------------------------------//
if (isset($_GET['budget_scenario'])) {
	$budget_scenario = $_GET['budget_scenario'];
} elseif (isset($_COOKIE['report_scenario'])) {
	$budget_scenario = $_COOKIE['report_scenario'];
} else {
	$budget_scenario = $budget_scenario;
}

SetCookie('report_scenario',$budget_scenario,0,'/budget/');

//------------------------------------------- Determine reference scenario ------------------------------------//
if (isset($_GET['reference'])) {
	$reference = $_GET['reference'];
} elseif (isset($_COOKIE['reference'])) {
	$reference = $_COOKIE['reference'];
} else {
	$reference = null; //--to use default reference from budget settings
}

SetCookie('reference',$reference,0,'/budget/');

//------------------------------------------- Business group ------------------------------------//
if (isset($_GET['bu_group'])) {
	$bu_group = $_GET['bu_group'];
} elseif (isset($_COOKIE['bu_group'])) {
	$bu_group = $_COOKIE['bu_group'];
} else {
	$bu_group = ""; 
}

SetCookie('bu_group',$bu_group,0,'/budget/');

//------------------------------------------- Determine report currency ----------------------------------//
if (isset($_GET['currency'])) {
	$currency = $_GET['currency'];
} elseif (isset($_COOKIE['report_currency'])) {
	$currency = $_COOKIE['report_currency'];
} else {
	$currency = 643;
}
SetCookie('report_currency',$currency,0,'/budget/');

// $arrCurrencySelector = Array(978=>'EUR',840=>'USD',643=>'RUB');
$arrCurrencySelector = Array(978=>'EUR',643=>'RUB');

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

//------------------------------------- denominator -------------------------------------------//
if (isset($_GET['denominator'])) {
	$denominator = $_GET['denominator'];
} elseif (isset($_COOKIE['report_denominator'])){
	$denominator = $_COOKIE['report_denominator'];
} else {
	$denominator = 1000;
}
SetCookie('report_denominator',$denominator,0,'/budget/');

if (isset($_GET['period_type'])) {
	$period_type = $_GET['period_type'];
} elseif (isset($_COOKIE['period_type'])) {
	$period_type = $_COOKIE['period_type'];
} else {
	$period_type = 'ytd';
}


//------------------------------------ Title for report ------------------------------------------//
if($currency!=643){
		$sql = "SELECT * FROM vw_currency WHERE curID={$currency} LIMIT 1";
		$rs = $oSQL->q($sql);
		$rw = $oSQL->f($rs);
		$curTitle = $rw["curTitle$strLocal"];		
} else {
	$curTitle = "RUB";
}

$arrUsrData["pagTitle$strLocal"] .= ': '.$curTitle;
$strCurrencyTitle = $curTitle;

if ($denominator!=1) {
	$arrUsrData["pagTitle$strLocal"] .= ' x'.$denominator;
	$strCurrencyTitle .= ' x'.$denominator;
}



//------------------------------------ Activity filter ------------------------------------------//

if (isset($_GET['activity'])) {
	$activity = $_GET['activity'];
} elseif (isset($_COOKIE['activity'])) {
	$activity = $_COOKIE['activity'];
} else {
	$activity = 'all'; 
}

SetCookie('activity',$activity,0,'/budget/');

if($activity=='all'){
	unset($filter['activity']);
} else {
	$filter['activity'] = $activity;
}

//------------------------- Detail switch ----------------------

if (isset($_GET['repType'])) {
	$repType = $_GET['repType'];
} elseif (isset($_COOKIE['repType'])) {
	$repType = $_COOKIE['repType'];
} else {
	$activity = 'item'; 
}

SetCookie('repType',$repType,0,'/budget/');


?>