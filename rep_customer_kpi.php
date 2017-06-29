<?php
$flagNoAuth=true;
require ('common/auth.php');
require ('classes/reports.class.php');

$budget_scenario = isset($_REQUEST['budget_scenario'])?$_REQUEST['budget_scenario']:$budget_scenario;

$filter = $_POST['filter'];

$oReport = new Reports(Array('budget_scenario'=>$budget_scenario, 'currency'=>$currency, 'denominator'=>$denominator, 'reference'=>$reference,'filter'=>$filter));

if (isset($_POST['filter']['activity'])){
	$sql = "SELECT * FROM vw_product_type WHERE prtID=".$oSQL->e($_POST['filter']['activity']);
	$rs = $oSQL->q($sql);
	$rwAct = $oSQL->f($rs);	
}

if (isset($_POST['filter']['route'])){
	$sql = "SELECT * FROM tbl_route WHERE rteID=".$oSQL->e($_POST['route']);
	$rs = $oSQL->q($sql);
	$rwRte = $oSQL->f($rs);
}
include ('includes/inc-frame_top.php');
?>
<div id='output'>
<h2><?php echo $rwAct["prtTitle$strLocal"]," | ",($rwRte['rteTitle']?$rwRte['rteTitle']:'all routes');?></h2>
<?php
if ($_POST['filter']['freehand']){
	?><h3>Freehand</h3><?php
}
$oReport->salesByCustomer($strPCFilter.' '.$sqlWhere);
?>
</div>
<?php
include ('includes/inc-frame_bottom.php');
?>