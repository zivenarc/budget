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

include ('includes/inc_report_pcfilter.php');

$arrJS[]='js/rep_pnl.js';
// $arrJS[]='js/input_form.js';	

include('includes/inc_group_buttons.php');

$sql = "SELECT * FROM stbl_user WHERE usrID=".$oSQL->e($ownerID);
$rs = $oSQL->q($sql);
$rw = $oSQL->f($rs);
$arrUsrData["pagTitle$strLocal"] = 'Sales by '.($rw['usrTitle']?$rw['usrTitle']:'<Unknown>');
	
	
if(!isset($_GET['pccGUID'])){
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,'</h1>';
	echo '<p>',$oBudget->timestamp,'; ',$oBudget->rates,'</p>';
	?>
	<div id='warnings'>
	<?php
		$sql = "SELECT DISTINCT salID FROM `tbl_sales`, `reg_sales`
					WHERE unit IN ('TEU','Kgs')
					AND source=salGUID
					AND kpi=1 AND hbl=1 and salFlagDeleted=0
					AND salScenario='{$budget_scenario}'
					AND salUserID='{$ownerID}'
					AND salDA=salJO";
		$rs = $oSQL->q($sql);
		if($oSQL->n($rs)){
			while ($rw = $oSQL->f($rs)){
				$arrErrDocs[] = "<a target='_sales' href='sales_form.php?salID={$rw['salID']}'>{$rw['salID']}</a>";
			}
			?>
			<div class='error'>Job owner and Destination agent are the same, Profit share may be calculated incorrectly: <?php echo implode(', ',$arrErrDocs);?></div>
			<?php
		}
		
	?>
	</div>
	<?php
	include ('includes/inc_report_selectors.php');
	
	Budget::getProfitTabs('reg_sales', false, Array('sales'=>$ownerID));
	
	include ('includes/inc_subordinates.php');

	include ('includes/inc-frame_bottom.php');
} else {
	
	include ('includes/inc_report_buttons.php');
	
	// $sqlWhere = "WHERE sales = ".$oSQL->e($ownerID);
	// if ($_GET['pccGUID']=='all'){

	// } else {
		// $sqlWhere .= " AND pc in (SELECT pccID FROM vw_profit WHERE pccGUID=".$oSQL->e($_GET['pccGUID']).")";
	// }
	
	$filter['sales'] = $ownerID;
	
	$oReport = new Reports(Array('budget_scenario'=>$budget_scenario, 'reference'=>$reference,'currency'=>$currency, 'denominator'=>$denominator, 'filter'=>$filter));

	if (strpos($oBudget->type,'FYE')!==false){
		$oReport->monthlyReport($type);
	} else {
		$oReport->periodicPnL($type);

		?>
		<h2>KPI</h2>
		<?php
		$oReport->salesByCustomer(' and sales='.$oSQL->e($ownerID));
	}
	
}
?>