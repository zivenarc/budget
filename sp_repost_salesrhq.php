<?php
$flagNoAuth =true;
require ('common/auth.php');

if ($_GET['tab']){
	
	?>
<button onclick="repost('<?php echo $_GET['tab']; ?>', event);">Repost documents</button>
<div/>

	<?php
	require ('classes/reports.class.php');
	
	$sql = "SELECT source, salID, salAmount, SUM(apr+may+jun+jul+aug+sep+`oct`+`nov`+`dec`+jan_1+feb_1+mar_1) as Total_RHQ
			FROM reg_sales_rhq 			
			LEFT JOIN tbl_sales ON salGUID=source 
			WHERE scenario = '{$_GET['tab']}'
			GROUP BY source 
			HAVING Total_RHQ<>salAmount";
	$rs = $oSQL->q($sql);
	while ($rw = $oSQL->f($rs)){
		$arrGUID[] = $rw['source'];
		$arrRHQ[$rw['source']] = $rw['Total_RHQ'];
	}
	
	$sql = "SELECT *,  edit_date as timestamp FROM vw_journal 				
		LEFT JOIN stbl_user ON usrID=vw_journal.edit_by				
		WHERE vw_journal.posted=1 
		AND vw_journal.scenario='{$_GET['tab']}' 
		AND prefix IN ('sal', 'ics')
		AND vw_journal.guid IN ('".implode("','",$arrGUID)."')
		GROUP BY vw_journal.guid
		ORDER BY vw_journal.edit_date ASC";	

		$rs =$oSQL->q($sql);
		while ($rw=$oSQL->f($rs)){
			$rw['comment'] = $rw['amount'] - $arrRHQ[$rw['guid']];
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
	echo Budget::getScenarioTabs();
	include ('includes/inc-frame_bottom.php');
}
?>