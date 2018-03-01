<?php
// $flagNoAuth = true;
require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/reports.class.php');
require ('classes/item.class.php');

include ('includes/inc_report_settings.php');
include ('includes/inc_total_functions.php');
include ('includes/inc_report_pcfilter.php'); /// filter and tabs for Business unit

$arrJS[] = 'js/rep_totals.js';

$arrActions[] = Array('title'=>'Apr-Mar','action'=>'?mthStart=4&mthEnd=15');
$arrActions[] = Array('title'=>'Jan-Dec','action'=>'?mthStart=1&mthEnd=12');
$arrActions[] = Array('title'=>'YTD','action'=>'?mthStart='.(1+$oBudget->offset).'&mthEnd='.$oBudget->cm);
$arrActions[] = Array('title'=>'ROY','action'=>'?mthStart='.$oBudget->nm.'&mthEnd='.(12+$oBudget->offset));
$arrActions[] = Array('title'=>'This month','action'=>'?mthStart='.$oBudget->cm.'&mthEnd='.$oBudget->cm);
$arrActions[] = Array('title'=>'Next month','action'=>'?mthStart='.$oBudget->nm.'&mthEnd='.$oBudget->nm);


// if ($bu_group){
	// $sql = "SELECT * FROM common_db.tbl_profit WHERE pccParentCode1C='{$bu_group}'";
	// $rs = $oSQL->q($sql);
	// while ($rw = $oSQL->f($rs)){
		// $arrBus[] = $rw['pccID']; 
	// }
	// $strBUs = implode(',',$arrBus);
	// $sqlWherePC = " AND pc IN ({$strBUs})";
// }


$oBudget = new Budget($budget_scenario);
$oReference = new Budget($reference);
$mthStart = $_GET['mthStart']?(integer)$_GET['mthStart']:1+$oBudget->offset;
$mthEnd = $_GET['mthEnd']?(integer)$_GET['mthEnd']:12+$oBudget->offset;
// $strLastTitle = $oBudget->type=='FYE'?'Budget':$reference;
$strLastTitle = $oReference->title;

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

if(isset($_GET['pccGUID'])){
	$sqlWherePC = "AND pc IN (".implode(',',$filter['pc']).")";
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

	$sql = "SELECT activity, Activity_title, prtGHQ, {$sqlAccountString} , SUM(".$oBudget->getYTDSQL($mthStart,$mthEnd,$arrRates_this).")/$denominator as Total, 0 as Estimate
			FROM vw_master
			WHERE scenario='{$oBudget->id}' AND company='{$company}' AND account NOT LIKE 'SZ%' {$sqlWherePC}
			GROUP BY activity, {$sqlGroupBy}
			UNION ALL
			SELECT activity, Activity_title, prtGHQ, {$sqlAccountString}, 0 as Total, SUM(".$oBudget->getYTDSQL($mthStart,$mthEnd,$arrRates_last).")/$denominator as Estimate
			FROM vw_master
			WHERE scenario='{$reference}' AND company='{$company}'  AND account NOT LIKE 'SZ%' {$sqlWherePC}
			GROUP BY activity, {$sqlGroupBy}
			ORDER BY `Total` DESC, `Group`, prtGHQ, activity";

	// echo '<pre>',$sql,'</pre>';
			
	$rs = $oSQL->q($sql);
	while ($rw=$oSQL->f($rs)){
		
		$keyActivity = $rw['activity'];
		
		if ($rw['Account']==Items::REVENUE || $rw['Account']==Items::INTERCOMPANY_REVENUE || $rw['Account']=='J00400'){
			$arrRevenue[$keyActivity] += $rw['Total'];
			$arrRevenueEst += $rw['Estimate'];
		}
			
		$arrReport['this'][$rw['GroupTitle']][$rw['AccountTitle']][$keyActivity] += $rw['Total'];
		$arrReport['last'][$rw['GroupTitle']][$rw['AccountTitle']][$keyActivity] += $rw['Estimate'];
		$arrTotal['this'][$rw['GroupTitle']][$keyActivity] += $rw['Total'];
		$arrTotal['last'][$rw['GroupTitle']][$keyActivity] += $rw['Estimate'];
		$arrGrandTotal[$keyActivity] += $rw['Total'];
		$arrGrandTotalEstimate[$keyActivity] += $rw['Estimate'];
		$arrEstimate[$rw['GroupTitle']][$rw['AccountTitle']] += $rw['Estimate'];
		$arrActivity[$keyActivity] = $rw['Activity_title'];
	}

	$sql = "SELECT activity, SUM(".$oBudget->getYTDSQL($mthStart,$mthEnd).")/".($mthEnd-$mthStart+1)." as Total, 0 as Estimate
			FROM reg_headcount
			WHERE scenario='{$oBudget->id}'  AND company='{$company}' and posted=1 and salary>10000 {$sqlWherePC}
			GROUP BY activity
			UNION ALL
			SELECT activity,  0 as Total, SUM(".$oBudget->getYTDSQL($mthStart,$mthEnd).")/".($mthEnd-$mthStart+1)." as Estimate
			FROM reg_headcount
			WHERE scenario='{$reference}'  AND company='{$company}' and posted=1 and salary>10000 {$sqlWherePC}
			GROUP BY activity
			ORDER BY activity";
	$rs = $oSQL->q($sql);
	while ($rw=$oSQL->f($rs)){
		$keyActivity = $rw['activity'];
		$arrHeadcount['this'][$keyActivity] += $rw['Total'];	
		$arrHeadcount['last'][$keyActivity] += $rw['Estimate'];	
	}

	$sql = "SELECT activity, SUM(".$oBudget->getYTDSQL($mthStart,$mthEnd,$arrRates_this).")/$denominator as Total, 0 as Estimate
			FROM reg_master
			WHERE scenario='{$oBudget->id}'  AND company='{$company}' {$sqlWherePC}
				AND (account NOT LIKE '6%' AND account NOT LIKE '7%' AND account NOT LIKE 'SZ%')
			GROUP BY activity
			UNION ALL
			SELECT activity, 0, SUM(".$oBudget->getYTDSQL($mthStart,$mthEnd,$arrRates_last).")/$denominator as Estimate
			FROM reg_master
			WHERE scenario='{$reference}'  AND company='{$company}' {$sqlWherePC}
				AND (account NOT LIKE '6%' AND account NOT LIKE '7%' AND account NOT LIKE 'SZ%')
			GROUP BY activity
			ORDER BY activity";
	$rs = $oSQL->q($sql);
	while ($rw=$oSQL->f($rs)){
		$keyActivity = $rw['activity'];
		$arrOpIncome['this'][$keyActivity] += $rw['Total'];	
		$arrOpIncome['last'][$keyActivity] += $rw['Estimate'];	
	}

	$sql = "SELECT activity, SUM(".$oBudget->getYTDSQL($mthStart,$mthEnd,$arrRates_this).")/$denominator as Total, 0 as Estimate
			FROM reg_master
			WHERE scenario='{$oBudget->id}'  AND company='{$company}' {$sqlWherePC}
				".Reports::GOP_FILTER."
			GROUP BY activity
			UNION ALL
			SELECT activity, 0, SUM(".$oBudget->getYTDSQL($mthStart,$mthEnd,$arrRates_last).")/$denominator as Estimate
			FROM reg_master
			WHERE scenario='{$reference}'  AND company='{$company}' {$sqlWherePC}
				".Reports::GOP_FILTER."
			GROUP BY activity
			ORDER BY activity";
	$rs = $oSQL->q($sql);
	while ($rw=$oSQL->f($rs)){
		$keyActivity = $rw['activity'];
		$arrGOP['this'][$keyActivity] += $rw['Total'];	
		$arrGOP['last'][$keyActivity] += $rw['Estimate'];	
	}

	// echo '<pre>';print_r($arrHeadcount);echo '</pre>';echo $sql;
	// echo '<pre>';print_r($arrReport);echo '</pre>';
	?>
	<table class='budget' id='report_<?php echo $_GET['pccGUID'];?>'>
	<caption><?php echo $arrUsrData["pagTitle$strLocal"], ' printed on ', date('d.m.Y h:i');?></caption>
	<thead>
		<?php echo getTableHeaderAct();?>
	</thead>
	<tbody>
	<?php
	foreach($arrReport['this'] as $group=>$arrItem){
		foreach($arrItem as $item=>$values){
			?>
			<tr>
				<td><?php echo $item;?></td>
			<?php
			foreach($arrActivity as $pc=>$flag){			
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
			<?php
		}
		
		//---Group subtotal
		?>
		<tr class="budget-subtotal">
			<td><?php echo $group;?></td>
		<?php
		foreach($arrActivity as $pc=>$flag){
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
		//------ Ratios for gross margin
		if ($group == GROSS_PROFIT){
			?>
			<tr class="budget-ratio">
				<td>GP, %</td>
				<?php
				foreach($arrActivity as $pc=>$flag){
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
				foreach($arrActivity as $pc=>$flag){
				?>
				<td class='budget-decimal'><?php Reports::render_ratio(-$arrTotal['this'][GROSS_PROFIT][$pc],$arrTotal['this'][STAFF_COSTS][$pc]*100);?></td>
				<?php
			}
			?>
			<td class='budget-decimal budget-ytd'><?php if(is_array($arrTotal['this'][GROSS_PROFIT])) Reports::render_ratio(-array_sum($arrTotal['this'][GROSS_PROFIT]),array_sum($arrTotal['this'][STAFF_COSTS])*100);?></td>
			<td class='budget-decimal'><?php if(is_array($arrEstimate[GROSS_PROFIT])) Reports::render_ratio(-array_sum($arrEstimate[GROSS_PROFIT]),array_sum($arrEstimate[STAFF_COSTS])*100);?></td>		
			</tr>
			<tr class="budget-ratio">
				<td>SC per FTE</td>
				<?php
				foreach($arrActivity as $pc=>$flag){
				?>
				<td class='budget-decimal'><?php Reports::render_ratio(-$arrTotal['this'][STAFF_COSTS][$pc],$arrHeadcount['this'][$pc]*100);?></td>
				<?php
			}
			?>
			<td class='budget-decimal budget-ytd'><?php Reports::render_ratio(-array_sum($arrTotal['this'][STAFF_COSTS]),array_sum($arrHeadcount['this'])*100);?></td>
			<td class='budget-decimal'><?php Reports::render_ratio(-array_sum($arrEstimate[STAFF_COSTS]),array_sum($arrHeadcount['last'])*100);?></td>		
			</tr>
			<?php
		}
		
	}
	?>
	</tbody>
	<tfoot>
		<?php echo getTableHeaderAct();?>
		<tr class="budget-total">
			<td>Profit before tax</td>
	<?php
	foreach($arrActivity as $pc=>$flag){
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
	foreach($arrActivity as $pc=>$flag){
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
	foreach($arrActivity as $pc=>$flag){
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
	foreach($arrActivity as $pc=>$flag){
		if ($arrReport['this'][GROSS_PROFIT]['Revenue'][$pc]){
			$arrCostRatio[$pc] = $arrGrandTotal[$pc]/$arrReport['this'][GROSS_PROFIT]['Revenue'][$pc]*100;	
		} else {
			$arrCostRatio[$pc]=0;
		}
		if(!$flag && is_array($arrReport['this'][GROSS_PROFIT]['Revenue'])){
			$arrCostRatio[$pc] = - $arrGrandTotal[$pc]/array_sum($arrReport['this'][GROSS_PROFIT]['Revenue'])*100;
		}
		?>
		<td class='budget-decimal'><?php Reports::render($arrCostRatio[$pc],1);?></td>
		<?php
	}
	?>
		<td class='budget-decimal'><?php if(is_array($arrReport['this'][GROSS_PROFIT]['Revenue'])) Reports::render_ratio(array_sum($arrGrandTotal),array_sum($arrReport['this'][GROSS_PROFIT]['Revenue']));?></td>
	</tr>
	<tr class="budget-subtotal">
		<td>Headcount</td>
	<?php
	foreach($arrActivity as $pc=>$flag){
		?>
		<td class='budget-decimal'><?php Reports::render($arrHeadcount['this'][$pc],1);?></td>
		<?php
	}
	?>
		<td class='budget-decimal'><?php Reports::render(array_sum($arrHeadcount['this']),1);?></td>
		<td class='budget-decimal'><?php Reports::render(array_sum($arrHeadcount['last']),1);?></td>
		<td class='budget-decimal'><?php Reports::render(array_sum($arrHeadcount['this'])-array_sum($arrHeadcount['last']),1);?></td>
		<td class='budget-decimal'><?php Reports::render_ratio(array_sum($arrHeadcount['this']),array_sum($arrHeadcount['last']),1);?></td>
	</tr>
	<tr>
		<td>Headcount, <?php echo $strLastTitle;?></td>
	<?php
	foreach($arrActivity as $pc=>$flag){
		?>
		<td class='budget-decimal'><?php Reports::render($arrHeadcount['last'][$pc],1);?></td>
		<?php
	}
	?>
		<td class='budget-decimal'><?php Reports::render(array_sum($arrHeadcount['last']),1);?></td>	
	</tr>
	<tr>
		<td>Diff</td>
	<?php
	foreach($arrActivity as $pc=>$flag){
		?>
		<td class='budget-decimal'><?php Reports::render($arrHeadcount['this'][$pc]-$arrHeadcount['last'][$pc],1);?></td>
		<?php
	}
	?>
		<td class='budget-decimal'><?php Reports::render(array_sum($arrHeadcount['this']) - array_sum($arrHeadcount['last']),1);?></td>	
	</tr>
	<tr>
		<td>Gross revenue</td>
	<?php
	foreach($arrActivity as $pc=>$flag){
		?>
		<td class='budget-decimal'><?php Reports::render($arrGrossRevenue[$pc]);?></td>
		<?php
	}
	?>
		<td class='budget-decimal budget-ytd'><?php if(is_array($arrGrossRevenue)) Reports::render(array_sum($arrGrossRevenue));?></td>
		<td class='budget-decimal'><?php Reports::render($arrGrossRevenueEstimate);?></td>
		<td class='budget-decimal'><?php if(is_array($arrGrossRevenue)) Reports::render(array_sum($arrGrossRevenue)-$arrGrossRevenueEstimate);?></td>
		<td class='budget-decimal budget-ratio'><?php if(is_array($arrGrossRevenue)) Reports::render_ratio(array_sum($arrGrossRevenue),$arrGrossRevenueEstimate);?></td>
	</tr>
	<tr class="budget-ratio">
		<td>%of total</td>
	<?php
	foreach($arrActivity as $pc=>$flag){
		?>
		<td class='budget-decimal'><?php if(is_array($arrGrossRevenue)) Reports::render_ratio($arrGrossRevenue[$pc],array_sum($arrGrossRevenue));?></td>
		<?php
	}
	?>
		<td class='budget-decimal budget-ytd'><?php Reports::render(100,1);?></td>	
	</tr>
	<?php 
	renderActualVsBudget($arrGOP, $arrActivity, "Gross Operating Profit",$strLastTitle);
	renderActualVsBudget($arrOpIncome, $arrActivity, "Operating income",$strLastTitle);
	?>
	<tr class="budget-ratio">
		<td>OI, %of total</td>
	<?php
	foreach($arrActivity as $pc=>$flag){
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
	foreach($arrActivity as $pc=>$flag){
		?>
		<td class='budget-decimal'><?php Reports::render_ratio($arrOpIncome['this'][$pc],$arrGrossRevenue[$pc]);?></td>
		<?php
	}
	?>
		<td class='budget-decimal budget-ytd'><?php if(is_array($arrGrossRevenue)) Reports::render_ratio(array_sum($arrOpIncome['this']),array_sum($arrGrossRevenue));?></td>	
		<td class='budget-decimal budget-ytd'><?php Reports::render_ratio(array_sum($arrOpIncome['last']),$arrGrossRevenueEstimate);?></td>	
	</tr>
	<tr>
		<td>OI per headcount</td>
	<?php
	foreach($arrActivity as $pc=>$flag){
		?>
		<td class='budget-decimal'><?php Reports::render_ratio($arrOpIncome['this'][$pc]/100,$arrHeadcount['this'][$pc],0);?></td>
		<?php
	}
	?>
		<td class='budget-decimal budget-ytd'><?php Reports::render_ratio(array_sum($arrOpIncome['this'])/100,array_sum($arrHeadcount['this']),0);?></td>
	</tr>
	<tr class="budget-subtotal">
		<td>OP costs</td>
		<?php
		foreach($arrActivity as $pc=>$flag){
		?>
		<td class='budget-decimal'><?php Reports::render($arrOpIncome['this'][$pc]-$arrTotal['this'][GROSS_PROFIT][$pc]);?></td>
		<?php
	}
	?>
	<td class='budget-decimal budget-ytd'><?php if(is_array($arrTotal['this'][GROSS_PROFIT])) Reports::render(array_sum($arrOpIncome['this']) - array_sum($arrTotal['this'][GROSS_PROFIT]));?></td>	
	</tr>
	<tr class="">
		<td>OP costs, <?php echo $strLastTitle;?></td>
		<?php
		foreach($arrActivity as $pc=>$flag){
		?>
		<td class='budget-decimal'><?php Reports::render($arrOpIncome['last'][$pc]-$arrTotal['last'][GROSS_PROFIT][$pc]);?></td>
		<?php
	}
	?>
	<td class='budget-decimal budget-ytd'><?php if(is_array($arrTotal['last'][GROSS_PROFIT])) Reports::render(array_sum($arrOpIncome['last']) - array_sum($arrTotal['last'][GROSS_PROFIT]));?></td>	
	</tr>
	<tr>
		<td>Op.cost per headcount</td>
	<?php
	foreach($arrActivity as $pc=>$flag){
		?>
		<td class='budget-decimal'><?php Reports::render_ratio(($arrOpIncome['this'][$pc]-$arrTotal['this'][GROSS_PROFIT][$pc])/100,$arrHeadcount['this'][$pc],0);?></td>
		<?php
	}
	?>
		<td class='budget-decimal budget-ytd'><?php if(is_array($arrTotal['this'][GROSS_PROFIT]))Reports::render_ratio((array_sum($arrOpIncome['this'])-array_sum($arrTotal['this'][GROSS_PROFIT]))/100,array_sum($arrHeadcount['this']),0);?></td>
	</tr>
	</tfoot>
	</table>
		<ul class='link-footer'>
			<li><a href='javascript:SelectContent("report_<?php echo $_GET['pccGUID'];?>");'>Copy table</a></li>
		</ul>
	<?php

	die();
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

$oBudget::getProfitTabs('reg_master', true, Array('pccID'=>$arrBus));

include ('includes/inc-frame_bottom.php');
?>