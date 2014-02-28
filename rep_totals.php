<?php
// $flagNoAuth = true;
require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/item.class.php');

$budget_scenario = isset($_GET['budget_scenario'])?$_GET['budget_scenario']:$budget_scenario;

$oBudget = new Budget($budget_scenario);
$denominator = isset($_GET['denominator'])?(double)$_GET['denominator']:1;

$arrJS[] = 'js/rep_pnl.js';
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
		WHERE scenario='$budget_scenario'
		GROUP BY Profit, `Budget item`,`item`
		ORDER BY `Group`,pccFlagProd,Profit,itmOrder";
$rs = $oSQL->q($sql);
while ($rw=$oSQL->f($rs)){

	if ($rw['pccFlagProd']){
		switch ($rw['Profit']){
			case 'TMMR':
			case 'ICD':
				$keyProfit = 'Toyota';
				break;
			case 'Forwarding':
			case 'STP office':
			case 'NOVO':
			case 'Krekshino':
				$keyProfit = 'FWD';
				break;						
			default:
				$keyProfit = $rw['Profit'];
		}
	} else {
		switch ($rw['Profit']){
			case 'Sales':
				$keyProfit = $rw['Profit'];	
				break;
			default:
			$keyProfit = 'Corporate';
		}
	}
	
	if ($rw['item']==Items::REVENUE || $rw['item']==Items::INTERCOMPANY_REVENUE){
		$arrRevenue[$keyProfit] += $rw['Total'];
		$arrRevenueEst += $rw['Estimate'];
	}

	$arrReport[$rw['Group']][$rw['Budget item']][$keyProfit] += $rw['Total'];
	$arrTotal[$rw['Group']][$keyProfit] += $rw['Total'];
	$arrGrandTotal[$keyProfit] += $rw['Total'];
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
		<th>Estimate</th>
		<th>Diff</th>
	</tr>
</thead>
<tbody>
<?php
foreach($arrReport as $group=>$arrItem){
	foreach($arrItem as $item=>$values){
		echo '<tr>';
		echo '<td>',$item,'</td>';
		foreach($arrProfit as $pc=>$flag){
			$strClass = $values[$pc]<0?"budget-negative":"";
			echo "<td class='budget-decimal $strClass'>",number_format($values[$pc],0,'.',','),'</td>';
		}
		
		$strClass = array_sum($values)<0?"budget-negative":"";
		echo "<td class='budget-decimal budget-ytd $strClass'>",number_format(array_sum($values),0,'.',','),'</td>';
		
		$strClass = $arrEstimate[$group][$item]<0?"budget-negative":"";
		echo "<td class='budget-decimal $strClass'>",number_format($arrEstimate[$group][$item],0,'.',','),'</td>';
		
		$strClass = (array_sum($values) - $arrEstimate[$group][$item])<0?"budget-negative":"";
		echo "<td class='budget-decimal $strClass'>",number_format(array_sum($values) - $arrEstimate[$group][$item],0,'.',','),'</td>';
		
		echo '</tr>';
	}
	
	echo '<tr class="budget-subtotal">';
	echo '<td>',$group,'</td>';
	foreach($arrProfit as $pc=>$flag){
		$strClass = $arrTotal[$group][$pc]<0?"budget-negative":"";
		echo "<td class='budget-decimal $strClass'>",number_format($arrTotal[$group][$pc],0,'.',','),'</td>';
	}
	$strClass = array_sum($arrTotal[$group])<0?"budget-negative":"";
	echo "<td class='budget-decimal budget-ytd $strClass'>",number_format(array_sum($arrTotal[$group]),0,'.',','),'</td>';
	
	$strClass = array_sum($arrEstimate[$group])<0?"budget-negative":"";
	echo "<td class='budget-decimal $strClass'>",number_format(array_sum($arrEstimate[$group]),0,'.',','),'</td>';
	
	$strClass = (array_sum($arrTotal[$group]) - array_sum($arrEstimate[$group]))<0?"budget-negative":"";
	echo "<td class='budget-decimal $strClass'>",number_format(array_sum($arrTotal[$group]) - array_sum($arrEstimate[$group]),0,'.',','),'</td>';
	
	echo '</tr>';

	if ($group == '01.Gross Margin'){
		echo '<tr class="budget-ratio">';
		echo '<td>GP, %</td>';
		foreach($arrProfit as $pc=>$flag){
			$strClass = $arrTotal[$group][$pc]<0?"budget-negative":"";
			
			echo "<td class='budget-decimal $strClass'>",($arrRevenue[$pc]?number_format($arrTotal[$group][$pc]/$arrRevenue[$pc]*100,1,'.',','):'n/a'),'</td>';
		}
		$strClass = array_sum($arrTotal[$group])<0?"budget-negative":"";
		echo "<td class='budget-decimal budget-ytd $strClass'>",number_format(array_sum($arrTotal[$group])/array_sum($arrRevenue)*100,1,'.',','),'</td>';
		
		$strClass = array_sum($arrEstimate[$group])<0?"budget-negative":"";
		echo "<td class='budget-decimal $strClass'>",number_format(array_sum($arrEstimate[$group])/$arrRevenueEst*100,1,'.',','),'</td>';
		
		$strClass = (array_sum($arrTotal[$group]) - array_sum($arrEstimate[$group]))<0?"budget-negative":"";
		echo "<td class='budget-decimal $strClass'>",number_format((array_sum($arrTotal[$group])/array_sum($arrRevenue)-array_sum($arrEstimate[$group])/$arrRevenueEst)*100,1,'.',','),'</td>';
		
		echo '</tr>';
	}
	
}
echo '<tr class="budget-total">';
echo '<td>Total result</td>';
foreach($arrProfit as $pc=>$flag){
	$strClass = $arrGrandTotal[$pc]<0?"budget-negative":"";
	echo "<td class='budget-decimal $strClass'>",number_format($arrGrandTotal[$pc],0,'.',','),'</td>';
}
$strClass = array_sum($arrGrandTotal)<0?"budget-negative":"";
echo "<td class='budget-decimal budget-ytd $strClass'>",number_format(array_sum($arrGrandTotal),0,'.',','),'</td>';
echo '</tr>';

echo '<tr class="budget-ratio">';
echo '<td>% of revenue</td>';

// echo '<pre>';print_r($arrReport);

foreach($arrProfit as $pc=>$flag){
	if ($arrReport['01.Gross Margin']['Revenue'][$pc]){
		$arrCostRatio[$pc] = $arrGrandTotal[$pc]/$arrReport['01.Gross Margin']['Revenue'][$pc]*100;	
	} else {
		$arrCostRatio[$pc]=0;
	}
	$arrCostRatio['Corporate'] = - $arrGrandTotal['Corporate']/array_sum($arrReport['01.Gross Margin']['Revenue'])*100;
	$arrCostRatio['Sales'] = - $arrGrandTotal['Sales']/array_sum($arrReport['01.Gross Margin']['Revenue'])*100;
	$strClass = $arrCostRatio[$pc]<0?"budget-negative":"";
	echo "<td class='budget-decimal $strClass'>",number_format($arrCostRatio[$pc],1,'.',','),'</td>';
}
echo "<td class='budget-decimal $strClass'>",number_format(array_sum($arrGrandTotal)/array_sum($arrReport['01.Gross Margin']['Revenue']),1,'.',','),'</td>';
echo '</tr>';
?>
</tbody>
</table>
	<ul class='link-footer'>
		<li><a href='javascript:SelectContent("report");'>Select table</a></li>
	</ul>
<?php
include ('includes/inc-frame_bottom.php');
?>