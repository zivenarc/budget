<?php
$flagNoAuth = true; set_time_limit(60);
require ('common/auth.php');
require ('classes/reports.class.php');
require ('classes/profit.class.php');

include ('includes/inc_report_settings.php');

$oBudget = new Budget($budget_scenario);
$ytd = $oBudget->cm;echo $ytd;


echo $oBudget->type;
if (strpos($oBudget->type,'Budget')) die('Wrong budget type, cannot fill in the actuals');

if($oBudget->flagReadOnly) die ('Budget scenario is locked for update');

//------------------------------------Fill in the actual data-------------------
$sql = Array();
$sql[] = "START TRANSACTION;";
$sql[] = "SET @scnID:='{$budget_scenario}';";
$sql[] = "SET @item:='453d8da7-963b-4c4f-85ca-99e26d9fc7a2', @yact:='J00801';";
$sql[] = "DELETE FROM reg_headcount WHERE scenario=@scnID and source='Actual';";

for($m=1+$oBudget->offset;$m<=$ytd;$m++){
	$year = $oBudget->year;
	$repDateStart = date('Y-m-d',mktime(0,0,0,$m,1,$year));
	$repDateEnd = date('Y-m-d H:i:s',mktime(23,59,59,$m+1,0,$year));
	
	// $month = date('M',mktime(0,0,0,$m,1,$year));
	$month = $oBudget->arrPeriod[$m];
	// echo '<pre>',$repDateStart,' - ',$repDateEnd,'</pre>';
	// echo $month;

	$sql[] = "SET @repDateStart:='{$repDateStart}', @repDateEnd:='{$repDateEnd}';";
	$sql[] = "UPDATE reg_headcount SET `{$month}`=0 WHERE scenario=@scnID AND source<>'Actual';";
	$sql[] = "INSERT INTO reg_headcount (company, pc, location, activity, `{$month}` ,source, scenario, particulars, account, item, `function`,salary, wc, active, posted)
				SELECT empCompanyID
					, IFNULL((SELECT ephProfitID FROM common_db.tbl_employee_profit WHERE ephEmployeeGUID1C=empGUID1C AND DATEDIFF(@repDateEnd, ephDate)>=0 ORDER BY ephDate DESC LIMIT 1),1)
					, empLocationID
					, IFNULL(empProductTypeID,0)
					, IF (empStartDate BETWEEN @repDateStart AND @repDateEnd, 1 - DATEDIFF(empStartDate, @repDateStart)/DATEDIFF(@repDateEnd,@repDateStart),1)
						- IF (empEndDate BETWEEN @repDateStart AND @repDateEnd, DATEDIFF(@repDateEnd, empEndDate )/DATEDIFF(@repDateEnd,@repDateStart),0) as FTE
						, 'Actual', @scnID, empGUID1C, IFNULL(empYACT,@yact),@item, empFunctionGUID
						##, empSalary
						, IFNULL((SELECT epsSalary FROM common_db.tbl_employee_salary WHERE epsEmployeeGUID1C=empGUID1C AND DATEDIFF(@repDateEnd, epsDate)>=0 ORDER BY epsDate DESC LIMIT 1),empSalary) as Salary
						, IFNULL((SELECT funFlagWC FROM common_db.tbl_function WHERE funGUID=empFunctionGUID),0), 1, 1
				FROM common_db.tbl_employee
				WHERE empStartDate <= @repDateEnd 
				AND (empEndDate IS NULL OR empEndDate >=@repDateStart) 
				##AND empFlagDeleted=0
				AND empSalary>0;";
	$sql[] = "UPDATE reg_headcount, common_db.tbl_employee, treasury.tbl_vacation 
				SET salary=0 
				WHERE vacVactypeID IN (3,4,5) ## Unpaid leave or maternity leave
					AND ((@repDateStart BETWEEN vacDateStart AND vacDateEnd) OR (@repDateEnd BETWEEN vacDateEnd AND vacDateEnd))  
					AND DATEDIFF(vacDateEnd,vacDateStart)>=28
					AND vacEmployeeID=empID 
					AND empGUID1C=particulars
					AND source='Actual'
					AND scenario=@scnID
					AND `{$month}`<>0;";
	$sql[] = "UPDATE reg_headcount, common_db.tbl_employee, treasury.tbl_sickleave 
				SET salary=0 
				WHERE DATEDIFF(sklDateEnd,sklDateStart) > 138
					AND sklStateID BETWEEN 910 AND 930
					AND ((@repDateStart BETWEEN sklDateStart AND sklDateEnd) OR (@repDateEnd BETWEEN sklDateStart AND sklDateEnd))  
					AND sklEmployeeID=empID 
					AND empGUID1C=particulars
					AND source='Actual'
					AND scenario=@scnID
					AND `{$month}`<>0;";
	$sql[] = "UPDATE reg_headcount, common_db.tbl_employee, treasury.tbl_resignation 
				SET end_date=rsgDateEnd, `{$month}`=IF(rsgDateEnd<@repDateStart,0,`{$month}`)
				WHERE 
					rsgStateID BETWEEN 1030 AND 1081
					AND rsgDateEnd >= '".date('Y-m-d',$oBudget->date_start)."'  
					AND rsgEmployeeID=empID 
					AND empGUID1C=particulars
					AND source='Actual'
					AND scenario=@scnID					
					AND `{$month}`=1;";
	
}


$sql[] = "DELETE FROM reg_headcount WHERE scenario=@scnID AND source='Actual' AND ".$oBudget->getYTDSQL(1,$ytd)."=0;";
$sql[] = "COMMIT";

//echo '<pre>';print_r($sql);echo '</pre>';
for ($i=0;$i<count($sql);$i++){
	$oSQL->q($sql[$i]);
}


$ProfitCenters = new ProfitCenters();

$sql = "SELECT * FROM reg_headcount 
		WHERE activity=0 
		AND scenario='{$budget_scenario}' 
		AND source='Actual'";
		
$rs = $oSQL->q($sql);
// echo '<hr/><pre>';print_r($sql);echo '</pre>';
$sql = Array();

while ($rw = $oSQL->f($rs)){
	$oProfit = $ProfitCenters->getByCode($rw['pc']);
	if (is_array($oProfit->activity)){
		foreach($oProfit->activity as $activity=>$share){
			
			$strMth = Array();
			for($m=1+$oBudget->offset;$m<=$ytd;$m++){
				$strMth[] = "`{$oBudget->arrPeriod[$m]}` = {$rw[$oBudget->arrPeriod[$m]]}*{$share}";
			}
			$sql[] = "INSERT INTO reg_headcount 
						SET 
						company = '{$rw['company']}',
						pc = {$rw['pc']},
						location = {$rw['location']}, 
						activity = {$activity},
						source = 'Actual', 
						scenario = '{$budget_scenario}', 
						particulars = '{$rw['particulars']}', 
						account = '{$rw['account']}',
						item = '{$rw['item']}', 
						`function` = '{$rw['function']}',
						salary = {$rw['salary']}, 
						wc = {$rw['wc']}, 
						active = {$rw['active']}, 
						posted = {$rw['posted']}, 
						".implode(",",$strMth);
						
		};
		$sql[] = "DELETE FROM reg_headcount WHERE id='{$rw['id']}' LIMIT 1";
	} else {
		$sql[] = "UPDATE reg_headcount SET activity = ".(integer)$oProfit->activity." WHERE id='{$rw['id']}'"; 
	}
}	
$sql[] = "COMMIT";

// echo '<pre>';print_r($sql);echo '</pre>';
for ($i=0;$i<count($sql);$i++){
	$oSQL->q($sql[$i]);
}
		
include ('includes/inc-frame_top.php');		
?>
<h1>Actual headcount, <?php echo $oBudget->title;?></h1>
<?php
$sqlSelect = "SELECT prtRHQ, empID, empGUID, empCode1C, pccTitle, empTitle, empTitleLocal, empFunction, empSalary, empStartDate, empEndDate, end_date, 
						locTitle as 'Location', prtGHQ as 'Activity', funTitle, funTitleLocal, pccTitle,pccTitleLocal , "
						.$oBudget->getMonthlySumSQL(1+$oBudget->offset,12+$oBudget->offset).", SUM(".$oBudget->getYTDSQL(1+$oBudget->offset,12+$oBudget->offset).")/12 as Total 
					FROM `reg_headcount`
					LEFT JOIN vw_function ON funGUID=function
					LEFT JOIN vw_product_type ON prtID=activity
					LEFT JOIN vw_location ON locID=location
					LEFT JOIN vw_profit ON pccID=pc
					LEFT JOIN vw_employee ON empGUID1C=particulars
					WHERE scenario='{$budget_scenario}'
					AND posted=1 AND active=1 AND salary>0";
			
			$sql = $sqlSelect."\r\n GROUP BY pc,location, activity, `particulars`
					ORDER BY pc,location, empSalary DESC, funGUID, empTitleLocal";
			$rs = $oSQL->q($sql);			
			if (!$oSQL->num_rows($rs)){
				echo "<div class='warning'>No data found</div>";
				return (false);
			}
			
			$tableID = md5($sql);
			
			?>
			<div class='f-row'><label for='budget_scenario'>Select scenario</label><?php echo $oBudget->getScenarioSelect();?></div>
			<table id='<?php echo $tableID;?>' class='budget'>
			<thead>
				<tr>
					<th>ID</th>		
					<th>Code</th>		
					<th>PC</th>		
					<th>Location</th>		
					<th>Activity</th>		
					<th>Name</th>		
					<th>Title</th>		
					<th>Salary</th>		
					<th>Start date</th>		
					<th>Resignation date</th>					
				<?php echo $oBudget->getTableHeader('monthly',1+$oBudget->offset,12+$oBudget->offset); ?><th class='budget-ytd'>Average</th></tr>
			</thead>			
			<tbody>
			<?php
			$pcc = "";
			while ($rw=$oSQL->f($rs)){				
				if ($pcc && $pcc!=$rw['pccTitle']){
					?>
					<tr class="budget-subtotal">
						<td colspan="10">Subtotal <?php echo $pcc;?></td>
						<?php				
						for ($m=1+$oBudget->offset;$m<=12+$oBudget->offset;$m++){
							// $month = date('M',mktime(0,0,0,$m,15));
							$month = $oBudget->arrPeriod[$m];
							echo "<td class='budget-decimal budget-$month'>",Reports::render($subtotal[$pcc][$month],2),'</td>';							
						}
						?>
						<td class='budget-decimal budget-ytd'><?php echo Reports::render(array_sum($subtotal[$pcc])/12,2);?></td>
					</tr>
					<?php
				}
				?>
				<tr>
					<td><?php echo $rw['empID'];?></td>
					<td><?php echo $rw['empCode1C'];?></td>
					<td><?php echo $rw['pccTitle'];?></td>
					<td><?php echo $rw['Location'];?></td>
					<td><?php echo $rw['Activity'];?></td>
					<td><?php echo $rw['empTitleLocal'];?></td>
					<td class="<?php echo $rw['empFunction']?"":"ui-state-error";?>"><?php echo $rw['empFunction'];?></td>
					<td class='budget-decimal'><?php echo number_format($rw['empSalary'],2,'.',',');?></td>
					<td><?php echo $rw['empStartDate'];?></td>
					<td><?php echo $rw['empEndDate']?$rw['empEndDate']:($rw['end_date']?'('.$rw['end_date'].')':'');?></td>				
				<?php				
				for ($m=1+$oBudget->offset;$m<=12+$oBudget->offset;$m++){
					// $month = date('M',mktime(0,0,0,$m,15));
					$month = $oBudget->arrPeriod[$m];
					?>
					<td class='budget-decimal budget-<?php echo $month;?> <?php echo ($m==$oBudget->cm?'budget-current':'');?>'><?php Reports::render($rw[$month],2);?></td>
					<?php
					$total[$month] += $rw[$month];		
					$subtotal[$rw['pccTitle']][$month] += $rw[$month];					
				}
				$totalPayroll += $rw['empSalary'];
				$subtotalPayroll[$rw['pccTitle']] += $rw['empSalary'];
				?>
					<td class='budget-decimal budget-ytd'><?php echo Reports::render($rw['Total'],2);?></td>
				</tr>
			<?php
				
				$pcc = $rw['pccTitle'];
			}
			?>
			<tfoot>
			<tr class='budget-subtotal'>
				<td colspan="7">Total</td>
				<td class="budget-decimal"><?php Reports::render($totalPayroll);?></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<?php
					for ($m=1+$oBudget->offset;$m<=12+$oBudget->offset;$m++){
						// $month = date('M',mktime(0,0,0,$m,15));
						$month = $oBudget->arrPeriod[$m];
						echo "<td class='budget-decimal budget-$month'>",Reports::render($total[$month],2),'</td>';					
					}
				?>
				<td class='budget-decimal budget-ytd'><?php echo Reports::render(array_sum($total)/12,2);?></td>
			</tr>
			</tfoot>
			</tbody>
			</table>
			<nav>
				<li><a href="javascript:SelectContent('<?php echo $tableID;?>');">Copy table</a></li>
			</nav>
			<div style='display:none;'><pre><?php echo $sql;?></pre></div>
<?php
include ('includes/inc-frame_bottom.php');
			