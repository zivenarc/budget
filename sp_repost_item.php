<?php
// $flagNoAuth =true;
require ('common/auth.php');
require_once('classes/item.class.php');

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
		echo "<h2>{{$itmGUID}} {$rw['itmTitle']} </h2>";
	} else {
		echo "<h2>Item {{$itmGUID}} not found</h2>";
	}
	echo Budget::getScenarioTabs(false);
	
	$sql = "SELECT C.*, P.itmTitle as parentTitle
			FROM vw_item C 
			LEFT JOIN vw_item P ON P.itmID=C.itmParentID
			ORDER by C.itmParentId, C.itmOrder";
	$rs = $oSQL->q($sql);
	
	$oItems = new Items();
	$arrItems = $oItems->getStructuredRef();
	foreach($arrItems as $group=>$items){
		echo '<h3>',$group,'</h3>';
		?>
		<ul>
		<?php
		foreach($items as $id=>$title){
			?>
			<li><a href="?itmGUID=<?php echo $id;?>"><?php echo $title;?></a></li>
			<?php
		}
		?>
		</ul>
		<?php
	}
	//echo '<pre>';print_r($arrItems);echo '</pre>';
		
	
	include ('includes/inc-frame_bottom.php');
}
?>