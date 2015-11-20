<?php
// $flagNoAuth = true;
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
$strLastTitle = $oBudget->type=='FYE'?'Budget':$oBudget->reference_scenario->id;

$arrRates = $oBudget->getMonthlyRates($currency);
// echo '<pre>'; print_r($arrRates);echo '</pre>';

$arrJS[] = 'js/rep_totals.js';

$arrUsrData["pagTitle$strLocal"] .= ': '.$oBudget->title;

if($currency!=643){
		$sql = "SELECT * FROM vw_currency WHERE curID={$currency} LIMIT 1";
		$rs = $oSQL->q($sql);
		$rw = $oSQL->f($rs);
		$curTitle = $rw["curTitle$strLocal"];		
} else {
	$curTitle = "RUB";
}

$arrUsrData["pagTitle$strLocal"] .= ': '.$curTitle;

if ($denominator!=1) {
	$arrUsrData["pagTitle$strLocal"] .= ' x'.$denominator;
}

include ('includes/inc-frame_top.php');	
?>
<h1><?php echo $arrUsrData["pagTitle$strLocal"];?></h1>
<form>
<table>
<tr>
<td>
<div id="currency_selector">
	<?php 
		$arrCurrencySelector = Array(978=>'EUR',840=>'USD',643=>'RUB');
		foreach ($arrCurrencySelector as $key=>$title){
			$label = "currency_".$key;
		?>		
		<input type="radio" id="<?php echo $label;?>" name="currency" <?php if ($currency==$key) echo "checked='checked'";?> value="<?php echo $key;?>"><label for="<?php echo $label;?>"><?php echo $title;?></label>
		<?php } ?>
</div>
</td>
<td>
<div id="denominator_selector">
	<?php 
		$arrDSelector = Array(1=>'1',1000=>'1k',1000000=>'1M');
		foreach ($arrDSelector as $key=>$title){
			$label = "denominator_".$key;
		?>		
		<input type="radio" id="<?php echo $label;?>" name="denominator" <?php if ($denominator==$key) echo "checked='checked'";?> value="<?php echo $key;?>"><label for="<?php echo $label;?>"><?php echo $title;?></label>
		<?php } ?>
</div>
</td>
<td>
<div class='f-row'><label for='budget_scenario'>Select scenario</label><?php echo $oBudget->getScenarioSelect();?></div>
</td>
</tr>
</table>
</form>
<script>
	$(document).ready(function(){
		$('#currency_selector, #denominator_selector').buttonset();
		$('input[name="currency"]').change(function(){
			location.search = 'currency='+$(this).val();
		});
		$('input[name="denominator"]').change(function(){
			location.search = 'denominator='+$(this).val();
		});
	});
</script>
<?php
if ($mthStart!=1 || $mthEnd!=12){
	if ($mthStart==$mthEnd){
		echo '<h2>',date('F',mktime(0,0,0,$mthStart)),' only</h2>';
	} else {
		echo '<h2>Period: ',date('M',mktime(0,0,0,$mthStart))," &ndash; ", date('M',mktime(0,0,0,$mthEnd)),'</h2>';
	}
}

echo '<p>',$oBudget->timestamp,'; ',$oBudget->rates,'</p>';

$sql = "SELECT Profit, pccFlagProd, `Budget item`, `Group`, `item`, itmOrder, `Group_code`, SUM(".$oBudget->getYTDSQL($mthStart,$mthEnd,$arrRates).")/$denominator as Total, 0 as Estimate
		FROM vw_master
		WHERE scenario='{$oBudget->id}'
		GROUP BY Profit, `Budget item`,`item`
		UNION ALL
		SELECT Profit, pccFlagProd, `Budget item`, `Group`, `item`, itmOrder, `Group_code`, 0 as Total, SUM(".$oBudget->getYTDSQL($mthStart,$mthEnd,$arrRates).")/$denominator as Estimate
		FROM vw_master
		WHERE scenario='{$oBudget->reference_scenario->id}'
		GROUP BY Profit, `Budget item`,`item`
		ORDER BY `Group`,pccFlagProd,Profit,itmOrder";

// echo '<pre>',$sql,'</pre>';
		
$rs = $oSQL->q($sql);
while ($rw=$oSQL->f($rs)){

	$keyProfit = $oBudget->getProfitAlias($rw);
	
	if ($rw['item']==Items::REVENUE || $rw['item']==Items::INTERCOMPANY_REVENUE){
		$arrRevenue[$keyProfit] += $rw['Total'];
		$arrRevenueEst += $rw['Estimate'];
	}

	$arrReport[$rw['Group']][$rw['Budget item']][$keyProfit] += $rw['Total'];
	$arrTotal['this'][$rw['Group']][$keyProfit] += $rw['Total'];
	$arrTotal['last'][$rw['Group']][$keyProfit] += $rw['Estimate'];
	$arrGrandTotal[$keyProfit] += $rw['Total'];
	$arrGrandTotalEstimate[$keyProfit] += $rw['Estimate'];
	$arrEstimate[$rw['Group']][$rw['Budget item']] += $rw['Estimate'];
	$arrProfit[$keyProfit] = $rw['pccFlagProd'];
}

$sql = "SELECT pccTitle as Profit, pccFlagProd, SUM(".$oBudget->getYTDSQL($mthStart,$mthEnd).")/".($mthEnd-$mthStart+1)." as Total, 0 as Estimate
		FROM reg_headcount
		LEFT JOIN vw_profit ON pccID=pc
		WHERE scenario='{$oBudget->id}' and posted=1 and salary>50
		GROUP BY Profit
		UNION ALL
		SELECT pccTitle as Profit, pccFlagProd, 0 as Total, SUM(".$oBudget->getYTDSQL($mthStart,$mthEnd).")/".($mthEnd-$mthStart+1)." as Estimate
		FROM reg_headcount
		LEFT JOIN vw_profit ON pccID=pc
		WHERE scenario='{$oBudget->reference_scenario->id}' and posted=1 and salary>50
		GROUP BY Profit
		ORDER BY pccFlagProd,Profit";
$rs = $oSQL->q($sql);
while ($rw=$oSQL->f($rs)){
	$keyProfit = $oBudget->getProfitAlias($rw);
	$arrHeadcount['FTE'][$keyProfit] += $rw['Total'];	
	$arrHeadcountBudget['FTE'][$keyProfit] += $rw['Estimate'];	
}

$sql = "SELECT account,Customer_group_code, Profit, pccFlagProd, SUM(".$oBudget->getYTDSQL($mthStart,$mthEnd,$arrRates).")/$denominator as Total, 0 as Estimate
		FROM vw_master		
		WHERE scenario='{$oBudget->id}'
			AND account IN('J00400','J00802')
		GROUP BY account, Customer_group_code, Profit
		UNION ALL
		SELECT account,Customer_group_code, Profit, pccFlagProd, 0, SUM(".$oBudget->getYTDSQL($mthStart,$mthEnd,$arrRates).")/$denominator as Estimate
		FROM vw_master		
		WHERE scenario='{$oBudget->reference_scenario->id}'
			AND account IN('J00400','J00802')
		GROUP BY account,Customer_group_code, Profit
		ORDER BY pccFlagProd,Profit";
$rs = $oSQL->q($sql);
while ($rw=$oSQL->f($rs)){
	$keyProfit = $oBudget->getProfitAlias($rw);
	
	if ($rw['account']=='J00400'){
		$arrGrossRevenue[$keyProfit] += $rw['Total'];	
		$arrGrossRevenueEstimate += $rw['Estimate'];
	}
	
	switch ($rw['Customer_group_code']){
		case 33239:
			$cusGroup = 'New customers';
			break;
		case 31153:
			$cusGroup = 'Brought in 2015';
			break;
		default:
			$cusGroup = 'Old customers';
			break;
	}
	
	$arrGP[$cusGroup]['this'][$keyProfit] += $rw['Total'];
	$arrGPTotal['this'][$keyProfit] += $rw['Total'];
	$arrGP[$cusGroup]['last'][$keyProfit] += $rw['Estimate'];
	$arrGPTotal['last'][$keyProfit] += $rw['Estimate'];
}

$sql = "SELECT pccTitle as Profit, pccFlagProd, SUM(".$oBudget->getYTDSQL($mthStart,$mthEnd,$arrRates).")/$denominator as Total, 0 as Estimate
		FROM reg_master
		LEFT JOIN vw_profit ON pccID=pc
		WHERE scenario='{$oBudget->id}'
			AND (account NOT LIKE '6%' AND account NOT LIKE '7%')
		GROUP BY Profit
		UNION ALL
		SELECT pccTitle as Profit, pccFlagProd, 0, SUM(".$oBudget->getYTDSQL($mthStart,$mthEnd,$arrRates).")/$denominator as Estimate
		FROM reg_master
		LEFT JOIN vw_profit ON pccID=pc
		WHERE scenario='{$oBudget->reference_scenario->id}'
			AND (account NOT LIKE '6%' AND account NOT LIKE '7%')
		GROUP BY Profit
		ORDER BY pccFlagProd,Profit";
$rs = $oSQL->q($sql);
while ($rw=$oSQL->f($rs)){
	$keyProfit = $oBudget->getProfitAlias($rw);
	$arrOpIncome['this'][$keyProfit] += $rw['Total'];	
	$arrOpIncome['last'][$keyProfit] += $rw['Estimate'];	
}

// echo '<pre>';print_r($arrHeadcount);echo '</pre>';echo $sql;
// echo '<pre>';print_r($arrReport);echo '</pre>';
?>
<table class='budget' id='report'>
<caption><?php echo $arrUsrData["pagTitle$strLocal"], ' printed on ', date('d.m.Y h:i');?></caption>
<thead>
	<tr>
		<th>Account</th>
		<?php foreach($arrProfit as $pc=>$flag){
					echo '<th>',$pc,'</th>';
		};?>
		<th class='budget-ytd'><?php echo $oBudget->type=='FYE'?'FYE':'Total';?></th>
		<th><?php echo $strLastTitle;?></th>
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
	if ($group == GROSS_PROFIT){
		?>
		<tr class="budget-ratio">
			<td>GP, %</td>
			<?php
			foreach($arrProfit as $pc=>$flag){
			?>
			<td class='budget-decimal'><?php Reports::render_ratio($arrTotal['this'][$group][$pc],$arrRevenue[$pc]);?></td>
			<?php
		}
		?>
		<td class='budget-decimal budget-ytd'><?php Reports::render_ratio(array_sum($arrTotal['this'][$group]),array_sum($arrRevenue));?></td>
		<td class='budget-decimal'><?php Reports::render_ratio(array_sum($arrEstimate[$group]),$arrRevenueEst);?></td>				
		<td class='budget-decimal'><?php @Reports::render((array_sum($arrTotal['this'][$group])/array_sum($arrRevenue)-array_sum($arrEstimate[$group])/$arrRevenueEst)*100,1);?></td>				
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
			<td class='budget-decimal'><?php Reports::render_ratio(-$arrTotal['this'][GROSS_PROFIT][$pc],$arrTotal['this'][STAFF_COSTS][$pc]*100);?></td>
			<?php
		}
		?>
		<td class='budget-decimal budget-ytd'><?php Reports::render_ratio(-array_sum($arrTotal['this'][GROSS_PROFIT]),array_sum($arrTotal['this'][STAFF_COSTS])*100);?></td>
		<td class='budget-decimal'><?php Reports::render_ratio(-array_sum($arrEstimate[GROSS_PROFIT]),array_sum($arrEstimate[STAFF_COSTS])*100);?></td>		
		</tr>
		<tr class="budget-ratio">
			<td>SC per FTE</td>
			<?php
			foreach($arrProfit as $pc=>$flag){
			?>
			<td class='budget-decimal'><?php Reports::render_ratio(-$arrTotal['this'][STAFF_COSTS][$pc],$arrHeadcount['FTE'][$pc]*100);?></td>
			<?php
		}
		?>
		<td class='budget-decimal budget-ytd'><?php Reports::render_ratio(-array_sum($arrTotal['this'][STAFF_COSTS]),array_sum($arrHeadcount['FTE'])*100);?></td>
		<td class='budget-decimal'><?php Reports::render_ratio(-array_sum($arrEstimate[STAFF_COSTS]),array_sum($arrHeadcountBudget['FTE'])*100);?></td>		
		</tr>
		<?php
	}
	
}
?>
</tbody>
<tfoot>
	<tr>
		<th>Business unit</th>
		<?php foreach($arrProfit as $pc=>$flag){
					echo '<th>',$pc,'</th>';
		};?>
		<th class='budget-ytd'><?php echo $oBudget->type=='FYE'?'FYE':'Total';?></th>
		<th><?php echo $strLastTitle;?></th>
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
		<td><?php echo $strLastTitle;?></td>
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
	if ($arrReport[GROSS_PROFIT]['Revenue'][$pc]){
		$arrCostRatio[$pc] = $arrGrandTotal[$pc]/$arrReport[GROSS_PROFIT]['Revenue'][$pc]*100;	
	} else {
		$arrCostRatio[$pc]=0;
	}
	$arrCostRatio['Corporate'] = - $arrGrandTotal['Corporate']/array_sum($arrReport[GROSS_PROFIT]['Revenue'])*100;
	$arrCostRatio['Sales'] = - $arrGrandTotal['Sales']/array_sum($arrReport[GROSS_PROFIT]['Revenue'])*100;
	?>
	<td class='budget-decimal'><?php Reports::render($arrCostRatio[$pc],1);?></td>
	<?php
}
?>
	<td class='budget-decimal'><?php Reports::render(array_sum($arrGrandTotal)/array_sum($arrReport[GROSS_PROFIT]['Revenue']),1);?></td>
</tr>
<tr class="budget-subtotal">
	<td>Headcount</td>
<?php
foreach($arrProfit as $pc=>$flag){
	?>
	<td class='budget-decimal'><?php Reports::render($arrHeadcount['FTE'][$pc],1);?></td>
	<?php
}
?>
	<td class='budget-decimal'><?php Reports::render(array_sum($arrHeadcount['FTE']),1);?></td>
	<td class='budget-decimal'><?php Reports::render(array_sum($arrHeadcountBudget['FTE']),1);?></td>
	<td class='budget-decimal'><?php Reports::render(array_sum($arrHeadcount['FTE'])-array_sum($arrHeadcountBudget['FTE']),1);?></td>
</tr>
<tr>
	<td>Headcount, <?php echo $strLastTitle;?></td>
<?php
foreach($arrProfit as $pc=>$flag){
	?>
	<td class='budget-decimal'><?php Reports::render($arrHeadcountBudget['FTE'][$pc],1);?></td>
	<?php
}
?>
	<td class='budget-decimal'><?php Reports::render(array_sum($arrHeadcountBudget['FTE']),1);?></td>	
</tr>
<tr>
	<td>Diff</td>
<?php
foreach($arrProfit as $pc=>$flag){
	?>
	<td class='budget-decimal'><?php Reports::render($arrHeadcount['FTE'][$pc]-$arrHeadcountBudget['FTE'][$pc],1);?></td>
	<?php
}
?>
	<td class='budget-decimal'><?php Reports::render(array_sum($arrHeadcount['FTE']) - array_sum($arrHeadcountBudget['FTE']),1);?></td>	
</tr>
<tr>
	<td>Gross revenue</td>
<?php
foreach($arrProfit as $pc=>$flag){
	?>
	<td class='budget-decimal'><?php Reports::render($arrGrossRevenue[$pc]);?></td>
	<?php
}
?>
	<td class='budget-decimal budget-ytd'><?php Reports::render(array_sum($arrGrossRevenue));?></td>
	<td class='budget-decimal'><?php Reports::render($arrGrossRevenueEstimate);?></td>
	<td class='budget-decimal'><?php Reports::render(array_sum($arrGrossRevenue)-$arrGrossRevenueEstimate);?></td>
</tr>
<tr class="budget-ratio">
	<td>%of total</td>
<?php
foreach($arrProfit as $pc=>$flag){
	?>
	<td class='budget-decimal'><?php Reports::render($arrGrossRevenue[$pc]/array_sum($arrGrossRevenue)*100,1);?></td>
	<?php
}
?>
	<td class='budget-decimal budget-ytd'><?php Reports::render(100,1);?></td>	
</tr>
<?php 
renderDataByPC($arrOpIncome, $arrProfit, "Operating income","budget-subtotal");
?>
<tr>
	<td>Operating income, <?php echo $strLastTitle;?></td>
<?php
foreach($arrProfit as $pc=>$flag){
	?>
	<td class='budget-decimal'><?php Reports::render($arrOpIncome['last'][$pc]);?></td>
	<?php
}
?>
	<td class='budget-decimal budget-ytd'><?php Reports::render(array_sum($arrOpIncome['last']));?></td>	
</tr>
<tr>
	<td>Diff</td>
<?php
foreach($arrProfit as $pc=>$flag){
	?>
	<td class='budget-decimal'><?php Reports::render($arrOpIncome['this'][$pc] - $arrOpIncome['last'][$pc]);?></td>
	<?php
}
?>
	<td class='budget-decimal budget-ytd'><?php Reports::render(array_sum($arrOpIncome['this']) - array_sum($arrOpIncome['last']));?></td>	
</tr>
<tr class="budget-ratio">
	<td>OI, %of total</td>
<?php
foreach($arrProfit as $pc=>$flag){
	?>
	<td class='budget-decimal'><?php Reports::render($arrOpIncome['this'][$pc]/array_sum($arrOpIncome['this'])*100,1);?></td>
	<?php
}
?>
	<td class='budget-decimal budget-ytd'><?php Reports::render(100,1);?></td>	
</tr>
<tr class="budget-ratio">
	<td>OI, %of revenue</td>
<?php
foreach($arrProfit as $pc=>$flag){
	?>
	<td class='budget-decimal'><?php Reports::render_ratio($arrOpIncome['this'][$pc],$arrGrossRevenue[$pc]);?></td>
	<?php
}
?>
	<td class='budget-decimal budget-ytd'><?php Reports::render_ratio(array_sum($arrOpIncome['this']),array_sum($arrGrossRevenue));?></td>	
	<td class='budget-decimal budget-ytd'><?php Reports::render_ratio(array_sum($arrOpIncome['last']),$arrGrossRevenueEstimate);?></td>
	<td class='budget-decimal'><?php Reports::render(array_sum($arrOpIncome['this'])/array_sum($arrGrossRevenue)*100-array_sum($arrOpIncome['last'])/$arrGrossRevenueEstimate*100,1);?></td>
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
<tr class="budget-subtotal">
	<td>OP costs</td>
	<?php
	foreach($arrProfit as $pc=>$flag){
	?>
	<td class='budget-decimal'><?php Reports::render($arrOpIncome['this'][$pc]-$arrTotal['this'][GROSS_PROFIT][$pc]);?></td>
	<?php
}
?>
<td class='budget-decimal budget-ytd'><?php Reports::render(array_sum($arrOpIncome['this']) - array_sum($arrTotal['this'][GROSS_PROFIT]));?></td>	
</tr>
<tr class="">
	<td>OP costs, <?php echo $strLastTitle;?></td>
	<?php
	foreach($arrProfit as $pc=>$flag){
	?>
	<td class='budget-decimal'><?php Reports::render($arrOpIncome['last'][$pc]-$arrTotal['last'][GROSS_PROFIT][$pc]);?></td>
	<?php
}
?>
<td class='budget-decimal budget-ytd'><?php Reports::render(array_sum($arrOpIncome['last']) - array_sum($arrTotal['last'][GROSS_PROFIT]));?></td>	
</tr>
<?php
foreach ($arrGP as $customer=>$data){
	renderDataByPC($data, $arrProfit, $customer);	
}
renderDataByPC($arrGPTotal, $arrProfit, "Total GP", "budget-subtotal");	
?>
</tfoot>
</table>
	<ul class='link-footer'>
		<li><a href='javascript:SelectContent("report");'>Select table</a></li>
	</ul>
<?php
include ('includes/inc-frame_bottom.php');

function renderDataByPC($data, $arrProfit, $strTitle, $strClass=""){
	?>
	<tr class="<?echo $strClass;?>">
		<td><?php echo $strTitle;?></td>
		<?php
		foreach($arrProfit as $pc=>$flag){
			?>
			<td class='budget-decimal'><?php Reports::render($data['this'][$pc]);?></td>
			<?php
		}
		?>
		<td class='budget-decimal budget-ytd'><?php Reports::render(array_sum($data['this']));?></td>
		<td class='budget-decimal '><?php Reports::render(array_sum($data['last']));?></td>
		<td class='budget-decimal '><?php Reports::render(array_sum($data['this']) - array_sum($data['last']));?></td>
	</tr>
	<?php
}

?>