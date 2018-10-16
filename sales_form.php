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
	if($_POST['DataAction']=='new_biz'){
		$sql = Array();
		$sql[] = "UPDATE tbl_sales SET salFlagNew=".(integer)$_POST['salFlagNew']." WHERE salGUID='{$oDocument->GUID}';";
		$sql[] = "UPDATE reg_sales SET new=".(integer)$_POST['salFlagNew']." WHERE source='{$oDocument->GUID}'";
		$sql[] = "UPDATE reg_master SET new=".(integer)$_POST['salFlagNew']." WHERE source='{$oDocument->GUID}'";
		$success = true;
		for ($i=0;$i<count($sql);$i++){
			$success &= $oSQL->q($sql[$i]);
		}
		header('Content-type:application/json;');
		if ($success) {
			echo json_encode(Array('status'=>'success','user'=>$arrUsrData['usrID']));
		} else {
			echo json_encode(Array('status'=>'error'));
		}
		die();
	}
	 
	if($_POST['DataAction']=='ownership'){
		$sql = Array();
		$sql[] = "UPDATE tbl_sales SET salUserID='{$arrUsrData['usrID']}' WHERE salGUID='{$oDocument->GUID}';";
		$sql[] = "UPDATE reg_sales SET sales='{$arrUsrData['usrID']}', bdv='{$arrUsrData['usrProfitID']}' WHERE source='{$oDocument->GUID}'";
		$sql[] = "UPDATE reg_master SET sales='{$arrUsrData['usrID']}', bdv='{$arrUsrData['usrProfitID']}' WHERE source='{$oDocument->GUID}'";
		$success = true;
		for ($i=0;$i<count($sql);$i++){
			$success &= $oSQL->q($sql[$i]);
		}
		header('Content-type:application/json;');
		if ($success) {
			echo json_encode(Array('status'=>'success','user'=>$arrUsrData['usrID']));
		} else {
			echo json_encode(Array('status'=>'error'));
		}
		die();
	}
	 
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
							$row->{$month} = abs($rw[strtolower($month)])*(1+$oDocument->budget->settings[$rw['prtGHQ']."_growth"]/100);
			}			
				
		}
	}
	
	if($_POST['DataAction']=='fill'){		
		
		$sql = "SELECT activity, SUM(".$oDocument->budget->getThisYTDSQL().")/{$oDocument->budget->cm} as nVolume, kpi
				FROM reg_sales
				WHERE customer=".(integer)$oDocument->customer."
					AND pc=".(integer)$oDocument->profit."
					AND source='Actual'
					AND scenario='{$oDocument->budget->id}'
				GROUP BY activity, kpi				
				";//die($sql);
				
		$oDocument->fillGridSQL = $sql;
		
		$rs = $oSQL->q($sql);
		while ($rw=$oSQL->f($rs)){
			$row = $oDocument->add_record();
			$row->flagUpdated = true;				
			$row->profit = $oDocument->profit;
			$row->activity = $rw['activity'];				
			$row->customer = $oDocument->customer;				
			$row->sales = $oDocument->sales;
			$row->kpi = $rw['kpi'];
			//$row->comment = $_POST['comment'][$id];				
			for ($m = $oDocument->budget->nm; $m<=15; $m++){
				$month = $oDocument->budget->arrPeriod[$m];
				$row->{$month} = $rw['nVolume'];
			}
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
			$oReport = new Reports(Array('budget_scenario'=>$oDocument->budget->id,'filter'=>Array('source'=>$oDocument->GUID)));
			$oReport->salesByActivity();
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
if($oDocument->GUID){
	$arrActions[] = Array ('title'=>'Take ownership','action'=>"javascript:ownership();",'class'=>'fa-user');
	if($oDocument->new_biz){
		$arrActions[] = Array ('title'=>'Old biz','action'=>"javascript:old_biz();",'class'=>'fa-old');
		$arrWarning[] = Array('class'=>'good','text'=>"This is a <strong>new business</strong>");
	} else {
		$arrActions[] = Array ('title'=>'New biz','action'=>"javascript:new_biz();",'class'=>'fa-new');
	}	
}
//============================== Main form definition ==============================

$oDocument->fillGrid();

// $arrUsrData["pagTitle$strLocal"] .= ' #'.$oDocument->ID;
$strPageSubtitle = $oDocument->ID?$oDocument->ID:"New";
if ($oDocument->flagPosted){
	foreach($oDocument->records[$oDocument->gridName] as $id=>$record){
		$nKPI+=$record->kpi;
		if ($record->kpi && $record->unit=='TEU'){
			$nTEU += $record->total();
		}
		if ($record->kpi && $record->unit=='Kgs'){
			$nKgs += $record->total();
		}
	}
	if(!$nKPI){
		$arrWarning[] = Array('class'=>'error','text'=>'No KPIs are reported by this document');
	}
	if($nTEU){
		$arrWarning[] = Array('class'=>'info','text'=>"OFF Volume: <strong>{$nTEU} TEU</strong>. GP per unit: <strong>".number_format($oDocument->amount/$nTEU,0)."</strong>");
	}
	if($nKgs){
		$arrWarning[] = Array('class'=>'info','text'=>"AFF Volume: <strong>{$nKgs} Kgs</strong>. GP per unit: <strong>".number_format($oDocument->amount/$nKgs,0)."</strong>");
	}
}


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