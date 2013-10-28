<?php
$flagNoAuth = true;
$itemGUID = $_GET['guid'];
$order = ($_GET['order']=="asc"?"ASC":"DESC");

require ('common/auth.php');

$sql = "SELECT ACL.*, actTitlePast, actTitlePastLocal, usrTitle, usrTitleLocal 
		FROM stbl_action_log ACL 
		JOIN stbl_action ON actID=aclActionID
		JOIN stbl_user ON usrID=aclInsertBy
		WHERE aclGUID =".$oSQL->e($itemGUID)."
		ORDER BY aclID $order;";

	
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