<?php
//header("Content-type: text/xml");
header("Cache-Control: max-age=3600, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
if (!$_POST){ //--- for tesing purposes
$_POST["table"]="tbl_counterparty";
$_POST["cntID"]="1396";
}

require ('common/auth.php');


$strTable = array_pop(explode("_",$_POST["table"]));
foreach ($_POST as $key=>$value){
	$arrWhere[$key] = "`$key` = ".$oSQL->escape_string($value); 
}
unset($arrWhere['table']); 
$strWhere = implode (" AND ",$arrWhere);

$sql = "SELECT `".$_POST["table"]."`.* FROM `".$_POST["table"]."` WHERE $strWhere";

$strOutput .="<?xml version=\"1.0\" encoding=\"utf-8\"?>\r";
//$strOutput .="<sql>$sql</sql>";
$strOutput .="<details>\r";
$rs = $oSQL->do_query($sql);


	while ($rw[]=$oSQL->fetch_array($rs)){
	$strOutput .="<$strTable>\r";
		//print_r($rw);
		foreach ($rw as $key=>$value){
			if ($j % 2) {
				$strOutput .= "<$key>";
				$strOutput .= $value;
				$strOutput .= "</$key>\r";
			}
			$j++;
		}
	$strOutput .="</$strTable>\r";	
	}
	if ($oSQL->num_rows($rs)>1){
		echo json_encode($rw);
	} else {
		echo json_encode($rw[0]);
	};


$strOutput .="</details>";
//echo $strOutput;

?>