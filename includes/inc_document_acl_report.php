<?php
echo '<h2>Access to this document</h2>';
			$sql = "SELECT DISTINCT usrName, MAX(pgrFlagRead) FROM stbl_user
						JOIN stbl_role_user ON rluUserID=usrID
						JOIN stbl_page_role ON pgrRoleID=rluRoleID AND pgrPageID={$arrUsrData['pagID']}
						GROUP BY usrID						
						HAVING MAX(pgrFlagRead)=1
						ORDER BY usrID";
			$rs = $oSQL->q($sql);
			while ($rw = $oSQL->f($rs)){
				$arrRes[] = $rw['usrName'];
			}
			if (is_array($arrRes)){
				echo '<p>',implode(', ',$arrRes),'</p>';
			}
			echo '<h2>Access to this profit center</h2>';
			$arrRes = Array();
			$sql = "SELECT DISTINCT usrName, MAX(pcrFlagRead) FROM stbl_user
						JOIN stbl_role_user ON rluUserID=usrID
						JOIN stbl_profit_role ON pcrRoleID=rluRoleID AND pcrProfitID={$oDocument->profit}
						GROUP BY usrID						
						HAVING MAX(pcrFlagRead)=1
						ORDER BY usrID";
			$rs = $oSQL->q($sql);
			while ($rw = $oSQL->f($rs)){
				$arrRes[] = $rw['usrName'];
			}
			if (is_array($arrRes)){
				echo '<p>',implode(', ',$arrRes),'</p>';
			}
?>