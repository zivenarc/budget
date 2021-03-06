<?php
// $flagNoAuth =true;
require ('common/auth.php');

$ownerID = isset($_GET['ownerID'])?$_GET['ownerID']:($_COOKIE['ownerID']?$_COOKIE['ownerID']:$arrUsrData['usrID']);
if ($_GET['ownerID']=='MYSELF'){
	$ownerID = $arrUsrData['usrID'];
}
SetCookie('ownerID',$ownerID,0,'/budget/');
$sqlWhere = " AND responsible=".$oSQL->e($ownerID);

$sql = "SELECT * FROM stbl_user WHERE usrID=".$oSQL->e($ownerID);
$rs = $oSQL->q($sql);
$rw = $oSQL->f($rs);

$arrUsrData["pagTitle$strLocal"] .= ' :: '.($rw['usrTitle']?$rw['usrTitle']:'<Unknown>');

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
		ORDER BY vw_journal.edit_date ASC";	

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
	echo Budget::getScenarioTabs(true);
	
	include ('includes/inc-frame_bottom.php');
}