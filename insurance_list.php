<?php
require ('common/auth.php');
require ('classes/budget.class.php');

if(!isset($_GET['tab'])){
	$arrJS[]='js/input_form.js';
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],'</h1>';
	Budget::getProfitTabs('reg_headcount');
	include ('includes/inc-frame_bottom.php');
} else {	
	$sql = "select empTitleLocal, 
					dmsTitle, 
					dmsPrice, 
					FLOOR((TO_DAYS(NOW())-TO_DAYS(empBirthDate))/365) as Age, 
					CASE 
						WHEN FLOOR((TO_DAYS(NOW())-TO_DAYS(empBirthDate))/365)>=55 THEN 1.6 
						ELSE 1 
					END as K,  
					empBirthDate 
			FROM tbl_employee_insurance 
	left join vw_employee ON empGUID1C=emdEmployeeID
	left join vw_profit ON empProfitID=pccID
	left join tbl_insurance ON dmsID=emdInsuranceID
	WHERE pccGUID=".$oSQL->e($_GET['tab'])."
	ORDER BY empTitleLocal, dmsPrice";
	$rs = $oSQL->q($sql);
	?>
	<table id='dms_table' class='log'>
		<thead>
			<tr>
				<th>Сотрудник</th>
				<th>Программа</th>
				<th>Стоимость</th>
				<th>Коэффициент</th>
			</tr>
		</thead>
		<tbody>
	<?php
	while ($rw = $oSQL->f($rs)){
		echo '<tr>';
		echo '<td>',$rw['empTitleLocal'],'</td>';
		echo '<td>',$rw['dmsTitle'],'</td>';
		echo '<td>',$rw['dmsPrice'],'</td>';
		echo '<td>',$rw['K'],'</td>';
		echo '</tr>';
	}
	?>
		</tbody>
	</table>
	<?php
	
}


?>