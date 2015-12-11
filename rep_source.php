<?php
$flagNoAuth =true;
require ('common/auth.php');
require ('classes/reports.class.php');
include ('includes/inc-frame_top.php');

if (isset($_POST['budget_scenario'])){
	$budget_scenario = $_POST['budget_scenario'];
}

if (isset($_POST['customer'])){
	$sqlWhere = " AND customer=".$oSQL->e($_POST['customer']);
}
if (isset($_POST['activity'])){
	$sqlWhere = " AND activity=".$oSQL->e($_POST['activity']);
}

if ($_POST['pccGUID']=='all' || $_POST['pccGUID']=='undefined' || !isset($_POST['pccGUID'])){
	$strPCFilter = '';
} else {
	$strPCFilter = " AND pccGUID=".$oSQL->e($_POST['pccGUID']);
}

$sql = "SELECT *,SUM(`Jan`+`Feb`+`Mar`+`Apr`+`May`+`Jun`+`Jul`+`Aug`+`Sep`+`Oct`+`Nov`+`Dec`) as amount FROM reg_master
		JOIN vw_journal ON guid=source
		LEFT JOIN vw_profit ON pccID=reg_master.pc
		LEFT JOIN stbl_user ON usrID=edit_by
		WHERE item=".$oSQL->e($_POST['item'])." $strPCFilter $sqlWhere  AND vw_journal.scenario='$budget_scenario'
		GROUP BY guid
		ORDER BY timestamp DESC";	
echo '<pre>',$sql,'</pre>';		
$rs =$oSQL->q($sql);
while ($rw=$oSQL->f($rs)){
	$data[] = $rw;
}
Reports::getJournalEntries($data);
include ('includes/inc-frame_bottom.php');
?>