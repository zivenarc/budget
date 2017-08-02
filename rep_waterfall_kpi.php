<?php
$flagNoAuth = true;
// $_DEBUG = true;
include('common/auth.php');
require ('classes/budget.class.php');
require ('classes/reports.class.php');
require ('classes/waterfall.class.php');
include ('includes/inc_report_settings.php');
include ('includes/inc_report_pcfilter.php'); /// filter and tabs for Business unit

$oActual = new Budget($budget_scenario);
$oBudget = new Budget($reference);

$actual = $oActual->id;
$budget = $oBudget->id;

$limit = 8;
$denominator = 1;
$currency = 643;

$arrActualRates = $oActual->getMonthlyRates($currency);
$arrBudgetRates = $oBudget->getMonthlyRates($currency);


SetCookie('period_type',$period_type,0,'/budget/');

$arrPeriodType['ytd'] = 'YTD';
$arrPeriodType['cm'] = 'Current month';
$arrPeriodType['nm'] = 'Next month';
$arrPeriodType['q1'] = '1<sup>st</sup> quarter';
$arrPeriodType['q2'] = '2<sup>nd</sup> quarter';
$arrPeriodType['q3'] = '3<sup>rd</sup> quarter';
$arrPeriodType['q4'] = '4<sup>th</sup> quarter';
$arrPeriodType['q5'] = '5<sup>th</sup> quarter';
$arrPeriodType['roy'] = 'Rest-of-year';
$arrPeriodType['fye'] = 'FYE';
$arrPeriodType['am'] = 'Apr-Mar';
	
foreach($arrPeriodType as $id=>$title){
	$temp = $_GET;
	$temp['period_type'] = $id;
	$url = $_SERVER['PHP_SELF'].'?'.http_build_query($temp);
	$arrActions[] = Array ('title'=>$title,'action'=>$url);
}

$sqlBaseTable = 'vw_sales';

$sqlActual = "SUM(".$oActual->getThisYTDSQL($period_type,$arrActualRates).")";
$sqlBudget = "SUM(".$oActual->getThisYTDSQL($period_type,$arrBudgetRates).")";

					
						

			
$type = $_REQUEST['type']?$_REQUEST['type']:'teucus';
						
$settings = Array(
				'teucus'=>Array('title'=>"TEU by customer",'currency'=>'TEU','tolerance'=>isset($_REQUEST['tolerance'])?$_REQUEST['tolerance']:0.05,'limit'=>10),
				'kgcus'=>Array('title'=>"AFF volume by customer",'currency'=>'Kgs','tolerance'=>isset($_REQUEST['tolerance'])?$_REQUEST['tolerance']:0.05,'limit'=>10),
				'rffcus'=>Array('title'=>"RFF volume by customer",'currency'=>'Trips','tolerance'=>isset($_REQUEST['tolerance'])?$_REQUEST['tolerance']:0.05,'limit'=>10),
				'gpsal'=>Array('title'=>"GP by sales",'currency'=>'RUB','tolerance'=>isset($_REQUEST['tolerance'])?$_REQUEST['tolerance']:0.05,'limit'=>7, 'denominator'=>1000)				
			);

	$settings['teucus']['sqlBase'] = "SELECT customer_group_code as optValue, 
											customer_group_title as optText,
										{$sqlActual} as Actual, 
										0 as Budget, 
										{$sqlActual} as Diff
								FROM `{$sqlBaseTable}` 								
								WHERE scenario='{$actual}' AND company='{$company}' %WHERE% AND activity IN (48,63)
								GROUP BY customer_group_code
								UNION ALL
								SELECT customer_group_code as optValue, 
											customer_group_title as optText, 
											0 as Actual, 
								{$sqlBudget}  as Budget, -{$sqlBudget} as Diff
								FROM `{$sqlBaseTable}` 								
								WHERE
								scenario='{$budget}' AND source<>'Estimate' AND company='{$company}' %WHERE% AND activity IN (48,63)
								GROUP BY customer_group_code";

	$settings['kgcus']['sqlBase']="SELECT customer_group_code as optValue, 
											customer_group_title as optText,
										{$sqlActual} as Actual, 
										0 as Budget, 
										{$sqlActual} as Diff
								FROM `{$sqlBaseTable}` 								
								WHERE scenario='{$actual}' AND company='{$company}' %WHERE% AND activity IN (46,47)
								GROUP BY customer_group_code
								UNION ALL
								SELECT customer_group_code as optValue, 
											customer_group_title as optText, 
											0 as Actual, 
								{$sqlBudget}  as Budget, -{$sqlBudget} as Diff
								FROM `{$sqlBaseTable}` 								
								WHERE
								scenario='{$budget}' AND source<>'Estimate' AND company='{$company}' %WHERE% AND activity IN (46,47)
								GROUP BY customer_group_code";

	$settings['rffcus']['sqlBase']="SELECT customer_group_code as optValue, 
											customer_group_title as optText,
										{$sqlActual} as Actual, 
										0 as Budget, 
										{$sqlActual} as Diff
								FROM `{$sqlBaseTable}` 								
								WHERE scenario='{$actual}' AND company='{$company}' %WHERE% AND activity IN (69,3,7,13)
								GROUP BY customer_group_code
								UNION ALL
								SELECT customer_group_code as optValue, 
											customer_group_title as optText, 
											0 as Actual, 
								{$sqlBudget}  as Budget, -{$sqlBudget} as Diff
								FROM `{$sqlBaseTable}` 								
								WHERE
								scenario='{$budget}' AND source<>'Estimate' AND company='{$company}' %WHERE% AND activity IN (69,3,7,13)
								GROUP BY customer_group_code";
						
	$settings['gpsal']['sqlBase'] = "SELECT sales as optValue, 
										usrTitle as optText, 
										{$sqlActual} as Actual, 
										0 as Budget, 
										{$sqlActual} as Diff
								FROM `vw_master` 							
								WHERE scenario='{$actual}' ".Reports::GP_FILTER." %WHERE% AND company='{$company}'
								GROUP BY sales
								UNION ALL
								SELECT sales, usrTitle as optText, 0 as Actual, 
								{$sqlBudget}  as Budget, -{$sqlBudget} as Diff
								FROM `vw_master` 								
								WHERE
								scenario='{$budget}' AND source<>'Estimate' ".Reports::GP_FILTER." %WHERE% AND company='{$company}'
								GROUP BY sales";


			
if (isset($_REQUEST['pccGUID'])){
	
	if (is_array($settings[$type])){
		$settings[$type]['title'] .= ', '.$arrPeriodType[$period_type];
		$settings[$type]['actual_title'] = $oActual->title;
		$settings[$type]['budget_title'] = $oBudget->title;
		//$settings[$type]['denominator'] = $denominator;
		$settings[$type]['filter'] = $filter;
	
		$oWF = new Waterfall($settings[$type]);
	} else {
		die('Wrong report type');
	}
						
	if($_REQUEST['DataAction']=='reload'){
		header('Content-type: application/json');
		echo json_encode($oWF->getDataTable());
		die();
	}	
	
	?>
	<script>
		var requestOptions = {tabKey:'pccGUID',tabValue:'<?php echo $_REQUEST['pccGUID'];?>'};
	</script>
	<?php
	$oWF->draw();
	
} else {					
	$arrJS[] = 'js/rep_pnl.js';					
	require ('includes/inc-frame_top.php');

	// echo '<pre>';print_r($settings);echo '</pre>';

	?>
	<h1>KPI Waterfall<?php echo ': ',$oActual->title, ": ",$arrPeriodType[$period_type];?></h1>
	<?php
	include ('includes/inc_report_selectors.php');	

	Budget::getProfitTabs('reg_sales', false);	


	?>
	<script>
		$('#currency_selector').find('input').attr('disabled',true);
		$('#denominator_selector').find('input').attr('disabled',true);
	</script>
	<nav>
	<ul class='link-footer'>
	<?php
	foreach($settings as $type=>$data){
		$temp = $_GET;
		$temp['type'] = $type;
		$url = $_SERVER['PHP_SELF']."?".http_build_query($temp);
		echo '<li><a href="',$url,'">',$data['title'],'</a></li>';
	}
	?>
	</ul>
	</nav>
	<?php 
	if ($_DEBUG) echo '<pre>',$oWF->sqlBase,'</pre>';
	require ('includes/inc-frame_bottom.php');
}

function _getPeriodTitle($scenario){
	$prefix = strtoupper(substr($scenario->title,0,3));
	switch($prefix){
		case 'FYE':
			return('Forecast');
			break;
		case 'BUD':
			return('Budget');
			break;
		case 'ACT':
			return('Actual');
			break;		
	}
	
}

?>