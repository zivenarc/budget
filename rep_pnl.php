<?php
require ('common/auth.php');
require ('classes/budget.class.php');

$budget_scenario = isset($_GET['budget_scenario'])?$_GET['budget_scenario']:$budget_scenario;
$currency = isset($_GET['currency'])?$_GET['currency']:643;

if(!isset($_GET['tab'])){
	$oBudget = new Budget($budget_scenario);
	$arrJS[]='js/rep_pnl.js';
	// $arrJS[]='js/input_form.js';	
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,'</h1>';
	?>
	<div class='f-row'><label for='budget_scenario'>Select scenario</label><?php echo Budget::getScenarioSelect();?></div>
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
	echo '<p>',$oBudget->timestamp,'; ',$oBudget->rates,'</p>';
	
	if ($_GET['tab']=='all'){
		$strRoles = "'".implode("','",$arrUsrData['roleIDs'])."'";
		$sqlWhere = "WHERE pc in (SELECT pcrProfitID FROM stbl_profit_role WHERE pcrRoleID IN ($strRoles) AND pcrFlagRead=1)";
	} else {
		$sqlWhere = "WHERE pc in (SELECT pccID FROM vw_profit WHERE pccGUID=".$oSQL->e($_GET['tab']).")";
	}
	switch ($_GET['tab']){
		case 'f865db6b-d328-102e-9d25-5de97ba9df63':
		case 'f865e1de-d328-102e-9d25-5de97ba9df63':
		case '48b5ae6c-e650-11de-959c-00188bc729d2':
			Reports::masterByActivityEst($sqlWhere." AND scenario='$budget_scenario'",$currency);	
			break;
		case 'all':
			echo "<input type='hidden' id='group' value='activity'/>";
			Reports::masterByGHQEst($sqlWhere." AND scenario='$budget_scenario'",$currency);	
		break;
		case 'f865e855-d328-102e-9d25-5de97ba9df63':
			$sqlWhere = "WHERE (pc in (SELECT pccID FROM vw_profit WHERE pccGUID=".$oSQL->e($_GET['tab']).") OR (customer=9907 AND Group_code=94))";
		default:
			echo "<input type='hidden' id='group' value='customer'/>";
			Reports::masterByCustomerEst($sqlWhere." AND scenario='$budget_scenario'",$currency);
			break;
	}
	?>
		<ul class='link-footer'>
			<li><a href='javascript:SelectContent("report_<?php echo $_GET['tab'];?>");'>Select table</a></li>
		</ul>
	<?php
}


?>