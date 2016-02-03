<?php
$flagNoAuth = true;
require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/reports.class.php');

include ('includes/inc_report_settings.php');

$oBudget = new Budget($budget_scenario);

if ($oBudget->type=='Budget') die('Wrong budget type, cannot fill in the actuals');

$ytd = date('n',$oBudget->date_start-1);echo $ytd;
$year = date('Y',$oBudget->date_start-1);

$arrKPI[] = Array('prtID'=>48,'ghq'=>'Ocean import','kpi'=>'SUM(jobTEU)', 'date'=>'jobETAPort');
$arrKPI[] = Array('prtID'=>63,'ghq'=>'Ocean export','kpi'=>'SUM(jobTEU)', 'date'=>'jobShipmentDate');
$arrKPI[] = Array('prtID'=>46,'ghq'=>'Air import','kpi'=>'SUM(jobGrossWeight)', 'date'=>'jobETAPort');
$arrKPI[] = Array('prtID'=>47,'ghq'=>'Air export','kpi'=>'SUM(jobGrossWeight)', 'date'=>'jobShipmentDate');

$sql = Array();

$sql[] = "SET @scenario='{$oBudget->id}'";
$sql[] = "DELETE FROM `reg_sales` WHERE scenario=@scenario AND source='Actual';";

for ($i=0; $i<count($arrKPI);$i++){
	$sql[] = "SELECT  @prtID:=prtID, @jobGHQ:=prtGHQ, @unit:=prtUnit 
				FROM vw_product_type WHERE prtID={$arrKPI[$i]['prtID']};";
	for($m=1;$m<=$ytd;$m++){
	
	$repDateStart = date('Y-m-d',mktime(0,0,0,$m,1,$year));
	$repDateEnd = date('Y-m-d H:i:s',mktime(23,59,59,$m+1,0,$year));
	$month = $oBudget->arrPeriod[$m];

	$sql[] = "SET @dateStart:='{$repDateStart}', @dateEnd:='{$repDateEnd}'";
	$sql[] = "INSERT INTO reg_sales (pc,activity,unit,customer,`{$month}`,source,scenario,active,posted,kpi,sales)
				SELECT jobProfitID, @prtID, @unit, cntID, {$arrKPI[$i]['kpi']} as '{$month}', 'Actual', @scenario, 1,1,1,cntUserID
				FROM tbl_job
				JOIN vw_counterparty ON cntID=jobCustomerID
				WHERE {$arrKPI[$i]['date']} BETWEEN @dateStart AND @dateEnd
					AND jobStatusID BETWEEN 15 AND 40
					AND (SELECT COUNT(jitGUID) 
								FROM tbl_job_item 
								LEFT JOIN vw_product ON prdID=jitProductID 
								WHERE jitJobID=jobID AND prdCategoryID=@prtID
								)>0				
				GROUP BY jobCustomerID, jobProfitID
				HAVING  {$arrKPI[$i]['kpi']} IS NOT NULL";
	};
};

for ($i=0;$i<count($sql);$i++){
	echo '<pre>',$sql[$i],'</pre>';
	$oSQL->q($sql[$i]);
}


?>