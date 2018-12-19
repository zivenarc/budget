<?php
// $flagNoAuth = true;
// $arrUsrData['usrID'] = 'ZHAROVA';

require ('common/auth.php');


$ownerID = isset($_GET['ownerID'])?$_GET['ownerID']:($_COOKIE['ownerID']?$_COOKIE['ownerID']:$arrUsrData['usrID']);
if ($_GET['ownerID']=='MYSELF'){
	$ownerID = $arrUsrData['usrID'];
}
SetCookie('ownerID',$ownerID,0);

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
	
	if(strpos($oBudget->type,'Budget')!==false){
		$period_type = 'fye';
	} else {
		$period_type = 'cm';
	}

	$sqlActual = "SUM(".$oBudget->getThisYTDSQL($period_type,$arrActualRates).")";
	$sqlBudget = "SUM(".$oBudget->getThisYTDSQL($period_type,$arrBudgetRates).")";
	
	$settings['gpcus'] = Array('title'=>"GP by customer sold by ".($rw['usrTitle']?$rw['usrTitle']:'<Unknown>'),
						'actual_title'=>$oBudget->title,
						'budget_title'=>$oReference->title,
						'sqlBase' => "SELECT customer_group_code as optValue, 
												customer_group_title as optText,  
											{$sqlActual} as Actual, 
											0 as Budget, 
											{$sqlActual} as Diff
									FROM vw_master 
									WHERE sales='{$ownerID}'
										AND scenario='{$oBudget->id}'  
										AND company='{$company}'
										".Reports::GP_FILTER."										
									GROUP BY customer_group_code
									UNION ALL
									SELECT customer_group_code as optValue, 
												customer_group_title as optText,  
												0 as Actual, 
									{$sqlBudget}  as Budget, -{$sqlBudget} as Diff
									FROM vw_master 
									WHERE sales='{$ownerID}'
										AND scenario='{$oReference->id}'  
										AND company='{$company}'
										AND source<>'Estimate' 
										".Reports::GP_FILTER."										
									GROUP BY customer_group_code",
							'tolerance'=>0.05,
							'denominator'=>$denominator,
							'limit'=>10);	

	$oWF = new Waterfall($settings['gpcus']);

	$oWF->draw();
	
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

	if (strpos($oBudget->type,'FYE')!== false){
	// if (false){
		$oReport->monthlyReport($type);	
	} elseif (strpos($oBudget->type,'Budget')!== false) {
		$oReport->quarterly($type);
	} else {
		include ('includes/inc_report_buttons.php');
		$oReport->periodicPnL($type);

		?>
		<h2>KPI</h2>
		<?php
		$oReport->salesByCustomer(' and sales='.$oSQL->e($ownerID));
	}
	
}
?>