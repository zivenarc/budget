<?php
require ('common/auth.php');

if ($_GET['DataAction']=='commission'){
	require('classes/sales.class.php');
	$sql = "SELECT * FROM tbl_sales WHERE salScenario='B2018_2'";
	$rs = $oSQL->q($sql);
	set_time_limit(10*$oSQL->n($rs));
	while ($rw = $oSQL->f($rs)){
		$oDocument = new Sales($rw['salID']);
		$res = $oDocument->calc_commission();
		for($i=0;$i<count($res);$i++){
			echo '<pre>',$res[$i]['product'],"\t",$res[$i]['charge'],"\t",$res[$i]['type'],"\t",$res[$i]['amount'],"</pre>";
		}
	}
	die();
}


require_once ('classes/entity_list.class.php');

$entID=1;
$entity = new Entity();
$entity->getByID($entID);

$arrTabs = $entity->getProfitTabs($sqlMyFilter);

if ($_GET['ownerID']) {
	$sqlMyFilter = "salInsertBy=".$oSQL->e($_GET['ownerID']);
	//$arrTabs = $entity->getProfitTabs($sqlMyFilter);
}

require ('includes/inc_entity_list.php'); //list function calls;