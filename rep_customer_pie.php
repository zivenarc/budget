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
	$runningTotal = 0; $yOthers = Array(); $arrOthers=Array();
	while ($rw = $oSQL->f($rs)){
		if($runningTotal<0.8*$nTotalGP){
			$arrHSSeries['GP'][] = Array('name'=>($rw['customer_group_title']?$rw['customer_group_title']:'Unspecified'),'y'=>(integer)$rw['YTD']);
		} elseif ($runningTotal<0.96*$nTotalGP) {
			$yOthers['GP']['b'] += (integer)$rw['YTD'];
			$arrOthers['GP']['b'][] = Array(($rw['customer_group_title']?$rw['customer_group_title']:'Unspecified'),(integer)$rw['YTD']);
		} else {
			$yOthers['GP']['c'] += (integer)$rw['YTD'];
			$arrOthers['GP']['c'][] = Array(($rw['customer_group_title']?$rw['customer_group_title']:'Unspecified'),(integer)$rw['YTD']);
		}
		$runningTotal += $rw['YTD'];
	}
	if (count($yOthers['GP'])){
		$arrHSSeries['GP'][] = Array('name'=>'B-Class ('.count($arrOthers['GP']['b']).')','y'=>$yOthers['GP']['b'], 'drilldown'=>'Others_B');
		$arrHSSeries['GP'][] = Array('name'=>'C-Class ('.count($arrOthers['GP']['c']).')','y'=>$yOthers['GP']['c'], 'drilldown'=>'Others_C');
	}
	
	// -------------------------------- Pie by TEU ------------------------------------
	$sql = "SELECT SUM(".$oReport->oBudget->getThisYTDSQL('fye').") as YTD 
			FROM vw_sales 			
			{$oReport->sqlWhere}
			AND scenario ='{$oReport->oBudget->id}' 
			AND unit='TEU'
			";
	$rs = $oSQL->q($sql);
	$nTotalGP = $oSQL->get_data($rs);
	
	$sql = "SELECT customer_group_code, customer_group_title, SUM(".$oReport->oBudget->getThisYTDSQL('fye').") as YTD 
			FROM vw_sales 			
			{$oReport->sqlWhere}			
			AND scenario ='{$oReport->oBudget->id}'
			AND unit='TEU'
			GROUP BY customer_group_code		
			ORDER BY YTD DESC
			";
	$rs = $oSQL->q($sql);	
	$runningTotal = 0; $yOthers = Array(); $arrOthers=Array();
	while ($rw = $oSQL->f($rs)){
		if($runningTotal<0.8*$nTotalGP){
			$arrHSSeries['TEU'][] = Array('name'=>($rw['customer_group_title']?$rw['customer_group_title']:'Unspecified'),'y'=>(integer)$rw['YTD']);
		} elseif ($runningTotal<0.96*$nTotalGP) {
			$yOthers['TEU']['b'] += (integer)$rw['YTD'];
			$arrOthers['TEU']['b'][] = Array(($rw['customer_group_title']?$rw['customer_group_title']:'Unspecified'),(integer)$rw['YTD']);
		} else {
			$yOthers['TEU']['c'] += (integer)$rw['YTD'];
			$arrOthers['TEU']['c'][] = Array(($rw['customer_group_title']?$rw['customer_group_title']:'Unspecified'),(integer)$rw['YTD']);
		}
		$runningTotal += $rw['YTD'];
	}
	if (count($yOthers['TEU'])){
		$arrHSSeries['TEU'][] = Array('name'=>'B-Class ('.count($arrOthers['TEU']['b']).')','y'=>$yOthers['TEU']['b'], 'drilldown'=>'Others_B');
		$arrHSSeries['TEU'][] = Array('name'=>'C-Class ('.count($arrOthers['TEU']['c']).')','y'=>$yOthers['TEU']['c'], 'drilldown'=>'Others_C');
	}
	
	//--------------------------------- Pie by Industry -------------------------------
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
	$customerPieTEU = 'customer_teu_'.$_GET['pccGUID'];
	$industryPie = 'industry_'.$_GET['pccGUID'];
	?>
	<div id='<?php echo $customerPie;?>' style='width:100%; height:600px;'></div>
	<div id='<?php echo $customerPieTEU;?>' style='width:100%; height:600px;'></div>
	<div id='<?php echo $industryPie;?>' style='width:100%; height:600px;'></div>
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
				data: <?php echo json_encode($arrHSSeries['GP']);?>
			}],
			"drilldown": {
				series: [
					{name:'B-Class (<?php echo count($arrOthers['GP']['b']);?>)',
						id:'Others_B',
						data: <?php echo json_encode($arrOthers['GP']['b']); ?>
						
					},{name:'C-Class (<?php echo count($arrOthers['GP']['c']);?>)',
						id:'Others_C',
						data: <?php echo json_encode($arrOthers['GP']['c']); ?>
						
					}
				]
			}
		});
		
		Highcharts.chart('<?php echo $customerPieTEU;?>', {
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				type: 'pie'
			},
			title: {
				text: 'Customer share by TEU, <?php echo $oBudget->title;?>'
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
				data: <?php echo json_encode($arrHSSeries['TEU']);?>
			}],
			"drilldown": {
				series: [
					{name:'B-Class (<?php echo count($arrOthers['TEU']['b']);?>)',
						id:'Others_B',
						data: <?php echo json_encode($arrOthers['TEU']['b']); ?>
						
					},{name:'C-Class (<?php echo count($arrOthers['TEU']['c']);?>)',
						id:'Others_C',
						data: <?php echo json_encode($arrOthers['TEU']['c']); ?>
						
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