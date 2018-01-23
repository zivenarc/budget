<?php
// $flagNoAuth = true; $usrID = 'zhuravlev'; 
// $_DEBUG = true;
//error_reporting(E_ALL);

require ('common/auth.php');
require ('classes/budget.class.php');
ini_set("SMTP",$arrSetup['stpSMTPAddress']);

/*------------- Parameters ------------------------------------------------
ID - Entity item ID (primary key)
recipient - "To" recipient, may take multiple values divided by semicolon
recipient_cc - "Cc" recipients
entity - text name of entity

For better usability, a custom view 'vw_%entity%' may be created, and "%%%TItle" field corrected
-------------------------------------------------------------------------*/

// $sql = "SELECT * FROM stbl_entity WHERE entEntity=".$oSQL->e($_POST['entity'])." LIMIT 1";
$sql = "SELECT * FROM stbl_entity WHERE entTable=".$oSQL->e($_POST['table'])." LIMIT 1";
$rs=$oSQL->q($sql);
$rwEntity=$oSQL->f($rs);
$prefix = $rwEntity['entPrefix'];
$table = $rwEntity['entTable'];

$recipient = $_POST['recipient'];
$message = $_POST['message'];

$PK = $prefix."ID";
$flagImportant = (integer)$_POST['flagImportant'];

$arrCCMail = Array();
if ($_POST['recipient_cc']){
	// $strCC = preg_replace(Array('/([a-zA-Z]+)/i','/;/'),Array('\'$1\'',','),$recipient_cc);
	$sql = "SELECT * FROM `stbl_user` WHERE `usrID` IN (".$oSQL->e($_POST['recipient_cc']).")";
	$rs=$oSQL->q($sql);
	while($rw=$oSQL->f($rs)){
		$arrCCMail[] = $rw['usrEmail'];
	};
}



$sql = "INSERT INTO tbl_message_log (msgGUID, msgRecipientID, msgText, msgInsertBy, msgFlagImportant, msgType, msgEntityID)
			SELECT `{$prefix}GUID`, ".$oSQL->e($_POST['recipient']).", ".$oSQL->e($_POST['message']).",'{$usrID}', {$flagImportant}, 1, '{$rwEntity['entID']}'
			FROM `{$table}` WHERE `{$PK}`=".$oSQL->e($_POST['ID']);
$rs = $oSQL->q($sql);


// $sql = "SELECT TABLE_NAME FROM information_schema.TABLES T WHERE T.TABLE_NAME = 'tbl_$entity' AND TABLE_SCHEMA = '$DB'";
// $rs=$oSQL->q($sql);
// if($rw=$oSQL->f($rs)){
	// $table = $rw['TABLE_NAME'];
// };

$sql = "SELECT `{$prefix}ID` AS Title, `{$prefix}Scenario` as Scenario FROM `$table` WHERE `$PK`='{$_POST['ID']}'";
$rs=$oSQL->q($sql);
$rw=$oSQL->f($rs);
// echo '<pre>';print_r($rw);echo '</pre>';

$oBudget = new Budget($rw["Scenario"]);

// $strSender = GetUserNameByID($ldap_conn,$usrID,"fn_sn",$oSQL);
$strSender = $arrUsrData['usrTitle'];
$strRecipient = GetUserNameByID($ldap_conn,$recipient,"fn_sn",$oSQL);

$mailData = Array('title' => $rw['Title'],
				'recipient'=> $strRecipient ,
				'sender'=> $strSender,
				'message'=>$message,
				'entity'=>$rwEntity['entTitle']
				,'href'=>$_SERVER['HTTP_REFERER']);

require_once ('../common/dwoo/dwooAutoload.php');  
$dwoo = new Dwoo();
ob_start();
$dwoo->output('templates/sp_inform.tpl', $mailData);
$messageText = ob_get_clean();

$to = GetUserMail($recipient);

$subjectRaw = "[Budget][{$oBudget->title}]{$rwEntity['entTitle']} #{$mailData['title']} for your attention";
$subject = "=?utf-8?B?".base64_encode($subjectRaw)."?=";

$headers = 
	// 'From: '.ini_get('sendmail_from')."\r\n" .
	"From: $strSender <{$arrUsrData['usrEmail']}>\r\n".
    'Reply-To: '.GetUserMail($usrID)."\r\n" .
    'Cc: '.implode(',',$arrCCMail)."\r\n" .
//	"Bcc: application.sandbox@gmail.com\r\n".
	'Content-Type: text/html; charset=utf-8'."\r\n".
    'X-Mailer: PHP/' . phpversion();


if ($_DEBUG){
	echo "<pre>$headers</pre>";
	echo "<h2>$subjectRaw</h2>";
	echo $messageText;
} else {
	header('Content-type:application/json');
	$res = Array('SMTP'=>$arrSetup['stpSMTPAddress'],
				'msgRecipient'=>$strRecipient,
				'to'=>$to,
				'msgText'=>$message,
				'msgInsertDate'=>date('Y-m-d H:i:s',mktime()),
				'usrTitle'=>$strSender,
				'headers'=>$headers);
	ob_start();
	$mail_res = mail($to, $subject, $messageText, $headers);
	if (!$mail_res) {
		$res['status'] = 'error';
		$res['errorText'] = ob_get_clean();
	} else {
		$res['status']='success';
		ob_end_clean();
	}
	echo json_encode($res);
};


?>