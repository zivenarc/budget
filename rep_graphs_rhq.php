<?php
// $flagNoAuth = true;
require ('common/auth.php');
require ('classes/reports.class.php');
include ('includes/inc_report_settings.php');
include ('includes/inc_report_ghqfilter.php');

$oBudget = new Budget($budget_scenario);
if ($reference!=$oBudget->reference_scenario->id){
	$oReference = new Budget($reference);
	$strVsTitle = ' vs '.$oReference->title;
} else {
	$reference = $oBudget->reference_scenario->id;
}


if(!isset($_GET['prtGHQ'])){

	$arrJS[]="https://code.highcharts.com/highcharts.js";
	$arrJS[]="https://code.highcharts.com/highcharts-more.js";
	$arrJS[]="https://code.highcharts.com/modules/exporting.js";
	
	$arrJS[]='js/rep_pnl.js';
		
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,$strVsTitle,'</h1>';
	include ('includes/inc_report_selectors.php');
	echo '<p>',$oBudget->timestamp,'; ',$oBudget->rates,'</p>';
	
	$oBudget->getGHQTabs();
	
	include ('includes/inc-frame_bottom.php');
} else {
	
	
	$oReport = new Reports(Array('budget_scenario'=>$budget_scenario, 'currency'=>$currency, 'denominator'=>$denominator,'reference'=>$reference, 'filter'=>$filter));
	$oReport->periodicGraph(Array('title'=>$_GET['prtGHQ']));

}


?>