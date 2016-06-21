<?php
$flagNoAuth = true;
require ('common/auth.php');
include ('classes/budget.class.php');

$oBudget = new Budget($budget_scenario);
include ('includes/inc-frame_top.php');

echo '<pre>',$oBudget->getYTDSQL(),'</pre>';
echo '<pre>',$oBudget->getYTDSQL(4,15),'</pre>';
echo '<pre>',$oBudget->getMonthlySQL(1,15),'</pre>';
echo '<pre>',$oBudget->getMonthlySumSQL(1,12),'</pre>';
echo '<pre>',$oBudget->getMonthlySumSQL(4,15),'</pre>';
echo '<pre>',$oBudget->getQuarterlySumSQL(),'</pre>';

include ('includes/inc-frame_bottom.php');


?>