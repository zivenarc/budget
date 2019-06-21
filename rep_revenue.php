<?php
$flagNoAuth = true;
require ('common/auth.php');
require_once ('classes/reports.class.php');
include ('includes/inc_report_settings.php');

$oBudget = new Budget($budget_scenario);
$oReference = new Budget($reference);

include ('includes/inc_report_pcfilter.php');

$arrJS[]='js/rep_pnl.js';
// $arrJS[]='js/input_form.js';	

include('includes/inc_group_buttons.php');

$arrDefaultParams = Array('currency'=>643,'period_type'=>'cm','denominator'=>1000,'bu_group'=>'');
$strQuery = http_build_query($arrDefaultParams);

if(!isset($_GET['pccGUID'])){
	
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,'</h1>';

	echo '<p>',$oBudget->timestamp,'; ',$oBudget->rates,'</p>';
	include ('includes/inc_report_selectors.php');

	Budget::getProfitTabs('reg_sales', false);

	include ('includes/inc-frame_bottom.php');

} else {

	$oReport = new Reports(Array('budget_scenario'=>$budget_scenario, 'reference'=>$reference,'currency'=>$currency, 'denominator'=>$denominator, 'filter'=>$filter));
	
	$oReport->revenueByCustomer();
	
	
}
?>