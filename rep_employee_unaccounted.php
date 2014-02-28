<?php
// $flagNoAuth =true;
require ('common/auth.php');
require ('classes/reports.class.php');
include ('includes/inc-frame_top.php');

echo '<h1>',$arrUsrData["pagTitle$strLocal"],'</h1>';

$sql = "SELECT * FROM vw_employee_select 
		LEFT JOIN reg_headcount ON particulars=empGUID1C AND posted=1 AND scenario='$budget_scenario'
		LEFT JOIN vw_profit ON pccID=empProfitID
		WHERE particulars IS NULL  
		ORDER BY empProfitID";//die($sql);
		
$rs =$oSQL->q($sql);

echo '<ol>';
while ($rw=$oSQL->f($rs)){
	// print_r($rw);
	echo '<li>',$rw["empTitle$strLocal"],' (',$rw["funTitle$strLocal"],'), ',$rw["pccTitle$strLocal"],' </li>';
}
echo '</ol>';

include ('includes/inc-frame_bottom.php');
?>