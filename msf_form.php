<?php
//$flagNoAuth = true;
require ('common/auth.php');
include ('classes/msf.class.php');
$arrJS[] = 'js/input_form.js';

$msfID=$_GET['msfID']?$_GET['msfID']:$_POST['msfID'];


$oDocument = new MSF($msfID);
$oDocument->defineEF();
$oDocument->defineGrid();
$oBudget = new Budget($oDocument->scenario);

if ($_POST['DataAction']){
	 // echo '<pre>'; print_r($_POST);	 echo '</pre>';
	
	switch ($_POST['DataAction']){
		case 'fill_fte':
			$oDocument->fill_distribution($oBudget, 'fte');
			break;
		case 'fill_sales':
			$oDocument->fill_distribution($oBudget, 'sales');
			break;	
		case 'fill_users':
			$oDocument->fill_distribution($oBudget, 'users');
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
			require_once ('classes/reports.class.php');
			$sqlWhere= "WHERE source='".$oDocument->GUID."'";			
			Reports::masterByProfit($sqlWhere);			
			Reports::masterByYACT($sqlWhere);
			die();
			break;
		default:
			break;
	}

}


include ('includes/inc_document_menu.php');
if ($oDocument->GUID && !$oDocument->flagPosted){
	$arrActions[] = Array ('title'=>'FTE','action'=>'javascript:fillGrid(\'_fte\');','class'=>'brick');	
	$arrActions[] = Array ('title'=>'Users','action'=>'javascript:fillGrid(\'_users\');','class'=>'brick');	
	$arrActions[] = Array ('title'=>'Sales','action'=>'javascript:fillGrid(\'_sales\');','class'=>'brick');	
}

//============================== Main form definition ==============================

$oDocument->fillGrid($oDocument->grid);

require ('includes/inc-frame_top.php');
require ('includes/inc_document_header.php');

?>
<script>
var arrGHQ = <?php echo json_encode($arrGHQ);?>;

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