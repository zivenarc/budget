<?php
$flagNoAuth =true;
require ('common/auth.php');

if ($_GET['tab']){
	
	?>
<div>
	<button onclick="repost('<?php echo $_GET['tab']; ?>', event);">Repost documents</button>
	<button onclick="fill('<?php echo $_GET['tab']; ?>', event);">Fill data</button>
<div/>

	<?php
	require ('classes/reports.class.php');
	$sql = "SELECT vw_journal.*, edit_date as timestamp, SUM(mar_1) as headcount 
		FROM vw_journal 				
		LEFT JOIN stbl_user ON usrID=vw_journal.edit_by	
		LEFT JOIN reg_headcount ON source=vw_journal.guid
		WHERE vw_journal.scenario='{$_GET['tab']}' 
		AND prefix IN ('cem','nem')
		GROUP BY vw_journal.guid
		ORDER BY vw_journal.edit_date ASC";	

		$rs =$oSQL->q($sql);
		while ($rw=$oSQL->f($rs)){
			$rw['comment'] = "[<span class='headcount'>{$rw['headcount']}</span>] {$rw['comment']}";
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