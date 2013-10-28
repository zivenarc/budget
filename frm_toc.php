<?php
$expires = 3600;
header("Pragma: public");
header("Cache-Control: maxage=".$expires);
header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
require ('common/auth.php');
$arrJS[] = "/common/jquery/jquery.simple.tree.js";
ob_start();
?>
 <script>
var simpleTreeCollection;
$(document).ready(function(){
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
	
});
</script>
<?php 
$strHead = ob_get_clean();
require ('includes/inc-frame_top.php'); 
require ("includes/inc_toc.php"); 
require ('includes/inc-frame_bottom.php'); 
 ?>