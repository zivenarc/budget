<?php
// $flagNoAuth = true;
require ('common/auth.php');
require ('classes/reference.class.php');
require ('classes/item.class.php');
require ('classes/budget.class.php');
require ('classes/reports.class.php');

$oBudget = new Budget($budget_scenario);

$sql = "SELECT * FROM vw_profit";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	$arrProfit[$rw['pccID']] = $rw;
}

$startMonth = date('n',$oBudget->date_start);

$sql = "SELECT pc, prtGHQ, ".Budget::getMonthlySumSQL($startMonth,12)." FROM reg_profit_ghq WHERE scenario='$budget_scenario'
		GROUP BY prtGHQ, pc";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=$startMonth;$m<13;$m++){
		$month = (date('M',mktime(0,0,0,$m,15)));
		$arrPC[$rw['pc']][$rw['prtGHQ']][$month] += $rw[$month];
		$arrSubtotal[$rw['pc']][$month] += $rw[$month];
		$arrGHQSubtotal[$rw['prtGHQ']][$month] += $rw[$month];
		$arrRevenue[$month] += $rw[$month];
	}
}

foreach($arrPC as $pc=>$arrGhq){
	foreach ($arrGhq as $ghq=>$values){
		for($m=$startMonth;$m<13;$m++){
			$month = (date('M',mktime(0,0,0,$m,15)));
			$arrRatio[$pc][$ghq][$month] = $arrSubtotal[$pc][$month]?$values[$month]/$arrSubtotal[$pc][$month]:0;
		}
	}
}

// echo '<pre>';print_r($arrRatio);echo '</pre>';

$sqlFields = "prtGHQ, pc, SUM(".Budget::getYTDSQL($startMonth,12).") as Total, ".Budget::getMonthlySumSQL($startMonth,12);


$arrFilter = Array(
	Items::REVENUE,
	Items::INTERCOMPANY_REVENUE
);
$reportKey = 'Revenue';
$sql = "SELECT $sqlFields FROM vw_master 
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND item in ('".implode("','",$arrFilter)."') 
		GROUP by prtGHQ"; 
// echo '<pre>',$sql,'</pre>';
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=$startMonth;$m<13;$m++){
		$month = (date('M',mktime(0,0,0,$m,15)));
		$arrReport[$rw['prtGHQ']][$reportKey][$month] += $rw[$month];
		$arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}


$arrFilter = Array(
	Items::DIRECT_COSTS,
	Items::INTERCOMPANY_COSTS,
	Items::KAIZEN
);
$reportKey = 'Direct costs';
$sql = "SELECT $sqlFields FROM vw_master 
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND item IN ('".implode("','",$arrFilter)."')
		GROUP by pc, prtGHQ";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=$startMonth;$m<13;$m++){
		$month = (date('M',mktime(0,0,0,$m,15)));
		$arrReport[$rw['prtGHQ']][$reportKey][$month] += $rw[$month];
		$arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}
	

$reportKey = 'Reclassified fixed costs';
$sql = "SELECT $sqlFields FROM vw_master 
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND account IN ('J00801', 'J00803','J00804','J00805','J00806','J00808','J0080W')
		GROUP by pc, prtGHQ";

distribute($reportKey, $sql);



$reportKey = 'General costs';
$sql = "SELECT $sqlFields FROM vw_master 
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND account LIKE '5%' AND account<>'527000' AND (pccFLagProd = 1 OR prtGHQ is NOT NULL)
		GROUP by pc, prtGHQ";

distribute($reportKey, $sql);

$reportKey = 'Corporate costs';
$sql = "SELECT $sqlFields FROM vw_master 
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND account LIKE '5%' AND account<>'527000'  AND (pccFLagProd = 0 AND prtGHQ IS NULL)
		GROUP by pc, prtGHQ";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){

	if ($rw['pc']==9){
		$key = 'General costs';
	} else {
		$key = $reportKey;
	}

	for($m=$startMonth;$m<13;$m++){
		$month = (date('M',mktime(0,0,0,$m,15)));
		if ($rw['prtGHQ']){
			$arrReport[$rw['prtGHQ']][$key][$month] += $rw[$month];
		} else {
			foreach($arrGHQSubtotal as $ghq=>$revenue){
				$arrReport[$ghq][$key][$month] += $rw[$month]*$revenue[$month]/$arrRevenue[$month];
			}
		}
		$arrGrandTotal[$key][$month] += $rw[$month];
	}
}

$reportKey = 'MSF';
$sql = "SELECT $sqlFields FROM vw_master 
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND account='527000' 
		GROUP by pc, prtGHQ";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=$startMonth;$m<13;$m++){
		$month = (date('M',mktime(0,0,0,$m,15)));
		if ($rw['prtGHQ']){
			$arrReport[$rw['prtGHQ']][$reportKey][$month] += $rw[$month];
		} else {
			foreach($arrGHQSubtotal as $ghq=>$revenue){
				$arrReport[$ghq][$reportKey][$month] += $rw[$month]*$revenue[$month]/$arrRevenue[$month];
			}
		}
		$arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}

$reportKey = 'N/O income';
$sql = "SELECT $sqlFields FROM vw_master 
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND (account like '60%')
		GROUP by pc, prtGHQ";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=$startMonth;$m<13;$m++){
		$month = (date('M',mktime(0,0,0,$m,15)));
		if ($rw['prtGHQ']){
			$arrReport[$rw['prtGHQ']][$reportKey][$month] += $rw[$month];
		} else {
			foreach($arrGHQSubtotal as $ghq=>$revenue){
				$arrReport[$ghq][$reportKey][$month] += $rw[$month]*$revenue[$month]/$arrRevenue[$month];
			}
		}
		$arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}


$reportKey = 'N/O costs';
$sql = "SELECT $sqlFields FROM vw_master 
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND (account like '65%' or account like '66%') 
		GROUP by pc, prtGHQ";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=$startMonth;$m<13;$m++){
		$month = (date('M',mktime(0,0,0,$m,15)));
		if ($rw['prtGHQ']){
			$arrReport[$rw['prtGHQ']][$reportKey][$month] += $rw[$month];
		} else {
			foreach($arrGHQSubtotal as $ghq=>$revenue){
				$arrReport[$ghq][$reportKey][$month] += $rw[$month]*$revenue[$month]/$arrRevenue[$month];
			}
		}
		$arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}

$reportKey = 'Extraordinary income';
$sql = "SELECT $sqlFields FROM vw_master 
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND (account like '70%')
		GROUP by pc, prtGHQ";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=$startMonth;$m<13;$m++){
		$month = (date('M',mktime(0,0,0,$m,15)));
		if ($rw['prtGHQ']){
			$arrReport[$rw['prtGHQ']][$reportKey][$month] += $rw[$month];
		} else {
			foreach($arrGHQSubtotal as $ghq=>$revenue){
				$arrReport[$ghq][$reportKey][$month] += $rw[$month]*$revenue[$month]/$arrRevenue[$month];
			}
		}
		$arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}


$reportKey = 'Extraordinary costs';
$sql = "SELECT $sqlFields FROM vw_master 
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND (account like '75%' or account like '76%') 
		GROUP by pc, prtGHQ";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=$startMonth;$m<13;$m++){
		$month = (date('M',mktime(0,0,0,$m,15)));
		if ($rw['prtGHQ']){
			$arrReport[$rw['prtGHQ']][$reportKey][$month] += $rw[$month];
		} else {
			foreach($arrGHQSubtotal as $ghq=>$revenue){
				$arrReport[$ghq][$reportKey][$month] += $rw[$month]*$revenue[$month]/$arrRevenue[$month];
			}
		}
		$arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}

$reportKey = 'NO YACT';
$sql = "SELECT $sqlFields FROM vw_master 
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND IFNULL(account,'') LIKE '' 
		GROUP by pc, prtGHQ";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=$startMonth;$m<13;$m++){
		$month = (date('M',mktime(0,0,0,$m,15)));
		if ($rw['prtGHQ']){
			$arrReport[$rw['prtGHQ']][$reportKey][$month] += $rw[$month];
		} else {
			foreach($arrGHQSubtotal as $ghq=>$revenue){
				$arrReport[$ghq][$reportKey][$month] += $rw[$month]*$revenue[$month]/$arrRevenue[$month];
			}
		}
		$arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}
// echo '<pre>';print_r($arrReport);echo '</pre>';

include ('includes/inc-frame_top.php');
echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,'</h1>';
echo '<p>',$oBudget->timestamp,'</p>';
?>
<table id='report' class='budget'>
<thead>
	<th>Item</th>
	<?php echo Budget::getTableHeader('monthly', $startMonth,12); ?>
	<th>Total</th>
</thead>
<tbody>
<?php
foreach ($arrReport as $ghq=>$arrItems){
	echo '<tr>';
	echo '<th colspan="14">',$ghq,'</th>';
	echo "</tr>\r\n";
	
	foreach ($arrItems as $item=>$values){
		?>
		<tr>
			<td><?php echo $item;?></td>
			<?php
			for ($m=$startMonth;$m<13;$m++){
				$month = (date('M',mktime(0,0,0,$m,15)));
				?>
				<td class="budget-decimal"><?php Reports::render($values[$month],0);?></td>
				<?php
			}
		?>
			<td class="budget-ytd budget-decimal"><?php Reports::render(array_sum($values),0);?></td>
		</tr>
		<?php
	}
}
?>
<tr>
	<th colspan="14">Grand total</th>
</tr>
<?php
foreach ($arrGrandTotal as $item=>$values){
		?>
		<tr>
			<td><?php echo $item;?></td>
			<?php
			for ($m=$startMonth;$m<13;$m++){
				$month = (date('M',mktime(0,0,0,$m,15)));
				?>
				<td class="budget-decimal"><?php Reports::render($values[$month],0);?></td>
				<?php
				$arrNRBT[$month] += $values[$month];
			}
		?>
		<td class="budget-ytd budget-decimal"><?php Reports::render(array_sum($values),0);?></td>
		</tr>
		<?php
}
?>
<tr class="budget-total">
<td>Total NRBT</td>
<?php
for ($m=$startMonth;$m<13;$m++){
				$month = (date('M',mktime(0,0,0,$m,15)));
				?>
				<td class="budget-decimal"><?php Reports::render($arrNRBT[$month],0);?></td>
				<?php
}
?>
	<td class="budget-decimal budget-ytd"><?php Reports::render(array_sum($arrNRBT),0);?></td>
</tr>
</tbody>
</table>

<ul class='link-footer'>
	<li><a href='javascript:SelectContent("report");'>Select table</a></li>
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
		?>
		<td><?php Reports::render_ratio(array_sum($revenue),array_sum($arrRevenue));?></td>
		<?php
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

function distribute($reportKey, $sql){
	GLOBAL $oSQL;
	GLOBAl $startMonth;
	GLOBAl $arrReport;
	GLOBAL $arrGrandTotal;
	GLOBAL $arrRatio;
	
	$rs = $oSQL->q($sql);
	while ($rw = $oSQL->f($rs)){
		for($m=$startMonth;$m<13;$m++){
			$month = (date('M',mktime(0,0,0,$m,15)));
			if ($rw[$month]!=0){
				if ($rw['prtGHQ']){
					$arrReport[$rw['prtGHQ']][$reportKey][$month] += $rw[$month];
				} else {
					if (!is_array($arrRatio[$rw['pc']])) error_distribution(Array('data'=>$rw,'reportKey'=>$reportKey,'month'=>$month, 'sql'=>$sql));
					foreach($arrRatio[$rw['pc']] as $ghq=>$ratios){
						$arrReport[$ghq][$reportKey][$month] += $rw[$month]*$ratios[$month];
					}
				}
				$arrGrandTotal[$reportKey][$month] += $rw[$month];
			} else {
				//skip;
			} 
		}
	}	
}
?>