<?php
$id = 0;
	$level = 1;
	function getNode($id,&$level,&$children){
		GLOBAL $oSQL;
		$sql = "SELECT E1.empID, 
					E1.empTitle,
					E1.empTitleLocal,
					E1.empUserID,
					E1.empFunction,
					E1.empFunctionLocal,
					COUNT(E2.empID) as nodes
					FROM common_db.tbl_employee E1
					LEFT JOIN common_db.tbl_employee E2 ON E2.empManagerID=E1.empID
					WHERE IFNULL(E1.empManagerID,0)='$id' 
					AND E1.empFlagFolder=0 
					AND (E1.empFlagDeleted=0 AND E1.empEndDate IS NULL)
					GROUP BY E1.empID
					ORDER BY 
					nodes DESC, E1.empFlagDeleted, E1.empTitle$strLocal";
		$rs = $oSQL->do_query($sql);
		$i=0;
		while ($rw=$oSQL->fetch_array($rs)){			
			// $children[$i] = $rw;
			// getNode($rw['empID'],$level,$children[$i]['children']);
			$children[] = $rw;
			getNode($rw['empID'],$level,$children);
			$i++;
		}
		return $children;
	}
	
	$subordinates = getNode($arrUsrData['usrEmployeeID'],$level,$children);
	echo '<pre>';print_r($tree);echo '</pre>';
	?>
	<ul class='link-footer'>
		<li><a href="?ownerID=<?php echo $arrUsrData['usrID'];?>">My documents</a>
		<?php
		if (is_array($subordinates)){
			foreach($subordinates as $id=>$data){
				if($data['empUserID']){
					?><li><a href="?ownerID=<?php echo $data['empUserID'];?>"><?php echo $data['empTitle'];?></a><?php
					$arrOwnerID[] = $data['empUserID'];
				}
			}
			?><li><a href="?ownerID[]=<?php echo $arrUsrData['usrID'],implode("&ownerID[]=",$arrOwnerID); ?>">All subordinates</a><?php
		}
		?>
	</ul>
