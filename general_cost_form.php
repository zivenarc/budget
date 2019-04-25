<?php
//$flagNoAuth = true;
require ('common/auth.php');
include ('classes/costs.class.php');
$arrJS[] = 'js/input_form.js';

$genID=$_GET['genID']?$_GET['genID']:$_POST['genID'];

$oDocument = new Indirect_costs ($genID,'general');
$oDocument->defineEF();
$oDocument->defineGrid();
$oBudget = new Budget($oDocument->scenario);

if ($_POST['DataAction']){
	 // echo '<pre>'; print_r($_POST);	 echo '</pre>';
	if(strpos($_POST['DataAction'],'fill_')!==false){
		$oDocument->fill_general_costs($oBudget, str_replace('fill_','',$_POST['DataAction']));	
	}
	/*
	switch ($_POST['DataAction']){
		case 'fill_hc':
			$oDocument->fill_general_costs($oBudget);
			break;
		case 'fill_bc':
			$oDocument->fill_general_costs($oBudget, 'bc');
			break;
		case 'fill_users':
			$oDocument->fill_general_costs($oBudget, 'users');
			break;
		case 'fill_teu':
			$oDocument->fill_general_costs($oBudget, 'teu');
			break;			
		case 'fill_revenue':
			$oDocument->fill_general_costs($oBudget, 'revenue');
			break;
		case 'fill_payroll':
			$oDocument->fill_general_costs($oBudget, 'payroll');
			break;
		case 'fill_ai':
			$oDocument->fill_general_costs($oBudget, 'ai');
			break;
		case 'fill_ae':
			$oDocument->fill_general_costs($oBudget, 'ae');
			break;
		case 'fill_oi':
			$oDocument->fill_general_costs($oBudget, 'oi');
			break;
		case 'fill_oe':
			$oDocument->fill_general_costs($oBudget, 'oe');
			break;
	}
	*/
	
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
			Reports::costsBySupplier($sqlWhere);
			die();
			break;
		case 'financials':
			include ('includes/inc_financials.php');
			die();
			break;
		default:
			break;
	}

}


include ('includes/inc_document_menu.php');
if ($oDocument->GUID && !$oDocument->flagPosted){
	$arrActions[] = Array ('title'=>'Headcount','action'=>'javascript:fillGrid(\'_hc\');','class'=>'brick');
	$arrActions[] = Array ('title'=>'Blue collars','action'=>'javascript:fillGrid(\'_bc\');','class'=>'user_blue');
	$arrActions[] = Array ('title'=>'Users','action'=>'javascript:fillGrid(\'_users\');','class'=>'user_suit');
	$arrActions[] = Array ('title'=>'TEU','action'=>'javascript:fillGrid(\'_teu\');','class'=>'bricks');
	$arrActions[] = Array ('title'=>'Revenue','action'=>'javascript:fillGrid(\'_revenue\');','class'=>'money');
	$arrActions[] = Array ('title'=>'Payroll','action'=>'javascript:fillGrid(\'_payroll\');','class'=>'fa-users');
	$arrActions[] = Array ('title'=>'Air import','action'=>'javascript:fillGrid(\'_ai\');','class'=>'hidden');
	$arrActions[] = Array ('title'=>'Air export','action'=>'javascript:fillGrid(\'_ae\');','class'=>'hidden');
	$arrActions[] = Array ('title'=>'Ocean import','action'=>'javascript:fillGrid(\'_oi\');','class'=>'hidden');
	$arrActions[] = Array ('title'=>'Ocean export','action'=>'javascript:fillGrid(\'_oe\');','class'=>'hidden');
	$arrActions[] = Array ('title'=>'OCM','action'=>'javascript:fillGrid(\'_ocm\');','class'=>'hidden');
	$arrActions[] = Array ('title'=>'LT','action'=>'javascript:fillGrid(\'_lt\');','class'=>'hidden');
	$arrActions[] = Array ('title'=>'CL','action'=>'javascript:fillGrid(\'_wh\');','class'=>'hidden');
}

//============================== Main form definition ==============================

$oDocument->fillGrid($oDocument->grid);

require ('includes/inc-frame_top.php');
require ('includes/inc_document_header.php');
?>
<script>

$(document).ready(function(){

	// var grid=eiseGrid_find(doc.gridName);
    // if (grid!=null){  
		// grid.change ("jan[]", function(oTr, input){
			// for (m=1;m<months.length;m++){
				// oTr.find("input[name='"+months[m]+"[]']").val(input.val());
			// }
		// })
    // }
	
});

</script>
<?php
require ('includes/inc-frame_bottom.php');
?>