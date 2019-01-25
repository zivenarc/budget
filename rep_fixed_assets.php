<?php
$flagNoAuth = true;
require ('common/auth.php');
require ('classes/reports.class.php');
include ('includes/inc-frame_top.php');

$sql = "SELECT fixID, fixTItle, locTitleLocal, empTitleLocal, FIXPC.pccTitleLocal as FIX, EMPPC.pccTitleLocal as EMP 
		FROM common_db.`tbl_fixed_assets` 
		LEFT JOIN common_db.tbl_employee ON empGUID1C=fixEmployeeGUID
		LEFT JOIN common_db.tbl_profit FIXPC ON FIXPC.pccID=fixProfitID
		LEFT JOIN common_db.tbl_profit EMPPC ON EMPPC.pccID=empProfitID
		LEFT JOIN common_db.tbl_location ON locID=fixLocationID
		WHERE fixProfitID<>empProfitID AND fixDeprEnd>NOW()
		ORDER BY fixID";

$tableID=md5(time());

$rs = $oSQL->q($sql);
?>
<table class='budget' id='<?php echo $tableID;?>'>
	<tr>
		<th>#</th>
		<th>Код</th>
		<th>Наименование ОС</th>
		<th>Расположение</th>
		<th>МОЛ</th>
		<th>ЦФО для амортизации</th>
		<th>ЦФО МОЛ</th>
	</tr>
<?php
	$i = 1;
	while($rw = $oSQL->f($rs)){
			?>
		<tr>
			<td><?php echo $i;?></td>
			<td><?php echo $rw['fixID'];?></td>
			<td><?php echo $rw['fixTItle'];?></td>
			<td><?php echo $rw['locTitleLocal'];?></td>
			<td><?php echo $rw['empTitleLocal'];?></td>
			<td><?php echo $rw['FIX'];?></td>
			<td><?php echo $rw['EMP'];?></td>
		</tr>
		<?php
		$i++;
	}
?>
</table>
<?php
Reports::_echoButtonCopyTable($tableID);				
include ('includes/inc-frame_bottom.php');		