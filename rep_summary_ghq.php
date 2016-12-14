<?php
$flagNoAuth = true;
require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/reports.class.php');
require ('classes/waterfall.class.php');
include ('includes/inc_report_settings.php');

	
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

	
	if ($_GET['prtGHQ']=='all'){
		$sqlWhere = " WHERE TRUE";
		// $filter = Array();
	} else {
		if ($_GET['prtGHQ']=='OFF') {
		$sqlWhereP = " WHERE prtGHQ IN ('Ocean import','Ocean export')";
		$filter = Array('prtGHQ'=>Array('Ocean import','Ocean export'));
		
		} elseif ($_GET['prtGHQ']=='AFF') {
			$sqlWhereP = " WHERE prtGHQ IN ('Air import','Air export')";
			$filter = Array('prtGHQ'=>Array('Air import','Air export'));

		} else {
			$sqlWhereP = " WHERE prtGHQ=".$oSQL->e(urldecode($_GET['prtGHQ']));
			$filter = Array('prtGHQ'=>urldecode($_GET['prtGHQ']));
			
		}
		
		$sql = "SELECT * FROM vw_product_type {$sqlWhereP}";
		$rs = $oSQL->q($sql);
		while ($rw = $oSQL->f($rs)){
			$arrProducts['title'][] = $rw['prtTitle'];
			$arrProducts['id'][] = $rw['prtID'];
		}
		
		$sqlWhere = "WHERE activity IN (".implode(',',$arrProducts['id']).")";
		$filter = Array('activity'=>$arrProducts['id']);
		
		?>
		<p><?php echo implode(', ',$arrProducts['title']);?></p>
		<?php
	}
	
	
	$oReport = new Reports(Array('budget_scenario'=>$oBudget->id, 'currency'=>643, 'denominator'=>$denominator, 'reference'=>$oReference->id, 'filter'=>$filter));
	$oReport->shortMonthlyReport();	
	$oReport = new Reports(Array('budget_scenario'=>$oBudget->id, 'currency'=>643, 'denominator'=>$denominator, 'reference'=>$oReference->id, 'filter'=>$filter));
	$oReport->shortMonthlyReport('fye');	
	
	
	
	?>	
	<div>
	<?php
	// die();
	$period_type = 'fye';
	$sqlActual = "SUM(".$oBudget->getThisYTDSQL($period_type,$arrActualRates).")";
	$sqlBudget = "SUM(".$oBudget->getThisYTDSQL($period_type,$arrBudgetRates).")";
	
	// echo '<pre>',$sqlActual,'</pre>';
	
	$settings['gpcus'] = Array('title'=>"GP by customer",
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
							'limit'=>10);	
	
	$oWF = new Waterfall($settings['gpcus']);
	$oWF->draw();
	
	$settings['rfc'] = Array('title'=>"RFC by elements",
						'sqlBase' => "SELECT IF(`Group_code` IN (108,110,96,94),item,Group_code)  as optValue, 
											IF(`Group_code` IN (108,110,96,94),`Budget item`,`Group`) as optText, 
											{$sqlActual} as Actual, 
											0 as Budget, 
											{$sqlActual} as Diff
									FROM vw_master 
									{$sqlWhere}
										AND  scenario='{$oBudget->id}' 
										AND (account IN ('J00801','J00803','J00804','J00805','J00806','J00808','J0080W')) 									
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
										AND (account IN ('J00801','J00803','J00804','J00805','J00806','J00808','J0080W')) 	
									GROUP BY IF(`Group_code` IN (108,110,96,94),item,Group_code)",
							'tolerance'=>0.05,
							'denominator'=>$denominator,
							'limit'=>10);
	
	$oWF = new Waterfall($settings['rfc']);
	$oWF->draw();
	
	$settings['sga'] = Array('title'=>"SG&A by elements",
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
							'limit'=>10);
	
	$oWF = new Waterfall($settings['sga']);
	$oWF->draw();
	?>
	</div>
	<?php
	//==================== Top 10 customers ==========================/
	$sql = "SELECT {$sqlActual} as GP 
					FROM vw_master 
					{$sqlWhere}
					AND  scenario='{$oBudget->id}' AND account IN ('J00400', 'J00802')";
	$rs = $oSQL->q($sql);
	$rw = $oSQL->f($rs);
	$arrReport['other']['GP'] = $rw['GP'];
	$arrReportTotal['GP'] = $rw['GP'];
	
	$sql = "SELECT {$sqlActual} as Revenue 
					FROM vw_master 
					{$sqlWhere}
					AND  scenario='{$oBudget->id}' AND account IN ('J00400')";
	$rs = $oSQL->q($sql);
	$rw = $oSQL->f($rs);
	$arrReport['other']['Revenue'] = $rw['Revenue'];
	$arrReportTotal['Revenue'] = $rw['Revenue'];
	
	$sql = "SELECT customer_group_code as optValue, 
						customer_group_title as optText,  
						{$sqlActual} as GP
				FROM vw_master 				
				{$sqlWhere}
					AND  scenario='{$oBudget->id}' AND account IN ('J00400', 'J00802')
				GROUP BY customer_group_code
				ORDER BY GP DESC
				LIMIT 10";
	$rs = $oSQL->q($sql);
	while ($rw = $oSQL->f($rs)){
		$arrReport[$rw['optText']]['GP'] = $rw['GP'];
		$arrCGFilter[] = $rw['optValue'];
	}
	
	$sql = "SELECT customer_group_code as optValue, 
						customer_group_title as optText,  
						{$sqlActual} as Revenue
				FROM vw_master 				
				{$sqlWhere}
					AND  scenario='{$oBudget->id}' AND account IN ('J00400')
					AND  customer_group_code IN (".implode(',',$arrCGFilter).")
				GROUP BY customer_group_code
				";
	$rs = $oSQL->q($sql);
	while ($rw = $oSQL->f($rs)){
		$arrReport[$rw['optText']]['Revenue'] = $rw['Revenue'];
	}
	
	$tableID = "top_".md5(time());
	?>
	<table class="budget" id="<?php echo $tableID;?>">
		<caption>Top 10 customers, <?php echo urldecode($_GET['prtGHQ']);?></caption>
	<thead>	
		<tr>
			<th>Customer</th>
			<th>Revenue</th>
			<th>GP</th>
			<th>Profitability</th>
			<th>% of total</th>
		</tr>
	</thead>
	<tbody>
	<?php
	foreach ($arrReport as $customer=>$values){
		?>
		<tr>
			<td><?php echo $customer;?></td>
			<td><?php echo number_format($values['Revenue'],0,'.',',');?></td>
			<td><?php echo number_format($values['GP'],0,'.',',');?></td>
			<td><?php echo number_format($values['GP']/$values['Revenue']*100,0,'.',',');?>%</td>
			<td><?php echo number_format($values['GP']/$arrReportTotal['GP']*100,0,'.',',');?>%</td>
		</tr>
		<?php
		$arrReport['other']['Revenue'] -=  $values['Revenue'];
		$arrReport['other']['GP'] -=  $values['GP'];
	}
	?>
	</tbody>
	<tfoot>
	<tr class="budget-subtotal">
		<td>Total</td>
		<td><?php echo number_format($arrReportTotal['Revenue'],0,'.',',');?></td>
		<td><?php echo number_format($arrReportTotal['GP'],0,'.',',');?></td>
		<td><?php echo number_format($arrReportTotal['GP']/$arrReportTotal['Revenue']*100,0,'.',',');?>%</td>
		<td>100%</td>
	</tr>
	</tfoot>
	</table>
	<ul class='link-footer'>
		<li><a href='javascript:SelectContent("<?php echo $tableID;?>");'>Select table</a></li>
	</ul>	
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
	<style>
	.blurry {
	   color: transparent;
	   text-shadow: 0 0 5px rgba(0,0,0,0.5);
	}
	</style>
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
			<td class='budget-decimal blurry' ><?php echo Reports::render($rw['salary']);?></td>
			<td class='budget-decimal blurry' ><?php echo Reports::render($rw['monthly_bonus']);?></td>
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