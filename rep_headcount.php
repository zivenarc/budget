<?php
require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/reports.class.php');

include ('includes/inc_report_settings.php');

$oBudget = new Budget($budget_scenario);

if($_POST['pccGUID'] && $_POST['activity']){
	
	$sql = "SELECT ".$oBudget->getMonthlySumSQL()." FROM reg_headcount 
				LEFT JOIN vw_product_type ON prtID=activity
				WHERE scenario=".$oSQL->e($_POST['budget_scenario'])."
					AND posted=1 AND salary>".Reports::SALARY_THRESHOLD."
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

	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,' vs ',$oReference->title,'</h1>';	
	include ('includes/inc_report_selectors.php');
	echo '<p>',$oBudget->timestamp,'; ',$oBudget->rates,'</p>';
	
	$oBudget->getProfitTabs('reg_headcount', true);
	
	?>
	<script>
		$('#currency_selector').find('input').attr('disabled',true);
		$('#denominator_selector').find('input').attr('disabled',true);
	</script>
	<?php
	include ('includes/inc-frame_bottom.php');
} else {

	include ('includes/inc_report_pcfilter.php');
	$oReport = new Reports(Array('budget_scenario'=>$oBudget->id, 'currency'=>$currency, 'denominator'=>$denominator, 'reference'=>$oReference->id, 'filter'=>$filter));
	$oReport->headcountByJob($sqlWhere);
}


?>