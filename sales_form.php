<?php
//$flagNoAuth = true;
require ('common/auth.php');
include ('classes/sales.class.php');
$arrJS[] = 'js/input_form.js';

$salID=$_GET['salID']?$_GET['salID']:$_POST['salID'];

$oBudget = new Budget($budget_scenario);
$oDocument = new Sales ($salID);
$oDocument->defineEF();
$grid = $oDocument->defineGrid();


if ($_POST['DataAction']){
	 // echo '<pre>'; print_r($_POST);	 echo '</pre>';
	
	if ($oDocument->save($_POST['DataAction'])){
		$oDocument->refresh($oDocument->ID);
		
		$arrActions = Array();
		include('includes/inc_document_menu.php');
		$oDocument->arrActions = $arrActions;
		$oDocument->status = 'success';
		header("Content-type: application/json");
		echo json_encode($oDocument);
	}
	die();
}

if ($_GET['tab']){
	switch($_GET['tab']){
		case 'kpi':
			require_once ('classes/reports.class.php');
			$sqlWhere = "WHERE source='".$oDocument->GUID."'";
			Reports::salesByActivity($sqlWhere);
			die();
			break;
		case 'financials':
			require_once ('classes/reports.class.php');
			$sqlWhere= "WHERE source='".$oDocument->GUID."'";			
			Reports::masterByCustomer($sqlWhere);
			die();
			break;
		default:
			break;
	}

}


include ('includes/inc_document_menu.php');


//============================== Main form definition ==============================

$oDocument->fillGrid($grid);

require ('includes/inc-frame_top.php');
echo '<h1>Budget: sales sheet #',$oDocument->ID,'</h1>';
echo '<p id="timestamp">',$oDocument->timestamp,'</p>';
?>
<script>
	var doc = <?php echo json_encode($oDocument);?>
</script>
<div>
<?php 

	$oDocument->Execute($oSQL, "panel", "formlist");

?>
</div>
<div id='tabs'>
	<ul>
		<li><a href='#tabs-input'>Input</a></li>
		<li><a href='<?php echo $_SERVER['REQUEST_URI']."&tab=kpi";?>'>KPI</a></li>
		<li><a href='<?php echo $_SERVER['REQUEST_URI']."&tab=financials";?>'>Financials</a></li>
		<li><a href='<?php echo "json_action_log.php?guid=",$oDocument->GUID;?>'>Action log</a></li>
	</ul>
	<div id='tabs-input'>
		<form>
			<input type="hidden" name="DataAction" id="DataAction" value="update">
			<div style="width: 100%; overflow-x: auto;">
			<?php
			if ($oDocument->GUID){
				$grid->Execute();
			}
			?>
			</div>
		</form>
	</div>
	<div id='tabs-kpi'>
	
	</div>
	<div id='tabs-fin'>
	
	</div>
</div>
<script>

$(document).ready(function(){
	eiseGridInitialize();
	$('.sales_jan, .sales_feb, .sales_mar, .sales_apr, .sales_may, .sales_jun, .sales_jul, .sales_aug, .sales_sep, .sales_oct, .sales_nov, .sales_dec').each(function(){
		$(this).change(function(){
			recalcYTD($(this));
		})
	});
	$('form').submit(function(){
		event.preventDefault();
	});
	
	
});
function save(arg){
	arg=arg||'update';
	$('#DataAction').val(arg);
	var data = $( "input, textarea, select" ).serialize();
	//console.log(data);
	$('#loader').show();
	$.post('sales_form.php',data, function(responseText){
		console.log(responseText);
		
		if (responseText.status=='success'){
		
			$('#timestamp').text(responseText.timestamp);
			$menu = $('ul.menu-h');
			$menu.children('li').detach();
		
			if(doc.flagPosted!=responseText.flagPosted || doc.ID!=responseText.ID){
				location.href='sales_form.php?salID='+responseText.ID;
			}
			
			for(i=0;i<responseText.arrActions.length;i++){
				console.log(responseText.arrActions[i]);
				var $li = $('<li>').append($('<a>',{'class':responseText.arrActions[i].class,'href':responseText.arrActions[i].action,'text':responseText.arrActions[i].title}))
				$menu.append($li);
			}
		}
		$('#loader').hide();
	});
}
function recalcYTD($o){
	var $row = $o.parent('tr');
	var $ytd = $row.find('td.sales_YTD div');
	var res = 0;
	for (m=0;m<months.length;m++){
		res += parseFloat($row.find('td.sales_'+months[m]+' input').val());
	}
	$ytd.text(res);
}

</script>
<?php
require ('includes/inc-frame_bottom.php');
?>