<?php
//$flagNoAuth = true;
require ('common/auth.php');
include ('classes/sales.class.php');
$arrJS[] = 'js/ef_common.js';
$arrJS[] = 'js/input_form.js';
$arrJS[] = 'js/sales_form.js';

$salID=$_GET['salID']?$_GET['salID']:$_POST['salID'];

$oBudget = new Budget($budget_scenario);
$oDocument = new Sales ($salID);
$oDocument->defineEF();
$oDocument->defineGrid();


if ($_POST['DataAction']){
	 // echo '<pre>'; print_r($_POST);	 echo '</pre>';
	if($_POST['DataAction']=='route'){
		
		$sql = "SELECT ref_route.*, POL.cntTitle as polTitle, POD.cntTitle as podTitle 
				FROM ref_route 
				LEFT JOIN geo.tbl_country POL ON POL.cntID=pol_country
				LEFT JOIN geo.tbl_country POD ON POD.cntID=pod_country
				WHERE pol_country=LEFT(".$oSQL->e($_POST['pol']).",2)
				AND pod_country=LEFT(".$oSQL->e($_POST['pod']).",2)";
		
		$rs = $oSQL->q($sql);
		if ($oSQL->n($rs)){
			$res = $oSQL->f($rs);
		} else {
			$oSQL->q("INSERT IGNORE INTO ref_route VALUES(LEFT(".$oSQL->e($_POST['pol']).",2),LEFT(".$oSQL->e($_POST['pod']).",2),0)");
			$rs = $oSQL->q($sql);
			$res = $oSQL->f($rs);
		}
		
		header('Content-type:application/json;');
		echo json_encode($res);
		die();
	}
	
	if($_POST['DataAction']=='route_update'){
		try {
			$oSQL->q("UPDATE ref_route SET route=".(integer)$_POST['route']." WHERE pol_country=".$oSQL->e($_POST['pol_country'])." AND pod_country=".$oSQL->e($_POST['pod_country']));	
			$res = Array('status'=>'success','description'=>"");
		} catch (Exception $e){
			$res = Array('status'=>'error','description'=>$e->getMessage());
		}
		
		header('Content-type:application/json;');
		echo json_encode($res);
		
		die();
	}
	
	if($_POST['DataAction']=='fill_estimate'){
		
		$sql = "SELECT prtGHQ,prtTitle, activity,account, ".$oDocument->budget->getMonthlySumSQL(1,15, null, 1000)." 
						FROM reg_master
						LEFT JOIN vw_product_type ON prtID=activity
						WHERE scenario='".$oDocument->budget->reference_scenario->id."' 
							AND active=1 
							AND pc='{$oDocument->profit}'
							AND company='{$company}'
							AND account IN ('J00400','J00802')
						GROUP BY prtGHQ,account, prtBudgetIncomeID, prtBudgetCostID
						ORDER BY prtGHQ,prtID, account"; 
		
		$oDocument->fillGridSQL = $sql;
		
		$oDocument->deleteGridRecords();
		
		$rs = $oSQL->q($sql);
		while ($rw=$oSQL->f($rs)){
			$row = $oDocument->add_record();
			$row->flagUpdated = true;				
			$row->profit = $oDocument->profit;
			$row->product = null;				
			$row->activity = $rw['activity'];				
			$row->comment = $rw['prtGHQ'].' ('.$rw['prtTitle'].')'." +".$oDocument->budget->settings[$rw['prtGHQ']."_growth"].'%';				
			$row->customer = $oDocument->customer;				
			$row->sales = $oDocument->sales;
			$row->kpi = 0;
			//$row->comment = $_POST['comment'][$id];				
			if($rw['account']=='J00400'){
					$row->selling_rate = 1000;						
					$row->selling_curr = 'RUB';
			} else {
				$row->buying_curr = 'RUB';			
				$row->buying_rate = 1000;
			}
			for ($m=1;$m<=15;$m++){							
							$month = $oDocument->budget->arrPeriod[$m];	
							$row->{$month} = abs($rw[strtolower($month)])*(1+$oDocument->budget->settings[$rw['prtGHQ']."_growth"]);
			}			
				
		}
	}
	
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
			$row->sales = $oDocument->sales;
			$row->kpi = 1;
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
				$oReport->masterByActivity($sqlWhere);
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
	$arrActions[] = Array ('title'=>'Estimate','action'=>"javascript:fillGrid('_estimate');",'class'=>'brick');
}

//============================== Main form definition ==============================

$oDocument->fillGrid();

// $arrUsrData["pagTitle$strLocal"] .= ' #'.$oDocument->ID;

require ('includes/inc-frame_top.php');
require ('includes/inc_document_header.php');
?>
<div id='route_select' style='display:none;'>
	<p id='route_select_prompt'/>
	<div id='route_select_wrap'>
		<select id='route_select_select'>
		</select>
	</div>
</div>
<script>

$(document).ready(function(){
		
	init_productProperties();
	init_monthlyCopy();
	
});
</script>

<?php
require ('includes/inc-frame_bottom.php');
?>