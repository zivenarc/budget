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

if ($_GET['DataAction']=='excel'){	
	include_once ("../common/eiseList/inc_excelXML.php");
	$xl = new excelXML();            
	$arrHeader = Array('Организация','Подразделение','Номенклатура','Номенклатурная группа','Содержание','Количество','Цена','Сумма');		
	$xl->addHeader($arrHeader);
	
	$sql = "SELECT comID, comTitleLocal, pc, pccTitleLocal, product, prdTitleLocal,activity,prtTitleLocal, buying_rate, ".$oBudget->getThisYTDSQL('nm')." as nQuantity, period
			FROM reg_costs	
			LEFT JOIN common_db.tbl_company ON comID=company
			LEFT JOIN common_db.tbl_profit ON pccID=pc
			LEFT JOIN common_db.tbl_product ON prdID=product
			LEFT JOIN common_db.tbl_product_type ON prtID=activity
			WHERE source='{$oDocument->GUID}'
			";
			
	
	$rs = $oSQL->q($sql);
	while ($rw = $oSQL->f($rs)){
			
			if($rw['period']=='annual'){
				$rw['buying_rate'] /= 12;
			}
			
			$arrRow = Array();
			$arrRow[] = $rw['comTitleLocal'];	
			$arrRow[] = $rw['pccTitleLocal'];					
			$arrRow[] = $rw['prdTitleLocal'];					
			$arrRow[] = $rw['prtTitleLocal'];					
			$arrRow[] = $rw['comment'];					
			$arrRow[] = number_format($rw['nQuantity'],3,'.','');	
			$arrRow[] = number_format($rw['buying_rate'],3,'.','');					
			$arrRow[] = number_format($rw['buying_rate']*$rw['nQuantity'],3,'.','');					
			$xl->addRow($arrRow);
	}
     
	$xl->Output($oDocument->GUID);
	die();	
}


if ($_POST['DataAction']){
	 // echo '<pre>'; print_r($_POST);	 echo '</pre>';
	if(strpos($_POST['DataAction'],'fill_')!==false){
		$oDocument->fill_general_costs($oBudget, str_replace('fill_','',$_POST['DataAction']));	
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
			die();
			break;
		default:
			break;
	}

}


include ('includes/inc_document_menu.php');
if ($oDocument->GUID){
	if (!$oDocument->flagPosted){
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
	$arrActions[] = Array ('title'=>'Excel','action'=>$_SERVER['REQUEST_URI'].'&DataAction=excel','class'=>'excel');
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