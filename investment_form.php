<?php
//$flagNoAuth = true;
require ('common/auth.php');
include ('classes/depreciation.class.php');
$arrJS[] = 'js/input_form.js';

$invID=$_GET['invID']?$_GET['invID']:$_POST['invID'];

$oBudget = new Budget($budget_scenario);
$oDocument = new Depreciation ($invID,'new');
$oDocument->defineEF();
$oDocument->defineGrid();


if ($_POST['DataAction']){
	 // echo '<pre>'; print_r($_POST);	 echo '</pre>';
	switch ($_POST['DataAction']){
		case 'fill_replacement':
			$oDocument->fill_replacement();
			break;
		default:
			//
			break;			
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
			Reports::costsBySupplier($sqlWhere);
			die();
			break;
		case 'financials':
			include ('includes/inc_financials.php');
			break;
		default:
			break;
	}

}


include ('includes/inc_document_menu.php');
if ($oDocument->profit && !$oDocument->flagPosted){
	$arrActions[] = Array ('title'=>'Fill grid','action'=>'javascript:fillGrid(\'_replacement\');','class'=>'brick');
}

//============================== Main form definition ==============================

$oDocument->fillGrid();

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