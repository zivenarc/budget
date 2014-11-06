<?php
// $flagNoAuth = true;
require ('common/auth.php');
require ('classes/budget.class.php');

$oBudget = new Budget($budget_scenario);
$denominator = isset($_GET['denominator'])?(double)$_GET['denominator']:1;

include ('includes/inc-frame_top.php');
echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,'</h1>';
if ($denominator!=1) {
	echo '<h2>RUB x',$denominator,'</h2>';
}
echo '<p>',$oBudget->timestamp,'</p>';

$sql = "SELECT Profit, pccFlagProd, `Budget item`, `Group`, SUM(".Budget::getYTDSQL().")/$denominator as Total, SUM(estimate)/$denominator as Estimate
		FROM vw_master
		WHERE scenario='$budget_scenario' AND source IN (select `nemGUID` FROM `tbl_new_employee`)
		GROUP BY Profit, `Budget item`
		ORDER BY `Group`,pccFlagProd,Profit,itmOrder";
$rs = $oSQL->q($sql);
while ($rw=$oSQL->f($rs)){
	
	// $keyProfit = Budget::getProfitAlias($rw);
	$keyProfit = $rw['Profit'];

	$arrReport[$rw['Group']][$rw['Budget item']][$keyProfit] += $rw['Total'];
	$arrTotal[$rw['Group']][$keyProfit] += $rw['Total'];
	$arrGrandTotal[$keyProfit] += $rw['Total'];
	// $arrEstimate[$rw['Group']][$rw['Budget item']] += $rw['Estimate'];
	$arrProfit[$keyProfit] = $rw['pccFlagProd'];
}

$sql = "SELECT pccFLagProd, pccTitle as Profit, pc, SUM(".Budget::getYTDSQL().")/12 as FTE
		FROM reg_headcount
		LEFT JOIN vw_profit ON pccID=pc
		WHERE scenario='$budget_scenario' AND new_fte<>0 AND posted=1
		GROUP BY pc";
$rs = $oSQL->q($sql);
while ($rw=$oSQL->f($rs)){
	
	// $keyProfit = Budget::getProfitAlias($rw);
	$keyProfit = $rw['Profit'];
	$arrHeadcount[$keyProfit] += $rw['FTE'];
}
// echo '<pre>';print_r($arrReport);echo '</pre>';
?>
<table class='budget' id='report'>
<thead>
	<tr>
		<th>Account</th>
		<?php foreach($arrProfit as $pc=>$flag){
					echo '<th><div>',$pc,'</div><div><small>',number_format($arrHeadcount[$pc],1,'.',','),'</small></div></th>';
		};?>
		<th class='budget-ytd'><div>Total</div><?php echo '<div><small>',number_format(array_sum($arrHeadcount),1,'.',','),'</small></div>';?></th>
	</tr>
</thead>
<tbody>
<?php
foreach($arrReport as $group=>$arrItem){
	foreach($arrItem as $item=>$values){
		echo '<tr>';
		echo '<td>',$item,'</td>';
		foreach($arrProfit as $pc=>$flag){
			$strClass = $values[$pc]<0?"budget-negative":"";
			echo "<td class='budget-decimal $strClass'>",number_format($values[$pc],0,'.',','),'</td>';
		}
		
		$strClass = array_sum($values)<0?"budget-negative":"";
		echo "<td class='budget-decimal budget-ytd $strClass'>",number_format(array_sum($values),0,'.',','),'</td>';
		
		echo '</tr>';
	}
	
	echo '<tr class="budget-subtotal">';
	echo '<td>',$group,'</td>';
	foreach($arrProfit as $pc=>$flag){
		$strClass = $arrTotal[$group][$pc]<0?"budget-negative":"";
		echo "<td class='budget-decimal $strClass'>",number_format($arrTotal[$group][$pc],0,'.',','),'</td>';
	}
	$strClass = array_sum($arrTotal[$group])<0?"budget-negative":"";
	echo "<td class='budget-decimal budget-ytd $strClass'>",number_format(array_sum($arrTotal[$group]),0,'.',','),'</td>';
	
	
	echo '</tr>';	
}
echo '<tr class="budget-total">';
echo '<td>Total result</td>';
foreach($arrProfit as $pc=>$flag){
	$strClass = $arrGrandTotal[$pc]<0?"budget-negative":"";
	echo "<td class='budget-decimal $strClass'>",number_format($arrGrandTotal[$pc],0,'.',','),'</td>';
}
$strClass = array_sum($arrGrandTotal)<0?"budget-negative":"";
echo "<td class='budget-decimal budget-ytd $strClass'>",number_format(array_sum($arrGrandTotal),0,'.',','),'</td>';
echo '</tr>';

?>
</tbody>
</table>
	<ul class='link-footer'>
		<li><a href='javascript:SelectContent("report");'>Select table</a></li>
	</ul>
<?php
include ('includes/inc-frame_bottom.php');
?>