<?php
// $flagNoAuth =true;
require ('common/auth.php');


$ownerID = isset($_GET['ownerID'])?$_GET['ownerID']:($_COOKIE['ownerID']?$_COOKIE['ownerID']:$arrUsrData['usrID']);
if ($_GET['ownerID']=='MYSELF'){
	$ownerID = $arrUsrData['usrID'];
}
SetCookie('ownerID',$ownerID,0);


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
		WHERE vw_journal.scenario='{$_GET['tab']}' 
		AND responsible=".$oSQL->e($ownerID)."
		GROUP BY vw_journal.guid
		ORDER BY vw_journal.edit_date ASC";	

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

	
	$sql = "SELECT * FROM stbl_user WHERE usrID=".$oSQL->e($ownerID);
	$rs = $oSQL->q($sql);
	$rw = $oSQL->f($rs);
	$arrUsrData["pagTitle$strLocal"] .= ' :: '.($rw['usrTitle']?$rw['usrTitle']:'<Unknown>');
	
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],'</h1>';
	echo Budget::getScenarioTabs(true);
	include ('includes/inc-frame_bottom.php');
}
?>