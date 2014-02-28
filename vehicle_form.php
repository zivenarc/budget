<?php
//$flagNoAuth = true;
require ('common/auth.php');
include ('classes/vehicle.class.php');
$arrJS[] = 'js/input_form.js';

$vehID=$_GET['vehID']?$_GET['vehID']:$_POST['vehID'];

$oBudget = new Budget($budget_scenario);
$oDocument = new Vehicle ($vehID);
$oDocument->defineEF();
$oDocument->defineGrid();


if ($_POST['DataAction']){
	 // echo '<pre>'; print_r($_POST);	 echo '</pre>';
	if($_POST['DataAction']=='fill'){
		
		if (is_array($oDocument->records[$oDocument->gridName])){
			foreach($oDocument->records[$oDocument->gridName] as $id=>$record){
				$record->flagDeleted = true;
			}
		}
		
		$dateBudgetStart = $oBudget->year.'-01-01';
		$dateBudgetEnd = ($oBudget->year+1).'-01-01';
		
		$sql = "SELECT *, PERIOD_DIFF(EXTRACT(YEAR_MONTH FROM '{$dateBudgetStart}'), EXTRACT(YEAR_MONTH FROM fixDeprStart)) AS months,
				fixValueStart*(1-PERIOD_DIFF(EXTRACT(YEAR_MONTH FROM '{$dateBudgetStart}'), EXTRACT(YEAR_MONTH FROM fixDeprStart))/fixDeprDuration) as fixValuePrimo,
				fixValueStart*(1-PERIOD_DIFF(EXTRACT(YEAR_MONTH FROM '{$dateBudgetEnd}'), EXTRACT(YEAR_MONTH FROM fixDeprStart))/fixDeprDuration) as fixValueUltimo
				FROM vw_fixed_assets 
				LEFT JOIN vw_item ON itmID=fixItemID
				WHERE fixProfitID=".$oDocument->profit." 
				##AND DATEDIFF(fixDeprEnd,'{$dateBudgetStart}')>0 
				AND fixFlagDeleted=0 AND fixVIN<>''
				ORDER BY fixItemID";//die($sql);
		$rs = $oSQL->q($sql);
		while ($rw=$oSQL->f($rs)){
			$row = $oDocument->add_record();
			$row->flagUpdated = true;				
			$row->profit = $oDocument->profit;
			$row->particulars = $rw['fixGUID'];						
			$row->activity = $rw['fixProductTypeID'];						
			$row->value_primo = (double)$rw['fixValuePrimo'];					
			
			$arrDescr = null;
			if ($rw['fixPlateNo']) $arrDescr[] = $rw['fixPlateNo'];
			if ($rw['fixVIN']) $arrDescr[] = $rw['fixVIN'];
			if (is_array($arrDescr)) $row->comment = implode('|',$arrDescr);				
			
			$dateEnd = strtotime($rw['fixDeprEnd']);
			
			for($m=1;$m<13;$m++){
				$month = date('M',mktime(0,0,0,$m,15));
				$eom = mktime(0,0,0,$m+1,0, $oBudget->year);
				if ($dateEnd>=$eom){
					$row->{$month} = 1;
				} else {
					$row->{$month} = 0;
				}
			}
			
		}		
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
if ($oDocument->profit && $oDocument->flagUpdate){
	$arrActions[] = Array ('title'=>'Fill grid','action'=>'javascript:fillGrid();','class'=>'car');
}

//============================== Main form definition ==============================

$oDocument->fillGrid();

require ('includes/inc-frame_top.php');
require ('includes/inc_document_header.php');
?>
<script>

$(document).ready(function(){
	eiseGridInitialize();
	rowTotalsInitialize();
	
		
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