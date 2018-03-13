<?php
// $flagNoAuth =true;
require ('common/auth.php');

if ($_GET['tab']){
	$budget_scenario = $_GET['tab'];
	?>
<button onclick="repost('<?php echo $_GET['tab']; ?>', event);">Repost documents</button>
<div/>

	<?php
	require ('classes/reports.class.php');
	$sql = "SELECT *, edit_date as timestamp FROM vw_journal 				
		LEFT JOIN stbl_user ON usrID=vw_journal.edit_by				
		WHERE vw_journal.scenario='{$budget_scenario}' 
		AND prefix IN ('msf')
		GROUP BY vw_journal.guid
		ORDER BY vw_journal.edit_date ASC";	

		$rs =$oSQL->q($sql);
		while ($rw=$oSQL->f($rs)){
			$data[] = $rw;
		}
		
		echo "<div id='div_{$budget_scenario}'>";
		Reports::getJournalEntries($data);
		echo '</div>';
		?>
		<nav>
		<a href="rep_totals.php?<?php echo $strQuery;?>&budget_scenario=<?php echo $budget_scenario;?>&bu_group=000000014">Results per BU</a>
		</nav>
		<?php
} else {
	require ('classes/budget.class.php');
	$arrJS[] = 'js/journal.js';		
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],'</h1>';
	echo Budget::getScenarioTabs(true);
	include ('includes/inc-frame_bottom.php');
}
?>