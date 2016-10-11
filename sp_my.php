<?php
// $flagNoAuth =true;
require ('common/auth.php');


$ownerID = isset($_GET['ownerID'])?$_GET['ownerID']:($_COOKIE['ownerID']?$_COOKIE['ownerID']:$arrUsrData['usrID']);
if ($_GET['ownerID']=='MYSELF'){
	$ownerID = $arrUsrData['usrID'];
}
SetCookie('ownerID',$ownerID,0);
$sqlWhere = " AND responsible=".$oSQL->e($ownerID);

$sql = "SELECT * FROM stbl_user WHERE usrID=".$oSQL->e($ownerID);
$rs = $oSQL->q($sql);
$rw = $oSQL->f($rs);
$arrUsrData["pagTitle$strLocal"] .= ' :: '.($rw['usrTitle']?$rw['usrTitle']:'<Unknown>');

if(isset($_GET['ownerID'])){
	SetCookie('pc',null);
	unset($pcfilter);
}

if(isset($_GET['pc'])){
	$pcfilter = isset($_GET['pc'])?$_GET['pc']:($_COOKIE['pc']?$_COOKIE['pc']:$arrUsrData['usrProfitID']);
	SetCookie('pc',$pcfilter,0);
	
	$sql = "SELECT * FROM vw_profit WHERE pccID=".$oSQL->e($pcfilter);
	$rs = $oSQL->q($sql);
	$rw = $oSQL->f($rs);
	$arrUsrData["pagTitle$strLocal"] .= ' :: '.($rw['pccTitle']?$rw['pccTitle']:'<Unknown PC>');
}

if ($_COOKIE['pc']){
	$pcfilter = $_COOKIE['pc'];
	$sqlWhere = " AND (guid IN (SELECT source FROM reg_master WHERE pc=".$oSQL->e($pcfilter).") OR pc=".$oSQL->e($pcfilter).")";
}

if ($_GET['tab']){
	
	?>
<button onclick="repost('<?php echo $_GET['tab']; ?>', event);">Repost documents</button>
<div/>

	<?php
	require ('classes/reports.class.php');
	$sql = "SELECT vw_journal.*, stbl_user.*, edit_date as timestamp FROM vw_journal 				
		LEFT JOIN stbl_user ON usrID=vw_journal.edit_by				
		WHERE vw_journal.scenario='{$_GET['tab']}' 
		{$sqlWhere}
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
	
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],'</h1>';
	echo Budget::getScenarioTabs(true);
	
	include ('includes/inc_subordinates.php');
	
	include ('includes/inc-frame_bottom.php');
}
?>