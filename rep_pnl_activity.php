<?php
$flagNoAuth = true;
require ('common/auth.php');
require ('classes/budget.class.php');

include ('includes/inc_rep_activity.php');


if(!isset($_GET['tab'])){
	$oBudget = new Budget($budget_scenario);
	$arrJS[]='js/rep_pnl.js';
	// $arrJS[]='js/input_form.js';	
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,'</h1>';
	echo '<h2>',$subtitle,'</h2>';
	echo '<p>',$oBudget->timestamp,'</p>';
	?>
	<div class='f-row'><label for='budget_scenario'>Select scenario</label><?php echo Budget::getScenarioSelect();?></div>
	<?php
	// Budget::getGHQTabs('reg_master', true);
	Budget::getActivityTabs('reg_master', true, "WHERE TRUE ".$sqlActivityFilter);
	include ('includes/inc-frame_bottom.php');
} else {
	require ('classes/reports.class.php');
	include ('includes/inc_report_buttons.php');
	if ($_GET['tab']=='all'){
		$sqlWhere = "WHERE 1=1 {$sqlActivityFilter}";
	} else {
		// $sqlWhere = "WHERE activity in (SELECT prtID FROM vw_product_type WHERE prtGHQ=".$oSQL->e($_GET['tab']).")";
		$sqlWhere = "WHERE activity = ".$oSQL->e($_GET['tab'])."  {$sqlActivityFilter}";
	}
	echo '<pre>',$sqlWhere,'</pre>';
	Reports::masterByCustomerEst($sqlWhere." AND scenario='$budget_scenario'");
	?>
		<ul class='link-footer'>
			<li><a href='javascript:SelectContent("report_<?php echo $_GET['tab'];?>");'>Select table</a></li>
		</ul>
	<?php
}


?>