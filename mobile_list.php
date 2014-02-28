<?php
require ('common/auth.php');
require ('classes/budget.class.php');

if(!isset($_GET['tab'])){
	$arrJS[]='js/input_form.js';
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],'</h1>';
	Budget::getProfitTabs();
	include ('includes/inc-frame_bottom.php');
} else {	
	$sql = "select empCode1C, empTitleLocal, empPhone, 
					empMobileLimit
			FROM vw_employee			
	WHERE empProfitID=(SELECT pccID FROM vw_profit WHERE pccGUID=".$oSQL->e($_GET['tab']).") 
		AND empMobileLimit>0
		AND empFlagDeleted=0 AND ifnull(empEndDate,0)=0
	ORDER BY empTitleLocal";
	$rs = $oSQL->q($sql);
	?>
	<table id='mobile_table' class='log'>
		<thead>
			<tr>
				<th>Таб.№</th>
				<th>Сотрудник</th>
				<th>Телефон</th>
				<th>Лимит</th>
			</tr>
		</thead>
		<tbody>
	<?php
	while ($rw = $oSQL->f($rs)){
		echo '<tr>';
		echo '<td>',$rw['empCode1C'],'</td>';
		echo '<td>',$rw['empTitleLocal'],'</td>';
		echo '<td>',preg_replace('/^([78])(\d{3})(\d{3})(\d{4})$/','$1 ($2) $3-$4',$rw['empPhone']),'</td>';
		echo '<td>',$rw['empMobileLimit'],'</td>';
		echo '</tr>';
	}
	?>
		</tbody>
	</table>
	<?php
	
}


?>