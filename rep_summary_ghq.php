<?php
// $flagNoAuth = true;
set_time_limit(60);
require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/reports.class.php');
require ('classes/waterfall.class.php');
include ('includes/inc_report_settings.php');
include ('includes/inc_report_ghqfilter.php');
	
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
		$oReport->shortMonthlyReport('budget');	
	} else {	
		$oReport->shortMonthlyReport('cm');
		$oReport->shortMonthlyReport('fye');	
	}
	
	
	?>	
	<div>
	<?php
	// die();
	$period_type = 'fye'; $period_title = "Full year";
	
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
										AND  scenario='{$oBudget->id}' AND item='".Reports::REVENUE_ITEM."'
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
										AND item='".Reports::REVENUE_ITEM."'							
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
										AND  scenario='{$oBudget->id}' AND account IN ('J00400', 'J00802')
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
										AND account IN ('J00400', 'J00802')										
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
										AND ".Reports::RFC_FILTER."
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
	
	function _renderTopCustomerLine($data, $arrTotal, $strTitle, $strClass=""){
		?>
		<tr class="<?php echo $strClass;?>">
			<td><?php echo $strTitle;?></td>
			<td><?php echo $data['ivlTitle'];?></td>			
			<td class="budget-decimal"><?php Reports::render($data['Revenue'],0,'.',',');?></td>
			<td class="budget-decimal"><?php Reports::render($data['GOP'],0,'.',',');?></td>
			<td class="budget-decimal"><?php Reports::render($data['KPI'],0,'.',',');?></td>
			<td class="budget-decimal"><?php Reports::render_ratio($data['GOP'],$data['Revenue'],0);?>%</td>
			<td class="budget-decimal"><?php Reports::render_ratio($data['GOP'],$data['KPI']*100,0);?></td>
			<td class="budget-decimal"><?php Reports::render_ratio($data['GOP'],$arrTotal['GP'],0);?>%</td>
		</tr>
		<?php
	}
	
	if(strpos($oBudget->type,'Budget')!==false){
		$period_type = 'fye'; $period_title = "Full year";
	} else {
		$period_type = 'ytd'; $period_title = "YTD";
	}
	$sqlActual = "SUM(".$oBudget->getThisYTDSQL($period_type,$arrActualRates).")";
	$sqlBudget = "SUM(".$oBudget->getThisYTDSQL($period_type,$arrBudgetRates).")";
	
	$sql = "SELECT customer_group_code as optValue, 
						customer_group_title as optText,  
						ivlTitle,
						{$sqlActual} as GOP
				FROM vw_master 	
				{$sqlWhere}
					AND  scenario='{$oBudget->id}' ".Reports::GOP_FILTER."
					AND IFNULL(customer_group_code,0)<>0
				GROUP BY customer_group_code				
				ORDER BY GOP DESC
				";
	$rs = $oSQL->q($sql);
	while ($rw = $oSQL->f($rs)){
		$arrReport[$rw['optText']]['GOP'] = $rw['GOP'];
		$arrReport[$rw['optText']]['ivlTitle'] = $rw['ivlTitle'];
		$arrCGFilter[] = $rw['optValue'];	
	}
	
	$sql = "SELECT customer_group_code as optValue, 
						customer_group_title as optText,  
						{$sqlActual} as Revenue
				FROM vw_master 				
				{$sqlWhere}
					AND  scenario='{$oBudget->id}' ".Reports::REVENUE_FILTER."
					##AND  customer_group_code IN (".implode(',',$arrCGFilter).")
				GROUP BY customer_group_code
				";
	$rs = $oSQL->q($sql);
	while ($rw = $oSQL->f($rs)){
		$arrReport[$rw['optText']]['Revenue'] = $rw['Revenue'];
	}
	
	$sql = "SELECT customer_group_code as optValue, 
						customer_group_title as optText,  
						SUM(".$oBudget->getThisYTDSQL($period_type).") as KPI,
						unit
				FROM vw_sales 				
				{$sqlWhere}
					AND  scenario='{$oBudget->id}' AND unit IN ('Kgs','TEU','Trips')
					##AND  customer_group_code IN (".implode(',',$arrCGFilter).")
				GROUP BY customer_group_code
				";
	$rs = $oSQL->q($sql);
	while ($rw = $oSQL->f($rs)){
		$arrReport[$rw['optText']]['KPI'] = $rw['KPI'];
	}
	
	$sql = "SELECT 	SUM(".$oBudget->getThisYTDSQL($period_type).") as KPI,
						unit
				FROM vw_sales 				
				{$sqlWhere}
					AND  scenario='{$oBudget->id}' AND unit IN ('Kgs','TEU','Trips')									
				";
	$rs = $oSQL->q($sql);
	$rw = $oSQL->f($rs);
	$arrReportOther['KPI'] = $rw['KPI'];
	$arrReportTotal['KPI'] = $rw['KPI'];
	
	$sql = "SELECT {$sqlActual} as GOP 
					FROM vw_master 
					{$sqlWhere}
					AND  scenario='{$oBudget->id}' ".Reports::GOP_FILTER;
	$rs = $oSQL->q($sql);
	$rw = $oSQL->f($rs);
	$arrReportOther['GOP'] = $rw['GOP'];
	$arrReportTotal['GOP'] = $rw['GOP'];
	
	$sql = "SELECT {$sqlActual} as Revenue 
					FROM vw_master 
					{$sqlWhere}
					AND  scenario='{$oBudget->id}' ".Reports::REVENUE_FILTER;
					
	$rs = $oSQL->q($sql);
	$rw = $oSQL->f($rs);
	$arrReportOther['Revenue'] = $rw['Revenue'];
	$arrReportTotal['Revenue'] = $rw['Revenue'];
	
	$tableID = "top_".md5(time());
	?>
	<table class="budget" id="<?php echo $tableID;?>">
		<caption>Top 10 and bottom 5 customers, <?php echo urldecode($_GET['prtGHQ']), ", ", $period_title;?></caption>
	<thead>	
		<tr>
			<th>Customer</th>
			<th>Vertical</th>			
			<th>Gross Revenue</th>
			<th>GOP</th>
			<th>Volume</th>
			<th>Profitability</th>
			<th>per unit</th>
			<th>% of total</th>
		</tr>
	</thead>
	<tbody>
	<?php
	
	foreach ($arrReport as $customer=>$values){
		if($values['Revenue']>0 && $customer!=''){
			$arrFilteredReport[$customer] = $values;
		}
	}
	
	$arrTop = array_slice($arrFilteredReport,0,10, true);
	$arrBottom = array_slice($arrFilteredReport,-5,5, true);
	// $arrBottom = array_slice($arrFilteredReport,-1,min(5,count($arrFilteredReport)-10), true);
	
	
	
	foreach ($arrTop as $customer=>$values){
		_renderTopCustomerLine($values, $arrReportTotal, $customer);	
		$arrReportOther['Revenue'] -=  $values['Revenue'];
		$arrReportOther['GOP'] -=  $values['GOP'];
		$arrReportOther['KPI'] -=  $values['KPI'];
	}
	
	foreach ($arrBottom as $customer=>$values){
		_renderTopCustomerLine($values, $arrReportTotal, $customer);	
		$arrReportOther['Revenue'] -=  $values['Revenue'];
		$arrReportOther['GOP'] -=  $values['GOP'];
		$arrReportOther['KPI'] -=  $values['KPI'];
	}
	
		_renderTopCustomerLine($arrReportOther, $arrReportTotal, "Others");
	?>
	</tbody>
	<tfoot>
	<?php
		_renderTopCustomerLine($arrReportTotal, $arrReportTotal, "Total", "budget-subtotal");
	?>	
	</tfoot>
	</table>
	<button onclick="SelectContent('<?php echo $tableID;?>');">Copy table</button>
	<?php
	
	
	
	//==================== Staff ==========================/
	$sql = "SELECT pccTitle, salary, monthly_bonus, empTitleLocal, funTitleLocal, prtTitleLocal,funFlagWC,funRHQ,".$oBudget->getMonthlySumSQL(1+$oBudget->offset,12+$oBudget->offset)." 
			FROM reg_headcount 
			LEFT JOIN vw_product_type ON prtID=activity
			LEFT JOIN common_db.tbl_employee ON empGUID1C=particulars
			LEFT JOIN common_db.tbl_function ON function=funGUID
			LEFT JOIN common_db.tbl_profit ON pc=pccID
			WHERE activity IN (".implode(',',$arrProducts['id']).") AND scenario='{$budget_scenario}' AND salary>".Reports::SALARY_THRESHOLD."
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