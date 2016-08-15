<?php
// $flagNoAuth = true;
require ('common/auth.php');
require ('classes/reference.class.php');
require ('classes/item.class.php');
require ('classes/budget.class.php');
require ('classes/reports.class.php');

include ('includes/inc_report_settings.php');
$oBudget = new Budget($budget_scenario);

$arrRates = $oBudget->getMonthlyRates($currency);

$arrKeys = Array();
$arrReport = Array('Air export'=>$arrKeys,'Air import'=>$arrKeys,'Ocean export'=>$arrKeys,'Ocean import'=>$arrKeys,'OCM'=>$arrKeys,'Warehouse'=>$arrKeys,'Land transport'=>$arrKeys);

$arrJS[] = 'js/rep_totals.js';

$sql = "SELECT * FROM vw_profit";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	$arrProfit[$rw['pccID']] = $rw;
}

// $startMonth = date('n',$oBudget->date_start);
$arrActions[] = Array('title'=>'Jan-Mar', 'action'=>'?mthStart=1&mthEnd=3');
$arrActions[] = Array('title'=>'Jan-Dec', 'action'=>'?mthStart=1&mthEnd=12');
$arrActions[] = Array('title'=>'Apr-Mar', 'action'=>'?mthStart=4&mthEnd=15');
$arrActions[] = Array('title'=>'Jan-Mar', 'action'=>'?mthStart=1&mthEnd=15');
$startMonth = isset($_GET['mthStart'])?$_GET['mthStart']:1+$oBudget->offset;
$endMonth = isset($_GET['mthEnd'])?$_GET['mthEnd']:12+$oBudget->offset;
$colspan = $endMonth - $startMonth + 3;


$sql = "SELECT pc, prtGHQ, ".$oBudget->getMonthlySumSQL($startMonth,$endMonth, $arrRates)." FROM reg_profit_ghq WHERE scenario='$budget_scenario'
		GROUP BY prtGHQ, pc";
$rs = $oSQL->q($sql);
if(!$oSQL->n($rs)){
	die("<div class='error'>No base for cost distribution. Prepare the <a href='rep_ratios.php?budget_scenario={$budget_scenario}&DataAction=update'>revenue register</a> first</div>");
}

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

$sqlFields = "CONCAT(account,': ',title) as account, prtGHQ, pc, pccFlagProd, 
				SUM(".$oBudget->getYTDSQL($startMonth,$endMonth, $arrRates).") as Total, 				
				".$oBudget->getMonthlySumSQL($startMonth,$endMonth, $arrRates);
$sqlGroupBy = "account, pc, prtGHQ";

// echo '<pre>',$sqlFields,'</pre>';

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
	for($m=$startMonth;$m<=$endMonth;$m++){
		$month = $oBudget->arrPeriod[$m];
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
$sql = "SELECT {$sqlFields} FROM vw_master 
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND item IN ('".implode("','",$arrFilter)."')
		GROUP BY {$sqlGroupBy}";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=$startMonth;$m<=$endMonth;$m++){
		$month = $oBudget->arrPeriod[$m];
		$arrReport[$rw['prtGHQ']][$reportKey][$month] += $rw[$month];
		$arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}
	

$reportKey = 'Reclassified fixed costs';
$sql = "SELECT {$sqlFields} FROM vw_master 
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND account IN ('J00801', 'J00803','J00804','J00805','J00806','J00808','J0080W')
		GROUP by {$sqlGroupBy}
		ORDER by account";

distribute($reportKey, $sql);



$reportKey = 'General costs';
$sql = "SELECT $sqlFields FROM vw_master 
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND account LIKE '5%' AND account<>'527000' AND (pccFLagProd = 1 OR IFNULL(prtGHQ,'')<>'')
		GROUP by {$sqlGroupBy}
		ORDER BY account";

distribute($reportKey, $sql);

$reportKey = 'Corporate costs';
$sql = "SELECT $sqlFields FROM vw_master 
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND account LIKE '5%' AND account<>'527000'  AND (pccFLagProd = 0 AND IFNULL(prtGHQ,'')='')
		GROUP by {$sqlGroupBy}
		ORDER BY account";
distribute ($reportKey, $sql);

$reportKey = 'Distributed corporate costs';
$sql = "SELECT $sqlFields FROM vw_master 
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND account ='607000' 
		GROUP by {$sqlGroupBy}
		ORDER BY account";
distribute ($reportKey, $sql);

$reportKey = 'MSF';
$sql = "SELECT $sqlFields FROM vw_master 
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND account='527000' 
		GROUP by pc, prtGHQ";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=$startMonth;$m<=$endMonth;$m++){
		$month = $oBudget->arrPeriod[$m];
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
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND (account like '60%') AND account<>'607000'
		GROUP by pc, prtGHQ";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=$startMonth;$m<=$endMonth;$m++){
		$month = $oBudget->arrPeriod[$m];
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
	for($m=$startMonth;$m<=$endMonth;$m++){
		$month = $oBudget->arrPeriod[$m];
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
	for($m=$startMonth;$m<=$endMonth;$m++){
		$month = $oBudget->arrPeriod[$m];
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
	for($m=$startMonth;$m<=$endMonth;$m++){
		$month = $oBudget->arrPeriod[$m];
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
	for($m=$startMonth;$m<=$endMonth;$m++){
		$month = $oBudget->arrPeriod[$m];
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

$reportKey = 'Control PBT';
$sql = "SELECT $sqlFields FROM vw_master 
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND account NOT LIKE 'SZ%'";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=$startMonth;$m<=$endMonth;$m++){
		$month = $oBudget->arrPeriod[$m];
		$arrControl[$month] += $rw[$month];
	}
}

include ('includes/inc-frame_top.php');
echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,'</h1>';
include ('includes/inc_report_selectors.php');
echo '<p>',$oBudget->timestamp,'</p>';
?>
<table id='report' class='budget'>
<thead>
	<th>Item</th>
	<?php echo $oBudget->getTableHeader('monthly', $startMonth,$endMonth); ?>
	<th>Total</th>	
</thead>
<tbody>
<?php
foreach ($arrReport as $ghq=>$arrItems){
	?>
	<tr>
	<th colspan="<?php echo $colspan;?>"><?php echo $ghq?$ghq:'[None]';?></th>
	</tr>
	<?php
	foreach ($arrItems as $item=>$values){
		?>
		<tr>
			<td><?php echo $item;?></td>
			<?php
			for ($m=$startMonth;$m<=$endMonth;$m++){
				$month = $oBudget->arrPeriod[$m];
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
	<th colspan="<?php echo $colspan;?>">Grand total</th>
</tr>
<?php
foreach ($arrGrandTotal as $item=>$values){
		?>
		<tr>
			<td><?php echo $item;?></td>
			<?php
			for ($m=$startMonth;$m<=$endMonth;$m++){
				$month = $oBudget->arrPeriod[$m];
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
for ($m=$startMonth;$m<=$endMonth;$m++){
				$month = $oBudget->arrPeriod[$m];
				?>
				<td class="budget-decimal"><?php Reports::render($arrNRBT[$month],0);?></td>
				<?php
}
?>
	<td class="budget-decimal budget-ytd"><?php Reports::render(array_sum($arrNRBT),0);?></td>
</tr>
<tr class="budget-total">
<td>Control</td>
<?php
for ($m=$startMonth;$m<=$endMonth;$m++){
				$month = $oBudget->arrPeriod[$m];
				?>
				<td class="budget-decimal" style="background-color:<?php echo (round($arrControl[$month],0)==round($arrNRBT[$month],0)?'lightgreen':'pink');?>;"><?php Reports::render($arrControl[$month],0);?></td>
				<?php
}
?>
	<td class="budget-decimal budget-ytd"><?php Reports::render(array_sum($arrControl),0);?></td>
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
	echo '<th>',($ghq?$ghq:'[None]'),'</th>';
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

<h1>Additional info</h1>
<?php
foreach ($arrBreakDown as $group=>$accounts){
	$arrColTotal = Array();
	$nControlTotal = 0;

	echo '<h3>',$group,'</h3>';
	$strTableID = urlencode($group);
	?>
	<table class='budget' id='<?php echo $strTableID;?>'>
	<thead>
		<tr>
			<th>Activity</th>
			<?php
			foreach ($accounts as $account=>$ghq){
				echo '<th>',$account,'</th>';
			}
			?>
			<th>Total</th>
			<th>Control</th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach ($arrReport as $ghq=>$values){
				$rowTotal = 0;
				?>
				<tr>
				<th><?php echo ($ghq?$ghq:'[None]');?></th>
				<?php				
				foreach ($accounts as $account=>$products){					
					$rowTotal += $products[$ghq];
					$arrColTotal[$account] += $products[$ghq];
					?>
					<td class="budget-decimal"><?php Reports::render(-$products[$ghq]);?></td>
					<?php
				}
				
				$nControlTotal += is_array($arrReport[$ghq][$group])?array_sum($arrReport[$ghq][$group]):0;
				
				echo '<td class="budget-ytd budget-decimal">',Reports::render(-$rowTotal),'</td>';
				echo '<td class="budget-ytd budget-decimal">',is_array($arrReport[$ghq][$group])?Reports::render(-array_sum($arrReport[$ghq][$group])):'n/a','</td>';
				?>
				</tr>
				<?php
			}									
		?>
		<tfoot>
			<tr class='budget-total'>
				<td>Total:</td>
				<?php
				foreach ($accounts as $account=>$products){	
					?>
					<td class='budget-decimal'><?php Reports::render(-$arrColTotal[$account]);?></td>					
					<?php
				}
				?>
				<td class='budget-decimal'><?php Reports::render(-array_sum($arrColTotal));?></td>										
				<td class='budget-decimal'><?php Reports::render(-($nControlTotal));?></td>										
			</tr>
		</tfoot>
	</tbody>
	</table>
	<ul class='link-footer'>
		<li><a href='javascript:SelectContent("<?php echo $strTableID;?>");'>Select table</a></li>
	</ul>
	<?
}

include ('includes/inc-frame_bottom.php');

function error_distribution($params){
	GLOBAL $arrProfit;
	echo '<pre>','Error for PC ',$arrProfit[$params['data']['pc']]['pccTitle'], " ({$params['data']['pc']})"," cannot distribute {$params['reportKey']} in {$params['month']} ({$params['data'][$params['month']]})" ,'</pre>';
	echo '<pre>',$params['sql'],'</pre>';
}

function distribute($reportKey, $sql){
	GLOBAL $oSQL, $oBudget;	
	GLOBAl $startMonth, $endMonth;
	GLOBAl $arrReport;
	GLOBAL $arrGrandTotal;
	GLOBAL $arrRatio,$arrGHQSubtotal,$arrRevenue;
	GLOBAL $arrBreakDown, $sqlFields, $sqlGroupBy;	
	
	$rs = $oSQL->q($sql);
	while ($rw = $oSQL->f($rs)){
	
		if (($rw['pc']==9 || $rw['pc']==130) && $reportKey=='Corporate costs'){
			$key = 'General costs';
		} else {
			$key = $reportKey;
		}
	
		for($m=$startMonth;$m<=$endMonth;$m++){
			$month = $oBudget->arrPeriod[$m];
			if ($rw[$month]!=0){
				if ($rw['prtGHQ']){
					$arrReport[$rw['prtGHQ']][$key][$month] += $rw[$month];
					$arrBreakDown[$key][$rw['account'].$rw['title']][$rw['prtGHQ']] += $rw[$month];
				} else {
					if (!is_array($arrRatio[$rw['pc']])) {
						if ($rw['pccFlagProd']){
							error_distribution(Array('data'=>$rw,'reportKey'=>$key,'month'=>$month, 'sql'=>$sql));
						} else {
							foreach($arrGHQSubtotal as $ghq=>$revenue){
								$arrReport[$ghq][$key][$month] += $rw[$month]*$revenue[$month]/$arrRevenue[$month];
								$arrBreakDown[$key][$rw['account'].$rw['title']][$ghq] += $rw[$month]*$revenue[$month]/$arrRevenue[$month];
							}
						}
					} else {
						foreach($arrRatio[$rw['pc']] as $ghq=>$ratios){
							$arrReport[$ghq][$key][$month] += $rw[$month]*$ratios[$month];
							$arrBreakDown[$key][$rw['account'].$rw['title']][$ghq] += $rw[$month]*$ratios[$month];
						}
					}
				}
				$arrGrandTotal[$key][$month] += $rw[$month];
			} else {
				//skip;
			} 
		}
	}
}
?>