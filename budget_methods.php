<?php
$flagNoAuth = true;
require ('common/auth.php');
include ('classes/budget.class.php');

$oBudget = new Budget($budget_scenario);
include ('includes/inc-frame_top.php');

echo '<pre>',$oBudget->getYTDSQL(),'</pre>';
echo '<pre>',$oBudget->getMonthlySQL(),'</pre>';
echo '<pre>',$oBudget->getMonthlySumSQL(),'</pre>';
echo '<pre>',$oBudget->getQuarterlySumSQL(),'</pre>';

include ('includes/inc-frame_bottom.php');


?>