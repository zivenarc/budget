<?php
require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/reports.class.php');
include ('includes/inc_report_settings.php');
include ('includes/inc_report_pcfilter.php');

$oBudget = new Budget($budget_scenario);
$oReport = new Reports(Array('budget_scenario'=>$budget_scenario, 'currency'=>$currency, 'denominator'=>$denominator, 'filter'=>$filter));

if(!isset($_GET['pccGUID'])){
	//$arrJS[] = 'https://www.google.com/jsapi';
	$arrJS[]='js/rep_pnl.js';
	include ('includes/inc-frame_top.php');
	echo '<h1>',$oBudget->title,' :: ',$arrUsrData["pagTitle$strLocal"],'</h1>';
	include ('includes/inc_report_selectors.php');
	Budget::getProfitTabs('reg_sales', false);	
	include ('includes/inc-frame_bottom.php');
} else {	
	include ('includes/inc_report_buttons.php');
	if ($_GET['pccGUID']=='all'){
		$sqlWhere = " WHERE scenario='$budget_scenario'";
	} else {
		$sqlWhere = "WHERE pc in (SELECT pccID FROM vw_profit WHERE pccGUID=".$oSQL->e($_GET['pccGUID']).") AND scenario='$budget_scenario'";
	}
	
	$oReport->salesByActivity($sqlWhere);
	?>
		<!--<input id='pccGUID' type="hidden" value="<?php echo $_GET['pccGUID'];?>"/>-->
		<div id='graph'/>
	<?php
}


?>