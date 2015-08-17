<?php
$flagNoAuth = true;
require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/reports.class.php');

$budget_scenario='FYE_15_Jul';
$oBudget = new Budget($budget_scenario);
$ytd = date('m',$oBudget->date_start)-1;

//------------------------------------Fill in the actual data-------------------
$sql = Array();
$sql[] = "START TRANSACTION;";
$sql[] = "SET @scnID:='{$budget_scenario}';";
$sql[] = "SET @item:='453d8da7-963b-4c4f-85ca-99e26d9fc7a2', @yact:='J00801';";
$sql[] = "DELETE FROM reg_headcount WHERE scenario=@scnID and source='Actual';";

for($m=1;$m<=$ytd;$m++){
	$year = date('Y',$oBudget->date_start);
	$repDateStart = date('Y-m-d',mktime(0,0,0,$m,1,$year));
	$repDateEnd = date('Y-m-d',mktime(0,0,0,$m+1,0,$year));
	
	$month = date('M',mktime(0,0,0,$m,1,$year));
	// echo '<pre>',$repDateStart,' - ',$repDateEnd,'</pre>';
	// echo $month;

	$sql[] = "SET @repDateStart:='{$repDateStart}', @repDateEnd:='{$repDateEnd}';";
	$sql[] = "UPDATE reg_headcount SET `{$month}`=0 WHERE scenario=@scnID AND source<>'Actual';";
	$sql[] = "INSERT INTO reg_headcount (company, pc, location, activity, `{$month}` ,source, scenario, particulars, account, item, `function`,salary, wc, active, posted)
				SELECT 'OOO'
					, IFNULL((SELECT ephProfitID FROM common_db.tbl_employee_profit WHERE ephEmployeeGUID1C=empGUID1C AND DATEDIFF(@repDateEnd, ephDate)>=0 ORDER BY ephDate DESC LIMIT 1),1)
					, empLocationID
					, empProductTypeID
					, IF (empStartDate BETWEEN @repDateStart AND @repDateEnd, 1 - DATEDIFF(empStartDate, @repDateStart)/DATEDIFF(@repDateEnd,@repDateStart),1)
						- IF (empEndDate BETWEEN @repDateStart AND @repDateEnd, DATEDIFF(@repDateEnd, empEndDate )/DATEDIFF(@repDateEnd,@repDateStart),0) as FTE
						, 'Actual', @scnID, empGUID1C, IFNULL(empYACT,@yact),@item, empFunctionGUID
						##, empSalary
						, IFNULL((SELECT epsSalary FROM common_db.tbl_employee_salary WHERE epsEmployeeGUID1C=empGUID1C AND DATEDIFF(@repDateEnd, epsDate)>=0 ORDER BY epsDate DESC LIMIT 1),empSalary) as Salary
						, IFNULL((SELECT funFlagWC FROM common_db.tbl_function WHERE funGUID=empFunctionGUID),0), 1, 1
				FROM common_db.tbl_employee
				WHERE empStartDate <= @repDateEnd 
				AND (empEndDate IS NULL OR empEndDate >=@repDateStart)
				AND empSalary>0;";
	$sql[] = "UPDATE reg_headcount, common_db.tbl_employee, treasury.tbl_vacation SET salary=0 
				WHERE vacVactypeID IN (4,5) 
					AND ((@repDateStart BETWEEN vacDateStart AND vacDateEnd) OR (@repDateEnd BETWEEN vacDateStart AND vacDateEnd))  
					AND vacEmployeeID=empID 
					AND empGUID1C=particulars
					AND source='Actual'
					AND scenario=@scnID
					AND `{$month}`<>0;";
	
}

$sql[] = "DELETE FROM reg_headcount WHERE scenario=@scnID AND source='Actual' AND ".$oBudget->getYTDSQL(1,$ytd)."=0;";

// echo '<pre>';print_r($sql);echo '</pre>';
for ($i=0;$i<count($sql);$i++){
	$oSQL->q($sql[$i]);
}

$sqlSelect = "SELECT prtRHQ, empID, empGUID, empCode1C, pccTitle, empTitle, empTitleLocal, empFunction, empSalary, empStartDate, empEndDate, end_date, 
						locTitle as 'Location', prtTitle as 'Activity', funTitle, funTitleLocal, pccTitle,pccTitleLocal , ".Budget::getMonthlySumSQL().", SUM(".Budget::getYTDSQL().")/12 as Total 
					FROM `reg_headcount`
					LEFT JOIN vw_function ON funGUID=function
					LEFT JOIN vw_product_type ON prtID=activity
					LEFT JOIN vw_location ON locID=location
					LEFT JOIN vw_profit ON pccID=pc
					LEFT JOIN vw_employee ON empGUID1C=particulars
					WHERE scenario='FYE_15_Jul'
					AND posted=1 AND active=1 AND salary>0";
			
			$sql = $sqlSelect." GROUP BY pc, `particulars`
					ORDER BY pc, empSalary DESC, funGUID, empTitleLocal";
			$rs = $oSQL->q($sql);			
			if (!$oSQL->num_rows($rs)){
				echo "<div class='warning'>No data found</div>";
				return (false);
			}
			
			$tableID = md5($sql);
			
include ('includes/inc-frame_top.php');			
			?>
			<table id='<?php echo $tableID;?>' class='budget'>
			<thead>
				<tr>
					<th>ID</th>		
					<th>Code</th>		
					<th>PC</th>		
					<th>Name</th>		
					<th>Title</th>		
					<th>Salary</th>		
					<th>Start date</th>		
					<th>Resignation date</th>					
				<?php echo Budget::getTableHeader('monthly'); ?><th class='budget-ytd'>Average</th></tr>
			</thead>			
			<tbody>
			<?php
			$pcc = "";
			while ($rw=$oSQL->f($rs)){				
				if ($pcc && $pcc!=$rw['pccTitle']){
					?>
					<tr class="budget-subtotal">
						<td colspan="8">Subtotal <?php echo $pcc;?></td>
						<?php				
						for ($m=1;$m<13;$m++){
							$month = date('M',mktime(0,0,0,$m,15));
							echo "<td class='budget-decimal budget-$month'>",Reports::render($subtotal[$pcc][$month],1),'</td>';							
						}
						?>
						<td class='budget-decimal budget-ytd'><?php echo Reports::render(array_sum($subtotal[$pcc])/12,1);?></td>
					</tr>
					<?php
				}
				?>
				<tr>
					<td><?php echo $rw['empID'];?></td>
					<td><?php echo $rw['empCode1C'];?></td>
					<td><?php echo $rw['pccTitle'];?></td>
					<td><?php echo $rw['empTitleLocal'];?></td>
					<td><?php echo $rw['empFunction'];?></td>
					<td class='budget-decimal'><?php echo number_format($rw['empSalary'],2,'.',',');?></td>
					<td><?php echo $rw['empStartDate'];?></td>
					<td><?php echo $rw['empEndDate']?$rw['empEndDate']:($rw['end_date']?'('.$rw['end_date'].')':'');?></td>				
				<?php				
				for ($m=1;$m<13;$m++){
					$month = date('M',mktime(0,0,0,$m,15));
					echo "<td class='budget-decimal budget-$month'>",Reports::render($rw[$month],1),'</td>';
					$total[$month] += $rw[$month];
					$subtotal[$rw['pccTitle']][$month] += $rw[$month];
				}
				?>
					<td class='budget-decimal budget-ytd'><?php echo Reports::render($rw['Total'],1);?></td>
				</tr>
			<?php
				
				$pcc = $rw['pccTitle'];
			}
			?>
			<tfoot>
			<tr class='budget-subtotal'>
			<td colspan="8">Total</td>
			<?php
				for ($m=1;$m<13;$m++){
					$month = date('M',mktime(0,0,0,$m,15));
					echo "<td class='budget-decimal budget-$month'>",Reports::render($total[$month],1),'</td>';					
				}
			?>
			<td class='budget-decimal budget-ytd'><?php echo Reports::render(array_sum($total)/12,1);?></td>
			</tr>
			</tfoot>
			</tbody>
			</table>
			
<?php
include ('includes/inc-frame_bottom.php');
			