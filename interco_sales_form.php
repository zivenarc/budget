<?php
//$flagNoAuth = true;
require ('common/auth.php');
include ('classes/interco_sales.class.php');
$arrJS[] = 'js/ef_common.js';
$arrJS[] = 'js/input_form.js';

$icsID=$_GET['icsID']?$_GET['icsID']:$_POST['icsID'];

$oBudget = new Budget($budget_scenario);
$oDocument = new Interco_sales ($icsID);
$oDocument->defineEF();
$oDocument->defineGrid();


if ($_POST['DataAction']){
	 // echo '<pre>'; print_r($_POST);	 echo '</pre>';
	
	if ($oDocument->save($_POST['DataAction'])){
		$oDocument->refresh($oDocument->ID);
		
		$arrActions = Array();
		include('includes/inc_document_menu.php');
		$oDocument->arrActions = $arrActions;
		$oDocument->status = 'success';
		header("Content-type: application/json");
		$oDocument->getJSON();
	}
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
			$oReport->masterByProfit($sqlWhere);
			$oReport->masterByYACT($sqlWhere);
			die();
			break;
		default:
			break;
	}

}


include ('includes/inc_document_menu.php');


//============================== Main form definition ==============================

$oDocument->fillGrid();

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