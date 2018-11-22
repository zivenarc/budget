<?php
$flagNoAuth = true;
require ('common/auth.php');
require ('classes/reports.class.php');

$arrJS[]="https://code.highcharts.com/highcharts.js";
// $arrJS[]="https://code.highcharts.com/modules/drilldown.js";
$arrJS[]="https://code.highcharts.com/highcharts-more.js";
$arrJS[]="https://code.highcharts.com/modules/exporting.js";

include ('includes/inc-frame_top.php');
echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,$strVsTitle,'</h1>';	

$arrScenario=Array('A2015','A2016','A2017','FYE_18_Sep','FYE_18_Oct','B2019');
foreach ($arrScenario as $budget_scenario){
	$oBudget = new Budget($budget_scenario);
	$sql = "SELECT Profit, ".$oBudget->getMonthlySumSQL(4,15, null, 1000)."
			FROM vw_master
			WHERE scenario='{$budget_scenario}'
			AND pccFlagProd=1
			".Reports::GP_FILTER."
			GROUP BY pc";
	// echo '<pre>',$sql,'</pre>';
	$rs = $oSQL->q($sql);
	while ($rw = $oSQL->f($rs)){
		$arrReport[$rw['Profit']][$oBudget->year][] = $rw;
	}
	
	// echo '<pre>';print_r($oBudget->arrPeriodTitle);echo '</pre>';
	//echo $oBudget->year;
	
	$arrYearTitles[$oBudget->year] = array_slice($oBudget->arrPeriodTitle,3,12);
}

//echo '<pre>';print_r($arrReport);echo '</pre>';
foreach($arrReport as $profit=>$years){
	$tableID = md5($profit);
	echo '<h2>',$profit,'</h2>';
	// echo '<pre>';print_r($years);echo '</pre>';
	?>
	<table id="<?php echo $tableID;?>" class='budget'>
		<thead>
			<tr>
				<?php foreach ($arrYearTitles as $year=>$arrPeriodTitle) { 
					echo '<th colspan="12">',$year,'</th>';
				} ?>
			</tr>
			<tr>
			<?php foreach ($arrYearTitles as $arrPeriodTitle) { 
				echo '<th>',implode('</th><th>',$arrPeriodTitle),'</th>';
			} ?>
			</tr>
		</thead>
		<?php foreach ($years as $scenarios) {
				//echo '<pre>';print_r($scenarios);echo '</pre>';
				$scenario_count = max($scenario_count, count($scenarios));
			}
			// echo $scenario_count;
		?>
		<tbody>
		<?php for ($i = 0;$i<$scenario_count;$i++){
			?>
			<tr>
				<?php foreach ($arrYearTitles as $year=>$titles){
					for($m = 4;$m<=15;$m++){
							$month = $oBudget->arrPeriod[$m];
							echo '<td>'; Reports::render($arrReport[$profit][$year][$i][$month]);echo '</td>';
					}
				}?>
			</tr>
			<?php
		}?>
		</tbody>
	</table>
	<?php
	Reports::_echoButtonCopyTable($tableID);
}
include ('includes/inc-frame_bottom.php');



?>