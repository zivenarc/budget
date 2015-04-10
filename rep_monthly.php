<?php
require ('common/auth.php');
require ('classes/budget.class.php');

$budget_scenario = isset($_GET['budget_scenario'])?$_GET['budget_scenario']:$budget_scenario;
$currency = isset($_GET['currency'])?$_GET['currency']:643;

//------------------------------------- type of report details -------------------------------------------//
if (isset($_GET['type'])){
	$type = $_GET['type'];
	SetCookie('pnl_type',$type,0,'/budget/');
} elseif (isset($_COOKIE['pnl_type'])) {
	$type = $_COOKIE['pnl_type'];
} else {
	switch ($_GET['tab']){
		case 'f865db6b-d328-102e-9d25-5de97ba9df63':
		case 'f865e1de-d328-102e-9d25-5de97ba9df63':
		case '48b5ae6c-e650-11de-959c-00188bc729d2':
			$type = 'activity';			
			break;
		case 'all':
			$type = 'ghq';			
		break;
		case 'f865e855-d328-102e-9d25-5de97ba9df63':
			$type = 'customer';
			//$sqlWhere = "WHERE (pc in (SELECT pccID FROM vw_profit WHERE pccGUID=".$oSQL->e($_GET['tab']).") OR (customer=9907 AND Group_code=94))";
		default:
			$type = 'customer';			
			break;
	}
}

if(!isset($_GET['tab'])){
	$oBudget = new Budget($budget_scenario);
	$arrJS[]='js/rep_pnl.js';
	// $arrJS[]='js/input_form.js';	
	
	$arrActions[] = Array ('title'=>'By customer','action'=>"?budget_scenario={$budget_scenario}&type=customer");
	$arrActions[] = Array ('title'=>'By activity','action'=>"?budget_scenario={$budget_scenario}&type=activity");
	$arrActions[] = Array ('title'=>'By GHQ type','action'=>"?budget_scenario={$budget_scenario}&type=ghq");
		
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,'</h1>';
	echo '<p>',$oBudget->timestamp,'; ',$oBudget->rates,'</p>';
	?>
	<div class='f-row'><label for='budget_scenario'>Select scenario</label><?php echo Budget::getScenarioSelect(Array('type'=>'FYE'));?></div>
	<?php
	Budget::getProfitTabs('reg_master', true);
	include ('includes/inc-frame_bottom.php');
} else {
	require ('classes/reports.class.php');
	include ('includes/inc_report_buttons.php');
	
	if(isset($_GET['currency'])){
		$sql = "SELECT * FROM vw_currency WHERE curID={$currency} LIMIT 1";
		$rs = $oSQL->q($sql);
		$rw = $oSQL->f($rs);
		echo '<h2>',$rw["curTitle$strLocal"],'</h2>';
	}
	
	if ($_GET['tab']=='all'){
		$strRoles = "'".implode("','",$arrUsrData['roleIDs'])."'";
		$sqlWhere = "WHERE pc in (SELECT pcrProfitID FROM stbl_profit_role WHERE pcrRoleID IN ($strRoles) AND pcrFlagRead=1)";
	} else {
		$sqlWhere = "WHERE pc in (SELECT pccID FROM vw_profit WHERE pccGUID=".$oSQL->e($_GET['tab']).")";
	}
	switch ($type){
		case 'activity':		
			Reports::monthlyByActivityEst($sqlWhere." AND scenario='$budget_scenario'",$currency);	
			break;
		case 'ghq':
			echo "<input type='hidden' id='group' value='activity'/>";
			Reports::monthlyByGHQEst($sqlWhere." AND scenario='$budget_scenario'",$currency);	
		break;
		// case 'f865e855-d328-102e-9d25-5de97ba9df63':
			// $sqlWhere = "WHERE (pc in (SELECT pccID FROM vw_profit WHERE pccGUID=".$oSQL->e($_GET['tab']).") OR (customer=9907 AND Group_code=94))";
		case 'customer':
		default:
			echo "<input type='hidden' id='group' value='customer'/>";
			Reports::monthlyByCustomerEst($sqlWhere." AND scenario='$budget_scenario'",$currency);
			break;
	}

}


?>