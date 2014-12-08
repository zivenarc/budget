<?php
$flagNoAuth = true;
require ('common/auth.php');
require ('classes/budget.class.php');

$cntID = isset($_GET['cntID'])?(integer)$_GET['cntID']:9907;//new if not defined
$budget_scenario = isset($_GET['budget_scenario'])?$_GET['budget_scenario']:$budget_scenario;

$oBudget = new Budget($budget_scenario);

$_SESSION['cntID'] = $cntID;

if(!isset($_GET['tab'])){
	$arrJS[] = 'https://www.google.com/jsapi';
	$arrJS[]='js/rep_pnl.js';
	include ('includes/inc-frame_top.php');
	echo '<h1>',$oBudget->title,' :: ',$arrUsrData["pagTitle$strLocal"],'</h1>';
	
	$sql = "SELECT cntTitle$strLocal FROM vw_customer WHERE cntID={$_SESSION['cntID']} LIMIT 1";
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
		$sqlWhere = " WHERE scenario='$budget_scenario' AND customer={$_SESSION['cntID']}";
	} else {
		$sqlWhere = "WHERE pc in (SELECT pccID FROM vw_profit WHERE pccGUID=".$oSQL->e($_GET['tab']).") AND scenario='$budget_scenario' AND customer={$_SESSION['cntID']}";
	}

	Reports::salesByActivity($sqlWhere);
	?>
		<div id='graph'/>
		<ul class='link-footer'>
			<li><a href='javascript:SelectContent("report_<?php echo $_GET['tab'];?>");'>Select table</a></li>
		</ul>
	<?php
}


?>