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
	
	$arrActions[] = Array ('title'=>'By customer group','action'=>"?type=customer_group");
	$arrActions[] = Array ('title'=>'By customer','action'=>"?type=customer");
	$arrActions[] = Array ('title'=>'By activity','action'=>"?type=activity");
	$arrActions[] = Array ('title'=>'By GHQ type','action'=>"?type=ghq");
	$arrActions[] = Array ('title'=>'By BDV staff','action'=>"?type=sales");
	$arrActions[] = Array ('title'=>'By PC','action'=>"?type=pc");
	$arrActions[] = Array ('title'=>'By BDV dept','action'=>"?type=bdv");
		
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
	
	$oReport->periodicPnL($type);
}


?>