<?php
//$flagNoAuth=true;
require ('common/auth.php');

if ($_GET['tab']){
	
	?>
<div>
	<button onclick="repost('<?php echo $_GET['tab']; ?>', event);">Repost documents</button>
	<button onclick="fill('<?php echo $_GET['tab']; ?>', event);">Fill data</button>
<div/>

	<?php
	require ('classes/reports.class.php');
	
	$oBudget = new Budget($_GET['tab']);
	
	$sql = "SELECT vw_journal.*, edit_date as timestamp, prtTitle, vw_yact.yctTitle, yctID, itmTitle
		FROM vw_journal 				
			LEFT JOIN tbl_rent ON rntGUID=guid
			LEFT JOIN stbl_user ON usrID=vw_journal.edit_by			
			LEFT JOIN vw_product_type ON rntActivityID=prtID
			LEFT JOIN vw_yact ON rntYact=yctID
			LEFT JOIN vw_item ON rntItemGUID=itmGUID
		WHERE vw_journal.scenario='{$_GET['tab']}' 
		AND prefix IN ('rnt')
		GROUP BY vw_journal.guid
		ORDER BY vw_journal.edit_date ASC";	

		$rs =$oSQL->q($sql);
		while ($rw=$oSQL->f($rs)){
			$rw['comment'] = "[{$rw['prtTitle']} | ".($rw['yctID']?$rw['yctID']:'All YACT')." | ".($rw['itmTitle']?$rw['itmTitle']:"All costs")."] {$rw['comment']}";
			$data[] = $rw;
		}
		
		echo "<div id='div_{$_GET['tab']}'>";
		Reports::getJournalEntries($data);
		echo '</div>';
		
	//--------------------- Control report ----------------------
	$sql = "SELECT account, pc, pccTitle, activity, prtTitle, 
				SUM(".$oBudget->getThisYTDSQL('ytd').") as ytd, 
				SUM(".$oBudget->getThisYTDSQL('roy').") as roy
			FROM reg_master
			LEFT JOIN common_db.tbl_profit ON pccID=pc
			LEFT JOIN common_db.tbl_product_type ON prtID=activity		
			WHERE scenario='{$oBudget->id}' 
				AND customer=0
				AND account LIKE 'J%'
				AND company='{$company}'
			GROUP BY activity, pc, account
			ORDER BY prtGHQ";		
			
	$rs = $oSQL->q($sql);
	while ($rw = $oSQL->f($rs)){
		$account = in_array($rw['account'],['J00802','J45010','J45030'])?'DC':'RFC';
		// $arrReport[$account][$rw['activity']][$rw['pc']]['YTD'] += $rw['YTD'];
		$arrReport['ytd'][$account][$rw['activity']][$rw['pc']] += $rw['ytd'];
		$arrReport['roy'][$account][$rw['activity']][$rw['pc']] += $rw['roy'];
		$arrProduct[$rw['activity']] = $rw['prtTitle'];
		$arrProfit[$rw['pc']] = $rw['pccTitle'];
	}
	if (count($arrReport)){
	?>
	<h2>Undistributed costs</h2>
	<div class='tabs'>
	<ul>
		<li><a href='#ytd_<?php echo $_GET['tab'];?>'>YTD</a></li>
		<li><a href='#roy_<?php echo $_GET['tab'];?>'>ROY</a></li>
	</ul>
		<?php 
			getCostTable('ytd', $arrProfit,$arrProduct, $arrReport);
			getCostTable('roy', $arrProfit,$arrProduct, $arrReport);
		?>
	</div>
	<script>
		$('.tabs').tabs();
	</script>
	<?php
	}
	
} else {
	require ('classes/budget.class.php');
	$arrJS[] = 'js/journal.js';		
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],'</h1>';
	echo Budget::getScenarioTabs(true);
	include ('includes/inc-frame_bottom.php');
}


function getCostTable($type, $arrProfit,$arrProduct, $arrReport){
	?>
	<div id='<?php echo $type,'_',$_GET['tab'];?>'>
			<table class="budget">	
				<tr>
					<th>Unit/Activity</th>
					<?php foreach ($arrProfit as $pc=>$title){
						echo "<th>{$title}</th>\r\n";
					}?>
					<th class="budget-ytd">Total</th>
				</tr>
				<?php 
				if(count($arrReport[$type]['DC'])){ 
					$arrSubtotal = array();
				?>
				<tr><th colspan="<?php echo count($arrProfit)+2;?>">Direct costs</th></tr>
				<?php foreach ($arrReport[$type]['DC'] as $activity=>$pcData){					
					echo "<tr>";
					echo "<td>{$arrProduct[$activity]}</td>";
					foreach ($arrProfit as $pc=>$title){
						echo "<td class='budget-decimal'>",Reports::render($pcData[$pc]),"</td>";
					}
					echo "<td class='budget-decimal budget-ytd'>",Reports::render(array_sum($pcData)),"</td>";
					echo "</tr>";
				}
				?>
				<tr class="budget-subtotal">
					<td>Subtotal</td>
					<?php
					foreach ($arrProfit as $pc=>$title){
						echo "<td class='budget-decimal'>",Reports::render($arrSubtotal[$pc]),"</td>";
					}
					?>
					<td class='budget-decimal budget-ytd'><?php Reports::render(array_sum($arrSubtotal)); ?></td>					
				</tr>
				<?php 
				}
				
				if(count($arrReport[$type]['RFC'])){ 
				$arrSubtotal = array();
				?>
				<tr><th colspan="<?php echo count($arrProfit)+2;?>">RFC</th></tr>
				<?php foreach ($arrReport[$type]['RFC'] as $activity=>$pcData){
					echo "<tr>";
					echo "<td>{$arrProduct[$activity]}</td>";
					foreach ($arrProfit as $pc=>$title){
						echo "<td class='budget-decimal'>",Reports::render($pcData[$pc]),"</td>";
						$arrSubtotal[$pc] += $pcData[$pc];
					}
					echo "<td class='budget-decimal budget-ytd'>",Reports::render(array_sum($pcData)),"</td>";
					echo "</tr>";
				}
				?>
				<tr class="budget-subtotal">
					<td>Subtotal</td>
					<?php
					foreach ($arrProfit as $pc=>$title){
						echo "<td class='budget-decimal'>",Reports::render($arrSubtotal[$pc]),"</td>";
					}
					?>
					<td class='budget-decimal budget-ytd'><?php Reports::render(array_sum($arrSubtotal)); ?></td>
				</tr>
				<?php 
				}
				?>				
			</table>
	</div>
	<?php
}
?>