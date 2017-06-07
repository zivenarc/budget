<?php
$flagNoAuth = true;
// $_DEBUG = true;
include('common/auth.php');
require ('classes/budget.class.php');
require ('classes/reports.class.php');
require ('classes/waterfall.class.php');
include ('includes/inc_report_settings.php');

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

$settings['teucus'] = Array('title'=>"TEU by customer",
					'sqlBase' => "SELECT customer_group_code as optValue, 
											customer_group_title as optText,
										{$sqlActual} as Actual, 
										0 as Budget, 
										{$sqlActual} as Diff
								FROM `{$sqlBaseTable}` 								
								WHERE scenario='{$actual}' AND company='{$company}' AND activity IN (48,63)
								GROUP BY customer_group_code
								UNION ALL
								SELECT customer_group_code as optValue, 
											customer_group_title as optText, 
											0 as Actual, 
								{$sqlBudget}  as Budget, -{$sqlBudget} as Diff
								FROM `{$sqlBaseTable}` 								
								WHERE
								scenario='{$budget}' AND source<>'Estimate' AND company='{$company}' AND activity IN (48,63)
								GROUP BY customer_group_code",
						'currency'=>'TEU',
						'tolerance'=>0.05,
						'limit'=>10);

$settings['kgcus'] = Array('title'=>"AFF volume by customer",
					'sqlBase' => "SELECT customer_group_code as optValue, 
											customer_group_title as optText,
										{$sqlActual} as Actual, 
										0 as Budget, 
										{$sqlActual} as Diff
								FROM `{$sqlBaseTable}` 								
								WHERE scenario='{$actual}' AND company='{$company}' AND activity IN (46,47)
								GROUP BY customer_group_code
								UNION ALL
								SELECT customer_group_code as optValue, 
											customer_group_title as optText, 
											0 as Actual, 
								{$sqlBudget}  as Budget, -{$sqlBudget} as Diff
								FROM `{$sqlBaseTable}` 								
								WHERE
								scenario='{$budget}' AND source<>'Estimate' AND company='{$company}' AND activity IN (46,47)
								GROUP BY customer_group_code",
						'currency'=>'Kgs',
						'tolerance'=>0.05,
						'limit'=>10);						
						
$settings['gpsal'] = Array('title'=>"GP by sales",
					'sqlBase' => "SELECT sales as optValue, 
										usrTitle as optText, 
										{$sqlActual} as Actual, 
										0 as Budget, 
										{$sqlActual} as Diff
								FROM `{$sqlBaseTable}` 							
								WHERE scenario='{$actual}' ".Reports::GP_FILTER." AND company='{$company}'
								GROUP BY sales
								UNION ALL
								SELECT sales, usrTitle as optText, 0 as Actual, 
								{$sqlBudget}  as Budget, -{$sqlBudget} as Diff
								FROM `{$sqlBaseTable}` 								
								WHERE
								scenario='{$budget}' AND source<>'Estimate' ".Reports::GP_FILTER." AND company='{$company}'
								GROUP BY sales",
						'tolerance'=>0.05,
						'limit'=>10);						
						
$settings['gpcuswwh'] = Array('title'=>"GP by customer, FF",
					'sqlBase' => "SELECT IF(C.cntParentID<>723,C.cntParentID, C.cntID) as optValue, 
										IF(C.cntParentID<>723,(SELECT P.cntTitle FROM common_db.tbl_counterparty P WHERE P.cntID=C.cntParentID),cntTitle) as optText, 
										{$sqlActual} as Actual, 
										0 as Budget, 
										{$sqlActual} as Diff
								FROM `{$sqlBaseTable}` 
								LEFT JOIN common_db.tbl_counterparty C ON C.cntID=customer
								WHERE scenario='{$actual}' ".Reports::GP_FILTER." AND company='{$company}'
								AND pc NOT in (5,15)
								GROUP BY IF(C.cntParentID<>723,C.cntParentID, C.cntID)
								UNION ALL
								SELECT IF(C.cntParentID<>723,C.cntParentID,C.cntID), IF(C.cntParentID<>723,(SELECT P.cntTitle FROM common_db.tbl_counterparty P WHERE P.cntID=C.cntParentID),cntTitle) as optText, 0 as Actual, 
								{$sqlBudget}  as Budget, -{$sqlBudget} as Diff
								FROM `{$sqlBaseTable}` 
								LEFT JOIN common_db.tbl_counterparty C ON C.cntID=customer
								WHERE
								scenario='{$budget}' AND source<>'Estimate' ".Reports::GP_FILTER." AND company='{$company}'
								AND pc NOT in (5,15)
								GROUP BY IF(C.cntParentID<>723,C.cntParentID, C.cntID)",
						'tolerance'=>0.05,
						'limit'=>10);
						
$settings['gpbu'] = Array('title'=>"GP by business unit",
'sqlBase' => "SELECT pc as optValue, 
					Profit as optText, 
					{$sqlActual} as Actual, 
					0 as Budget, 
					{$sqlActual} as Diff
			FROM `{$sqlBaseTable}` 			
			WHERE scenario='{$actual}' ".Reports::GP_FILTER." AND company='{$company}'
			GROUP BY pc
			UNION ALL
			SELECT pc, Profit, 0 as Actual, {$sqlBudget}  as Budget, -{$sqlBudget} as Diff
			FROM `{$sqlBaseTable}` 			
			WHERE
			scenario='{$budget}' AND source<>'Estimate' ".Reports::GP_FILTER." AND company='{$company}'
			GROUP BY pc",
			'tolerance'=>0.001
			);

$settings['gopbu'] = Array('title'=>"GOP by business unit",
'sqlBase' => "SELECT pc as optValue, 
					Profit as optText, 
					{$sqlActual} as Actual, 
					0 as Budget, 
					{$sqlActual} as Diff
			FROM `{$sqlBaseTable}` 			
			WHERE scenario='{$actual}' ".Reports::GOP_FILTER." AND company='{$company}'
			GROUP BY pc
			UNION ALL
			SELECT pc, Profit, 0 as Actual, {$sqlBudget}  as Budget, -{$sqlBudget} as Diff
			FROM `{$sqlBaseTable}` 			
			WHERE
			scenario='{$budget}' AND source<>'Estimate' ".Reports::GOP_FILTER." AND company='{$company}'
			GROUP BY pc",
			'tolerance'=>0.001
			);
			
			
$settings['scbu'] = Array('title'=>"Staff cost by business unit",
'sqlBase' => "SELECT pc as optValue, 
					Profit as optText, 
					{$sqlActual} as Actual, 
					0 as Budget, 
					{$sqlActual} as Diff
			FROM `{$sqlBaseTable}` 			
			WHERE scenario='{$actual}' ".Reports::SC_FILTER." AND company='{$company}'
			GROUP BY pc
			UNION ALL
			SELECT pc, Profit, 0 as Actual, {$sqlBudget}  as Budget, -{$sqlBudget} as Diff
			FROM `{$sqlBaseTable}` 			
			WHERE
			scenario='{$budget}' AND source<>'Estimate' ".Reports::SC_FILTER." AND company='{$company}'
			GROUP BY pc",
			'tolerance'=>0.005
			);			
			
$settings['gpact'] = Array('title'=>"GP by activity",
'sqlBase' => "SELECT activity as optValue, 
					Activity_title as optText, 
					{$sqlActual} as Actual, 
					0 as Budget, 
					{$sqlActual} as Diff
			FROM `{$sqlBaseTable}` 			
			WHERE scenario='{$actual}' ".Reports::GP_FILTER." AND company='{$company}'
			GROUP BY activity
			UNION ALL
			SELECT activity, Activity_title, 0 as Actual, {$sqlBudget}  as Budget, -{$sqlBudget} as Diff
			FROM `{$sqlBaseTable}` 			
			WHERE
			scenario='{$budget}' AND source<>'Estimate' ".Reports::GP_FILTER." AND company='{$company}'
			GROUP BY activity",
			'tolerance'=>0.1
			);			
			
$settings['opbu'] = Array('title'=>"OP by business unit",
'sqlBase' => "SELECT pc as optValue, 
					Profit as optText, 
					{$sqlActual} as Actual, 
					0 as Budget, 
					{$sqlActual} as Diff
			FROM `{$sqlBaseTable}` 			
			WHERE scenario='{$actual}'  ".Reports::OP_FILTER." AND company='{$company}'
			GROUP BY pc
			UNION ALL
			SELECT pc, Profit, 0 as Actual, {$sqlBudget}  as Budget, -{$sqlBudget} as Diff
			FROM `{$sqlBaseTable}` 			
			WHERE
			scenario='{$budget}' AND source<>'Estimate' ".Reports::OP_FILTER." AND company='{$company}'
			GROUP BY pc",
			'tolerance'=>0.05
			);

			
			
$settings['pbt'] = Array('title'=>"PBT by factors",
'sqlBase' => "SELECT IF(`Group_code` IN (108,110,96),item,Group_code)  as optValue, 
					IF(`Group_code` IN (108,110,96),`Budget item`,`Group`) as optText, 
					{$sqlActual} as Actual, 
					0 as Budget, 
					{$sqlActual} as Diff
			FROM `{$sqlBaseTable}` 			
			WHERE scenario='{$actual}' AND Group_code<>121 AND company='{$company}'
			GROUP BY IF(`Group_code` IN (108,110,96),item, Group_code)
			UNION ALL
			SELECT IF(`Group_code` IN (108,110,96),item,Group_code), 
				IF(`Group_code` IN (108,110,96),`Budget item`,`Group`), 
				0 as Actual, {$sqlBudget}  as Budget, -{$sqlBudget} as Diff
			FROM `{$sqlBaseTable}` 			
			WHERE
			scenario='{$budget}' AND source<>'Estimate' AND Group_code<>121 AND company='{$company}'
			GROUP BY IF(`Group_code` IN (108,110,96),item, Group_code)",
			'tolerance'=>0.07,
			'limit'=>5);
			
$type = $_GET['type']?$_GET['type']:'teucus';
			
if (is_array($settings[$type])){
	$settings[$type]['title'] .= ', '.$arrPeriodType[$period_type];
	$settings[$type]['actual_title'] = $oActual->title;
	$settings[$type]['budget_title'] = $oBudget->title;
	$settings[$type]['denominator'] = $denominator;
	
	$oWF = new Waterfall($settings[$type]);
} else {
	die('Wrong report type');
}
					
$arrJS[] = 'js/rep_pnl.js';					
require ('includes/inc-frame_top.php');

// echo '<pre>';print_r($settings);echo '</pre>';

?>
<h1>Waterfall<?php echo ': ',$oActual->title, ": ",$arrPeriodType[$period_type];?></h1>
<?php
include ('includes/inc_report_selectors.php');

	$oWF->draw();
?>

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