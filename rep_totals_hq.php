<?php
// $flagNoAuth = true;
define ('STAFF_COSTS', '02.Staff costs');
define ('GROSS_PROFIT', '01.Gross Margin');


require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/reports.class.php');
require ('classes/item.class.php');

include ('includes/inc_report_settings.php');
include ('includes/inc_total_functions.php');

$oBudget = new Budget($budget_scenario);
$oReference = new Budget($reference);
$mthStart = $_GET['mthStart']?(integer)$_GET['mthStart']:1+$oBudget->offset;
$mthEnd = $_GET['mthEnd']?(integer)$_GET['mthEnd']:12+$oBudget->offset;
// $strLastTitle = $oBudget->type=='FYE'?'Budget':$reference;
$strLastTitle = $reference;

$arrRates_this = $oBudget->getMonthlyRates($currency);
$arrRates_last = $oReference->getMonthlyRates($currency);

$arrJS[] = 'js/rep_totals.js';
include ('includes/inc-frame_top.php');

echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,'</h1>';
include ('includes/inc_report_selectors.php');
if ($mthStart!=1 || $mthEnd!=12){
	if ($mthStart==$mthEnd){
		$periodTitle = date('F',mktime(0,0,0,$mthStart)).' only';
	} else {
		$periodTitle = 'Period: '.date('M',mktime(0,0,0,$mthStart))." &ndash; ". date('M',mktime(0,0,0,$mthEnd));
	}
	echo '<h2>',$periodTitle,'</h2>';
}


$sql = "SELECT Profit, pccFlagProd, `Budget item`, `Group`, `item`, `Group_code`, SUM(".$oBudget->getYTDSQL($mthStart,$mthEnd,$arrRates_this).")/$denominator as Total, SUM(estimate)/$denominator as Estimate
		FROM vw_master
		WHERE scenario='$budget_scenario' AND pccFlagProd=0
		GROUP BY Profit, `Budget item`,`item`
		ORDER BY `Group`,Profit,itmOrder";
$rs = $oSQL->q($sql);
while ($rw=$oSQL->f($rs)){

	// $keyProfit = $oBudget->getProfitAlias($rw);
	$keyProfit = $rw['Profit'];
	
	if ($rw['item']==Items::REVENUE || $rw['item']==Items::INTERCOMPANY_REVENUE){
		$arrRevenue[$keyProfit] += $rw['Total'];
		$arrRevenueEst += $rw['Estimate'];
	}

	$arrReport[$rw['Group']][$rw['Budget item']][$keyProfit] += $rw['Total'];
	$arrTotal[$rw['Group']][$keyProfit] += $rw['Total'];
	$arrGrandTotal['this'][$keyProfit] += $rw['Total'];
	$arrGrandTotal['last'][$keyProfit] += $rw['Estimate'];
	$arrEstimate[$rw['Group']][$rw['Budget item']] += $rw['Estimate'];
	$arrProfit[$keyProfit] = $rw['pccFlagProd'];
}


//------------------------------ GROSS PROFIT ---------------------------
$sql = "SELECT account,Customer_group_code, vw_profit.pccTitle as Profit, SUM(".$oBudget->getYTDSQL($mthStart,$mthEnd,$arrRates).")/$denominator as Total, 0 as Estimate
		FROM vw_master		
		LEFT JOIN vw_profit ON bdv=pccID
		WHERE scenario='{$oBudget->id}'
			AND account IN('J00400','J00802')
		GROUP BY bdv, account, Customer_group_code, Profit
		UNION ALL
		SELECT account,Customer_group_code, vw_profit.pccTitle as Profit,  0, SUM(".$oBudget->getYTDSQL($mthStart,$mthEnd,$arrRates).")/$denominator as Estimate
		FROM vw_master		
		LEFT JOIN vw_profit ON bdv=pccID		
		WHERE scenario='{$oReference->id}'
			AND account IN('J00400','J00802')
		GROUP BY bdv, account,Customer_group_code, Profit
		ORDER BY Profit";
$rs = $oSQL->q($sql);
while ($rw=$oSQL->f($rs)){	
	
	$cusGroup = Reports::getCustomerGroup($rw);
	
	$arrGP[$cusGroup]['this'][$rw['Profit']] += $rw['Total'];
	$arrGPTotal['this'][$rw['Profit']] += $rw['Total'];
	$arrGP[$cusGroup]['last'][$rw['Profit']] += $rw['Estimate'];
	$arrGPTotal['last'][$rw['Profit']] += $rw['Estimate'];
}
// echo '<pre>';print_r($arrReport);echo '</pre>';
?>
<table class='budget' id='report'>
<thead>
	<tr>
		<th>Account</th>
		<?php foreach($arrProfit as $pc=>$flag){
					echo '<th>',$pc,'</th>';
		};?>
		<th class='budget-ytd'>Total</th>
		<th>Last</th>
		<th>Diff</th>
	</tr>
</thead>
<tbody>
<?php
foreach($arrReport as $group=>$arrItem){
	foreach($arrItem as $item=>$values){
		?>
		<tr>
			<td><?php echo $item;?></td>
		<?php
		foreach($arrProfit as $pc=>$flag){			
			?>
			<td class='budget-decimal'><?php Reports::render($values[$pc]);?></td>
			<?php
		}				
		?>
			<td class='budget-decimal budget-ytd'><?php Reports::render(array_sum($values));?></td>		
			<td class='budget-decimal'><?php Reports::render($arrEstimate[$group][$item]);?></td>
			<td class='budget-decimal'><?php Reports::render(array_sum($values) - $arrEstimate[$group][$item]);?></td>
		</tr>
		<?php
	}
	
	//---Group subtotal
	?>
	<tr class="budget-subtotal">
		<td><?php echo $group;?></td>
	<?php
	foreach($arrProfit as $pc=>$flag){
		?>
			<td class='budget-decimal'><?php Reports::render($arrTotal[$group][$pc]);?></td>
		<?php
	}
	?>
		<td class='budget-decimal budget-ytd'><?php Reports::render(array_sum($arrTotal[$group]));?></td>
		<td class='budget-decimal'><?php Reports::render(array_sum($arrEstimate[$group]));?></td>
		<td class='budget-decimal'><?php Reports::render(array_sum($arrTotal[$group]) - array_sum($arrEstimate[$group]));?></td>
	</tr>
	<?php
	//------ Ratios for gross margin
	if ($group == '01.Gross Margin'){
		?>
		<tr class="budget-ratio">
			<td>GP, %</td>
			<?php
			foreach($arrProfit as $pc=>$flag){
			?>
			<td class='budget-decimal'><?php Reports::render_ratio($arrTotal[$group][$pc],$arrRevenue[$pc]);?></td>
			<?php
		}
		?>
		<td class='budget-decimal budget-ytd'><?php Reports::render_ratio(array_sum($arrTotal[$group]),array_sum($arrRevenue));?></td>
		<td class='budget-decimal'><?php Reports::render_ratio(array_sum($arrEstimate[$group]),$arrRevenueEst);?></td>				
		</tr>
		<?php
	}
	
}
?>
</tbody>
<tfoot>
	<tr>
		<th>Branch</th>
		<?php foreach($arrProfit as $pc=>$flag){
					echo '<th>',$pc,'</th>';
		};?>
		<th class='budget-ytd'>Total</th>
		<th>Last</th>
		<th>Diff</th>
	</tr>	
<?php
renderDataByPC($arrGrandTotal, $arrProfit, 'Grand total','budget-total');
?>
<tr>
		<td>Last</td>
<?php
foreach($arrProfit as $pc=>$flag){
	?>
	<td class='budget-decimal'><?php Reports::render($arrGrandTotal['last'][$pc]);?></td>
	<?php
}
?>
	<td class='budget-decimal budget-ytd'><?php Reports::render(array_sum($arrGrandTotal['last']));?></td>
</tr>
<tr>
		<td>Diff</td>
<?php
foreach($arrProfit as $pc=>$flag){
	?>
	<td class='budget-decimal'><?php Reports::render($arrGrandTotal['this'][$pc]-$arrGrandTotal['last'][$pc]);?></td>
	<?php
}
?>
	<td class='budget-decimal budget-ytd'><?php Reports::render(array_sum($arrGrandTotal['this'])-array_sum($arrGrandTotal['last']));?></td>
</tr>
<?php
foreach ($arrGP as $customer=>$data){
	renderDataByPC($data, $arrProfit, $customer);	
}
?>
</tfoot>
</table>
<button onclick='SelectContent("report");'>Copy table</button>
<?php
include ('includes/inc-frame_bottom.php');
?>