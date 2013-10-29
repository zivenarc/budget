<?php
require ('common/auth.php');
require_once ('classes/entity_list.class.php');

$entID=2;
$entity = new Entity();
$entity->getByID($entID);

$arrTabs = $entity->getLocationTabs($sqlMyFilter);

if ($_GET['ownerID']) {
	$sqlMyFilter = "lcoInsertBy=".$oSQL->e($_GET['ownerID']);
	//$arrTabs = $entity->getProfitTabs($sqlMyFilter);
}

require ('includes/inc_entity_list.php'); //list function calls;