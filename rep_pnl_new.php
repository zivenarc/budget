<?php
require ('common/auth.php');
require ('classes/budget.class.php');

$bdv = isset($_GET['bdv'])?$_GET['bdv']:($_COOKIE['bdv']?$_COOKIE['bdv']:$arrUsrData['usrProfitID']);
if ($_GET['bdv']=='MYSELF'){
	$bdv = $arrUsrData['usrProfitID'];
}
SetCookie('bdv',$bdv,0);


include ('includes/inc_report_settings.php');
include ('includes/inc_report_pcfilter.php');

if(!isset($_GET['pccGUID'])){
	$oBudget = new Budget($budget_scenario);
	
	/// Prepare data for the report
	$sql = Array();
	$sql[] = "UPDATE reg_master SET `new`=1 WHERE customer IN (SELECT cntID FROM tbl_unknown)";
	$sql[] = "UPDATE reg_sales SET `new`=1 WHERE customer IN (SELECT cntID FROM tbl_unknown)";
	$sql[] = "UPDATE reg_master SET `new`=1 WHERE item IN ('7bfcd52d-50ad-11e5-b3b1-00155d010e0b','b2e02fdd-803a-11e4-b3b1-00155d010e0b')";
	for ($i=0;$i<count($sql);$i++){
		$oSQL->q($sql[$i]);
	};
	
	$arrJS[]='js/rep_pnl.js';
	// $arrJS[]='js/input_form.js';	
	
	include('includes/inc_group_buttons.php');	
	
	
	if($bdv){
		$sql = "SELECT * FROM common_db.tbl_profit WHERE pccID=".$oSQL->e($bdv);
		$rs = $oSQL->q($sql);
		$arrBDV = $oSQL->f($rs);
		$arrUsrData["pagTitle$strLocal"] .= 'Sales by '.($arrBDV['pccTitle']?$arrBDV['pccTitle']:'<Unknown>');
	}
	
	$arrDefaultParams = Array('currency'=>643,'period_type'=>'cm','denominator'=>1000,'bu_group'=>'');
	$strQuery = http_build_query($arrDefaultParams);
	$arrActions[] = Array('title'=>'NSD','action'=>'?bdv=9&type=bu_group&'.$strQuery);
	$arrActions[] = Array('title'=>'JSD','action'=>'?bdv=130&type=bu_group&'.$strQuery);
	
	
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,$strVsTitle,'</h1>';
	echo '<h2>Reference to actual periods not available</h2>';
	include ('includes/inc_report_selectors.php');
	echo '<p>',$oBudget->timestamp,'; ',$oBudget->rates,'</p>';
	
	Budget::getProfitTabs('reg_master', true, Array('pccID'=>$arrBus));
	?>
	<script>
		$('#reference').attr('disabled',true);		
	</script>
	<?php
	include ('includes/inc-frame_bottom.php');
} else {
	require ('classes/reports.class.php');
	include ('includes/inc_report_buttons.php');
	
	$filter['new'] = true;
	$filter['bdv'] = $bdv;
		
	$oReport = new Reports(Array('budget_scenario'=>$budget_scenario, 'currency'=>$currency, 'denominator'=>$denominator,'reference'=>$budget_scenario,'filter'=>$filter));
	// echo '<pre>';print_r($filter);echo '</pre>';
	$oReport->periodicPnL($type);
}


?>