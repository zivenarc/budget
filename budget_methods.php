<?php
$flagNoAuth = true;
require ('common/auth.php');
include ('classes/budget.class.php');

$oBudget = new Budget($budget_scenario);
include ('includes/inc-frame_top.php');

echo '<pre>',Budget::getYTDSQL(),'</pre>';
echo '<pre>',Budget::getMonthlySQL(),'</pre>';
echo '<pre>',Budget::getMonthlySumSQL(),'</pre>';
echo '<pre>',Budget::getQuarterlySumSQL(),'</pre>';

include ('includes/inc-frame_bottom.php');


?>