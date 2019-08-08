<?php
//$flagNoAuth = true;
require ('common/auth.php');
include ('classes/distribution.class.php');
$arrJS[] = 'js/input_form.js';

$rntID=$_GET['rntID']?$_GET['rntID']:$_POST['rntID'];

$oBudget = new Budget($budget_scenario);
$oDocument = new Distribution($rntID);
$oDocument->defineEF();
$oDocument->defineGrid();


if ($_POST['DataAction']){
	 // echo '<pre>'; print_r($_POST);	 echo '</pre>';
	
	if(strpos($_POST['DataAction'],'fill_')!==false){
		$oDocument->fill_distribution($oBudget, str_replace('fill_','',$_POST['DataAction']));	
	}
	
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
			//Reports::costsBySupplier($sqlWhere);
			die();
			break;
		case 'financials':
			require_once ('classes/reports.class.php');
			$sqlWhere= "WHERE source='".$oDocument->GUID."'";	
			$oReport = new Reports(Array('budget_scenario'=>$oDocument->budget->id));				
			$oReport->masterByCustomer($sqlWhere);	
			$oReport->masterByYACT($sqlWhere);
			die();
			break;
		default:
			break;
	}

}


include ('includes/inc_document_menu.php');
if ($oDocument->GUID && !$oDocument->flagPosted){
	// $arrActions[] = Array ('title'=>'SQM','action'=>'javascript:fillGrid(\'_sqm\');','class'=>'brick');	
	$arrActions[] = Array ('title'=>'Fill KPI','action'=>'javascript:fillGrid(\'_kpi\');','class'=>'brick');	
	// $arrActions[] = Array ('title'=>'TEU Import','action'=>'javascript:fillGrid(\'_teu_imp\');','class'=>'brick hidden');	
	// $arrActions[] = Array ('title'=>'TEU Export','action'=>'javascript:fillGrid(\'_teu_exp\');','class'=>'brick hidden');	
}

//============================== Main form definition ==============================

$oDocument->fillGrid($oDocument->grid);

require ('includes/inc-frame_top.php');
require ('includes/inc_document_header.php');

?>
<script>
var arrGHQ = <?php echo json_encode($arrGHQ);?>;

$(document).ready(function(){
	
	init_monthlyCopy();
	
});

</script>
<?php
require ('includes/inc-frame_bottom.php');
?>