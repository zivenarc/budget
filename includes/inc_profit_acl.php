<?php
// echo '<pre>';print_r($arrUsrData);echo '</pre>';

$strRoles = "'".implode("','",$arrUsrData['roleIDs'])."'";

$sql = "SELECT MAX(pcrFlagRead) as pcrFlagRead, MAX(pcrFlagUpdate) as pcrFlagUpdate 
		FROM stbl_profit_role 
		WHERE pcrProfitID=".$oDocument->profit." AND pcrRoleID IN ($strRoles);";
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

?>