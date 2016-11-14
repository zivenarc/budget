<?php
//$flagNoAuth = true;
require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/reports.class.php');
require ('classes/reference.class.php');
require ('classes/item.class.php');

include ('includes/inc_report_settings.php');

$oBudget = new Budget($budget_scenario);
$arrJS[]='js/rep_pnl.js';

include ('includes/inc-frame_top.php');
echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,'</h1>';

if($_GET['DataAction']=='full'){
	$sql = "SELECT * FROM vw_headcount WHERE scenario='{$budget_scenario}' ORDER BY empTitleLocal";
	$rs = $oSQL->q($sql);
	?>
	<table id='headcount' class='log'>
	<?php
	while ($rw = $oSQL->f($rs)){
		?>
		<tr>
			<td><?php echo $rw['empCode1C'];?></td>
			<td><?php echo $rw['empTitleLocal'];?></td>
			<td><?php echo $rw['funTitleLocal'];?></td>
			<td><?php echo $rw['Location'];?></td>
			<td><?php echo $rw['pccTitle'];?></td>
			<td><?php echo $rw['empSalary'];?></td>
			<td><?php echo $rw['salary'];?></td>
		</tr>
		<?php
	}
	?>
	</table>
	<?php
	include ('includes/inc-frame_bottom.php');
	die();
}

$sqlWhere = "WHERE `Group_code` IN (95)  AND scenario='{$budget_scenario}'";
?>
<script>
	$(document).ready(function(){
		$('#period_switch').buttonset().children('input').change(function(){
				if($(this).val()=='monthly'){
					$('.budget-monthly').show();
					$('.budget-quarterly').hide();
				} else {
					$('.budget-monthly').hide();
					$('.budget-quarterly').show();
				}
		});
		init_panel($('#report_content'));
	});
</script>
<div class="report-radio f-row">
<div id='period_switch'>
		<input type='radio' id='period_monthly_<?php echo $_GET['tab'];?>' name='period' value='monthly'/>
		<label for='period_monthly_<?php echo $_GET['tab'];?>'>Monthly</label>
		<input type='radio' checked id='period_quarterly_<?php echo $_GET['tab'];?>' name='period' value='quarterly'/>
		<label for='period_quarterly_<?php echo $_GET['tab'];?>'>Quarterly</label>
	</div>
</div>
<div id='report_content'>
<?php
Reports::masterbyProfitEst($sqlWhere);
?>
</div>
<?php
include ('includes/inc-frame_bottom.php');
?>