<?php
$flagNoAuth = true;

require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/reports.class.php');

include ('includes/inc_report_settings.php');

$oBudget = new Budget($budget_scenario);
$mthStart = $_GET['mthStart']?(integer)$_GET['mthStart']:1;
$mthEnd = $_GET['mthEnd']?(integer)$_GET['mthEnd']:12;
$strLastTitle = $oBudget->type=='FYE'?'Budget':$oBudget->reference_scenario->id;

$arrRates_this = $oBudget->getMonthlyRates($currency);
$arrRates_last = $oBudget->reference_scenario->getMonthlyRates($currency);

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
<?php
include ('includes/inc_report_selectors.php');

echo '<p>',$oBudget->timestamp,'; ',$oBudget->rates,'</p>';

$sql = "SELECT account, Title, ".$oBudget->getMonthlySumSQL($mthStart,$mthEnd,$arrRates_this).", SUM(".$oBudget->getYTDSQL($mthStart,$mthEnd,$arrRates_this).")/{$denominator} as Total, 0 as Estimate
		FROM vw_master
		WHERE scenario='{$oBudget->id}'
		GROUP BY account, Title
		ORDER BY account	";

// echo '<pre>',$sql,'</pre>';
		
$rs = $oSQL->q($sql);
$tableID=md5($sql);
?>
<table id="<?php echo $tableID;?>" class="budget">
<thead>
	<tr>
		<th>Account</th>
		<th>Title</th>
		<?php
		for ($m=$mthStart;$m<=$mthEnd;$m++){
			$month = $oBudget->arrPeriod[$m];
			?>
			<th><?php echo ucfirst($month);?></th>
			<?php
		}
		?>
		<th>Total</th>
</thead>
<tbody>
<?php
while ($rw=$oSQL->f($rs)){
	?>
	<tr>
		<td><?php echo $rw['account'];?></td>
		<td><?php echo $rw['Title'];?></td>
		<?php
		for ($m=$mthStart;$m<=$mthEnd;$m++){
			$month = $oBudget->arrPeriod[$m];
			$arrTotal[$month] += $rw[$month];
			?>
			<td class="budget-decimal"><?php Reports::render(abs($rw[$month]));?></td>
			<?php
		}
		$arrTotal['Total'] += $rw['Total'];
		?>
		<td class="budget-decimal budget-ytd"><?php Reports::render(abs($rw['Total']));?></td>
	</tr>
<?php
}
?>
<tr class="budget-subtotal">
	<td colspan="2">Total</td>
	<?php	
	for ($m=$mthStart;$m<=$mthEnd;$m++){
		$month = $oBudget->arrPeriod[$m];		
		?>
		<td class="budget-decimal"><?php Reports::render($arrTotal[$month]);?></td>
		<?php
	}
	?>
	<td class="budget-decimal budget-ytd"><?php Reports::render($arrTotal['Total']);?></td>
</tr>
</tbody>
</table>

		