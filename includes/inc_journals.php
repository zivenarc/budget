		<div class='panel' id='journal-user' style='float:right;'>
			<nav>
			<?php
			$sql = "SELECT responsible, usrTitle, SUM(1-posted-deleted) as nCount
					FROM vw_journal 
					LEFT JOIN stbl_user ON responsible=usrID
					WHERE scenario='{$_GET['tab']}'
					GROUP BY responsible
					ORDER BY nCount DESC";
			$rs =$oSQL->q($sql);
			while ($rw=$oSQL->f($rs)){
				?>
				<div><a href='sp_my.php?ownerID=<?php echo $rw['responsible'];?>#<?php echo $_GET['tab'];?>'><?php echo $rw['usrTitle'],($rw['nCount']?(' ('.$rw['nCount'].')'):'');?></a></div>
				<?php
			}
			?>
			</nav>
		</div>
		<div class='panel' id='journal-bu' style='float:right;'>
			<nav>
			<?php
			$sql = "SELECT pc, pccTitle, SUM(1-posted-deleted) as nCount
					FROM vw_journal 
					JOIN common_db.tbl_profit ON pc=pccID
					WHERE scenario='{$_GET['tab']}'
					GROUP BY pc
					ORDER BY nCount DESC";
			$rs =$oSQL->q($sql);
			while ($rw=$oSQL->f($rs)){
				?>
				<div><a href='sp_bu.php?pc=<?php echo $rw['pc'];?>#<?php echo $_GET['tab'];?>'><?php echo $rw['pccTitle'],' (',$rw['nCount'],')';?></a></div>
				<?php
			}
			?>
			</nav>
		</div>