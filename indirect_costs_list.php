<?php
require ('common/auth.php');
require_once ('classes/entity_list.class.php');

$entID=6;
$entity = new Entity();
$entity->getByID($entID);

$arrTabs = $entity->getProfitTabs($sqlMyFilter);

if ($_GET['ownerID']) {
	$sqlMyFilter = "icoInsertBy=".$oSQL->e($_GET['ownerID']);
	//$arrTabs = $entity->getProfitTabs($sqlMyFilter);
}

require ('includes/inc_entity_list.php'); //list function calls;