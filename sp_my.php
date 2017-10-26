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
		
		<div class='panel' style='float:right;'>
			<nav>
			<?php
			$sql = "SELECT responsible, usrTitle, SUM(1-posted-deleted) as nCount
					FROM vw_journal 
					LEFT JOIN stbl_user ON responsible=usrID
					WHERE scenario='{$_GET['tab']}'
					GROUP BY responsible
					ORDER BY nCount DESC";
			$rs =$oSQL->q($sql);
			while ($rw=$oSQL->f($rs)){
				?>
				<div><a href='?ownerID=<?php echo $rw['responsible'];?>'><?php echo $rw['usrTitle'],($rw['nCount']?(' ('.$rw['nCount'].')'):'');?></a></div>
				<?php
			}
			?>
			</nav>
		</div>
		<div class='panel' style='float:right;'>
			<nav>
			<?php
			$sql = "SELECT pc, pccTitle, SUM(1-posted-deleted) as nCount
					FROM vw_journal 
					LEFT JOIN common_db.tbl_profit ON pc=pccID
					WHERE scenario='{$_GET['tab']}'
					GROUP BY pc
					ORDER BY nCount DESC";
			$rs =$oSQL->q($sql);
			while ($rw=$oSQL->f($rs)){
				?>
				<div><a href='?pc=<?php echo $rw['pc'];?>'><?php echo $rw['pccTitle'],' (',$rw['nCount'],')';?></a></div>
				<?php
			}
			?>
			</nav>
		</div>
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
		<span><a href='?pc=<?php echo $arrUsrData['usrProfitID'];?>'>See docs for <?php echo $arrUsrData['PCC']['pccTitle'];?></a></span>| 
		<span><a href='?ownerID=MYSELF'>See my own docs</a></span>
	</nav>
	<?php
	echo Budget::getScenarioTabs(true);
	
	include ('includes/inc-frame_bottom.php');
}