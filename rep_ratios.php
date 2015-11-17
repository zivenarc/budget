<?php
// $flagNoAuth =true;
require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/item.class.php');

$budget_scenario = isset($_GET['budget_scenario'])?$_GET['budget_scenario']:$budget_scenario;
$oBudget = new Budget($budget_scenario);

// $startMonth = date('n',$oBudget->date_start);
$startMonth = 1;

if($_GET['DataAction']=='update'){
	$sql = Array();
	$sql[] = "DELETE FROM reg_profit_ghq WHERE scenario = '$budget_scenario'";
	$sql[] = "INSERT INTO reg_profit_ghq
				SELECT scenario, pc, prtGHQ, ".$oBudget->getMonthlySumSQL(1,15).", SUM(`estimate`) as estimate
				FROM reg_master
				LEFT JOIN vw_product_type ON prtID = activity
				##WHERE item =  '".Items::REVENUE."'
				WHERE account='J00400'
				AND scenario =  '$budget_scenario' AND source NOT IN ('Estimate')##,'Actual')
				GROUP BY pc, prtGHQ";
	for ($i=0;$i<count($sql);$i++){
		// echo '<pre>',$sql[$i],'</pre>';
		$oSQL->q($sql[$i]);
	}
	
	redirect($_SERVER['PHP_SELF']."?budget_scenario={$budget_scenario}");
	die();
	
}

if (!isset($_GET['tab'])){
	
	$arrJS[] = 'js/rep_pnl.js';
	$arrActions[] = Array ('title'=>'Refresh','action'=>$_SERVER['PHP_SELF']."?DataAction=update&budget_scenario={$budget_scenario}",'class'=>'calculator');
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],'::',$oBudget->title,'</h1>';
		?>
	<div class='f-row'><label for='budget_scenario'>Select scenario</label><?php echo $oBudget->getScenarioSelect();?></div>
	<?php
	
	?>
	<div id='tabs'>
		<ul>
			<li><a href='<?php echo $_SERVER['PHP_SELF'];?>?budget_scenario=<?php echo $budget_scenario;?>&tab=activity'>Activity</a></li>
			<li><a href='<?php echo $_SERVER['PHP_SELF'];?>?budget_scenario=<?php echo $budget_scenario;?>&tab=pc'>PC</a></li>
		</ul>
	</div>
	<?php
	include ('includes/inc-frame_bottom.php');
} else {
	?>
	<script>		
		($('.budget-monthly').show())();	
	</script>
	<?php
	switch($_GET['tab']){
		case 'activity':
			$sql = "SELECT *, ".$oBudget->getYTDSQL()." FROM reg_profit_ghq 
					LEFT JOIN vw_profit ON pccID=pc
					WHERE scenario='$budget_scenario' 
					order by prtGHQ, `dec` DESC";
					
			$rs =$oSQL->q($sql);
			?>
			<table id='report_<?php echo $_GET['tab'];?>' class='budget'>
			<thead>
				<tr>
					<th>Activity</th>
					<th>PC</th>
					<?php
					echo $oBudget->getTableHeader('monthly',$startMonth);
					?>
					<th>Total</th>
				</tr>
			</thead>
			<tbody>
			<?php
			while ($rw=$oSQL->f($rs)){	
				for ($m=$startMonth;$m<13;$m++) {
					$month = strtolower(date('M',mktime(0,0,0,$m,15)));
					$arrGHQ[$rw['prtGHQ']][$rw['pccTitle']][$month] = $rw[$month];
					$arrSubtotal[$rw['prtGHQ']][$month] += $rw[$month];
					$arrGrandTotal[$month] += $rw[$month];
					if ($arrGrandTotal[$month]) {
						$arrRatio[$rw['prtGHQ']][$month] = $arrSubtotal[$rw['prtGHQ']][$month]/$arrGrandTotal[$month]*100;
					}
				}
			}

			foreach ($arrGHQ as $ghq=>$arrPC){
				
				for ($m=$startMonth;$m<13;$m++) {
					$month = strtolower(date('M',mktime(0,0,0,$m,15)));
					if ($arrGrandTotal[$month]) {
							$arrRatio[$ghq][$month] = $arrSubtotal[$ghq][$month]/$arrGrandTotal[$month]*100;
					}
				}

				echo '<tr>';
				echo "<td rowspan='".count($arrPC)."'>",$ghq,'</td>';
				$trOpen = true;
				foreach ($arrPC as $pc=>$values){
					// echo "<pre>";print_r($values);echo '</pre>';
					if (!$trOpen) {
						echo '<tr>';
					}
					echo '<td>',$pc,'</td>';
					echoMonthlyTR($values);
					echo "</tr>";
					$trOpen = false;
				}	
				echo '<tr class="budget-subtotal">';
				echo '<td colspan="2">Subtotal ',$ghq,'</td>';
				echoMonthlyTR($arrSubtotal[$ghq]);
				echo '</tr>';
				
				$arrRatio[$ghq]['YTD'] = array_sum($arrSubtotal[$ghq])/array_sum($arrGrandTotal)*100;
				
				echo '<tr class="budget-ratio">';
				echo '<td colspan="2">Weight ',$ghq,'</td>';
				echoMonthlyTR($arrRatio[$ghq],'',1);
				echo '</tr>';
			}
			echo '<tr class="budget-subtotal">';
			echo '<td colspan="2">Grand total</td>';
			echoMonthlyTR($arrGrandTotal);
			echo '</tr>';
			?>
			</tbody>
			</table>
			<ul class='link-footer'>
				<li><a href='javascript:SelectContent("report_<?php echo $_GET['tab'];?>");'>Select table</a></li>
			</ul>
			<?php
			break;
			case 'pc':
				$sql = "SELECT *, ".$oBudget->getYTDSQL()." FROM reg_profit_ghq 
					LEFT JOIN vw_profit ON pccID=pc
					WHERE scenario='$budget_scenario' 
					order by pc, `dec` DESC";
					
			$rs =$oSQL->q($sql);
			?>
			<table id='report_<?php echo $_GET['tab'];?>' class='budget'>
			<thead>
				<tr>
					<th>PC</th>
					<th>Activity</th>
					<?php
					echo $oBudget->getTableHeader('monthly',$startMonth);
					?>
					<th>Total</th>
				</tr>
			</thead>
			<tbody>
			<?php
			while ($rw=$oSQL->f($rs)){	
				for ($m=$startMonth;$m<13;$m++) {
					$month = strtolower(date('M',mktime(0,0,0,$m,15)));
					$arrPC[$rw['pccTitle']][$rw['prtGHQ']][$month] = $rw[$month];
					$arrSubtotal[$rw['pccTitle']][$month] += $rw[$month];
					$arrGrandTotal[$month] += $rw[$month];
					if ($arrGrandTotal[$month]) {
						$arrRatio[$rw['pccTitle']][$month] = $arrSubtotal[$rw['pccTitle']][$month]/$arrGrandTotal[$month]*100;
					}
				}
			}

			foreach ($arrPC as $pc=>$arrGHQ){
				
				for ($m=$startMonth;$m<13;$m++) {
					$month = strtolower(date('M',mktime(0,0,0,$m,15)));
					if ($arrGrandTotal[$month]) {
							$arrRatio[$pc][$month] = $arrSubtotal[$pc][$month]/$arrGrandTotal[$month]*100;
					}
				}

				echo '<tr>';
				echo "<td rowspan='".count($arrGHQ)."'>",$pc,'</td>';
				$trOpen = true;
				foreach ($arrGHQ as $ghq=>$values){
					// echo "<pre>";print_r($values);echo '</pre>';
					if (!$trOpen) {
						echo '<tr>';
					}
					echo '<td>',$ghq,'</td>';
					echoMonthlyTR($values);
					echo "</tr>";
					$trOpen = false;
				}	
				echo '<tr class="budget-subtotal">';
				echo '<td colspan="2">Subtotal ',$pc,'</td>';
				echoMonthlyTR($arrSubtotal[$pc]);
				echo '</tr>';
				
				$arrRatio[$pc]['YTD'] = array_sum($arrSubtotal[$pc])/array_sum($arrGrandTotal)*100;
				
				echo '<tr class="budget-ratio">';
				echo '<td colspan="2">Weight ',$pc,'</td>';
				echoMonthlyTR($arrRatio[$pc],'',1);
				echo '</tr>';
			}
			echo '<tr class="budget-subtotal">';
			echo '<td colspan="2">Grand total</td>';
			echoMonthlyTR($arrGrandTotal);
			echo '</tr>';
			?>
			</tbody>
			</table>
			<ul class='link-footer'>
				<li><a href='javascript:SelectContent("report_<?php echo $_GET['tab'];?>");'>Select table</a></li>
			</ul>
			<?php
			break;
	}
}

function echoMonthlyTR($data,$class='', $decimal_places=0){

	GLOBAL $startMonth;

	for ($m=$startMonth;$m<13;$m++) {
			$month = strtolower(date('M',mktime(0,0,0,$m,15)));
			echo '<td class="budget-decimal">',number_format($data[$month],$decimal_places,'.',','),'</td>';
	}
	echo '<td class="budget-decimal budget-ytd">',number_format(isset($data['YTD'])?$data['YTD']:array_sum($data),$decimal_places,'.',','),'</td>';	
}




?>