<?php
$flagNoAuth=true;
require ('common/auth.php');
require ('classes/reports.class.php');
include ('includes/inc_report_settings.php');

$budget_scenario = isset($_REQUEST['budget_scenario'])?$_REQUEST['budget_scenario']:$budget_scenario;
$reference = isset($_REQUEST['reference'])?$_REQUEST['reference']:$reference;
$oReport = new Reports(Array('budget_scenario'=>$budget_scenario, 'currency'=>$currency, 'denominator'=>$denominator, 'reference'=>$reference, 'filter'=>$_POST['filter']));

include ('includes/inc-frame_top.php');
?>
<div id='output'>
<h2><?php echo $rwAct["prtTitle$strLocal"]," | ",$rwRte['rteTitle'];?></h2>
<?php
$oReport->monthlyReport('activity',Array('financial'=>true,'summary'=>false,'kpi'=>false,'headcount'=>false));
?>
</div>
<?php
include ('includes/inc-frame_bottom.php');
?>