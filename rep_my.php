<?php
// $flagNoAuth = true;
// $arrUsrData['usrID'] = 'ZHAROVA';

require ('common/auth.php');


$ownerID = isset($_GET['ownerID'])?$_GET['ownerID']:($_COOKIE['ownerID']?$_COOKIE['ownerID']:$arrUsrData['usrID']);
if ($_GET['ownerID']=='MYSELF'){
	$ownerID = $arrUsrData['usrID'];
}
SetCookie('ownerID',$ownerID,0);

require ('classes/budget.class.php');
require ('classes/reports.class.php');
include ('includes/inc_report_settings.php');

$oBudget = new Budget($budget_scenario);
$arrJS[]='js/rep_pnl.js';
// $arrJS[]='js/input_form.js';	

$arrActions[] = Array ('title'=>'By customer','action'=>"?type=customer");
$arrActions[] = Array ('title'=>'By activity','action'=>"?type=activity");
$arrActions[] = Array ('title'=>'By GHQ type','action'=>"?type=ghq");

if(isset($currency)){
		$sql = "SELECT * FROM vw_currency WHERE curID={$currency} LIMIT 1";
		$rs = $oSQL->q($sql);
		$rw = $oSQL->f($rs);
		echo '<h2>',$rw["curTitle$strLocal"],'</h2>';
}

$sql = "SELECT * FROM stbl_user WHERE usrID=".$oSQL->e($ownerID);
$rs = $oSQL->q($sql);
$rw = $oSQL->f($rs);
$arrUsrData["pagTitle$strLocal"] = 'Sales by '.($rw['usrTitle']?$rw['usrTitle']:'<Unknown>');
	
include ('includes/inc-frame_top.php');
echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,'</h1>';
echo '<p>',$oBudget->timestamp,'; ',$oBudget->rates,'</p>';
// include ('includes/inc_report_buttons.php');
?>
<div class='f-row'><label for='budget_scenario'>Select scenario</label><?php echo Budget::getScenarioSelect();?></div>
<?php
$sqlWhere .= "WHERE scenario='$budget_scenario' AND sales = ".$oSQL->e($ownerID);
$oReport = new Reports(Array('budget_scenario'=>$budget_scenario, 'currency'=>$currency, 'denominator'=>$denominator));
	
switch ($type){
	case 'activity':		
		$oReport->periodicPnL($sqlWhere,Array('field_data'=>'activity','field_title'=>'Activity_title','title'=>'Activity'));	
		break;
	case 'ghq':
		$oReport->periodicPnL($sqlWhere,Array('field_data'=>'prtGHQ','field_title'=>'prtGHQ','title'=>'GHQ'));	
		break;		
	case 'customer':
	default:			
		$oReport->periodicPnL($sqlWhere,Array('field_data'=>'customer','field_title'=>'Customer_name','title'=>'Customer'));
		break;
}
?>
<h2>KPI</h2>
<?php
$oReport->salesByCustomer(' and sales='.$oSQL->e($ownerID));

include ('includes/inc-frame_bottom.php');
?>