<?php
$flagNoAuth =true;
require ('common/auth.php');
require ('classes/reports.class.php');
require ('classes/budget.class.php');
include ('includes/inc-frame_top.php');

$budget_scenario = isset($_GET['budget_scenario'])?$_GET['budget_scenario']:$budget_scenario;

if (isset($_POST['activity'])){
	$sqlWhere = " AND activity=".$oSQL->e($_POST['activity']);
}

if ($_POST['pccGUID']=='all'){
	$strPCFilter = '';
} else {
	$strPCFilter = " AND pccGUID=".$oSQL->e($_POST['pccGUID']);
}

// $sql = "SELECT cntTitle, ".Budget::getMonthlySumSQL().", SUM(".Budget::getYTDSQL().") as YTD FROM reg_sales
		// LEFT JOIN vw_profit ON pccID=reg_master.pc
		// WHERE $strPCFilter $sqlWhere  AND reg_sales.scenario='$budget_scenario'
		// GROUP BY customer
		// ORDER BY YTD DESC";	
// echo '<pre>',$sql,'</pre>';		
// $rs =$oSQL->q($sql);
// while ($rw=$oSQL->f($rs)){
	// $data[] = $rw;
// }
Reports::salesByCustomer($strPCFilter.' '.$sqlWhere." AND scenario='{$budget_scenario}' AND active=1");
?>
	
<?php
include ('includes/inc-frame_bottom.php');
?>