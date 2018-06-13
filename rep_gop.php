<?php
$flagNoAuth = true;
require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/reports.class.php');
include ('includes/inc_report_settings.php');

$arrActions[] = Array('title'=>'Current month','action'=>'?period_type=cm');
$arrActions[] = Array('title'=>'FYE','action'=>'?period_type=fye');

if ($bu_group){
	$sql = "SELECT * FROM common_db.tbl_profit WHERE pccParentCode1C='{$bu_group}'";
	$rs = $oSQL->q($sql);
	while ($rw = $oSQL->f($rs)){
		$arrBus[] = $rw['pccID']; 
	}
}
	
	$oBudget = new Budget($budget_scenario);
	$oReference = new Budget($reference);
	
	if(strpos($oBudget->type,"Budget")!==false){	
		$period_type = 'budget';
	}
	//$period_type = 'cm';
	
	if ($_GET['debug']){
		echo '<pre>';print_r($oBudget);echo '</pre>';
	}

if(!isset($_GET['pccGUID'])){
	
	$arrJS[]='js/rep_pnl.js';

	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,' vs ',$oReference->title,'</h1>';	
	include ('includes/inc_report_selectors.php');
	echo '<p>',$oBudget->timestamp,'; ',$oBudget->rates,'</p>';
	
	$oBudget->getProfitTabs('reg_master', true);
	
	include ('includes/inc-frame_bottom.php');
} else {

	
	include ('includes/inc_report_pcfilter.php');
	
	if(is_array($arrPCHeader)){
		echo '<p>',implode(' | ',$arrPCHeader),'</p>';
	}
	$oReport = new Reports(Array('budget_scenario'=>$oBudget->id, 'currency'=>$currency, 'denominator'=>$denominator, 'reference'=>$oReference->id, 'filter'=>$filter));
	$oReport->GOP($period_type);	
	
	?>
	
	<?php
	
}


?>