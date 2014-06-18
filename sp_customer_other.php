<?php
$flagNoAuth = true;
require ('common/auth.php');

$sql = "UPDATE reg_master, vw_profit
		SET customer=9802 
		WHERE customer=".(integer)$_POST['customer']." 
		AND pc=pccID
		AND pccGUID=".$oSQL->e($_POST['pccGUID'])." 
		AND source IN ('estimate','Actual')
		AND scenario='$budget_scenario'";
echo '<pre>',$sql, '</pre>';
$oSQL->q($sql);
?>