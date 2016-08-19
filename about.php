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
	<a href="rep_summary.php?budget_scenario=<?php echo $oBudget->id;?>&reference=<?php echo $oReference->id;?>">Summary</a>|
	<a href="rep_monthly.php?budget_scenario=<?php echo $oBudget->id;?>&reference=<?php echo $oReference->id;?>">Monthly report</a>|
	<a href="rep_pnl.php?budget_scenario=<?php echo $oBudget->id;?>&reference=<?php echo $oReference->id;?>">Full-year estimate</a>|
	<a href="rep_totals.php?budget_scenario=<?php echo $oBudget->id;?>&reference=<?php echo $oReference->id;?>">Results per BU</a>|
	<a href="rep_waterfall.php?budget_scenario=<?php echo $oBudget->id;?>&reference=<?php echo $oReference->id;?>">Waterfall</a>|
	<a href="rep_graphs.php?budget_scenario=<?php echo $oBudget->id;?>&reference=<?php echo $oReference->id;?>">Charts</a>
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

$sqlActual = "SUM(".$oBudget->getThisYTDSQL($period_type,$arrActualRates).")";
$sqlBudget = "SUM(".$oBudget->getThisYTDSQL($period_type,$arrBudgetRates).")";
$settings['gpcus'] = Array('title'=>"GP by customer, current month",
					'sqlBase' => "SELECT customer_group_code as optValue, 
											customer_group_title as optText,  
										{$sqlActual} as Actual, 
										0 as Budget, 
										{$sqlActual} as Diff
								FROM vw_master 
								WHERE scenario='{$oBudget->id}' 
									AND account IN ('J00400', 'J00802')
									{$sqlActivityFilter}
								GROUP BY customer_group_code
								UNION ALL
								SELECT customer_group_code as optValue, 
											customer_group_title as optText,  
											0 as Actual, 
								{$sqlBudget}  as Budget, -{$sqlBudget} as Diff
								FROM vw_master 
								WHERE
								scenario='{$oReference->id}' 
									AND source<>'Estimate' 
									AND account IN ('J00400', 'J00802')
									{$sqlActivityFilter}
								GROUP BY customer_group_code",
						'tolerance'=>0.05,
						'denominator'=>$denominator,
						'limit'=>10);	

$oWF = new Waterfall($settings['gpcus']);

$oWF->draw();
?>
</div>
<?php
require ('includes/inc-frame_bottom.php');
?>