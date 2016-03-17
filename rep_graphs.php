<?php
// $flagNoAuth = true;
require ('common/auth.php');
require ('classes/budget.class.php');

include ('includes/inc_report_settings.php');

if ($bu_group){
	$sql = "SELECT * FROM common_db.tbl_profit WHERE pccParentCode1C='{$bu_group}'";
	$rs = $oSQL->q($sql);
	while ($rw = $oSQL->f($rs)){
		$arrBus[] = $rw['pccID']; 
	}
}

if(!isset($_GET['pccGUID'])){
	$oBudget = new Budget($budget_scenario);
	if ($reference!=$oBudget->reference_scenario->id){
		$oReference = new Budget($reference);
		$strVsTitle = ' vs '.$oReference->title;
	} else {
		$reference = $oBudget->reference_scenario->id;
	}
	
	$arrJS[] = 'https://www.google.com/jsapi';
	$arrJS[]='js/rep_pnl.js';
	// $arrJS[]='js/input_form.js';	
	
	// $arrActions[] = Array ('title'=>'By customer group','action'=>"?type=customer_group");
	// $arrActions[] = Array ('title'=>'By customer','action'=>"?type=customer");
	// $arrActions[] = Array ('title'=>'By activity','action'=>"?type=activity");
	// $arrActions[] = Array ('title'=>'By GHQ type','action'=>"?type=ghq");
	// $arrActions[] = Array ('title'=>'By BDV staff','action'=>"?type=sales");
	// $arrActions[] = Array ('title'=>'By PC','action'=>"?type=pc");
		
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,$strVsTitle,'</h1>';
	include ('includes/inc_report_selectors.php');
	echo '<p>',$oBudget->timestamp,'; ',$oBudget->rates,'</p>';
	
	Budget::getProfitTabs('reg_master', !$flagNoAuth, Array('pccID'=>$arrBus));
	
	include ('includes/inc-frame_bottom.php');
} else {
	require ('classes/reports.class.php');
	include ('includes/inc_report_buttons.php');
	
	if ($_GET['pccGUID']=='all'){
		
		
		
		if (!$flagNoAuth) { 
			$strRoles = "'".implode("','",$arrUsrData['roleIDs'])."'";
			$sqlPCFilter[] = "pcrRoleID IN ({$strRoles}) AND pcrFlagRead=1"; 
			$sqlRoleFilter[] = "pcrRoleID IN ({$strRoles}) AND pcrFlagRead=1"; 
		};
		
		if ($bu_group){
			$strBUs = implode(',',$arrBus);
			$sqlPCFilter[] = "pcrProfitID IN ({$strBUs})";
			$sql = "SELECT DISTINCT pcrProfitID FROM stbl_profit_role WHERE ".implode(" AND ",$sqlPCFilter);
		} else {		
			$sql = "SELECT DISTINCT pcrProfitID FROM stbl_profit_role WHERE ".implode(" AND ",$sqlRoleFilter);
		}
		$rs = $oSQL->q($sql);
		while ($rw = $oSQL->f($rs)){
			$arrPC[] = $rw['pcrProfitID'];
		}
		$sqlWhere = "WHERE pc in (".implode(',',$arrPC).")";
	} else {
		$sqlWhere = "WHERE pc in (SELECT pccID FROM vw_profit WHERE pccGUID=".$oSQL->e($_GET['pccGUID']).")";
	}
	
	
	// $sqlWhere .= " AND scenario='$budget_scenario'";
	$oReport = new Reports(Array('budget_scenario'=>$budget_scenario, 'currency'=>$currency, 'denominator'=>$denominator,'reference'=>$reference));
	
	$oReport->periodicGraph($sqlWhere);
	
	

}


?>