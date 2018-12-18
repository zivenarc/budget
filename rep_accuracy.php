<?php
$flagNoAuth = true;
// $_DEBUG = true;
include('common/auth.php');
require ('classes/reports.class.php');
require ('classes/waterfall.class.php');
include ('includes/inc_report_settings.php');

$oActual = new Budget($budget_scenario);
$oLast = new Budget($oActual->lastyear);

require ('includes/inc-frame_top.php');

//echo '<pre>';print_r((array)$oActual);echo '</pre>';
echo "<h1>Accuracy report, {$oActual->title}</h1>";
$sql = "SELECT * FROM tbl_scenario WHERE scnType NOT LIKE '%Budget%' ORDER BY scnDateStart DESC";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	$arrScn[$rw['scnDateStart']] = $rw;
}

for ($i=12;$i>=1;$i--){
	
	$dateStart = date('Y-m-d',strtotime("{$i} months ago",$oActual->date_start));
	// echo '<pre>',$dateStart;
	
	if(is_array($arrScn[$dateStart])){
		$arrScnUse[$dateStart] = $arrScn[$dateStart]['scnID'];		
	} else {
		$arrScnUse[$dateStart] = $lastScn;
	};
	
	$lastScn = $arrScn[$dateStart]['scnID'];
	
	// echo '</pre>';
	
}


//echo '<pre>';print_r($arrScnUse);echo '<pre>';
$sql = Array();

$groupTitle = 'Profit';
$groupValue = 'pc';

foreach($arrScnUse as $dateStart=>$scenario){
	$oRef = new Budget($scenario);
	$sql['forecast'][] = "SELECT `{$groupTitle}`, `{$groupValue}`, SUM(".$oRef->getThisYTDSQL('nm').") as `".$oActual->arrPeriod[$oRef->nm]."`
			FROM vw_master 
			WHERE scenario='{$oRef->id}' 
				AND company='{$company}'
				".Reports::GP_FILTER."
				GROUP BY `{$groupValue}`";	
}

$sql['actual'][] = "SELECT `{$groupTitle}`, `{$groupValue}`,".$oActual->getMonthlySumSQL(4,$oActual->cm)."
					FROM vw_master 
								WHERE scenario='{$oActual->id}' 
									AND company='{$company}'
									".Reports::GP_FILTER."
									GROUP BY `{$groupValue}`";

$sql['actual'][] = "SELECT `{$groupTitle}`, `{$groupValue}`,".$oActual->getMonthlySumSQL($oActual->nm,15)."
					FROM vw_master 
								WHERE scenario='{$oActual->lastyear}' 
									AND company='{$company}'
									".Reports::GP_FILTER."
									GROUP BY `{$groupValue}`";
				
	
foreach ($sql as $datatype=>$arrQuery){	
	for($i=0;$i<count($arrQuery);$i++){
		
		// echo '<pre>';print_r($arrQuery[$i]);echo '</pre>';
		
		$rs = $oSQL->q($arrQuery[$i]);
		while ($rw = $oSQL->f($rs)){
			for($m=4;$m<=15;$m++){
				$month = $oActual->arrPeriod[$m];
				$arrReport[$rw[$groupTitle]][$datatype][$month] += $rw[$month];				
			}
		}
	}
}

// echo '<pre>';print_r($arrReport);echo '</pre>';
?>
<table class="budget" id="accuracy">
<tr>
	<th>Responsible</th>
	<th>Data</th>
	<?php for($m=$oActual->nm;$m<=15;$m++){
			$month = $oLast->arrPeriodTitle[$m];
			echo "<th>{$month}</th>";
		} ;
		for($m=4;$m<=$oActual->cm;$m++){
			$month = $oActual->arrPeriodTitle[$m];
			echo "<th>{$month}</th>";
		} ;
	?>
	<th class="budget-ytd">Total</th>
</tr>
<?php 
	foreach ($arrReport as $sales=>$data){
			$error = 0;
			?>
			<tr>
				<td rowspan="4"><?php echo $sales;?></td>
				<td>Forecast</td>
				<?php
				for($m=$oActual->nm;$m<=15;$m++){
					$month = $oActual->arrPeriod[$m];
					?>
					<td class="budget-decimal"><?php Reports::render($data['forecast'][$month]);?></td>
					<?php
				} ;
				for($m=4;$m<=$oActual->cm;$m++){
					$month = $oActual->arrPeriod[$m];
					?>
					<td class="budget-decimal"><?php Reports::render($data['forecast'][$month]);?></td>
					<?php
				} ;
				?>
				<td class="budget-ytd budget-decimal"><?php Reports::render(array_sum($data['forecast']));?></td>
			</tr>
			<tr>				
				<td>Actual</td>
				<?php
				for($m=$oActual->nm;$m<=15;$m++){
					$month = $oActual->arrPeriod[$m];
					?>
					<td class="budget-decimal"><?php Reports::render($data['actual'][$month]);?></td>
					<?php
				} ;
				for($m=4;$m<=$oActual->cm;$m++){
					$month = $oActual->arrPeriod[$m];
					?>
					<td class="budget-decimal"><?php Reports::render($data['actual'][$month]);?></td>
					<?php
				} ;
				?>
				<td class="budget-ytd budget-decimal"><?php Reports::render(array_sum($data['actual']));?></td>
			</tr>
			<tr>				
				<td>Diff</td>
				<?php
				for($m=$oActual->nm;$m<=15;$m++){
					$month = $oActual->arrPeriod[$m];
					?>
					<td class="budget-decimal"><?php Reports::render($data['actual'][$month]-$data['forecast'][$month]);?></td>					
					<?php
					$error += abs($data['actual'][$month]-$data['forecast'][$month]);
				} ;
				for($m=4;$m<=$oActual->cm;$m++){
					$month = $oActual->arrPeriod[$m];
					?>
					<td class="budget-decimal"><?php Reports::render($data['actual'][$month]-$data['forecast'][$month]);?></td>
					<?php
					$error += abs($data['actual'][$month]-$data['forecast'][$month]);
				} ;
				?>
				<td class="budget-ytd budget-decimal"><?php Reports::render($error);?></td>
			</tr>
			<tr class="budget-ratio">				
				<td>%</td>
				<?php
				for($m=$oActual->nm;$m<=15;$m++){
					$month = $oActual->arrPeriod[$m];
					?>
					<td class="budget-decimal"><?php Reports::render_ratio(abs($data['actual'][$month]-$data['forecast'][$month]),$data['actual'][$month]);?></td>
					<?php
				} ;
				for($m=4;$m<=$oActual->cm;$m++){
					$month = $oActual->arrPeriod[$m];
					?>
					<td class="budget-decimal"><?php Reports::render_ratio(abs($data['actual'][$month]-$data['forecast'][$month]),$data['actual'][$month]);?></td>
					<?php
				} ;
				?>
				<td class="budget-ytd budget-decimal"><?php Reports::render_ratio($error,array_sum($data['actual']));?></td>
			</tr>
			<?php
	}
?>
</table>
<?php
Reports::_echoButtonCopyTable('accuracy');

require ('includes/inc-frame_bottom.php');
?>