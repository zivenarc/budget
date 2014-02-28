<?php
// $flagNoAuth =true;
require ('common/auth.php');

if ($_GET['tab']){

	require ('classes/reports.class.php');
	$sql = "SELECT *, edit_date as timestamp FROM vw_master 		
		LEFT JOIN vw_journal ON source=guid
		LEFT JOIN stbl_user ON usrID=edit_by
		LEFT JOIN vw_profit ON pccID=vw_master.pc
		##LEFT JOIN vw_location ON locID=vw_journal.pc	
		WHERE posted=1 AND vw_master.scenario='{$_GET['tab']}' AND IFNULL(account,'') = ''
		GROUP BY guid
		ORDER BY vw_master.timestamp DESC";	

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