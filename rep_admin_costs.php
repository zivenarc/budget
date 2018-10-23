<?php
//$flagNoAuth = true;
require ('common/auth.php');
require ('classes/reports.class.php');
require ('classes/reference.class.php');
require ('classes/item.class.php');
include ('includes/inc_report_settings.php');
$arrJS[]='js/rep_pnl.js';

$arrItems[] = Items::COMPANY_CARS;
$arrItems[] = Items::OFFICE_RENT;
$arrItems[] = Items::STATIONERY;
$arrItems[] = Items::OTHER_OFFICE;
$arrItems[] = Items::CANTEEN;
$arrItems[] = Items::EXPAT_HOUSING;
$arrItems[] = Items::EXPAT_COSTS;
$arrItems[] = Items::OTHER_COMMUNICATION;

$oReport = new Reports(Array('budget_scenario'=>$budget_scenario, 'currency'=>$currency, 'denominator'=>$denominator, 'reference'=>$reference,'filter'=>Array('item'=>$arrItems)));
$oBudget = new Budget($budget_scenario);

include ('includes/inc-frame_top.php');
echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,'</h1>';

include ('includes/inc_report_selectors.php');
?>
<div id='report_content'>
<?php
$oReport->quarterly('item_bu',false);	
?>
</div>
<?php
include ('includes/inc-frame_bottom.php');
?>