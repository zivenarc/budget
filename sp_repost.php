<?php
$flagNoAuth =true;
require ('common/auth.php');

if ($_GET['tab']){
	
	?>
<button onclick="repost('<?php echo $_GET['tab']; ?>', event);">Repost documents</button>
<div/>

	<?php
	require ('classes/reports.class.php');
	$sql = "SELECT vw_journal.*, stbl_user.*, vw_profit.*, vw_location.*,  edit_date as timestamp FROM vw_journal 				
		LEFT JOIN stbl_user ON usrID=vw_journal.edit_by		
		LEFT JOIN vw_profit ON pccID=vw_journal.pc
		LEFT JOIN vw_location ON locID=vw_journal.pc
		##WHERE vw_journal.posted=1 AND vw_journal.scenario='{$_GET['tab']}' 
		WHERE  vw_journal.deleted=0 vw_journal.scenario='{$_GET['tab']}' 
		AND guid IN (SELECT DISTINCT source FROM reg_sales WHERE selling_curr<>'RUB' OR buying_curr<>'RUB' 
						UNION ALL 
					SELECT DISTINCT source FROM reg_costs WHERE buying_curr<>'RUB')
		GROUP BY vw_journal.guid
		##ORDER BY vw_journal.edit_date ASC";	

		$rs =$oSQL->q($sql);
		while ($rw=$oSQL->f($rs)){
			$data[] = $rw;
		}
		
		echo "<div id='div_{$_GET['tab']}'>";
		Reports::getJournalEntries($data);
		echo '</div>';
		
	
} else {
	require ('classes/budget.class.php');
	$arrJS[] = 'js/journal.js';		
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],'</h1>';
	echo Budget::getScenarioTabs(true);
	include ('includes/inc-frame_bottom.php');
}
?>