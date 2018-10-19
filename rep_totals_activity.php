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
	<script>
		$(document).ready(function(){
			$('#ghq_filter li a').button();
		});
	</script>
<?php
}

$arrScenario=Array('this'=>$budget_scenario,'last'=>$reference);

foreach($arrScenario as $scnKey=>$scenario){
	$sql = "SELECT Profit, pccFlagProd, `Budget item`, `Group`, `item`, `Group_code`, SUM(".$oBudget->getYTDSQL($mthStart, $mthEnd).")/$denominator as Total
			FROM vw_master
			WHERE scenario='{$scenario}' AND company='{$company}'
			{$sqlActivityFilter}
			AND pccFlagProd=1
			GROUP BY Profit, `Budget item`,`item`
			ORDER BY `Group`,pccFlagProd,Profit,itmOrder";
	$rs = $oSQL->q($sql);
	while ($rw=$oSQL->f($rs)){

		// $keyProfit = $rw['Profit'];//Budget::getProfitAlias($rw);
		$keyProfit = $oBudget->getProfitAlias($rw,false);
		
		if (in_array($rw['item'],Reports::GROSS_REVENUE_ITEMS)){
			$arrRevenue[$scnKey][$keyProfit] += $rw['Total'];		
		}

		$arrReport[$scnKey][$rw['Group']][$rw['Budget item']][$keyProfit] += $rw['Total'];
		$arrTotal[$scnKey][$rw['Group']][$keyProfit] += $rw['Total'];
		$arrGrandTotal[$scnKey][$keyProfit] += $rw['Total'];	
		$arrProfit[$keyProfit] = $rw['pccFlagProd'];
	}
	
	$sql = "SELECT pccTitle as Profit, pccFlagProd, SUM(".$oBudget->getYTDSQL($mthStart, $mthEnd).")/12 as Total
		FROM reg_headcount
		LEFT JOIN vw_profit ON pccID=pc
		WHERE scenario='{$scenario}' and posted=1 AND company='{$company}' and salary>10000
		{$sqlActivityFilter}
		GROUP BY Profit
		ORDER BY pccFlagProd,Profit";
	$rs = $oSQL->q($sql);
	while ($rw=$oSQL->f($rs)){
		$keyProfit = $oBudget->getProfitAlias($rw,false);
		$arrHeadcount[$scnKey]['FTE'][$keyProfit] += $rw['Total'];	
	}
	
	$sql = "SELECT pccTitle as Profit, pccFlagProd, SUM(".$oBudget->getYTDSQL($mthStart, $mthEnd).")/$denominator as Total
		FROM reg_master
		LEFT JOIN vw_profit ON pccID=pc
		WHERE scenario='{$scenario}' and active=1 AND company='{$company}'
		".Reports::OP_FILTER."
		{$sqlActivityFilter}
		GROUP BY Profit
		ORDER BY pccFlagProd,Profit";
	$rs = $oSQL->q($sql);
	while ($rw=$oSQL->f($rs)){
		$keyProfit = $oBudget->getProfitAlias($rw,false);
		$arrOP[$scnKey][$keyProfit] += $rw['Total'];		
	}
	
	$sql = "SELECT pccTitle as Profit, pccFlagProd, SUM(".$oBudget->getYTDSQL($mthStart, $mthEnd).")/$denominator as Total
		FROM reg_master
		LEFT JOIN vw_profit ON pccID=pc
		WHERE scenario='{$scenario}' and active=1 AND company='{$company}'
			".Reports::GOP_FILTER."
		{$sqlActivityFilter}
		GROUP BY Profit
		ORDER BY pccFlagProd,Profit";
	$rs = $oSQL->q($sql);
	while ($rw=$oSQL->f($rs)){
		$keyProfit = $oBudget->getProfitAlias($rw,false);
		$arrGOP[$scnKey][$keyProfit] += $rw['Total'];			
	}
	
	
	$sql = "SELECT prtTitle, unit, pccTitle as Profit, pccFlagProd, SUM(".$oBudget->getYTDSQL($mthStart, $mthEnd).")/$denominator as Total
			##
			FROM reg_sales
			LEFT JOIN vw_profit ON pccID=pc
			LEFT JOIN vw_product_type ON prtID=activity
			WHERE scenario='{$scenario}' and posted=1 and kpi=1 AND unit<>'' AND company='{$company}'		
			{$sqlActivityFilter}
			GROUP BY activity, Profit
			ORDER BY activity, pccFlagProd,Profit";
	$rs = $oSQL->q($sql);
	while ($rw=$oSQL->f($rs)){
		$keyProfit = $oBudget->getProfitAlias($rw,false);
		$arrKPI[$rw['prtTitle'].', '.$rw['unit']][$scnKey][$keyProfit] += $rw['Total'];	
		//$arrKPIEstimate += $rw['Estimate'];	
	}
	
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
foreach($arrReport['this'] as $group=>$arrItem){
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
			<td class='budget-decimal'><?php if (is_array($arrReport['last'][$group][$item])) Reports::render(array_sum($arrReport['last'][$group][$item]));?></td>
			<td class='budget-decimal'><?php if (is_array($arrReport['last'][$group][$item])) Reports::render(array_sum($values) - array_sum($arrReport['last'][$group][$item]));?></td>
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
			<td class='budget-decimal'><?php Reports::render($arrTotal['this'][$group][$pc]);?></td>
		<?php
	}
	?>
		<td class='budget-decimal budget-ytd'><?php Reports::render(array_sum($arrTotal['this'][$group]));?></td>
		<td class='budget-decimal'><?php Reports::render(array_sum($arrTotal['last'][$group]));?></td>
		<td class='budget-decimal'><?php Reports::render(array_sum($arrTotal['this'][$group]) - array_sum($arrTotal['last'][$group]));?></td>
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
				<td class='budget-decimal'><?php Reports::render_ratio($arrTotal['this'][$group][$pc],$arrRevenue['this'][$pc]);?></td>
				<?php
			}
		?>
		<td class='budget-decimal budget-ytd'><?php Reports::render_ratio(array_sum($arrTotal['this'][$group]),array_sum($arrRevenue['this']));?></td>
		<td class='budget-decimal'><?php Reports::render_ratio(array_sum($arrTotal['last'][$group]),array_sum($arrRevenue['last']));?></td>						
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
renderDataByPC($arrGrandTotal, $arrProfit, "Total result","budget-total");
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
<tr class="budget-ratio">
	<td>% of revenue</td>
<?php
foreach($arrProfit as $pc=>$flag){
	if ($arrRevenue['this'][$pc]){
		$arrCostRatio[$pc] = $arrGrandTotal['this'][$pc]/$arrRevenue['this'][$pc]*100;	
	} else {
		$arrCostRatio[$pc]=0;
	}
	$arrCostRatio['Corporate'] = - $arrGrandTotal['this']['Corporate']/array_sum($arrRevenue['this'])*100;
	$arrCostRatio['Sales'] = - $arrGrandTotal['this']['Sales']/array_sum($arrRevenue['this'])*100;
	?>
	<td class='budget-decimal'><?php Reports::render($arrCostRatio[$pc],1);?></td>
	<?php
}
?>
	<td class='budget-decimal'><?php Reports::render(array_sum($arrGrandTotal['this'])/array_sum($arrRevenue['this']),1);?></td>
</tr>
<tr class="budget-ratio">
	<td>Headcount</td>
<?php
foreach($arrProfit as $pc=>$flag){
	?>
	<td class='budget-decimal'><?php Reports::render($arrHeadcount['this']['FTE'][$pc],1);?></td>
	<?php
}
?>
	<td class='budget-decimal budget-ytd'><?php Reports::render(array_sum($arrHeadcount['this']['FTE']),1);?></td>
	<td class='budget-decimal'><?php Reports::render(array_sum($arrHeadcount['last']['FTE']),1);?></td>
	<td class='budget-decimal'><?php Reports::render(array_sum($arrHeadcount['this']['FTE'])-array_sum($arrHeadcount['last']['FTE']),1);?></td>
</tr>
<?php
renderDataByPC($arrRevenue, $arrProfit, "Gross revenue","budget-subtotal");
?>
<tr class="budget-ratio">
	<td>%of total</td>
<?php
foreach($arrProfit as $pc=>$flag){
	?>
	<td class='budget-decimal'><?php Reports::render_ratio($arrRevenue['this'][$pc],array_sum($arrRevenue['this']));?></td>
	<?php
}
?>
	<td class='budget-decimal budget-ytd'><?php Reports::render(100,1);?></td>	
</tr>
<?php
renderDataByPC($arrGOP, $arrProfit, "Gross Operating Profit","budget-subtotal");
renderDataByPC($arrOP, $arrProfit, "Operating income","budget-subtotal");
?>
<tr class="budget-ratio">
	<td>OP % of total</td>
<?php
foreach($arrProfit as $pc=>$flag){
	?>
	<td class='budget-decimal'><?php Reports::render($arrOP['this'][$pc]/array_sum($arrOP['this'])*100,1);?></td>
	<?php
}
?>
	<td class='budget-decimal budget-ytd'><?php Reports::render(100,1);?></td>	
</tr>
<tr class="budget-ratio">
	<td>OP % of revenue</td>
<?php
foreach($arrProfit as $pc=>$flag){
	?>
	<td class='budget-decimal'><?php Reports::render_ratio($arrOP['this'][$pc],$arrRevenue['this'][$pc]);?></td>
	<?php
}

?>
	<td class='budget-decimal budget-ytd'><?php Reports::render_ratio(array_sum($arrOP['this']),array_sum($arrRevenue['this']));?></td>	
	<td class='budget-decimal budget-ytd'><?php Reports::render_ratio(array_sum($arrOP['last']),array_sum($arrRevenue['last']));?></td>
	<td class='budget-decimal'><?php if (array_sum($arrRevenue['last'])*array_sum($arrRevenue['this'])) Reports::render(array_sum($arrOP['this'])/array_sum($arrRevenue['this'])*100-array_sum($arrOP['last'])/array_sum($arrRevenue['last'])*100,1);?></td>
</tr>
<tr>
	<td>OI per headcount</td>
<?php
foreach($arrProfit as $pc=>$flag){
	?>
	<td class='budget-decimal'><?php Reports::render_ratio($arrOP['this'][$pc]/100,$arrHeadcount['this']['FTE'][$pc],0);?></td>
	<?php
}
?>
	<td class='budget-decimal budget-ytd'><?php Reports::render_ratio(array_sum($arrOP['this'])/100,array_sum($arrHeadcount['this']['FTE']),0);?></td>
</tr>
<tr><th colspan="<?php echo count($arrProfit)+5;?>">KPI</th></td>
<?php 
foreach ($arrKPI as $kpi=>$values){ 
	renderDataByPC($values, $arrProfit, $kpi ,""); 
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