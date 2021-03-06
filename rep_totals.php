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
$arrActions[] = Array('title'=>'&nbsp', 'action'=>'#');
$arrActions[] = Array('title'=>'Budget items','action'=>'?repType=item');
$arrActions[] = Array('title'=>'YACT','action'=>'?repType=yact');

switch ($bu_group){
	case 'no_h':
		$sql = "SELECT * FROM common_db.tbl_profit 
				JOIN stbl_profit_role ON pccID LIKE pcrProfitID AND pcrFlagRead=1
				JOIN stbl_role_user ON rluRoleID=pcrRoleID AND rluUserID='{$arrUsrData['usrID']}'
				WHERE pccFlagFolder=0
				ORDER BY pccParentCode1C, pccTitle";
		$rs = $oSQL->q($sql);
		while ($rw = $oSQL->f($rs)){
			$arrBus[] = $rw['pccID']; 
		}
		$strBUs = implode(',',array_unique($arrBus));
		$sqlWherePC = " AND pc IN ({$strBUs})";
		break;
	case '0':
	case '':
	
		break;
	default:
		$sql = "SELECT * FROM common_db.tbl_profit 
				JOIN stbl_profit_role ON pccID LIKE pcrProfitID
				JOIN stbl_role_user ON rluRoleID=pcrRoleID AND rluUserID='{$arrUsrData['usrID']}'
				WHERE pccParentCode1C='{$bu_group}'
				ORDER BY pccParentCode1C, pccTitle";
		$rs = $oSQL->q($sql);
		while ($rw = $oSQL->f($rs)){
			$arrBus[] = $rw['pccID']; 
		}
		$strBUs = implode(',',array_unique($arrBus));
		$sqlWherePC = " AND pc IN ({$strBUs})";
		break;
}




$mthStart = $_GET['mthStart']?(integer)$_GET['mthStart']:1+$oBudget->offset;
$mthEnd = $_GET['mthEnd']?(integer)$_GET['mthEnd']:12+$oBudget->offset;
// $strLastTitle = $oBudget->type=='FYE'?'Budget':$reference;
$strLastTitle = $oReference->title;

$arrRates_this = $oBudget->getMonthlyRates($currency);
$arrRates_last = $oReference->getMonthlyRates($currency);
// echo '<pre>'; print_r($arrRates);echo '</pre>';

$arrUsrData["pagTitle$strLocal"] .= ': '.$oBudget->title;

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



switch($repType){
	case 'yact':
	
		define ('STAFF_COSTS', 'J00801:Labor cost');
		define ('GROSS_PROFIT', 'Gross profit');
	
		$sqlAccountString = "CONCAT(`account`,':',`Title`) AS 'AccountTitle', `account` AS 'Account', `yact_group` AS 'GroupTitle', `yact_group_code` AS 'Group'";
		$sqlGroupBy = "`account`";
		break;
	case 'item':
	default:
		
		define ('STAFF_COSTS', '02.1 Staff costs (fixed)');
		define ('GROSS_PROFIT', '01.Gross Margin');
	
		$sqlAccountString = "`ITM`.`itmTitle` AS 'AccountTitle', `item` AS 'Account', `ITP`.`itmTitle` AS 'GroupTitle', `ITP`.`itmID` AS 'Group'";
		$sqlGroupBy = "`item`";
		break;
}

//============================= Main query for PnL ==================================
$sql = "SELECT ITM.itmOrder, pccTitle as Profit, pccParentCode1C, pccFlagProd, {$sqlAccountString} , SUM(".$oBudget->getYTDSQL($mthStart,$mthEnd,$arrRates_this).")/$denominator as Total, 0 as Estimate
		FROM reg_master
		LEFT JOIN common_db.tbl_profit ON pc=pccID
		LEFT JOIN vw_item ITM ON itmGUID=item
		LEFT JOIN vw_item ITP ON ITP.itmID=ITM.itmParentID
		WHERE scenario='{$oBudget->id}' AND company='{$company}' AND account NOT LIKE 'SZ%' {$sqlWherePC}
		GROUP BY Profit, {$sqlGroupBy}		
		UNION ALL
		SELECT ITM.itmOrder,pccTitle as Profit, pccParentCode1C, pccFlagProd, {$sqlAccountString}, 0 as Total, SUM(".$oBudget->getYTDSQL($mthStart,$mthEnd,$arrRates_last).")/$denominator as Estimate
		FROM reg_master
		LEFT JOIN common_db.tbl_profit ON pc=pccID
		LEFT JOIN vw_item ITM ON itmGUID=item
		LEFT JOIN vw_item ITP ON ITP.itmID=ITM.itmParentID
		WHERE scenario='{$reference}' AND company='{$company}'  AND account NOT LIKE 'SZ%' {$sqlWherePC}
		GROUP BY Profit, {$sqlGroupBy}
		ORDER BY `Group`,itmOrder, pccParentCode1C, pccFlagProd,Profit";

// echo '<pre>',$sql,'</pre>';		
		
$rs = $oSQL->q($sql);
while ($rw=$oSQL->f($rs)){
	
	if(!$bu_group) {
		$keyProfit = $oBudget->getProfitAlias($rw);	
	
	} else {
		$keyProfit = $rw['Profit'];
	}
	
	if (in_array($rw['Account'],Reports::GROSS_REVENUE_ITEMS)){
		$arrRevenue[$keyProfit] += $rw['Total'];
		$arrRevenueEst += $rw['Estimate'];
	}
		
	$arrReport['this'][$rw['GroupTitle']][$rw['AccountTitle']][$keyProfit] += $rw['Total'];
	$arrReport['last'][$rw['GroupTitle']][$rw['AccountTitle']][$keyProfit] += $rw['Estimate'];
	$arrTotal['this'][$rw['GroupTitle']][$keyProfit] += $rw['Total'];
	$arrTotal['last'][$rw['GroupTitle']][$keyProfit] += $rw['Estimate'];
	$arrGrandTotal[$keyProfit] += $rw['Total'];
	$arrGrandTotalEstimate[$keyProfit] += $rw['Estimate'];
	$arrEstimate[$rw['GroupTitle']][$rw['AccountTitle']] += $rw['Estimate'];
	$arrProfit[$keyProfit] = $rw['pccFlagProd'];
}


$sql = "SELECT pccTitle as Profit, pccFlagProd, SUM(".$oBudget->getYTDSQL($mthStart,$mthEnd).")/".($mthEnd-$mthStart+1)." as Total, 0 as Estimate
		FROM `reg_headcount`
		LEFT JOIN vw_profit ON pccID=pc
		WHERE scenario='{$oBudget->id}'  AND company='{$company}' and posted=1 and salary>10000 {$sqlWherePC}
		GROUP BY Profit
		UNION ALL
		SELECT pccTitle as Profit, pccFlagProd, 0 as Total, SUM(".$oBudget->getYTDSQL($mthEnd,$mthEnd).") as Estimate
		FROM `reg_headcount`
		LEFT JOIN vw_profit ON pccID=pc
		WHERE scenario='{$reference}'  AND company='{$company}' and posted=1 and salary>10000 {$sqlWherePC}
		GROUP BY Profit
		ORDER BY pccFlagProd,Profit";
$rs = $oSQL->q($sql);
while ($rw=$oSQL->f($rs)){
	if(!$bu_group) {
		$keyProfit = $oBudget->getProfitAlias($rw);		
	} else {
		$keyProfit = $rw['Profit'];
	}
	$arrHeadcount['this']['FTE'][$keyProfit] += $rw['Total'];	
	$arrHeadcount['last']['FTE'][$keyProfit] += $rw['Estimate'];	
}

//------------------------------ GROSS PROFIT ---------------------------
$sql = "SELECT account,Customer_group_code, customer, Profit, pccFlagProd, bdv, bdvTitle, SUM(".$oBudget->getYTDSQL($mthStart,$mthEnd,$arrRates_this).")/$denominator as Total, 0 as Estimate
		FROM vw_master		
		WHERE scenario='{$oBudget->id}'  AND company='{$company}' {$sqlWherePC}
		".Reports::GP_FILTER."
		GROUP BY account, Customer_group_code, customer, Profit, bdvTitle
		UNION ALL
		SELECT account,Customer_group_code, customer,  Profit, pccFlagProd, bdv, bdvTitle, 0, SUM(".$oBudget->getYTDSQL($mthStart,$mthEnd,$arrRates_last).")/$denominator as Estimate
		FROM vw_master		
		WHERE scenario='{$reference}'  AND company='{$company}' {$sqlWherePC}
		".Reports::GP_FILTER."
		GROUP BY account,Customer_group_code, customer, Profit, bdvTitle
		ORDER BY pccFlagProd,Profit";
$rs = $oSQL->q($sql);
while ($rw=$oSQL->f($rs)){
	if(!$bu_group) {
		$keyProfit = $oBudget->getProfitAlias($rw);		
	} else {
		$keyProfit = $rw['Profit'];
	}
	
	if (in_array($rw['account'],Array('J00400','J40010'))){
		$arrGrossRevenue[$keyProfit] += $rw['Total'];	
		$arrGrossRevenueEstimate += $rw['Estimate'];
	}
	
	switch($rw['bdv']){
		case 9:
		case 130:
			$bdvGroup = $rw['bdvTitle'];
			$cusGroup = Reports::getCustomerGroup($rw);
			break;
		default:
			$bdvGroup = 'Other';
			$cusGroup = 'Customers handled by OPS';
			break;
	}
	
	
	
	$arrGP[$bdvGroup][$cusGroup]['this'][$keyProfit] += $rw['Total'];
	$arrGPTotal[$bdvGroup]['this'][$keyProfit] += $rw['Total'];
	$arrGP[$bdvGroup][$cusGroup]['last'][$keyProfit] += $rw['Estimate'];
	$arrGPTotal[$bdvGroup]['last'][$keyProfit] += $rw['Estimate'];
}

$sql = "SELECT pccTitle as Profit, pccFlagProd, SUM(".$oBudget->getYTDSQL($mthStart,$mthEnd,$arrRates_this).")/$denominator as Total, 0 as Estimate
		FROM reg_master
		LEFT JOIN vw_profit ON pccID=pc
		WHERE scenario='{$oBudget->id}'  AND company='{$company}' {$sqlWherePC}
			AND (account NOT LIKE '6%' AND account NOT LIKE '7%' AND account NOT LIKE 'SZ%')
		GROUP BY Profit
		UNION ALL
		SELECT pccTitle as Profit, pccFlagProd, 0, SUM(".$oBudget->getYTDSQL($mthStart,$mthEnd,$arrRates_last).")/$denominator as Estimate
		FROM reg_master
		LEFT JOIN vw_profit ON pccID=pc
		WHERE scenario='{$reference}'  AND company='{$company}' {$sqlWherePC}
			AND (account NOT LIKE '6%' AND account NOT LIKE '7%' AND account NOT LIKE 'SZ%')
		GROUP BY Profit
		ORDER BY pccFlagProd,Profit";
$rs = $oSQL->q($sql);
while ($rw=$oSQL->f($rs)){
	if(!$bu_group) {
		$keyProfit = $oBudget->getProfitAlias($rw);		
	} else {
		$keyProfit = $rw['Profit'];
	}
	$arrOpIncome['this'][$keyProfit] += $rw['Total'];	
	$arrOpIncome['last'][$keyProfit] += $rw['Estimate'];	
}

$sql = "SELECT pccTitle as Profit, pccFlagProd, SUM(".$oBudget->getYTDSQL($mthStart,$mthEnd,$arrRates_this).")/$denominator as Total, 0 as Estimate
		FROM reg_master
		LEFT JOIN vw_profit ON pccID=pc
		WHERE scenario='{$oBudget->id}'  AND company='{$company}' {$sqlWherePC}
			".Reports::GOP_FILTER."
		GROUP BY Profit
		UNION ALL
		SELECT pccTitle as Profit, pccFlagProd, 0, SUM(".$oBudget->getYTDSQL($mthStart,$mthEnd,$arrRates_last).")/$denominator as Estimate
		FROM reg_master
		LEFT JOIN vw_profit ON pccID=pc
		WHERE scenario='{$reference}'  AND company='{$company}' {$sqlWherePC}
			".Reports::GOP_FILTER."
		GROUP BY Profit
		ORDER BY pccFlagProd,Profit";
$rs = $oSQL->q($sql);
while ($rw=$oSQL->f($rs)){
	if(!$bu_group) {
		$keyProfit = $oBudget->getProfitAlias($rw);		
	} else {
		$keyProfit = $rw['Profit'];
	}
	$arrGOP['this'][$keyProfit] += $rw['Total'];	
	$arrGOP['last'][$keyProfit] += $rw['Estimate'];	
}


$sql = "SELECT pccTitle as Profit, pccFlagProd, SUM(".$oBudget->getYTDSQL($mthStart,$mthEnd,$arrRates_this).")/$denominator as Total, 0 as Estimate
		FROM reg_master
		LEFT JOIN vw_profit ON pccID=pc
		WHERE scenario='{$oBudget->id}'  AND company='{$company}' {$sqlWherePC}
			".Reports::OWN_OPERATING_PROFIT."
		GROUP BY Profit
		UNION ALL
		SELECT pccTitle as Profit, pccFlagProd, 0, SUM(".$oBudget->getYTDSQL($mthStart,$mthEnd,$arrRates_last).")/$denominator as Estimate
		FROM reg_master
		LEFT JOIN vw_profit ON pccID=pc
		WHERE scenario='{$reference}'  AND company='{$company}' {$sqlWherePC}
			".Reports::OWN_OPERATING_PROFIT."
		GROUP BY Profit
		ORDER BY pccFlagProd,Profit";
$rs = $oSQL->q($sql);
while ($rw=$oSQL->f($rs)){
	if(!$bu_group) {
		$keyProfit = $oBudget->getProfitAlias($rw);		
	} else {
		$keyProfit = $rw['Profit'];
	}
	$arrOOP['this'][$keyProfit] += $rw['Total'];	
	$arrOOP['last'][$keyProfit] += $rw['Estimate'];	
}

// echo '<pre>';print_r($arrHeadcount);echo '</pre>';echo $sql;
// echo '<pre>';print_r($arrReport);echo '</pre>';
?>
<table class='budget' id='report'>
<caption><?php echo $arrUsrData["pagTitle$strLocal"], ' printed on ', date('d.m.Y h:i');?></caption>
<thead>
	<?php echo getTableHeader();?>
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
		<td class='budget-decimal budget-ytd'><?php if(is_array($arrTotal['this'][GROSS_PROFIT])) Reports::render_ratio(-array_sum($arrTotal['this'][GROSS_PROFIT]),array_sum($arrTotal['this'][STAFF_COSTS])*100);?></td>
		<td class='budget-decimal'><?php if(is_array($arrEstimate[GROSS_PROFIT])) Reports::render_ratio(-array_sum($arrEstimate[GROSS_PROFIT]),array_sum($arrEstimate[STAFF_COSTS])*100);?></td>		
		</tr>
		<tr class="budget-ratio">
			<td>GP per FTE</td>
			<?php
			foreach($arrProfit as $pc=>$flag){
			?>
			<td class='budget-decimal'><?php Reports::render_ratio($arrTotal['this'][GROSS_PROFIT][$pc],$arrHeadcount['this']['FTE'][$pc]*100,0);?></td>
			<?php
		}
		?>
		<td class='budget-decimal budget-ytd'><?php Reports::render_ratio(array_sum($arrTotal['this'][GROSS_PROFIT]),array_sum($arrHeadcount['this']['FTE'])*100,0);?></td>
		<td class='budget-decimal'><?php Reports::render_ratio(array_sum($arrEstimate[GROSS_PROFIT]),array_sum($arrHeadcount['last']['FTE'])*100,0);?></td>		
		</tr>
		<tr class="budget-ratio">
			<td>SC per FTE</td>
			<?php
			foreach($arrProfit as $pc=>$flag){
			?>
			<td class='budget-decimal'><?php Reports::render_ratio(-$arrTotal['this'][STAFF_COSTS][$pc],$arrHeadcount['this']['FTE'][$pc]*100,0);?></td>
			<?php
		}
		?>
		<td class='budget-decimal budget-ytd'><?php Reports::render_ratio(-array_sum($arrTotal['this'][STAFF_COSTS]),array_sum($arrHeadcount['this']['FTE'])*100,0);?></td>
		<td class='budget-decimal'><?php Reports::render_ratio(-array_sum($arrEstimate[STAFF_COSTS]),array_sum($arrHeadcount['last']['FTE'])*100,0);?></td>		
		</tr>
		<?php
	}
	
	if ($group == '13.Corporate costs'){
		?>
		<tr class="budget-ratio">
			<td>Corp. cost to GP, %</td>
			<?php
			foreach($arrProfit as $pc=>$flag){
			?>
			<td class='budget-decimal'><?php Reports::render_ratio(-$arrTotal['this'][$group][$pc],$arrTotal['this'][GROSS_PROFIT][$pc],1);?></td>
			<?php
		}
		?>
		<td class='budget-decimal budget-ytd'><?php if(is_array($arrTotal['this'][GROSS_PROFIT])) Reports::render_ratio(-array_sum($arrTotal['this'][$group]),array_sum($arrTotal['this'][GROSS_PROFIT]),1);?></td>
		<td class='budget-decimal'><?php if(is_array($arrEstimate[GROSS_PROFIT])) Reports::render_ratio(-array_sum($arrEstimate[$group]),array_sum($arrEstimate[GROSS_PROFIT]),1);?></td>		
		</tr>
		<?php
	}
}
?>
</tbody>
<tfoot>
	<?php echo getTableHeader();?>
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
foreach($arrProfit as $pc=>$flag){
	?>
	<td class='budget-decimal'><?php Reports::render($arrHeadcount['this']['FTE'][$pc],1);?></td>
	<?php
}
?>
	<td class='budget-decimal'><?php Reports::render(array_sum($arrHeadcount['this']['FTE']),1);?></td>
	<td class='budget-decimal'><?php Reports::render(array_sum($arrHeadcount['last']['FTE']),1);?></td>
	<td class='budget-decimal'><?php Reports::render(array_sum($arrHeadcount['this']['FTE'])-array_sum($arrHeadcount['last']['FTE']),1);?></td>
	<td class='budget-decimal'><?php Reports::render_ratio(array_sum($arrHeadcount['this']['FTE']),array_sum($arrHeadcount['last']['FTE']),1);?></td>
</tr>
<tr>
	<td>Headcount, end of <?php echo $strLastTitle;?></td>
<?php
foreach($arrProfit as $pc=>$flag){
	?>
	<td class='budget-decimal'><?php Reports::render($arrHeadcount['last']['FTE'][$pc],1);?></td>
	<?php
}
?>
	<td class='budget-decimal'><?php Reports::render(array_sum($arrHeadcount['last']['FTE']),1);?></td>	
</tr>
<tr>
	<td>Diff</td>
<?php
foreach($arrProfit as $pc=>$flag){
	?>
	<td class='budget-decimal'><?php Reports::render($arrHeadcount['this']['FTE'][$pc]-$arrHeadcount['last']['FTE'][$pc],1);?></td>
	<?php
}
?>
	<td class='budget-decimal'><?php Reports::render(array_sum($arrHeadcount['this']['FTE']) - array_sum($arrHeadcount['last']['FTE']),1);?></td>	
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
	<td class='budget-decimal budget-ytd'><?php if(is_array($arrGrossRevenue)) Reports::render(array_sum($arrGrossRevenue));?></td>
	<td class='budget-decimal'><?php Reports::render($arrGrossRevenueEstimate);?></td>
	<td class='budget-decimal'><?php if(is_array($arrGrossRevenue)) Reports::render(array_sum($arrGrossRevenue)-$arrGrossRevenueEstimate);?></td>
	<td class='budget-decimal budget-ratio'><?php if(is_array($arrGrossRevenue)) Reports::render_ratio(array_sum($arrGrossRevenue),$arrGrossRevenueEstimate);?></td>
</tr>
<tr class="budget-ratio">
	<td>%of total</td>
<?php
foreach($arrProfit as $pc=>$flag){
	?>
	<td class='budget-decimal'><?php if(is_array($arrGrossRevenue)) Reports::render_ratio($arrGrossRevenue[$pc],array_sum($arrGrossRevenue));?></td>
	<?php
}
?>
	<td class='budget-decimal budget-ytd'><?php Reports::render(100,1);?></td>	
</tr>
<?php 
renderActualVsBudget($arrGOP, $arrProfit, "Gross Operating Profit",$strLastTitle);
renderActualVsBudget($arrOOP, $arrProfit, "OWN operating profit",$strLastTitle);
renderActualVsBudget($arrOpIncome, $arrProfit, "Net operating profit",$strLastTitle);
?>
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
	<td class='budget-decimal budget-ytd'><?php if(is_array($arrGrossRevenue)) Reports::render_ratio(array_sum($arrOpIncome['this']),array_sum($arrGrossRevenue));?></td>	
	<td class='budget-decimal budget-ytd'><?php Reports::render_ratio(array_sum($arrOpIncome['last']),$arrGrossRevenueEstimate);?></td>	
</tr>
<tr>
	<td>OI per headcount</td>
<?php
foreach($arrProfit as $pc=>$flag){
	?>
	<td class='budget-decimal'><?php Reports::render_ratio($arrOpIncome['this'][$pc]/100,$arrHeadcount['this']['FTE'][$pc],0);?></td>
	<?php
}
?>
	<td class='budget-decimal budget-ytd'><?php Reports::render_ratio(array_sum($arrOpIncome['this'])/100,array_sum($arrHeadcount['this']['FTE']),0);?></td>
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
<td class='budget-decimal budget-ytd'><?php if(is_array($arrTotal['this'][GROSS_PROFIT])) Reports::render(array_sum($arrOpIncome['this']) - array_sum($arrTotal['this'][GROSS_PROFIT]));?></td>	
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
<td class='budget-decimal budget-ytd'><?php if(is_array($arrTotal['last'][GROSS_PROFIT])) Reports::render(array_sum($arrOpIncome['last']) - array_sum($arrTotal['last'][GROSS_PROFIT]));?></td>	
</tr>
<tr>
	<td>Op.cost per headcount</td>
<?php
foreach($arrProfit as $pc=>$flag){
	?>
	<td class='budget-decimal'><?php Reports::render_ratio(($arrOpIncome['this'][$pc]-$arrTotal['this'][GROSS_PROFIT][$pc])/100,$arrHeadcount['this']['FTE'][$pc],0);?></td>
	<?php
}
?>
	<td class='budget-decimal budget-ytd'><?php if(is_array($arrTotal['this'][GROSS_PROFIT]))Reports::render_ratio((array_sum($arrOpIncome['this'])-array_sum($arrTotal['this'][GROSS_PROFIT]))/100,array_sum($arrHeadcount['this']['FTE']),0);?></td>
</tr>
<?php
if(is_array($arrGP)){
	foreach ($arrGP as $bdv=>$arrCusGP){
		?>
		<tr><th colspan="<?php echo count($arrProfit)+5;?>">Gross Profit delivered by <?php echo $bdv;?></th></tr>
		<?php
		foreach ($arrCusGP as $customer=>$data){
			renderDataByPC($data, $arrProfit, $customer);	
		}
		renderDataByPC($arrGPTotal[$bdv], $arrProfit, "Total GP", "budget-subtotal");	
	}
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