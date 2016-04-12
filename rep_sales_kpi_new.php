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

include ('includes/inc_report_pcfilter.php');

$sql = "SELECT cntID, cntTitle$strLocal, cntUserID, usrTitle$strLocal as Sales
		FROM common_db.tbl_counterparty 
		LEFT JOIN stbl_user ON usrID=cntUserID
		WHERE cntID={$cntID} 
			OR cntParentCode1C=(SELECT cntCode1C FROM common_db.tbl_counterparty WHERE cntID={$cntID})
		ORDER BY cntUserID, cntTitle$strLocal";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	$arrCnt[] = $rw['cntID'];
	$arrCntTitle[$rw['Sales']][] = $rw["cntTitle$strLocal"];
}

if(!isset($_GET['pccGUID'])){

	$arrActions[] = Array ('title'=>'By activity','action'=>"?type=activity");
	$arrActions[] = Array ('title'=>'By GHQ type','action'=>"?type=ghq");
	$arrActions[] = Array ('title'=>'By BDV staff','action'=>"?type=sales");	
	$arrActions[] = Array ('title'=>'By PC','action'=>"?type=pc");	
	$arrActions[] = Array ('title'=>'By BDV dept','action'=>"?type=bdv");	

	$arrJS[] = 'https://www.google.com/jsapi';
	$arrJS[]='js/rep_pnl.js';
	include ('includes/inc-frame_top.php');
	echo '<h1>',$oBudget->title,' :: ',$arrUsrData["pagTitle$strLocal"],'</h1>';
	
	if (count($arrCnt>1)){
		foreach ($arrCntTitle as $sales=>$customers){
			echo '<h2>',($sales?$sales:"Unassigned"),'</h2>';
			echo '<p>',implode(', ',$customers),'</p>';
		}
	}
	
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
	
	$filter['customer'] = $arrCnt;	
	
	$oReport = new Reports(Array('budget_scenario'=>$budget_scenario, 'currency'=>$currency, 'denominator'=>$denominator, 'filter'=>$filter));
	
	
	?>
		<div id='graph'/>
	<?php
	if ($oBudget->type=='FYE'){
		$oReport->monthlyReport($type);	
	} else {
		$oReport->periodicPnL($sqlWhere,Array('field_data'=>'prtGHQ','field_title'=>'prtGHQ','title'=>'GHQ'));	
		$oReport->salesByActivity($sqlWhere);
	}
	// $oReport->periodicPnL($sqlWhere,Array('field_data'=>'activity','field_title'=>'Activity_title','title'=>'Activity'));	
	
}


?>