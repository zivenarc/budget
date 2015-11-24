<?php
//$flagNoAuth = true;
require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/reference.class.php');
require ('classes/item.class.php');
require ('classes/reports.class.php');
include ('includes/inc_report_settings.php');

$oReport = new Reports(Array('budget_scenario'=>$budget_scenario, 'currency'=>$currency, 'denominator'=>$denominator, 'reference'=>$reference));
$oBudget = new Budget($budget_scenario);
$arrJS[]='js/rep_pnl.js';

include ('includes/inc-frame_top.php');
echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,'</h1>';

$arrItems[] = Items::IT_EQUIPMENT;
$arrItems[] = Items::INTERNET;
$arrItems[] = Items::IT_COSTS;
$arrItems[] = Items::IT_SUPPORT;
$arrItems[] = Items::SATELLITE;
$arrItems[] = Items::ONEASS;

$strItems = "'".implode("','",$arrItems)."'";

$sqlWhere = "WHERE `item` IN ($strItems)  AND scenario='$budget_scenario'";
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
$oReport->periodicPnL($sqlWhere,Array('field_data'=>'pc','field_title'=>'Profit','title'=>'PC'));	
?>
</div>
<?php
include ('includes/inc-frame_bottom.php');
?>