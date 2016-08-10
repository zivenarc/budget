<?php
$flagNoAuth = true;
// $arrUsrData['usrID'] = 'ZHAROVA';

require ('common/auth.php');


$bdv = isset($_GET['bdv'])?$_GET['bdv']:($_COOKIE['bdv']?$_COOKIE['bdv']:$arrUsrData['usrID']);
if ($_GET['bdv']=='MYSELF'){
	$bdv = $arrUsrData['usrProfitID'];
}
SetCookie('bdv',$bdv,0);

require ('classes/budget.class.php');
require ('classes/reports.class.php');
include ('includes/inc_report_settings.php');

$oBudget = new Budget($budget_scenario);
$arrJS[]='js/rep_pnl.js';
// $arrJS[]='js/input_form.js';	

include('includes/inc_group_buttons.php');

if(isset($currency)){
		$sql = "SELECT * FROM vw_currency WHERE curID={$currency} LIMIT 1";
		$rs = $oSQL->q($sql);
		$rw = $oSQL->f($rs);
		echo '<h2>',$rw["curTitle$strLocal"],'</h2>';
}

$sql = "SELECT * FROM common_db.tbl_profit WHERE pccID=".$oSQL->e($bdv);
$rs = $oSQL->q($sql);
$rw = $oSQL->f($rs);
$arrUsrData["pagTitle$strLocal"] = 'Sales by '.($rw['pccTitle']?$rw['pccTitle']:'<Unknown>');
	
include ('includes/inc-frame_top.php');
echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,'</h1>';
echo '<p>',$oBudget->timestamp,'; ',$oBudget->rates,'</p>';
// include ('includes/inc_report_buttons.php');
?>
<div class='f-row'><label for='budget_scenario'>Select scenario</label><?php echo Budget::getScenarioSelect();?></div>
<?php
$sqlWhere .= "WHERE bdv = ".$oSQL->e($bdv);


$oReport = new Reports(Array('budget_scenario'=>$budget_scenario, 'currency'=>$currency, 'denominator'=>$denominator, 'filter'=>Array('bdv'=>$bdv)));

if (strpos($oBudget->type,'FYE')!==false){
	$oReport->monthlyReport($type);
} else {
	switch ($type){
		case 'activity':		
			$oReport->periodicPnL($sqlWhere,Array('field_data'=>'activity','field_title'=>'Activity_title','title'=>'Activity'));	
			break;
		case 'ghq':
			$oReport->periodicPnL($sqlWhere,Array('field_data'=>'prtGHQ','field_title'=>'prtGHQ','title'=>'GHQ'));	
			break;		
		case 'pc':
			$oReport->periodicPnL($sqlWhere,Array('field_data'=>'pc','field_title'=>'Profit','title'=>'PC'));	
			break;	
		case 'customer':
		default:			
			$oReport->periodicPnL($sqlWhere,Array('field_data'=>'customer','field_title'=>'Customer_name','title'=>'Customer'));
			break;
	}

	?>
	<h2>KPI</h2>
	<?php
	$oReport->salesByCustomer(' and bdv='.$oSQL->e($bdv));
}

include ('includes/inc-frame_bottom.php');
?>