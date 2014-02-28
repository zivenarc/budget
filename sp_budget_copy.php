<?php
$flagNoAuth = true;
require ('common/auth.php');
require ('classes/budget.class.php');

$old_budget = $_GET['old_budget'];
$new_budget = $_GET['new_budget'];

if (!isset($_GET['old_budget'])){
	die ('ERROR: Old budget scenario is not set');
}
if (!isset($_GET['new_budget'])){
	die ('ERROR: New budget scenario is not set');
}
if ($new_budget==$old_budget){
	die ('ERROR: Budget scenarios cannot be the same');
}

$oNewBudget = new Budget($new_budget);
if (!$oNewBudget->flagUpdate){
	die ('ERROR: New budget has data and is read-only');
}

$sql = "SELECT * FROM stbl_entity";
$rs = $oSQL->q($sql);
while ($rw=$oSQL->f($rs)){

	$arrEntity[$rw['entTable']] = $rw;

}

$sql = Array('SET AUTOCOMMIT=0;','START TRANSACTION;');

$sql[] = "DELETE FROM `reg_sales` WHERE `scenario`='{$new_budget}';";
$sql[] = "DELETE FROM `reg_costs` WHERE `scenario`='{$new_budget}';";
$sql[] = "DELETE FROM `reg_depreciation` WHERE `scenario`='{$new_budget}';";
$sql[] = "DELETE FROM `reg_vehicles` WHERE `scenario`='{$new_budget}';";
$sql[] = "DELETE FROM `reg_headcount` WHERE `scenario`='{$new_budget}';";

$sql [] = "DELETE FROM reg_master WHERE scenario='{$new_budget}';";
$sql[] = "INSERT INTO reg_master (company, pc, activity, customer, account, item, source, estimate, scenario, active)
			SELECT company, pc, activity, customer, account, item, 'Estimate', SUM(".Budget::getYTDSQL().") as YTD, '{$new_budget}', active
				FROM reg_master WHERE scenario='{$old_budget}' AND active=1 AND estimate=0
				GROUP BY company, pc, activity, customer, account, item
				HAVING YTD<>0;";
				
$sql [] = "DELETE FROM tbl_scenario_variable WHERE scvScenarioID='{$new_budget}';";
$sql [] = "INSERT INTO tbl_scenario_variable (scvVariableID, scvScenarioID, scvValue, scvEditBy, scvEditDate, scvInsertBy, scvInsertDate, scvFlagDeleted, scvGUID)
			SELECT scvVariableID, '{$new_budget}', scvValue, scvEditBy, scvEditDate, scvInsertBy, scvInsertDate, scvFlagDeleted, UUID()
				FROM tbl_scenario_variable WHERE scvScenarioID='{$old_budget}';";

foreach ($arrEntity as $entity=>$entity_data){
	
	echo '<h1>',$entity_data['entTitle'],'</h1>';
	
	$prefix = $entity_data['entPrefix'];

	$sql[] = "DELETE FROM `$entity` WHERE `{$prefix}Scenario`='{$new_budget}';";	

	//------------get document fields-----------------
	$arrFields = Array();
	$sqlFields = "SHOW COLUMNS FROM `$entity`";
	$rs = $oSQL->q($sqlFields);
	while ($rw=$oSQL->f($rs)){
		//echo '<pre>';print_r($rw);echo '</pre>';
		$arrFields[] = $rw['Field'];
		
	}
	
	//------------get register fields-----------------
	$arrRegFields = Array();
		$sqlFields = "SHOW COLUMNS FROM `{$entity_data['entRegister']}`";
		$rs = $oSQL->q($sqlFields);
		while ($rw=$oSQL->f($rs)){
			//echo '<pre>';print_r($rw);echo '</pre>';
			$arrRegFields[] = $rw['Field'];
			
	}
	
	//----------------------------------Copy documents------------------------------------------------------
	$sqlDoc = "SELECT * FROM `$entity` WHERE `{$prefix}FlagPosted`=1 and `{$prefix}Scenario`='{$old_budget}'";
	$rs = $oSQL->q($sqlDoc);
	while ($rw=$oSQL->f($rs)){
		
		$arrSet = Array();
		$new_guid = $oSQL->get_new_guid();
		$strSQL = "INSERT INTO `$entity` SET ";
		for($f=0;$f<count($arrFields);$f++){
			switch ($arrFields[$f]){
				case $prefix."ID":
					$arrSet[] = "`{$arrFields[$f]}`=NULL";
					break;
				case $prefix."GUID":
					$arrSet[] = "`{$arrFields[$f]}`='{$new_guid}'";
					break;
				case $prefix."Scenario":
					$arrSet[] = "`{$arrFields[$f]}`='{$new_budget}'";
					break;
				case $prefix."FlagPosted":
					$arrSet[] = "`{$arrFields[$f]}`=0";
					break;					
				case $prefix."InsertDate":
				case $prefix."EditDate":
					$arrSet[] = "`{$arrFields[$f]}`=NOW()";
					break;						
				default:
					$arrSet[] = "`{$arrFields[$f]}`=".$oSQL->e($rw[$arrFields[$f]]);
			}		
		}
		$strSQL .= implode(", ",$arrSet); 
		
		$sql[] = $strSQL;
		
		//-------------Copy register lines--------------------------------//		
		$strFields = "`".implode("`, `",$arrRegFields)."`";
		
		$strSQL = "INSERT INTO `{$entity_data['entRegister']}` ({$strFields}) SELECT ";
		$array_search = Array ('`id`','`source`','`scenario`','`posted`');
		$array_replace = Array ("NULL","'{$new_guid}'","'{$new_budget}'",0);
		$strSQL .= str_replace($array_search,$array_replace,$strFields);
		$strSQL .= " FROM `{$entity_data['entRegister']}` WHERE `source`='{$rw[$prefix."GUID"]}';";
				
		$sql[] = $strSQL;
		
		
		
	}
	
	
	
}


$sql[] = "COMMIT;";
$sql[] = "SET AUTOCOMMIT=1;";
for ($i=0;$i<count($sql);$i++){
	echo '<pre>',$sql[$i],'</pre>';
	$oSQL->q($sql[$i]);
}

?>