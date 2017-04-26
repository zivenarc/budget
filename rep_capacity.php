<?php
$flagNoAuth = true;
require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/reports.class.php');

include ('includes/inc_report_settings.php');

$oBudget = new Budget($budget_scenario);
$oReport = new Reports(Array('budget_scenario'=>$budget_scenario));

if ($reference!=$oBudget->reference_scenario->id){
	$oReference = new Budget($reference);
	$strVsTitle = ' vs '.$oReference->title;
} else {
	$reference = $oBudget->reference_scenario->id;
}
include ('includes/inc-frame_top.php');
echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,$strVsTitle,'</h1>';

include ('includes/inc_report_selectors.php');
echo '<p>',$oBudget->timestamp,'; ',$oBudget->rates,'</p>';

$sql = "SELECT pol, pod, ".$oBudget->getMonthlySumSQL($oBudget->offset+1, $oBudget->offset+12)." 
		FROM reg_sales
		WHERE activity IN (48,63) AND scenario='{$oBudget->id}' AND company='{$company}'
		GROUP BY pol, pod
		ORDER BY pol, pod";
$rs = $oSQL->q($sql);
?>
<table class='budget'>
	<thead>
		<tr>
			<th>POL</th>
			<th>POD</th>
			<?php echo $oBudget->getTableHeader('monthly',$oBudget->offset+1,$oBudget->offset+12);?>
		</tr>
	</thead>
<?php
while ($rw = $oSQL->f($rs)){
	?>
	<tr>
		<td><?php echo $rw['pol'];?></td>
		<td><?php echo $rw['pod'];?></td>
		<?php 
			for ($m=$oBudget->offset+1;$m<=$oBudget->offset+12;$m++){
				$month = $oBudget->arrPeriod[$m];
				echo '<td class="budget-decimal">',$oReport->render($rw[$month]),'</td>';
			};
		?>
	</tr>
	<?php
}
?>
</table>
<?php
include ('includes/inc-frame_bottom.php');



?>