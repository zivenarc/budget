<?php
$flagNoAuth =true;
require ('common/auth.php');

if ($_GET['tab']){
	require ('classes/reports.class.php');	
	$sql = "SELECT source FROM reg_sales WHERE scenario='{$_GET['tab']}' GROUP BY source HAVING SUM(kpi)=0";
	$rs =$oSQL->q($sql);
	if ($oSQL->n($rs)){
	while ($rw=$oSQL->f($rs)){
		$arrSource[] = "'".$rw['source']."'";
	}	
	$sql = "SELECT *, edit_date as timestamp FROM vw_journal 				
		WHERE scenario='{$_GET['tab']}' 
			AND guid IN (".implode(",",$arrSource).")
		GROUP BY guid
		ORDER BY responsible, timestamp DESC";	

		$rs =$oSQL->q($sql);
		while ($rw=$oSQL->f($rs)){
			$data[] = $rw;
		}
		?>
		<!--<button onclick="repost('<?php echo $_GET['tab']; ?>', event);">Repost documents</button>-->
		<div id='div_<?php echo $_GET['tab'];?>'>
		<h3>No KPIs recorded</h3>
		<?php		
		Reports::getJournalEntries($data);
		?>
		</div>
		<?php
	}
} else {
	require ('classes/budget.class.php');
	$arrJS[] = 'js/journal.js';
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],'</h1>';
	echo Budget::getScenarioTabs(true);
	include ('includes/inc-frame_bottom.php');
}
?>