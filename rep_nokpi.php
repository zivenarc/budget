<?php
// $flagNoAuth =true;
require ('common/auth.php');

if ($_GET['tab']){
	require ('classes/reports.class.php');	
	?>
	<div id='div_<?php echo $_GET['tab'];?>'>
	<?php
	$data = Array();
	$sql = "SELECT source FROM reg_sales WHERE scenario='{$_GET['tab']}' GROUP BY source HAVING SUM(kpi)=0";
	$rs =$oSQL->q($sql);
	if ($oSQL->n($rs)){
	$arrSource = Array();
		while ($rw=$oSQL->f($rs)){
			$arrSource[] = "'".$rw['source']."'";
		}	
		$sql = "SELECT *, edit_date as timestamp FROM vw_journal 				
			WHERE scenario='{$_GET['tab']}' 
				AND guid IN (".implode(",",$arrSource).")
			GROUP BY guid
			ORDER BY responsible, timestamp DESC";	

			$rs =$oSQL->q($sql);
			while ($rw=$oSQL->f($rs)){
				$data[] = $rw;
			}
			?>
			<!--<button onclick="repost('<?php echo $_GET['tab']; ?>', event);">Repost documents</button>-->			
			<h3>No KPIs recorded</h3>
			<?php
			Reports::getJournalEntries($data);

	}
	
	$data = Array();
	$arrActivity = Array(74,72,5,75);
	$sql = "SELECT source FROM reg_sales WHERE scenario='{$_GET['tab']}' AND activity IN(".implode(',',$arrActivity).") GROUP BY source";
	$rs =$oSQL->q($sql);
	if ($oSQL->n($rs)){
	$arrSource = Array();
		while ($rw=$oSQL->f($rs)){
			$arrSource[] = "'".$rw['source']."'";
		}	
		$sql = "SELECT *, edit_date as timestamp FROM vw_journal 				
			WHERE scenario='{$_GET['tab']}' 
				AND guid IN (".implode(",",$arrSource).")
			GROUP BY guid
			ORDER BY responsible, timestamp DESC";	

			$rs =$oSQL->q($sql);
			while ($rw=$oSQL->f($rs)){
				$data[] = $rw;
			}
			?>
			<!--<button onclick="repost('<?php echo $_GET['tab']; ?>', event);">Repost documents</button>-->			
			<h3>Forbidden activities</h3>
			<?php
			Reports::getJournalEntries($data);

	}
	
	$data = Array();
	$arrActivity = Array(46,48);
	$sql = "SELECT source FROM reg_sales 
			WHERE scenario='{$_GET['tab']}' AND activity IN(".implode(',',$arrActivity).") 
			GROUP BY source
			HAVING SUM(hbl)=0";
	$rs =$oSQL->q($sql);
	if ($oSQL->n($rs)){
	$arrSource = Array();
		while ($rw=$oSQL->f($rs)){
			$arrSource[] = "'".$rw['source']."'";
		}	
		$sql = "SELECT *, edit_date as timestamp FROM vw_journal 				
			WHERE scenario='{$_GET['tab']}' 
				AND guid IN (".implode(",",$arrSource).")
			GROUP BY guid
			ORDER BY responsible, timestamp DESC";	

			$rs =$oSQL->q($sql);
			while ($rw=$oSQL->f($rs)){
				$data[] = $rw;
			}
			?>
			<!--<button onclick="repost('<?php echo $_GET['tab']; ?>', event);">Repost documents</button>-->			
			<h3>No scope set for Profit share</h3>
			<?php
			Reports::getJournalEntries($data);

	}
	
	$data = Array();
	$arrActivity = Array(46,48);
	$sql = "SELECT source FROM reg_sales 
			WHERE scenario='{$_GET['tab']}' AND activity IN(".implode(',',$arrActivity).") AND jo=714
			GROUP BY source
			";
	$rs =$oSQL->q($sql);
	if ($oSQL->n($rs)){
	$arrSource = Array();
		while ($rw=$oSQL->f($rs)){
			$arrSource[] = "'".$rw['source']."'";
		}	
		$sql = "SELECT *, edit_date as timestamp FROM vw_journal 				
			WHERE scenario='{$_GET['tab']}' 
				AND guid IN (".implode(",",$arrSource).")
			GROUP BY guid
			ORDER BY responsible, timestamp DESC";	

			$rs =$oSQL->q($sql);
			while ($rw=$oSQL->f($rs)){
				$data[] = $rw;
			}
			?>
			<!--<button onclick="repost('<?php echo $_GET['tab']; ?>', event);">Repost documents</button>-->			
			<h3>Wrong job owner</h3>
			<?php
			Reports::getJournalEntries($data);

	}
	
	
	$data = Array();
	$sql = "SELECT source FROM reg_master 
			LEFT JOIN vw_product_type ON prtID=activity
			WHERE scenario='{$_GET['tab']}' AND account='J00400' AND source NOT IN ('Actual','Estimate')
			GROUP BY source 
			HAVING COUNT(DISTINCT prtGHQ)>1";
	$rs =$oSQL->q($sql);
	if ($oSQL->n($rs)){
	$arrSource = Array();
		while ($rw=$oSQL->f($rs)){
			$arrSource[] = "'".$rw['source']."'";
		}	
		$sql = "SELECT *, edit_date as timestamp FROM vw_journal 				
			WHERE scenario='{$_GET['tab']}' 
				AND guid IN (".implode(",",$arrSource).")
			GROUP BY guid
			ORDER BY responsible, timestamp DESC";	

			$rs =$oSQL->q($sql);
			while ($rw=$oSQL->f($rs)){
				$data[] = $rw;
			}
			?>
			<!--<button onclick="repost('<?php echo $_GET['tab']; ?>', event);">Repost documents</button>-->			
			<h3>Multiple activities</h3>
			<?php
			Reports::getJournalEntries($data);

	}
	
	$data = Array();
	$sql = "SELECT source FROM reg_sales 
			WHERE scenario='{$_GET['tab']}' 
				AND activity IN (48,63) AND bo=714
			GROUP BY source";
	$rs =$oSQL->q($sql);
	if ($oSQL->n($rs)){
	$arrSource = Array();
		while ($rw=$oSQL->f($rs)){
			$arrSource[] = "'".$rw['source']."'";
		}	
		$sql = "SELECT *, edit_date as timestamp FROM vw_journal 				
			WHERE scenario='{$_GET['tab']}' 
				AND guid IN (".implode(",",$arrSource).")
			GROUP BY guid
			ORDER BY responsible, timestamp DESC";	

			$rs =$oSQL->q($sql);
			while ($rw=$oSQL->f($rs)){
				$data[] = $rw;
			}
			?>
			<!--<button onclick="repost('<?php echo $_GET['tab']; ?>', event);">Repost documents</button>-->			
			<h3>Freehand OFF - check!</h3>
			<?php
			Reports::getJournalEntries($data);

	}
	?>
	</div>
	<?php
} else {
	require ('classes/budget.class.php');
	$arrJS[] = 'js/journal.js';
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],'</h1>';
	echo Budget::getScenarioTabs(true);
	include ('includes/inc-frame_bottom.php');
}
?>