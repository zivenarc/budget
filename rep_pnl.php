<?php
require ('common/auth.php');
require ('classes/budget.class.php');

include ('includes/inc_report_settings.php');

if(!isset($_GET['pccGUID'])){
	$oBudget = new Budget($budget_scenario);
	$arrJS[]='js/rep_pnl.js';
	// $arrJS[]='js/input_form.js';	
	
	$arrActions[] = Array ('title'=>'By customer','action'=>"?type=customer");
	$arrActions[] = Array ('title'=>'By activity','action'=>"?type=activity");
	$arrActions[] = Array ('title'=>'By GHQ type','action'=>"?type=ghq");
	$arrActions[] = Array ('title'=>'By BDV staff','action'=>"?type=sales");
	$arrActions[] = Array ('title'=>'By PC','action'=>"?type=pc");
		
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,'</h1>';
	echo '<p>',$oBudget->timestamp,'; ',$oBudget->rates,'</p>';
	?>
	<div class='f-row'><label for='budget_scenario'>Select scenario</label><?php echo Budget::getScenarioSelect();?></div>
	<?php
	Budget::getProfitTabs('reg_master', true);
	include ('includes/inc-frame_bottom.php');
} else {
	require ('classes/reports.class.php');
	include ('includes/inc_report_buttons.php');
	
	if(isset($currency)){
		$sql = "SELECT * FROM vw_currency WHERE curID={$currency} LIMIT 1";
		$rs = $oSQL->q($sql);
		$rw = $oSQL->f($rs);
		echo '<h2>',$rw["curTitle$strLocal"],'</h2>';
	}
	
	if ($_GET['pccGUID']=='all'){
		$strRoles = "'".implode("','",$arrUsrData['roleIDs'])."'";
		$sql = "SELECT DISTINCT pcrProfitID FROM stbl_profit_role WHERE pcrRoleID IN ($strRoles) AND pcrFlagRead=1";
		$rs = $oSQL->q($sql);
		while ($rw = $oSQL->f($rs)){
			$arrPC[] = $rw['pcrProfitID'];
		}
		$sqlWhere = "WHERE pc in (".implode(',',$arrPC).")";
	} else {
		$sqlWhere = "WHERE pc in (SELECT pccID FROM vw_profit WHERE pccGUID=".$oSQL->e($_GET['pccGUID']).")";
	}
	
	if ($_GET['nowh']){
		$sqlWhere .= " AND pc NOT in (5,15)";
	}
	
	
	// $sqlWhere .= " AND scenario='$budget_scenario'";
	$oReport = new Reports(Array('budget_scenario'=>$budget_scenario, 'currency'=>$currency, 'denominator'=>$denominator));
	
	switch ($type){
		case 'activity':		
			$oReport->periodicPnL($sqlWhere,Array('field_data'=>'activity','field_title'=>'Activity_title','title'=>'Activity'));	
			break;
		case 'ghq':
			$oReport->periodicPnL($sqlWhere,Array('field_data'=>'prtGHQ','field_title'=>'prtGHQ','title'=>'GHQ'));	
			break;
		case 'sales':			
			$oReport->periodicPnL($sqlWhere,Array('field_data'=>'sales','field_title'=>'usrTitle','title'=>'Responsible'));	
			break;
		case 'pc':			
			$oReport->periodicPnL($sqlWhere,Array('field_data'=>'pc','field_title'=>'Profit','title'=>'PC'));	
			break;
		case 'customer':
		default:			
			$oReport->periodicPnL($sqlWhere,Array('field_data'=>'CASE WHEN Customer_group_code=723 THEN customer ELSE Customer_group_code END','field_title'=>'CASE WHEN Customer_group_code=723 THEN Customer_name ELSE Customer_group_title END','title'=>'Customer'));
			break;
	}

}


?>