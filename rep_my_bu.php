<?php
require ('common/auth.php');
require_once ('classes/budget.class.php');
require_once ('classes/reports.class.php');
require_once ('classes/waterfall.class.php');

$bdv = isset($_GET['bdv'])?$_GET['bdv']:($_COOKIE['bdv']?$_COOKIE['bdv']:$arrUsrData['usrProfitID']);
if ($_GET['bdv']=='MYSELF'){
	$bdv = $arrUsrData['usrProfitID'];
}
SetCookie('bdv',$bdv,0);
$sqlWhere = "WHERE bdv = ".$oSQL->e($bdv);

include ('includes/inc_report_settings.php');

$oBudget = new Budget($budget_scenario);
$oReference = new Budget($reference);

include ('includes/inc_report_pcfilter.php');

$arrJS[]='js/rep_pnl.js';
// $arrJS[]='js/input_form.js';	

include('includes/inc_group_buttons.php');

$sql = "SELECT * FROM common_db.tbl_profit WHERE pccID=".$oSQL->e($bdv);
$rs = $oSQL->q($sql);
$arrBDV = $oSQL->f($rs);
$arrUsrData["pagTitle$strLocal"] = 'Sales by '.($arrBDV['pccTitle']?$arrBDV['pccTitle']:'<Unknown>');

$arrDefaultParams = Array('currency'=>643,'period_type'=>'cm','denominator'=>1000,'bu_group'=>'');
$strQuery = http_build_query($arrDefaultParams);

$arrActions[] = Array('title'=>'NSD','action'=>'?bdv=9&type=bu_group&'.$strQuery);
$arrActions[] = Array('title'=>'JSD','action'=>'?bdv=130&type=bu_group&'.$strQuery);
	
if(!isset($_GET['pccGUID'])){
	
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,'</h1>';

	echo '<p>',$oBudget->timestamp,'; ',$oBudget->rates,'</p>';
	include ('includes/inc_report_selectors.php');

	Budget::getProfitTabs('reg_sales', false, Array('bdv'=>$bdv));

	$sql = "SELECT pccID, pccTitle FROM common_db.tbl_profit WHERE pccFlagFolder=0 ORDER BY pccTitle";
	$rs = $oSQL->q($sql);
		
	?>
	<ul class='link-footer'>		
		<?php
		while ($rw = $oSQL->f($rs)){
			?><li><a href="?bdv=<?php echo $rw['pccID'];?>"><?php echo $rw['pccTitle'];?></a><?php
		}		
		?>
	</ul>
	
	<div id='waterfall'>
	<?php
	$period_type = 'cm';

	$sqlActual = "SUM(".$oBudget->getThisYTDSQL($period_type,$arrActualRates).")";
	$sqlBudget = "SUM(".$oBudget->getThisYTDSQL($period_type,$arrBudgetRates).")";
	
	$settings['gpcus'] = Array('title'=>"GP by customer sold by {$arrBDV['pccTitle']}, current month",
						'actual_title'=>$oBudget->title,
						'budget_title'=>$oReference->title,
						'sqlBase' => "SELECT customer_group_code as optValue, 
												customer_group_title as optText,  
											{$sqlActual} as Actual, 
											0 as Budget, 
											{$sqlActual} as Diff
									FROM vw_master 
									{$sqlWhere}
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
									{$sqlWhere} 
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
	?>
	</div>
	
	<?php
	include ('includes/inc-frame_bottom.php');

} else {

	if ($_GET['pccGUID']=='all'){
		
	} else {
		$sqlWhere .= " AND pc in (SELECT pccID FROM vw_profit WHERE pccGUID=".$oSQL->e($_GET['pccGUID']).")";
	}
	
	$filter['bdv'] = $bdv;
	
	$oReport = new Reports(Array('budget_scenario'=>$budget_scenario, 'reference'=>$reference,'currency'=>$currency, 'denominator'=>$denominator, 'filter'=>$filter, 'yact'=>false));
	
	if (strpos($oBudget->type,'Budget')===false){
		$oReport->monthlyReport($type);
	} else {
		$oReport->periodicPnL($type);

		?>
		<h2>KPI</h2>
		<?php
		$oReport->salesByCustomer(' and bdv='.$oSQL->e($bdv));
	}
}
?>