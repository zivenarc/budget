<?php
// $flagNoAuth = true;
require ('classes/reports.class.php');
require ('common/auth.php');
require ('classes/reference.class.php');
require ('classes/item.class.php');


include ('includes/inc_report_settings.php');
$oBudget = new Budget($budget_scenario);

$arrRates = $oBudget->getMonthlyRates($currency);

$arrKeys = Array();
$arrReport = Array('Air export'=>$arrKeys,
					'Air import'=>$arrKeys,
					// 'AFF Total'=>$arrKeys,
					'Ocean export'=>$arrKeys,
					'Ocean import'=>$arrKeys,
					// 'OFF Total'=>$arrKeys,
					'OCM (SCS)'=>$arrKeys,
					'Warehouse'=>$arrKeys,
					'Land transport'=>$arrKeys);

$arrJS[] = 'js/rep_totals.js';

$sql = "SELECT DISTINCT pc, Profit FROM vw_master WHERE scenario='{$budget_scenario}' ORDER BY pccFlagProd";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	$arrProfit[$rw['pc']] = $rw;
}

// $startMonth = date('n',$oBudget->date_start);
$arrActions[] = Array('title'=>'YTD', 'action'=>"?mthStart=".($oBudget->offset+1)."&mthEnd={$oBudget->cm}");
$arrActions[] = Array('title'=>'FYE', 'action'=>"?mthStart=".($oBudget->offset+1)."&mthEnd=".($oBudget->offset+12));
// $arrActions[] = Array('title'=>'Jan-Mar', 'action'=>'?mthStart=1&mthEnd=3');
// $arrActions[] = Array('title'=>'Jan-Dec', 'action'=>'?mthStart=1&mthEnd=12');
// $arrActions[] = Array('title'=>'Apr-Mar', 'action'=>'?mthStart=4&mthEnd=15');
// $arrActions[] = Array('title'=>'Jan-Mar', 'action'=>'?mthStart=1&mthEnd=15');
$startMonth = isset($_GET['mthStart'])?$_GET['mthStart']:1+$oBudget->offset;
$endMonth = isset($_GET['mthEnd'])?$_GET['mthEnd']:12+$oBudget->offset;
$colspan = $endMonth - $startMonth + 3;

$sql = "SELECT account, pc, prtGHQ, ".$oBudget->getMonthlySumSQL($startMonth,$endMonth, $arrRates)." 
		FROM vw_master
		WHERE scenario='{$budget_scenario}' AND company='{$company}'
		AND account IN ('5999CO','5999BD')
		AND pccFlagProd=1
		GROUP BY prtGHQ, account
		ORDER BY prtGHQ, account";
$rs = $oSQL->q($sql);
if(!$oSQL->n($rs)){
	die("<div class='error'>No base for cost distribution. Prepare the <a href='rep_ratios.php?budget_scenario={$budget_scenario}&DataAction=update'>revenue register</a> first</div>");
}

while ($rw = $oSQL->f($rs)){
	for($m=$startMonth;$m<=$endMonth;$m++){
		$month = $oBudget->arrPeriod[$m];
		// $arrPC[$rw['pc']][$rw['prtGHQ']][$month] += $rw[$month];
		// $arrSubtotal[$rw['pc']][$month] += $rw[$month];
		$arrGHQSubtotal[$rw['account']][$rw['prtGHQ']][$month] += $rw[$month];
		$arrCost[$rw['account']][$month] += $rw[$month];
	}
}

// foreach($arrPC as $pc=>$arrGhq){
	// foreach ($arrGhq as $ghq=>$values){
		// for($m=$startMonth;$m<=$endMonth;$m++){
			// $month = $oBudget->arrPeriod[$m];
			// $arrRatio[$pc][$ghq][$month] = $arrSubtotal[$pc][$month]?$values[$month]/$arrSubtotal[$pc][$month]:0;
		// }
	// }
// }

// echo '<pre>';print_r($arrCost);echo '</pre>';

$sqlFields = "account, title, prtGHQ, pc, pccFlagProd, Profit, 
				SUM(".$oBudget->getYTDSQL($startMonth,$endMonth, $arrRates).") as Total, 				
				".$oBudget->getMonthlySumSQL($startMonth,$endMonth, $arrRates);
$sqlGroupBy = "account, pc, prtGHQ, pccFlagProd";

$sqlWhere = "WHERE scenario='{$budget_scenario}' 
			AND company='{$company}' 
			AND source<>'Estimate'";
			// AND pccFlagProd=1 ";


//------------------------------------------DEBUG
if($_GET['DataAction']=='excel'){
	include ('includes/inc-frame_top.php');
	$sql = "SELECT {$sqlFields} 
			FROM vw_master 
			{$sqlWhere}
			GROUP BY {$sqlGroupBy}";
	echo '<h1>Data</h1>';
	echo '<pre>',$sql,'</pre>';	
	$rs = $oSQL->q($sql);
	populate_recordset($rs,'budget','d.m.Y','debug');
	Reports::_echoButtonCopyTable('debug');
	include ('includes/inc-frame_bottom.php');
	die();
}
////////////////////////////////////////////////
			
$arrRevenueFilter = Array(
	Items::REVENUE,
	Items::INTERCOMPANY_REVENUE,
	Items::PROFIT_SHARE
);



$arrAccounts = Array(
		'Revenue'=>Array('sql'=>"SELECT {$sqlFields} FROM vw_master 
							{$sqlWhere} 
							".Reports::REVENUE_FILTER."			
							GROUP by {$sqlGroupBy} ORDER BY {$sqlGroupBy}",'subtotal'=>Array('Gross profit','Gross operating profit','Net operating profit','PBT')),
		'Direct costs'=>Array('negative'=>true, 'sql'=>"SELECT {$sqlFields} FROM vw_master 
								{$sqlWhere}  
								".Reports::DIRECT_COST_FILTER."	
								AND pccFlagProd=1
								GROUP BY {$sqlGroupBy}",'subtotal'=>Array('Gross profit','Gross operating profit','Net operating profit','PBT')),
		'Gross profit'=>Array('class'=>'budget-subtotal'),
		'Reclassified fixed costs'=>Array('negative'=>true,'breakdown'=>true,'sql'=>"SELECT {$sqlFields} FROM vw_master 
									{$sqlWhere} 
									".Reports::RFC_FILTER." 
									AND pccFlagProd=1			
									GROUP by {$sqlGroupBy}
									ORDER by account",'subtotal'=>Array('Gross operating profit','Net operating profit','PBT')),
		'Gross operating profit'=>Array('class'=>'budget-subtotal'),
		'General costs'=>Array('negative'=>true,'breakdown'=>true,'sql'=>"SELECT {$sqlFields} FROM vw_master 
								{$sqlWhere}  
								AND (account LIKE '5%' AND account NOT IN ('5999CO','527000'))
								##AND pccFlagProd=1											
								GROUP by {$sqlGroupBy}
								ORDER BY account",'subtotal'=>Array('Net operating profit','PBT')),
		'Corporate costs'=>Array('negative'=>true,'breakdown'=>true,'sql'=>"SELECT {$sqlFields} FROM vw_master 
								{$sqlWhere} 
								".Reports::CORP_FILTER."
								##AND pccFlagProd=1	
								GROUP by {$sqlGroupBy}
								ORDER BY account",'subtotal'=>Array('Net operating profit','PBT')),
		'MSF'=>Array('negative'=>true,'breakdown'=>true,'sql'=>"SELECT {$sqlFields} FROM vw_master 
								{$sqlWhere} 
								".Reports::MSF_FILTER."
								AND pccFlagProd=1								
								GROUP by {$sqlGroupBy}
								ORDER BY account",'subtotal'=>Array('Net operating profit','PBT')),
		'Net operating profit'=>Array('class'=>'budget-subtotal'),
		'Non-operating income'=>Array('sql'=>"SELECT {$sqlFields} FROM vw_master 
								{$sqlWhere} 
									AND (account like '60%') AND account<>'607000'			
								GROUP by pc, prtGHQ",'subtotal'=>Array('PBT')),
		'Non-operating costs'=>Array('negative'=>true,'sql'=>"SELECT {$sqlFields} FROM vw_master 
								{$sqlWhere} 
									AND (account like '65%' or account like '66%')			
								GROUP by pc, prtGHQ",'subtotal'=>Array('PBT')),
		'Extraordinary'=>Array('negative'=>true,'sql'=>"SELECT {$sqlFields} FROM vw_master 
								{$sqlWhere} 
									AND (account like '7%')			
								GROUP by pc, prtGHQ",'subtotal'=>Array('PBT')),
		'PBT'=>Array('class'=>'budget-total')
	);

// echo '<pre>';print_r($arrAccounts); echo '</pre>';

foreach($arrReport as $key=>$values){
	$arrReport[$key] = $arrAccounts;
	$arrPC[$key] = Array();
}
			
foreach ($arrAccounts as $reportKey=>$settings){
	$sql = $settings['sql'];
	 // echo '<pre>',$sql,'</pre>';
	if(strlen($sql)){
		$rs = $oSQL->q($sql);
		while ($rw = $oSQL->f($rs)){
			
			$product = $rw['prtGHQ'];
			if (strpos($product,'Air')!==false){
				$productTotal = "AFF Total";
			} elseif (strpos($product,'Ocean')!==false) {
				$productTotal = "OFF Total";
			} else {
				$productTotal = '';
			}
			
			
			$arrPC[$product][] = $rw['Profit'];
			if($productTotal) { $arrPC[$productTotal][] = $rw['Profit']; };
				
			if($rw['pccFlagProd']){
				for($m=$startMonth;$m<=$endMonth;$m++){
					$month = $oBudget->arrPeriod[$m];
					
					$arrReport[$product][$reportKey]['monthly'][$month] += $rw[$month]*($settings['negative']?-1:1);
					$arrReport[$product][$reportKey]['pc'][$rw['Profit']] += $rw[$month]*($settings['negative']?-1:1);
					for($i=0;$i<count($settings['subtotal']);$i++){
						$arrReport[$product][$settings['subtotal'][$i]]['monthly'][$month] += $rw[$month];
						$arrReport[$product][$settings['subtotal'][$i]]['pc'][$rw['Profit']] += $rw[$month];
						$arrGrandTotal[$settings['subtotal'][$i]]['monthly'][$month] += $rw[$month];
					};
					
					$arrGrandTotal[$reportKey]['monthly'][$month] += $rw[$month];
				
					if($settings['breakdown']){
						$accKey = getAccountAlias($rw['account']);
						$accKeyOther = getOtherAccountAlias($rw['account']);
						$arrBreakDown[$reportKey][$accKey][$product] += $rw[$month];
						$arrBreakDownMonthly[$reportKey][$product][$accKeyOther][$month] += $rw[$month];
					}
					
					if ($productTotal){
						$arrReport[$productTotal][$reportKey]['monthly'][$month] += $rw[$month]*($settings['negative']?-1:1);
						$arrReport[$productTotal][$reportKey]['pc'][$rw['Profit']] += $rw[$month]*($settings['negative']?-1:1);
						for($i=0;$i<count($settings['subtotal']);$i++){
							$arrReport[$productTotal][$settings['subtotal'][$i]]['monthly'][$month] += $rw[$month];
							$arrReport[$productTotal][$settings['subtotal'][$i]]['pc'][$rw['Profit']] += $rw[$month];							
						};
					
					}
			
				}
			} else {
				
				for($m=$startMonth;$m<=$endMonth;$m++){
					$month = $oBudget->arrPeriod[$m];
					if($settings['breakdown']){
						
						$accKey = getAccountAlias($rw['account']);
						$accKeyOther = getOtherAccountAlias($rw['account']);
						switch((integer)$rw['pc']){
							case 9:
							case 130:
								$corpKey = '5999BD';
								$bdKey = $reportKey;
								break;
							default:
								$bdKey = "Corporate costs";
								$corpKey = '5999CO';
								$arrPCBreakdown[$accKey][$rw['Profit']] -= $rw[$month];
								break;
						}
						
						
						foreach($arrGHQSubtotal[$corpKey] as $ghq=>$data){
							if ($arrCost[$corpKey][$month]){
								$arrBreakDown[$bdKey][$accKey][$ghq] += $rw[$month]*$data[$month]/$arrCost[$corpKey][$month];
								$arrBreakDownMonthly[$bdKey][$ghq][$accKeyOther][$month] += $rw[$month]*$data[$month]/$arrCost[$corpKey][$month];
							}
						}
					}	
				}
				
				$arrGrandTotal[$reportKey]['monthly'][$month] += $rw[$month];
			}
			

		}
	}
}

// echo '<pre>';print_r($arrPCBreakdown);echo '</pre>';

$reportKey = 'Extraordinary income';
$sql = "SELECT {$sqlFields} FROM vw_master 
		WHERE scenario='{$budget_scenario}' AND company='{$company}' AND source<>'Estimate' AND (account like '70%')
		GROUP by pc, prtGHQ";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=$startMonth;$m<=$endMonth;$m++){
		$month = $oBudget->arrPeriod[$m];
		$arrReport[$rw['prtGHQ']][$reportKey][$month] += $rw[$month];
		$arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}


$reportKey = 'Extraordinary costs';
$sql = "SELECT {$sqlFields} FROM vw_master 
		WHERE scenario='{$budget_scenario}' AND company='{$company}' AND source<>'Estimate' AND (account like '75%' or account like '76%') 
		GROUP by pc, prtGHQ";
$rs = $oSQL->q($sql);
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=$startMonth;$m<=$endMonth;$m++){
		$month = $oBudget->arrPeriod[$m];
		$arrReport[$rw['prtGHQ']][$reportKey][$month] += $rw[$month];
		$arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}

$reportKey = 'NO YACT';
$sql = "SELECT {$sqlFields} 
		FROM vw_master 
		WHERE scenario='{$budget_scenario}' AND company='{$company}' AND source<>'Estimate' AND IFNULL(account,'') LIKE '' 
		GROUP by pc, prtGHQ";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=$startMonth;$m<=$endMonth;$m++){
		$month = $oBudget->arrPeriod[$m];
		$arrReport[$rw['prtGHQ']][$reportKey][$month] += $rw[$month];
		$arrGrandTotal[$reportKey][$month] += $rw[$month];
	}
}
// echo '<pre>';print_r($arrReport);echo '</pre>';

$reportKey = 'Control PBT';
$sql = "SELECT {$sqlFields} FROM vw_master 
		{$sqlWhere} AND account NOT LIKE 'SZ%'";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	for($m=$startMonth;$m<=$endMonth;$m++){
		$month = $oBudget->arrPeriod[$m];
		$arrControl[$month] += $rw[$month];
	}
}

include ('includes/inc-frame_top.php');
echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,'</h1>';
include ('includes/inc_report_selectors.php');
echo '<p>',$oBudget->timestamp,'</p>';
?>
<style>
	.toggle{
		color: blue;
		border-bottom: 1px dashed blue;
		margin-bottom: 5px;
		cursor: pointer;
	}
</style>
<script>
$(document).ready(function(){
	
	$('.budget-bypc').hide();
	$('.toggle').click(function(){
		var o = $(this).parent('div');
		var res = toggleVisibility(o);
		$(this).text(res);
	});
	
});

function toggleVisibility(o){
	var cellsMonthly = $('.budget-monthly',o);
	var cellsPC = $('.budget-bypc',o);
	
	var wrapperDivsMonthly = cellsMonthly.wrapInner('<div/>').children();
	var wrapperDivsPC = cellsPC.wrapInner('<div style="display:block;"/>').children();
	
	if ($('.budget-monthly:visible',o).length>0){			
		wrapperDivsMonthly.animate({'width':'hide'},1000,function(){
			cellsMonthly.hide();
			wrapperDivsMonthly.replaceWith(function(){
              return $(this).contents();
            });			
		});
		wrapperDivsPC.animate({'width':'show'},1000,function(){
				cellsPC.show();
				wrapperDivsPC.replaceWith(function(){
					return $(this).contents();
				});
			});
		return ('Show by month');
	} else {
		wrapperDivsMonthly.animate({'width':'show'},1000,function(){
			cellsMonthly.show();
			wrapperDivsMonthly.replaceWith(function(){
              return $(this).contents();
            });			
		});
		wrapperDivsPC.animate({'width':'hide'},1000,function(){
				cellsPC.hide();
				wrapperDivsPC.replaceWith(function(){
					return $(this).contents();
				});
			});
		return ('Show by unit');
	}
}
</script>
<div id="report">
<?php 
foreach ($arrReport as $ghq=>$arrItems){
	$arrPC[$ghq] = array_unique($arrPC[$ghq]);
?>
<div id="<?php echo $ghq;?>">
<h2><?php echo $ghq?$ghq:"No product";?></h2>
<span class='toggle'>Show by unit</span>
<table id="<?php echo 'report_'.$qhq;?>" class="budget">
<thead>
	<th>Item</th>
	<?php echo $oBudget->getTableHeader('monthly', $startMonth,$endMonth); ?>
	<th>Total</th>
	<?php
	foreach ($arrPC[$ghq] as $pc){
		?>
		<th class='budget-bypc'><?php echo $pc;?></th>
		<?php
	};
	?>
</thead>
<tbody>
	<?php
	foreach ($arrAccounts as $item=>$settings){
		?>
		<tr class="<?php echo $settings['class'];?>">
			<td><?php echo $item;?></td>
			<?php
			for ($m=$startMonth;$m<=$endMonth;$m++){
				$month = $oBudget->arrPeriod[$m];
				?>
				<td class="budget-decimal budget-monthly <?php echo ($m==$oBudget->cm?'budget-current':'');?>"><?php Reports::render($arrReport[$ghq][$item]['monthly'][$month],0);?></td>
				<?php
			}
			$columnTotal = (is_array($arrReport[$ghq][$item]['monthly'])?array_sum($arrReport[$ghq][$item]['monthly']):0);
		?>
			<td class="budget-ytd budget-decimal"><?php Reports::render($columnTotal,0);?></td>			
			<?php
			foreach ($arrPC[$ghq] as $pc){
				?>
				<td class="budget-decimal budget-bypc"><?php Reports::render($arrReport[$ghq][$item]['pc'][$pc],0);?></td>
				<?php
			}
			?>
		</tr>
		<?php
	}
	?>
	</tbody>
	</table>
</div>
	<?php
}
?>
<h2>Grand total</h2>
<table class='budget'>
<thead>
	<th>Item</th>
	<?php echo $oBudget->getTableHeader('monthly', $startMonth,$endMonth); ?>
	<th>Total</th>	
</thead>
<tbody>
<?php
foreach ($arrAccounts as $item=>$settings){
		?>
		<tr class="<?php echo $settings['class'];?>">
			<td><?php echo $item;?></td>
			<?php
			for ($m=$startMonth;$m<=$endMonth;$m++){
				$month = $oBudget->arrPeriod[$m];
				?>
				<td class="budget-decimal"><?php Reports::render($arrGrandTotal[$item]['monthly'][$month],0);?></td>
				<?php
				$arrNRBT[$month] += $arrGrandTotal[$item]['monthly'][$month];
			}
		?>
		<td class="budget-ytd budget-decimal"><?php Reports::render(array_sum($arrGrandTotal[$item]['monthly']),0);?></td>
		</tr>
		<?php
}
?>
<tr class="budget-total">
<td>Control</td>
<?php
for ($m=$startMonth;$m<=$endMonth;$m++){
				$month = $oBudget->arrPeriod[$m];
				?>
				<td class="budget-decimal" style="background-color:<?php echo (round($arrControl[$month],0)==round($arrNRBT[$month],0)?'lightgreen':'pink');?>;"><?php Reports::render($arrControl[$month],0);?></td>
				<?php
}
?>
	<td class="budget-decimal budget-ytd"><?php Reports::render(array_sum($arrControl),0);?></td>
</tr>
<tr class="">
<td>Diff</td>
<?php
for ($m=$startMonth;$m<=$endMonth;$m++){
				$month = $oBudget->arrPeriod[$m];
				?>
				<td class="budget-decimal"><?php Reports::render($arrControl[$month]-$arrGrandTotal[$item]['monthly'][$month],0);?></td>
				<?php
}
?>
	<td class="budget-decimal budget-ytd"><?php Reports::render(array_sum($arrControl)-array_sum($arrGrandTotal[$item]['monthly']),0);?></td>
</tr>
</tbody>
</table>
</div>
<?php
Reports::_echoButtonCopyTable('report');
// echo '<pre>';print_r($arrGHQSubtotal);echo '</pre>';

?>
<h2>Activity ratios</h2>
<table class='budget' style='width:auto;'>
<thead>
<tr>
<th>Type</th>
<?php
foreach($arrReport as $ghq=>$values){
	echo '<th>',($ghq?$ghq:'[None]'),'</th>';
}
?>
	<th class="budget-ytd">Total</th>
</tr>
</thead>
<tbody>
<?php
	foreach($arrGHQSubtotal as $account=>$data){
?>
	<tr>
		<td><?php echo $account;?></td>
		<?php
		foreach ($arrReport as $ghq=>$values) {
			$arrSubtotal[$account] += array_sum($data[$ghq])/array_sum($arrCost[$account]);
		?>
		<td><?php Reports::render_ratio(array_sum($data[$ghq]),array_sum($arrCost[$account]));?></td>
		<?php
		}
	?>
		<td class="budget-ytd"><?php Reports::render($arrSubtotal[$account]*100,1);?></td>
	</tr>
	<?php
	}
?>
</tbody>
</table>

<h1>Additional info</h1>
<?php
getBreakdown($arrBreakDown, $arrReport);

?>
<h1>Additional monthly</h2>
<?php
//$arrBreakDownMonthly[$bdKey][$ghq][$accKeyOther][$month]

foreach($arrBreakDownMonthly as $costType=>$costReport){
	$strTableID = 'breakdown_'.$costType;
	?>
	<h3><?php echo $costType ;?></h3>
	<table class="budget" id="<?php echo $strTableID;?>">
	<tr>
		<th>Activity</th>
		<th>Cost</th>
		<?php
					for($m=4;$m<=15;$m++){
						$month = $oBudget->arrPeriodTitle[$m];
						?>						
						<th><?php echo $month;?></th>
						<?php
					};
		?>
		<th>Total</th>
	</tr>
	<?php
	foreach($costReport as $activity=>$breakdowndata){
		$i=0;
		?>
		<tr>
			<td rowspan="<?php echo count($breakdowndata);?>"><?php echo $activity;?></td>
			<?php foreach ($breakdowndata as $account=>$data){
				if ($i>0) echo '<tr>';
					?>
					<td><?php echo $account;?></td>					
					<?php
					for($m=4;$m<=15;$m++){
						$month = $oBudget->arrPeriod[$m];
						?>						
						<td class="budget-decimal"><?php Reports::render(-$data[$month]);?></td>
						<?php
					};
					?>
					<td class="budget-decimal budget-ytd"><?php Reports::render(-array_sum($data));?></td>
					<?php
				if ($i>0) echo '</tr>';
				$i++;
			}
			?>			
		</tr>
		<?php
	}
	?>
	</table>
	<?php
	Reports::_echoButtonCopyTable($strTableID);
}

$strTableID = 'corp_breakdown';
?>	
	<h3>Corporate cost breakdown</h3>
	<table class='budget' id='<?php echo $strTableID;?>'>
	<caption>Corporate costs :: <?php $oBudget->title;?></caption>
	<thead>
		<tr>
			<th>Cost center</th>
			<?php
			foreach ($arrPCBreakdown as $account=>$pcData){
				echo '<th>',$account,'</th>';
			}
			?>
			<th class="budget-ytd">Total</th>			
		</tr>
	</thead>
	<tbody>
		<?php
			foreach ($pcData as $pc=>$values){
				$rowTotal = 0;
				?>
				<tr>
				<td><?php echo ($pc?$pc:'[None]');?></td>
				<?php				
				foreach ($arrPCBreakdown as $account=>$pcData){					
					$rowTotal += $pcData[$pc];
					$arrColTotal[$account] += $pcData[$pc];
					?>
					<td class="budget-decimal"><?php Reports::render($pcData[$pc]);?></td>
					<?php
				}
				
								
				echo '<td class="budget-ytd budget-decimal">',Reports::render($rowTotal),'</td>';				
				?>
				</tr>
				<?php
			}									
		?>
		<tfoot>
			<tr class='budget-total'>
				<td>Total:</td>
				<?php
				foreach ($arrPCBreakdown as $account=>$pcData){	
					?>
					<td class='budget-decimal'><?php Reports::render($arrColTotal[$account]);?></td>					
					<?php
				}
				?>
				<td class='budget-decimal'><?php Reports::render(array_sum($arrColTotal));?></td>														
			</tr>
		</tfoot>
	</tbody>
	</table>
	<?php
	Reports::_echoButtonCopyTable($strTableID);

?>
<hr/>

<h2>RHQ report format FY2019</h2>	
<?php

$oReport = new Reports(Array('budget_scenario'=>$budget_scenario));
$oReport->salesRHQ("WHERE scenario='{$budget_scenario}' AND company='{$company}'");

include ('includes/inc-frame_bottom.php');

function error_distribution($params){
	GLOBAL $arrProfit;
	echo '<pre>','Error for PC ',$arrProfit[$params['data']['pc']]['pccTitle'], " ({$params['data']['pc']})"," cannot distribute {$params['reportKey']} in {$params['month']} ({$params['data'][$params['month']]})" ,'</pre>';
	echo '<pre>',$params['sql'],'</pre>';
}

function distribute($reportKey, $sql){
	GLOBAL $oSQL, $oBudget;	
	GLOBAl $startMonth, $endMonth;
	GLOBAl $arrReport;
	GLOBAL $arrGrandTotal;
	GLOBAL $arrRatio,$arrGHQSubtotal,$arrRevenue;
	GLOBAL $arrBreakDown, $sqlFields, $sqlGroupBy;	
	
	$rs = $oSQL->q($sql);
	while ($rw = $oSQL->f($rs)){
	
		if (($rw['pc']==9 || $rw['pc']==130) && $reportKey=='Corporate costs'){
			$key = 'General costs';
		} else {
			$key = $reportKey;
		}
		
		$accKey = getAccountAlias($rw['account']);
			
		for($m=$startMonth;$m<=$endMonth;$m++){
			$month = $oBudget->arrPeriod[$m];
			if ($rw[$month]!=0){
				if ($rw['prtGHQ']){
					$arrReport[$rw['prtGHQ']][$key][$month] += $rw[$month];
					$arrBreakDown[$key][$accKey][$rw['prtGHQ']] += $rw[$month];
				} else {
					if (!is_array($arrRatio[$rw['pc']])) {
						if ($rw['pccFlagProd']){
							error_distribution(Array('data'=>$rw,'reportKey'=>$key,'month'=>$month, 'sql'=>$sql));
						} else {
							foreach($arrGHQSubtotal as $ghq=>$revenue){
								$arrReport[$ghq][$key][$month] += $rw[$month]*$revenue[$month]/$arrRevenue[$month];
								$arrBreakDown[$key][$accKey][$ghq] += $rw[$month]*$revenue[$month]/$arrRevenue[$month];
							}
						}
					} else {
						foreach($arrRatio[$rw['pc']] as $ghq=>$ratios){
							$arrReport[$ghq][$key][$month] += $rw[$month]*$ratios[$month];
							$arrBreakDown[$key][$accKey][$ghq] += $rw[$month]*$ratios[$month];
						}
					}
				}
				$arrGrandTotal[$key][$month] += $rw[$month];
			} else {
				//skip;
			} 
		}
	}
}

function getBreakdown($arrData, $arrReport){
	
	GLOBAL $oBudget;
	
	foreach ($arrData as $group=>$accounts){
	$arrColTotal = Array();
	$nControlTotal = 0;

	echo '<h3>',$group,'</h3>';
	$strTableID = urlencode($group);
	?>
	<table class='budget' id='<?php echo $strTableID;?>'>
	<caption><?php echo $group,", ",$oBudget->title;?></caption>
	<thead>
		<tr>
			<th>Activity</th>
			<?php
			foreach ($accounts as $account=>$ghq){
				echo '<th>',$account,'</th>';
			}
			?>
			<th class="budget-ytd">Total</th>
			<th>Control</th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach ($arrReport as $ghq=>$values){
				$rowTotal = 0;
				?>
				<tr>
				<td><?php echo ($ghq?$ghq:'[None]');?></td>
				<?php				
				foreach ($accounts as $account=>$products){					
					$rowTotal += $products[$ghq];
					$arrColTotal[$account] += $products[$ghq];
					?>
					<td class="budget-decimal"><?php Reports::render(-$products[$ghq]);?></td>
					<?php
				}
				
				$nControlTotal += is_array($arrReport[$ghq][$group])?array_sum($arrReport[$ghq][$group]):0;
				
				echo '<td class="budget-ytd budget-decimal">',Reports::render(-$rowTotal),'</td>';
				echo '<td class="budget-decimal">',is_array($arrReport[$ghq][$group])?Reports::render(-array_sum($arrReport[$ghq][$group])):'n/a','</td>';
				?>
				</tr>
				<?php
			}									
		?>
		<tfoot>
			<tr class='budget-total'>
				<td>Total:</td>
				<?php
				foreach ($accounts as $account=>$products){	
					?>
					<td class='budget-decimal'><?php Reports::render(-$arrColTotal[$account]);?></td>					
					<?php
				}
				?>
				<td class='budget-decimal'><?php Reports::render(-array_sum($arrColTotal));?></td>										
				<td class='budget-decimal'><?php Reports::render(-($nControlTotal));?></td>										
			</tr>
		</tfoot>
	</tbody>
	</table>
	<?php
	Reports::_echoButtonCopyTable($strTableID);
}
}

function getAccountAlias($account){
	switch($account){
			case 'J00801':
			case 'J45110':
			case 'J45120':
			case 'J45140':
				$accKey = 'Labor costs';
				break;
			case 'J0080W':
			case 'J45550':
				$accKey = 'Warehouse costs';
				break;
			case 'J00806':
			case '512000':
			case 'J45560':
				$accKey = 'Depreciation';
				break;
			case '502000':
			case '505000':
			case '506000':
				$accKey = 'Personal expenses';
				break;
			case '514000':
			case '515000':
			case '519000':
			case '525000':
				$accKey = 'Office cost';
				break;
			case '527000':
				$accKey = 'MSF';
				break;
			case '5999CO':
			case '5999BD':
				$accKey = 'Int.distr';
				break;
			default:
				$accKey = 'Other costs';
				break;			
		}
	return ($accKey);
}

function getOtherAccountAlias($account){
	switch($account){
			case '502000':
			case '505000':
			case '506000':
			case 'J00801':
			case 'J45110':
			case 'J45120':
			case 'J45140':
				$accKey = 'Personel';
				break;
			case '5999CO':
			case '5999BD':
				$accKey = 'Int.distr';
				break;
			default:
				$accKey = 'Other';
				break;			
		}
	return ($accKey);
}

?>