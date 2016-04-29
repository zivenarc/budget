<?php
require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/reports.class.php');

   $arrActions[] = Array(
   "title" => ShowFieldTitle('Print')
   , "class" => "print"
   , "action" => "javascript:window.print();"
   );
   $arrActions[] = Array(
   "title" => ShowFieldTitle('help')
   , "class" => "question"
   , "action" => "/wiki/Treasury"
   );

$arrJS[]='js/about.js';
require ('includes/inc-frame_top.php');

$oBudget = new Budget($arrSetup['stpFYEID']);
$oReference = new Budget($arrSetup['stpScenarioID']);
?>
<h1>Current scenario: <?php echo $oBudget->title; ?>, current budget - <?php echo $oReference->title; ?></h1>
<nav>
	<a href="rep_monthly.php?budget_scenario=<?php echo $oBudget->id;?>&reference=<?php echo $oReference->id;?>">Monthly report</a>|
	<a href="rep_pnl.php?budget_scenario=<?php echo $oBudget->id;?>&reference=<?php echo $oReference->id;?>">Full-year estimate</a>|
	<a href="rep_totals.php?budget_scenario=<?php echo $oBudget->id;?>&reference=<?php echo $oReference->id;?>">Results per BU</a>
</nav>
<br/>
<?php

$oReport = new Reports(Array('budget_scenario'=>$oBudget->id, 'currency'=>643, 'denominator'=>1000, 'reference'=>$oReference->id, 'filter'=>$filter));
$oReport->shortMonthlyReport();	

require ('includes/inc-frame_bottom.php');
?>