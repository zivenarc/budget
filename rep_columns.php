<?php
// $flagNoAuth = true;
require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/columns.class.php');
require ('classes/reports.class.php');

include ('includes/inc_report_settings.php');

$oBudget = new Budget($budget_scenario);
$oReference = new Budget($reference);

if ($bu_group){
	$sql = "SELECT * FROM common_db.tbl_profit WHERE pccParentCode1C='{$bu_group}'";
	$rs = $oSQL->q($sql);
	while ($rw = $oSQL->f($rs)){
		$arrBus[] = $rw['pccID']; 
	}
}

if(!isset($_GET['pccGUID'])){	
	
	$arrJS[]='js/rep_pnl.js';
	
	SetCookie('period_type',$period_type,0,'/budget/');

	if(strpos($oBudget->type,'budget')===false){
		$arrPeriodType['ytd'] = 'YTD';
		$arrPeriodType['cm'] = 'Current month';
		$arrPeriodType['nm'] = 'Next month';
		$arrPeriodType['roy'] = 'Rest-of-year';
	}
	
	if(!$oBudget->offset || $oBudget->length==15){
		$arrPeriodType['fye'] = 'FYE';
		$arrPeriodType['q1'] = '1<sup>st</sup> quarter';
	};
	
	$arrPeriodType['q2'] = '2<sup>nd</sup> quarter';
	$arrPeriodType['q3'] = '3<sup>rd</sup> quarter';
	$arrPeriodType['q4'] = '4<sup>th</sup> quarter';
	
	if($oBudget->offset || $oBudget->length==15){
		$arrPeriodType['q5'] = '5<sup>th</sup> quarter';
		$arrPeriodType['am'] = 'Apr-Mar';
	}


	
		
	foreach($arrPeriodType as $id=>$title){
		$temp = $_GET;
		$temp['period_type'] = $id;
		$url = $_SERVER['PHP_SELF'].'?'.http_build_query($temp);
		$arrActions[] = Array ('title'=>$title,'action'=>$url);
	}
		
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],'</h1>';
	echo '<h2>',$arrPeriodType[$period_type],'</h2>';
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
	
	$arrActualRates = $oBudget->getMonthlyRates($currency);
	$arrBudgetRates = $oReference->getMonthlyRates($currency);

	

	$sqlActual = "SUM(".$oBudget->getThisYTDSQL($period_type,$arrActualRates).")";
	$sqlBudget = "SUM(".$oBudget->getThisYTDSQL($period_type,$arrBudgetRates).")";

	
	// $sql="SELECT 	sales as optValue, 
					// usrTitle as optText,
					// customer_group_code as optGroupValue, 
					// customer_group_title as optGroupText,
										// {$sqlActual} as Actual, 
										// 0 as Budget, 
										// {$sqlActual} as Diff
								// FROM vw_master 								
								// {$sqlWhere} AND scenario='{$oBudget->id}' ".Reports::GP_FILTER." 
								// GROUP BY customer_group_code, sales
								// UNION ALL
								// SELECT sales as optValue, 
								// usrTitle as optText,
								// customer_group_code as optGroupValue, 
								// customer_group_title as optGroupText,
											// 0 as Actual, 
								// {$sqlBudget}  as Budget, -{$sqlBudget} as Diff
								// FROM vw_master 								
								// {$sqlWhere} AND	scenario='{$oReference->id}' AND source<>'Estimate' ".Reports::GP_FILTER." 
								// GROUP BY customer_group_code, sales";
	
	// $oReport = new Columns(Array('sqlBase'=>$sql, 'actual_title'=>$oBudget->title,'budget_title'=>$oReference->title,'xTitle'=>'Gross profit', 'title'=>'Gross profit'));
		
	// $oReport->draw();
	
	$sql="SELECT 	sales as optValue, 
					usrTitle as optText,
					customer_group_code as optGroupValue, 
					customer_group_title as optGroupText,
										{$sqlActual} as Actual, 
										0 as Budget, 
										{$sqlActual} as Diff
								FROM vw_master 								
								{$sqlWhere} AND scenario='{$oBudget->id}' AND Group_code=94
								GROUP BY customer_group_code, sales
								UNION ALL
								SELECT sales as optValue, 
								usrTitle as optText,
								customer_group_code as optGroupValue, 
								customer_group_title as optGroupText,
											0 as Actual, 
								{$sqlBudget}  as Budget, -{$sqlBudget} as Diff
								FROM vw_master 								
								{$sqlWhere} AND	scenario='{$oReference->id}' AND source<>'Estimate' AND Group_code=94
								GROUP BY customer_group_code, sales";
	
	$oReport = new Columns(Array('sqlBase'=>$sql, 'actual_title'=>$oBudget->title,'budget_title'=>$oReference->title,'xTitle'=>'Gross margin', 'title'=>'Gross margin'));
		
	$oReport->draw();
	

}


?>