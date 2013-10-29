<!--<script type="text/javascript" language="javascript" src="/common/jquery/jquery-autocomplete/lib/jquery.bgiframe.min.js?q=1301293221"></script>
<script type="text/javascript" language="javascript" src="/common/jquery/ui/js/jquery-ui-1.8.16.custom.min.js?q=1325012530"></script>
<script type="text/javascript" language="javascript" src="/common/jquery/jquery-autocomplete/lib/jquery.dimensions.js?q=1301293221"></script>
<script type="text/javascript" language="javascript" src="/common/jquery/jquery-autocomplete/lib/jquery.ajaxQueue.js?q=1301293221"></script>
<script type="text/javascript" language="javascript" src="/common/jquery/jquery-autocomplete/jquery.autocomplete.js?q=1301293221"></script>-->
<script type="text/javascript" language="javascript">
	$(document).ready(function(){
		initialize_inputs($('#entity'));
		$('input.date').datepicker();
		$('#tabs').tabs();
	});
	
	function save(){
		if (easyFormValidate())	$('#entity').submit();
	};
	function easyFormValidate(){
		return(true);
	}
</script>
<h1><?php echo $strTitle; ?></h1>
<?php
require_once ('../common/dwoo/dwooAutoload.php');  
$dwoo = new Dwoo();

$data = array(	'pageTitle'=>$arrUsrData["pagTitle$strLocal"],
				'arrActions'=>$arrActions,
				'staTitle'=>$rwSTA['staTitle'],
				'staDescription'=>$rwSTA['staDescription'],
				'arrActionLog'=>$arrActionLog,
				'arrFile'=>$arrFile,
				'itemGUID'=>$rwMain[$prefix."GUID"],
				'itemID'=>$itemID,
				'prefix'=>$prefix,
				'entity'=>$entity,
				'PHP_SELF'=>$_SERVER["PHP_SELF"],
				'myForm'=>Array('columns'=>$myForm->Columns
								,'ID'=>$myForm->key
								,'name'=>$myForm->name
								,'method'=>$myForm->method),
				); 
	
if (!empty($rwMain)){
	foreach($rwMain as $key=>$value){
		$data["$key"]=$value;
	}
}

if(is_array($arrTabs)){
	?>
	<div id="tabs">
	<ul>
	<li><a href="#main_form">Main</a></li>
	<?php
		for($i=0;$i<count($arrTabs);$i++){
			echo "<li><a href=\"{$arrTabs[$i]['href']}\">{$arrTabs[$i]['title']}</a></li>";
		}
	?>
	</ul>
	<div id='tab_content'>
	<?php
}
?>
<div class="panel" id='main_form'>
<table>
	<tbody>
	<tr>
	<td style="width: 100%;">
<?php
	$dwoo->output('../common/dwoo/templates/inc_easyform.tpl', $data);
?>
	</td>
	<td>
<?php
		$dwoo->output('../common/dwoo/templates/inc_action_log.tpl', $data);
		$dwoo->output('../common/dwoo/templates/inc_files.tpl', $data);
?>
	</td>
	</tr>
	</tbody>
	</table>
</div>

<?php if(is_array($arrTabs)){ ?>
	</div>
</div>
<?php
}
?>

<ul class='link-footer'>
	<li><a target='_top' href='<?php echo "index.php?pane=".basename($_SERVER['REQUEST_URI']); ?>'><?php echo $strLocal?"Ссылка на документ":"Link to this document";?></a></li>
	<?php
		for($i=0;$i<count($arrLinkFooter);$i++){
		echo "<li>"
			,"<a href='"
			,$arrLinkFooter[$i]['href']
			,"' target='"
			,$arrLinkFooter[$i]['target']?$arrLinkFooter[$i]['target']:'_self'
			,"'>"
			,$arrLinkFooter[$i]['title']
			,"</a>"
			,"</li>\r\n";
		}
	?>
</ul>