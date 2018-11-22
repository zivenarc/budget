<?php
$flagNoAuth = true;
require ('common/auth.php');
require ('classes/reports.class.php');
include ('includes/inc_report_settings.php');
include ('includes/inc_report_pcfilter.php');


$arrJS[]="https://code.highcharts.com/highcharts.js";
// $arrJS[]="https://code.highcharts.com/modules/drilldown.js";
$arrJS[]="https://code.highcharts.com/highcharts-more.js";
$arrJS[]="https://code.highcharts.com/modules/exporting.js";

if(!isset($_GET['pccGUID'])){
	$oBudget = new Budget($budget_scenario);
	// if ($reference!=$oBudget->reference_scenario->id){
		// $oReference = new Budget($reference);
		// $strVsTitle = ' vs '.$oReference->title;
	// } else {
		// $reference = $oBudget->reference_scenario->id;
	// }
	
	$arrJS[]='js/rep_pnl.js';
	// $arrJS[]='js/input_form.js';	
	
	include('includes/inc_group_buttons.php');	
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,$strVsTitle,'</h1>';	
	include ('includes/inc_report_selectors.php');
	echo '<p>',$oBudget->timestamp,'; ',$oBudget->rates,'</p>';
	
	Budget::getProfitTabs('reg_master', true, Array('pccID'=>$arrBus));
	?>
	<script>
		//$('#reference').attr('disabled',true);		
	</script>
	<?php
	include ('includes/inc-frame_bottom.php');
} else {
	
	// include ('includes/inc_report_buttons.php');
	
	$oReport = new Reports(Array('budget_scenario'=>$budget_scenario, 'currency'=>$currency, 'denominator'=>$denominator,'reference'=>$reference,'filter'=>$filter));
	$oReport->yearRatio();
}


?>