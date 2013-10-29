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
		$oDocument->getJSON();
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
require ('includes/inc_document_header.php');
?>
<script>

$(document).ready(function(){
	eiseGridInitialize();
	rowTotalsInitialize();
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
			
			$('#inp_'+doc.gridName+'_updated[]').val();
			$('#inp_'+doc.gridName+'_deleted').val();
			
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

</script>
<?php
require ('includes/inc-frame_bottom.php');
?>