<?php
// $flagNoAuth =true;
require ('common/auth.php');

$itmGUID = isset($_GET['itmGUID'])?$_GET['itmGUID']:$_COOKIE['itmGUID'];
SetCookie('itmGUID',$itmGUID);

if ($_GET['tab']){
	
	?>
<button onclick="repost('<?php echo $_GET['tab']; ?>', event);">Repost documents</button>
<div/>

	<?php
	require ('classes/reports.class.php');
	
	$sql = "SELECT *,  edit_date as timestamp 
		FROM vw_journal 			
		LEFT JOIN stbl_user ON usrID=vw_journal.edit_by						
		WHERE vw_journal.scenario='{$_GET['tab']}' 
			AND guid IN (SELECT source FROM reg_master WHERE scenario='{$_GET['tab']}' AND item='{$itmGUID}' AND company='{$company}')
		GROUP BY vw_journal.guid
		ORDER BY vw_journal.edit_date ASC";	
		
		// echo '<pre>',$sql,'</pre>';
		
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
	$sql = "SELECT * FROM vw_item WHERE itmGUID='{$itmGUID}'";
	$rs = $oSQL->q($sql);
	if($oSQL->n($rs)){
		$rw = $oSQL->f($rs);
		echo '<h2>', $rw['itmTitle'], '</h2>';
	} else {
		echo "<h2>Item not {{$itmGUID}} found</h2>";
	}
	echo Budget::getScenarioTabs(true);
	$sql = "SELECT * FROM vw_item ORDER by itmParentId, itmTitle";
	$rs = $oSQL->q($sql);
	while ($rw = $oSQL->f($rs)){
		if($rw['itmFlagFolder']){
			echo "<h3>{$rw['itmTitle']}</h3>";
		} else {
			echo "<a href='?itmGUID={$rw['itmGUID']}'>{$rw['itmTitle']}</a> ";
		}
	}
	include ('includes/inc-frame_bottom.php');
}
?>