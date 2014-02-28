<?php
//$flagNoAuth = true;
require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/reports.class.php');
require ('classes/reference.class.php');
require ('classes/item.class.php');

$oBudget = new Budget($budget_scenario);
$arrJS[]='js/rep_pnl.js';

include ('includes/inc-frame_top.php');
echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,'</h1>';

$sqlWhere = "WHERE `Group_code` IN (95)  AND scenario='$budget_scenario'";
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