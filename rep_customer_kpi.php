<?php
$flagNoAuth=true;
require ('common/auth.php');
require ('classes/reports.class.php');

$budget_scenario = isset($_REQUEST['budget_scenario'])?$_REQUEST['budget_scenario']:$budget_scenario;
$oReport = new Reports(Array('budget_scenario'=>$budget_scenario, 'currency'=>$currency, 'denominator'=>$denominator, 'reference'=>$reference));

if (isset($_POST['activity'])){
	$sqlWhere = " AND activity=".$oSQL->e($_POST['activity']);
	if ($_POST['freehand']){
		$sqlWhere.= " AND bo=714";
	}	
	$sql = "SELECT * FROM vw_product_type WHERE prtID=".$oSQL->e($_POST['activity']);
	$rs = $oSQL->q($sql);
	$rwAct = $oSQL->f($rs);
}

if ($_POST['pccGUID']=='all'){
	$strPCFilter = '';
} else {
	$strPCFilter = " AND pccGUID=".$oSQL->e($_POST['pccGUID']);
}

include ('includes/inc-frame_top.php');
?>
<div id='output'>
<h2><?php echo $rwAct["prtTitle$strLocal"];?></h2>
<?php
if ($_POST['freehand']){
	?><h3>Freehand</h3><?php
}
$oReport->salesByCustomer($strPCFilter.' '.$sqlWhere);
?>
</div>
<?php
include ('includes/inc-frame_bottom.php');
?>