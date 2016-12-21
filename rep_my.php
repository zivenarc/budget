<?php
// $flagNoAuth = true;
// $arrUsrData['usrID'] = 'ZHAROVA';

require ('common/auth.php');


$ownerID = isset($_GET['ownerID'])?$_GET['ownerID']:($_COOKIE['ownerID']?$_COOKIE['ownerID']:$arrUsrData['usrID']);
if ($_GET['ownerID']=='MYSELF'){
	$ownerID = $arrUsrData['usrID'];
}
SetCookie('ownerID',$ownerID,0);

require ('classes/budget.class.php');
require ('classes/reports.class.php');
include ('includes/inc_report_settings.php');

$oBudget = new Budget($budget_scenario);

include ('includes/inc_report_pcfilter.php');

$arrJS[]='js/rep_pnl.js';
// $arrJS[]='js/input_form.js';	

include('includes/inc_group_buttons.php');

if(isset($currency)){
		$sql = "SELECT * FROM vw_currency WHERE curID={$currency} LIMIT 1";
		$rs = $oSQL->q($sql);
		$rw = $oSQL->f($rs);
		echo '<h2>',$rw["curTitle$strLocal"],'</h2>';
}

$sql = "SELECT * FROM stbl_user WHERE usrID=".$oSQL->e($ownerID);
$rs = $oSQL->q($sql);
$rw = $oSQL->f($rs);
$arrUsrData["pagTitle$strLocal"] = 'Sales by '.($rw['usrTitle']?$rw['usrTitle']:'<Unknown>');
	
	
if(!isset($_GET['pccGUID'])){
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,'</h1>';
	echo '<p>',$oBudget->timestamp,'; ',$oBudget->rates,'</p>';
	include ('includes/inc_report_selectors.php');
	
	Budget::getProfitTabs('reg_sales', false, Array('customer'=>$arrCounterparty['codes']));
	
	include ('includes/inc_subordinates.php');

	include ('includes/inc-frame_bottom.php');
} else {
	
	include ('includes/inc_report_buttons.php');
	
	$sqlWhere = "WHERE sales = ".$oSQL->e($ownerID);
	
	if ($_GET['pccGUID']=='all'){
		
	} else {
		$sqlWhere .= " AND pc in (SELECT pccID FROM vw_profit WHERE pccGUID=".$oSQL->e($_GET['pccGUID']).")";
	}
	
	$oReport = new Reports(Array('budget_scenario'=>$budget_scenario, 'reference'=>$reference,'currency'=>$currency, 'denominator'=>$denominator, 'filter'=>Array('sales'=>$ownerID)));

	if (strpos($oBudget->type,'FYE')!==false){
		$oReport->monthlyReport($type);
	} else {
		$oReport->periodicPnL($sqlWhere,$type);

		?>
		<h2>KPI</h2>
		<?php
		$oReport->salesByCustomer(' and sales='.$oSQL->e($ownerID));
	}
	
}
?>