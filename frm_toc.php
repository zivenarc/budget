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
	
	if(false){
	simpleTreeCollection = $('ul.simpleTree').simpleTree({
		autoclose: true,
		drag: false,
		afterClick:function(node){
			//alert("text-"+$('span:first',node).text());
		},
		afterDblClick:function(node){
			//alert("text-"+$('span:first',node).text());
		},
		afterMove:function(destination, source, pos){
			//alert("destination-"+$('span:first',destination).text()+" source-"+$('span:first',source).text()+" pos-"+pos);
		},
		afterAjax:function()
		{
			//alert('Loaded');
		},
		animate:true
		,docToFolderConvert:true
		});
	}
	
});
</script>
<?php 
$strHead = ob_get_clean();
if(!($_GET['entID']||$_GET['pagID'])) require ('includes/inc-frame_top.php'); 

if (!$_GET['entID']) require ("includes/inc_toc.php"); 
// if (!$_GET['pagID']) require ("includes/inc_entity.php");

if(!($_GET['entID']||$_GET['pagID'])) require ('includes/inc-frame_bottom.php'); 
 ?>