<?php
require ('common/auth.php');
require ('classes/budget.class.php');

include ('includes/inc_report_settings.php');
include ('includes/inc_report_pcfilter.php');

if(!isset($_GET['pccGUID'])){
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
	include ('includes/inc_report_selectors.php');
	echo '<p>',$oBudget->timestamp,'; ',$oBudget->rates,'</p>';
	
	Budget::getProfitTabs('reg_master', true, Array('pccID'=>$arrBus));
	
	include ('includes/inc-frame_bottom.php');
} else {
	require ('classes/reports.class.php');
	include ('includes/inc_report_buttons.php');
	
	$oReport = new Reports(Array('budget_scenario'=>$budget_scenario, 'currency'=>$currency, 'denominator'=>$denominator,'reference'=>$reference,'filter'=>$filter));
	// echo '<pre>';print_r($filter);echo '</pre>';
	$oReport->periodicPnL($type);
}


?>