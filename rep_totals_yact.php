<?php
$flagNoAuth = true;
define ('STAFF_COSTS', '02.Staff costs');
define ('GROSS_PROFIT', '01.Gross Margin');


require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/reports.class.php');
require ('classes/item.class.php');

include ('includes/inc_report_settings.php');

$oBudget = new Budget($budget_scenario);
$mthStart = $_GET['mthStart']?(integer)$_GET['mthStart']:1;
$mthEnd = $_GET['mthEnd']?(integer)$_GET['mthEnd']:12;


$arrRates = $oBudget->getMonthlyRates($currency);

$arrJS[] = 'js/rep_totals.js';
include ('includes/inc-frame_top.php');
echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,'</h1>';

if($currency!=643){
		$sql = "SELECT * FROM vw_currency WHERE curID={$currency} LIMIT 1";
		$rs = $oSQL->q($sql);
		$rw = $oSQL->f($rs);
		$curTitle = $rw["curTitle$strLocal"];		
} else {
	$curTitle = "RUB";
}

if ($denominator!=1) {
	echo "<h2>{$curTitle} x{$denominator}</h2>";
} else {
	echo "<h2>{$curTitle}</h2>";
}

if ($mthStart!=1 || $mthEnd!=12){
	if ($mthStart==$mthEnd){
		echo '<h2>',date('F',mktime(0,0,0,$mthStart)),' only</h2>';
	} else {
		echo '<h2>Period: ',date('M',mktime(0,0,0,$mthStart))," &ndash; ", date('M',mktime(0,0,0,$mthEnd)),'</h2>';
	}
}

echo '<p>',$oBudget->timestamp,'; ',$oBudget->rates,'</p>';
?>
<div class='f-row'><label for='budget_scenario'>Select scenario</label><?php echo Budget::getScenarioSelect();?></div>

<?php

$sqlFields = "Profit, pccFlagProd, account, yact_group as 'Group', CONCAT(`account`,': ', `title`) as 'Budget item'";
$sqlGroup = "Profit, `account`";

$sql = "SELECT {$sqlFields} , SUM(".Budget::getYTDSQL($mthStart,$mthEnd,$arrRates).")/$denominator as Total, 0 as Estimate
		FROM vw_master
		WHERE scenario='{$oBudget->id}'
		GROUP BY {$sqlGroup}
		UNION ALL
		SELECT {$sqlFields} , 0 as Total, SUM(".Budget::getYTDSQL($mthStart,$mthEnd,$arrRates).")/$denominator as Estimate
		FROM vw_master
		WHERE scenario='{$oBudget->reference_scenario->id}'
		GROUP BY {$sqlGroup}
		ORDER BY {$sqlGroup}";

// echo '<pre>',$sql,'</pre>';
		
$rs = $oSQL->q($sql);
while ($rw=$oSQL->f($rs)){

	// $keyProfit = Budget::getProfitAlias($rw);
	if (!$rw['pccFlagProd']){
		$keyProfit = "Corporate";
	} else {
		$keyProfit = $rw['Profit'];
	};
	
	$arrReport[$rw['Group']][$rw['Budget item']][$keyProfit] += $rw['Total'];
	$arrTotal[$rw['Group']][$keyProfit] += $rw['Total'];
	$arrGrandTotal[$keyProfit] += $rw['Total'];
	$arrGrandTotalEstimate[$keyProfit] += $rw['Estimate'];
	$arrEstimate[$rw['Group']][$rw['Budget item']] += $rw['Estimate'];
	$arrProfit[$keyProfit] = $rw['pccFlagProd'];
}

$sql = "SELECT pccTitle as Profit, pccFlagProd, SUM(".Budget::getYTDSQL($mthStart,$mthEnd).")/".($mthEnd-$mthStart+1)." as Total, 0 as Estimate
		FROM reg_headcount
		LEFT JOIN vw_profit ON pccID=pc
		WHERE scenario='{$oBudget->id}' and posted=1 and salary>50
		GROUP BY Profit
		UNION ALL
		SELECT pccTitle as Profit, pccFlagProd, 0 as Total, SUM(".Budget::getYTDSQL($mthStart,$mthEnd).")/".($mthEnd-$mthStart+1)." as Estimate
		FROM reg_headcount
		LEFT JOIN vw_profit ON pccID=pc
		WHERE scenario='{$oBudget->reference_scenario->id}' and posted=1 and salary>50
		GROUP BY Profit
		ORDER BY pccFlagProd,Profit";
$rs = $oSQL->q($sql);
while ($rw=$oSQL->f($rs)){
	$keyProfit = Budget::getProfitAlias($rw);
	$arrHeadcount['FTE'][$keyProfit] += $rw['Total'];	
	$arrHeadcountBudget['FTE'][$keyProfit] += $rw['Estimate'];	
}

$sql = "SELECT pccTitle as Profit, pccFlagProd, SUM(".Budget::getYTDSQL($mthStart,$mthEnd,$arrRates).")/$denominator as Total, 0 as Estimate
		FROM reg_master
		LEFT JOIN vw_profit ON pccID=pc
		WHERE scenario='{$oBudget->id}' and active=1
			AND account='J00400'
		GROUP BY Profit
		UNION ALL
		SELECT pccTitle as Profit, pccFlagProd, 0, SUM(".Budget::getYTDSQL($mthStart,$mthEnd,$arrRates).")/$denominator as Estimate
		FROM reg_master
		LEFT JOIN vw_profit ON pccID=pc
		WHERE scenario='{$oBudget->reference_scenario->id}' and active=1
			AND account='J00400'
		GROUP BY Profit
		ORDER BY pccFlagProd,Profit";
$rs = $oSQL->q($sql);
while ($rw=$oSQL->f($rs)){
	$keyProfit = Budget::getProfitAlias($rw);
	$arrGrossRevenue[$keyProfit] += $rw['Total'];	
	$arrGrossRevenueEstimate += $rw['Estimate'];	
}

$sql = "SELECT pccTitle as Profit, pccFlagProd, SUM(".Budget::getYTDSQL($mthStart,$mthEnd,$arrRates).")/$denominator as Total, 0 as Estimate
		FROM reg_master
		LEFT JOIN vw_profit ON pccID=pc
		WHERE scenario='{$oBudget->id}' and active=1
			AND (account NOT LIKE '6%' AND account NOT LIKE '7%')
		GROUP BY Profit
		UNION ALL
		SELECT pccTitle as Profit, pccFlagProd, 0, SUM(".Budget::getYTDSQL($mthStart,$mthEnd,$arrRates).")/$denominator as Estimate
		FROM reg_master
		LEFT JOIN vw_profit ON pccID=pc
		WHERE scenario='{$oBudget->reference_scenario->id}' and active=1
			AND (account NOT LIKE '6%' AND account NOT LIKE '7%')
		GROUP BY Profit
		ORDER BY pccFlagProd,Profit";
$rs = $oSQL->q($sql);
while ($rw=$oSQL->f($rs)){
	$keyProfit = Budget::getProfitAlias($rw);
	$arrOpIncome[$keyProfit] += $rw['Total'];	
	$arrOpIncomeEstimate[$keyProfit] += $rw['Estimate'];	
}

// echo '<pre>';print_r($arrHeadcount);echo '</pre>';echo $sql;
// echo '<pre>';print_r($arrReport);echo '</pre>';
?>
<table class='budget' id='report'>
<thead>
	<tr>
		<th>Account</th>
		<?php foreach($arrProfit as $pc=>$flag){
					echo '<th>',$pc,'</th>';
		};?>
		<th class='budget-ytd'><?php echo $oBudget->type=='FYE'?'FYE':'Total';?></th>
		<th><?php echo $oBudget->type=='FYE'?'Budget':'Last';?></th>
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
	if ($group == GROSS_PROFIT){
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
	
	if ($group == STAFF_COSTS){
		?>
		<tr class="budget-ratio">
			<td>GP to Staff costs</td>
			<?php
			foreach($arrProfit as $pc=>$flag){
			?>
			<td class='budget-decimal'><?php Reports::render_ratio(-$arrTotal[GROSS_PROFIT][$pc],$arrTotal[STAFF_COSTS][$pc]*100);?></td>
			<?php
		}
		?>
		<td class='budget-decimal budget-ytd'><?php Reports::render_ratio(-array_sum($arrTotal[GROSS_PROFIT]),array_sum($arrTotal[STAFF_COSTS])*100);?></td>
		<td class='budget-decimal'><?php Reports::render_ratio(-array_sum($arrEstimate[GROSS_PROFIT]),array_sum($arrEstimate[STAFF_COSTS])*100);?></td>				
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
		<th class='budget-ytd'><?php echo $oBudget->type=='FYE'?'FYE':'Total';?></th>
		<th><?php echo $oBudget->type=='FYE'?'Budget':'Last';?></th>
		<th>Diff</th>
	</tr>
	<tr class="budget-total">
		<td>Profit before tax</td>
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
		<td><?php echo $oBudget->type=='FYE'?'Budget':'Last';?></td>
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
		<li><a href='javascript:SelectContent("report");'>Copy table</a></li>
	</ul>
<?php
include ('includes/inc-frame_bottom.php');
?>