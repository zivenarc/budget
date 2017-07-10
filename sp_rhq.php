<?php
// $flagNoAuth = true;
require ('common/auth.php');
require ('classes/reference.class.php');
require ('classes/item.class.php');
require ('classes/budget.class.php');
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
$colspan = $endMonth - $startMonth + 3;

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

$sqlFields = "prtGHQ, pc, SUM(Total) as Total, ".$oBudget->getMonthlySumSQL($startMonth,$endMonth, $arrRates);

$arrFilter = Array(
	Items::REVENUE,
	Items::INTERCOMPANY_REVENUE
);
$reportKey = '<i>Revenue correction</i>';
$sql = "SELECT $sqlFields FROM vw_master 
		WHERE scenario='$budget_scenario' AND company='{$company}' AND source<>'Estimate' AND item in ('".implode("','",$arrFilter)."') AND account='J00802'
		GROUP by prtGHQ"; 
// echo '<pre>',$sql,'</pre>';
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=$startMonth;$m<=$endMonth;$m++){
			$month = $oBudget->arrPeriod[$m];
		$arrReport[$rw['prtGHQ']][$reportKey][$month] -= $rw[$month];
		// $arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}

$arrFreightFilter = Array(45,46,47,48,52,58);

$arrFilter = Array(
	Items::REVENUE,
	Items::INTERCOMPANY_REVENUE
);
$reportKey = '<i>Freight revenue</i>';
$sql = "SELECT $sqlFields FROM vw_master 
		WHERE scenario='$budget_scenario' AND company='{$company}' AND source<>'Estimate' AND item in ('".implode("','",$arrFilter)."') AND activity in (".implode(",",$arrFreightFilter).")
		GROUP by prtGHQ"; 
// echo '<pre>',$sql,'</pre>';
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=$startMonth;$m<=$endMonth;$m++){
			$month = $oBudget->arrPeriod[$m];
		$arrReport[$rw['prtGHQ']][$reportKey][$month] += $rw[$month];
		// $arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}
$reportKey = '<i>Other revenue</i>';
$sql = "SELECT $sqlFields FROM vw_master 
		WHERE scenario='$budget_scenario' AND company='{$company}' AND source<>'Estimate' AND item in ('".implode("','",$arrFilter)."') AND activity not in (".implode(",",$arrFreightFilter).")
		GROUP by prtGHQ"; 
// echo '<pre>',$sql,'</pre>';
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=$startMonth;$m<=$endMonth;$m++){
			$month = $oBudget->arrPeriod[$m];
		$arrReport[$rw['prtGHQ']][$reportKey][$month] += $rw[$month];
		// $arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}

$arrFilter = Array(
	Items::REVENUE,
	Items::INTERCOMPANY_REVENUE
);
$reportKey = 'Revenue';
$sql = "SELECT $sqlFields FROM vw_master 
		WHERE scenario='$budget_scenario' AND company='{$company}' AND source<>'Estimate' AND item in ('".implode("','",$arrFilter)."') 
		GROUP by prtGHQ"; 
// echo '<pre>',$sql,'</pre>';
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=$startMonth;$m<=$endMonth;$m++){
			$month = $oBudget->arrPeriod[$m];
		$arrReport[$rw['prtGHQ']][$reportKey][$month] += $rw[$month];
		$arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}


$arrFilter = Array(
	Items::DIRECT_COSTS,
	Items::INTERCOMPANY_COSTS,
	//Items::CY_RENT,
	//Items::WH_RENT,
	Items::KAIZEN
);
$reportKey = 'Direct costs';
$sql = "SELECT $sqlFields FROM vw_master 
		WHERE scenario='$budget_scenario' AND company='{$company}' AND source<>'Estimate' AND item IN ('".implode("','",$arrFilter)."')
		GROUP by pc, prtGHQ";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=$startMonth;$m<=$endMonth;$m++){
			$month = $oBudget->arrPeriod[$m];
		$arrReport[$rw['prtGHQ']][$reportKey][$month] -= $rw[$month];
		$arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}

$reportKey = '<i>thereof: Freight costs</i>';
$sql = "SELECT $sqlFields FROM vw_master 
		WHERE scenario='$budget_scenario' AND company='{$company}' AND source<>'Estimate' AND item in ('".implode("','",$arrFilter)."') AND activity in (".implode(",",$arrFreightFilter).")
		GROUP by prtGHQ"; 
// echo '<pre>',$sql,'</pre>';
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=$startMonth;$m<=$endMonth;$m++){
			$month = $oBudget->arrPeriod[$m];
		$arrReport[$rw['prtGHQ']][$reportKey][$month] -= $rw[$month];
		// $arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}
$reportKey = '<i>Other costs</i>';
$sql = "SELECT $sqlFields FROM vw_master 
		WHERE scenario='$budget_scenario' AND company='{$company}' AND source<>'Estimate' AND item in ('".implode("','",$arrFilter)."') AND activity not in (".implode(",",$arrFreightFilter).")
		GROUP by prtGHQ"; 
// echo '<pre>',$sql,'</pre>';
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=$startMonth;$m<=$endMonth;$m++){
			$month = $oBudget->arrPeriod[$m];
		$arrReport[$rw['prtGHQ']][$reportKey][$month] -= $rw[$month];
		// $arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}

$reportKey = 'RFC: Labor costs';
$sql = "SELECT $sqlFields FROM vw_master 
		LEFT JOIN vw_yact YACT ON yctID=account
		##WHERE scenario='$budget_scenario' AND source<>'Estimate' AND YACT.yctParentID IN ('59900P') AND LEFT(yctID,1)='J' AND pccFLagProd = 1
		WHERE scenario='$budget_scenario' AND company='{$company}' AND source<>'Estimate' AND account IN('J00801') AND pccFLagProd = 1
		GROUP by pc, prtGHQ";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=$startMonth;$m<=$endMonth;$m++){
			$month = $oBudget->arrPeriod[$m];
		$arrReport[$rw['prtGHQ']][$reportKey][$month] -= $rw[$month];
		$arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}


$reportKey = 'RFC: Warehouse costs';
$sql = "SELECT $sqlFields FROM vw_master 
		LEFT JOIN vw_yact YACT ON yctID=account
		##WHERE scenario='$budget_scenario' AND source<>'Estimate' AND YACT.yctParentID IN ('59900P') AND LEFT(yctID,1)='J' AND pccFLagProd = 1
		WHERE scenario='$budget_scenario' AND company='{$company}' AND source<>'Estimate' AND account IN('J0080W') AND pccFLagProd = 1
		GROUP by pc, prtGHQ";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=$startMonth;$m<=$endMonth;$m++){
			$month = $oBudget->arrPeriod[$m];
		$arrReport[$rw['prtGHQ']][$reportKey][$month] -= $rw[$month];
		$arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}

$reportKey = 'RFC: Depreciation';
$sql = "SELECT $sqlFields FROM vw_master 
		LEFT JOIN vw_yact YACT ON yctID=account
		##WHERE scenario='$budget_scenario' AND source<>'Estimate' AND account IN ('512000','J00806') AND pccFLagProd = 1
		WHERE scenario='$budget_scenario' AND company='{$company}' AND source<>'Estimate' AND account IN ('J00806') AND pccFLagProd = 1
		GROUP by pc, prtGHQ";
// echo '<pre>',$sql,'</pre>';
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=$startMonth;$m<=$endMonth;$m++){
			$month = $oBudget->arrPeriod[$m];
		$arrReport[$rw['prtGHQ']][$reportKey][$month] -= $rw[$month];
		$arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}

$reportKey = 'RFC: Other';
$sql = "SELECT $sqlFields FROM vw_master 
		LEFT JOIN vw_yact YACT ON yctID=account
		WHERE scenario='$budget_scenario' AND company='{$company}' AND source<>'Estimate' AND (YACT.yctParentID IN ('SZ0040') AND account NOT IN ('J00806','J00801','J0080W')) AND pccFLagProd = 1
		GROUP by pc, prtGHQ";
// echo '<pre>',$sql,'</pre>';
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=$startMonth;$m<=$endMonth;$m++){
			$month = $oBudget->arrPeriod[$m];
		$arrReport[$rw['prtGHQ']][$reportKey][$month] -= $rw[$month];
		$arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}

/////////////////////// SG&A costs //////////////////////////////// 
$arrSubreport = Array(
					Array('reportKey' => 'SGA:Sales commission',
								'sql' => "SELECT $sqlFields FROM vw_master 		
							WHERE scenario='$budget_scenario' AND company='{$company}' AND source<>'Estimate' 
								AND account='523000' AND (pccFLagProd = 1 OR pc IN (9,130))
							GROUP by pc, prtGHQ"),
					Array('reportKey' => 'SGA:Personnel costs',
								'sql' => "SELECT $sqlFields FROM vw_master 
										LEFT JOIN vw_yact YACT ON yctID=account		
										WHERE scenario='$budget_scenario' AND company='{$company}' AND source<>'Estimate' 
											AND YACT.yctParentID IN ('59900P') AND (pccFLagProd = 1 OR pc IN (9,130))
										GROUP by pc, prtGHQ"),
					Array('reportKey' => 'SGA:Other',
								'sql' => "SELECT $sqlFields FROM vw_master 
										LEFT JOIN vw_yact YACT ON yctID=account		
										WHERE scenario='$budget_scenario' AND company='{$company}' AND source<>'Estimate' 
											AND YACT.yctParentID IN ('59900S') AND (pccFLagProd = 1 OR pc IN (9,130))
										GROUP by pc, prtGHQ"),
					Array('reportKey' => 'Corporate costs: personnel',
								'sql' => "SELECT $sqlFields FROM vw_master 
										LEFT JOIN vw_yact YACT ON yctID=account
										WHERE scenario='$budget_scenario' AND company='{$company}' AND source<>'Estimate' 
											AND YACT.yctParentID IN ('59900P')  AND (pccFLagProd = 0 AND pc NOT IN(9,130))
										GROUP by pc, prtGHQ"),
					Array('reportKey' => 'Corporate costs: other',
								'sql' => "SELECT $sqlFields FROM vw_master 
										LEFT JOIN vw_yact YACT ON yctID=account
										WHERE scenario='$budget_scenario' AND company='{$company}' AND source<>'Estimate' 
											AND YACT.yctParentID IN ('59900S')  AND (pccFLagProd = 0 AND pc NOT IN(9,130))
										GROUP by pc, prtGHQ"),
					Array('reportKey' => 'MSF',
								'sql' => "SELECT $sqlFields FROM vw_master 
										WHERE scenario='$budget_scenario' AND company='{$company}' AND source<>'Estimate' AND account='527000' 
										GROUP by pc, prtGHQ"),
					Array('reportKey' => 'Non-operating income',
								'sql' => "SELECT $sqlFields FROM vw_master 
										WHERE scenario='$budget_scenario' AND company='{$company}' AND source<>'Estimate' AND account LIKE '60%' AND account<>'607000'
										GROUP by pc, prtGHQ",
								'positive' => true),
					Array('reportKey' => 'Non-operating costs',
								'sql' => "SELECT $sqlFields FROM vw_master 
										WHERE scenario='$budget_scenario' AND company='{$company}' AND source<>'Estimate' AND (account LIKE '65%' OR account LIKE '66%')
										GROUP by pc, prtGHQ"),
					Array('reportKey' => 'NO YACT',
								'sql' => "SELECT $sqlFields FROM vw_master 
									WHERE scenario='$budget_scenario' AND company='{$company}' AND source<>'Estimate' AND IFNULL(account,'') LIKE '' 
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
	<th>Item</th>
	<?php echo $oBudget->getTableHeader('monthly', $startMonth, $endMonth);?>
	<th>Total</th>
</thead>
<tbody>
<?php
$strClass='';
foreach ($arrReport as $ghq=>$arrItems){
	?>
	<tr>
		<th colspan='<?php echo $colspan;?>'><?php echo $ghq;?></th>
	</tr>
	<?php
	
	foreach ($arrItems as $item=>$values){
		?>
		<tr class="<?php echo $strClass;?>">
		<td><?php echo $item;?></td>
		<?php
			for($m=$startMonth;$m<=$endMonth;$m++){
			$month = $oBudget->arrPeriod[$m];
				echo '<td class="budget-decimal">',number_format($values[$month],0,'.',','),'</td>';
			}
		?>
		<td class="budget-ytd budget-decimal"><?php echo number_format(array_sum($values),0,'.',',');?></td>
		</tr>
		<?php
	}
}
?>
</tbody>
<tfoot>
	<tr>
		<th colspan='<?php echo $colspan;?>'>Grand total</th>
	</tr>
<?php
foreach ($arrGrandTotal as $item=>$values){
		echo '<tr>';
		echo '<td>',$item,'</td>';
			for($m=$startMonth;$m<=$endMonth;$m++){
			$month = $oBudget->arrPeriod[$m];
				echo '<td class="budget-decimal">',number_format($values[$month],0,'.',','),'</td>';
				$arrNRBT[$month] += $values[$month];
			}
		echo '<td class="budget-ytd budget-decimal">',number_format(array_sum($values),0,'.',','),'</td>';
		echo "</tr>\r\n";
}
?>
<tr class="budget-total">
<td>Total NRBT</td>
<?php
for($m=$startMonth;$m<=$endMonth;$m++){
			$month = $oBudget->arrPeriod[$m];
				echo '<td class="budget-decimal">',number_format($arrNRBT[$month],0,'.',','),'</td>';				
}
echo '<td class="budget-decimal budget-ytd">',number_format(array_sum($arrNRBT),0,'.',','),'</td>';
?>
</tr>
</tfoot>
</table>

<ul class='link-footer'>
	<li><a href='javascript:SelectContent("report");'>Select table</a></li>
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
	<li><a href='javascript:SelectContent("corporate_costs");'>Select table</a></li>
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

?>