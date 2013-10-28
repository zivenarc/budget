<?php
ini_set("zlib.output_compression","1");
$user_agent = $_SERVER['HTTP_USER_AGENT'];
if (stripos($user_agent, 'MSIE 6.0') !== false && stripos($user_agent, 'MSIE 8.0') === false && stripos($user_agent, 'MSIE 7.0') === false) {
	if (!isset($HTTP_COOKIE_VARS["ie"])) {
		setcookie("ie", "yes", time()+60*60*24*360);
		header ("Location: /ie6/ie6.html");
	}
}

require ('common/auth.php');

if ($_GET["pane"])
   $paneSrc = $_GET["pane"];
else 
   $paneSrc = "about.php";

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
	<title><?php echo $strPageTitle, ($strSubTitle ? " :: ".$strSubTitle : "") ; ?></title>
	<link rel="STYLESHEET" type="text/css" href="common/style.css">
	<link rel="icon" href="./favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="./favicon.ico" type="image/x-icon" />

	<!--[if lt IE 7]>
		<link rel="stylesheet" href="common/ie.css" type="text/css">
	<![endif]-->
</head>
<!-- frames -->
<frameset rows="71px,*">
    <frame id="header" name="header" src="frm_header.php" marginwidth="0" marginheight="0" scrolling="no" frameborder="0" noresize>
    <frameset  cols="15%,*">
        <frame id="toc" name="toc" src="frm_toc.php" marginwidth="10" marginheight="10" scrolling="auto" frameborder="0">
        <frame id="pane" name="pane" src="<?php echo $paneSrc ; ?>" marginwidth="0" marginheight="0" scrolling="auto" frameborder="0">
    </frameset>
</frameset>
</html>