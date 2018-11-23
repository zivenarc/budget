<?php
// $flagNoAuth = true;
require ('common/auth.php');
require ('classes/reports.class.php');
include ('includes/inc_report_settings.php');
include ('includes/inc_report_pcfilter.php');

$arrJS[]="https://code.highcharts.com/highcharts.js";
$arrJS[]="https://code.highcharts.com/highcharts-more.js";
$arrJS[]="https://code.highcharts.com/modules/exporting.js";
$arrJS[]="https://code.highcharts.com/modules/drilldown.js";

$oBudget = new Budget($budget_scenario);
$pc = $_GET['pc']?(integer)$_GET['pc']:$arrUsrData['usrProfitID'];

if(!isset($_GET['pccGUID'])){
	$oBudget = new Budget($budget_scenario);
	// if ($reference!=$oBudget->reference_scenario->id){
		// $oReference = new Budget($reference);
		// $strVsTitle = ' vs '.$oReference->title;
	// } else {
		// $reference = $oBudget->reference_scenario->id;
	// }
	
	$arrJS[]='js/rep_pnl.js';
	// $arrJS[]='js/input_form.js';	
	
	//include('includes/inc_group_buttons.php');	
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,$strVsTitle,'</h1>';	
	include ('includes/inc_report_selectors.php');
	echo '<p>',$oBudget->timestamp,'; ',$oBudget->rates,'</p>';
	
	Budget::getProfitTabs('reg_master', true, Array('pccID'=>$arrBus));
	?>
	<script>
		//$('#reference').attr('disabled',true);		
	</script>
	<?php
	include ('includes/inc-frame_bottom.php');
} else {
	
	$oReport = new Reports(Array('budget_scenario'=>$budget_scenario, 'currency'=>$currency, 'denominator'=>$denominator,'reference'=>$reference,'filter'=>$filter));

	$sql = "SELECT SUM(".$oReport->oBudget->getThisYTDSQL('fye').") as YTD 
			FROM vw_master 			
			{$oReport->sqlWhere}
			".$oReport::GP_FILTER."
			AND scenario ='{$oReport->oBudget->id}'						
			";
	$rs = $oSQL->q($sql);
	$nTotalGP = $oSQL->get_data($rs);
	
	$sql = "SELECT customer_group_code, customer_group_title, SUM(".$oReport->oBudget->getThisYTDSQL('fye').") as YTD 
			FROM vw_master 			
			{$oReport->sqlWhere}
			".$oReport::GP_FILTER."
			AND scenario ='{$oReport->oBudget->id}'
			GROUP BY customer_group_code		
			ORDER BY YTD DESC
			";
	$rs = $oSQL->q($sql);	
	$runningTotal = 0;
	while ($rw = $oSQL->f($rs)){
		if($runningTotal<0.8*$nTotalGP){
			$arrHSSeries[] = Array('name'=>($rw['customer_group_title']?$rw['customer_group_title']:'Unspecified'),'y'=>(integer)$rw['YTD']);
		} elseif ($runningTotal<0.96*$nTotalGP) {
			$yOthers['b'] += (integer)$rw['YTD'];
			$arrOthers['b'][] = Array(($rw['customer_group_title']?$rw['customer_group_title']:'Unspecified'),(integer)$rw['YTD']);
		} else {
			$yOthers['c'] += (integer)$rw['YTD'];
			$arrOthers['c'][] = Array(($rw['customer_group_title']?$rw['customer_group_title']:'Unspecified'),(integer)$rw['YTD']);
		}
		$runningTotal += $rw['YTD'];
	}
	if (is_array($yOthers)){
		$arrHSSeries[] = Array('name'=>'B-Class ('.count($arrOthers['b']).')','y'=>$yOthers['b'], 'drilldown'=>'Others_B');
		$arrHSSeries[] = Array('name'=>'C-Class ('.count($arrOthers['c']).')','y'=>$yOthers['c'], 'drilldown'=>'Others_C');
	}

	$sql = "SELECT ivlGroup, SUM(".$oBudget->getThisYTDSQL('fye').") as YTD 
			FROM vw_master 
			{$oReport->sqlWhere}
			".$oReport::GP_FILTER."
			AND scenario ='{$oReport->oBudget->id}'
			GROUP BY ivlGroup		
			ORDER BY YTD DESC
			";
	$rs = $oSQL->q($sql);
	while ($rw = $oSQL->f($rs)){
		$arrIndustrySeries[] = Array('name'=>($rw['ivlGroup']?$rw['ivlGroup']:'Unspecified'),'y'=>(integer)$rw['YTD']);
	}

	$customerPie = 'customer_'.$_GET['pccGUID'];
	$industryPie = 'industry_'.$_GET['pccGUID'];
	?>
	<div id='<?php echo $customerPie;?>' style='width:100%; height:900px;'></div>
	<div id='<?php echo $industryPie;?>' style='width:100%; height:900px;'></div>
	<script>
	$(document).ready(function(){
		
		Highcharts.chart('<?php echo $customerPie;?>', {
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				type: 'pie'
			},
			title: {
				text: 'Customer share by GP, <?php echo $oBudget->title;?>'
			},
			subtitle: {
				text: 'with ABC-analysis'
			},
			tooltip: {
				headerFormat: '<b>{point.key}</b><br>',
				pointFormat: '{point.y:,.0f}: {point.percentage:.0f}%'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						format: '<b>{point.name}</b><br>{point.y:,.0f} ({point.percentage:.0f}%)',
						style: {
							color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
						}
						// ,
						// filter: {
							// property: 'percentage',
							// operator: '>',
							// value: 1
						// }
					}
				}
			},
			"series": [{
				name: 'A-Class customers',
				colorByPoint: true,
				data: <?php echo json_encode($arrHSSeries);?>
			}],
			"drilldown": {
				series: [
					{name:'B-Class (<?php echo count($arrOthers['b']);?>)',
						id:'Others_B',
						data: <?php echo json_encode($arrOthers['b']); ?>
						
					},{name:'C-Class (<?php echo count($arrOthers['c']);?>)',
						id:'Others_C',
						data: <?php echo json_encode($arrOthers['c']); ?>
						
					}
				]
			}
		});
		
		Highcharts.chart('<?php echo $industryPie;?>', {
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				type: 'pie'
			},
			title: {
				text: 'Industry verticals by GP, <?php echo $oBudget->title;?>'
			},
			tooltip: {
				pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						format: '<b>{point.name}</b>: {point.percentage:.1f} %',
						style: {
							color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
						}
						
					}
				}
			},
			series: [{
				name: 'Industry',
				colorByPoint: true,
				data: <?php echo json_encode($arrIndustrySeries);?>
			}]
		});
	});
	</script>
	<?php
}