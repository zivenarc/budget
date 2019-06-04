<?php
//////////////////---------------PC filter----------------------
switch($bu_group){
	case 'no_h':
	case 0:	
		$sql = "SELECT * FROM common_db.tbl_profit WHERE pccFlagFolder=0";
		break;
	default:
		$sql = "SELECT * FROM common_db.tbl_profit WHERE pccParentCode1C='{$bu_group}'";
		break;
};

$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	$arrBus[] = $rw['pccID']; 
}

if ($_GET['pccGUID']=='all'){
	
	if(is_array($arrUsrData['roleIDs'])) $strRoles = "'".implode("','",$arrUsrData['roleIDs'])."'";
	$strBUs = implode(',',$arrBus);
	
	if($bu_group=='no_h'){
		$sql = "SELECT DISTINCT pccID 
				FROM stbl_profit_role 
				JOIN common_db.tbl_profit ON pccID LIKE pcrProfitID
				WHERE pcrRoleID IN ({$strRoles}) 
					AND pcrFlagRead=1 
					AND pccFlagFolder=0";			
	
	} elseif ($bu_group){
		
		// $sql = "SELECT DISTINCT pcrProfitID FROM stbl_profit_role WHERE pcrRoleID IN ($strRoles) AND pcrFlagRead=1 AND pcrProfitID IN ({$strBUs})";
		$sql = "SELECT DISTINCT pccID FROM common_db.tbl_profit WHERE pccID IN ({$strBUs})";
	} else {		
		// $sql = "SELECT DISTINCT pcrProfitID FROM stbl_profit_role WHERE pcrRoleID IN ($strRoles) AND pcrFlagRead=1";
		$sql = "SELECT DISTINCT pccID FROM common_db.tbl_profit WHERE pccFlagFolder=0";
	}
	$rs = $oSQL->q($sql);
	while ($rw = $oSQL->f($rs)){
		// $arrPC[] = $rw['pcrProfitID'];
		$arrPC[] = $rw['pccID'];
	}		
} else {
	$sql = "SELECT pccID FROM vw_profit WHERE pccGUID=".$oSQL->e($_GET['pccGUID']);
	$rs = $oSQL->q($sql);
	while ($rw = $oSQL->f($rs)){
		$arrPC[] = $rw['pccID'];
	}
	$sql = "SELECT pccID FROM vw_profit WHERE pccParentCode1C IN (SELECT pccCode1C FROM vw_profit WHERE pccGUID=".$oSQL->e($_GET['pccGUID']).")";
	$rs = $oSQL->q($sql);
	while ($rw = $oSQL->f($rs)){
		$arrPC[] = $rw['pccID'];
	}	
}
	// $sqlWhere = "WHERE pc in (".implode(',',$arrPC).")";

$filter['pc'] = $arrPC;







?>