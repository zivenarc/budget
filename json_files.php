<?php
//$flagNoAuth = true;
$itemGUID = $_GET['guid'];
$order = ($_GET['order']=="asc"?"ASC":"DESC");

require ('common/auth.php');

$sql = "SELECT filName as alias
			, filType as type
			, filGUID as file
			, filInsertDate as date
			, filSize as size
			, USR.usrName$strLocal as author, usrFlagDeleted
			FROM stbl_file FIL 
			JOIN stbl_user USR ON usrID=filInsertBy
			WHERE filEntityID=".$oSQL->e($itemGUID)." AND filSize>0 ORDER BY filID $order;";

	
$rs = $oSQL->do_query($sql);

ob_start();
$res = Array();

while ($rw = $oSQL->fetch_array($rs)){
	$rw['size'] = convert_size_human($rw['size']);
	$rw['class']=str_replace('.','_',basename($rw['filType']));
	$res[] = $rw;
}

echo json_encode($res);

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
header('Content-type:application/json; charset=UTF-8');

ob_flush();
?>