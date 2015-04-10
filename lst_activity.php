<?php
$flagNoAuth = true;
require ('common/auth.php');
require ('includes/inc-frame_top.php');
?>
<table class='log'>
	<thead>
		<tr>
			<th>ID</th>
			<th>Title</th>
			<th>Title in RU</th>
			<th>GHQ</th>
			<th>Unit</th>
		</tr>
	</thead>
	<tbody>	
<?php
$sql = "SELECT prtID, prtTitle, prtTitleLocal, prtGHQ, prtUnit FROM vw_product_type ORDER BY prtGHQ, prtID";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	?>
		<tr>
			<td><?php echo $rw['prtID'];?></td>
			<td><?php echo $rw['prtTitle'];?></td>
			<td><?php echo $rw['prtTitleLocal'];?></td>
			<td><?php echo $rw['prtGHQ'];?></td>
			<td><?php echo $rw['prtUnit'];?></td>
		</tr>
	<?php
}
?>
	</tbody>
</table>
<?php
require ('includes/inc-frame_bottom.php');

?>