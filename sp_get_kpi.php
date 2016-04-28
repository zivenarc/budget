<?php
$flagNoAuth = true;
require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/reports.class.php');

include ('includes/inc_report_settings.php');

$oBudget = new Budget($budget_scenario);

if (strpos($oBudget->type,'Budget')) die('Wrong budget type, cannot fill in the actuals');

$ytd = date('n',$oBudget->date_start-1);echo $ytd;
$year = date('Y',$oBudget->date_start-1);

$arrKPI[] = Array('prtID'=>48,'ghq'=>'Ocean import','kpi'=>'SUM(jobTEU)', 'date'=>'jobETAPort');
$arrKPI[] = Array('prtID'=>63,'ghq'=>'Ocean export','kpi'=>'SUM(jobTEU)', 'date'=>'jobShipmentDate');
$arrKPI[] = Array('prtID'=>46,'ghq'=>'Air import','kpi'=>'SUM(jobGrossWeight)', 'date'=>'jobETAPort');
$arrKPI[] = Array('prtID'=>47,'ghq'=>'Air export','kpi'=>'SUM(jobGrossWeight)', 'date'=>'jobShipmentDate');
$arrKPI[] = Array('prtID'=>7,'ghq'=>'Distribution','kpi'=>'COUNT(DISTINCT jobID)', 'date'=>'jobShipmentDate');
$arrKPI[] = Array('prtID'=>6,'ghq'=>'Delivery to plant','kpi'=>'COUNT(DISTINCT jobID)', 'date'=>'jobShipmentDate');
$arrKPI[] = Array('prtID'=>3,'ghq'=>'Transportation','kpi'=>'COUNT(DISTINCT jobID)', 'date'=>'jobShipmentDate');
$arrKPI[] = Array('prtID'=>4,'ghq'=>'Customs','kpi'=>'COUNT(DISTINCT jobID)', 'date'=>'jobShipmentDate');
$arrKPI[] = Array('prtID'=>13,'ghq'=>'Int.trucking','kpi'=>'COUNT(DISTINCT jobID)', 'date'=>'jobShipmentDate');
$arrKPI[] = Array('prtID'=>50,'ghq'=>'AFF c/c','kpi'=>'COUNT(DISTINCT jobID)', 'date'=>'jobShipmentDate');
$arrKPI[] = Array('prtID'=>69,'ghq'=>'Rail','kpi'=>'COUNT(DISTINCT jobID)', 'date'=>'jobShipmentDate');
$arrKPI[] = Array('prtID'=>53,'ghq'=>'Door delivery','kpi'=>'SUM((SELECT COUNT(jcnID) FROM nlogjc.tbl_job_container WHERE jcnJobID=jobID))', 'date'=>'jobETAPort');

$sql = Array();

$sql[] = "SET @scenario='{$oBudget->id}'";
$sql[] = "DELETE FROM `reg_sales` WHERE scenario=@scenario AND source='Actual';";

for ($i=0; $i<count($arrKPI);$i++){

	echo '<pre>',$arrKPI[$i]['ghq'],'</pre>';
	
	$sql[] = "SELECT  @prtID:=prtID, @jobGHQ:=prtGHQ, @unit:=prtUnit 
				FROM vw_product_type WHERE prtID={$arrKPI[$i]['prtID']};";
	for($m=1+$oBudget->offset;$m<=$ytd;$m++){
	
	$repDateStart = date('Y-m-d',mktime(0,0,0,$m,1,$year));
	$repDateEnd = date('Y-m-d H:i:s',mktime(23,59,59,$m+1,0,$year));
	$month = $oBudget->arrPeriod[$m];

	$sql[] = "SET @dateStart:='{$repDateStart}', @dateEnd:='{$repDateEnd}'";
	$sql[] = "INSERT INTO budget.reg_sales (pc,activity,unit,customer,`{$month}`,source,scenario,active,posted,kpi,sales)
				SELECT jobProfitID, @prtID, @unit, cntID, {$arrKPI[$i]['kpi']} as '{$month}', 'Actual', @scenario, 1,1,1,cntUserID
				FROM nlogjc.tbl_job
				JOIN common_db.tbl_counterparty ON cntID=jobCustomerID
				WHERE {$arrKPI[$i]['date']} BETWEEN @dateStart AND @dateEnd
					AND jobStatusID BETWEEN 15 AND 40
					AND (SELECT COUNT(jitGUID) 
								FROM nlogjc.tbl_job_item 
								LEFT JOIN common_db.tbl_product ON prdID=jitProductID 
								WHERE jitJobID=jobID AND prdCategoryID=@prtID
								)>0				
				GROUP BY jobCustomerID, jobProfitID
				HAVING `{$month}` IS NOT NULL";
				// HAVING  {$arrKPI[$i]['kpi']} IS NOT NULL";
	};
};

//-------------- Intercompany -----------------
$arrKPI = Array();
$arrKPI[] = Array('prtID'=>3,'ghq'=>'Transport','kpi'=>'COUNT(DISTINCT jobID)', 'date'=>'jobShipmentDate');
$arrKPI[] = Array('prtID'=>6,'ghq'=>'Delivery to plant','kpi'=>'COUNT(DISTINCT jobID)', 'date'=>'jobShipmentDate');
$arrKPI[] = Array('prtID'=>11,'ghq'=>'Shunting','kpi'=>'COUNT(DISTINCT jobID)', 'date'=>'jobShipmentDate');

for ($i=0; $i<count($arrKPI);$i++){

	echo '<pre>',$arrKPI[$i]['ghq'],'</pre>';
	
	$sql[] = "SELECT  @prtID:=prtID, @jobGHQ:=prtGHQ, @unit:=prtUnit 
				FROM vw_product_type WHERE prtID={$arrKPI[$i]['prtID']};";
	for($m=1+$oBudget->offset;$m<=$ytd;$m++){
	$repDateStart = date('Y-m-d',mktime(0,0,0,$m,1,$year));
	$repDateEnd = date('Y-m-d H:i:s',mktime(23,59,59,$m+1,0,$year));
	$month = $oBudget->arrPeriod[$m];
	$sql[] = "SET @dateStart:='{$repDateStart}', @dateEnd:='{$repDateEnd}'";
	$sql[] = "INSERT INTO reg_sales (pc,activity,unit,customer,`{$month}`,source,scenario,active,posted,kpi,sales)
				SELECT jobOwnerProfitID, @prtID, @unit, cntID, {$arrKPI[$i]['kpi']} as '{$month}', 'Actual', @scenario, 1,1,1,cntUserID
				FROM intercompany.tbl_job
				JOIN common_db.tbl_counterparty ON cntID=jobCustomerID
				WHERE {$arrKPI[$i]['date']} BETWEEN @dateStart AND @dateEnd
					AND jobStatusID BETWEEN 15 AND 40
					AND (SELECT COUNT(jitGUID) 
								FROM intercompany.tbl_job_item 
								LEFT JOIN common_db.tbl_product ON prdID=jitProductID 
								WHERE jitJobID=jobID AND prdCategoryID=@prtID
								)>0				
				GROUP BY jobCustomerID, jobProfitID
				HAVING  {$arrKPI[$i]['kpi']} IS NOT NULL";
	};
};

for ($i=0;$i<count($sql);$i++){	
	if (!$oSQL->q($sql[$i]) || $_GET['debug']){
		echo '<h2>Error:</h2>';
		echo '<pre>',$sql[$i],'</pre>';
	}
}


?>