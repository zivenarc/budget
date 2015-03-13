<?php
// $flagNoAuth = true;
require ('common/auth.php');
require ('classes/reference.class.php');
require ('classes/item.class.php');
require ('classes/budget.class.php');

$oBudget = new Budget($budget_scenario);

$sql = "SELECT * FROM vw_profit";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	$arrProfit[$rw['pccID']] = $rw;
}

$sql = "SELECT pc, prtGHQ, ".Budget::getMonthlySumSQL()." FROM reg_profit_ghq WHERE scenario='$budget_scenario'
		GROUP BY prtGHQ, pc";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=1;$m<13;$m++){
		$month = (date('M',mktime(0,0,0,$m,15)));
		$arrPC[$rw['pc']][$rw['prtGHQ']][$month] += $rw[$month];
		$arrSubtotal[$rw['pc']][$month] += $rw[$month];
		$arrGHQSubtotal[$rw['prtGHQ']][$month] += $rw[$month];
		$arrRevenue[$month] += $rw[$month];
	}
}

foreach($arrPC as $pc=>$arrGhq){
	foreach ($arrGhq as $ghq=>$values){
		for($m=1;$m<13;$m++){
			$month = (date('M',mktime(0,0,0,$m,15)));
			$arrRatio[$pc][$ghq][$month] = $arrSubtotal[$pc][$month]?$values[$month]/$arrSubtotal[$pc][$month]:0;
		}
	}
}

// echo '<pre>';print_r($arrRatio);echo '</pre>';

$sqlFields = "prtGHQ, pc, SUM(Total) as Total, ".Budget::getMonthlySumSQL();

$arrFilter = Array(
	Items::REVENUE,
	Items::INTERCOMPANY_REVENUE
);
$reportKey = '<i>Revenue correction</i>';
$sql = "SELECT $sqlFields FROM vw_master 
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND item in ('".implode("','",$arrFilter)."') AND account='J00802'
		GROUP by prtGHQ"; 
// echo '<pre>',$sql,'</pre>';
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=1;$m<13;$m++){
		$month = (date('M',mktime(0,0,0,$m,15)));
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
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND item in ('".implode("','",$arrFilter)."') AND activity in (".implode(",",$arrFreightFilter).")
		GROUP by prtGHQ"; 
// echo '<pre>',$sql,'</pre>';
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=1;$m<13;$m++){
		$month = (date('M',mktime(0,0,0,$m,15)));
		$arrReport[$rw['prtGHQ']][$reportKey][$month] += $rw[$month];
		// $arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}
$reportKey = '<i>Other revenue</i>';
$sql = "SELECT $sqlFields FROM vw_master 
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND item in ('".implode("','",$arrFilter)."') AND activity not in (".implode(",",$arrFreightFilter).")
		GROUP by prtGHQ"; 
// echo '<pre>',$sql,'</pre>';
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=1;$m<13;$m++){
		$month = (date('M',mktime(0,0,0,$m,15)));
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
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND item in ('".implode("','",$arrFilter)."') 
		GROUP by prtGHQ"; 
// echo '<pre>',$sql,'</pre>';
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=1;$m<13;$m++){
		$month = (date('M',mktime(0,0,0,$m,15)));
		$arrReport[$rw['prtGHQ']][$reportKey][$month] += $rw[$month];
		$arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}


$arrFilter = Array(
	Items::DIRECT_COSTS,
	Items::INTERCOMPANY_COSTS,
	Items::CY_RENT,
	Items::WH_RENT,
	Items::KAIZEN
);
$reportKey = 'Direct costs';
$sql = "SELECT $sqlFields FROM vw_master 
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND item IN ('".implode("','",$arrFilter)."')
		GROUP by pc, prtGHQ";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=1;$m<13;$m++){
		$month = (date('M',mktime(0,0,0,$m,15)));
		$arrReport[$rw['prtGHQ']][$reportKey][$month] -= $rw[$month];
		$arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}

$reportKey = '<i>Freight costs</i>';
$sql = "SELECT $sqlFields FROM vw_master 
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND item in ('".implode("','",$arrFilter)."') AND activity in (".implode(",",$arrFreightFilter).")
		GROUP by prtGHQ"; 
// echo '<pre>',$sql,'</pre>';
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=1;$m<13;$m++){
		$month = (date('M',mktime(0,0,0,$m,15)));
		$arrReport[$rw['prtGHQ']][$reportKey][$month] -= $rw[$month];
		// $arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}
$reportKey = '<i>Other costs</i>';
$sql = "SELECT $sqlFields FROM vw_master 
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND item in ('".implode("','",$arrFilter)."') AND activity not in (".implode(",",$arrFreightFilter).")
		GROUP by prtGHQ"; 
// echo '<pre>',$sql,'</pre>';
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=1;$m<13;$m++){
		$month = (date('M',mktime(0,0,0,$m,15)));
		$arrReport[$rw['prtGHQ']][$reportKey][$month] -= $rw[$month];
		// $arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}

$reportKey = 'Labor costs';
$sql = "SELECT $sqlFields FROM vw_master 
		LEFT JOIN vw_yact YACT ON yctID=account
		##WHERE scenario='$budget_scenario' AND source<>'Estimate' AND YACT.yctParentID IN ('59900P') AND LEFT(yctID,1)='J' AND pccFLagProd = 1
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND account IN('J00801') AND pccFLagProd = 1
		GROUP by pc, prtGHQ";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=1;$m<13;$m++){
		$month = (date('M',mktime(0,0,0,$m,15)));
		if ($rw['prtGHQ']){
			$arrReport[$rw['prtGHQ']][$reportKey][$month] -= $rw[$month];			
		} else {
			if (!is_array($arrRatio[$rw['pc']])) echo '<pre>','Error for PC',$arrProfit[$rw['pc']]['pccTitle'], " ({$rw['pc']})"," cannot distribute $month",$rw[$month] ,'</pre>';
			foreach($arrRatio[$rw['pc']] as $ghq=>$ratios){
				$arrReport[$ghq][$reportKey][$month] -= $rw[$month]*$ratios[$month];				
			}
		}
		$arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}

$reportKey = 'Depreciation';
$sql = "SELECT $sqlFields FROM vw_master 
		LEFT JOIN vw_yact YACT ON yctID=account
		##WHERE scenario='$budget_scenario' AND source<>'Estimate' AND account IN ('512000','J00806') AND pccFLagProd = 1
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND account IN ('J00806') AND pccFLagProd = 1
		GROUP by pc, prtGHQ";
// echo '<pre>',$sql,'</pre>';
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=1;$m<13;$m++){
		$month = (date('M',mktime(0,0,0,$m,15)));
		if ($rw['prtGHQ']){
			$arrReport[$rw['prtGHQ']][$reportKey][$month] -= $rw[$month];
		} else {
			if (!is_array($arrRatio[$rw['pc']])) echo '<pre>','Error for PC',$rw['pc'],' cannot distribute ',$rw[$month] ,'</pre>';
			foreach($arrRatio[$rw['pc']] as $ghq=>$ratios){
				// echo '<pre>distributing pc',$rw['pc'],' to ',$ghq, ', '.$ratios[$month]*100,'</pre>';
				$arrReport[$ghq][$reportKey][$month] -= $rw[$month]*$ratios[$month];
			}
		}
		$arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}

$reportKey = 'Other fixed costs';
$sql = "SELECT $sqlFields FROM vw_master 
		LEFT JOIN vw_yact YACT ON yctID=account
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND (YACT.yctParentID IN ('SZ0040') AND account NOT IN ('J00806','J00801')) AND pccFLagProd = 1
		GROUP by pc, prtGHQ";
// echo '<pre>',$sql,'</pre>';
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=1;$m<13;$m++){
		$month = (date('M',mktime(0,0,0,$m,15)));
		if ($rw['prtGHQ']){
			$arrReport[$rw['prtGHQ']][$reportKey][$month] -= $rw[$month];
		} else {
			if (!is_array($arrRatio[$rw['pc']])) echo '<pre>','Error for PC',$rw['pc'],' cannot distribute ',$rw[$month] ,'</pre>';
			foreach($arrRatio[$rw['pc']] as $ghq=>$ratios){
				// echo '<pre>distributing pc',$rw['pc'],' to ',$ghq, ', '.$ratios[$month]*100,'</pre>';
				$arrReport[$ghq][$reportKey][$month] -= $rw[$month]*$ratios[$month];
			}
		}
		$arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}

$reportKey = 'SGA:Personnel costs';
$sql = "SELECT $sqlFields FROM vw_master 
		LEFT JOIN vw_yact YACT ON yctID=account
		##WHERE scenario='$budget_scenario' AND source<>'Estimate' AND YACT.yctParentID IN ('59900P') AND LEFT(yctID,1)='5' AND (pccFLagProd = 1 OR activity is not null)
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND YACT.yctParentID IN ('59900P') AND (pccFLagProd = 1 OR activity is not null)
		GROUP by pc, prtGHQ";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=1;$m<13;$m++){
		$month = (date('M',mktime(0,0,0,$m,15)));
		if ($rw['prtGHQ']){
			$arrReport[$rw['prtGHQ']][$reportKey][$month] -= $rw[$month];
		} else {
			if (!is_array($arrRatio[$rw['pc']])) echo '<pre>','Error for PC',$arrProfit[$rw['pc']]['pccTitle'], " ({$rw['pc']})"," cannot distribute $month",$rw[$month] ,'</pre>';
			foreach($arrRatio[$rw['pc']] as $ghq=>$ratios){
				$arrReport[$ghq][$reportKey][$month] -= $rw[$month]*$ratios[$month];
			}
		}
		$arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}

$reportKey = 'Other SGA';
$sql = "SELECT $sqlFields FROM vw_master 
		LEFT JOIN vw_yact YACT ON yctID=account
		##WHERE scenario='$budget_scenario' AND source<>'Estimate' AND YACT.yctParentID IN ('59900P') AND LEFT(yctID,1)='5' AND (pccFLagProd = 1 OR activity is not null)
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND YACT.yctParentID IN ('59900S') AND (pccFLagProd = 1 OR activity is not null)
		GROUP by pc, prtGHQ";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=1;$m<13;$m++){
		$month = (date('M',mktime(0,0,0,$m,15)));
		if ($rw['prtGHQ']){
			$arrReport[$rw['prtGHQ']][$reportKey][$month] -= $rw[$month];
		} else {
			if (!is_array($arrRatio[$rw['pc']])) echo '<pre>','Error for PC',$arrProfit[$rw['pc']]['pccTitle'], " ({$rw['pc']})"," cannot distribute $month",$rw[$month] ,'</pre>';
			foreach($arrRatio[$rw['pc']] as $ghq=>$ratios){
				$arrReport[$ghq][$reportKey][$month] -= $rw[$month]*$ratios[$month];
			}
		}
		$arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}

$reportKey = 'Corporate costs: personnel';
$sql = "SELECT $sqlFields FROM vw_master 
		LEFT JOIN vw_yact YACT ON yctID=account
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND YACT.yctParentID IN ('59900P')  AND (pccFLagProd = 0 and activity is null)
		##GROUP by pc, prtGHQ";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){

	for($m=1;$m<13;$m++){
		$month = (date('M',mktime(0,0,0,$m,15)));
		// if ($rw['prtGHQ']){
			$arrReport['Corporate'][$reportKey][$month] -= $rw[$month];
		// } else {
			// foreach($arrGHQSubtotal as $ghq=>$revenue){
				// $arrReport[$ghq][$key][$month] += $rw[$month]*$revenue[$month]/$arrRevenue[$month];
			// }
		// }
		$arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}

$reportKey = 'Corporate costs: other';
$sql = "SELECT $sqlFields FROM vw_master 
		LEFT JOIN vw_yact YACT ON yctID=account
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND (account IN ('J00803','J00804','J00805','J00806','J00808') OR YACT.yctParentID IN ('59900S'))  AND pccFLagProd = 0
		##GROUP by pc, prtGHQ";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){

	// if ($rw['pc']==9){
		// $key = 'General costs';
	// } else {
		// $key = $reportKey;
	// }

	for($m=1;$m<13;$m++){
		$month = (date('M',mktime(0,0,0,$m,15)));
		// if ($rw['prtGHQ']){
			$arrReport['Corporate'][$reportKey][$month] -= $rw[$month];
		// } else {
			// foreach($arrGHQSubtotal as $ghq=>$revenue){
				// $arrReport[$ghq][$key][$month] += $rw[$month]*$revenue[$month]/$arrRevenue[$month];
			// }
		// }
		$arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}

$reportKey = 'Interest income';
$sql = "SELECT $sqlFields FROM vw_master 
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND account IN ('601000') 
		##GROUP by pc, prtGHQ";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=1;$m<13;$m++){
		$month = (date('M',mktime(0,0,0,$m,15)));
		$arrReport['Non-op.income'][$reportKey][$month] += $rw[$month];
		$arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}
$reportKey = 'Gain on sale';
$sql = "SELECT $sqlFields FROM vw_master 
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND account IN ('606000') 
		##GROUP by pc, prtGHQ";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=1;$m<13;$m++){
		$month = (date('M',mktime(0,0,0,$m,15)));
		$arrReport['Non-op.income'][$reportKey][$month] += $rw[$month];
		$arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}
$reportKey = 'Other non-op income';
$sql = "SELECT $sqlFields FROM vw_master 
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND account like '60%' AND account NOT IN ('601000','606000') 
		##GROUP by pc, prtGHQ";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=1;$m<13;$m++){
		$month = (date('M',mktime(0,0,0,$m,15)));
		$arrReport['Non-op.income'][$reportKey][$month] += $rw[$month];
		$arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}

$reportKey = 'Interest costs';
$sql = "SELECT $sqlFields FROM vw_master 
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND account IN ('650000')
		##GROUP by pc, prtGHQ";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=1;$m<13;$m++){
		$month = (date('M',mktime(0,0,0,$m,15)));
		// if ($rw['prtGHQ']){
			$arrReport['Non-op. costs'][$reportKey][$month] -= $rw[$month];
		// } else {
			// foreach($arrGHQSubtotal as $ghq=>$revenue){
				// $arrReport[$ghq][$reportKey][$month] += $rw[$month]*$revenue[$month]/$arrRevenue[$month];
			// }
		// }
		$arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}
$reportKey = 'Other non-op. costs';
$sql = "SELECT $sqlFields FROM vw_master 
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND (account like '65%' or account like '66%') AND account NOT IN ('650000')
		##GROUP by pc, prtGHQ";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=1;$m<13;$m++){
		$month = (date('M',mktime(0,0,0,$m,15)));
		// if ($rw['prtGHQ']){
			$arrReport['Non-op. costs'][$reportKey][$month] -= $rw[$month];
		// } else {
			// foreach($arrGHQSubtotal as $ghq=>$revenue){
				// $arrReport[$ghq][$reportKey][$month] += $rw[$month]*$revenue[$month]/$arrRevenue[$month];
			// }
		// }
		$arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}
$reportKey = 'MSF';
$sql = "SELECT $sqlFields FROM vw_master 
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND account='527000' 
		##GROUP by pc, prtGHQ";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=1;$m<13;$m++){
		$month = (date('M',mktime(0,0,0,$m,15)));
		// if ($rw['prtGHQ']){
			 $arrReport['Non-op. costs'][$reportKey][$month] -= $rw[$month];
		// } else {
			// foreach($arrGHQSubtotal as $ghq=>$revenue){
				// $arrReport[$ghq][$reportKey][$month] += $rw[$month]*$revenue[$month]/$arrRevenue[$month];
			// }
		// }
		$arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}






$reportKey = 'NO YACT';
$sql = "SELECT $sqlFields FROM vw_master 
		WHERE scenario='$budget_scenario' AND source<>'Estimate' AND IFNULL(account,'') LIKE '' 
		##GROUP by pc, prtGHQ";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=1;$m<13;$m++){
		$month = (date('M',mktime(0,0,0,$m,15)));
		$arrReport[$rw['']][$reportKey][$month] += $rw[$month];
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
	<?php echo Budget::getTableHeader('monthly'); ?>
	<th>Total</th>
</thead>
<tbody>
<?php
foreach ($arrReport as $ghq=>$arrItems){
	echo '<tr>';
	echo '<th colspan="14">',$ghq,'</th>';
	echo "</tr>\r\n";
	
	foreach ($arrItems as $item=>$values){
		echo '<tr>';
		echo '<td>',$item,'</td>';
			for ($m=1;$m<13;$m++){
				$month = (date('M',mktime(0,0,0,$m,15)));
				echo '<td class="budget-decimal">',number_format($values[$month],0,'.',','),'</td>';
			}
		echo '<td class="budget-ytd budget-decimal">',number_format(array_sum($values),0,'.',','),'</td>';
		echo "</tr>\r\n";
	}
}

echo '<tr>';
echo '<th colspan="14">Grand total</th>';
echo "</tr>\r\n";
foreach ($arrGrandTotal as $item=>$values){
		echo '<tr>';
		echo '<td>',$item,'</td>';
			for ($m=1;$m<13;$m++){
				$month = (date('M',mktime(0,0,0,$m,15)));
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
for ($m=1;$m<13;$m++){
				$month = (date('M',mktime(0,0,0,$m,15)));
				echo '<td class="budget-decimal">',number_format($arrNRBT[$month],0,'.',','),'</td>';				
}
echo '<td class="budget-decimal budget-ytd">',number_format(array_sum($arrNRBT),0,'.',','),'</td>';
?>
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
		echo '<td>',number_format(array_sum($revenue)/array_sum($arrRevenue)*100,1,'.',','),'</td>';
	}
?>
<td>100</td>
</tr>
</tbody>
</table>
<?php
include ('includes/inc-frame_bottom.php');
?>