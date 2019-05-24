<?php
// $flagNoAuth = true;
set_time_limit(160);
require ('common/auth.php');
require ('classes/reports.class.php');
require ('classes/waterfall.class.php');
include ('includes/inc_report_settings.php');
include ('includes/inc_report_ghqfilter.php');

$arrActions[] = Array('title'=>'Current month','action'=>'?period_type=cm');
$arrActions[] = Array('title'=>'YTD','action'=>'?period_type=ytd');
$arrActions[] = Array('title'=>'ROY','action'=>'?period_type=roy');
$arrActions[] = Array('title'=>'FYE','action'=>'?period_type=fye');
	
	$oBudget = new Budget($budget_scenario);
	$oReference = new Budget($reference);
	
	$arrActualRates = $oBudget->getMonthlyRates($currency);
	$arrBudgetRates = $oReference->getMonthlyRates($currency);
	
	if ($_GET['debug']){
		echo '<pre>';print_r($oBudget);echo '</pre>';
	}

if(!isset($_GET['prtGHQ'])){

	$arrJS[]='js/rep_pnl.js';
	$arrJS[] = "js/rep_summary.js";

	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,' vs ',$oReference->title,'</h1>';	
	include ('includes/inc_report_selectors.php');
	echo '<p>',$oBudget->timestamp,'; ',$oBudget->rates,'</p>';
	
	$oBudget->getGHQTabs();
	
	include ('includes/inc-frame_bottom.php');
} else {

	
	if(is_array($arrProducts)){
	?>
	<p><?php echo implode(', ',$arrProducts['title']);?></p>
	<?php
	}
	
	
	$oReport = new Reports(Array('budget_scenario'=>$oBudget->id, 'currency'=>$currency, 'denominator'=>$denominator, 'reference'=>$oReference->id, 'filter'=>$filter));
	if(strpos($oBudget->type,"Budget")!==false){
		$oReport->shortMonthlyReportRHQ('budget');	
	} else {	
		$oReport->shortMonthlyReportRHQ('cm');
		$oReport->shortMonthlyReportRHQ('fye');	
	}
	
	?>	
	<div>
	<?php
	// die();
	// $period_type = 'roy'; $period_title = "Rest-of-year";
	//$period_type = $_GET['period_type']?$_GET['period_type']:'ytd';
	$period_title = strtoupper($period_type);
	
	$sqlActual = "SUM(".$oBudget->getThisYTDSQL($period_type,$arrActualRates).")";
	$sqlBudget = "SUM(".$oBudget->getThisYTDSQL($period_type,$arrBudgetRates).")";
	
	// echo '<pre>',$sqlActual,'</pre>';
	
	$settings['revcus'] = Array('title'=>"Revenue by customer, ".$period_title,
						'sqlBase' => "SELECT customer_group_code as optValue, 
											customer_group_title as optText,  
											{$sqlActual} as Actual, 
											0 as Budget, 
											{$sqlActual} as Diff
									FROM vw_master 
									{$sqlWhere}
										AND  scenario='{$oBudget->id}' 
										".Reports::REVENUE_FILTER."
									GROUP BY customer_group_code
									UNION ALL
									SELECT customer_group_code as optValue, 
											customer_group_title as optText,  
									0 as Actual, 
									{$sqlBudget}  as Budget, 
									-{$sqlBudget} as Diff
									FROM vw_master 
									{$sqlWhere}
										AND scenario='{$oReference->id}' 
										AND source<>'Estimate' 
										".Reports::REVENUE_FILTER."						
									GROUP BY customer_group_code",
							'tolerance'=>0.05,
							'denominator'=>$denominator,
							'actual_title'=>$oBudget->title,
							'budget_title'=>$oReference->title,
							'limit'=>10);	
	
	$oWF = new Waterfall($settings['revcus']);
	$oWF->draw();
	
	$settings['gpcus'] = Array('title'=>"GP by customer, ".$period_title,
						'sqlBase' => "SELECT customer_group_code as optValue, 
											customer_group_title as optText,  
											{$sqlActual} as Actual, 
											0 as Budget, 
											{$sqlActual} as Diff
									FROM vw_master 
									{$sqlWhere}
										AND  scenario='{$oBudget->id}' 
										".Reports::GP_FILTER."
									GROUP BY customer_group_code
									UNION ALL
									SELECT customer_group_code as optValue, 
											customer_group_title as optText,  
									0 as Actual, 
									{$sqlBudget}  as Budget, 
									-{$sqlBudget} as Diff
									FROM vw_master 
									{$sqlWhere}
										AND scenario='{$oReference->id}' 
										AND source<>'Estimate' 
										".Reports::GP_FILTER."										
									GROUP BY customer_group_code",
							'tolerance'=>0.05,
							'denominator'=>$denominator,
							'actual_title'=>$oBudget->title,
							'budget_title'=>$oReference->title,
							'limit'=>10);	
	
	$oWF = new Waterfall($settings['gpcus']);
	$oWF->draw();
	
	$settings['rfc'] = Array('title'=>"RFC by elements, ".$period_title,
						'sqlBase' => "SELECT IF(`Group_code` IN (108,110,96,94),item,Group_code)  as optValue, 
											IF(`Group_code` IN (108,110,96,94),`Budget item`,`Group`) as optText, 
											{$sqlActual} as Actual, 
											0 as Budget, 
											{$sqlActual} as Diff
									FROM vw_master 
									{$sqlWhere}
										AND  scenario='{$oBudget->id}' 
										".Reports::RFC_FILTER."
									GROUP BY IF(`Group_code` IN (108,110,96,94),item,Group_code)
									UNION ALL
									SELECT IF(`Group_code` IN (108,110,96,94),item,Group_code)  as optValue, 
											IF(`Group_code` IN (108,110,96,94),`Budget item`,`Group`) as optText, 
											0 as Actual, 
									{$sqlBudget}  as Budget, -{$sqlBudget} as Diff
									FROM vw_master 
									{$sqlWhere}
										AND scenario='{$oReference->id}' 
										AND source<>'Estimate' 						
										".Reports::RFC_FILTER."
									GROUP BY IF(`Group_code` IN (108,110,96,94),item,Group_code)",
							'tolerance'=>0.05,
							'denominator'=>$denominator,
							'actual_title'=>$oBudget->title,
							'budget_title'=>$oReference->title,
							'limit'=>10);
	
	$oWF = new Waterfall($settings['rfc']);
	$oWF->draw();
	
	$settings['sga'] = Array('title'=>"SG&A by elements, ".$period_title,
						'sqlBase' => "SELECT IF(`Group_code` IN (108,110,96,94),item,Group_code)  as optValue, 
											IF(`Group_code` IN (108,110,96,94),`Budget item`,`Group`) as optText, 
											{$sqlActual} as Actual, 
											0 as Budget, 
											{$sqlActual} as Diff
									FROM vw_master 
									{$sqlWhere}
										AND  scenario='{$oBudget->id}' 
										AND (account LIKE '5%') 									
									GROUP BY IF(`Group_code` IN (108,110,96,94),item,Group_code)
									UNION ALL
									SELECT IF(`Group_code` IN (108,110,96,94),item,Group_code)  as optValue, 
											IF(`Group_code` IN (108,110,96,94),`Budget item`,`Group`) as optText, 
											0 as Actual, 
									{$sqlBudget}  as Budget, -{$sqlBudget} as Diff
									FROM vw_master 
									{$sqlWhere}
										AND scenario='{$oReference->id}' 
										AND source<>'Estimate' 						
										AND (account LIKE '5%') 	
									GROUP BY IF(`Group_code` IN (108,110,96,94),item,Group_code)",
							'tolerance'=>0.05,
							'denominator'=>$denominator,
							'actual_title'=>$oBudget->title,
							'budget_title'=>$oReference->title,
							'limit'=>10);
	
	$oWF = new Waterfall($settings['sga']);
	$oWF->draw();
	
	// if (strpos($oBudget->type,'Budget')===false){
		$sqlActual = "SUM(".$oBudget->getThisYTDSQL('nm',$arrActualRates).")";
		$sqlBudget = "SUM(".$oBudget->getThisYTDSQL('cm',$arrActualRates).")";
		
		if ($oBudget->nm < $oBudget->cm){
			$sqlBase = "SELECT  customer_group_code as optValue, 
												customer_group_title as optText,  
												{$sqlActual} as Actual, 
												0 as Budget, 
												{$sqlActual} as Diff
										FROM vw_master 
										{$sqlWhere}
											AND  scenario='{$oBudget->id}' AND account IN ('J00400', 'J00802')
										GROUP BY customer_group_code
						UNION ALL
						SELECT  customer_group_code as optValue, 
												customer_group_title as optText,  
												0 as Actual, 
												{$sqlBudget} as Budget, 
												(-{$sqlBudget}) as Diff
										FROM vw_master 
										{$sqlWhere}
											AND  scenario='{$oReference->id}' AND account IN ('J00400', 'J00802')
										GROUP BY customer_group_code";
		} else {
			$sqlBase = "SELECT  customer_group_code as optValue, 
												customer_group_title as optText,  
												{$sqlActual} as Actual, 
												{$sqlBudget} as Budget, 
												({$sqlActual}-{$sqlBudget}) as Diff
										FROM vw_master 
										{$sqlWhere}
											AND  scenario='{$oBudget->id}' AND account IN ('J00400', 'J00802')
										GROUP BY customer_group_code";
		}
		
		$settings['nextGP'] = Array('title'=>"GP by customer, next month changes",
							'sqlBase' => $sqlBase,
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
											AND  scenario='{$oBudget->id}' AND account NOT IN ('J00400', 'J00802') AND item<>''
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
	//==================== Top 10 customers ==========================/	
	
	if(strpos($oBudget->type,'Budget')!==false){
		$period_type = 'fye'; $period_title = "Full year";
	} else {
		$period_type = 'ytd'; $period_title = "YTD";
	}
	
	$oReport->topCustomers(10,5,$period_type);
	
		//==================== Staff ==========================/
	
	$sql = "SELECT pccTitle, 
				".(in_array('HR',$arrUsrData['roleIDs'])?"salary, monthly_bonus,":"")." 
				empTitleLocal, funTitleLocal, prtTitleLocal,funFlagWC,funRHQ,".$oBudget->getMonthlySumSQL(1+$oBudget->offset,12+$oBudget->offset)." 
			FROM reg_headcount 
			LEFT JOIN vw_product_type ON prtID=activity
			LEFT JOIN common_db.tbl_employee ON empGUID1C=particulars
			LEFT JOIN common_db.tbl_function ON function=funGUID
			LEFT JOIN common_db.tbl_profit ON pc=pccID
			{$oReport->sqlWhere} 
				AND scenario='{$budget_scenario}' 
				AND salary>".Reports::SALARY_THRESHOLD."
			GROUP BY particulars, function, pc
			ORDER BY funRHQ, pc,funTitle, empTitleLocal";
	$rs = $oSQL->q($sql);
	?>
	<table class="budget" id='headcount'>
	<caption>Employees</caption>
	<thead>
		<tr>
			<th>Employee</th>
			<th>Function</th>
			<th>BU</th>
			<th>Activity</th>
			<th>Payroll</th>
			<th>Quality bonus</th>
			<?php
			echo $oBudget->getTableHeader('monhtly',1+$oBudget->offset, 12+$oBudget->offset); 
			?>
			<th>Average</th>
		</tr>
	</thead>
	<tbody>
	<?php
	while ($rw = $oSQL->f($rs)){
	?>
		<tr>
			<td><?php echo $rw['empTitleLocal'];?></td>			
			<td><?php echo $rw['funRHQ'],' | ',$rw['funTitleLocal'];?></td>			
			<td><?php echo $rw['pccTitle'];?></td>
			<td><?php echo $rw['prtTitleLocal'];?></td>			
			<td class='budget-decimal budget-cloak' ><?php echo Reports::render($rw['salary']);?></td>
			<td class='budget-decimal budget-cloak' ><?php echo Reports::render($rw['monthly_bonus']);?></td>
			<?php
			$totalPayroll += $rw['salary'];
			$totalMB += $rw['monthly_bonus'];
			$hc = 0;
			for($m=1+$oBudget->offset;$m<=12+$oBudget->offset;$m++){
				$month = $oBudget->arrPeriod[$m];
				$hc += $rw[$month];
				$arrSubtotal[$month] += $rw[$month];
			?>
			<td class='budget-decimal'><?php echo Reports::render($rw[$month],1);?></td>
			<?php
			}
			?>
			<td class='budget-decimal budget-subtotal'><?php echo Reports::render($hc/12,1);?></td>
		</tr>		
		<?php
	}
	?>
	</tbody>
	<tfoot>
	<tr class='budget-subtotal'>
			<td colspan="4">Total</td>
			<td class='budget-decimal'><?php echo Reports::render($totalPayroll);?></td>
			<td class='budget-decimal'><?php echo Reports::render($totalMB);?></td>
			<?php
			for($m=1+$oBudget->offset;$m<=12+$oBudget->offset;$m++){
				$month = $oBudget->arrPeriod[$m];			
			?>
			<td class='budget-decimal'><?php echo Reports::render($arrSubtotal[$month],1);?></td>
			<?php
			}
			?>
			<td class='budget-decimal budget-subtotal'><?php echo Reports::render(array_sum($arrSubtotal)/12,1);?></td>
		</tr>
	</tfoot>
	</table>
	<?php
}
?>