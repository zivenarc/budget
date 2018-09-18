<?php
//$flagNoAuth = true;
require ('common/auth.php');
include ('classes/location_costs.class.php');
$arrJS[] = 'js/input_form.js';

$arrJS[]="https://code.highcharts.com/highcharts.js";
$arrJS[]="https://code.highcharts.com/highcharts-more.js";
$arrJS[]="https://code.highcharts.com/modules/exporting.js";

$lcoID=$_GET['lcoID']?$_GET['lcoID']:$_POST['lcoID'];

$oBudget = new Budget($budget_scenario);
$oDocument = new Location_costs ($lcoID);
$oDocument->defineEF();
$oDocument->defineGrid();


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
			$sql = "SELECT pccTitle, wc, SUM(".$oDocument->budget->getThisYTDSQL('roy').")/".($oDocument->budget->offset+12-$oDocument->budget->cm)."  as FTE
					FROM `reg_headcount`
					LEFT JOIN common_db.tbl_profit ON pccID=pc
					WHERE scenario='{$oDocument->budget->id}' AND location='{$oDocument->location}'
					AND salary>10000 AND posted=1
					GROUP BY pc, wc
					ORDER BY FTE DESC";
			// echo '<pre>',$sql,'</pre>';
			$rs = $oSQL->q($sql);
			while ($rw = $oSQL->f($rs)){
				$arrReport[$rw['pccTitle']][$rw['wc']] = $rw['FTE'];
				$arrTotal[$rw['wc']] +=$rw['FTE'];				
			}
			if (is_array($arrReport)){
				?>
				<table><tr><td>
				<div id='distribution_table'>
				<table class="budget">
				<thead>
				<tr>
					<th>Business unit</th>
					<th>White</th>
					<th>Blue</th>
					<th class="budget-ytd">Total</th>
				</thead>
				<tbody>
				<?php
				foreach($arrReport as $pc=>$data){
					$arrPie[] = Array('name'=>$pc,'y'=>array_sum($data));
					?>
					<tr>
						<td><?php echo $pc;?></td>
						<td class='budget-decimal'><?php Reports::render($data[1],1);?></td>
						<td class='budget-decimal'><?php Reports::render($data[0],1);?></td>
						<td class="budget-decimal budget-ytd"><?php Reports::render(array_sum($data),1);?></td>
					</tr>
					<?php
				}
				?>
				</tbody>
				<tfoot>
					<tr class="budget-subtotal">
						<td>Total</td>
						<td class='budget-decimal'><?php Reports::render($arrTotal[1],1);?></td>
						<td class='budget-decimal'><?php Reports::render($arrTotalata[0],1);?></td>
						<td class="budget-decimal budget-ytd"><?php Reports::render(array_sum($arrTotal),1);?></td>
					</tr>
				</tfoot>
				</table>
				</div>
				</td>
				<td>
				<div id='distribution_chart'>
				</div>
				</td></tr></table>
				<script type="text/javascript">
					Highcharts.chart('distribution_chart', {
						chart: {
							plotBackgroundColor: null,
							plotBorderWidth: null,
							plotShadow: false,
							type: 'pie'
						},
						title: {
							text: 'Location headcount'
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
							name: 'Business unit',
							colorByPoint: true,
							data: <?php echo json_encode($arrPie);?>
						}]
					});
				</script>
				<?php
			}
			die();
			break;
		case 'financials':
			require_once ('classes/reports.class.php');
			$sqlWhere= "WHERE source='".$oDocument->GUID."'";			
			$oReport = new Reports(Array('budget_scenario'=>$oDocument->budget->id));
			$oReport->masterByProfit($sqlWhere);
			$oReport->masterByYACT($sqlWhere);
			die();
			break;
		default:
			break;
	}

}


include ('includes/inc_document_menu.php');


//============================== Main form definition ==============================

$oDocument->fillGrid($oDocument->grid);

require ('includes/inc-frame_top.php');
require ('includes/inc_document_header.php');



?>
<script>

$(document).ready(function(){
			
	// var grid=eiseGrid_find(doc.gridName);
    // if (grid!=null){  
		// grid.change ("jan[]", function(oTr, input){
			// for (m=1;m<months.length;m++){
				// oTr.find("input[name='"+months[m]+"[]']").val(input.val());
			// }
		// })
    // }
	
});

</script>
<?php
require ('includes/inc-frame_bottom.php');
?>