<?php
// $flagNoAuth = true;
require ('common/auth.php');
require ('classes/reference.class.php');
require ('classes/item.class.php');
require ('classes/budget.class.php');
require ('classes/reports.class.php');

include ('includes/inc_report_settings.php');
$oBudget = new Budget($budget_scenario);

$arrRates = $oBudget->getMonthlyRates($currency);

$arrKeys = Array();
$arrReport = Array('Air export'=>$arrKeys,'Air import'=>$arrKeys,'Ocean export'=>$arrKeys,'Ocean import'=>$arrKeys,'OCM'=>$arrKeys,'Warehouse'=>$arrKeys,'Land transport'=>$arrKeys);

$arrJS[] = 'js/rep_totals.js';

$sql = "SELECT DISTINCT pc, Profit FROM vw_master WHERE scenario='{$budget_scenario}' ORDER BY pccFlagProd";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	$arrProfit[$rw['pc']] = $rw;
}

// $startMonth = date('n',$oBudget->date_start);
$arrActions[] = Array('title'=>'Jan-Mar', 'action'=>'?mthStart=1&mthEnd=3');
$arrActions[] = Array('title'=>'Jan-Dec', 'action'=>'?mthStart=1&mthEnd=12');
$arrActions[] = Array('title'=>'Apr-Mar', 'action'=>'?mthStart=4&mthEnd=15');
$arrActions[] = Array('title'=>'Jan-Mar', 'action'=>'?mthStart=1&mthEnd=15');
$startMonth = isset($_GET['mthStart'])?$_GET['mthStart']:1+$oBudget->offset;
$endMonth = isset($_GET['mthEnd'])?$_GET['mthEnd']:12+$oBudget->offset;
$colspan = $endMonth - $startMonth + 3;


// $sql = "SELECT pc, prtGHQ, ".$oBudget->getMonthlySumSQL($startMonth,$endMonth, $arrRates)." 
		// FROM reg_profit_ghq 
		// WHERE scenario='$budget_scenario' AND company='{$company}'
		// GROUP BY prtGHQ, pc";
// $rs = $oSQL->q($sql);
// if(!$oSQL->n($rs)){
	// die("<div class='error'>No base for cost distribution. Prepare the <a href='rep_ratios.php?budget_scenario={$budget_scenario}&DataAction=update'>revenue register</a> first</div>");
// }

while ($rw = $oSQL->f($rs)){
	for($m=$startMonth;$m<=$endMonth;$m++){
		$month = $oBudget->arrPeriod[$m];
		$arrPC[$rw['pc']][$rw['prtGHQ']][$month] += $rw[$month];
		$arrSubtotal[$rw['pc']][$month] += $rw[$month];
		$arrGHQSubtotal[$rw['prtGHQ']][$month] += $rw[$month];
		$arrRevenue[$month] += $rw[$month];
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

// echo '<pre>';print_r($arrRatio);echo '</pre>';

$sqlFields = "account, title, prtGHQ, pc, pccFlagProd, Profit, 
				SUM(".$oBudget->getYTDSQL($startMonth,$endMonth, $arrRates).") as Total, 				
				".$oBudget->getMonthlySumSQL($startMonth,$endMonth, $arrRates);
$sqlGroupBy = "account, pc, prtGHQ";

$sqlWhere = "WHERE scenario='{$budget_scenario}' 
			AND company='{$company}' 
			AND source<>'Estimate'";
			// AND pccFlagProd=1 ";

			
$arrRevenueFilter = Array(
	Items::REVENUE,
	Items::INTERCOMPANY_REVENUE
);



$arrAccounts = Array(
		'Revenue'=>Array('sql'=>"SELECT $sqlFields FROM vw_master 
							{$sqlWhere} 
								AND item in ('".implode("','",$arrRevenueFilter)."') 			
							GROUP by {$sqlGroupBy}",'subtotal'=>Array('Gross profit','Gross operating profit','Net operating profit','PBT')),
		'Direct costs'=>Array('negative'=>true, 'sql'=>"SELECT {$sqlFields} FROM vw_master 
								{$sqlWhere}  
									AND account IN ('J00802') AND pccFlagProd=1 AND item<>'".Reports::REVENUE_ITEM."'
								GROUP BY {$sqlGroupBy}",'subtotal'=>Array('Gross profit','Gross operating profit','Net operating profit','PBT')),
		'Gross profit'=>Array('class'=>'budget-subtotal'),
		'Reclassified fixed costs'=>Array('negative'=>true,'breakdown'=>true,'sql'=>"SELECT {$sqlFields} FROM vw_master 
									{$sqlWhere} 
										AND account IN ('J00801','J00803','J00804','J00805','J00806','J00808','J0080W') AND pccFlagProd=1			
									GROUP by {$sqlGroupBy}
									ORDER by account",'subtotal'=>Array('Gross operating profit','Net operating profit','PBT')),
		'Gross operating profit'=>Array('class'=>'budget-subtotal'),
		'General costs'=>Array('negative'=>true,'breakdown'=>true,'sql'=>"SELECT $sqlFields FROM vw_master 
								{$sqlWhere}  
									AND account LIKE '5%' AND account<>'5999CO'			
								GROUP by {$sqlGroupBy}
								ORDER BY account",'subtotal'=>Array('Net operating profit','PBT')),
		'Corporate costs'=>Array('negative'=>true,'breakdown'=>true,'sql'=>"SELECT $sqlFields FROM vw_master 
								{$sqlWhere} 
									AND account='5999CO'  			
								GROUP by {$sqlGroupBy}
								ORDER BY account",'subtotal'=>Array('Net operating profit','PBT')),
		'Net operating profit'=>Array('class'=>'budget-subtotal'),
		'Non-operating income'=>Array('sql'=>"SELECT $sqlFields FROM vw_master 
								{$sqlWhere} 
									AND (account like '60%') AND account<>'607000'			
								GROUP by pc, prtGHQ",'subtotal'=>Array('PBT')),
		'Non-operating costs'=>Array('negative'=>true,'sql'=>"SELECT $sqlFields FROM vw_master 
								{$sqlWhere} 
									AND (account like '65%' or account like '66%')			
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
			$arrPC[$rw['prtGHQ']][] = $rw['Profit'];
			if($rw['pccFlagProd']){
				for($m=$startMonth;$m<=$endMonth;$m++){
					$month = $oBudget->arrPeriod[$m];
					$arrReport[$rw['prtGHQ']][$reportKey]['monthly'][$month] += $rw[$month]*($settings['negative']?-1:1);
					$arrReport[$rw['prtGHQ']][$reportKey]['pc'][$rw['Profit']] += $rw[$month]*($settings['negative']?-1:1);
					for($i=0;$i<count($settings['subtotal']);$i++){
						$arrReport[$rw['prtGHQ']][$settings['subtotal'][$i]]['monthly'][$month] += $rw[$month];
						$arrReport[$rw['prtGHQ']][$settings['subtotal'][$i]]['pc'][$rw['Profit']] += $rw[$month];
						$arrGrandTotal[$settings['subtotal'][$i]]['monthly'][$month] += $rw[$month];
					};
					$arrGrandTotal[$reportKey]['monthly'][$month] += $rw[$month];
				
					if($settings['breakdown']){
						$accKey = getAccountAlias($rw['account']);
						$arrBreakDown[$reportKey][$accKey][$rw['prtGHQ']] += $rw[$month];
					}		
			
				}
			} else {
				$arrGrandTotal[$reportKey]['monthly'][$month] += $rw[$month];
			}
			

		}
	}
}

// echo '<pre>';print_r($arrBreakDown);echo '</pre>';

$reportKey = 'Extraordinary income';
$sql = "SELECT $sqlFields FROM vw_master 
		WHERE scenario='$budget_scenario' AND company='{$company}' AND source<>'Estimate' AND (account like '70%')
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
$sql = "SELECT $sqlFields FROM vw_master 
		WHERE scenario='$budget_scenario' AND company='{$company}' AND source<>'Estimate' AND (account like '75%' or account like '76%') 
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
$sql = "SELECT $sqlFields FROM vw_master 
		WHERE scenario='$budget_scenario' AND company='{$company}' AND source<>'Estimate' AND IFNULL(account,'') LIKE '' 
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
$sql = "SELECT $sqlFields FROM vw_master 
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
</tbody>
</table>
</div>
<ul class='link-footer'>
	<li><a href='javascript:SelectContent("report");'>Select all</a></li>
</ul>

<h2>Activity ratios</h2>
<table class='budget' style='width:auto;'>
<thead>
<tr>
<?php
foreach($arrGHQSubtotal as $ghq=>$revenue){
	echo '<th>',($ghq?$ghq:'[None]'),'</th>';
}
?>
	<th>Total</th>
</tr>
</thead>
<tbody>
<tr>
<?php
	foreach($arrGHQSubtotal as $ghq=>$revenue){
		?>
		<td><?php Reports::render_ratio(array_sum($revenue),array_sum($arrRevenue));?></td>
		<?php
	}
?>
<td>100</td>
</tr>
</tbody>
</table>

<h1>Additional info</h1>
<?php
foreach ($arrBreakDown as $group=>$accounts){
	$arrColTotal = Array();
	$nControlTotal = 0;

	echo '<h3>',$group,'</h3>';
	$strTableID = urlencode($group);
	?>
	<table class='budget' id='<?php echo $strTableID;?>'>
	<thead>
		<tr>
			<th>Activity</th>
			<?php
			foreach ($accounts as $account=>$ghq){
				echo '<th>',$account,'</th>';
			}
			?>
			<th>Total</th>
			<th>Control</th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach ($arrReport as $ghq=>$values){
				$rowTotal = 0;
				?>
				<tr>
				<th><?php echo ($ghq?$ghq:'[None]');?></th>
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
				echo '<td class="budget-ytd budget-decimal">',is_array($arrReport[$ghq][$group])?Reports::render(-array_sum($arrReport[$ghq][$group])):'n/a','</td>';
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
	<ul class='link-footer'>
		<li><a href='javascript:SelectContent("<?php echo $strTableID;?>");'>Select table</a></li>
	</ul>
	<?php
}

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
	
		switch($rw['account']){
			case 'J00801':
				$accKey = 'Labor costs';
				break;
			case 'J0080W':
				$accKey = 'Warehouse costs';
				break;
			case 'J00806':
			case '512000':
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
			
			default:
				$accKey = 'Other costs';
				break;			
		}
	
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

function getAccountAlias($account){
	switch($account){
			case 'J00801':
				$accKey = 'Labor costs';
				break;
			case 'J0080W':
				$accKey = 'Warehouse costs';
				break;
			case 'J00806':
			case '512000':
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
			case '5999CO':
			case '5999BD':
				return (false);
				break;
			default:
				$accKey = 'Other costs';
				break;			
		}
	return ($accKey);
}
?>