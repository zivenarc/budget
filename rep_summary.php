<?php
require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/reports.class.php');
require ('classes/waterfall.class.php');
include ('includes/inc_report_settings.php');

if ($bu_group){
	$sql = "SELECT * FROM common_db.tbl_profit WHERE pccParentCode1C='{$bu_group}'";
	$rs = $oSQL->q($sql);
	while ($rw = $oSQL->f($rs)){
		$arrBus[] = $rw['pccID']; 
	}
}

	$denominator = 1000;	
	// $budget_scenario = $_GET['budget_scenario']?$_GET['budget_scenario']:$arrSetup['stpFYEID'];
	// $reference = $_GET['reference']?$_GET['reference']:$arrSetup['stpScenarioID'];
	
	$oBudget = new Budget($budget_scenario);
	$oReference = new Budget($reference);
	
	if(strpos($oBudget->type,"Budget")!==false){	
		$period_type = 'fye';
	}
	//$period_type = 'cm';
	
	if ($_GET['debug']){
		echo '<pre>';print_r($oBudget);echo '</pre>';
	}

if(!isset($_GET['pccGUID'])){
	
	$arrJS[]='js/rep_pnl.js';
	$arrJS[] = "js/rep_summary.js";

	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,' vs ',$oReference->title,'</h1>';	
	include ('includes/inc_report_selectors.php');
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
	
	
	$oReport = new Reports(Array('budget_scenario'=>$oBudget->id, 'currency'=>$currency, 'denominator'=>$denominator, 'reference'=>$oReference->id, 'filter'=>$filter));
	$oReport->shortMonthlyReport($period_type);	
	
	?>
	<div>
	<?php
	
	$sqlActual = "SUM(".$oBudget->getThisYTDSQL($period_type,$arrActualRates).")";
	$sqlBudget = "SUM(".$oBudget->getThisYTDSQL($period_type,$arrBudgetRates).")";
	
	$settings['gpcus'] = Array('title'=>"GP by customer",
						'sqlBase' => "SELECT  customer_group_code as optValue, 
											customer_group_title as optText,  
											{$sqlActual} as Actual, 
											0 as Budget, 
											{$sqlActual} as Diff
									FROM vw_master 
									{$sqlWhere}
										AND  scenario='{$oBudget->id}' AND company='{$company}' AND account IN ('J00400', 'J00802')
									GROUP BY customer_group_code
									UNION ALL
									SELECT  customer_group_code as optValue, 
											customer_group_title as optText,  
									0 as Actual, 
									{$sqlBudget}  as Budget, 
									-{$sqlBudget} as Diff
									FROM vw_master 									
									{$sqlWhere}
										AND scenario='{$oReference->id}' AND company='{$company}' 
										AND source<>'Estimate' 
										AND account IN ('J00400', 'J00802')										
									GROUP BY customer_group_code",
							'denominator'=>$denominator,
							'actual_title'=>$oBudget->title,
							'budget_title'=>$oReference->title,
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
										AND  scenario='{$oBudget->id}' AND company='{$company}' 
										AND account NOT LIKE 'SZ%'																				
									GROUP BY IF(`Group_code` IN (108,110,96),item,Group_code)
									UNION ALL
									SELECT IF(`Group_code` IN (108,110,96),item,Group_code)  as optValue, 
											IF(`Group_code` IN (108,110,96),`Budget item`,`Group`) as optText, 
											0 as Actual, 
									{$sqlBudget}  as Budget, -{$sqlBudget} as Diff
									FROM vw_master 
									{$sqlWhere}
										AND scenario='{$oReference->id}' AND company='{$company}' 
										AND source<>'Estimate' 	
										AND account NOT LIKE 'SZ%'										
									GROUP BY IF(`Group_code` IN (108,110,96),item,Group_code)",
							'denominator'=>$denominator,
							'actual_title'=>$oBudget->title,
							'budget_title'=>$oReference->title,
							'tolerance'=>0.05,
							'limit'=>10);
	
	$oWF = new Waterfall($settings['pbt']);
	$oWF->draw();
	
	// if (strpos($oBudget->type,'Budget')===false){
		$sqlActual = "SUM(".$oBudget->getThisYTDSQL('nm',$arrActualRates).")";
		$sqlBudget = "SUM(".$oBudget->getThisYTDSQL('cm',$arrActualRates).")";
		$settings['nextGP'] = Array('title'=>"GP by customer, next month changes",
							'sqlBase' => "SELECT  customer_group_code as optValue, 
												customer_group_title as optText,  
												{$sqlActual} as Actual, 
												{$sqlBudget} as Budget, 
												({$sqlActual}-{$sqlBudget}) as Diff
										FROM vw_master 
										{$sqlWhere}
											AND  scenario='{$oBudget->id}' AND company='{$company}' AND account IN ('J00400', 'J00802')
										GROUP BY customer_group_code",
								'denominator'=>$denominator,
								'budget_title'=>'This month',
								'actual_title'=>'Next month',
								'tolerance'=>0.05,
								'limit'=>10);	
		
		$oWF = new Waterfall($settings['nextGP']);
		$oWF->draw();
		
		$settings['nextCosts'] = Array('title'=>"Costs, next month changes",
							'sqlBase' => "SELECT  IF(`Group_code` IN (108,110,96,94),item,Group_code)  as optValue, 
												IF(`Group_code` IN (108,110,96,94),`Budget item`,`Group`) as optText, 
												{$sqlActual} as Actual, 
												{$sqlBudget} as Budget, 
												({$sqlActual}-{$sqlBudget}) as Diff
										FROM vw_master 
										{$sqlWhere}
											AND  scenario='{$oBudget->id}' AND company='{$company}' AND account NOT IN ('J00400', 'J00802') AND item<>''
										GROUP BY IF(`Group_code` IN (108,110,96,94),item,Group_code)",
								'denominator'=>$denominator,
								'budget_title'=>'This month',
								'actual_title'=>'Next month',
								'tolerance'=>0.05,
								'limit'=>10);	
		
		$oWF = new Waterfall($settings['nextCosts']);
		$oWF->draw();
	// }
	?>
	</div>
	<?php
	
}


?>