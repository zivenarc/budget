<?php
// $flagNoAuth = true;
require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/reports.class.php');

include ('includes/inc_report_settings.php');

session_start();

$cntID = isset($_GET['cntID'])?(integer)$_GET['cntID']:(isset($_SESSION['cntID'])?$_SESSION['cntID']:31153);//new if not defined
$_SESSION['cntID'] = $cntID;

$budget_scenario = isset($_GET['budget_scenario'])?$_GET['budget_scenario']:$budget_scenario;
$oBudget = new Budget($budget_scenario);
$oReport = new Reports(Array('budget_scenario'=>$budget_scenario, 'currency'=>$currency, 'denominator'=>$denominator));

$sql = "SELECT cntID, cntTitle$strLocal FROM common_db.tbl_counterparty WHERE cntID={$cntID} OR cntParentCode1C=(SELECT cntCode1C FROM common_db.tbl_counterparty WHERE cntID={$cntID})";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	$arrCnt[] = $rw['cntID'];
	$arrCntTitle[] = $rw["cntTitle$strLocal"];
}

if(!isset($_GET['pccGUID'])){
	$arrJS[] = 'https://www.google.com/jsapi';
	$arrJS[]='js/rep_pnl.js';
	include ('includes/inc-frame_top.php');
	echo '<h1>',$oBudget->title,' :: ',$arrUsrData["pagTitle$strLocal"],'</h1>';
	
	echo '<h2>',implode(', ',$arrCntTitle),'</h2>';
	
	?>
	<div class='f-row'><label for='budget_scenario'>Select scenario</label><?php echo Budget::getScenarioSelect();?></div>
	<?php
	Budget::getProfitTabs('reg_sales', false, Array('customer'=>$arrCnt));	
	include ('includes/inc-frame_bottom.php');
} else {
	
	include ('includes/inc_report_buttons.php');
	if ($_GET['pccGUID']=='all'){
		$sqlWhere = " WHERE customer IN (".implode(',',$arrCnt).")"; 
	} else {
		$sqlWhere = "WHERE pc in (SELECT pccID FROM vw_profit WHERE pccGUID=".$oSQL->e($_GET['pccGUID']).") AND customer IN (".implode(',',$arrCnt).")";
	}

	$oReport->salesByActivity($sqlWhere);
	?>
		<div id='graph'/>
	<?php	
	$oReport->periodicPnL($sqlWhere,Array('field_data'=>'prtGHQ','field_title'=>'prtGHQ','title'=>'GHQ'));	
	// $oReport->periodicPnL($sqlWhere,Array('field_data'=>'activity','field_title'=>'Activity_title','title'=>'Activity'));	
	
}


?>