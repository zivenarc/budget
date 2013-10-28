<?php
require ('common/auth.php');
require ('classes/budget.class.php');




if(!isset($_GET['tab'])){
	$arrJS[]='js/input_form.js';
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],'</h1>';
	Budget::getProfitTabs('reg_sales');
	include ('includes/inc-frame_bottom.php');
} else {
	require ('classes/reports.class.php');
	$sqlWhere = "WHERE pc in (SELECT pccID FROM vw_profit WHERE pccGUID=".$oSQL->e($_GET['tab']).")";
	Reports::salesByActivity($sqlWhere);
}


?>