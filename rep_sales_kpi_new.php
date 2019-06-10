<?php
// $flagNoAuth = true;
require ('common/auth.php');
require ('classes/reports.class.php');
require ('classes/waterfall.class.php');
include ('includes/inc_report_settings.php');

session_start();

if(isset($_GET['cntID'])){
	$_SESSION['cntFilterMode'] = 'counterparty';	
}
$cntID = isset($_GET['cntID'])?(integer)$_GET['cntID']:(isset($_SESSION['cntID'])?$_SESSION['cntID']:743);//new if not defined
$_SESSION['cntID'] = $cntID;

if(isset($_GET['catID'])){
	$_SESSION['cntFilterMode'] = 'category';	
}
$catID = isset($_GET['catID'])?(integer)$_GET['catID']:(isset($_SESSION['catID'])?$_SESSION['catID']:158021);//new if not defined
$_SESSION['catID'] = $catID;

$budget_scenario = isset($_GET['budget_scenario'])?$_GET['budget_scenario']:$budget_scenario;
$oBudget = new Budget($budget_scenario);

include ('includes/inc_report_pcfilter.php');

// set_time_limit (10);
if($_SESSION['cntFilterMode'] == 'category'){
	$sql = "SELECT catTitle FROM common_db.tbl_category WHERE catID='{$catID}';";
	$rs = $oSQL->q($sql);
	$strFilterSubtitle = "Category= ".$oSQL->get_data($rs);
	print_r($catID);
	$arrCounterparty = getCategory($catID);
} else {	
	$arrCounterparty = getCnt($cntID);
}
$filter['customer'] = $arrCounterparty['codes'];

if(!isset($_GET['pccGUID'])){
	include('includes/inc_group_buttons.php');	
	$arrActions[] = Array('title'=>'Category','class'=>'fa-filter','action'=>'javascript:showCategoryList();');
	$arrJS[]='js/rep_pnl.js';
	include ('includes/inc-frame_top.php');
	echo '<h1>',$oBudget->title,' :: ',$arrUsrData["pagTitle$strLocal"],'</h1>';	
	
	if (count($arrCounterparty['codes']>1)){
		foreach ($arrCounterparty['titles'] as $sales=>$customers){
			//echo '<h4>',($sales?$sales:"Unassigned"),'</h4>';
			//echo '<div>';
			foreach ($customers as $id=>$data){
				echo "<span title='{$data['cntCode1C']}' class='".($data['cntFlagFolder']?'folder-open':'')."'>";
				if ($id==$cntID){
					echo $data["cntTitle"];
				} else {
					echo "<a href='{$_SERVER['PHP_SELF']}?cntID={$id}'>",$data["cntTitle"],"</a>";
				}
				echo "</span> | ";
			}
			//echo '</div>';
		}
	}
	
	include ('includes/inc_report_selectors.php');
	Budget::getProfitTabs('reg_sales', false, Array('customer'=>$arrCounterparty['codes']));	
	
	?>
	<h2>Charts</h2>
	<?php
		unset($filter['pc']);
		$oReport = new Reports(Array('budget_scenario'=>$budget_scenario, 'reference'=>$reference, 'currency'=>$currency, 'denominator'=>$denominator, 'filter'=>$filter));
		$oReport->periodicGraph(Array('table'=>false,'oop'=>false));
		
		if (strpos($oBudget->type,'Budget')===false && count($arrCounterparty['codes'])>1){
					
			$sqlActual = "SUM(".$oBudget->getThisYTDSQL('nm',$arrActualRates).")";
			$sqlBudget = "SUM(".$oBudget->getThisYTDSQL('cm',$arrActualRates).")";
			$settings['nextGP'] = Array('title'=>"GP by activity, next month changes",
								'sqlBase' => "SELECT activity as optValue, 
													Activity_title as optText,  
													{$sqlActual} as Actual, 
													{$sqlBudget} as Budget, 
													({$sqlActual}-{$sqlBudget}) as Diff
											FROM vw_master 
											{$oReport->sqlWhere}
												AND  scenario='{$oBudget->id}' 
												".Reports::GP_FILTER."
												##AND customer IN (".implode($arrCounterparty['codes']).")
											GROUP BY activity",
									'denominator'=>$denominator,
									'budget_title'=>$oBudget->arrPeriodTitle[$oBudget->cm],
									'actual_title'=>$oBudget->arrPeriodTitle[$oBudget->nm],
									'tolerance'=>0.05,
									'limit'=>10);	
			
			$oWF = new Waterfall($settings['nextGP']);
			$oWF->draw();
		}
		
		
		
	?>
	<h2>Documents related to this customer</h2>
	<?php
	$sql = "SELECT vw_journal.*, stbl_user.*, edit_date as timestamp, SUM(".$oBudget->getYTDSQL().") as amount
	FROM reg_master
	LEFT JOIN vw_journal ON vw_journal.guid = source
	LEFT JOIN stbl_user ON usrID=vw_journal.edit_by				
	WHERE reg_master.scenario IN ('{$budget_scenario}','{$reference}')
		AND reg_master.customer IN (".implode(',',$arrCounterparty['codes']).")
	GROUP BY vw_journal.guid
	ORDER BY vw_journal.edit_date ASC";	

	$rs =$oSQL->q($sql);
	$data = Array();
	while ($rw=$oSQL->f($rs)){
		$data[] = $rw;
	}
	Reports::getJournalEntries($data);
	
	include ('includes/inc-frame_bottom.php');
} else {
	
	if ($_GET['pccGUID']=='all'){
		$sqlWhere = " WHERE customer IN (".implode(',',$arrCounterparty['codes']).")"; 
	} else {
		$sqlWhere = "WHERE pc in (SELECT pccID FROM vw_profit WHERE pccGUID=".$oSQL->e($_GET['pccGUID']).") AND customer IN (".implode(',',$arrCounterparty['codes']).")";
	}
	
		
	$oReport = new Reports(Array('budget_scenario'=>$budget_scenario, 'reference'=>$reference, 'currency'=>$currency, 'denominator'=>$denominator, 'filter'=>$filter));
	
	?>
		<div id='graph'/>
	<?php
	if (strpos($oBudget->type,'FYE')!== false || strpos($oBudget->type,'Actual')!== false){
	// if (false){
		$oReport->monthlyReport($type);	
	} elseif (strpos($oBudget->type,'Budget')!== false) {
		$oReport->quarterly($type);
	} else {
		include ('includes/inc_report_buttons.php');
		$oReport->periodicPnL($type);
		$oReport->salesByActivity($sqlWhere);
	}
	
	
	// $oReport->periodicPnL($sqlWhere,Array('field_data'=>'activity','field_title'=>'Activity_title','title'=>'Activity'));	
	
}

function getCnt($cntID, &$arrCounterparty=Array()){
	GLOBAL $oSQL, $strLocal;
	
	$sql = "SELECT cntID, cntTitle$strLocal as cntTitle, cntUserID, usrTitle$strLocal as Sales, cntFlagFolder, cntCode1C
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

function getCategory($catID, &$arrCounterparty=Array()){
	GLOBAL $oSQL, $strLocal;
	$sql = "SELECT cntID, cntTitle$strLocal as cntTitle, cntUserID, usrTitle$strLocal as Sales, cntFlagFolder, cntCode1C
		FROM common_db.tbl_object_category
		JOIN common_db.tbl_counterparty ON cntGUID1C=obcObjectID
		LEFT JOIN stbl_user ON usrID=cntUserID
		WHERE obcCategoryID='{$catID}'
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

?>