<?php
// $flagNoAuth =true;
require ('common/auth.php');

if ($_GET['tab']){

	require ('classes/reports.class.php');
	$sql = "SELECT *, edit_date as timestamp FROM vw_journal 		
		LEFT JOIN stbl_user ON usrID=edit_by
		LEFT JOIN vw_profit ON pccID=pc
		LEFT JOIN vw_location ON locID=pc
		WHERE posted=1 AND scenario='{$_GET['tab']}' 
		GROUP BY guid
		ORDER BY timestamp DESC";	

		$rs =$oSQL->q($sql);
		while ($rw=$oSQL->f($rs)){
			$data[] = $rw;
		}
		Reports::getJournalEntries($data);
		
	
} else {
	require ('classes/budget.class.php');
	$arrJS[] = 'js/journal.js';
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],'</h1>';
	echo Budget::getScenarioTabs();
	include ('includes/inc-frame_bottom.php');
}
?>