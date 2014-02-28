<?php
//$flagNoAuth = true;
require ('common/auth.php');
include ('classes/costs.class.php');
$arrJS[] = 'js/input_form.js';

$kznID=$_GET['kznID']?$_GET['kznID']:$_POST['kznID'];

$oBudget = new Budget($budget_scenario);
$oDocument = new Indirect_costs ($kznID,'kaizen');
$oDocument->defineEF();
$oDocument->defineGrid();


if ($_POST['DataAction']){
	 // echo '<pre>'; print_r($_POST);	 echo '</pre>';
	
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
		case 'fill_kaizen':
			$oDocument->fill_general_costs($oBudget, 'kaizen', Array('prtGHQ'=>$_POST['prtGHQ']));
			break;
		case 'fill_kaizen_revenue':
			$oDocument->fill_general_costs($oBudget, 'kaizen_revenue', Array('prtGHQ'=>$_POST['prtGHQ']));
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
	$arrActions[] = Array ('title'=>'Kaizen on costs','action'=>'javascript:fillGrid(\'_kaizen\');','class'=>'money');
	$arrActions[] = Array ('title'=>'Kaizen on revenue','action'=>'javascript:fillGrid(\'_kaizen_revenue\');','class'=>'money');
}

//============================== Main form definition ==============================

$oDocument->fillGrid($oDocument->grid);

require ('includes/inc-frame_top.php');
require ('includes/inc_document_header.php');

$sql = "SELECT DISTINCT prtGHQ FROM vw_product_type";
$rs = $oSQL->q($sql);
$arrGHQ = Array();
while ($rw=$oSQL->f($rs)){
	$arrGHQ[]=$rw['prtGHQ'];
}

?>
<script>
var arrGHQ = <?php echo json_encode($arrGHQ);?>;

$(document).ready(function(){
	eiseGridInitialize();
	rowTotalsInitialize();
	
	$('#kznRate').filter(':text').spinner({
		min:-100,
		max:100,
		step:0.01
	});
		
	var grid=eiseGrid_find(doc.gridName);
    if (grid!=null){  
		grid.change ("jan[]", function(oTr, input){
			for (m=1;m<months.length;m++){
				oTr.find("input[name='"+months[m]+"[]']").val(input.val());
			}
		})
    }
	
});

</script>
<?php
require ('includes/inc-frame_bottom.php');
?>