<?php
ini_set("zlib.output_compression","1");
header("Content-Type: text/html; charset=UTF-8");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");




ob_start();

require ("../common/common.php");
require ("config.php");
require ("common.php");

$js_path = "";

$oSQL = new sql($DBHOST, $DBUSER, $DBPASS, $DB, false, CP_UTF8);
$oSQL->connect();

if (!$flagNoAuth){
    // checking is session available

   session_set_cookie_params(12*60*60, "/");
   session_start();
   
    if (!$_SESSION["usrID"]){
       SetCookie("PageNoAuth", $_SERVER["PHP_SELF"].($_SERVER["QUERY_STRING"]!="" ? ("?".$_SERVER["QUERY_STRING"]) : ""));
       header("HTTP/1.0 401 Unauthorized");
       header ("Location: login.php");
       die();
    }
    //print_r($_COOKIE);
    $arrUsrData = checkPermissions($oSQL);
    
	switch ($_GET['lang']){
	case 'ru':
		SetCookie('strLocal','Local',time()+60*60*24*365);
		$strLocal = "Local";
	break;
	
	case 'en':
		SetCookie('strLocal','',time()+60*60*24*365);
		$strLocal = "";
	break;
	
	default:
		$strLocal = isset($_COOKIE['strLocal'])?$_COOKIE['strLocal']:($arrUsrData["usrFlagLocal"]==1 ? "Local" : "");
	break;
}
	
	if ($strLocal) setlocale(LC_TIME, 'ru');
}

    

    
require ("../common/inc_setup.php");
//require ("../common/inc_russtuff.php");

readUserData($arrUsrData);

if ($strLocal){
	require_once ("../common/language/ru.php");
} else {
	require_once ("../common/language/en.php");
};

$arrCurr = Array('EUR'=> 'EUR', 'LOC'=>$arrSetup['stpLocalCurrencyName'],'USD'=>'USD');
define ('UPLOAD_DIR',$arrSetup['stpUploadPath']);
ini_set("SMTP",$arrSetup['stpSMTPAddress']);

//===============Fill the profit array=========================
$sql = "SELECT * FROM vw_profit";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	$arrProfitConfig[$rw['pccID']] = $rw;
}
// echo '<pre>';print_r($arrProfitConfig);echo '</pre>';

//require ("lang_en.php");
$budget_scenario = $arrSetup['stpScenarioID'];
?>