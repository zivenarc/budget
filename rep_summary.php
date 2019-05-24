<?php
// $flagNoAuth = true;
require ('common/auth.php');
require ('classes/reports.class.php');
require ('classes/waterfall.class.php');
include ('includes/inc_report_settings.php');

$arrActions[] = Array('title'=>'Current month','action'=>'?period_type=cm');
$arrActions[] = Array('title'=>'FYE','action'=>'?period_type=fye');

if ($bu_group){
	$sql = "SELECT * FROM common_db.tbl_profit WHERE pccParentCode1C='{$bu_group}'";
	$rs = $oSQL->q($sql);
	while ($rw = $oSQL->f($rs)){
		$arrBus[] = $rw['pccID']; 
	}
}
	
	$oBudget = new Budget($budget_scenario);
	$oReference = new Budget($reference);
	
	if(strpos($oBudget->type,"Budget")!==false){	
		$period_type = 'budget';
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

	
	include ('includes/inc_report_pcfilter.php');
	
	if(is_array($arrPCHeader)){
		echo '<p>',implode(' | ',$arrPCHeader),'</p>';
	}
	
	$strPCHeader = $oBudget->arrProfit[$_GET['pccGUID']]["pccTitle{$strLocal}"];
	
	$oReport = new Reports(Array(	'budget_scenario'=>$oBudget->id, 
									'currency'=>$currency, 
									'denominator'=>$denominator, 
									'reference'=>$oReference->id, 
									'filter'=>$filter, 
									'title'=>$strPCHeader
								)
							);
	// $oReport->shortMonthlyReport($period_type);	
	$oReport->shortMonthlyReportRHQ($period_type);	
	
	?>
	<div>
	<?php
	
	$sqlActual = "SUM(".$oBudget->getThisYTDSQL($period_type,$arrActualRates).")";
	$sqlBudget = "SUM(".$oBudget->getThisYTDSQL($period_type,$arrBudgetRates).")";
	
	$settings['oop'] = Array('title'=>"{$strPCHeader} :: OOP by factors",
						'sqlBase' => "SELECT IF(`Group_code` IN (108,110,96),item,Group_code)  as optValue, 
											IF(`Group_code` IN (108,110,96),`Budget item`,`Group`) as optText, 
											{$sqlActual} as Actual, 
											0 as Budget, 
											{$sqlActual} as Diff
									FROM vw_master 
									{$oReport->sqlWhere}
										".Reports::OWN_OPERATING_PROFIT."
										AND  scenario='{$oBudget->id}'
										AND account NOT LIKE 'SZ%'																				
									GROUP BY IF(`Group_code` IN (108,110,96),item,Group_code)
									UNION ALL
									SELECT IF(`Group_code` IN (108,110,96),item,Group_code)  as optValue, 
											IF(`Group_code` IN (108,110,96),`Budget item`,`Group`) as optText, 
											0 as Actual, 
									{$sqlBudget}  as Budget, -{$sqlBudget} as Diff
									FROM vw_master 
									{$oReport->sqlWhere}
										".Reports::OWN_OPERATING_PROFIT."
										AND scenario='{$oReference->id}'
										AND source<>'Estimate' 	
										AND account NOT LIKE 'SZ%'										
									GROUP BY IF(`Group_code` IN (108,110,96),item,Group_code)",
							'denominator'=>$denominator,
							'actual_title'=>$oBudget->title,
							'budget_title'=>$oReference->title,
							'tolerance'=>0.03,
							'limit'=>10);
	
	$oWF = new Waterfall($settings['oop']);
	$oWF->draw();
	
	$settings['gpcus'] = Array('title'=>"{$strPCHeader} :: GP by customer",
						'sqlBase' => "SELECT  customer_group_code as optValue, 
											customer_group_title as optText,  
											{$sqlActual} as Actual, 
											0 as Budget, 
											{$sqlActual} as Diff
									FROM vw_master 
									{$oReport->sqlWhere}
										AND  scenario='{$oBudget->id}' 
										".Reports::GP_FILTER."
									GROUP BY customer_group_code
									UNION ALL
									SELECT  customer_group_code as optValue, 
											customer_group_title as optText,  
									0 as Actual, 
									{$sqlBudget}  as Budget, 
									-{$sqlBudget} as Diff
									FROM vw_master 									
									{$oReport->sqlWhere}
										AND scenario='{$oReference->id}'
										AND source<>'Estimate' 
										".Reports::GP_FILTER."									
									GROUP BY customer_group_code",
							'denominator'=>$denominator,
							'actual_title'=>$oBudget->title,
							'budget_title'=>$oReference->title,
							'tolerance'=>0.03,
							'limit'=>10);	
	
	$oWF = new Waterfall($settings['gpcus']);
	$oWF->draw();
	
	if (strpos($oBudget->type,'Budget')===false){
		$sqlActual = "SUM(".$oBudget->getThisYTDSQL('nm',$arrActualRates).")";
		$sqlBudget = "SUM(".$oBudget->getThisYTDSQL('cm',$arrActualRates).")";
		$settings['nextGP'] = Array('title'=>"GP by customer, next month changes",
							'sqlBase' => "SELECT  customer_group_code as optValue, 
												customer_group_title as optText,  
												{$sqlActual} as Actual, 
												{$sqlBudget} as Budget, 
												({$sqlActual}-{$sqlBudget}) as Diff
										FROM vw_master 
										{$oReport->sqlWhere}
											AND  scenario='{$oBudget->id}' 
											".Reports::GP_FILTER."
										GROUP BY customer_group_code",
								'denominator'=>$denominator,
								'budget_title'=>'This month',
								'actual_title'=>'Next month',
								'tolerance'=>0.03,
								'limit'=>10);	
		
		$oWF = new Waterfall($settings['nextGP']);
		$oWF->draw();
		
		$settings['nextCosts'] = Array('title'=>"{$strPCHeader} :: Costs, next month changes",
							'sqlBase' => "SELECT  IF(`Group_code` IN (108,110,96,94),item,Group_code)  as optValue, 
												IF(`Group_code` IN (108,110,96,94),`Budget item`,`Group`) as optText, 
												{$sqlActual} as Actual, 
												{$sqlBudget} as Budget, 
												({$sqlActual}-{$sqlBudget}) as Diff
										FROM vw_master 
										{$oReport->sqlWhere}
											AND  scenario='{$oBudget->id}' 
											AND account NOT IN ('J00400', 'J00802','J45010','J40010') 
											AND item<>''
										GROUP BY IF(`Group_code` IN (108,110,96,94),item,Group_code)",
								'denominator'=>$denominator,
								'budget_title'=>'This month',
								'actual_title'=>'Next month',
								'tolerance'=>0.05,
								'limit'=>10);	
		
		$oWF = new Waterfall($settings['nextCosts']);
		$oWF->draw();
		
		if ($oBudget->cm<15){
			$sqlActual = "SUM(".$oBudget->getThisYTDSQL('roy',$arrActualRates,(12+$oBudget->offset-$oBudget->cm)).")";
			$sqlBudget = "SUM(".$oBudget->getThisYTDSQL('ytd',$arrActualRates,($oBudget->cm-$oBudget->offset)).")";
			$settings['ROYYTD'] = Array('title'=>"{$strPCHeader} :: GP by customer, ROY vs YTD",
								'sqlBase' => "SELECT  customer_group_code as optValue, 
													customer_group_title as optText,  
													{$sqlActual} as Actual, 
													{$sqlBudget} as Budget, 
													({$sqlActual}-{$sqlBudget}) as Diff
											FROM vw_master 
											{$oReport->sqlWhere}
												AND  scenario='{$oBudget->id}' 
												".Reports::GP_FILTER."
											GROUP BY customer_group_code",
									'denominator'=>$denominator,
									'budget_title'=>'YTD/'.($oBudget->cm-$oBudget->offset),
									'actual_title'=>'ROY/'.(12+$oBudget->offset-$oBudget->cm),
									'tolerance'=>0.04,
									'limit'=>12);	
			
			$oWF = new Waterfall($settings['ROYYTD']);
			$oWF->draw();
		}
		

	}
	
		//==================== Top 10 customers ==========================/	
	
	if(strpos($oBudget->type,'Budget')!==false){
		$period_type = 'fye'; $period_title = "Full year";
	} else {
		$period_type = 'ytd'; $period_title = "YTD";
	}
	
	$oReport->topCustomers(10,5,$period_type,$strPCHeader);
	
	?>
	</div>
	<?php
	
}


?>