<?php
require_once ('common/auth.php');

$start =date('Y-m-d',$_GET['start']);
$end = date('Y-m-d',$_GET['end']);

$res = Array();
ob_start();

$sql = "SELECT calID, calTitle as title, calDateStart as start, calDateEnd as end, calClass as className FROM tbl_calendar
	WHERE
	DATEDIFF('$end',`calDateStart`)>=0  
	AND DATEDIFF(`calDateEnd`,'$start')>=0";
$rs = $oSQL->do_query($sql);
$i=0;
while ($rw=$oSQL->fetch_array($rs)){
	
	$res[] = Array("id"=>$i
				,"title"=>$rw["title"]
				,"start"=>$rw['start']
				,"end"=>$rw['end']
				,"url"=>'calendar_form.php?calID='.$rw['calID']
				,"className"=>$rw['className']);
	
	
	$i++;
}

echo json_encode($res);
ob_flush();

?>
