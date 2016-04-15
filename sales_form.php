<?php
//$flagNoAuth = true;
require ('common/auth.php');
include ('classes/sales.class.php');
$arrJS[] = 'js/ef_common.js';
$arrJS[] = 'js/input_form.js';

$salID=$_GET['salID']?$_GET['salID']:$_POST['salID'];

$oBudget = new Budget($budget_scenario);
$oDocument = new Sales ($salID);
$oDocument->defineEF();
$oDocument->defineGrid();


if ($_POST['DataAction']){
	 // echo '<pre>'; print_r($_POST);	 echo '</pre>';
	
	if($_POST['DataAction']=='fill'){		
		
		$sql = "SELECT jitProductID, jitEstIncomeCurr, COUNT(jitProductID),AVG(jitEstIncome) as IncomeRate,jitEstCostCurr, AVG(jitEstCost) as CostRate FROM nlogjc.tbl_job_item
				JOIN nlogjc.tbl_job ON jobID=jitJobID
				JOIN nlogjc.tbl_jobtemplate ON jteGUID=jobTemplateID
				WHERE jteProductFolderID='".$oDocument->data['salProductFolderID']."' 
					AND jobCustomerID=".(integer)$oDocument->data['salCustomerID']."
					AND jobProfitID=".(integer)$oDocument->data['salProfitID']." AND DATEDIFF(NOW(), jobInsertDate)<=365
				GROUP BY jitProductID, jitQtdIncomeCurr
				HAVING COUNT(jitProductID)>1
				ORDER BY	jitProductID, COUNT(jitProductID) DESC";//die($sql);
				
		$oDocument->fillGridSQL = $sql;
		
		$rs = $oSQL->q($sql);
		while ($rw=$oSQL->f($rs)){
			$row = $oDocument->add_record();
			$row->flagUpdated = true;				
			$row->profit = $oDocument->profit;
			$row->product = $rw['jitProductID'];				
			$row->customer = $oDocument->customer;				
			//$row->comment = $_POST['comment'][$id];				
			$row->selling_rate = (double)$rw['IncomeRate'];				
			switch($rw['jitEstIncomeCurr']){
				case 'LOC':
				case 'none':
				case '':
					$selling_curr = 'RUB';
					break;
				default:
					$selling_curr = $rw['jitEstIncomeCurr'];
					break;
			}
				
			$row->selling_curr = $selling_curr;				
			$row->buying_rate = (double)$rw['CostRate'];
			switch($rw['jitEstCostCurr']){
				case 'LOC':
				case 'none':
				case '':
					$buying_curr = 'RUB';
					break;
				default:
					$buying_curr = $rw['jitEstCostCurr'];
					break;
			}			
			$row->buying_curr = $buying_curr;	
		}		
	}
	
	// $oSQL->startProfiling();
	
	if ($oDocument->save($_POST['DataAction'])){
		$oDocument->refresh($oDocument->ID);
		
		$arrActions = Array();
		include('includes/inc_document_menu.php');
		$oDocument->arrActions = $arrActions;
		$oDocument->status = 'success';
		header("Content-type: application/json");
		$oDocument->getJSON();
	}
	
	// $oSQL->showProfileInfo();
	
	die();
}

if ($_GET['tab']){
	switch($_GET['tab']){
		case 'kpi':
			require_once ('classes/reports.class.php');
			$sqlWhere = "WHERE source='".$oDocument->GUID."'";
			$oReport = new Reports(Array('budget_scenario'=>$oDocument->budget->id));
			$oReport->salesByActivity($sqlWhere);
			die();
			break;
		case 'financials':			
			require_once ('classes/reports.class.php');
			$sqlWhere= "WHERE source='".$oDocument->GUID."'";
			$oReport = new Reports(Array('budget_scenario'=>$oDocument->budget->id));			
			if ($oDocument->ps_profit){
				$oReport->masterByProfit($sqlWhere);
			} else {
				$oReport->masterByCustomer($sqlWhere);
			}			
			$oReport->masterByYACT($sqlWhere);
			die();
			break;
		default:
			break;
	}

}


include ('includes/inc_document_menu.php');
if ($oDocument->customer && $oDocument->flagUpdate ){
	$arrActions[] = Array ('title'=>'Fill grid','action'=>'javascript:fillGrid();','class'=>'brick');
}

//============================== Main form definition ==============================

$oDocument->fillGrid();

// $arrUsrData["pagTitle$strLocal"] .= ' #'.$oDocument->ID;

require ('includes/inc-frame_top.php');
require ('includes/inc_document_header.php');
?>
<script>

$(document).ready(function(){
		
	init_productProperties();
	init_monthlyCopy();
	
});
</script>

<?php
require ('includes/inc-frame_bottom.php');
?>