<?php
// $flagNoAuth = true;
require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/columns.class.php');
require ('classes/reports.class.php');

include ('includes/inc_report_settings.php');

$oActual = new Budget($budget_scenario);
$oBudget = new Budget($reference);

if ($bu_group){
	$sql = "SELECT * FROM common_db.tbl_profit WHERE pccParentCode1C='{$bu_group}'";
	$rs = $oSQL->q($sql);
	while ($rw = $oSQL->f($rs)){
		$arrBus[] = $rw['pccID']; 
	}
}

if(!isset($_GET['pccGUID'])){	
	
	$arrJS[]='js/rep_pnl.js';
	// $arrJS[]='js/input_form.js';	
	
	// $arrActions[] = Array ('title'=>'By customer group','action'=>"?type=customer_group");
	// $arrActions[] = Array ('title'=>'By customer','action'=>"?type=customer");
	// $arrActions[] = Array ('title'=>'By activity','action'=>"?type=activity");
	// $arrActions[] = Array ('title'=>'By GHQ type','action'=>"?type=ghq");
	// $arrActions[] = Array ('title'=>'By BDV staff','action'=>"?type=sales");
	// $arrActions[] = Array ('title'=>'By PC','action'=>"?type=pc");
		
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],'</h1>';
	include ('includes/inc_report_selectors.php');	
	
	Budget::getProfitTabs('reg_master', !$flagNoAuth, Array('pccID'=>$arrBus));
	
	include ('includes/inc-frame_bottom.php');
} else {
	
	// include ('includes/inc_report_buttons.php');
	
	if ($_GET['pccGUID']=='all'){
		
		
		
		if (!$flagNoAuth) { 
			$strRoles = "'".implode("','",$arrUsrData['roleIDs'])."'";
			$sqlPCFilter[] = "pcrRoleID IN ({$strRoles}) AND pcrFlagRead=1"; 
			$sqlRoleFilter[] = "pcrRoleID IN ({$strRoles}) AND pcrFlagRead=1"; 
		};
		
		if ($bu_group){
			$strBUs = implode(',',$arrBus);
			$sqlPCFilter[] = "pcrProfitID IN ({$strBUs})";
			$sql = "SELECT DISTINCT pcrProfitID FROM stbl_profit_role WHERE ".implode(" AND ",$sqlPCFilter);
		} else {		
			$sql = "SELECT DISTINCT pcrProfitID FROM stbl_profit_role WHERE ".implode(" AND ",$sqlRoleFilter);
		}
		$rs = $oSQL->q($sql);
		while ($rw = $oSQL->f($rs)){
			$arrPC[] = $rw['pcrProfitID'];
		}
		$sqlWhere = "WHERE pc in (".implode(',',$arrPC).")";
	} else {
		$sqlWhere = "WHERE pc in (SELECT pccID FROM vw_profit WHERE pccGUID=".$oSQL->e($_GET['pccGUID']).")";
	}
	
	$actual = $oActual->id;
	$budget = $oBudget->id;

	$arrActualRates = $oActual->getMonthlyRates($currency);
	$arrBudgetRates = $oBudget->getMonthlyRates($currency);

	$limit = 8;
	//$denominator = 1000;


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

	$sqlActual = "SUM(".$oActual->getThisYTDSQL($period_type,$arrActualRates).")";
	$sqlBudget = "SUM(".$oActual->getThisYTDSQL($period_type,$arrBudgetRates).")";

	
	$sql="SELECT 	sales as optValue, 
					usrTitle as optText,
					customer_group_code as optGroupValue, 
					customer_group_title as optGroupText,
										{$sqlActual} as Actual, 
										0 as Budget, 
										{$sqlActual} as Diff
								FROM vw_master 								
								{$sqlWhere} AND scenario='{$actual}' ".Reports::GP_FILTER." 
								GROUP BY customer_group_code, sales
								UNION ALL
								SELECT sales as optValue, 
								usrTitle as optText,
								customer_group_code as optGroupValue, 
								customer_group_title as optGroupText,
											0 as Actual, 
								{$sqlBudget}  as Budget, -{$sqlBudget} as Diff
								FROM vw_master 								
								{$sqlWhere} AND	scenario='{$budget}' AND source<>'Estimate' ".Reports::GP_FILTER." 
								GROUP BY customer_group_code, sales";
	
	$oReport = new Columns(Array('sqlBase'=>$sql, 'actual_title'=>$oActual->title,'budget_title'=>$oBudget->title,'xTitle'=>'Gross profit'));
		
	$oReport->draw();
	
	

}


?>