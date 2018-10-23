<?php
//$flagNoAuth = true;
require ('common/auth.php');
require ('classes/reports.class.php');
require ('classes/reference.class.php');
require ('classes/item.class.php');
include ('includes/inc_report_settings.php');
$arrJS[]='js/rep_pnl.js';

$arrItems[] = Items::COMPANY_CARS;
$arrItems[] = Items::OFFICE_RENT;
$arrItems[] = Items::STATIONERY;
$arrItems[] = Items::OTHER_OFFICE;
$arrItems[] = Items::CANTEEN;
$arrItems[] = Items::EXPAT_HOUSING;
$arrItems[] = Items::EXPAT_COSTS;
$arrItems[] = Items::OTHER_COMMUNICATION;

$oReport = new Reports(Array('budget_scenario'=>$budget_scenario, 'currency'=>$currency, 'denominator'=>$denominator, 'reference'=>$reference,'filter'=>Array('item'=>$arrItems)));
$oBudget = new Budget($budget_scenario);

include ('includes/inc-frame_top.php');
echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,'</h1>';

include ('includes/inc_report_selectors.php');
?>
<div id='report_content'>
<?php
$oReport->quarterly('item_bu',false);	
?>
</div>
<div>
<h4>Documents</h4>
<?php 
	$sql = "SELECT *,  edit_date as timestamp 
		FROM vw_journal 			
		LEFT JOIN stbl_user ON usrID=vw_journal.edit_by						
		WHERE vw_journal.scenario='{$budget_scenario}' 
			AND guid IN (SELECT source 
						FROM reg_master 
						WHERE scenario='{$budget_scenario}' 
							AND item IN('".implode("','",$arrItems)."') 
							AND company='{$company}')
		GROUP BY vw_journal.guid
		ORDER BY vw_journal.prefix ASC";	
		
		 //echo '<pre>',$sql,'</pre>';
		
		$rs =$oSQL->q($sql);
		while ($rw=$oSQL->f($rs)){
			$data[] = $rw;
		}
		
		Reports::getJournalEntries($data);
		
?>
</div>
<?php
include ('includes/inc-frame_bottom.php');
?>