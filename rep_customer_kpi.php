<?php
$flagNoAuth=true;
require ('common/auth.php');
require ('classes/reports.class.php');

$budget_scenario = isset($_REQUEST['budget_scenario'])?$_REQUEST['budget_scenario']:$budget_scenario;
$oReport = new Reports(Array('budget_scenario'=>$budget_scenario, 'currency'=>$currency, 'denominator'=>$denominator, 'reference'=>$reference));

if (isset($_POST['filter']['activity'])){
	$sqlWhere = " AND activity=".$oSQL->e($_POST['filter']['activity']);
	if ($_POST['freehand']){
		$sqlWhere.= " AND freehand=1";
	}
	$sql = "SELECT * FROM vw_product_type WHERE prtID=".$oSQL->e($_POST['filter']['activity']);
	$rs = $oSQL->q($sql);
	$rwAct = $oSQL->f($rs);
}

if (isset($_POST['route'])){
	$sqlWhere .= " AND route=".$oSQL->e($_POST['route']);
	$sql = "SELECT * FROM tbl_route WHERE rteID=".$oSQL->e($_POST['route']);
	$rs = $oSQL->q($sql);
	$rwRte = $oSQL->f($rs);
}

if ($_POST['pccGUID']=='all'){
	$strPCFilter = '';
} else {
	if (isset($_POST['pccGUID'])){
		$strPCFilter = " AND pccGUID=".$oSQL->e($_POST['pccGUID']);
	} elseif (isset($_POST['filter']['pc'])) {
		if(is_array($_POST['filter']['pc'])){
			$strPCFilter = " AND pc IN (".implode(',', $_POST['filter']['pc']).")";
		} else {
			$strPCFilter = " AND pc=".$oSQL->e($_POST['filter']['pc']);
		}
	}
}

include ('includes/inc-frame_top.php');
?>
<div id='output'>
<h2><?php echo $rwAct["prtTitle$strLocal"]," | ",$rwRte['rteTitle'];?></h2>
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