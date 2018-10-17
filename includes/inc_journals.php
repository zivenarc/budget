		<div class='panel' id='journal-user' style='float:right;'>
			<nav>
			<?php
			$sql = "SELECT responsible, usrTitle$strLocal as usrTitle, usrFlagDeleted, SUM(1-posted-deleted) as nCount
					FROM vw_journal 
					LEFT JOIN stbl_user ON responsible=usrID
					WHERE scenario='{$_GET['tab']}'
					GROUP BY responsible
					ORDER BY nCount DESC";
			$rs = $oSQL->q($sql);
			$arrReport = Array($arrUsrData['usrID']=>Array());
			while ($rw=$oSQL->f($rs)){
				$arrReport[$rw['responsible']] = $rw;
			};
			
			foreach ($arrReport as $user=>$data){
				?>
				<div>
					<?php if ($user==$arrUsrData['usrID']) { echo '<strong>'; }?>
					<a href='sp_my.php?ownerID=<?php echo $user;?>#<?php echo $_GET['tab'];?>'>
					<?php echo ($data['usrFlagDeleted']?'<del>':''),$data['usrTitle'],($data['usrFlagDeleted']?'</del>':''),($data['nCount']?(' ('.$data['nCount'].')'):'');?>
					</a>
					<?php if ($user==$arrUsrData['usrID']) { echo '</strong>'; }?>
				</div>
				<?php	
			}
			?>
			</nav>
		</div>
		<div class='panel' id='journal-bu' style='float:right;'>
			<nav>
			<?php
			$sql = "SELECT pc, pccTitle$strLocal as pccTitle, pccFlagDeleted, SUM(1-posted-deleted) as nCount
					FROM vw_journal 
					JOIN common_db.tbl_profit ON pc=pccID
					WHERE scenario='{$_GET['tab']}'
					GROUP BY pc
					ORDER BY nCount DESC";
			$rs =$oSQL->q($sql);
			$arrReport = Array($arrUsrData['usrProfitID']=>Array());
			while ($rw=$oSQL->f($rs)){
				$arrReport[$rw['pc']] = $rw;
			};
			foreach ($arrReport as $pc=>$data){
				?>
				<div>
				<?php if ($pc==$arrUsrData['usrProfitID']) { echo '<strong>'; }?>
				<a href='sp_bu.php?pc=<?php echo $pc;?>#<?php echo $_GET['tab'];?>'>
				<?php echo ($data['pccFlagDeleted']?'<del>':''),$data['pccTitle'],($data['pccFlagDeleted']?'</del>':''),($data['nCount']?(' ('.$data['nCount'].')'):'');?>
				</a>
				<?php if ($pc==$arrUsrData['usrProfitID']) { echo '</strong>'; }?>
				</div>
				<?php
			}
			?>
			</nav>
		</div>