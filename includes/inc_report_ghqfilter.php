<?php
if ($_GET['prtGHQ']=='all'){
		$sqlWhere = " WHERE company='{$company}'";
		// $filter = Array();
	} else {
		if ($_GET['prtGHQ']=='OFF') {
		$sqlWhereP = " WHERE prtGHQ IN ('Ocean import','Ocean export')";
		$filter = Array('prtGHQ'=>Array('Ocean import','Ocean export'));
		
		} elseif ($_GET['prtGHQ']=='AFF') {
			$sqlWhereP = " WHERE prtGHQ IN ('Air import','Air export')";
			$filter = Array('prtGHQ'=>Array('Air import','Air export'));

		} else {
			$sqlWhereP = " WHERE prtGHQ=".$oSQL->e(urldecode($_GET['prtGHQ']));
			$filter = Array('prtGHQ'=>urldecode($_GET['prtGHQ']));
			
		}
		
		$sql = "SELECT * FROM vw_product_type {$sqlWhereP}";
		$rs = $oSQL->q($sql);
		while ($rw = $oSQL->f($rs)){
			$arrProducts['title'][] = $rw['prtTitle'];
			$arrProducts['id'][] = (integer)$rw['prtID'];
		}
		
		$sqlWhere = "WHERE activity IN (".implode(',',$arrProducts['id']).") AND company='$company'";
		$filter = Array('activity'=>$arrProducts['id']);
		
		
	}
	
?>