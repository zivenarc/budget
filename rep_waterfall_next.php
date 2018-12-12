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
// $budget = $oBudget->id;

$arrActualRates = $oActual->getMonthlyRates($currency);
// $arrBudgetRates = $oBudget->getMonthlyRates($currency);

$limit = 8;
//$denominator = 1000;


SetCookie('period_type',$period_type,0,'/budget/');

$arrPeriodType = Array();
$arrPeriodType['nm'] = 'Next month';
$arrPeriodType['roy'] = 'Rest-of-year';
	
foreach($arrPeriodType as $id=>$title){
	$temp = $_GET;
	$temp['period_type'] = $id;
	$url = $_SERVER['PHP_SELF'].'?'.http_build_query($temp);
	$arrActions[] = Array ('title'=>$title,'action'=>$url);
}

$divider = ($period_type=='roy'?15-$oActual->cm:1);

$sqlActual = "SUM(".$oActual->getThisYTDSQL($period_type,$arrActualRates,$divider).")";
$sqlBudget = "SUM(".$oActual->getThisYTDSQL('ytd',$arrActualRates,$oActual->cm-$oActual->offset).")";
// $sqlBudget = "SUM(".$oActual->getThisYTDSQL($period_type,$arrBudgetRates).")";
// echo '<pre>';print_r($sqlActual);echo '</pre>';

$settings['gpcus'] = Array('title'=>"GP by customer",
					'sqlBase' => "SELECT customer_group_code as optValue, 
											customer_group_title as optText,
										{$sqlActual} as Actual, 
										{$sqlBudget} as Budget, 
										({$sqlActual}-{$sqlBudget}) as Diff
								FROM vw_master 								
								WHERE scenario='{$actual}' ".Reports::GP_FILTER." AND company='{$company}'
								GROUP BY customer_group_code
								",
						'tolerance'=>0.05,
						'limit'=>10);

$settings['gopcus'] = Array('title'=>"GOP by customer",
					'sqlBase' => "SELECT customer_group_code as optValue, 
											customer_group_title as optText,
										{$sqlActual} as Actual, 
										{$sqlBudget} as Budget, 
										({$sqlActual}-{$sqlBudget}) as Diff
								FROM vw_master 								
								WHERE scenario='{$actual}' ".Reports::GOP_FILTER." AND company='{$company}'
								GROUP BY customer_group_code
								",
						'tolerance'=>0.05,
						'limit'=>10);
						
// echo '<pre>';print_r($settings);echo '</pre>';
$settings['gpsal'] = Array('title'=>"GP by sales",
					'sqlBase' => "SELECT sales as optValue, 
										usrTitle as optText, 
										{$sqlActual} as Actual, 
										{$sqlBudget} as Budget, 
										({$sqlActual}-{$sqlBudget}) as Diff
								FROM vw_master 							
								WHERE scenario='{$actual}' ".Reports::GP_FILTER." AND company='{$company}'
								GROUP BY sales
								",
						'tolerance'=>0.02,
						'limit'=>10);						
						
$settings['gpcuswwh'] = Array('title'=>"GP by customer, FF",
					'sqlBase' => "SELECT IF(C.cntParentID<>723,C.cntParentID, C.cntID) as optValue, 
										IF(C.cntParentID<>723,(SELECT P.cntTitle FROM common_db.tbl_counterparty P WHERE P.cntID=C.cntParentID),cntTitle) as optText, 
										{$sqlActual} as Actual, 
										{$sqlBudget} as Budget, 
										({$sqlActual}-{$sqlBudget}) as Diff
								FROM vw_master 
								LEFT JOIN common_db.tbl_counterparty C ON C.cntID=customer
								WHERE scenario='{$actual}' ".Reports::GP_FILTER." AND company='{$company}'
								AND pc NOT in (5,15)
								GROUP BY IF(C.cntParentID<>723,C.cntParentID, C.cntID)
								",
						'tolerance'=>0.05,
						'limit'=>10);
						
$settings['gpbu'] = Array('title'=>"GP by business unit",
'sqlBase' => "SELECT pc as optValue, 
					Profit as optText, 
					{$sqlActual} as Actual, 
					{$sqlBudget} as Budget, 
					({$sqlActual}-{$sqlBudget}) as Diff
			FROM vw_master 			
			WHERE scenario='{$actual}' ".Reports::GP_FILTER." AND company='{$company}'
			GROUP BY pc
			",
			'tolerance'=>0.001
			);

$settings['gopbu'] = Array('title'=>"GOP by business unit",
'sqlBase' => "SELECT pc as optValue, 
					Profit as optText, 
					{$sqlActual} as Actual, 
					{$sqlBudget} as Budget, 
					({$sqlActual}-{$sqlBudget}) as Diff
			FROM vw_master 			
			WHERE scenario='{$actual}' ".Reports::GOP_FILTER." AND company='{$company}'
			GROUP BY pc
			",
			'tolerance'=>0.001
			);
			
$settings['oopbu'] = Array('title'=>"Own OP by business unit",
'sqlBase' => "SELECT pc as optValue, 
					Profit as optText, 
					{$sqlActual} as Actual, 
					{$sqlBudget} as Budget, 
					({$sqlActual}-{$sqlBudget}) as Diff
			FROM vw_master 			
			WHERE scenario='{$actual}' 
				AND (account NOT LIKE '6%' AND account NOT LIKE '7%' AND account NOT LIKE 'SZ%' AND account NOT LIKE '5999%' AND pccFlagProd=1) 
				AND company='{$company}'
			GROUP BY pc
			",
			'tolerance'=>0.001
			);

			
$settings['scbu'] = Array('title'=>"Staff cost by business unit",
'sqlBase' => "SELECT pc as optValue, 
					Profit as optText, 
					{$sqlActual} as Actual, 
					{$sqlBudget} as Budget, 
					({$sqlActual}-{$sqlBudget}) as Diff
			FROM vw_master 			
			WHERE scenario='{$actual}' ".Reports::SC_FILTER." AND company='{$company}'
			GROUP BY pc
			",
			'tolerance'=>0.005
			);			
			
$settings['gpact'] = Array('title'=>"GP by activity",
'sqlBase' => "SELECT activity as optValue, 
					Activity_title as optText, 
					{$sqlActual} as Actual, 
					{$sqlBudget} as Budget, 
					({$sqlActual}-{$sqlBudget}) as Diff
			FROM vw_master 			
			WHERE scenario='{$actual}' ".Reports::GP_FILTER." AND company='{$company}'
			GROUP BY activity
			",
			'tolerance'=>0.1
			);			
			
$settings['opbu'] = Array('title'=>"OP by business unit",
'sqlBase' => "SELECT pc as optValue, 
					Profit as optText, 
					{$sqlActual} as Actual, 
					{$sqlBudget} as Budget, 
					({$sqlActual}-{$sqlBudget}) as Diff
			FROM vw_master 			
			WHERE scenario='{$actual}'  ".Reports::OP_FILTER." AND company='{$company}'
			GROUP BY pc
			",
			'tolerance'=>0.001
			);

			
			
$settings['pbt'] = Array('title'=>"PBT by factors",
'sqlBase' => "SELECT IF(`Group_code` IN (108,110,96),item,Group_code)  as optValue, 
					IF(`Group_code` IN (108,110,96),`Budget item`,`Group`) as optText, 
					{$sqlActual} as Actual, 
					{$sqlBudget} as Budget, 
					({$sqlActual}-{$sqlBudget}) as Diff
			FROM vw_master 			
			WHERE scenario='{$actual}' AND Group_code<>121 AND company='{$company}'
			GROUP BY IF(`Group_code` IN (108,110,96),item, Group_code)
			",
			'tolerance'=>0.07,
			'limit'=>5);
			
$type = $_GET['type']?$_GET['type']:'gpcus';
			
if (is_array($settings[$type])){
	$settings[$type]['title'] .= ', '.$arrPeriodType[$period_type];
	$settings[$type]['actual_title'] = ($period_type=='roy'?('Avg.'.$oActual->arrPeriodTitle[$oActual->nm]."-".$oActual->arrPeriodTitle[15]):$oActual->arrPeriodTitle[$oActual->nm]);
	// $settings[$type]['budget_title'] = "YTD/".(($oActual->cm)-($oActual->offset));
	$settings[$type]['budget_title'] = "YTD average";
	$settings[$type]['denominator'] = $denominator;
	$settings[$type]['currency'] = $arrCurrencySelector[$currency];	
	
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

if($currency!=643){
		$sql = "SELECT * FROM vw_currency WHERE curID={$currency} LIMIT 1";
		$rs = $oSQL->q($sql);
		$rw = $oSQL->f($rs);
		$curTitle = $rw["curTitle$strLocal"];		
} else {
	$curTitle = "RUB";
}

if ($denominator!=1) {
	echo "<h2>{$curTitle} x{$denominator}</h2>";
} else {
	echo "<h2>{$curTitle}</h2>";
}

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