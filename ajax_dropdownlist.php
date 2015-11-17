<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Content-type: application/json"); // JSON

$noCompression = true;

$flagNoAuth = true;
include("common/auth.php");
$q = urldecode($_GET["q"]);
$table = urldecode($_GET["table"]);
$prefix = urldecode($_GET["prefix"]);
$limit = $_GET['limit']?(integer)$_GET['limit']:20;

$fldTitle = Array("Title"=>"Title","TitleLocal"=>"TitleLocal");
if ($table=="stbl_user") $fldTitle=Array("Title"=>"Name","TitleLocal"=>"NameLocal");//--------- Костыли для нестандартной таблицы с юзерами

if (strlen($q)>1){
$sql = "SELECT `".$prefix."ID` as optValue, `".$prefix.$fldTitle["Title"]."` as optText, `".$prefix.$fldTitle["TitleLocal"]."` as optTextLocal
		FROM `".$table."`
		WHERE (`".$prefix.$fldTitle["Title"]."` LIKE '%".addslashes($q)."%' 
		OR `".$prefix.$fldTitle["TitleLocal"]."` LIKE '%".addslashes($q)."%'
		OR `".$prefix.$fldTitle["TitleLocal"]."` LIKE '%".addslashes(mb_convert_case($q, MB_CASE_TITLE, "UTF-8"))."%'
		OR `".$prefix.$fldTitle["TitleLocal"]."` LIKE '%".addslashes(mb_convert_case($q, MB_CASE_UPPER, "UTF-8"))."%'
		)
		".(!$_GET['deleted']?"AND `".$prefix."FlagDeleted`<>1":"")."
		ORDER BY `".$prefix.$fldTitle["Title"]."`, `".$prefix.$fldTitle["TitleLocal"]."`
		LIMIT $limit;";
		
	$rs = $oSQL->do_query($sql);
	$strOutput = "";
	while ($rw=$oSQL->fetch_array($rs)){
	   $strOutput.= ($strOutput!="" ? ",\r\n" : "").json_encode($rw);
	}
	echo "{\"data\":[".$strOutput."]}";

}
//echo $strOutput;

?>