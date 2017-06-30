<!DOCTYPE html>
<?php
//echo $strDocType."\r\n";
if (isset($_COOKIE["UserMessage"])) {
   $strUserMessage = $_COOKIE["UserMessage"];
   SetCookie("UserMessage", "");
}
?>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<meta name="platform" content="IZ_Intra v3.01 Date UI"/>
	<meta name="author" content="Igor Zhuravlev" />
	<title><?php echo $arrUsrData["pagTitle$strLocal"].($strPageSubtitle?" | ".$strPageSubtitle:""); ?></title>
	<script type="text/javascript">
		var arrUsrData = <?php echo json_encode($arrUsrData);?>;
		var strLocal = '<?php echo $strLocal; ?>';		
	</script>
	<!--Scripts loaded by LoadJS-->
<?php
loadJS();
?>
<!--Styles loaded by LoadCSS-->
<?php
loadCSS();
?>
<!--Frame-specific HEAD tags-->
<?php
echo "\t".$strHead."\r\n";
?>
<!--End of frame-specific HEAD tags-->
<script>
$(document).ready(function(){  
			MsgShow();
		});
</script>
<img src='/common/images/spinner-orange.gif' style='display:none;'/>
</head>
<body>
<div id="body">
	<div style="display:none;" id="sysmsg"<?php  echo (preg_match("/ERROR/", $strUserMessage) ? " class='error'" : "") ;?>><?php echo $strUserMessage ; ?></div>
<?php 
if (!$flagNoMenu && is_array($arrActions)) {
 ?>
<div id="menubar" class="menubar">
	<div id="loader"><img alt="Connecting..." src="/common/images/ajax-loader-orange.gif" /></div>
	<ul class="menu-h">
<?php
    for ($i=0;$i<count($arrActions);$i++) {
			$strClass = 'sprite '.$arrActions[$i]['class'];
            $isJS = preg_match("/javascript\:(.+)$/", $arrActions[$i]['action'], $arrJSAction);
            if (!$isJS){
                 echo "\t<li><a class='{$strClass}' href=\"".$arrActions[$i]['action']."\">".$arrActions[$i]['title']."</a></li>\r\n";
             } else {
                 echo "\t<li><a class='{$strClass}' href=\"".$arrActions[$i]['action']."\" onclick=\"".$arrJSAction[1]."; return false;\">".$arrActions[$i]['title']."</a></li>\r\n";
             }
    }
?>
	</ul>
</div>
<div id='vspacer'>&nbsp;</div>
<?php 
}
if ($_DEBUG) {
	echo "<h1>Debug information</h1><h2>\$_SERVER:</h2>\r\n<pre>";print_r($_SERVER);echo "</pre>\r\n";
}	?>
<div id="frameContent" class="content"><!--End of frame top template(includes/inc_frame-top.php)-->
