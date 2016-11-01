<?php 
header("Pragma: public");
header('Expires: ' . gmdate('D, d M Y H:i:s', time(0,0,0,date('m',time()),date('d',time())+1, date('Y',time()))) . ' GMT');

require ('common/auth.php');
/*------ Temporary roles ----------*/
$sql = "delete from stbl_role_user where datediff(NOW(),rluDeadline)>=0";
$rs = $oSQL->do_query($sql);
$sql = "select RLU.*, rolTitle$strLocal 
		from stbl_role_user RLU
		join stbl_role ON rluRoleID=rolID AND DATEDIFF(NOW(), rluInsertDate)>=0
		where rluUserID='$usrID'";
$rs = $oSQL->do_query($sql);
while ($rwRLU = $oSQL->fetch_array($rs)) {
	$arrRoleData[] = $rwRLU["rolTitle$strLocal"].($rwRLU["rluDeadline"]?($strLocal?" до ":" until ").date('d.m.Y',strtotime($rwRLU["rluDeadline"])):"");
};
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $strPageTitle ?></title>
	<link rel="STYLESHEET" type="text/css" href="common/style.css" media="screen">
	<link rel="STYLESHEET" type="text/css" href="common/print.css" media="print">
	<link rel="STYLESHEET" type="text/css" href="common/header.css">
</head>
<body>  

<div id="header_wrapper">
	<a href="index.php" target="_top"><div id="corner_logo"><?php echo $arrSetup['strCompanyName']; ?></div></a>
	<div id="app_title"><?php echo $strPageTitle.($strSubTitle? " :: ".$strSubTitle : ""); ?> ::
		<select>
			<?php 
				foreach($arrCompanyConfig as $company=>$data){
					echo "<option value='{$company}'>{$data["comTitle$strLocal"]}</option>";
				}
			?>
		</select>
	</div>
	
	<?php
    if ($usrID){
        ?><div id="login_info"><?php echo $registeredas." ".GetUserNameByID($ldap_conn, $usrID, "fn_sn", $oSQL, $strLocal);
		
		echo is_array($arrRoleData) ? " (".implode(", ",$arrRoleData).")" : " - No roles assigned";

        if ($strAuthMode!="IIS") {
			echo ",&nbsp;<a href=\"logout.php\" target=\"_top\">$logout</a>";
        }
		?></div><?php
    }
	?>
	<div id='search_form'>
		<form target='pane' action='frm_search.php'>
		<input class='i-text' placeholder='<?php echo $strLocal?"Поиск...":"Search...";?>' type='text' name='strSearch' id='strSearch'/>
		<input class='ui-button' type='submit' id='search_submit' value='<?php echo $strLocal?"Найти":"Find";?>'/>
		</form>
	</div>	
	<div id='languages'>
		<ul>
			<li><a target="_top" class="lang-en" href="index.php?lang=en">ENG</a></li>
			<li><a target="_top" class="lang-ru" href="index.php?lang=ru">RUS</a></li>
		</ul>
	</div>

</div>
</body>
</html>