<?php
//$flagNoAuth = true;
require ('common/auth.php');
include ('classes/headcount.class.php');
$arrJS[] = 'js/ef_common.js';
$arrJS[] = 'js/input_form.js';

$cemID=$_GET['cemID']?$_GET['cemID']:$_POST['cemID'];

$oBudget = new Budget($budget_scenario);
$oDocument = new Headcount ($cemID);
$oDocument->defineEF();
$oDocument->defineGrid();

include ('includes/inc_profit_acl.php');

if ($_POST['DataAction']){

	if($_POST['DataAction']=='classify'){
		$oDocument->classify(); 
		redirect($_SERVER['REQUEST_URI']);
		die();
	}
	
	if($_POST['DataAction']=='declassify'){
		$oDocument->declassify();
		redirect($_SERVER['REQUEST_URI']);
		die();
	}
	
	if($_POST['DataAction']=='salary'){
	
		$sql = "SELECT empGUID1C, empTitleLocal, IF(bnsStateID=2270,bnsApprovedSalary,bnsReviewedSalary) as salary, bnsSkill+bnsQuality as bonus, DATE_FORMAT(DATE_ADD(bpdDateEnd, INTERVAL 1 DAY),'%d.%m.%Y') as reviewDate
				FROM treasury.tbl_bonus 
				LEFT JOIN common_db.tbl_employee ON bnsEmployeeID=empID
				LEFT JOIN treasury.tbl_bonus_period ON bpdID=bnsPeriodID
				WHERE bnsPeriodID=(SELECT MAX(bpdID) FROM treasury.tbl_bonus_period WHERE bpdFlagSalaryReview=1)
				AND bnsStateID BETWEEN 2240 AND 2279"
				// AND empProfitID='{$oDocument->profit}'";
				
		$rs = $oSQL->q($sql);
		while ($rw = $oSQL->f($rs)){
			$data[$rw['empGUID1C']] = $rw;
		}
		header('Content-type:application/json');
		echo json_encode($data);
		die();
	}
	
	 if($_POST['DataAction']=='fill'){
		
		$oDocument->fillData($oDocument->budget);
		
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
			$sqlWhere = "WHERE pc = '{$oDocument->profit}' AND scenario='{$oDocument->budget->id}'";
			$oReport = new Reports(Array('budget_scenario'=>$oDocument->budget->id));
			$oReport->headcountByJob($sqlWhere);
			die();
			break;
		case 'financials':
			require_once ('classes/reports.class.php');
			$sqlWhere= "WHERE source='".$oDocument->GUID."'";			
			$oReport = new Reports(Array('budget_scenario'=>$oDocument->budget->id));
			$oReport->masterByActivity($sqlWhere);
			$oReport->masterByYACT($sqlWhere);
			$oReport->employees(Array('pc'=>$oDocument->profit));
			die();
			break;
		case 'access':
			echo '<h2>Access to this document</h2>';
			$sql = "SELECT DISTINCT usrName, MAX(pgrFlagRead) FROM stbl_user
						JOIN stbl_role_user ON rluUserID=usrID
						JOIN stbl_page_role ON pgrRoleID=rluRoleID AND pgrPageID={$arrUsrData['pagID']}
						GROUP BY usrID						
						HAVING MAX(pgrFlagRead)=1
						ORDER BY usrID";
			$rs = $oSQL->q($sql);
			while ($rw = $oSQL->f($rs)){
				$arrRes[] = $rw['usrName'];
			}
			if (is_array($arrRes)){
				echo '<p>',implode(', ',$arrRes),'</p>';
			}
			echo '<h2>Access to this profit center</h2>';
			$arrRes = Array();
			$sql = "SELECT DISTINCT usrName, MAX(pcrFlagRead) FROM stbl_user
						JOIN stbl_role_user ON rluUserID=usrID
						JOIN stbl_profit_role ON pcrRoleID=rluRoleID AND pcrProfitID={$oDocument->profit}
						GROUP BY usrID						
						HAVING MAX(pcrFlagRead)=1
						ORDER BY usrID";
			$rs = $oSQL->q($sql);
			while ($rw = $oSQL->f($rs)){
				$arrRes[] = $rw['usrName'];
			}
			if (is_array($arrRes)){
				echo '<p>',implode(', ',$arrRes),'</p>';
			}
			die();
			break;
		default:
			break;
	}

}


include ('includes/inc_document_menu.php');
if ($oDocument->profit && $oDocument->flagUpdate){
	$arrActions[] = Array ('title'=>'Fill grid','action'=>'javascript:fillGrid();','class'=>'brick');
	$arrActions[] = Array ('title'=>'New salaries','action'=>'javascript:fillReviewedSalary();','class'=>'brick');
}

if ($oDocument->ID && !$oDocument->classified){
	$arrActions[] = Array ('title'=>'Classify','action'=>'javascript:send(\'classify\');','class'=>'delete');
}

if ($oDocument->ID && $oDocument->classified==$arrUsrData['usrID']){
	$arrActions[] = Array ('title'=>'Declassify','action'=>'javascript:send(\'declassify\');','class'=>'accept');
}

//============================== Main form definition ==============================

$oDocument->fillGrid($oDocument->grid);

require ('includes/inc-frame_top.php');
require ('includes/inc_document_header.php');

?>
<script>

$(document).ready(function(){

	$('#cemTurnover, #cemOvertime').filter(':text').spinner({min:0,max:100});

	// var grid=eiseGrid_find(doc.gridName);
    // if (grid!=null){  
		// grid.change ("particulars[]", function(oTr, input){ 
			// console.log(oTr);
			// $.post("ajax_details.php"
				// , {table:'vw_employee_select',empGUID1C:oTr.find("[name='particulars[]']").val()}
				// , function(data, textStatus){
					// console.log(data);
					// oTr.find("[name='salary[]']").val(parseFloat(data.empSalary));
					// oTr.find("[name='function[]']").val(data.empFunctionGUID);
					// oTr.find("[name='function_text[]']").val(data.funTitle);
					// oTr.find("[name='location[]']").val(data.empLocationID);
					// oTr.find("[name='location_text[]']").val(data.locTitle);
					// oTr.find("[name='activity[]']").val(data.empProductTypeID);
					// oTr.find("[name='activity_text[]']").val(data.prtTitle);
					// oTr.find("[name='mobile_limit[]']").val(parseFloat(data.funMobile));
					// oTr.find("[name='fuel[]']").val(parseFloat(data.funFuel));
					// oTr.find("[name='wc[]']").val(data.funFlagWC);
					// oTr.find("[name='wc_chk[]']").val(data.funFlagWC?'on':'');
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