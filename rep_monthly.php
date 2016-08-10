<?php
require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/reports.class.php');
include ('includes/inc_report_settings.php');

$oBudget = new Budget($budget_scenario);
if ($reference!=$oBudget->reference_scenario->id){
	$oReference = new Budget($reference);
	$strVsTitle = ' vs '.$oReference->title;
} else {
	$reference = $oBudget->reference_scenario->id;
}

if(isset($_GET['currency'])){
		$sql = "SELECT * FROM vw_currency WHERE curID={$currency} LIMIT 1";
		$rs = $oSQL->q($sql);
		$rw = $oSQL->f($rs);
		echo '<h2>',$rw["curTitle$strLocal"],'</h2>';
}

include ('includes/inc_report_pcfilter.php'); /// filter and tabs for Business unit

if (isset($_REQUEST['filter'])){
	$user_filter = $_REQUEST['filter'];	
	$filter = array_merge($filter, $user_filter);	
}

$oReport = new Reports(Array('budget_scenario'=>$budget_scenario, 'currency'=>$currency, 'denominator'=>$denominator, 'reference'=>$reference, 'filter'=>$filter));
	
switch ($_POST['DataAction']){
	case 'kpiByCustomer':
		$oReport->kpiByCustomerMR();
		die();
		break;
	default:
		if(!isset($_GET['pccGUID'])){
			
			$arrJS[]='js/rep_pnl.js';
			// $arrJS[]='js/input_form.js';	
			
			include('includes/inc_group_buttons.php');
			
			?>
				<script>
				function getDetails(params){					
						$('#details').detach();
						$('<div>',{id:'details'}).load(location.href, params , function(){
							$(this).dialog({
								'title':'Details for '+params.title,
								'modal':true,
								'width':'80%'
							});
						});
				}
				</script>
			<?php
			
			include ('includes/inc-frame_top.php');
			echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,$strVsTitle,'</h1>';
			include ('includes/inc_report_selectors.php');
			echo '<p>',$oBudget->timestamp,'; ',$oBudget->rates,'</p>';	
			
			$oBudget::getProfitTabs('reg_master', true, Array('pccID'=>$arrBus));
			include ('includes/inc-frame_bottom.php');
		} else {
				
			$oReport->monthlyReport($type);		

		}
}

?>