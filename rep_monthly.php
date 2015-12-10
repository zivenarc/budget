<?php
require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/reports.class.php');
include ('includes/inc_report_settings.php');



$oReport = new Reports(Array('budget_scenario'=>$budget_scenario, 'currency'=>$currency, 'denominator'=>$denominator, 'reference'=>$reference));

$oBudget = new Budget($budget_scenario);
if ($reference!=$oBudget->reference_scenario->id){
	$oReference = new Budget($reference);
	$strVsTitle = ' vs '.$oReference->title;
}

if(!isset($_GET['pccGUID'])){
	
	$arrJS[]='js/rep_pnl.js';
	// $arrJS[]='js/input_form.js';	
	
	$arrActions[] = Array ('title'=>'By customer','action'=>"?budget_scenario={$budget_scenario}&type=customer");
	$arrActions[] = Array ('title'=>'By activity','action'=>"?budget_scenario={$budget_scenario}&type=activity");
	$arrActions[] = Array ('title'=>'By GHQ type','action'=>"?budget_scenario={$budget_scenario}&type=ghq");
	$arrActions[] = Array ('title'=>'By BDV staff','action'=>"?type=sales");	
	$arrActions[] = Array ('title'=>'By PC','action'=>"?type=pc");	
	
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,$strVsTitle,'</h1>';
	echo '<p>',$oBudget->timestamp,'; ',$oBudget->rates,'</p>';
	?>
	<div class='f-row'><label for='budget_scenario'>Select scenario</label><?php echo $oBudget->getScenarioSelect(Array('type'=>'FYE'));?></div>
	<?php
	$oBudget->getProfitTabs('reg_master', true);
	include ('includes/inc-frame_bottom.php');
} else {
	
	//include ('includes/inc_report_buttons.php');
	
	if(isset($_GET['currency'])){
		$sql = "SELECT * FROM vw_currency WHERE curID={$currency} LIMIT 1";
		$rs = $oSQL->q($sql);
		$rw = $oSQL->f($rs);
		echo '<h2>',$rw["curTitle$strLocal"],'</h2>';
	}
	
	if ($_GET['pccGUID']=='all'){
		$strRoles = "'".implode("','",$arrUsrData['roleIDs'])."'";
		$sqlWhere = "WHERE pc in (SELECT pcrProfitID FROM stbl_profit_role WHERE pcrRoleID IN ($strRoles) AND pcrFlagRead=1)";
	} else {
		$sqlWhere = "WHERE pc in (SELECT pccID FROM vw_profit WHERE pccGUID=".$oSQL->e($_GET['pccGUID']).")";
	}
	
	switch ($type){
		case 'activity':		
			$oReport->monthlyReport($sqlWhere, 'activity');	
			break;
		case 'pc':		
			$oReport->monthlyReport($sqlWhere, 'pc');	
			break;
		case 'ghq':
			echo "<input type='hidden' id='group' value='activity'/>";
			$oReport->monthlyReport($sqlWhere,'ghq');	
		break;
		// case 'f865e855-d328-102e-9d25-5de97ba9df63':
			// $sqlWhere = "WHERE (pc in (SELECT pccID FROM vw_profit WHERE pccGUID=".$oSQL->e($_GET['pccGUID']).") OR (customer=9907 AND Group_code=94))";
		case 'customer':
		default:
			echo "<input type='hidden' id='group' value='customer'/>";
			$oReport->monthlyReport($sqlWhere,'customer');
			break;
	}

}


?>