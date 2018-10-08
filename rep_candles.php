<?php
$flagNoAuth = true;
set_time_limit(60);
require ('common/auth.php');
require ('classes/reports.class.php');
include ('includes/inc_report_settings.php');

$oBudget = new Budget($budget_scenario);

$arrJS[]='js/rep_pnl.js';

include ('includes/inc-frame_top.php');
echo '<h1>',$arrUsrData["pagTitle$strLocal"],': ',$oBudget->title,'</h1>';
include ('includes/inc_report_selectors.php');

$sql = "SELECT ".$oBudget->getMonthlySumSQL(1+$oBudget->offset,$oBudget->cm).", pc, Profit
		FROM vw_master
		WHERE scenario='{$oBudget->id}' AND company='{$company}' ".Reports::OWN_OPERATING_PROFIT."
		GROUP BY pc";
// echo '<pre>',$sql,'</pre>';
$rs = $oSQL->q($sql);
?>
<table id='candles_oop' class="budget">
	<caption>Own operating profit</caption>
	<thead>
		<tr>
			<th>Business unit</th>
			<?php for ($m=$oBudget->offset+1;$m<=$oBudget->cm;$m++){
				echo "<th>{$oBudget->arrPeriodTitle[$m]}</th>";
			}
			?>
			<th>Min</th>
			<th>Prev</th>
			<th>This</th>
			<th>Max</th>
		</tr>
	</thead>
	<tbody>
		<?php while ($rw = $oSQL->f($rs)) { 
					$rw['min'] = $rw['apr']; $rw['max'] = $rw['apr'];
			?>
			<tr>
				<td><?php echo $rw['Profit'];?></td>
				<?php for ($m=$oBudget->offset+1;$m<=$oBudget->cm;$m++){
					$month = $oBudget->arrPeriod[$m];
					?>
					<td class="budget-decimal"><?php Reports::render($rw[$month]);?></td>
				<?php
					$rw['prev'] = $rw[$oBudget->arrPeriod[$oBudget->cm-1]];
					$rw['this'] = $rw[$oBudget->arrPeriod[$oBudget->cm]];
					if($rw[$month]<$rw['min']) $rw['min'] = $rw[$month];
					if($rw[$month]>$rw['max']) $rw['max'] = $rw[$month];					
				} ?>
				<td class="budget-decimal budget-quarterly"><?php Reports::render($rw['min']);?></td>
				<td class="budget-decimal budget-ytd"><?php Reports::render($rw['prev']);?></td>
				<td class="budget-decimal budget-ytd"><?php Reports::render($rw['this']);?></td>
				<td class="budget-decimal budget-quarterly"><?php Reports::render($rw['max']);?></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<?php
Reports::_echoButtonCopyTable('candles_oop');
include ('includes/inc-frame_bottom.php');
?>