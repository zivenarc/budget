<?php
//$flagNoAuth = true;
require ('common/auth.php');

$id = $_GET['id']?urldecode($_GET['id']):'';
$q = urldecode($_GET["term"]);
$table = urldecode($_GET["table"]);
$limit = $_GET['limit']?(integer)$_GET['limit']:10;
//$prefix = urldecode($_GET["prefix"]);

if (strlen($q)>1 || $id){

$sql = "SHOW TABLES LIKE '$table'";
//$rs = $oSQL->q($sql);
if ($rw = $oSQL->d($sql)){
	
	$sql = "SHOW COLUMNS FROM `$rw`";
	$id_col = $oSQL->d($sql);
	$prefix = substr($id_col,0,3);
	
	$fldTitle = Array("Title"=>"{$prefix}Title","TitleLocal"=>"{$prefix}TitleLocal");
	if ($table=="stbl_user") $fldTitle=Array("Title"=>"{$prefix}Name","TitleLocal"=>"{$prefix}NameLocal");//--------- Костыли для нестандартной таблицы с юзерами
	
	if ($id) {
		$sql = "SELECT `{$prefix}ID` as value, `{$fldTitle["Title$strLocal"]}` as label
				FROM `$table`
				WHERE `{$prefix}ID` = '$id' 				
				LIMIT 1;";
	} else {
		$sql = "SELECT `{$prefix}ID` as value, `{$fldTitle["Title$strLocal"]}` as label
				FROM `$table`
				WHERE (`{$fldTitle["Title"]}` LIKE '%".addslashes($q)."%' 
				OR `{$fldTitle["TitleLocal"]}` LIKE '%".addslashes($q)."%' 
				OR `{$fldTitle["TitleLocal"]}` LIKE '%".addslashes(mb_convert_case($q, MB_CASE_TITLE, "UTF-8"))."%'
				OR `{$fldTitle["TitleLocal"]}` LIKE '%".addslashes(mb_convert_case($q, MB_CASE_UPPER, "UTF-8"))."%')
				AND `{$prefix}FlagDeleted`<>1
				ORDER BY `{$fldTitle["Title"]}`, `{$fldTitle["TitleLocal"]}`
				LIMIT $limit;";
	}
		
		$rs = $oSQL->q($sql);
		//if (mysql_num_rows($rs)==0) echo $sql;
		while ($rw=$oSQL->f($rs)){
			$arrOutput[] = $rw;
		}
		
		header("Cache-Control: no-cache, must-revalidate");
		header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
		header('Content-type:application/json; charset=UTF-8');
		echo json_encode($arrOutput);
		
	} else {
		echo "ERROR: Table '$table' doesn't exist";
	}
	echo $strOutput;
	
}
?>