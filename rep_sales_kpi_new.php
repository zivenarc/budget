<?php
$flagNoAuth = true;
require ('common/auth.php');
require ('classes/budget.class.php');

session_start();

$cntID = isset($_GET['cntID'])?(integer)$_GET['cntID']:(isset($_SESSION['cntID'])?$_SESSION['cntID']:9907);//new if not defined
$_SESSION['cntID'] = $cntID;

$budget_scenario = isset($_GET['budget_scenario'])?$_GET['budget_scenario']:$budget_scenario;
$oBudget = new Budget($budget_scenario);

if(!isset($_GET['tab'])){
	$arrJS[] = 'https://www.google.com/jsapi';
	$arrJS[]='js/rep_pnl.js';
	include ('includes/inc-frame_top.php');
	echo '<h1>',$oBudget->title,' :: ',$arrUsrData["pagTitle$strLocal"],'</h1>';
	
	$sql = "SELECT cntTitle$strLocal FROM vw_customer WHERE cntID={$cntID} LIMIT 1";
	$rs = $oSQL->q($sql);
	$cntTitle = $oSQL->get_data($rs);
	echo '<h2>',$cntTitle,'</h2>';
	
	?>
	<div class='f-row'><label for='budget_scenario'>Select scenario</label><?php echo Budget::getScenarioSelect();?></div>
	<?php
	Budget::getProfitTabs('reg_sales');	
	include ('includes/inc-frame_bottom.php');
} else {
	require ('classes/reports.class.php');
	include ('includes/inc_report_buttons.php');
	if ($_GET['tab']=='all'){
		$sqlWhere = " WHERE scenario='$budget_scenario' AND customer={$cntID}";
	} else {
		$sqlWhere = "WHERE pc in (SELECT pccID FROM vw_profit WHERE pccGUID=".$oSQL->e($_GET['tab']).") AND scenario='$budget_scenario' AND customer={$cntID}";
	}

	Reports::salesByActivity($sqlWhere);
	?>
		<div id='graph'/>
		<ul class='link-footer'>
			<li><a href='javascript:SelectContent("kpi_<?php echo $_GET['tab'];?>");'>Select table</a></li>
		</ul>
	<?php	
	Reports::masterbyGHQEst($sqlWhere);
		?>
		<ul class='link-footer'>
			<li><a href='javascript:SelectContent("report_<?php echo $_GET['tab'];?>");'>Select table</a></li>
		</ul>
	<?php
}


?>