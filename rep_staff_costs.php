<?php
$flagNoAuth = true;
require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/reports.class.php');

$repDateStart = '2015-01-01';
$repDateEnd = '2015-01-31';

$sql = "SELECT empID, empGUID, empCode1C, pccTitle, empTitle, empFunction, empSalary, empStartDate, empEndDate, 
	IF (empStartDate BETWEEN '{$repDateStart}' AND '{$repDateEnd}', 1 - DATEDIFF(empStartDate, '{$repDateStart}')/DATEDIFF('{$repDateEnd}','{$repDateStart}'),1)
		- IF (empEndDate BETWEEN '{$repDateStart}' AND '{$repDateEnd}', DATEDIFF('{$repDateEnd}', empEndDate )/DATEDIFF('{$repDateEnd}','{$repDateStart}'),0) as FTE
FROM common_db.tbl_employee, common_db.tbl_profit
WHERE empStartDate <= '{$repDateEnd}' 
AND (empEndDate IS NULL OR empEndDate >='{$repDateEnd}')
AND empSalary >0 AND empFlagDeleted=0
AND pccID = empProfitID";

$rs = $oSQL->q($sql);
include ('includes/inc-frame_top.php');

/*
?>
<div><?php echo $oSQL->num_rows($rs), " employees";?></div>
<table class='budget'>
<tr>
		<th>ID</th>		
		<th>Code</th>		
		<th>PC</th>		
		<th>Name</th>		
		<th>Title</th>		
		<th>Salary</th>		
		<th>Start date</th>		
		<th>Resignation date</th>		
		<th>FTE</th>		
</tr>
<?php
while ($rw = $oSQL->f($rs)){
?>
	<tr>
		<td><?php echo $rw['empID'];?></td>
		<td><?php echo $rw['empCode1C'];?></td>
		<td><?php echo $rw['pccTitle'];?></td>
		<td><?php echo $rw['empTitle'];?></td>
		<td><?php echo $rw['empFunction'];?></td>
		<td><?php echo $rw['empSalary'];?></td>
		<td><?php echo $rw['empStartDate'];?></td>
		<td><?php echo $rw['empEndDate'];?></td>
		<td><?php echo $rw['FTE'];?></td>
	</tr>
<?php	
};
?>
</table>


<?php
*/

$sqlSelect = "SELECT prtRHQ, empID, empGUID, empCode1C, pccTitle, empTitle, empTitleLocal, empFunction, empSalary, empStartDate, empEndDate, 
						locTitle as 'Location', prtTitle as 'Activity', funTitle, funTitleLocal, pccTitle,pccTitleLocal , ".Budget::getMonthlySumSQL().", SUM(".Budget::getYTDSQL().")/12 as Total 
					FROM `reg_headcount`
					LEFT JOIN vw_function ON funGUID=function
					LEFT JOIN vw_product_type ON prtID=activity
					LEFT JOIN vw_location ON locID=location
					LEFT JOIN vw_profit ON pccID=pc
					LEFT JOIN vw_employee ON empGUID1C=particulars
					WHERE scenario='FYE_15_Jul'
					AND posted=1 AND active=1 AND salary>0";
			
			$sql = $sqlSelect." GROUP BY `particulars`
					ORDER BY pc, empTitleLocal";
			$rs = $oSQL->q($sql);			
			if (!$oSQL->num_rows($rs)){
				echo "<div class='warning'>No data found</div>";
				return (false);
			}
			
			$tableID = md5($sql);
			
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
			while ($rw=$oSQL->f($rs)){
				?>
				<tr>
					<td><?php echo $rw['empID'];?></td>
					<td><?php echo $rw['empCode1C'];?></td>
					<td><?php echo $rw['pccTitle'];?></td>
					<td><?php echo $rw['empTitleLocal'];?></td>
					<td><?php echo $rw['empFunction'];?></td>
					<td><?php echo $rw['empSalary'];?></td>
					<td><?php echo $rw['empStartDate'];?></td>
					<td><?php echo $rw['empEndDate'];?></td>				
				<?php
				for ($m=1;$m<13;$m++){
					$month = date('M',mktime(0,0,0,$m,15));
					echo "<td class='budget-decimal budget-$month'>",Reports::render($rw[$month],1),'</td>';
				
				}
				?>
					<td class='budget-decimal budget-ytd'><?php echo Reports::render($rw['Total'],1);?></td>
				</tr>
			<?php
			}
			?>
			</tbody>
			</table>
			
<?php
include ('includes/inc-frame_bottom.php');
			