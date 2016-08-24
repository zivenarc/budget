<?php
// $flagNoAuth =true;
require ('common/auth.php');
require ('classes/budget.class.php');
// require ('classes/reports.class.php');
include ('includes/inc-frame_top.php');

// $oBudget = new Budget($budget_scenario);
if ($_GET['tab']){
	
	$oBudget = new Budget($_GET['tab']);
	
	$sql = "SELECT * FROM vw_employee_select 
		LEFT JOIN reg_headcount ON particulars=empGUID1C AND posted=1 AND scenario='{$_GET['tab']}'
		LEFT JOIN vw_profit ON pccID=empProfitID
		LEFT JOIN vw_function ON funGUID=empFunctionGUID
		WHERE particulars IS NULL AND empFlagDeleted=0 AND empEndDate >='".date('Y-m-d',$oBudget->date_start)."'
		ORDER BY empProfitID";
	// die($sql);
		
	$rs =$oSQL->q($sql);
	?>
	<ol>
	<?php
	while ($rw=$oSQL->f($rs)){
	?>
	<li><?php echo $rw["empTitleLocal"],' (',$rw["funTitleLocal"],'), ',$rw["pccTitle$strLocal"];?></li>
	<?php
	}
	?>
	</ol>
	<?php
	
		$sql = "SELECT COUNT(particulars) as nCount, EMP.*, funTitleLocal, GROUP_CONCAT(pccTitle) as pccTitle
		FROM reg_headcount 
		JOIN vw_employee_select EMP ON particulars=empGUID1C AND posted=1 AND scenario='{$_GET['tab']}' and source<>'Actual'
		JOIN vw_profit ON pc=pccID
		JOIN vw_function ON funGUID=empFunctionGUID
		GROUP BY particulars
		HAVING COUNT(particulars)>1
		ORDER BY empProfitID";
	// die($sql);
		
	$rs =$oSQL->q($sql);
	?>
	<h3>Двойной учет</h3>
	<ol>
	<?php
	while ($rw=$oSQL->f($rs)){
	?>
	<li><?php echo $rw["empTitleLocal"],' (',$rw["funTitleLocal"],'): ',$rw["pccTitle"];?></li>
	<?php
	}
	?>
	</ol>
	<?php
	
} else {		
	$arrJS[] = 'js/journal.js';
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],'</h1>';
	echo Budget::getScenarioTabs();
	include ('includes/inc-frame_bottom.php');
}






?>