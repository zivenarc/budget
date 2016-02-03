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

$arrKPI[] = Array('prtID'=>48,'ghq'=>'Ocean import','kpi'=>'SUM(jobTEU)');
$arrKPI[] = Array('prtID'=>63,'ghq'=>'Ocean export','kpi'=>'SUM(jobTEU)');

$sql = Array();

$sql[] = "SET @scenario='{$oBudget->id}'";
$sql[] = "DELETE FROM `reg_sales` WHERE scenario=@scenario AND source='Actual';";

for ($i=0; $i<count($arrKPI);$i++){
	$sql[] = "SET @prtID:={$arrKPI[$i]['prtID']}, @jobGHQ:='{$arrKPI[$i]['ghq']}';";
	for($m=1;$m<=$ytd;$m++){
	
	$repDateStart = date('Y-m-d',mktime(0,0,0,$m,1,$year));
	$repDateEnd = date('Y-m-d H:i:s',mktime(23,59,59,$m+1,0,$year));
	$month = $oBudget->arrPeriod[$m];

	$sql[] = "SET @dateStart:='{$repDateStart}', @dateEnd:='{$repDateEnd}'";
	$sql[] = "INSERT INTO reg_sales (pc,activity,customer,`{$month}`,source,scenario,active,posted,kpi,sales)
				SELECT jobProfitID, @prtID, cntID, {$arrKPI[$i]['kpi']} as '{$month}', 'Actual', @scenario, 1,1,1,cntUserID
				FROM nlogjc.tbl_job 
				JOIN common_db.tbl_counterparty ON cntID=jobCustomerID
				WHERE jobETAPort BETWEEN @dateStart AND @dateEnd AND jobGHQ=@jobGHQ
				GROUP BY jobCustomerID, jobProfitID
				HAVING  {$arrKPI[$i]['kpi']} IS NOT NULL";
	};
};

for ($i=0;$i<count($sql);$i++){
	$oSQL->q($sql[$i]);
}


?>