<?php
// $flagNoAuth = true;
require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/reports.class.php');

include ('includes/inc_report_settings.php');

session_start();

$cntID = isset($_GET['cntID'])?(integer)$_GET['cntID']:(isset($_SESSION['cntID'])?$_SESSION['cntID']:33239);//new if not defined
$_SESSION['cntID'] = $cntID;

$budget_scenario = isset($_GET['budget_scenario'])?$_GET['budget_scenario']:$budget_scenario;
$oBudget = new Budget($budget_scenario);

include ('includes/inc_report_pcfilter.php');

// set_time_limit (10);
$arrCounterparty = getCnt($cntID);

function getCnt($cntID, &$arrCounterparty=Array()){
	GLOBAL $oSQL;
	
	$sql = "SELECT cntID, cntTitle$strLocal as cntTitle, cntUserID, usrTitle$strLocal as Sales, cntFlagFolder
		FROM common_db.tbl_counterparty 
		LEFT JOIN stbl_user ON usrID=cntUserID
		WHERE (cntID={$cntID} AND cntFlagFolder=0)
			OR (cntParentCode1C=(SELECT cntCode1C FROM common_db.tbl_counterparty WHERE cntID={$cntID}))
		ORDER BY cntUserID, cntTitle$strLocal";
	// echo "<pre>",$sql,"</pre>";
	$rs = $oSQL->q($sql);
	while ($rw = $oSQL->f($rs)){
		// $arrCnt[] = $rw['cntID'];
		$arrCounterparty['codes'][] = $rw['cntID'];
		// $arrCntTitle[$rw['Sales']][$rw['cntID']] = $rw;
		$arrCounterparty['titles'][$rw['Sales']][$rw['cntID']] = $rw;
		if ($rw['cntFlagFolder']){
			$arrCounterparty = getCnt($rw['cntID'],$arrCounterparty);
		}	
	}
	
	return ($arrCounterparty);
}

if(!isset($_GET['pccGUID'])){

	$arrActions[] = Array ('title'=>'By customer','action'=>"?type=customer");
	$arrActions[] = Array ('title'=>'By activity','action'=>"?type=activity");
	$arrActions[] = Array ('title'=>'By GHQ type','action'=>"?type=ghq");
	$arrActions[] = Array ('title'=>'By BDV staff','action'=>"?type=sales");	
	$arrActions[] = Array ('title'=>'By PC','action'=>"?type=pc");	
	$arrActions[] = Array ('title'=>'By BDV dept','action'=>"?type=bdv");	

	$arrJS[] = 'https://www.google.com/jsapi';
	$arrJS[]='js/rep_pnl.js';
	include ('includes/inc-frame_top.php');
	echo '<h1>',$oBudget->title,' :: ',$arrUsrData["pagTitle$strLocal"],'</h1>';
	
	if (count($arrCounterparty['codes']>1)){
		foreach ($arrCounterparty['titles'] as $sales=>$customers){
			echo '<h4>',($sales?$sales:"Unassigned"),'</h4>';
			echo '<div>';
			foreach ($customers as $id=>$data){
				echo "<span class='".($data['cntFlagFolder']?'folder-open':'')."'>";
				if ($id==$cntID){
					echo $data["cntTitle"];
				} else {
					echo "<a href='{$_SERVER['PHP_SELF']}?cntID={$id}'>",$data["cntTitle"],"</a>";
				}
				echo "</span> | ";
			}
			echo '</div>';
		}
	}
	
	include ('includes/inc_report_selectors.php');
	Budget::getProfitTabs('reg_sales', false, Array('customer'=>$arrCounterparty['codes']));	
	include ('includes/inc-frame_bottom.php');
} else {
	
	include ('includes/inc_report_buttons.php');
	if ($_GET['pccGUID']=='all'){
		$sqlWhere = " WHERE customer IN (".implode(',',$arrCounterparty['codes']).")"; 
	} else {
		$sqlWhere = "WHERE pc in (SELECT pccID FROM vw_profit WHERE pccGUID=".$oSQL->e($_GET['pccGUID']).") AND customer IN (".implode(',',$arrCounterparty['codes']).")";
	}
	
	$filter['customer'] = $arrCounterparty['codes'];	
	
	$oReport = new Reports(Array('budget_scenario'=>$budget_scenario, 'currency'=>$currency, 'denominator'=>$denominator, 'filter'=>$filter));
	
	
	?>
		<div id='graph'/>
	<?php
	// if (strpos($oBudget->type,'FYE')!== false){
	if (false){
		$oReport->monthlyReport($type);	
	} else {
		
		$oReport->periodicPnL($sqlWhere,$type);
		$oReport->salesByActivity($sqlWhere);
		
	}
	// $oReport->periodicPnL($sqlWhere,Array('field_data'=>'activity','field_title'=>'Activity_title','title'=>'Activity'));	
	
}


?>