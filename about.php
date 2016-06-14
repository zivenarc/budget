<?php
require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/reports.class.php');
require ('classes/waterfall.class.php');

if (isset($_GET['no_activity'])){
	$arrNoActivity = $_GET['no_activity'];
	$sqlActivityFilter = " AND activity NOT IN(".implode(",",$arrNoActivity).") ";
	
	$filter['no_activity']=$_GET['no_activity'];
	
	$sql = "SELECT prtTitle FROM vw_product_type WHERE prtID IN (".implode(",",$arrNoActivity).") ";
	$rs = $oSQL->q($sql);
	while ($rw = $oSQL->f($rs)){
		$arrActivityFilter[] = $rw['prtTitle'];
	}
	$strActivity = implode(", ",$arrActivityFilter)." excluded";
	
}

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

$denominator = 1000;
$oBudget = new Budget($arrSetup['stpFYEID']);
$oReference = new Budget($arrSetup['stpScenarioID']);
?>
<h1>Current scenario: <?php echo $oBudget->title; ?>, current budget - <?php echo $oReference->title; ?></h1>
<nav>
	<a href="rep_monthly.php?budget_scenario=<?php echo $oBudget->id;?>&reference=<?php echo $oReference->id;?>">Monthly report</a>|
	<a href="rep_pnl.php?budget_scenario=<?php echo $oBudget->id;?>&reference=<?php echo $oReference->id;?>">Full-year estimate</a>|
	<a href="rep_totals.php?budget_scenario=<?php echo $oBudget->id;?>&reference=<?php echo $oReference->id;?>">Results per BU</a>|
	<a href="rep_waterfall.php?budget_scenario=<?php echo $oBudget->id;?>&reference=<?php echo $oReference->id;?>">Waterfall</a>
</nav>
<br/>
<?php
if ($strActivity) {
	echo '<div class="info">',$strActivity,'</div>';
}

$oReport = new Reports(Array('budget_scenario'=>$oBudget->id, 'currency'=>643, 'denominator'=>$denominator, 'reference'=>$oReference->id, 'filter'=>$filter));
$oReport->shortMonthlyReport();	

//-----------------Waterfall
?>
<div>
<?php
$period_type = 'cm';

$sqlActual = "SUM(".$oBudget->getThisYTDSQL($period_type,$arrActualRates).")/{$denominator}";
$sqlBudget = "SUM(".$oBudget->getThisYTDSQL($period_type,$arrBudgetRates).")/{$denominator}";
$settings['gpcus'] = Array('title'=>"GP by customer",
					'sqlBase' => "SELECT IF(C.cntParentID<>723,C.cntParentID, C.cntID) as optValue, 
										IF(C.cntParentID<>723,(SELECT P.cntTitle FROM common_db.tbl_counterparty P WHERE P.cntID=C.cntParentID),cntTitle) as optText, 
										{$sqlActual} as Actual, 
										0 as Budget, 
										{$sqlActual} as Diff
								FROM vw_master 
								LEFT JOIN common_db.tbl_counterparty C ON C.cntID=customer
								WHERE scenario='{$oBudget->id}' 
									AND account IN ('J00400', 'J00802')
									{$sqlActivityFilter}
								GROUP BY IF(C.cntParentID<>723,C.cntParentID, C.cntID)
								UNION ALL
								SELECT IF(C.cntParentID<>723,C.cntParentID,C.cntID), IF(C.cntParentID<>723,(SELECT P.cntTitle FROM common_db.tbl_counterparty P WHERE P.cntID=C.cntParentID),cntTitle) as optText, 0 as Actual, 
								{$sqlBudget}  as Budget, -{$sqlBudget} as Diff
								FROM vw_master 
								LEFT JOIN common_db.tbl_counterparty C ON C.cntID=customer
								WHERE
								scenario='{$oReference->id}' 
									AND source<>'Estimate' 
									AND account IN ('J00400', 'J00802')
									{$sqlActivityFilter}
								GROUP BY IF(C.cntParentID<>723,C.cntParentID, C.cntID)",
						'tolerance'=>0.05,
						'limit'=>10);	

$oWF = new Waterfall($settings['gpcus']);

$oWF->draw();
?>
</div>
<?php
require ('includes/inc-frame_bottom.php');
?>