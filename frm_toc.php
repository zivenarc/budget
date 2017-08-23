<?php
$expires = 3600;
header("Pragma: public");
header("Cache-Control: maxage=".$expires);
header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
require ('common/auth.php');
// $arrJS[] = "../common/jquery/jquery.simple.tree.js";
$arrJS[] = "../common/jquery/sidebar-menu/dist/sidebar-menu.js";
$arrCSS[] = "../common/jquery/sidebar-menu/dist/sidebar-menu.css";
ob_start();
?>
 <script>
var simpleTreeCollection;
$(document).ready(function(){

	// $('div.menu').css({width:'250px'}).accordion();
	$.sidebarMenu($('.sidebar-menu'));
	
	$('span.fa-bars').click(function(){
		$('#sidebar').toggle('slide');
	});
	
});
</script>
<?php 
$strHead = ob_get_clean();
// if(!($_GET['entID']||$_GET['pagID'])) require ('includes/inc-frame_top.php'); 
?>

<?php
if (!$_GET['entID'])  require ("../common/izintra/inc_toc.php");
//if (!$_GET['pagID']) require ("includes/inc_entity.php");
?>

<?php
// if(!($_GET['entID']||$_GET['pagID'])) require ('includes/inc-frame_bottom.php'); 
 ?>