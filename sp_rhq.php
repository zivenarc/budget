<?php
// $flagNoAuth = true;
require ('common/auth.php');
require ('classes/reference.class.php');
require ('classes/item.class.php');
require ('classes/budget.class.php');
require ('classes/reports.class.php');
//
include ('includes/inc_report_settings.php');
$oBudget = new Budget($budget_scenario);

$arrKeys = Array();
$arrReport = Array('Air export'=>$arrKeys,'Air import'=>$arrKeys,'Ocean export'=>$arrKeys,'Ocean import'=>$arrKeys,'OCM'=>$arrKeys,'Warehouse'=>$arrKeys,'Land transport'=>$arrKeys);

$arrRates = $oBudget->getMonthlyRates($currency);

$sql = "SELECT * FROM vw_profit";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	$arrProfit[$rw['pccID']] = $rw;
}

$arrActions[] = Array('title'=>'Jan-Mar', 'action'=>'?mthStart=1&mthEnd=3');
$arrActions[] = Array('title'=>'Jan-Dec', 'action'=>'?mthStart=1&mthEnd=12');
$arrActions[] = Array('title'=>'Apr-Mar', 'action'=>'?mthStart=4&mthEnd=15');
$arrActions[] = Array('title'=>'Jan-Mar', 'action'=>'?mthStart=1&mthEnd=15');
$startMonth = isset($_GET['mthStart'])?$_GET['mthStart']:1+$oBudget->offset;
$endMonth = isset($_GET['mthEnd'])?$_GET['mthEnd']:12+$oBudget->offset;
$colspan = $endMonth - $startMonth + 4;

$sql = "SELECT pc, prtGHQ, ".$oBudget->getMonthlySumSQL($startMonth,$endMonth, $arrRates)." FROM reg_profit_ghq WHERE scenario='{$budget_scenario}' AND company='{$company}'
		GROUP BY prtGHQ, pc";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=$startMonth;$m<=$endMonth;$m++){
			$month = $oBudget->arrPeriod[$m];
		$arrPC[$rw['pc']][$rw['prtGHQ']][$month] += $rw[$month];
		$arrSubtotal[$rw['pc']][$month] += $rw[$month];
		$arrGHQSubtotal[$rw['prtGHQ']][$month] += $rw[$month];
		$arrRevenue[$month] += $rw[$month];
	}
}

foreach($arrPC as $pc=>$arrGhq){
	foreach ($arrGhq as $ghq=>$values){
		for($m=$startMonth;$m<=$endMonth;$m++){
			$month = $oBudget->arrPeriod[$m];
			$arrRatio[$pc][$ghq][$month] = $arrSubtotal[$pc][$month]?$values[$month]/$arrSubtotal[$pc][$month]:0;
		}
	}
}

// echo '<pre>';print_r($arrRatio);echo '</pre>';

$sqlFields = "account, Title, prtGHQ, pc, SUM(Total_AM) as Total, ".$oBudget->getMonthlySumSQL($startMonth,$endMonth, $arrRates).", SUM(".$oBudget->getThisYTDSQL().") as YTD";
$sqlWhere = "scenario='$budget_scenario' AND company='{$company}' AND source<>'Estimate'";


$sql = "SELECT $sqlFields FROM vw_master 
		WHERE {$sqlWhere} 
		".Reports::REVENUE_FILTER."		
		GROUP by prtGHQ, account
		ORDER BY account"; 
// echo '<pre>',$sql,'</pre>';
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	$reportKey = 'Revenue::'.$rw['account']."::".$rw['Title'];
	for($m=$startMonth;$m<=$endMonth;$m++){
			$month = $oBudget->arrPeriod[$m];
		$arrReport[$rw['prtGHQ']][$reportKey][$month] += $rw[$month];
		$arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
	$arrReport[$rw['prtGHQ']][$reportKey]['YTD'] += $rw['YTD'];
	$arrReport[$rw['prtGHQ']][$reportKey]['Total'] += $rw['Total'];
	$arrGrandTotal[$reportKey]['YTD'] += $rw['YTD'];
	$arrGrandTotal[$reportKey]['Total'] += $rw['Total'];
}


$sql = "SELECT $sqlFields FROM vw_master 
		WHERE {$sqlWhere} 
		".Reports::DIRECT_COST_FILTER."	
		GROUP by pc, prtGHQ, account
		ORDER BY account";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	$reportKey = 'COS::'.$rw['account']."::".$rw['Title'];
	for($m=$startMonth;$m<=$endMonth;$m++){
			$month = $oBudget->arrPeriod[$m];
		$arrReport[$rw['prtGHQ']][$reportKey][$month] -= $rw[$month];
		$arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
	$arrReport[$rw['prtGHQ']][$reportKey]['YTD'] += $rw['YTD'];
	$arrReport[$rw['prtGHQ']][$reportKey]['Total'] += $rw['Total'];
	$arrGrandTotal[$reportKey]['YTD'] += $rw['YTD'];
	$arrGrandTotal[$reportKey]['Total'] += $rw['Total'];
}

$sql = "SELECT $sqlFields FROM vw_master 
		LEFT JOIN vw_yact YACT ON yctID=account
		WHERE {$sqlWhere} 
		".Reports::RFC_FILTER."
		AND pccFLagProd = 1
		GROUP by pc, prtGHQ, account
		ORDER BY account";
// echo '<pre>',$sql,'</pre>';
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	$reportKey = $rw['account']."::".$rw['Title'];
	for($m=$startMonth;$m<=$endMonth;$m++){
			$month = $oBudget->arrPeriod[$m];
		$arrReport[$rw['prtGHQ']][$reportKey][$month] -= $rw[$month];
		$arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
	$arrReport[$rw['prtGHQ']][$reportKey]['YTD'] -= $rw['YTD'];
	$arrReport[$rw['prtGHQ']][$reportKey]['Total'] -= $rw['Total'];
	$arrGrandTotal[$reportKey]['YTD'] += $rw['YTD'];
	$arrGrandTotal[$reportKey]['Total'] += $rw['Total'];
}

$sql = "SELECT $sqlFields FROM vw_master 
		LEFT JOIN vw_yact YACT ON yctID=account
		WHERE {$sqlWhere} 
		".Reports::SGA_FILTER."		
		GROUP by pc, prtGHQ, account
		ORDER BY account";
// echo '<pre>',$sql,'</pre>';
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	$reportKey = $rw['account']."::".$rw['Title'];
	for($m=$startMonth;$m<=$endMonth;$m++){
			$month = $oBudget->arrPeriod[$m];
		$arrReport[$rw['prtGHQ']][$reportKey][$month] -= $rw[$month];
		$arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
	$arrReport[$rw['prtGHQ']][$reportKey]['YTD'] -= $rw['YTD'];
	$arrReport[$rw['prtGHQ']][$reportKey]['Total'] -= $rw['Total'];
	$arrGrandTotal[$reportKey]['YTD'] += $rw['YTD'];
	$arrGrandTotal[$reportKey]['Total'] += $rw['Total'];
}

$sql = "SELECT $sqlFields FROM vw_master 
		LEFT JOIN vw_yact YACT ON yctID=account
		WHERE {$sqlWhere} 
		".Reports::CORP_FILTER."		
		GROUP by pc, prtGHQ, account
		ORDER BY account";
// echo '<pre>',$sql,'</pre>';
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	$reportKey = $rw['account']."::".$rw['Title'];
	for($m=$startMonth;$m<=$endMonth;$m++){
			$month = $oBudget->arrPeriod[$m];
		$arrReport[$rw['prtGHQ']][$reportKey][$month] -= $rw[$month];
		$arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
	$arrReport[$rw['prtGHQ']][$reportKey]['YTD'] -= $rw['YTD'];
	$arrReport[$rw['prtGHQ']][$reportKey]['Total'] -= $rw['Total'];
	$arrGrandTotal[$reportKey]['YTD'] += $rw['YTD'];
	$arrGrandTotal[$reportKey]['Total'] += $rw['Total'];
}

/////////////////////// SG&A costs //////////////////////////////// 
$arrSubreport = Array(
					Array('reportKey' => 'Non-operating income',
								'sql' => "SELECT $sqlFields FROM vw_master 
										WHERE {$sqlWhere} AND account LIKE '60%' AND account<>'607000' and pccFlagProd=1
										GROUP by pc, prtGHQ",
								'positive' => true),
					Array('reportKey' => 'Non-operating costs',
								'sql' => "SELECT $sqlFields FROM vw_master 
										WHERE {$sqlWhere}AND (account LIKE '65%' OR account LIKE '66%')  and pccFlagProd=1
										GROUP by pc, prtGHQ"),
					Array('reportKey' => 'NO YACT',
								'sql' => "SELECT $sqlFields FROM vw_master 
									WHERE {$sqlWhere} AND IFNULL(account,'') LIKE '' 
									GROUP by pc, prtGHQ")
				);

for ($i=0;$i<count($arrSubreport);$i++){
	$rs = $oSQL->q($arrSubreport[$i]['sql']);
	while ($rw = $oSQL->f($rs)){
	$activity = $rw['prtGHQ']?$rw['prtGHQ']:"[NO ACTIVITY]";
	for($m=$startMonth;$m<=$endMonth;$m++){
		$month = $oBudget->arrPeriod[$m];
		
		$arrReport[$activity][$arrSubreport[$i]['reportKey']][$month] += $arrSubreport[$i]['positive']?$rw[$month]:-$rw[$month];		
		$arrGrandTotal[$arrSubreport[$i]['reportKey']][$month] += $rw[$month];

	}
	$arrReport[$activity][$arrSubreport[$i]['reportKey']]['YTD'] += $arrSubreport[$i]['positive']?$rw['YTD']:-$rw['YTD'];		
	$arrReport[$activity][$arrSubreport[$i]['reportKey']]['Total'] += $arrSubreport[$i]['positive']?$rw['Total']:-$rw['Total'];		
	$arrGrandTotal[$arrSubreport[$i]['reportKey']]['YTD'] += $rw['YTD'];
	$arrGrandTotal[$arrSubreport[$i]['reportKey']]['Total'] += $rw['Total'];
}
}
// echo '<pre>';print_r($arrReport);echo '</pre>';

include ('includes/inc-frame_top.php');
echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,'</h1>';
include ('includes/inc_report_selectors.php');
echo '<p>',$oBudget->timestamp,'</p>';

?>
<table id='report' class='budget'>
<thead>
</thead>
<tbody>
<?php
$strClass='';
foreach ($arrReport as $ghq=>$arrItems){
	?>
	<tr>
		<th colspan='<?php echo $colspan;?>'><?php echo $ghq;?></th>
	</tr>
	<tr>
		<th>Item</th>
		<?php echo $oBudget->getTableHeader('monthly', $startMonth, $endMonth);?>
		<th class="budget-ytd">YTD</th>
		<th>Total</th>
	</tr>
	<?php
	
	foreach ($arrItems as $item=>$values){
		_echoTR($values,$item,$strClass);
	}
}
?>
</tbody>
<tfoot>
	<tr>
		<th colspan='<?php echo $colspan;?>'>Grand total</th>
	</tr>
	<tr>
		<th>Item</th>
		<?php echo $oBudget->getTableHeader('monthly', $startMonth, $endMonth);?>
		<th class="budget-ytd">YTD</th>
		<th>Total</th>
	</tr>
<?php
foreach ($arrGrandTotal as $item=>$values){
		
		_echoTR($values,$item);
		
		for($m=$startMonth;$m<=$endMonth;$m++){
			$month = $oBudget->arrPeriod[$m];
			$arrNRBT[$month] += $values[$month];
		}
		$arrNRBT['YTD'] += $values['YTD'];
		$arrNRBT['Total'] += $values['Total'];
		
}
_echoTR($arrNRBT,'Total NRBT','budget-total');
?>
</tr>
</tfoot>
</table>

<ul class='link-footer'>
	<li><a href='javascript:SelectContent("report");'>Copy table</a></li>
</ul>


<?php

// $sql = "SELECT * FROM vw_profit WHERE pccFLagProd = 0 AND pccID NOT IN(9,130) AND pccFlagFolder=0";
$sql = "SELECT * FROM vw_profit";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	$arrPCCorp[] = $rw['pccTitle']."({$rw['pccID']})";
}

$sql = "SELECT account, yctTitle, SUM(Total) as Total, ".$oBudget->getMonthlySumSQL($startMonth,$endMonth, $arrRates)."
		FROM vw_master 
		LEFT JOIN vw_yact YACT ON yctID=account
		WHERE scenario='$budget_scenario' AND company='{$company}' AND source<>'Estimate' 
			AND account LIKE '5%'
			##AND (pccFLagProd = 0 AND pc NOT IN(9,130))
		GROUP by account";
$rs = $oSQL->q($sql);
?>
<h2>Corporate costs</h2>
<p><?php echo implode(', ',$arrPCCorp);?></p>
<table class='budget' id='corporate_costs'>
	<thead>
		<th>Title</th>
		<th>Account</th>
		<?php echo $oBudget->getTableHeader('monthly', $startMonth, $endMonth);?>
		<th>Total</th>
	</thead>
	<tbody>
	<?php 
	$arrTotal = Array();
	while ($rw = $oSQL->f($rs)){ ?>
		<tr>
			<td><?php echo $rw['yctTitle'];?></td>
			<td><?php echo $rw['account'];?></td>
			<?php
			$rowTotal = 0;
			for($m=$startMonth;$m<=$endMonth;$m++){
				$month = $oBudget->arrPeriod[$m];
				$rowTotal += $rw[$month];
				$arrTotal[$month]+=$rw[$month];
					echo '<td class="budget-decimal">',number_format(-$rw[$month],0,'.',','),'</td>';				
				}
			?>
			<td class='budget-decimal budget-ytd'><?php echo number_format(-$rowTotal,0,'.',',');?></td>
		</tr>
	<?php } ?>
	</tbody>
	<tfoot>
		<tr class='budget-total'>
			<td colspan="2">Total</td>
			<?php
			$rowTotal = 0;
			for($m=$startMonth;$m<=$endMonth;$m++){
				$month = $oBudget->arrPeriod[$m];
				$rowTotal += $arrTotal[$month];
					echo '<td class="budget-decimal">',number_format(-$arrTotal[$month],0,'.',','),'</td>';				
				}
			?>
			<td class='budget-decimal budget-ytd'><?php echo number_format(-$rowTotal,0,'.',',');?></td>
		</tr>
	</tfoot>
</table>
<ul class='link-footer'>
	<li><a href='javascript:SelectContent("corporate_costs");'>Copy table</a></li>
</ul>

<h2>Activity ratios</h2>
<table class='budget' style='width:auto;'>
<thead>
<tr>
<?php
foreach($arrGHQSubtotal as $ghq=>$revenue){
	echo '<th>',$ghq,'</th>';
}
?>
	<th>Total</th>
</tr>
</thead>
<tbody>
<tr>
<?php
	foreach($arrGHQSubtotal as $ghq=>$revenue){
		echo '<td>',number_format(array_sum($revenue)/array_sum($arrRevenue)*100,1,'.',','),'</td>';
	}
?>
<td>100</td>
</tr>
</tbody>
</table>
<?php
include ('includes/inc-frame_bottom.php');


function error_distribution($params){
	GLOBAL $arrProfit;
	echo '<pre>','Error for PC ',$arrProfit[$params['data']['pc']]['pccTitle'], " ({$params['data']['pc']})"," cannot distribute {$params['reportKey']} in {$params['month']} ({$params['data'][$params['month']]})" ,'</pre>';
	echo '<pre>',$params['sql'],'</pre>';
}

function _echoTR($arrData, $strName="", $strClass=""){
	GLOBAL $startMonth,$endMonth,$oBudget;
	?>
	<tr class="<?php echo $strClass;?>">
		<td><?php echo $strName;?></td>
		<?php 
		for($m=$startMonth;$m<=$endMonth;$m++){
			$month = $oBudget->arrPeriod[$m];
			?>
			<td class="budget-decimal <?php if($m==$oBudget->cm) echo "budget-current";?>"><?php Reports::render($arrData[$month]);?></td>
			<?php
		}
		?>
		<td class="budget-decimal budget-ytd"><?php Reports::render($arrData['YTD']);?></td>
		<td class="budget-decimal budget-ytd"><?php Reports::render($arrData['Total']);?></td>
	</tr>
	<?php
}

?>