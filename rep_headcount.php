<?php
require ('common/auth.php');
require ('classes/budget.class.php');

$budget_scenario = isset($_GET['budget_scenario'])?$_GET['budget_scenario']:$budget_scenario;

if($_POST['pccGUID'] && $_POST['activity']){
	
	$sql = "SELECT ".Budget::getMonthlySumSQL()." FROM reg_headcount 
				LEFT JOIN vw_product_type ON prtID=activity
				WHERE scenario=".$oSQL->e($_POST['budget_scenario'])."
					AND posted=1 AND salary>0
					AND prtGHQ=(SELECT DISTINCT prtGHQ FROM vw_product_type WHERE prtTitle=".$oSQL->e($_POST['activity']).")
					AND pc in (SELECT pccID FROM vw_profit WHERE pccGUID=".$oSQL->e($_POST['pccGUID']).")
					GROUP BY activity";
	$rs = $oSQL->q($sql);
	$rw = $oSQL->f($rs);
	// echo $sql;
	header('Content-type:application/json');
	echo json_encode($rw);
	die();
}

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