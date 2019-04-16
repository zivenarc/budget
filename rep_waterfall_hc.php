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

include ('includes/inc_report_period.php');
	
foreach($arrPeriodType as $id=>$title){
	$temp = $_GET;
	$temp['period_type'] = $id;
	$url = $_SERVER['PHP_SELF'].'?'.http_build_query($temp);
	$arrActions[] = Array ('title'=>$title,'action'=>$url);
}

$sqlBaseTable = 'vw_headcount';

$sqlActual = "SUM(".$oActual->getThisYTDSQL($period_type,$arrActualRates,$oActual->cm-$oActual->offset).")";
$sqlBudget = "SUM(".$oActual->getThisYTDSQL($period_type,$arrBudgetRates,$oActual->cm-$oActual->offset).")";

					
						

			
$type = $_REQUEST['type']?$_REQUEST['type']:'hcbu';
						
$settings = Array(
				'hcbu'=>Array('title'=>"Headcount by BU",'currency'=>'FTE','tolerance'=>0.05,'limit'=>10),
				'hcfun'=>Array('title'=>"Headcount by function",'currency'=>'FTE','tolerance'=>0.05,'limit'=>10),
				'hcloc'=>Array('title'=>"Headcount by location",'currency'=>'FTE','tolerance'=>0.05,'limit'=>10)
			);

	$settings['hcbu']['sqlBase'] = "SELECT pc as optValue, 
											pccTitle as optText,
										{$sqlActual} as Actual, 
										0 as Budget, 
										{$sqlActual} as Diff
								FROM `{$sqlBaseTable}` 								
								WHERE scenario='{$actual}' AND company='{$company}' 
								GROUP BY pc
								UNION ALL
								SELECT pc as optValue, 
											pccTitle as optText, 
											0 as Actual, 
								{$sqlBudget}  as Budget, -{$sqlBudget} as Diff
								FROM `{$sqlBaseTable}` 								
								WHERE
								scenario='{$budget}' 
								AND company='{$company}'
								GROUP BY pc";

	$settings['hcfun']['sqlBase']="SELECT funRHQ as optValue, 
											funRHQ as optText,
										{$sqlActual} as Actual, 
										0 as Budget, 
										{$sqlActual} as Diff
								FROM `{$sqlBaseTable}` 								
								WHERE scenario='{$actual}' AND company='{$company}'
								GROUP BY funRHQ
								UNION ALL
								SELECT funRHQ as optValue, 
											funRHQ as optText, 
											0 as Actual, 
								{$sqlBudget}  as Budget, -{$sqlBudget} as Diff
								FROM `{$sqlBaseTable}` 								
								WHERE
								scenario='{$budget}' AND company='{$company}'
								GROUP BY funRHQ";

	$settings['hcloc']['sqlBase']="SELECT Location as optValue, 
											Location as optText,
										{$sqlActual} as Actual, 
										0 as Budget, 
										{$sqlActual} as Diff
								FROM `{$sqlBaseTable}` 								
								WHERE scenario='{$actual}' AND company='{$company}'
								GROUP BY Location
								UNION ALL
								SELECT Location as optValue, 
											Location as optText, 
											0 as Actual, 
								{$sqlBudget}  as Budget, -{$sqlBudget} as Diff
								FROM `{$sqlBaseTable}` 								
								WHERE
								scenario='{$budget}' AND company='{$company}'
								GROUP BY Location";
							


				
$arrJS[] = 'js/rep_pnl.js';					
require ('includes/inc-frame_top.php');

// echo '<pre>';print_r($settings);echo '</pre>';

?>
<h1>Headcount waterfall<?php echo ': ',$oActual->title, ": ",$arrPeriodType[$period_type];?></h1>
<?php
include ('includes/inc_report_selectors.php');	
?>
<script>
	$('#currency_selector').find('input').attr('disabled',true);
	$('#denominator_selector').find('input').attr('disabled',true);
</script>
<?php
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
?>
<div>
<?php
$oWF->draw();
?>
</div>
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