<?php
//$flagNoAuth = true;
//$usrID = 'zhuravlev';
$itemGUID = $_GET['guid'];
$limit = (integer)$_GET['limit'];

require ('common/auth.php');

$sql = "SELECT MSL.*, SENDER.usrName$strLocal as usrTitle, RECIPIENT.usrName$strLocal as msgRecipient
					FROM tbl_message_log MSL
					JOIN stbl_user SENDER ON SENDER.usrID=msgInsertBy
					JOIN stbl_user RECIPIENT ON RECIPIENT.usrID=msgRecipientID
					WHERE (msgRecipientID='$usrID' OR msgInsertBy='$usrID') AND msgGUID=".$oSQL->e($itemGUID)."
					ORDER BY msgID DESC ".($limit?" LIMIT {$limit}":"");

	
$rs = $oSQL->do_query($sql);

ob_start();
$res = Array();

while ($rw = $oSQL->fetch_array($rs)){
$res[] = $rw;
}

echo json_encode($res);

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
header('Content-type:application/json; charset=UTF-8');

ob_flush();
?>