<?php
$flagNoAuth = true;
require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/reports.class.php');
require ('classes/waterfall.class.php');
include ('includes/inc_report_settings.php');
include ('includes/inc_report_ghqfilter.php');

// $arrActions[] = Array('title'=>'Current month','action'=>'?period_type=cm');
// $arrActions[] = Array('title'=>'FYE','action'=>'?period_type=fye');

if ($bu_group){
	$sql = "SELECT * FROM common_db.tbl_profit WHERE pccParentCode1C='{$bu_group}'";
	$rs = $oSQL->q($sql);
	while ($rw = $oSQL->f($rs)){
		$arrBus[] = $rw['pccID']; 
	}
}

	//$denominator = 1000;	
	// $budget_scenario = $_GET['budget_scenario']?$_GET['budget_scenario']:$arrSetup['stpFYEID'];
	// $reference = $_GET['reference']?$_GET['reference']:$arrSetup['stpScenarioID'];
	
	$oBudget = new Budget($budget_scenario);
	$oReference = new Budget($reference);
	
	if(strpos($oBudget->type,"Budget")!==false){	
		$period_type = 'fye';
	}
	//$period_type = 'cm';
	
	if ($_GET['debug']){
		echo '<pre>';print_r($oBudget);echo '</pre>';
	}

if(!isset($_GET['prtGHQ'])){
	
	$arrJS[]='js/rep_pnl.js';
	$arrJS[] = "js/rep_summary.js";

	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,' vs ',$oReference->title,'</h1>';	
	include ('includes/inc_report_selectors.php');
	echo '<p>',$oBudget->timestamp,'; ',$oBudget->rates,'</p>';
	
	$oBudget->getGHQTabs();
	
	include ('includes/inc-frame_bottom.php');
} else {

	if(is_array($arrProducts)){
	?>
	<p><?php echo implode(', ',$arrProducts['title']);?></p>
	<?php
	}	
	
	?>
	<div>
	<?php
	
	$settings = Array('title'=>"FYE by factors, GOP",
						'sqlBase' => "",
							'denominator'=>$denominator,
							'actual_title'=>$oBudget->title,
							'budget_title'=>$oReference->title,
							'tolerance'=>0.05,
							'limit'=>10);	
	
	$oWF = new Waterfall($settings);
	
	$sql = "SELECT SUM(".$oBudget->getThisYTDSQL('fye',$arrActualRates).") as Budget
			FROM reg_master 
			{$sqlWhere} and company='{$company}' 
			AND scenario='{$oReference->id}' ".Reports::GOP_FILTER;	
	$rs = $oSQL->q($sql);
	$rw = $oSQL->f($rs);			
	$oWF->arrReport[] = Array('title'=>$oReference->title,
								'this'=>null,
								'that'=>null,
								'diff'=>$rw['Budget']/$oWF->denominator,
								'class'=>'budget-subtotal');
	$oWF->arrHSChart[] = Array('name'=>$oWF->budget_title,'y'=>(integer)$rw['Budget'], 'color'=>'blue');
	
	$sql = "SELECT SUM(".$oBudget->getThisYTDSQL('ytd',$arrActualRates).") as Diff
		FROM reg_master 
		{$sqlWhere} and company='{$company}' 
		AND scenario='{$oReference->id}' ".Reports::GOP_FILTER;	
	$rs = $oSQL->q($sql);
	$rw = $oSQL->f($rs);
	$ytdBudget = $rw['Diff'];
	$sql = "SELECT SUM(".$oBudget->getThisYTDSQL('ytd',$arrActualRates).") as Actual
			FROM reg_master 
			{$sqlWhere} and company='{$company}'
			AND scenario='{$oBudget->id}' ".Reports::GOP_FILTER;
	$rs = $oSQL->q($sql);
	$rw = $oSQL->f($rs);			
	$strDiff = ($rw['Actual']>=$ytdBudget?"YTD proficit":"YTD deficit");
	$oWF->arrReport[] = Array('title'=>$strDiff,
								'this'=>$rw['Actual']/$oWF->denominator,
								'that'=>$ytdBudget/$oWF->denominator,
								'diff'=>($rw['Actual']-$ytdBudget)/$oWF->denominator);
	$oWF->arrHSChart[] = Array('name'=>$strDiff,'y'=>(integer)($rw['Actual']-$ytdBudget));
	
	$limit = 3;
	$sqlActual = "SUM(".$oBudget->getThisYTDSQL('roy',$arrActualRates).")";
	$sqlBudget = "SUM(".$oBudget->getThisYTDSQL('roy',$arrBudgetRates).")";
	$sqlBase = "SELECT  customer_group_code as optValue, 
					customer_group_title as optText,  
					{$sqlActual} as Actual, 
					0 as Budget, 
					{$sqlActual} as Diff
			FROM vw_master 
			{$sqlWhere}
				AND  scenario='{$oBudget->id}' AND company='{$company}' AND account IN ('J00400', 'J00802')
			GROUP BY customer_group_code
			UNION ALL
			SELECT  customer_group_code as optValue, 
					customer_group_title as optText,  
			0 as Actual, 
			{$sqlBudget}  as Budget, 
			-{$sqlBudget} as Diff
			FROM vw_master 									
			{$sqlWhere}
				AND scenario='{$oReference->id}' AND company='{$company}' 
				AND source<>'Estimate' 
				AND account IN ('J00400', 'J00802')										
			GROUP BY customer_group_code";
	
	$oWF->processSQL($sqlBase,$limit,'GP');
	
	$sqlBase="SELECT IF(`Group_code` IN (108,110,96,94),item,Group_code)  as optValue, 
											IF(`Group_code` IN (108,110,96,94),`Budget item`,`Group`) as optText, 
											{$sqlActual} as Actual, 
											0 as Budget, 
											{$sqlActual} as Diff
									FROM vw_master 
									{$sqlWhere}
										AND  scenario='{$oBudget->id}' AND company='{$company}' 
										".Reports::RFC_FILTER."																			
									GROUP BY IF(`Group_code` IN (108,110,96,94),item,Group_code)
									UNION ALL
									SELECT IF(`Group_code` IN (108,110,96,94),item,Group_code)  as optValue, 
											IF(`Group_code` IN (108,110,96,94),`Budget item`,`Group`) as optText, 
											0 as Actual, 
									{$sqlBudget}  as Budget, -{$sqlBudget} as Diff
									FROM vw_master 
									{$sqlWhere}
										AND scenario='{$oReference->id}' AND company='{$company}' 								
										".Reports::RFC_FILTER."										
									GROUP BY IF(`Group_code` IN (108,110,96,94),item,Group_code)";
	
	$oWF->processSQL($sqlBase,$limit,'RFC');
	
	$sql = "SELECT SUM(".$oBudget->getThisYTDSQL('fye',$arrActualRates).") as Diff
			FROM reg_master 
			{$sqlWhere} and company='{$company}' 
			AND scenario='{$oBudget->id}' ".Reports::GOP_FILTER;	
	$rs = $oSQL->q($sql);
	$rw = $oSQL->f($rs);		
	$oWF->arrReport[] = Array('title'=>$oBudget->title,
								'this'=>null,
								'that'=>null,
								'diff'=>$rw['Diff']/$oWF->denominator,
								'class'=>'budget-subtotal');	
	$oWF->arrHSChart[] = Array('name'=>$oWF->actual_title,'y'=>(integer)$rw['Diff'], 'color'=>'#646464','isSum'=>true);
		
	?>
		<table>
		<tr>
		<td>
		<?php $oWF->drawTable(); ?>
		</td>
		<td>
		<?php $oWF->drawChart(); ?>
		</td>
		</table>
		<?php	
	
	
	// }
	?>
	</div>
	<?php
	
}


?>