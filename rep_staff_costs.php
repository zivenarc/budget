<?php
$flagNoAuth = true;
require ('common/auth.php');

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