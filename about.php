<?php
require ('common/auth.php');
require ('classes/budget.class.php');

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
<?php
require ('includes/inc-frame_bottom.php');
?>