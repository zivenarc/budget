<?php
require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/reports.class.php');
require ('classes/waterfall.class.php');

if ($bu_group){
	$sql = "SELECT * FROM common_db.tbl_profit WHERE pccParentCode1C='{$bu_group}'";
	$rs = $oSQL->q($sql);
	while ($rw = $oSQL->f($rs)){
		$arrBus[] = $rw['pccID']; 
	}
}

	$denominator = 1000;
	$oBudget = new Budget($arrSetup['stpFYEID']);
	$oReference = new Budget($arrSetup['stpScenarioID']);

if(!isset($_GET['pccGUID'])){

	$arrJS[] = "js/rep_summary.js";

	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,' vs ',$oReference->title,'</h1>';	
	echo '<p>',$oBudget->timestamp,'; ',$oBudget->rates,'</p>';
	
	$oBudget->getProfitTabs('reg_master', true);
	
	include ('includes/inc-frame_bottom.php');
} else {

	
	if ($_GET['pccGUID']=='all'){
		$strRoles = "'".implode("','",$arrUsrData['roleIDs'])."'";

		$sql = "SELECT DISTINCT pcrProfitID FROM stbl_profit_role WHERE pcrRoleID IN ($strRoles) AND pcrFlagRead=1";

		$rs = $oSQL->q($sql);
		while ($rw = $oSQL->f($rs)){
			$arrPC[] = $rw['pcrProfitID'];
		}
		$sqlWhere = "WHERE pc in (".implode(',',$arrPC).")";
		$filter = Array('pc'=>$arrPC);
	} else {
		$sqlWhere = "WHERE pc in (SELECT pccID FROM vw_profit WHERE pccGUID=".$oSQL->e($_GET['pccGUID']).")";
		
		$sql = "SELECT pccID FROM vw_profit WHERE pccGUID=".$oSQL->e($_GET['pccGUID']);
		$arrPC = $oSQL->get_data($sql);
		$filter = Array('pc'=>$arrPC);
	}
	
	
	$oReport = new Reports(Array('budget_scenario'=>$oBudget->id, 'currency'=>643, 'denominator'=>$denominator, 'reference'=>$oReference->id, 'filter'=>$filter));
	$oReport->shortMonthlyReport();	
	
	?>
	<div>
	<?php
	$period_type = 'cm';
	$sqlActual = "SUM(".$oBudget->getThisYTDSQL($period_type,$arrActualRates).")/{$denominator}";
	$sqlBudget = "SUM(".$oBudget->getThisYTDSQL($period_type,$arrBudgetRates).")/{$denominator}";
	$settings['gpcus'] = Array('title'=>"GP by customer",
						'sqlBase' => "SELECT IF(C.cntParentID<>723,C.cntParentID, C.cntID) as optValue, 
											IF(C.cntParentID<>723,(SELECT P.cntTitle FROM common_db.tbl_counterparty P WHERE P.cntID=C.cntParentID),cntTitle) as optText, 
											{$sqlActual} as Actual, 
											0 as Budget, 
											{$sqlActual} as Diff
									FROM vw_master 
									LEFT JOIN common_db.tbl_counterparty C ON C.cntID=customer
									{$sqlWhere}
										AND  scenario='{$oBudget->id}' AND account IN ('J00400', 'J00802')
									GROUP BY IF(C.cntParentID<>723,C.cntParentID, C.cntID)
									UNION ALL
									SELECT IF(C.cntParentID<>723,C.cntParentID,C.cntID), 
									IF(C.cntParentID<>723,(SELECT P.cntTitle FROM common_db.tbl_counterparty P WHERE P.cntID=C.cntParentID),cntTitle) as optText, 
									0 as Actual, 
									{$sqlBudget}  as Budget, 
									-{$sqlBudget} as Diff
									FROM vw_master 
									LEFT JOIN common_db.tbl_counterparty C ON C.cntID=customer
									{$sqlWhere}
										AND scenario='{$oReference->id}' 
										AND source<>'Estimate' 
										AND account IN ('J00400', 'J00802')										
									GROUP BY IF(C.cntParentID<>723,C.cntParentID, C.cntID)",
							'tolerance'=>0.05,
							'limit'=>10);	
	
	$oWF = new Waterfall($settings['gpcus']);
	$oWF->draw();
	
	$settings['pbt'] = Array('title'=>"PBT by factors",
						'sqlBase' => "SELECT IF(`Group_code` IN (108,110,96),item,Group_code)  as optValue, 
											IF(`Group_code` IN (108,110,96),`Budget item`,`Group`) as optText, 
											{$sqlActual} as Actual, 
											0 as Budget, 
											{$sqlActual} as Diff
									FROM vw_master 
									{$sqlWhere}
										AND  scenario='{$oBudget->id}' AND account IN ('J00400', 'J00802')
									GROUP BY IF(`Group_code` IN (108,110,96),item,Group_code)
									UNION ALL
									SELECT IF(`Group_code` IN (108,110,96),item,Group_code)  as optValue, 
											IF(`Group_code` IN (108,110,96),`Budget item`,`Group`) as optText, 
											0 as Actual, 
									{$sqlBudget}  as Budget, -{$sqlBudget} as Diff
									FROM vw_master 
									{$sqlWhere}
										AND scenario='{$oReference->id}' 
										AND source<>'Estimate' 
										AND account IN ('J00400', 'J00802')										
									GROUP BY IF(`Group_code` IN (108,110,96),item,Group_code)",
							'tolerance'=>0.05,
							'limit'=>10);
	
	$oWF = new Waterfall($settings['pbt']);
	$oWF->draw();
	?>
	</div>
	<?php
	
}


?>