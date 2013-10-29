<?php
$flagNoAuth = true;
$itemGUID = $_GET['guid'];
$order = ($_GET['order']=="asc"?"ASC":"DESC");
$limit = ($_GET['limit']?(integer)$_GET['limit']:10);

require ('common/auth.php');

$sql = "SELECT ACL.*, actTitlePast$strLocal as actTitle, usrTitle$strLocal as aclInsertByTitle 
		FROM stbl_action_log ACL 
		JOIN stbl_action ON actID=aclActionID
		JOIN stbl_user ON usrID=aclInsertBy
		WHERE aclGUID =".$oSQL->e($itemGUID)."
		ORDER BY aclID $order LIMIT $limit;";

	// echo $sql;
$rs = $oSQL->q($sql);

ob_start();
$res = Array();

while ($rw = $oSQL->fetch_array($rs)){
$res[] = $rw;
}

if ($_GET['json']){
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
	header('Content-type:application/json; charset=UTF-8');
	echo json_encode($res);

} else {
	
	$data['arrActionLog'] = $res;
	$data['strLocal'] = $strLocal;
	
	if (!is_a($dwoo, 'Dwoo')){
		require_once ('../common/dwoo/dwooAutoload.php');  
		$dwoo = new Dwoo();
	};
	echo $dwoo->output(DWOO_ACTION_LOG, $data);
	
}

ob_flush();
?>