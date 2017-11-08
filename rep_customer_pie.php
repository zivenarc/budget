<?php
// $flagNoAuth = true;
require ('common/auth.php');
require ('classes/budget.class.php');

$oBudget = new Budget($budget_scenario);

$sql = "SELECT customer_group_code, cntTitle, SUM(".$oBudget->getThisYTDSQL('ytd').") as YTD 
		FROM reg_master 
		LEFT JOIN common_db.tbl_counterparty ON cntID=customer_group_code
		WHERE account IN ('J00400','J00802') 
			AND scenario IN ('{$budget_scenario}') 
			AND company={$company}
			AND (pc='{$arrUsrData['usrProfitID']}')
		GROUP BY customer_group_code		
		ORDER BY YTD DESC
		";
$rs = $oSQL->q($sql);
$i = 1;
while ($rw = $oSQL->f($rs)){
	if($i<20){
		$arrHSSeries[] = Array('name'=>($rw['cntTitle']?$rw['cntTitle']:'Unspecified'),'y'=>(integer)$rw['YTD']);
	} else {
			$yOthers += (integer)$rw['YTD'];
	}
	$i++;
}
if ($yOthers){
	$arrHSSeries[] = Array('name'=>'Others','y'=>$yOthers);
}

$sql = "SELECT ivlGroup, SUM(".$oBudget->getThisYTDSQL('ytd').") as YTD 
		FROM reg_master 
		LEFT JOIN common_db.tbl_counterparty ON cntID=customer_group_code
		LEFT JOIN common_db.tbl_industry ON cntIndustryID=ivlGUID
		WHERE account IN ('J00400','J00802') 
			AND scenario IN ('{$budget_scenario}') 
			AND company={$company}
			AND (pc='{$arrUsrData['usrProfitID']}')
		GROUP BY ivlGroup		
		ORDER BY YTD DESC
		";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	$arrIndustrySeries[] = Array('name'=>($rw['ivlGroup']?$rw['ivlGroup']:'Unspecified'),'y'=>(integer)$rw['YTD']);
}

$arrJS[]="https://code.highcharts.com/highcharts.js";
$arrJS[]="https://code.highcharts.com/highcharts-more.js";
$arrJS[]="https://code.highcharts.com/modules/exporting.js";
include ('includes/inc-frame_top.php');
?>
<div id='pie' style='width:1600px; height: 900px;'></div>
<div id='industry' style='width:1600px; height: 900px;'></div>
<script>
$(document).ready(function(){
	
	Highcharts.chart('pie', {
		chart: {
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: false,
			type: 'pie'
		},
		title: {
			text: 'Customer share by GP, <?php echo $oBudget->title;?>'
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
			name: 'Customers',
			colorByPoint: true,
			data: <?php echo json_encode($arrHSSeries);?>
		}]
	});
	
	Highcharts.chart('industry', {
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
include ('includes/inc-frame_bottom.php');