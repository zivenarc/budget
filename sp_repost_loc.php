<?php
// $flagNoAuth =true;
require ('common/auth.php');
require_once ('classes/reports.class.php');

if ($_GET['tab']){
	
	?>
<button onclick="repost('<?php echo $_GET['tab']; ?>', event);">Repost documents</button>
<div/>
	<?php	
	$oBudget = new Budget($_GET['tab']);
	
	$sql = "SELECT *,  edit_date as timestamp FROM vw_journal 				
		LEFT JOIN stbl_user ON usrID=vw_journal.edit_by				
		##WHERE vw_journal.posted=1 AND vw_journal.scenario='{$oBudget->id}' 
		WHERE vw_journal.scenario='{$oBudget->id}' 
		AND prefix IN ('lco')
		GROUP BY vw_journal.guid
		ORDER BY vw_journal.edit_date ASC";	

		$rs =$oSQL->q($sql);
		while ($rw=$oSQL->f($rs)){
			$data[] = $rw;
		}
		
		echo "<div id='div_{$_GET['tab']}'>";
		Reports::getJournalEntries($data);
		echo '</div>';
		
		
			$sql = "SELECT pccTitle, locTitle, SUM(".$oBudget->getThisYTDSQL('roy').")/".($oBudget->offset+12-$oBudget->cm)."  as FTE
					FROM `reg_headcount`
					LEFT JOIN common_db.tbl_profit ON pccID=pc
					LEFT JOIN common_db.tbl_location ON locID=location
					WHERE scenario='{$oBudget->id}'
					AND salary>10000 AND posted=1
					GROUP BY pc, location
					ORDER BY FTE DESC";
			// echo '<pre>',$sql,'</pre>';
			$rs = $oSQL->q($sql);
			while ($rw = $oSQL->f($rs)){
				$arrReport[$rw['pccTitle']][$rw['locTitle']] = $rw['FTE'];
				$arrLocation[] = $rw['locTitle'];
				$arrTotal[$rw['locTitle']] +=$rw['FTE'];				
			}
			$arrLocation = array_unique($arrLocation);
			?>
			<table id='location_report' class="budget">
				<caption>Headcount distribution, <?php echo $oBudget->title;?></caption>
				<tr>
					<th>Business unit/location</th>
					<?php foreach($arrLocation as $location){
						echo '<th>',$location,'</th>';
					} ?>
					<th>Total</th>
				</tr>
				<?php foreach($arrReport as $profit=>$data){
					?>
					<tr>
						<td><?php echo $profit;?></td>
						<?php foreach ($arrLocation as $location){
							?>
								<td class="budget-decimal"><?php Reports::render($data[$location],1);?></td>
							<?php
						} ?> 
							<td class="budget-decimal budget-ytd"><?php Reports::render(array_sum($data),1);?></td>
						</tr>
				<?php }?>
				<td>
				<tr class="budget-subtotal">
					<td>Total</td>
					<?php foreach ($arrLocation as $location){
							?>
								<td class="budget-decimal"><?php Reports::render($arrTotal[$location],1);?></td>
							<?php
					} ?> 
					<td class="budget-decimal budget-ytd"><?php Reports::render(array_sum($arrTotal),1);?></td>
				</tr>
			</table>
			<?php 
			Reports::_echoButtonCopyTable('location_report');
	
} else {
	//require ('classes/budget.class.php');
	$arrJS[] = 'js/journal.js';		
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],'</h1>';
	echo Budget::getScenarioTabs(true);
	include ('includes/inc-frame_bottom.php');
}
?>