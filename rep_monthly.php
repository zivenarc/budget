<?php
require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/reports.class.php');
include ('includes/inc_report_settings.php');

if ($bu_group){
	$sql = "SELECT * FROM common_db.tbl_profit WHERE pccParentCode1C='{$bu_group}'";
	$rs = $oSQL->q($sql);
	while ($rw = $oSQL->f($rs)){
		$arrBus[] = $rw['pccID']; 
	}
}

$oReport = new Reports(Array('budget_scenario'=>$budget_scenario, 'currency'=>$currency, 'denominator'=>$denominator, 'reference'=>$reference));

$oBudget = new Budget($budget_scenario);
if ($reference!=$oBudget->reference_scenario->id){
	$oReference = new Budget($reference);
	$strVsTitle = ' vs '.$oReference->title;
} else {
	$reference = $oBudget->reference_scenario->id;
}
if(!isset($_GET['pccGUID'])){
	
	$arrJS[]='js/rep_pnl.js';
	// $arrJS[]='js/input_form.js';	
	
	$arrActions[] = Array ('title'=>'By customer group','action'=>"?type=customer_group");
	$arrActions[] = Array ('title'=>'By customer','action'=>"?type=customer");
	$arrActions[] = Array ('title'=>'By activity','action'=>"?type=activity");
	$arrActions[] = Array ('title'=>'By GHQ type','action'=>"?type=ghq");
	$arrActions[] = Array ('title'=>'By BDV staff','action'=>"?type=sales");	
	$arrActions[] = Array ('title'=>'By PC','action'=>"?type=pc");	
	$arrActions[] = Array ('title'=>'By BDV dept','action'=>"?type=bdv");	
	
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,$strVsTitle,'</h1>';
	include ('includes/inc_report_selectors.php');
	echo '<p>',$oBudget->timestamp,'; ',$oBudget->rates,'</p>';	
	
	$oBudget::getProfitTabs('reg_master', true, Array('pccID'=>$arrBus));
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
		
		if ($bu_group){
			$strBUs = implode(',',$arrBus);
			$sql = "SELECT DISTINCT pcrProfitID FROM stbl_profit_role WHERE pcrRoleID IN ($strRoles) AND pcrFlagRead=1 AND pcrProfitID IN ({$strBUs})";
		} else {		
			$sql = "SELECT DISTINCT pcrProfitID FROM stbl_profit_role WHERE pcrRoleID IN ($strRoles) AND pcrFlagRead=1";
		}
		$rs = $oSQL->q($sql);
		while ($rw = $oSQL->f($rs)){
			$arrPC[] = $rw['pcrProfitID'];
		}
		$sqlWhere = "WHERE pc in (".implode(',',$arrPC).")";
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
		case 'sales':		
			$oReport->monthlyReport($sqlWhere, 'sales');	
			break;
		case 'customer_group':		
			$oReport->monthlyReport($sqlWhere, 'customer_group');	
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