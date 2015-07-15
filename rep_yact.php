<?php
//$flagNoAuth = true;
require ('common/auth.php');
require ('classes/budget.class.php');

$budget_scenario = isset($_GET['budget_scenario'])?$_GET['budget_scenario']:$budget_scenario;


if(!isset($_GET['pccGUID'])){
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
	?>
	<input type='hidden' id='request_uri' value='<?php echo $_SERVER['REQUEST_URI'];?>'/>
	<input type='hidden' id='pccGUID' value='<?php echo $_GET['pccGUID'];?>'/>
	<div class="report-radio f-row">
	<div id='period_switch'>
		<input type='radio' id='period_monthly_<?php echo $_GET['pccGUID'];?>' name='period' value='monthly'/>
		<label for='period_monthly_<?php echo $_GET['pccGUID'];?>'>Monthly</label>
		<input type='radio' checked id='period_quarterly_<?php echo $_GET['pccGUID'];?>' name='period' value='quarterly'/>
		<label for='period_quarterly_<?php echo $_GET['pccGUID'];?>'>Quarterly</label>
	</div>
	<div id='detail_switch'>
		<input type='radio' id='detail_all_<?php echo $_GET['pccGUID'];?>' checked name='detail' value='all'/>
		<label for='detail_all_<?php echo $_GET['pccGUID'];?>'>Details</label>
		<input type='radio' id='detail_totals_<?php echo $_GET['pccGUID'];?>' name='detail' value='totals'/>
		<label for='detail_totals_<?php echo $_GET['pccGUID'];?>'>Totals</label>
	</div>
	</div>
	<?php
	if ($_GET['pccGUID']=='all'){
		$strRoles = "'".implode("','",$arrUsrData['roleIDs'])."'";
		$sqlWhere = "WHERE pc in (SELECT pcrProfitID FROM stbl_profit_role WHERE pcrRoleID IN ($strRoles))";
	} else {
		$sqlWhere = "WHERE pc in (SELECT pccID FROM vw_profit WHERE pccGUID=".$oSQL->e($_GET['pccGUID']).")";
	}
	// switch ($_GET['pccGUID']){
		// case 'f865db6b-d328-102e-9d25-5de97ba9df63':
		// case 'f865e1de-d328-102e-9d25-5de97ba9df63':
		// case 'all':
			echo "<input type='hidden' id='group' value='activity'/>";
			Reports::masterYactByActivityEst($sqlWhere." AND scenario='$budget_scenario'");	
		// break;
		// case 'f865e855-d328-102e-9d25-5de97ba9df63':
			// $sqlWhere = "WHERE (pc in (SELECT pccID FROM vw_profit WHERE pccGUID=".$oSQL->e($_GET['pccGUID']).") OR (customer=9907 AND Group_code=94))";
		// default:
			// echo "<input type='hidden' id='group' value='customer'/>";
			// Reports::masterYactByCustomerEst($sqlWhere." AND scenario='$budget_scenario'");
			// break;
	// }
	?>
		<ul class='link-footer'>
			<li><a href='javascript:SelectContent("report_<?php echo $_GET['pccGUID'];?>");'>Select table</a></li>
		</ul>
	<?php
}


?>