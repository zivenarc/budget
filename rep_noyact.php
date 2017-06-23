<?php
// $flagNoAuth =true;
require ('common/auth.php');

if ($_GET['tab']){
	
	require ('classes/reports.class.php');
	$sql = "SELECT *, edit_date as timestamp FROM vw_master 		
		LEFT JOIN vw_journal ON source=guid
		LEFT JOIN stbl_user ON usrID=edit_by		
		WHERE posted=1 AND vw_master.scenario='{$_GET['tab']}' AND company='{$company}'
		AND (IFNULL(account,'') = '' OR IFNULL(item,'')='')
		GROUP BY guid
		ORDER BY vw_master.timestamp DESC";	

		$rs =$oSQL->q($sql);
		while ($rw=$oSQL->f($rs)){
			$data[] = $rw;
		}
		?>
		<h3>Missing YACT or Account</h3>
		<button onclick="repost('<?php echo $_GET['tab']; ?>', event);">Repost documents</button>
		<div id='div_<?php echo $_GET['tab'];?>'>
		<?php
		Reports::getJournalEntries($data);
		?>
		</div>
		<?php
		
		$data = Array();
		
		$sql = "SELECT *, edit_date as timestamp FROM vw_master 		
		LEFT JOIN vw_journal ON source=guid
		LEFT JOIN stbl_user ON usrID=edit_by		
		WHERE posted=1 AND vw_master.scenario='{$_GET['tab']}' AND company='{$company}'
			AND IFNULL(vw_master.pc,0) = 0
		GROUP BY guid
		ORDER BY vw_master.timestamp DESC";	

		$rs =$oSQL->q($sql);
		while ($rw=$oSQL->f($rs)){
			$data[] = $rw;
		}
		?>
		<h3>Missing PC</h3>
		<?php
		Reports::getJournalEntries($data);
		
		$data = Array();
		
		$sql = "SELECT yctID,yctTitle FROM vw_yact WHERE yctID LIKE 'J%'";
		$rs = $oSQL->q($sql);
		while ($rw = $oSQL->f($rs)){
			$arrYact['code'][] = $rw['yctID'];			
			$arrYact['title'][] = $rw['yctTitle'];			
		}
		$strAccounts = "'".implode("','",$arrYact['code'])."'";
		
		$sql = "SELECT *, edit_date as timestamp FROM vw_master 		
		LEFT JOIN vw_journal ON source=guid
		LEFT JOIN stbl_user ON usrID=edit_by		
		WHERE posted=1 AND vw_master.scenario='{$_GET['tab']}' AND company='{$company}'
			##AND IFNULL(vw_master.activity,'') = '' 
			AND IFNULL(prtGHQ,'')=''
			AND account IN ({$strAccounts})
		GROUP BY guid
		ORDER BY vw_master.timestamp DESC";	

		// echo '<pre>',$sql,'</pre>';
		$rs =$oSQL->q($sql);
		while ($rw=$oSQL->f($rs)){
			$data[] = $rw;
		}
		?>
		<h3>Missing Activity</h3>
		<p><?php echo implode(", ",$arrYact['title']);?></p>
		<?php
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