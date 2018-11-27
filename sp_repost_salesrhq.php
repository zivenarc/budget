<?php
$flagNoAuth =true;
require ('common/auth.php');

if ($_GET['tab']){
	
	?>
<button onclick="repost('<?php echo $_GET['tab']; ?>', event);">Repost documents</button>
<div/>

	<?php
	require ('classes/reports.class.php');
	
	$sql = "SELECT source,SUM(Total_AM) as Total_AM
			FROM vw_master 			
			WHERE scenario = '{$_GET['tab']}'
			AND account IN ('J00400', 'J00802','J45010','J40010')
			GROUP BY source 
			";
	$rs = $oSQL->q($sql);
	while ($rw = $oSQL->f($rs)){
		$arrGUID[] = $rw['source'];
		$arrAM[$rw['source']] = $rw['Total_AM'];
	}
	
	$sql = "SELECT source SUM(Apr+May+Jun+Jul+Aug+Sep+`Oct`+Nov+`Dec`+Jan_1+Feb_1+Mar_1) as Total_RHQ
			FROM reg_sales_rhq 			
			WHERE scenario = '{$_GET['tab']}'			
			GROUP BY source";
	while ($rw = $oSQL->f($rs)){		
		$arrRHQ[$rw['source']] = $rw['Total_RHQ'];
	}
	
	
	$sql = "SELECT *,  edit_date as timestamp FROM vw_journal 				
		LEFT JOIN stbl_user ON usrID=vw_journal.edit_by				
		WHERE vw_journal.posted=1 
		AND vw_journal.scenario='{$_GET['tab']}' 
		AND prefix IN ('sal', 'ics', 'cst')
		AND vw_journal.guid IN ('".implode("','",$arrGUID)."')
		GROUP BY vw_journal.guid
		ORDER BY vw_journal.edit_date ASC";	

		$rs =$oSQL->q($sql);
		while ($rw=$oSQL->f($rs)){
			$rw['comment'] = number_format($rw['amount'] - $arrRHQ[$rw['guid']],0,'.',',');
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