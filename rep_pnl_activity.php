<?php
$flagNoAuth = true;
require ('common/auth.php');
require ('classes/budget.class.php');

$budget_scenario = isset($_GET['budget_scenario'])?$_GET['budget_scenario']:$budget_scenario;


if(!isset($_GET['tab'])){
	$oBudget = new Budget($budget_scenario);
	$arrJS[]='js/rep_pnl.js';
	// $arrJS[]='js/input_form.js';	
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,'</h1>';
	?>
	<div class='f-row'><label for='budget_scenario'>Select scenario</label><?php echo Budget::getScenarioSelect();?></div>
	<?php
	// Budget::getGHQTabs('reg_master', true);
	Budget::getActivityTabs('reg_master', true);
	include ('includes/inc-frame_bottom.php');
} else {
	require ('classes/reports.class.php');
	include ('includes/inc_report_buttons.php');
	if ($_GET['tab']=='all'){
		$sqlWhere = "WHERE 1=1";
	} else {
		// $sqlWhere = "WHERE activity in (SELECT prtID FROM vw_product_type WHERE prtGHQ=".$oSQL->e($_GET['tab']).")";
		$sqlWhere = "WHERE activity = ".$oSQL->e($_GET['tab']);
	}
	
	Reports::masterByCustomerEst($sqlWhere." AND scenario='$budget_scenario'");
	?>
		<ul class='link-footer'>
			<li><a href='javascript:SelectContent("report_<?php echo $_GET['tab'];?>");'>Select table</a></li>
		</ul>
	<?php
}


?>