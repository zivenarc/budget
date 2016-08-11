<?php
require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/reports.class.php');

include ('includes/inc_report_settings.php');

$oReport = new Reports(Array('budget_scenario'=>$budget_scenario, 'currency'=>$currency, 'denominator'=>$denominator));
$oBudget = new Budget($budget_scenario);

if($_POST['pccGUID'] && $_POST['activity']){
	
	$sql = "SELECT ".$oBudget->getMonthlySumSQL()." FROM reg_headcount 
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

if(!isset($_GET['pccGUID'])){

	$arrJS[]='js/rep_pnl.js';
	//$arrJS[]='js/input_form.js';
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,'</h1>';
	echo '<p>',$oBudget->timestamp,'; ',$oBudget->rates,'</p>';
	?>
	<div class='f-row'><label for='budget_scenario'>Select scenario</label><?php echo $oBudget->getScenarioSelect();?></div>
	<?php
	$oBudget->getProfitTabs('reg_headcount');
	include ('includes/inc-frame_bottom.php');
} else {

	if ($_GET['pccGUID']=='all') {
		$sqlWhere = "WHERE scenario='$budget_scenario'";
	} else {
		
		$sql = "SELECT pccID FROM common_db.tbl_profit WHERE pccGUID=".$oSQL->e($_GET['pccGUID'])." LIMIT 1";
		$rs = $oSQL->q($sql);
		$pccID = $oSQL->get_data($rs);
		$filter['pc']=$pccID;
	
		$sqlWhere = "WHERE pc='{$pccID}' AND scenario='$budget_scenario'";
	}
	$oReport->headcountByJob($sqlWhere);
}


?>