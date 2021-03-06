<?php
// $flagNoAuth =true;
require ('common/auth.php');

$pcfilter = isset($_GET['pc'])?$_GET['pc']:($_COOKIE['pc']?$_COOKIE['pc']:$arrUsrData['usrProfitID']);
SetCookie('pc',$pcfilter,0,'/budget/');
	
$sql = "SELECT * FROM vw_profit WHERE pccID=".$oSQL->e($pcfilter);
$rs = $oSQL->q($sql);
$rw = $oSQL->f($rs);
$arrUsrData["pagTitle$strLocal"] .= ' :: '.($rw['pccTitle']?$rw['pccTitle']:'<Unknown PC>');
	
$sqlWhere = " AND (guid IN (SELECT source FROM reg_master WHERE pc=".$oSQL->e($pcfilter).") OR pc=".$oSQL->e($pcfilter).")";


if (isset($_GET['tab'])){
	?>
	<button onclick="repost('<?php echo $_GET['tab']; ?>', event);">Repost documents</button>
	<?php
	require ('classes/reports.class.php');
	$sql = "SELECT vw_journal.*, stbl_user.*, edit_date as timestamp FROM vw_journal 				
		LEFT JOIN stbl_user ON usrID=vw_journal.edit_by				
		WHERE vw_journal.scenario='{$_GET['tab']}' 
		{$sqlWhere}
		GROUP BY vw_journal.guid
		ORDER BY vw_journal.deleted ASC, vw_journal.table, vw_journal.id";	

		$rs =$oSQL->q($sql);
		while ($rw=$oSQL->f($rs)){
			$data[] = $rw;
		}
		
		?>
		<div style='float:none;'>
		<div id='div_<?php echo $_GET['tab'];?>' style='float:left;'>
		<?php
		Reports::getJournalEntries($data);
		?>
		</div>
		<?php
		include('includes/inc_journals.php');
		?>		
		</div>
	<?php
	die();
} else {
	require ('classes/budget.class.php');
	$arrJS[] = 'js/journal.js';
	
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],'</h1>';
	?>
	<nav>
		<span><a href='sp_bu.php?pc=<?php echo $arrUsrData['usrProfitID'];?>'>See docs for <?php echo $arrUsrData['PCC']['pccTitle'];?></a></span>| 
		<span><a href='sp_my.php?ownerID=MYSELF'>See my own docs</a></span>
	</nav>
	<?php
	echo Budget::getScenarioTabs();
	
	include ('includes/inc-frame_bottom.php');
}