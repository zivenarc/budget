<?php
$activity = (integer)$_GET['activity'];
if (isset($_GET['ghq'])) $ghq = urldecode($_GET['ghq']);
if (isset($_GET['unit'])) $unit = urldecode($_GET['unit']);

$budget_scenario = isset($_GET['budget_scenario'])?$_GET['budget_scenario']:$budget_scenario;

$oBudget = new Budget($budget_scenario);
$denominator = isset($_GET['denominator'])?(double)$_GET['denominator']:1;

$arrJS[] = 'js/rep_totals.js';


if ($denominator!=1) {
	echo '<h2>RUB x',$denominator,'</h2>';
}
if ($activity){
	$sql = "SELECT prtTitle FROM vw_product_type WHERE prtID={$activity}";
	$rs = $oSQL->q($sql);
	$subtitle = "Activity: ".$oSQL->get_data($rs);
	$sqlActivityFilter = "AND activity={$activity}";
}
if (isset($_GET['ghq'])){
	$sql = "SELECT prtID FROM vw_product_type WHERE prtGHQ=".$oSQL->e($_GET['ghq']);
	$rs = $oSQL->q($sql);
	while ($rw = $oSQL->f($rs)){
		$arrActivity[] = $rw['prtID'];
	}
	$subtitle = "GHQ: ".$ghq;
	if ($_GET['ghq']==''){
		$sqlActivityFilter = "AND activity IS NULL";
	} else {
		$sqlActivityFilter = "AND activity IN (".implode(',',$arrActivity).")";
	}
}
if ($unit){
	$sql = "SELECT prtID, prtTitle FROM vw_product_type WHERE prtUnit=".$oSQL->e($_GET['unit']);
	$rs = $oSQL->q($sql);
	while ($rw = $oSQL->f($rs)){
		$arrActivity[] = $rw['prtID'];
		$arrHref[] = "<span><a href='{$_SERVER['PHP_SELF']}?activity={$rw['prtID']}'>{$rw['prtTitle']}</a></span>";
	}
	$subtitle = $unit.implode(', ',$arrHref);
	$sqlActivityFilter = "AND activity IN (".implode(',',$arrActivity).")";
}
?>