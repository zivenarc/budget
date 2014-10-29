<?php
// $flagNoAuth = true;
require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/reports.class.php');
require ('classes/item.class.php');

$budget_scenario = isset($_GET['budget_scenario'])?$_GET['budget_scenario']:$budget_scenario;

$oBudget = new Budget($budget_scenario);
$denominator = isset($_GET['denominator'])?(double)$_GET['denominator']:1;

$arrJS[] = 'js/rep_totals.js';
include ('includes/inc-frame_top.php');
echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,'</h1>';
if ($denominator!=1) {
	echo '<h2>RUB x',$denominator,'</h2>';
}
echo '<p>',$oBudget->timestamp,'</p>';
?>
<div class='f-row'><label for='budget_scenario'>Select scenario</label><?php echo Budget::getScenarioSelect();?></div>
<?php

$sql = "SELECT Profit, pccFlagProd, `Budget item`, `Group`, `item`, `Group_code`, SUM(".Budget::getYTDSQL().")/$denominator as Total, SUM(estimate)/$denominator as Estimate
		FROM vw_master
		WHERE scenario='$budget_scenario' AND pccFlagProd=0
		GROUP BY Profit, `Budget item`,`item`
		ORDER BY `Group`,Profit,itmOrder";
$rs = $oSQL->q($sql);
while ($rw=$oSQL->f($rs)){

	// $keyProfit = Budget::getProfitAlias($rw);
	$keyProfit = $rw['Profit'];
	
	if ($rw['item']==Items::REVENUE || $rw['item']==Items::INTERCOMPANY_REVENUE){
		$arrRevenue[$keyProfit] += $rw['Total'];
		$arrRevenueEst += $rw['Estimate'];
	}

	$arrReport[$rw['Group']][$rw['Budget item']][$keyProfit] += $rw['Total'];
	$arrTotal[$rw['Group']][$keyProfit] += $rw['Total'];
	$arrGrandTotal[$keyProfit] += $rw['Total'];
	$arrGrandTotalEstimate[$keyProfit] += $rw['Estimate'];
	$arrEstimate[$rw['Group']][$rw['Budget item']] += $rw['Estimate'];
	$arrProfit[$keyProfit] = $rw['pccFlagProd'];
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
	<tr class="budget-total">
		<td>Total result</td>
<?php
foreach($arrProfit as $pc=>$flag){
	?>
	<td class='budget-decimal'><?php Reports::render($arrGrandTotal[$pc]);?></td>
	<?php
}
?>
	<td class='budget-decimal budget-ytd'><?php Reports::render(array_sum($arrGrandTotal));?></td>
	<td class='budget-decimal'><?php Reports::render(array_sum($arrGrandTotalEstimate));?></td>
	<td class='budget-decimal'><?php Reports::render(array_sum($arrGrandTotal)-array_sum($arrGrandTotalEstimate));?></td>
</tr>
<tr>
		<td>Last</td>
<?php
foreach($arrProfit as $pc=>$flag){
	?>
	<td class='budget-decimal'><?php Reports::render($arrGrandTotalEstimate[$pc]);?></td>
	<?php
}
?>
	<td class='budget-decimal budget-ytd'><?php Reports::render(array_sum($arrGrandTotalEstimate));?></td>
</tr>
<tr>
		<td>Diff</td>
<?php
foreach($arrProfit as $pc=>$flag){
	?>
	<td class='budget-decimal'><?php Reports::render($arrGrandTotal[$pc]-$arrGrandTotalEstimate[$pc]);?></td>
	<?php
}
?>
	<td class='budget-decimal budget-ytd'><?php Reports::render(array_sum($arrGrandTotal)-array_sum($arrGrandTotalEstimate));?></td>
</tr>
</tfoot>
</table>
	<ul class='link-footer'>
		<li><a href='javascript:SelectContent("report");'>Select table</a></li>
	</ul>
<?php
include ('includes/inc-frame_bottom.php');
?>