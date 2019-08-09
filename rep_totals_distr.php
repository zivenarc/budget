<?php
// $flagNoAuth = true;
require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/reports.class.php');
require ('classes/item.class.php');
include ('includes/inc_report_settings.php');
include ('includes/inc_total_functions.php');

$arrJS[] = 'js/rep_totals.js';

$oBudget = new Budget($budget_scenario);
$oReference = new Budget($reference);

$arrActions[] = Array('title'=>'Apr-Mar','action'=>'?mthStart=4&mthEnd=15');
$arrActions[] = Array('title'=>'Jan-Dec','action'=>'?mthStart=1&mthEnd=12');
$arrActions[] = Array('title'=>'YTD','action'=>'?mthStart='.(1+$oBudget->offset).'&mthEnd='.$oBudget->cm);
$arrActions[] = Array('title'=>'ROY','action'=>'?mthStart='.$oBudget->nm.'&mthEnd='.(12+$oBudget->offset));
$arrActions[] = Array('title'=>'This month','action'=>'?mthStart='.$oBudget->cm.'&mthEnd='.$oBudget->cm);
$arrActions[] = Array('title'=>'Next month','action'=>'?mthStart='.$oBudget->nm.'&mthEnd='.$oBudget->nm);

$sqlWherePC = "AND pccFlagProd=1";

$mthStart = $_GET['mthStart']?(integer)$_GET['mthStart']:1+$oBudget->offset;
$mthEnd = $_GET['mthEnd']?(integer)$_GET['mthEnd']:12+$oBudget->offset;
// $strLastTitle = $oBudget->type=='FYE'?'Budget':$reference;
$strLastTitle = $reference;

$arrRates_this = $oBudget->getMonthlyRates($currency);
$arrRates_last = $oReference->getMonthlyRates($currency);
// echo '<pre>'; print_r($arrRates);echo '</pre>';

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

$repType = 'budget';

switch($repType){
	case 'yact':
	
		define ('STAFF_COSTS', 'J00801:Labor cost');
		define ('GROSS_PROFIT', 'Gross profit');
	
		$sqlAccountString = "CONCAT(`account`,':',`Title`) AS 'AccountTitle', `account` AS 'Account', `yact_group` AS 'GroupTitle', `yact_group_code` AS 'Group'";
		$sqlGroupBy = "`account`";
		break;
	case 'budget':
	default:
		
		define ('STAFF_COSTS', '02.Staff costs');
		define ('GROSS_PROFIT', '01.Gross Margin');
	
		$sqlAccountString = "`Budget item` AS 'AccountTitle', `item` AS 'Account', `Group` AS 'GroupTitle', `Group_code` AS 'Group'";
		$sqlGroupBy = "`item`";
		break;
}

// echo '<pre>';print_r($arrUsrData);echo '</pre>';
if($arrUsrData['PCC']['pccFlagProd']){
	$arrProfit[$arrUsrData['PCC']['pccTitle']] = $arrUsrData['PCC']['pccFlagProd'];
}

$sql = "SELECT Profit, pccFlagProd, {$sqlAccountString} , SUM(".$oBudget->getYTDSQL($mthStart,$mthEnd,$arrRates_this).")/$denominator as Total, 0 as Estimate
		FROM vw_master
		WHERE scenario='{$oBudget->id}' AND company='{$company}' AND account LIKE '5999%' {$sqlWherePC}
		GROUP BY Profit, {$sqlGroupBy}
		UNION ALL
		SELECT Profit, pccFlagProd, {$sqlAccountString}, 0 as Total, SUM(".$oBudget->getYTDSQL($mthStart,$mthEnd,$arrRates_last).")/$denominator as Estimate
		FROM vw_master
		WHERE scenario='{$reference}' AND company='{$company}'  AND account LIKE '5999%' {$sqlWherePC}
		GROUP BY Profit, {$sqlGroupBy}
		ORDER BY `Group`,pccFlagProd,Profit";

// echo '<pre>',$sql,'</pre>';
		
$rs = $oSQL->q($sql);
while ($rw=$oSQL->f($rs)){
	
	// echo '<pre>';print_r ($rw);echo '</pre>';
	
	// if (!$bu_group) {
	if (false) {
		$keyProfit = $oBudget->getProfitAlias($rw);		
	} else {
		$keyProfit = $rw['Profit'];
	}
	
	if ($rw['Account']==Items::REVENUE || $rw['Account']==Items::INTERCOMPANY_REVENUE || $rw['Account']=='J00400'){
		$arrRevenue[$keyProfit] += $rw['Total'];
		$arrRevenueEst += $rw['Estimate'];
	}
		
	$arrReport['this'][$rw['GroupTitle']][$rw['AccountTitle']][$keyProfit] += $rw['Total'];
	$arrReport['last'][$rw['GroupTitle']][$rw['AccountTitle']][$keyProfit] += $rw['Estimate'];
	$arrTotal['this'][$rw['GroupTitle']][$keyProfit] += $rw['Total'];
	$arrTotal['last'][$rw['GroupTitle']][$keyProfit] += $rw['Estimate'];
	$arrGrandTotal['this'][$keyProfit] += $rw['Total'];
	$arrGrandTotal['last'][$keyProfit] += $rw['Estimate'];
	$arrEstimate[$rw['GroupTitle']][$rw['AccountTitle']] += $rw['Estimate'];
	$arrProfit[$keyProfit] = $rw['pccFlagProd'];
}

$sql = "SELECT unit, item, itmTitle, pccTitle as Profit, pccFlagProd, SUM(".$oBudget->getYTDSQL($mthStart,$mthEnd).")/".($mthEnd-$mthStart+1)." as Total, 0 as Estimate
		FROM reg_msf
		LEFT JOIN vw_profit ON pccID=pc
		LEFT JOIN vw_item ON itmGUID=item
		WHERE scenario='{$oBudget->id}'  AND company='{$company}' and posted=1 {$sqlWherePC}
		GROUP BY Profit, item
		UNION ALL
		SELECT unit, item, itmTitle, pccTitle as Profit, pccFlagProd, 0 as Total, SUM(".$oBudget->getYTDSQL($mthStart,$mthEnd).")/".($mthEnd-$mthStart+1)." as Estimate
		FROM reg_msf
		LEFT JOIN vw_profit ON pccID=pc
		LEFT JOIN vw_item ON itmGUID=item
		WHERE scenario='{$reference}'  AND company='{$company}' and posted=1 {$sqlWherePC}
		GROUP BY Profit, item
		ORDER BY pccFlagProd,Profit";

$rs = $oSQL->q($sql);
while ($rw=$oSQL->f($rs)){
	// if (!$bu_group) {
	if (false) {
		$keyProfit = $oBudget->getProfitAlias($rw);		
	} else {
		$keyProfit = $rw['Profit'];
	}
	if($rw['itmTitle']){
		$arrMSF['this'][$rw['itmTitle']][$keyProfit] += $rw['Total'];	
		$arrMSF['last'][$rw['itmTitle']][$keyProfit] += $rw['Estimate'];	
		$arrMSFKeys[$rw['itmTitle']] = $rw['unit'];
	}
}

// echo '<pre>';print_r($arrMSF);echo '</pre>';

?>
<table class='budget' id='report'>
<caption><?php echo $arrUsrData["pagTitle$strLocal"], ' printed on ', date('d.m.Y h:i');?></caption>
<thead>
	<?php echo getTableHeader(Array('Value'));?>
</thead>
<tbody>
<?php
foreach($arrReport['this'] as $group=>$arrItem){
	foreach($arrItem as $item=>$values){
		?>
		<tr>
			<td rowspan="7"><?php echo $item;?></td>
			<td>Cost allocation</td>
		<?php
		foreach($arrProfit as $pc=>$flag){			
			?>
			<td class='budget-decimal'><?php Reports::render($values[$pc]);?></td>
			<?php
		}				
		?>			
			<td class='budget-decimal budget-ytd'><?php Reports::render(array_sum($values));?></td>		
			<td class='budget-decimal'><?php Reports::render(array_sum($arrReport['last'][$group][$item]));?></td>
			<td class='budget-decimal'><?php Reports::render(array_sum($values) - $arrEstimate[$group][$item]);?></td>
			<td class='budget-decimal budget-ratio'><?php Reports::render_ratio(array_sum($values) , $arrEstimate[$group][$item]);?></td>
		</tr>
		<tr>
			<td>Key, <?php echo $arrMSFKeys[$item];?></td>
		<?php
		foreach($arrProfit as $pc=>$flag){			
			?>
			<td class='budget-decimal'><?php Reports::render($arrMSF['this'][$item][$pc],1);?></td>
			<?php
		}

		if(is_array($arrMSF['this'][$item]) && is_array($arrMSF['last'][$item])){
		?>
			<td class='budget-decimal budget-ytd'><?php Reports::render(array_sum($arrMSF['this'][$item]));?></td>		
			<?php
			
			?>
			<td class='budget-decimal'><?php Reports::render(array_sum($arrMSF['last'][$item]));?></td>					
			<td class='budget-decimal'><?php Reports::render(array_sum($arrMSF['this'][$item]) - array_sum($arrMSF['last'][$item]));?></td>
			<td class='budget-decimal budget-ratio'><?php Reports::render_ratio(array_sum($arrMSF['this'][$item]) , array_sum($arrMSF['last'][$item]));?></td>
			<?php 
			} else {
				echo str_repeat("<td>&nbsp;</td>",4);
			}
			?>
		</tr>
		<tr>
			<td>Key, <?php echo $strLastTitle;?></td>
		<?php
		foreach($arrProfit as $pc=>$flag){			
			?>
			<td class='budget-decimal'><?php Reports::render($arrMSF['last'][$item][$pc],1);?></td>
			<?php
		}				
		
		if(is_array($arrMSF['last'][$item])){
		?>
			<td class='budget-decimal budget-ytd'><?php Reports::render(array_sum($arrMSF['last'][$item]));?></td>		
		<?php
		} else {
				echo "<td>&nbsp;</td>";
		}
		?>
			<td>&nbsp;</td>	
			<td>&nbsp;</td>			
			<td>&nbsp;</td>			
		</tr>
		<tr class="budget-ratio">
			<td>Share, %</td>
		<?php
		foreach($arrProfit as $pc=>$flag){			
			if(is_array($arrMSF['this'][$item])){
				?>
				<td class='budget-decimal'><?php Reports::render_ratio($arrMSF['this'][$item][$pc],array_sum($arrMSF['this'][$item]));?></td>
				<?php
			} else {
				echo "<td>&nbsp;</td>";
			}
		}				
		?>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>			
			<td>Deviation, cost</td>
		<?php
		foreach($arrProfit as $pc=>$flag){			
			if(is_array($arrMSF['last'][$item])){
				$arrDeviationCost[$pc] = (array_sum($arrReport['this'][$group][$item])-array_sum($arrReport['last'][$group][$item]))*$arrMSF['last'][$item][$pc]/array_sum($arrMSF['last'][$item]);
			}
			?>
			<td class='budget-decimal'><?php Reports::render($arrDeviationCost[$pc]);?></td>
			<?php
		}				
		?>			
			<td class='budget-decimal budget-ytd'><?php Reports::render(array_sum($arrReport['this'][$group][$item])-array_sum($arrReport['last'][$group][$item]));?></td>		
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>			
		</tr>
		<tr>			
			<td>Redistribution</td>
		<?php
		foreach($arrProfit as $pc=>$flag){			
			?>
			<td class='budget-decimal'><?php Reports::render($arrReport['this'][$group][$item][$pc]-$arrReport['last'][$group][$item][$pc] - $arrDeviationCost[$pc]);?></td>
			<?php
		}				
		?>			
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>			
		</tr>
		<tr class="budget-subtotal">			
			<td>Total deviation</td>
		<?php
		foreach($arrProfit as $pc=>$flag){			
			?>
			<td class='budget-decimal'><?php Reports::render($arrReport['this'][$group][$item][$pc]-$arrReport['last'][$group][$item][$pc]);?></td>
			<?php
		}				
		?>			
			<td class='budget-decimal budget-ytd'><?php Reports::render(array_sum($arrReport['this'][$group][$item])-array_sum($arrReport['last'][$group][$item]));?></td>		
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>			
		</tr>
		<?php
	}
	
	//---Group subtotal
	?>
	<tr class="budget-subtotal">
		<td><?php echo $group;?></td>
		<td>&nbsp;</td>
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
		<td class='budget-decimal budget-ratio'><?php Reports::render_ratio(array_sum($arrTotal['this'][$group]) , array_sum($arrTotal['last'][$group]));?></td>
	</tr>
	<?php
}
?>
</tbody>
<tfoot>
	<?php echo getTableHeader(Array(''));?>
	<tr class="budget-total">
		<td colspan="2">Total corporate costs</td>		
<?php
foreach($arrProfit as $pc=>$flag){
	?>
	<td class='budget-decimal'><?php Reports::render($arrGrandTotal['this'][$pc]);?></td>
	<?php
}
?>
	<td class='budget-decimal budget-ytd'><?php Reports::render(array_sum($arrGrandTotal['this']));?></td>
	<td class='budget-decimal'><?php Reports::render(array_sum($arrGrandTotal['last']));?></td>
	<td class='budget-decimal'><?php Reports::render(array_sum($arrGrandTotal['this'])-array_sum($arrGrandTotal['last']));?></td>
	<td class='budget-decimal budget-ratio'><?php Reports::render_ratio(array_sum($arrGrandTotal['this']),array_sum($arrGrandTotal['last']));?></td>
</tr>
<tr>
		<td colspan="2"><?php echo $strLastTitle;?></td>
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
		<td colspan="2">Diff</td>
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
	<td colspan="2">% of Total</td>
<?php
foreach($arrProfit as $pc=>$flag){
	?>
	<td class='budget-decimal'><?php Reports::render_ratio($arrGrandTotal['this'][$pc],array_sum($arrGrandTotal['this']));?></td>
	<?php
}
?>
	<td class='budget-decimal'>100%</td>
</tr>
</tfoot>
</table>
	<ul class='link-footer'>
		<li><a href='javascript:SelectContent("report");'>Copy table</a></li>
	</ul>
<script>
	$(document).ready(function(){
		$('#bu_group').selectmenu( "option", "disabled", true );
	});
</script>
<?php
include ('includes/inc-frame_bottom.php');
?>