<?php
// $flagNoAuth =true;
require ('common/auth.php');
require ('classes/budget.class.php');
include ('includes/inc-frame_top.php');

$oBudget = new Budget($budget_scenario);

echo '<h1>',$arrUsrData["pagTitle$strLocal"],'</h1>';

$dateBudgetStart = $oBudget->year.'-01-01';
$dateBudgetEnd = ($oBudget->year+1).'-01-01';
		
$sql = "SELECT *, PERIOD_DIFF(EXTRACT(YEAR_MONTH FROM '{$dateBudgetStart}'), EXTRACT(YEAR_MONTH FROM fixDeprStart)) AS months,
				fixValueStart*(1-PERIOD_DIFF(EXTRACT(YEAR_MONTH FROM '{$dateBudgetStart}'), EXTRACT(YEAR_MONTH FROM fixDeprStart))/fixDeprDuration) as fixValuePrimo,
				fixValueStart*(1-PERIOD_DIFF(EXTRACT(YEAR_MONTH FROM '{$dateBudgetEnd}'), EXTRACT(YEAR_MONTH FROM fixDeprStart))/fixDeprDuration) as fixValueUltimo
				FROM vw_fixed_assets 
				LEFT JOIN vw_item ON itmID=fixItemID
				LEFT JOIN reg_depreciation ON particulars=fixGUID AND scenario='$budget_scenario' AND posted=1
				LEFT JOIN vw_profit ON pccID=fixProfitID
				WHERE DATEDIFF(fixDeprEnd,'{$dateBudgetStart}')>0 
					AND fixFlagDeleted=0 
					AND fixFlagFolder=0
					AND particulars IS NULL					 
				ORDER BY fixProfitID, fixItemID";
		
$rs =$oSQL->q($sql);

echo '<ol>';
while ($rw=$oSQL->f($rs)){
	// print_r($rw);
	echo '<li>',$rw["fixTitle"],' (',$rw['funTitle'],'), ',$rw["pccTitle$strLocal"],' </li>';
}
echo '</ol>';

include ('includes/inc-frame_bottom.php');
?>