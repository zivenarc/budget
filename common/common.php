<?php 
require ('../common/izintra/izintra.class.php');
$arrJS[] = '../common/jquery/jquery-2.1.1.min.js';
$arrJS[] = '../common/jquery/jquery-ui-1.12.0.custom/jquery-ui.min.js';
//$arrJS[] = 'js/ef_common.js';
$arrCSS[] = "../common/izintra/style.css";
$arrCSS[] = "common/budget.css";
$arrCSS[] = Array('file'=>"common/print.css",'media'=>'print');
// $arrCSS[] = "../common/jquery/jquery-ui-1.12.0.custom/themes/redmond/jquery-ui.css";
$arrCSS[] = '../common/jquery/jquery-ui-1.12.0.custom/jquery-ui.css';
$arrCSS[] = "../common/jquery/jquery-ui-1.12.0.custom/themes/transform/jquery-ui.theme.min.css";

define ("TABLES_OR_VIEWS","/(tbl_|vw_|stbl_|svw_)/i");
define ("subjPrefix", "[INTRANET] ");

function makePath($strPath){
	$arrPath = explode('/',$strPath);
	foreach($arrPath as $key=>$value){
		$strTempPath .= $value.'/';
		if (!file_exists($strTempPath)) mkdir ($strTempPath);
	}
}

function GetERValues ($oSQL, $date) {
   GLOBAL $stpLocalCurrencyName;
   if($stpLocalCurrencyName=="BGN")
      $sqlER = "SELECT TOP 1 erhLOCtoUSD, erhLOCtoEUR, erhDate FROM tbl_exchange_rate_history
            WHERE erhDate < '".date("Y-m-d", $date)."'
            ORDER BY erhDate DESC";
   else
   	  $sqlER = "SELECT TOP 1 erhLOCtoUSD, erhLOCtoEUR, erhDate FROM tbl_exchange_rate_history
            WHERE erhDate <= '".date("Y-m-d", $date)."'
            ORDER BY erhDate DESC";
   $rs = $oSQL->do_query($sqlER);
   $rw = $oSQL->fetch_array($rs);
   $oSQL->free_result($rw);
   return $rw;
}

function arrayToXML($arr, $strRet=''){
  foreach($arr as $key=>$value) {
     if (preg_match("/^[0-9]/", $key)){
        $strRet .= "<item index=\"".$key."\">";
        $key = "item";
     } else 
         $strRet .= "<$key>";
	 if (is_array($value))
	    $strRet .= arrayToXML($value, "");
     else 
	    $strRet .= htmlspecialchars($value);
     $strRet .= "</$key>\r\n";
  }
  return $strRet;
}
function GetUserMail($usrID, $strLocal=""){
GLOBAL $oSQL;
GLOBAL $_DEBUG;
	$sql = "SELECT usrName, usrNameLocal, usrEmail FROM common_db.stbl_user WHERE usrID='$usrID' LIMIT 0,1";
	$rs = $oSQL->do_query($sql);
	$rw=$oSQL->fetch_array($rs);
	
	if($_DEBUG) print_r($rw);
	
	$strOutput = ($rw["usrEmail"] ? "{$rw["usrName"]}<{$rw["usrEmail"]}>" : "MAILER-DAEMON@messagelabs.com");
	return $strOutput;
}

function FIO($fullname, $srcCharset='utf-8', $destCharset='cp1251'){
	$fullname = iconv($srcCharset,$destCharset,$fullname);
	$arrName = explode(" ",$fullname);
	$short = $arrName[0].($arrName[1]? " ".substr($arrName[1],0,1).". ":"").($arrName[2]? " ".substr($arrName[2],0,1).". ":"");
	$short = iconv($destCharset,$srcCharset, $short);
	return ($short);

}

function getTabSheets($arrData, $strIdName, $activeID, $class="tabsheet"){
	$match = false;
	$result = "\r\n<div class='$class'><ul>\r\n";
	for($i=0;$i<count($arrData);$i++){
			if ($arrData[$i]['optValue']==$activeID) {
			$strClass = "class=\"$class-active\"";
				$match = true;
			} else {
				$strClass = "";
			};
			$_GET_Temp = $_GET;
			$_GET_Temp[$strIdName]=$arrData[$i]['optValue'];
			$_GET_Temp['offset']=0;
			$href = $_SERVER['PHP_SELF']."?".http_build_query($_GET_Temp);
			$result .= "\t<li $strClass><a href=\"$href\">{$arrData[$i]['optText']}</a></li>\r\n";
	}
	if (count($arrData)>0 && (!$activeID || !$match)) { 
		$_GET_Temp = $_GET;
		$_GET_Temp[$strIdName]=$arrData[0]['optValue'];
		$_GET_Temp['offset']=0;
		$href = $_SERVER['PHP_SELF']."?".http_build_query($_GET_Temp);		
		redirect($href);
		die();
	};
	$result .="</ul></div>\r\n";
	
	echo $result;
}

function logToFile ($var, $heading="", $logFile=""){
	global $_LOG;
	
	if ($_LOG) {
		if ($logFile==""){
			if (!file_exists("logs")) mkdir ('logs');
			$curDate = getdate($_SERVER['REQUEST_TIME']);
			if (!file_exists('logs/'.$curDate['year'])) mkdir ('logs/'.$curDate['year']);
			if (!file_exists('logs/'.$curDate['year'].'/'.$curDate['mon'])) mkdir ('logs/'.$curDate['year'].'/'.$curDate['mon']);
			if (!file_exists('logs/'.$curDate['year'].'/'.$curDate['mon'].'/'.$curDate['mday'])) mkdir ('logs/'.$curDate['year'].'/'.$curDate['mon'].'/'.$curDate['mday']);
			$logFile = "logs/".$curDate['year'].'/'.$curDate['mon'].'/'.$curDate['mday']."/".basename($_SERVER['PHP_SELF']).".".date('H-i-s',$_SERVER['REQUEST_TIME']).".log";
		}
	/*--------------- For logging purposes ----------------*/

		file_put_contents($logFile,'----'.date('d.m.Y H:i:s,u',time()).'--------['.$heading."]---------------------\r\n",FILE_APPEND);
		file_put_contents($logFile,var_export($var, true),FILE_APPEND);
		file_put_contents($logFile,"\r\n\r\n",FILE_APPEND);
	}
}

function logToScreen($var, $heading=""){
	global $_DEBUG;
	if ($_DEBUG){
		if (is_array($var)){
			echo "<h2>",$heading,"</h2>\r\n";
			echo "<pre>";
			print_r($var);
			echo "</pre>\r\n";
		} else {
			echo "<pre>";
			echo "<strong>",$heading, " = </strong>";
			var_dump($var);
			echo "</pre><hr/>\r\n";
		}
		return true;
	} else {
		return false;
	}
}

function readUserData(&$arrUsrData){
	global $oSQL;
	global $_DEBUG;
	
	$sql = "SELECT USU.*, SETUP.* 
			FROM `stbl_user_setup` USU 
			INNER JOIN `stbl_setting` SETUP ON `setID`=`usuSettingID`
			WHERE `usuUserID`='{$arrUsrData['usrID']}'";
			
	$rs = $oSQL->do_query($sql);
	while($rw=$oSQL->fetch_array($rs)){
		switch ($rw['setType']){
			case 'integer':
				$arrUsrData[$rw['setID']]=(integer)$rw['usuValue'];
				break;
			case 'decimal':
				$arrUsrData[$rw['setID']]=(double)$rw['usuValue'];
				break;
			case 'boolean':
			case 'checkbox':
				$arrUsrData[$rw['setID']]=(boolean)$rw['usuValue'];
				break;
			case 'date':
				$arrUsrData[$rw['setID']]=strtotime($rw['usuValue']);
				break;
			default:
				$arrUsrData[$rw['setID']]=$rw['usuValue'];
				break;
		}
	}
	$sql = "SELECT * 
			FROM `common_db`.`tbl_profit` 
			WHERE `pccID`='{$arrUsrData['usrProfitID']}'";
			
	$rs = $oSQL->do_query($sql);
	while($rw=$oSQL->fetch_array($rs)) $arrUsrData['PCC']=$rw;
	
	$sql = "SELECT empTitle, empTitleLocal, empTitleFullLocal 
			FROM `common_db`.`tbl_employee` 
			WHERE `empID`='{$arrUsrData['usrEmployeeID']}'";
			
	$rs = $oSQL->do_query($sql);
	while($rw=$oSQL->fetch_array($rs)) $arrUsrData['EMP']=$rw;
	
	logToScreen($arrUsrData,'arrUsrData');
	
}

function writeCache($content, $filename) {
    $fp = fopen('./cache/' . $filename, 'w');
    fwrite($fp, $content);
    fclose($fp);
  } 
  
 function readCache($filename, $expiry) {
    if (file_exists('./cache/' . $filename)) {
      if ((time() - $expiry) > filemtime('./cache/' . $filename))
        return FALSE;
      $cache = file('./cache/' . $filename);
      return implode('', $cache);
    }
    return FALSE;
  } 

function simpleForm($data){

	require_once ('../common/dwoo/dwooAutoload.php');  
	$dwoo = new Dwoo();
	$dwoo->output(DWOO_EASYFORM, $data);

}  

function month_ru ($date){
	$date = strtotime($date);
	$arrMonth = Array ("января","февраля","марта","апреля","мая","июня","июля","августа","сентября","октября","ноября","декабря");
	$nMonth = (integer)strftime('%m',$date);
	$retVal['day'] = strftime('%d',$date);
	$retVal['month'] = $arrMonth[$nMonth-1];
	$retVal['year'] = strftime('%y',$date);
	
	return ($retVal);
} 

function myErrHandler($code, $message, $errFile, $errLine) {
/*
	SOURCE: http://www.nyphp.org/PHundamentals/7_PHP-Error-Handling
 */
  //Set message/log info
  $subject = "$message: MAJOR PROBLEM at " . APP_NAME . ': ' . date("F j, Y, g:i a");
  $body = "errFile: $errFile\r\n"
            . "errLine: $errLine\r\n"
            . trigger_dump($GLOBALS);

    /*
    An email will be sent to the site administrator.
    Its subject line will have the date and time it occurred while
    the body will contain the state of all of the global variables. This information
    is obtained through the function trigger_dump.
  */
  mail(ADMIN_EMAIL_ADDR,$subject,$body);


  //The same subject line and body of the email will get written to the error log.
  error_log("$subject\r\n $body");


  /*
    We don't want users to know the true nature of the problem so
    we just redirect them to a generic error page that has been created.
    The generic page should have a simple message, such as "System down
    for maintenance." The key idea is not to let any potentially malicious
    user learn about the actual problem that had occurred.
  */
  header ("Location: http://{$_SERVER['HTTP_HOST']}/". GENERIC_ERR_PAGE );
  exit;
} 
function trigger_dump( $mixed,$type = 0 ) {
  /*
	SOURCE: http://www.nyphp.org/PHundamentals/7_PHP-Error-Handling
    $mixed will handle whatever you may decide to pass to it.
    $type will determine what this function should do with the
    information obtained by var_dump
  */
  switch( (int) $type ) {
    case 0:
      /*
      Grab the contents of the output buffer
      when you want to send the information
      back to the calling function
      */
      ob_start();
      var_dump($mixed);
      return ob_get_clean();

    case 1:
      /*
       When you want to display the information to the browser
      */
      print '<pre>';
      var_dump($mixed);
      print '</pre>';
      break;
    case 2:
      //When you want your error handler to deal with the information
      ob_start();
      var_dump($mixed);
      trigger_error(ob_get_clean());
      break;

	  } 
	}

function nameMorpher($input){
	GLOBAL $curl;
	$strURL = "http://morpher.ru/WebServices/Morpher.asmx/GetForms?s=".urlencode($input);
	
    curl_setopt($curl, CURLOPT_PROXY, '10.31.4.20:9119');
    curl_setopt($curl, CURLOPT_PROXYUSERPWD, '1cadmin:zaq12wsx');
	$strXML = curl_readpage($strURL);

	$xmlObj = simplexml_load_string($strXML);
	$arrXml = objectsIntoArray($xmlObj);
	
	return ($arrXml['string']);
}

function objectsIntoArray($arrObjData, $arrSkipIndices = array())
{
    $arrData = array();
   
    // if input is object, convert into array
    if (is_object($arrObjData)) {
        $arrObjData = get_object_vars($arrObjData);
    }
   
    if (is_array($arrObjData)) {
        foreach ($arrObjData as $index => $value) {
            if (is_object($value) || is_array($value)) {
                $value = objectsIntoArray($value, $arrSkipIndices); // recursive call
            }
            if (in_array($index, $arrSkipIndices)) {
                continue;
            }
            $arrData[$index] = $value;
        }
    }
    return $arrData;
} 

function showEntityFiles($strGUID, $strField=''){
GLOBAL $oSQL;
GLOBAL $strLocal;
GLOBAL $dwoo;

		$sqlF = "SELECT FIL.*, USR.usrName$strLocal as filInsertByTitle FROM stbl_file FIL
				JOIN common_db.stbl_user USR ON filInsertBy=usrID
				WHERE filEntityID='$strGUID' ".($strField ? " AND filField='$strField'" :"")
				." ORDER BY filID DESC" ;
		$rs = $oSQL->do_query($sqlF);
		while($rwF = $oSQL->fetch_array($rs)) {
			$rwF['filType'] = str_replace('.','_',basename($rwF['filType']));
			$rwF['filSize'] = convert_size_human($rwF['filSize']);
			$data['arrFile'][]=$rwF;
		}

		if (is_array($data)){
			ob_start();
			$data['strLocal'] = $strLocal;
			
			if (!is_a($dwoo, 'Dwoo')){
				require_once ('../common/dwoo/dwooAutoload.php');  
				$dwoo = new Dwoo();
			};
			$dwoo->output(DWOO_FILE_LOG, $data);
			$strAttachment = ob_get_clean();
		}
		echo $strAttachment;
}	

function getLatestFile($objGUID,$strField=''){
GLOBAL $oSQL;
	
	if ($strField) $andWhere = "AND filField='$strField'";
	$sqlF = "SELECT * FROM stbl_file WHERE filEntityID='$objGUID' AND filSize>0 $andWhere ORDER BY filID DESC LIMIT 1";
	
	$rs = $oSQL->do_query($sqlF);
	$rwF = $oSQL->fetch_array($rs);
	
	$filPath = $rwF['filPath'].$rwF['filGUID'];
	
	$res = file_get_contents($filPath);
	return ($res);
	
}

function getUserData_extended($usrID){
	GLOBAL $oSQL;
	$sql = "SELECT * FROM common_db.stbl_user
			LEFT OUTER JOIN common_db.tbl_employee ON empID=usrEmployeeID
			WHERE usrID='$usrID' LIMIT 1";
	$rs = $oSQL->do_query($sql);
	$rw = $oSQL->fetch_array($rs);
	return($rw);
}

function readSourceAttribute($strInput,$flagEscape = false){
	GLOBAL $oSQL;
	GLOBAL $strLocal;
	GLOBAL $rwMain;
	if ($strInput){
		if (preg_match(TABLES_OR_VIEWS,$strInput)){
			if ($flagEscape) {
				eval('$res = '.$oSQL->e($strInput).';');
			} else {
				eval('$res = "'.$strInput.'";');
			}			
		} else {
			//eval('$comboSQL = '.$arrInput['atrProgrammerReserved'].';');
			$res = (array) json_decode($strInput);
		}
	} else {
		$res = null;
	}
	return($res);
}

function efFillArray($arrInput, &$arrOutput){
	GLOBAL $strLocal;
	GLOBAL $rwMain;
	
	$comboSQL = readSourceAttribute($arrInput['atrProgrammerReserved']);
	
	switch ($arrInput['atrType']){
		case 'date':	
			$arrInput['atrValidate'] = '/^[0-9]{2}\.[0-9]{2}\.[0-9]{4}$/';
			break;
		case 'datetime':
			$arrInput['atrValidate'] = '/^[0-9]{2}\.[0-9]{2}\.[0-9]{4} [0-2][1-9]:[0-5][0-9]$/';
			break;
		default:
			break;
	};
	
	
	//$arrOutput[$arrInput['atrID']] = Array( - почему-то вываливает Fatal Error
	
	$arrOutput[] = Array(
		'field'=>$arrInput['atrFieldName'],
		'type'=>$arrInput['atrType'],
		'title'=>array_key_exists('satFlagShowInForm',$arrInput) ? ($arrInput['satFlagShowInForm']? $arrInput["atrTitle$strLocal"] : "") : ($arrInput['atrFlagShowInForm']? $arrInput["atrTitle$strLocal"] : ""),
		'sql'=> $comboSQL,
		'disabled'=> array_key_exists('satFlagEditable',$arrInput) ? !$arrInput['satFlagEditable'] : !$arrInput['atrFlagEditable'],
		'table'=>$arrInput['atrTable'],
		'prefix'=>$arrInput['atrPrefix'],
		'mandatory'=>$arrInput['satFlagMandatory'],
		'validation'=>$arrInput['atrValidate'],
		'validationText'=>$arrInput["atrValidationText$strLocal"],
		'default'=>($arrInput['atrDefault']!='' ? $arrInput['atrDefault'] : ''),
		'defaultText'=>$arrInput["atrTitle$strLocal"],
		'class'=>$arrInput['atrClass'],
		'description'=>$arrInput["atrDescription$strLocal"],
		'group'=>$arrInput["atrGroup$strLocal"]
		
	);
};

function plFillArray ($arrInput, &$arrOutput, $strTabKey='', $strEntityForm=''){
	GLOBAL $strLocal;
	
	$prefix = substr($arrInput['atrFieldName'],0,3);
	$strPK = $prefix."ID";
	
	if($strEntityForm=='') {
		$entity = preg_replace(TABLES_OR_VIEWS,'',$arrInput['atrEntityID']);
		$strEntityForm = $entity.'_form.php';
	};
	
	$comboSQL = null;
	$i++;
	
	$comboSQL = readSourceAttribute($arrInput['atrProgrammerReserved']);
	
	if (!isset($_GET[$arrInput['atrFieldName']]) && $strTabKey!=$arrInput['atrFieldName']){
		$arrOutput[] = array('title' => (($arrInput['satFlagShowInList']||$arrInput['atrFlagShowInList'])? $arrInput["atrTitle$strLocal"] :'')
									 , 'type' => $arrInput['atrType']
									 , 'PK'=> $arrInput['atrFlagPK']//($arrInput['atrFieldName']==$strPK)
									 , 'field' => $arrInput['atrFieldName']
									 , 'order_field' => $arrInput['atrFieldName']
									 , 'source'=>$comboSQL
									 , 'source_prefix'=>$arrInput['atrPrefix']
									 , 'sql'=>((isset($comboSQL) && !is_array($comboSQL) && !preg_match('/^(vw_|tbl_|stbl_)/i',$comboSQL))?"SELECT `optText` FROM ($comboSQL) Q$i WHERE `optValue`=`{$arrInput['atrFieldName']}`":"")
									 , 'filter' => $arrInput['atrFieldName']	
									, 'href' => (preg_match("/title|$strPK/i",$arrInput['atrFieldName']) ? $strEntityForm."?".$prefix."ID=[$strPK]" : $arrInput['atrHref'])
									 );
									 
	};
}

function populate_recordset($rs, $class='log', $dateFormat = 'd.m.Y', $id=null){
// Функция выводит простую таблицу на основе рекордсета с минимальным форматированием
// Аргументы: 	$rs - рекордсет
//				$class - CSS класс таблицы
//				$dateFormat - формат даты

	GLOBAL $oSQL;

	$flagPrintHeader = true;
	
	echo "<table id='{$id}' class='{$class}'>\r\n<thead>";
	while($rw = $oSQL->f($rs)){
	
		if ($flagPrintHeader){
			$keys = array_keys($rw);
			echo "<tr>";
			for($i=0;$i<count($keys);$i++) { echo "<th>",$keys[$i],"</th>"; }
			echo "</tr>\r\n</thead>\r\n<tbody>\r\n";
			$flagPrintHeader = false;
		}
		

		echo "<tr>";
		foreach($rw as $key=>$value){
			
			if(preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/',$value)){
				$cell = date($dateFormat,strtotime($value));
			} elseif (is_numeric($value)){
				$cell = number_format($value,2,'.',',');
				$style = "text-align: right;";
			} else {
				$cell = $value;
			}
			echo "<td style=\"$style\">",$cell,"</td>";
			$style="";
		}
	echo "</tr>\r\n";
	}
	echo "</table>\r\n";
}

function format_sql($strInput){

	$arrSearch = Array('/(\$[\w]+)/'
						,'/(select |from|join|where|and|or |order by|as |asc|desc|group by)/i'
						,'/(ifnull|sum)/i');
	$arrReplace = Array('<font color="red">$1</font>'
						,'<strong><font color="blue">$1</font></strong>'
						,'<strong><font color="maroon">$1</font></strong>');
	$res = preg_replace($arrSearch,$arrReplace,$strInput);
	
	return $res;
}

function sortAge($age){
	GLOBAL $strLocal;
	$age = (integer)$age;
	if ($age == 0){		
		$res = $strLocal?"Сегодня":"Today";
	} elseif ($age == 1) {
		$res = $strLocal?"Вчера":"Yesterday";
	} elseif ($age == 2) {
		$res = $strLocal?"Позавчера":"Day before yesterday";
	} elseif ($age >= 3 && $age <8) {
		$res = $strLocal?"На этой неделе":"Last week";		
	} elseif ($age >=8 && $age < 14) {
		$res = $strLocal?"На прошлой неделе":"A week ago";
	} else {
		$res = $strLocal?"Давно":"Long time ago";
	};
	return ($res);
}

function getUITabs($arrTabs){
	?>
	<div class='tabs' id='tabs'>
	<ul>
		<?php for($i=0;$i<count($arrTabs);$i++){?>
		<li><a href='<?php echo $_SERVER['PHP_SELF'],'?',$_SERVER['QUERY_STRING'],'&tab=',$arrTabs[$i]['optValue'];?>'><?php echo $arrTabs[$i]["optText"];?></a></li>
		<?php } ?>
	</ul>
	</div>
	<?php
}

function rstrpos ($haystack, $needle, $offset=0){
    $size = strlen ($haystack);
    $pos = strpos (strrev($haystack), $needle, $size - $offset);
    
    if ($pos === false)
        return false;
    
    return $size - $pos;
}
?>