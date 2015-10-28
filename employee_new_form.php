<?php
//$flagNoAuth = true;
require ('common/auth.php');
include ('classes/headcount.class.php');
$arrJS[] = 'js/ef_common.js';
$arrJS[] = 'js/input_form.js';

$cemID=$_GET['nemID']?$_GET['nemID']:$_POST['nemID'];

$oBudget = new Budget($budget_scenario);
$oDocument = new Headcount ($cemID, 'new');
$oDocument->defineEF();
$oDocument->defineGrid();

include ('includes/inc_profit_acl.php');

if ($_POST['DataAction']){
	 if($_POST['DataAction']=='fill'){
		
		//do nothing
		
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
			Reports::headcountByJob($sqlWhere);
			die();
			break;
		case 'financials':
			require_once ('classes/reports.class.php');
			$sqlWhere= "WHERE source='".$oDocument->GUID."'";			
			Reports::masterByCustomer($sqlWhere);
			Reports::masterByYACT($sqlWhere);
			die();
			break;
		case 'access':
			include ('includes/inc_document_acl_report.php');			
			die();
			break;
		default:
			break;
	}

}


include ('includes/inc_document_menu.php');
// if ($oDocument->profit && !$oDocument->flagPosted){
	// $arrActions[] = Array ('title'=>'Fill grid','action'=>'javascript:fillGrid();','class'=>'brick');
// }

//============================== Main form definition ==============================

$oDocument->fillGrid($oDocument->grid);

require ('includes/inc-frame_top.php');
require ('includes/inc_document_header.php');
?>
<script>

$(document).ready(function(){
		
	// var grid=eiseGrid_find(doc.gridName);
    // if (grid!=null){  
		// grid.change ("function[]", function(oTr, input){ 
			// console.log(oTr);
			// $.post("ajax_details.php"
				// , {table:'vw_function',funGUID:oTr.find("[name='function[]']").val()}
				// , function(data, textStatus){
					// console.log(data);
					// oTr.find("[name='mobile_limit[]']").val(data.funMobile);
					// oTr.find("[name='fuel[]']").val(data.funFuel);
					// oTr.find("[name='new_fte[]']").val(1);
					// oTr.find("[name='wc[]']").val(data.funFlagWC==1);
					// oTr.find("[name='wc_chk[]']").attr('checked',data.funFlagWC==1);
				// }
				// ,'json'
			// );
		// })
    // }
	
});

</script>
<?php
require ('includes/inc-frame_bottom.php');
?>