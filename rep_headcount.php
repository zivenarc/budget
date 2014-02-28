<?php
require ('common/auth.php');
require ('classes/budget.class.php');




if(!isset($_GET['tab'])){
	$arrJS[]='js/input_form.js';
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],'</h1>';
	Budget::getProfitTabs('reg_headcount');
	include ('includes/inc-frame_bottom.php');
} else {
	require ('classes/reports.class.php');
	if ($_GET['tab']=='all') {
		$sqlWhere = "WHERE scenario='$budget_scenario'";
	} else {
		$sqlWhere = "WHERE pc in (SELECT pccID FROM vw_profit WHERE pccGUID=".$oSQL->e($_GET['tab']).") AND scenario='$budget_scenario'";
	}
	Reports::headcountByJob($sqlWhere);
}


?>