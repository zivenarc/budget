<?php
// $flagNoAuth = true;
require ('common/auth.php');
require ('classes/reports.class.php');
include ('includes/inc_report_settings.php');

$oBudget = new Budget($budget_scenario);
if ($reference!=$oBudget->reference_scenario->id){
	$oReference = new Budget($reference);
	$strVsTitle = ' vs '.$oReference->title;
} else {
	$reference = $oBudget->reference_scenario->id;
}

include ('includes/inc_report_pcfilter.php'); /// filter and tabs for Business unit

if(!isset($_GET['pccGUID'])){

	// $arrJS[] = 'https://www.google.com/jsapi';
	
	$arrJS[]="https://code.highcharts.com/highcharts.js";
	$arrJS[]="https://code.highcharts.com/highcharts-more.js";
	$arrJS[]="https://code.highcharts.com/modules/exporting.js";
	
	$arrJS[]='js/rep_pnl.js';
	// $arrJS[]='js/input_form.js';	
	
	// $arrActions[] = Array ('title'=>'By customer group','action'=>"?type=customer_group");
	// $arrActions[] = Array ('title'=>'By customer','action'=>"?type=customer");
	// $arrActions[] = Array ('title'=>'By activity','action'=>"?type=activity");
	// $arrActions[] = Array ('title'=>'By GHQ type','action'=>"?type=ghq");
	// $arrActions[] = Array ('title'=>'By BDV staff','action'=>"?type=sales");
	// $arrActions[] = Array ('title'=>'By PC','action'=>"?type=pc");
		
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,$strVsTitle,'</h1>';
	include ('includes/inc_report_selectors.php');
	echo '<p>',$oBudget->timestamp,'; ',$oBudget->rates,'</p>';
	
	Budget::getProfitTabs('reg_master', !$flagNoAuth, Array('pccID'=>$arrBus));
	
	include ('includes/inc-frame_bottom.php');
} else {

	// include ('includes/inc_report_buttons.php');
	
	// $sqlWhere .= " AND scenario='$budget_scenario'";
	$oReport = new Reports(Array('budget_scenario'=>$budget_scenario, 'currency'=>$currency, 'denominator'=>$denominator,'reference'=>$reference, 'filter'=>$filter));
	
	$oReport->periodicGraph();

}


?>