<?php
// $flagNoAuth = true;
require ('common/auth.php');
require ('classes/budget.class.php');
include ('includes/inc_report_settings.php');
include ('includes/inc_report_pcfilter.php');


// echo '<pre>';print_r($filter);echo '</pre>';

if(!isset($_GET['pccGUID'])){
	
	if(!isset($_GET['activity']) || $_GET['activity']=='all'){
		$sql = "SELECT prtID FROM common_db.tbl_product_type WHERE prtGHQ LIKE 'Ocean%'";
		$rs = $oSQL->q($sql);
		while ($rw = $oSQL->f($rs)){
			$filter['activity'][] = $rw['prtID'];
		}
	} else {
		$sql = "SELECT prtTitle FROM common_db.tbl_product_type WHERE prtID=".(integer)$_GET['activity'];
		$strSubtitle = $oSQL->get_data($sql);
		$filter['activity']=(integer)$_GET['activity'];
	}
	SetCookie('activity',serialize($filter['activity']),0);
	
	$oBudget = new Budget($budget_scenario);
	if ($reference!=$oBudget->reference_scenario->id){
		$oReference = new Budget($reference);
		$strVsTitle = ' vs '.$oReference->title;
	} else {
		$reference = $oBudget->reference_scenario->id;
	}
	
	$arrJS[]='js/rep_pnl.js';
	// $arrJS[]='js/input_form.js';	
	
	include('includes/inc_group_buttons.php');	
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,$strVsTitle,'</h1>';
	echo $strSubtitle?'<h2>'.$strSubtitle.'</h2>':'';
	include ('includes/inc_report_selectors.php');
	echo '<p>',$oBudget->timestamp,'; ',$oBudget->rates,'</p>';
	
	Budget::getProfitTabs('reg_master', true, Array('pccID'=>$arrBus));
	
	include ('includes/inc-frame_bottom.php');
} else {
	require ('classes/reports.class.php');
	include ('includes/inc_report_buttons.php');
	
	$filter['activity']=unserialize($_COOKIE['activity']);
	
	$oReport = new Reports(Array('budget_scenario'=>$budget_scenario, 'currency'=>$currency, 'denominator'=>$denominator,'reference'=>$reference,'filter'=>$filter));
	
	$oReport->productivityReport();
}


?>