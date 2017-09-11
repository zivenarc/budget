<?php
require ('../common/common.php');
$ldap_domain = 'ylrus.com';

function Authenticate($login, $password, &$strError, $method="LDAP"){
    GLOBAL $ldap_server;
    GLOBAL $ldap_domain;
    GLOBAL $ldap_dn;
    GLOBAL $ldap_conn;

    switch($method) {
    case "LDAP":    
        if (preg_match("/^([a-z0-9]+)[\/\\\]([a-z0-9]+)$/i", $login, $arrMatch)){
            $login = $arrMatch[2];
            $ldap_domain = strtolower($arrMatch[1].".abyrvalg.com");
        } elseif (preg_match("/^([a-z0-9\_]+)[\@]([a-z0-9\.\-]+)$/i", $login, $arrMatch)){
                $login = $arrMatch[1];
                $ldap_domain = $arrMatch[2];
        }
            
        
        
/*
		$ping = exec("ping -n 3 -w 100 $ldap_server", $input, $result);
		if ($result != 0){
*/
    if(false){
            $strError = "Connnection attempt to $ldap_server failed";
            $method = "database";
            die();
        return true;
		
		} else {
			$ldap_conn = ldap_connect($ldap_server);
			//$binding = @ldap_bind($ldap_conn, $ldap_anonymous_login, $ldap_anonymous_pass);
            $ldap_login = $login."@".$ldap_domain;
            $ldap_pass = $password;
            ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);
            $binding = ldap_bind($ldap_conn, $ldap_login, $ldap_pass);
		}
		
        if (!$binding){
               $strError = "Login failed for $ldap_login";
               return false;
        } else
               return true;
        
		
		break;
    case "mysql":
       SetCookie("authstring", $_POST["authstring"]);
       return true;
	   break;
    case "database":
    case "DB":

        GLOBAL $DBHOST, $DBUSER, $DBPASS, $DB;

        $oSQL = new sql($DBHOST, $DBUSER, $DBPASS, $DB, false, CP_UTF8);

        if(!$oSQL->connect()){
            $strError = $this->translate("Unable to connect to database");
            return false;
        }
        $sqlAuth = "SELECT usrID FROM stbl_user WHERE usrID='{$login}' AND usrPass='".md5($password)."'";
        $rsAuth = $oSQL->do_query($sqlAuth);
        if ($oSQL->num_rows($rsAuth)==1)
            return true;
        else {
            $strError = "Bad password or user name";
            return false;
        }
        break;
        return false;
        break;
    }
    
}

$DataAction = isset($_POST["DataAction"]) ? $_POST["DataAction"] : $_GET["DataAction"];

switch ($DataAction){
   case "login":
       $auth_str = base64_decode($_POST["authstring"]);

       preg_match("/^([^\:]+)\:([\S ]+)$/i", $auth_str, $arrMatches);
       $arrLoginPassword = Array($arrMatches[1], $arrMatches[2]);
       
       $login = $arrMatches[1];
       $password = $arrMatches[2];
       $strError = "";
       if (Authenticate($login, $password, $strError, (isset($authmethod) ? $authmethod : "LDAP"))){
           session_initialize();
           $_SESSION["usrID"] = strtoupper($login);
           $_SESSION["last_login_time"] = Date("Y-m-d H:i:s");
           $_SESSION["authstring"] = $_POST["authstring"];
           SetCookie("last_succesfull_usrID", $login);
           header ("Location: ".(isset($_COOKIE["PageNoAuth"]) ? $_COOKIE["PageNoAuth"] : "index.php"));
       } else {
           SetCookie("last_succesfull_usrID", "");
           header ("Location: login.php?error=".ShowFieldTitle("Bad password or user name."));
       }
       die();
       break;
   case "logout":
      session_start();
      session_unset();
      session_destroy();
      header ("Location: login.php");
      die();
      break;

}

session_start();
session_unset();
session_destroy();
//print_r($_COOKIE);
ob_start();
?>
<style type='text/css'>
	#btnsubmit{
		width:50%;
		margin-left:25%;
		margin-right:25%;
	}
	#content{
		width:auto;
	}
	#tip{
		text-align:center;
	}
	#content-container{
		width: 30%;
		margin:0 auto;
	}
</style>
<script type='text/javascript'>
$(document).ready(function(){
   
   $('input[type="submit"]').button();
   var host = $("#host");
   if(host!=null) {
       host.val("localhost");
   } 
   
   $("#login").focus().select();

});
</script>
<?php
$strHead = ob_get_clean();
require ('includes/inc-frame_top.php');
?>
<div id='content-container'>
<h1>Login to <?php  echo $title ; ?></h1>

<?php
if ($_GET["error"]){
?>
<div class="error">ERROR: <?php  echo $_GET["error"] ; ?></div>
<?php
}


$arrUsr = split("[\\]", $AUTH_USER);
$usrID = strtoupper($arrUsr[count($arrUsr)-1]);

if ($strMode == "LDAP"){

	$ping = exec("ping -n 3 -w 100 $ldap_server", $input, $result);
	if ($result == 0){
		$ldap_conn = ldap_connect($ldap_server);
		$binding = @ldap_bind($ldap_conn, $ldap_anonymous_login, $ldap_anonymous_pass);
	}else{
		$binding = false;
	}
	
	
}
 ?>
<div class="panel" id='content'>
<form action="<?php echo $_SERVER["PHP_SELF"] ?>" name="loginform" id="loginform" method="POST" onsubmit="return LoginForm();">
<input type="hidden" id="DataAction" name="DataAction" value="login">
<input type="hidden" id="authstring" name="authstring" value="">
<?php 
if ($flagShowHost) {?>
   <dt>Host:</dt>
	<dd><input type="text" id="host" name="host" value=""></dd>
<?php
}
?>
	<div class='f-row'>
		<label for="login">Login:</label>
		<input class="i-text" type="text" id="login" name="login" value="<?php echo $_COOKIE["last_succesfull_usrID"] ;?>"/>
	</div>

	<div class='f-row'>
		<label for="password">Password:</label>
		<input class="i-text" type="password" id="password" name="password" value=""/>
	</div>
	
	<div class='f-row'>
	<input type="submit" id="btnsubmit" name="btnsubmit" value="Login"/>
	</div>
<p id='tip'>Please enter your <strong><?php echo ($binding ? "CITRIX" : "database"); ?></strong> login/password.</p>

</form>
</div>
</div>
<?php
require ('includes/inc-frame_bottom.php');
?>