<?php
/*======================================== Инициализация сущности ===============================*/
$entity = strtolower($rwEntity['entEntity']);
$entity_id = strtolower($rwEntity['entID']);
$prefix = strtolower($rwEntity['entPrefix']);
$table = strtolower($rwEntity['entTable']);
$itemID = $_GET[$prefix."ID"] ? $_GET[$prefix."ID"] : $_POST[$prefix."ID"];

$sql = "SHOW TABLES LIKE 'stbl_attribute_log'";
$rs = $oSQL->do_query($sql);
if ($oSQL->num_rows($rs)) $flagAtrLog = true;

/*---------------------------------------- Инициализация формы ------------------------------------*/
require_once ("../common/easyForm/inc_easyForm.php");
$myForm = new easyForm($entity
	, $table
	, $prefix
	, $itemID
	, $arrUsrData);

/*========================================= ОБРАБОТКА =============================================*/

//$_DEBUG = true;

if ($_POST) {
	$actID = $_POST['actID'];
	logToScreen($_POST,'POST');
	
	if ($flagAtrLog){
		$sqlMonitor = "SELECT * FROM stbl_attribute 
						WHERE atrEntityID = '$entity' OR atrEntityID='$entity_id'
						AND atrFlagMonitor = 1";
		$rs = $oSQL->do_query($sqlMonitor);
		if ($oSQL->num_rows($rs)){
			$sqlAtrLog[] = "SET @aclID:=LAST_INSERT_ID()";
			while ($rw = $oSQL->fetch_array($rs)){
				$arrFieldMonitor[] = $rw['atrType']=='date' ? "DATE_FORMAT('%d.%m.%Y',`".$rw['atrID']."`)" : "`".$rw['atrID']."`";
			};
			$strFieldList = implode(',',$arrFieldMonitor);
			
			$sqlFL = "SELECT $strFieldList FROM `$table` WHERE `".$prefix."ID`='$itemID' LIMIT 0,1";
			$rsFL = $oSQL->do_query($sqlFL);
			while ($rwFL = $oSQL->fetch_array($rsFL)){
				foreach ($rwFL as $key=>$value){
					if ($_POST[$key]!=$value){
						$sqlAtrLog[] = "INSERT INTO stbl_attribute_log (atlActionLogID, atlAttributeID, atlOldValue, atlNewValue)
										SELECT @aclID, '$key', '$value', '".$_POST[$key]."'";
					}
				}
			}
		}
		
		logToScreen($sqlAtrLog,'sqlAtrLog');
	}
	
	$itemID = $myForm->Update();
	
	logToScreen($itemID,'Item ID after MyForm update');
	
	if ($_DEBUG){
	echo "<h2>Action SQL (actSQL):</h2><pre>";
	print_r($actUpdate);
	print_r($arrUpdate);
	print_r($sqlAction);
	echo "</pre>";
	};
		$sql = Array();
		$sql[] = "SET AUTOCOMMIT=0;";
		$sql[] = "START TRANSACTION;";
		
		$sql[] = "INSERT INTO `stbl_action_log` (`aclGUID`, `aclActionID`, `aclComment`, `aclInsertBy`, `aclInsertDate`)
					SELECT `".$prefix."GUID`, 9999, ".$oSQL->escape_string($aclComment).", '$usrID', NOW()
					FROM `".$table."` WHERE `".$prefix."ID`='$itemID';";
		
		if(is_array($sqlAtrLog)) $sql = array_merge($sql,$sqlAtrLog);
		
		$sql[] = "COMMIT;";

		logToScreen($sql,'sql');
		
		//file_put_contents("logs/vac_".$usrID."_".date('Ymd_Hi',time()).".log"	,"POST: ".var_export($_POST,true)."\r\nSQL: ".var_export($sql,true)."\r\nSQL Dump: ".var_export($myForm->SqlDump,true));
		for($i=0;$i<count($sql);$i++) {
			if ($_DEBUG) echo "<pre>",$sql[$i],"</pre>\r\n";
			$rs=$oSQL->do_query($sql[$i]);
		
		/*-----------Почтовый модуль ---------------------*/		
		//require_once ("inc_announce.php");
		
/*---------------------------------------------------------------------------------------------------------------------------*/
	}
	
	SetCookie("UserMessage", ($itemID? "Запись успешно обновлена" : "ERROR: Ошибка записи")
		.($mailSuccess ? ", письмо отослано" : ", письмо не отослано"));
	
	$myForm->key = $itemID;
}

if (!isset($rwMain)){
	$sql = "SELECT * FROM `".$table."` WHERE `".$prefix."ID` = '$itemID' LIMIT 0,1";
	$rs = $oSQL->do_query($sql);
	
	$rwMain = $oSQL->fetch_array($rs);
	unset($sql);
	$oSQL->free_result($rs);
}
$status = (integer)$rwMain[$prefix."StateID"];

/*================== О С Н О В Н А Я   Ф О Р М А ================*/

if(is_array($arrAttrFilter)){
	$strAtrFilter = " AND atrFieldName IN (".preg_replace('/([a-z0-9]+)/i',"'$1'",implode(',',$arrAttrFilter)).")";
}

$sqlAttr = "SELECT ATR.* FROM `stbl_attribute` ATR 
WHERE atrEntityID='$table'  OR atrEntityID='$entity_id'
AND (
	(`atrFieldName`<>'".$prefix."InsertBy')
	AND (`atrFieldName`<>'".$prefix."InsertDate')
	AND (`atrFieldName`<>'".$prefix."EditBy')
	AND (`atrFieldName`<>'".$prefix."EditDate')
) $strAtrFilter
ORDER BY atrOrder ASC";

$oSQL->free_result($rsAttr);
$rsAttr = $oSQL->do_query($sqlAttr);

while ($rwAttr=$oSQL->fetch_array($rsAttr)){
	
	if ($rwAttr["atrGroup$strLocal"]!=$strGroup) {
		$myForm->Columns[] = Array('type'=>'html','data'=>($strGroup?'</fieldset>':'').($rwAttr["atrGroup$strLocal"]?'<fieldset><legend>'.$rwAttr["atrGroup$strLocal"].'</legend>':'</fieldset>'));
	}
	$strGroup = $rwAttr["atrGroup$strLocal"];
	if (!$strGroup) $flagFieldsetCLosed = true;
	
	efFillArray($rwAttr, &$myForm->Columns);
	
}

logToScreen($sqlAttr,'sqlAttr');
logToScreen($myForm, 'myForm');


	
/*----------------------------------------------------- История изменений --------------------------------------------------------------------*/
if ($itemID && $flagAtrLog){
	$sql = "SELECT ACL.*, usrTitle$strLocal as aclInsertByTitle
			FROM stbl_action_log ACL 
			JOIN stbl_user ON usrID=ACL.aclInsertBy
			WHERE aclGUID = '".$rwMain[$prefix.'GUID']."'
			ORDER BY aclID DESC";
	$rs = $oSQL->do_query($sql);
	while ($rwH=$oSQL->fetch_array($rs)){
		$sqlAttrLog = "SELECT ATL.*, ATR.atrTitle$strLocal as atrTitle FROM stbl_attribute_log ATL
						JOIN stbl_attribute ATR ON atrID=atlAttributeID
						WHERE atlActionLogID = '".$rwH['aclID']."'";
		$rsAttr = $oSQL->do_query($sqlAttrLog);
		while ($rw = $oSQL->fetch_array($rsAttr)){
			$rwH['attribute_log'][] = $rw;
		}
		$arrActionLog[]=$rwH;
	}
}

/*----------------------------------------------------- Файлы -------------------------------------------------------*/

if ($itemID){
	$sql = "SELECT FIL.*, usrTitle$strLocal as filInsertByTitle
			FROM stbl_file FIL 
			JOIN stbl_user ON usrID=FIL.filInsertBy
			WHERE filEntityID='".$rwMain[$prefix.'GUID']."' AND filSize>0 ORDER BY filID DESC;";
	$rs = $oSQL->do_query($sql);
	while ($rwF=$oSQL->fetch_array($rs)){
		$arrNames = explode("/",$rwF['filName']);
		$rwF['filName']=array_pop($arrNames);
		$arrFile[]=$rwF;
	}

}

//------------------- Read the main form data

$myForm->Read($oSQL);
?>