<?php
require ('common/auth.php');
require_once ('classes/entity_list.class.php');

$entID=4;
$entity = new Entity();
$entity->getByID($entID);

$arrTabs = $entity->getScenarioTabs($sqlMyFilter);

if ($_GET['ownerID']) {
	$sqlMyFilter = "cemInsertBy=".$oSQL->e($_GET['ownerID']);
	//$arrTabs = $entity->getProfitTabs($sqlMyFilter);
}

require ('includes/inc_entity_list.php'); //list function calls;