<?php
$flagNoAuth = true;
require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/reports.class.php');
require ('classes/waterfall.class.php');

	$denominator = 1000;	
	$budget_scenario = $_GET['budget_scenario']?$_GET['budget_scenario']:$arrSetup['stpFYEID'];
	$reference = $_GET['reference']?$_GET['reference']:$arrSetup['stpScenarioID'];
	
	$oBudget = new Budget($budget_scenario);
	$oReference = new Budget($reference);
	
	if ($_GET['debug']){
		echo '<pre>';print_r($oBudget);echo '</pre>';
	}

if(!isset($_GET['prtGHQ'])){

	$arrJS[] = "js/rep_summary.js";

	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,' vs ',$oReference->title,'</h1>';	
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
	die();
	$period_type = 'fye';
	$sqlActual = "SUM(".$oBudget->getThisYTDSQL($period_type,$arrActualRates).")/{$denominator}";
	$sqlBudget = "SUM(".$oBudget->getThisYTDSQL($period_type,$arrBudgetRates).")/{$denominator}";
	
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
							'limit'=>10);
	
	$oWF = new Waterfall($settings['rfc']);
	$oWF->draw();
	?>
	</div>
	<?php
	//==================== Top 10 customers ==========================/
	$sql = "SELECT {$sqlActual} as Actual 
					FROM vw_master 
					{$sqlWhere}
					AND  scenario='{$oBudget->id}' AND account IN ('J00400', 'J00802')";
	$rs = $oSQL->q($sql);
	$rw = $oSQL->f($rs);
	$arrReport['other']['fye'] = $rw['Actual'];
	$arrReport['total']['fye'] = $rw['Actual'];
	
	$sql = "SELECT customer_group_code as optValue, 
						customer_group_title as optText,  
						{$sqlActual} as Actual, 
						0 as Budget, 
						{$sqlActual} as Diff
				FROM vw_master 				
				{$sqlWhere}
					AND  scenario='{$oBudget->id}' AND account IN ('J00400', 'J00802')
				GROUP BY customer_group_code
				ORDER BY Actual DESC
				LIMIT 10";
				
	$rs = $oSQL->q($sql);
	?>
	<table class="budget">
		<caption>Top 10 customers, <?php echo urldecode($_GET['prtGHQ']);?></caption>
		<tr>
			<th>Customer</th>
			<th>GP</th>
			<th>% of total</th>
		</tr>
	<?php
	while ($rw = $oSQL->f($rs)){
		?>
		<tr>
			<td><?php echo $rw['optText'];?></td>
			<td><?php echo number_format($rw['Actual'],0,'.',',');?></td>
			<td><?php echo number_format($rw['Actual']/$arrReport['total']['fye']*100,0,'.',',');?>%</td>
		</tr>
		<?php
		$arrReport['other']['fye'] -=  $rw['Actual'];
	}
	?>
	<tr>
			<td>Others</td>
			<td><?php echo number_format($arrReport['other']['fye'],0,'.',',');?></td>
			<td><?php echo number_format($arrReport['other']['fye']/$arrReport['total']['fye']*100,0,'.',',');?>%</td>
		</tr>
	</table>	
	<?php
}


?>