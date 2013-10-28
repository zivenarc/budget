<?php
$flagNoAuth = true;
require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/reference.class.php');
require ('classes/yact_coa.class.php');
require ('classes/employees.class.php');

$oBudget = new Budget('B2014');
$oDoc = new budget_session($oBudget->id);

echo '<pre>';print_r($oDoc);echo '</pre>';

$Employees = new Employees();
$YACT_COA = new YACT_COA();

while ($Employees->next()){
	$employee = $Employees->current;
	//$oBR = $oDoc->add_master();
	$oHR = $oDoc->add_headcount();
	
	$oHR->particulars = Array('type'=>'EMP','obj'=>$employee);
	$oHR->account = $YACT_COA->getByCode('502000');
	$oHR->profit = $employee->profit;
	$oHR->activity = $employee->activity;
	$oHR->salary = $employee->salary;
	$oHR->function = $employee->job;
	
	for($m=1;$m<13;$m++){
		$oHR->set_month_value($m,1);
	}
	// for($m=1;$m<$oBudget->settings['salary_review_month'];$m++){
		// $oBR->set_month_value($m,-$employee->salary);
	// }
	// for($m=$oBudget->settings['salary_review_month'];$m<13;$m++){
		// $oBR->set_month_value($m,-$employee->salary*(1+$oBudget->settings['salary_increase_ratio']));
	// }
	
}

include ('includes/inc-frame_top.php');
echo '<pre>';print_r($oDoc);'</pre>';
$oDoc->save();









?>