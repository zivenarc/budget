<?php
// $flagNoAuth = true;
// $arrUsrData['usrID'] = 'ZHAROVA';

require ('common/auth.php');


$bdv = isset($_GET['bdv'])?$_GET['bdv']:($_COOKIE['bdv']?$_COOKIE['bdv']:$arrUsrData['usrProfitID']);
if ($_GET['bdv']=='MYSELF'){
	$bdv = $arrUsrData['usrProfitID'];
}
SetCookie('bdv',$bdv,0);

require ('classes/budget.class.php');
require ('classes/reports.class.php');
include ('includes/inc_report_settings.php');

$oBudget = new Budget($budget_scenario);

include ('includes/inc_report_pcfilter.php');

$arrJS[]='js/rep_pnl.js';
// $arrJS[]='js/input_form.js';	

include('includes/inc_group_buttons.php');

$sql = "SELECT * FROM common_db.tbl_profit WHERE pccID=".$oSQL->e($bdv);
$rs = $oSQL->q($sql);
$rw = $oSQL->f($rs);
$arrUsrData["pagTitle$strLocal"] = 'Sales by '.($rw['pccTitle']?$rw['pccTitle']:'<Unknown>');

$arrDefaultParams = Array('currency'=>643,'period_type'=>'cm','denominator'=>1000,'bu_group'=>'');
$strQuery = http_build_query($arrDefaultParams);

$arrActions[] = Array('title'=>'NSD','action'=>'?bdv=9&type=bu_group&'.$strQuery);
$arrActions[] = Array('title'=>'JSD','action'=>'?bdv=130&type=bu_group&'.$strQuery);
	
if(!isset($_GET['pccGUID'])){
	
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,'</h1>';

	echo '<p>',$oBudget->timestamp,'; ',$oBudget->rates,'</p>';
	include ('includes/inc_report_selectors.php');

	Budget::getProfitTabs('reg_sales', false, Array('bdv'=>$bdv));

	include ('includes/inc-frame_bottom.php');

} else {
	$sqlWhere = "WHERE bdv = ".$oSQL->e($bdv);

	if ($_GET['pccGUID']=='all'){
		
	} else {
		$sqlWhere .= " AND pc in (SELECT pccID FROM vw_profit WHERE pccGUID=".$oSQL->e($_GET['pccGUID']).")";
	}
	
	$filter['bdv'] = $bdv;
	
	$oReport = new Reports(Array('budget_scenario'=>$budget_scenario, 'reference'=>$reference,'currency'=>$currency, 'denominator'=>$denominator, 'filter'=>$filter));
	
	if (strpos($oBudget->type,'FYE')!==false){
		$oReport->monthlyReport($type);
	} else {
		$oReport->periodicPnL($type);

		?>
		<h2>KPI</h2>
		<?php
		$oReport->salesByCustomer(' and bdv='.$oSQL->e($bdv));
	}
}
?>