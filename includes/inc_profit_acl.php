<?php
//echo '<pre>';print_r($arrUsrData);echo '</pre>';
$flagProfitRestriction = true;

$strRoles = "'".implode("','",$arrUsrData['roleIDs'])."'";

if ($oDocument->GUID){
	$sql = "SELECT MAX(pcrFlagRead) as pcrFlagRead, MAX(pcrFlagUpdate) as pcrFlagUpdate 
			FROM stbl_profit_role 
			WHERE '{$oDocument->profit}' LIKE pcrProfitID 
			AND pcrRoleID IN ($strRoles);";
	// echo '<pre>';print_r($sql);echo '</pre>';
	$rs = $oSQL->q($sql);
	$rw = $oSQL->f($rs);
	if (!$rw['pcrFlagRead']){
		redirect('profit_acl_denied.php?id='.$oDocument->profit);
		die();
	} else {
			$arrUsrData['FlagUpdate'] &= $rw['pcrFlagUpdate'];
			$arrUsrData['FlagWrite'] &= $rw['pcrFlagUpdate'];
	}		
}
?>