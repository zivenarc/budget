<?php
// $flagNoAuth = true;
require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/reports.class.php');
require ('classes/item.class.php');

include ('includes/inc_rep_activity.php');
include ('includes/inc_report_settings.php');
include ('includes/inc_total_functions.php');

$mthStart = $_GET['mthStart']?(integer)$_GET['mthStart']:1+$oBudget->offset;
$mthEnd = $_GET['mthEnd']?(integer)$_GET['mthEnd']:12+$oBudget->offset;

include ('includes/inc-frame_top.php');
?>
<h1><?php echo $arrUsrData["pagTitle$strLocal"];?></h1>
<?php
include ('includes/inc_report_selectors.php');

if ($mthStart!=1 || $mthEnd!=12){
	if ($mthStart==$mthEnd){
		$periodTitle = date('F',mktime(0,0,0,$mthStart)).' only';
	} else {
		$periodTitle = 'Period: '.date('M',mktime(0,0,0,$mthStart))." &ndash; ". date('M',mktime(0,0,0,$mthEnd));
	}
	echo '<h2>',$periodTitle,'</h2>';
}

echo '<p>',$oBudget->timestamp,'; ',$oBudget->rates,'</p>';


if(true || !isset($_GET['ghq'])){
?>
	<div id='ghq_filter'>
		<ul class='link-footer'>
		<?php
			$sql = "SELECT DISTINCT prtGHQ FROM vw_product_type ORDER BY prtGHQ";
			$rs = $oSQL->q($sql);
			while ($rw = $oSQL->f($rs)){
				?>
				<li><a href="<?php echo $_SERVER['PHP_SELF'],"?budget_scenario={$budget_scenario}&ghq=",urlencode($rw['prtGHQ']);?>"><?php echo $rw['prtGHQ']?$rw['prtGHQ']:"[None]";?></a></li>
				<?php
			}
		?>
		</ul>
	</div>
<?php
}

$sql = "SELECT Profit, pccFlagProd, `Budget item`, `Group`, `item`, `Group_code`, SUM(".$oBudget->getYTDSQL($mthStart, $mthEnd).")/$denominator as Total, SUM(estimate)/$denominator as Estimate
		FROM vw_master
		WHERE scenario='{$budget_scenario}' AND company='{$company}'
		{$sqlActivityFilter}
		GROUP BY Profit, `Budget item`,`item`
		ORDER BY `Group`,pccFlagProd,Profit,itmOrder";
$rs = $oSQL->q($sql);
while ($rw=$oSQL->f($rs)){

	$keyProfit = $rw['Profit'];//Budget::getProfitAlias($rw);
	
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

$sql = "SELECT pccTitle as Profit, pccFlagProd, SUM(".$oBudget->getYTDSQL($mthStart, $mthEnd).")/12 as Total
		FROM reg_headcount
		LEFT JOIN vw_profit ON pccID=pc
		WHERE scenario='$budget_scenario' and posted=1 AND company='{$company}' and salary>10000
		{$sqlActivityFilter}
		GROUP BY Profit
		ORDER BY pccFlagProd,Profit";
$rs = $oSQL->q($sql);
while ($rw=$oSQL->f($rs)){
	$keyProfit = $rw['Profit'];//Budget::getProfitAlias($rw);
	$arrHeadcount['FTE'][$keyProfit] += $rw['Total'];	
}

$sql = "SELECT pccTitle as Profit, pccFlagProd, SUM(".$oBudget->getYTDSQL($mthStart, $mthEnd).")/$denominator as Total, SUM(estimate)/$denominator as Estimate
		FROM reg_master
		LEFT JOIN vw_profit ON pccID=pc
		WHERE scenario='$budget_scenario' and active=1 AND company='{$company}'
			AND account='J00400'
			{$sqlActivityFilter}
		GROUP BY Profit
		ORDER BY pccFlagProd,Profit";
$rs = $oSQL->q($sql);
while ($rw=$oSQL->f($rs)){
	$keyProfit = $rw['Profit'];//Budget::getProfitAlias($rw);
	$arrGrossRevenue['this'][$keyProfit] += $rw['Total'];	
	$arrGrossRevenue['last'] += $rw['Estimate'];	
}

$sql = "SELECT pccTitle as Profit, pccFlagProd, SUM(".$oBudget->getYTDSQL($mthStart, $mthEnd).")/$denominator as Total, SUM(estimate)/$denominator as Estimate
		FROM reg_master
		LEFT JOIN vw_profit ON pccID=pc
		WHERE scenario='$budget_scenario' and active=1 AND company='{$company}'
			AND (account NOT LIKE '6%' AND account NOT LIKE '7%')
		{$sqlActivityFilter}
		GROUP BY Profit
		ORDER BY pccFlagProd,Profit";
$rs = $oSQL->q($sql);
while ($rw=$oSQL->f($rs)){
	$keyProfit = $rw['Profit'];//Budget::getProfitAlias($rw);
	$arrOpIncome['this'][$keyProfit] += $rw['Total'];	
	$arrOpIncome['last'][$keyProfit] += $rw['Estimate'];	
}

$sql = "SELECT pccTitle as Profit, pccFlagProd, SUM(".$oBudget->getYTDSQL($mthStart, $mthEnd).")/$denominator as Total, SUM(estimate)/$denominator as Estimate
		FROM reg_master
		LEFT JOIN vw_profit ON pccID=pc
		WHERE scenario='$budget_scenario' and active=1 AND company='{$company}'
			".Reports::GOP_FILTER."
		{$sqlActivityFilter}
		GROUP BY Profit
		ORDER BY pccFlagProd,Profit";
$rs = $oSQL->q($sql);
while ($rw=$oSQL->f($rs)){
	$keyProfit = $rw['Profit'];//Budget::getProfitAlias($rw);
	$arrGOP['this'][$keyProfit] += $rw['Total'];	
	$arrGOP['last'][$keyProfit] += $rw['Estimate'];	
}

$sql = "SELECT prtTitle, unit, pccTitle as Profit, pccFlagProd, SUM(".$oBudget->getYTDSQL($mthStart, $mthEnd).")/$denominator as Total
		##, SUM(estimate)/$denominator as Estimate
		FROM reg_sales
		LEFT JOIN vw_profit ON pccID=pc
		LEFT JOIN vw_product_type ON prtID=activity
		WHERE scenario='$budget_scenario' and posted=1 and kpi=1 AND company='{$company}'		
		{$sqlActivityFilter}
		GROUP BY activity, Profit
		ORDER BY activity, pccFlagProd,Profit";
$rs = $oSQL->q($sql);
while ($rw=$oSQL->f($rs)){
	$keyProfit = $rw['Profit'];//Budget::getProfitAlias($rw);
	$arrKPI[$rw['prtTitle'].', '.$rw['unit']][$keyProfit] += $rw['Total'];	
	//$arrKPIEstimate += $rw['Estimate'];	
}

// echo '<pre>';print_r($arrKPI);echo '</pre>';echo $sql;
// echo '<pre>';print_r($arrReport);echo '</pre>';
?>
<table class='budget' id='report'>
<caption><?php echo $_GET['ghq'];?></caption>
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
<tr class="budget-ratio">
	<td>% of revenue</td>
<?php
foreach($arrProfit as $pc=>$flag){
	if ($arrReport['01.Gross Margin']['Revenue'][$pc]){
		$arrCostRatio[$pc] = $arrGrandTotal[$pc]/$arrReport['01.Gross Margin']['Revenue'][$pc]*100;	
	} else {
		$arrCostRatio[$pc]=0;
	}
	$arrCostRatio['Corporate'] = - $arrGrandTotal['Corporate']/array_sum($arrReport['01.Gross Margin']['Revenue'])*100;
	$arrCostRatio['Sales'] = - $arrGrandTotal['Sales']/array_sum($arrReport['01.Gross Margin']['Revenue'])*100;
	?>
	<td class='budget-decimal'><?php Reports::render($arrCostRatio[$pc],1);?></td>
	<?php
}
?>
	<td class='budget-decimal'><?php Reports::render(array_sum($arrGrandTotal)/array_sum($arrReport['01.Gross Margin']['Revenue']),1);?></td>
</tr>
<tr class="budget-ratio">
	<td>Headcount</td>
<?php
foreach($arrProfit as $pc=>$flag){
	?>
	<td class='budget-decimal'><?php Reports::render($arrHeadcount['FTE'][$pc],1);?></td>
	<?php
}
?>
	<td class='budget-decimal'><?php Reports::render(array_sum($arrHeadcount['FTE']),1);?></td>
</tr>
<tr>
	<td>Gross revenue</td>
<?php
foreach($arrProfit as $pc=>$flag){
	?>
	<td class='budget-decimal'><?php Reports::render($arrGrossRevenue['this'][$pc]);?></td>
	<?php
}
?>
	<td class='budget-decimal budget-ytd'><?php Reports::render(array_sum($arrGrossRevenue['this']));?></td>
	<td class='budget-decimal'><?php Reports::render($arrGrossRevenue['last']);?></td>
	<td class='budget-decimal'><?php Reports::render(array_sum($arrGrossRevenue['this'])-$arrGrossRevenue['last']);?></td>
</tr>
<tr class="budget-ratio">
	<td>%of total</td>
<?php
foreach($arrProfit as $pc=>$flag){
	?>
	<td class='budget-decimal'><?php Reports::render_ratio($arrGrossRevenue['this'][$pc],array_sum($arrGrossRevenue['this']));?></td>
	<?php
}
?>
	<td class='budget-decimal budget-ytd'><?php Reports::render(100,1);?></td>	
</tr>
<?php
renderDataByPC($arrGOP, $arrProfit, "Gross Operating Profit","budget-subtotal");
renderDataByPC($arrOpIncome, $arrProfit, "Operating income","budget-subtotal");
?>
<tr class="budget-ratio">
	<td>%of total</td>
<?php
foreach($arrProfit as $pc=>$flag){
	?>
	<td class='budget-decimal'><?php Reports::render($arrOpIncome[$pc]/array_sum($arrOpIncome['this'])*100,1);?></td>
	<?php
}
?>
	<td class='budget-decimal budget-ytd'><?php Reports::render(100,1);?></td>	
</tr>
<tr class="budget-ratio">
	<td>%of revenue</td>
<?php
foreach($arrProfit as $pc=>$flag){
	?>
	<td class='budget-decimal'><?php Reports::render_ratio($arrOpIncome['this'][$pc],$arrGrossRevenue['this'][$pc]);?></td>
	<?php
}

?>
	<td class='budget-decimal budget-ytd'><?php Reports::render_ratio(array_sum($arrOpIncome['this']),array_sum($arrGrossRevenue['this']));?></td>	
	<td class='budget-decimal budget-ytd'><?php Reports::render_ratio($arrOpIncome['last'],$arrGrossRevenue['last']);?></td>
	<td class='budget-decimal'><?php if ($arrGrossRevenue['last']*array_sum($arrGrossRevenue['this'])) Reports::render(array_sum($arrOpIncome['this'])/array_sum($arrGrossRevenue['this'])*100-array_sum($arrOpIncome['last'])/$arrGrossRevenue['last']*100,1);?></td>
</tr>
<tr>
	<td>OI per headcount</td>
<?php
foreach($arrProfit as $pc=>$flag){
	?>
	<td class='budget-decimal'><?php Reports::render_ratio($arrOpIncome['this'][$pc]/100,$arrHeadcount['FTE'][$pc],0);?></td>
	<?php
}
?>
	<td class='budget-decimal budget-ytd'><?php Reports::render_ratio(array_sum($arrOpIncome['this'])/100,array_sum($arrHeadcount['FTE']),0);?></td>
</tr>
<tr><th colspan="<?php echo count($arrProfit)+4;?>">KPI</th></td>
<?php foreach ($arrKPI as $kpi=>$values){ ?>
<tr>
	<td><?php echo $kpi;?></td>
<?php
	foreach($arrProfit as $pc=>$flag){
		?>
		<td class='budget-decimal'><?php Reports::render($values[$pc]);?></td>
		<?php
	}
?>
	<td class='budget-decimal budget-ytd'><?php Reports::render(array_sum($values));?></td>
	<td class='budget-decimal'><?php echo 'n/a';?></td>
	<td class='budget-decimal'><?php echo 'n/a';?></td>
</tr>
<?php 
} 
?>
</tfoot>
</table>
	<ul class='link-footer'>
		<li><a href='javascript:SelectContent("report");'>Copy table</a></li>
	</ul>
<?php
include ('includes/inc-frame_bottom.php');
?>