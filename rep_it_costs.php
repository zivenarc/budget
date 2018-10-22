<?php
//$flagNoAuth = true;
require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/reference.class.php');
require ('classes/item.class.php');
require ('classes/reports.class.php');
include ('includes/inc_report_settings.php');

$arrItems[] = Items::IT_EQUIPMENT;
$arrItems[] = Items::INTERNET;
$arrItems[] = Items::IT_COSTS;
$arrItems[] = Items::IT_SUPPORT;
$arrItems[] = Items::SATELLITE;
$arrItems[] = Items::ONEASS;
$arrItems[] = Items::RHQ_IT_COST;

$oReport = new Reports(Array('budget_scenario'=>$budget_scenario, 'currency'=>$currency, 'denominator'=>$denominator, 'reference'=>$reference,'filter'=>Array('item'=>$arrItems)));
$oBudget = new Budget($budget_scenario);
$arrJS[]='js/rep_pnl.js';

include ('includes/inc-frame_top.php');
echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,'</h1>';

include ('includes/inc_report_selectors.php');
// include ('includes/inc_report_buttons.php');



$strItems = "'".implode("','",$arrItems)."'";

$sqlWhere = "WHERE `item` IN ($strItems)";
?>
<div id='report_content'>
<?php
$oReport->quarterly('item_bu',false);	
?>
</div>
<?php
include ('includes/inc-frame_bottom.php');
?>