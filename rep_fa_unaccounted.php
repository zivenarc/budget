<?php
// $flagNoAuth =true;
require ('common/auth.php');
require ('classes/budget.class.php');

if(isset($_GET['tab'])){
	$oBudget = new Budget($_GET['tab']);
	
	$dateBudgetStart = date('Y-m-d',$oBudget->date_start);
	$dateBudgetEnd = date('Y-m-d 23:59:59',$oBudget->date_end);
			

	
	?>
	<div id="report">
	<pre style="display:none;"><?php echo $sql;?></pre>
	<h2>Unaccounted assets</h2>
	<ol>
	<?php
	$sql = "SELECT *, PERIOD_DIFF(EXTRACT(YEAR_MONTH FROM '{$dateBudgetStart}'), EXTRACT(YEAR_MONTH FROM fixDeprStart)) AS months,
					fixValueStart*(1-PERIOD_DIFF(EXTRACT(YEAR_MONTH FROM '{$dateBudgetStart}'), EXTRACT(YEAR_MONTH FROM fixDeprStart))/fixDeprDuration) as fixValuePrimo,
					fixValueStart*(1-PERIOD_DIFF(EXTRACT(YEAR_MONTH FROM '{$dateBudgetEnd}'), EXTRACT(YEAR_MONTH FROM fixDeprStart))/fixDeprDuration) as fixValueUltimo
					FROM vw_fixed_assets 
					LEFT JOIN vw_item ON itmID=fixItemID
					LEFT JOIN reg_depreciation ON particulars=fixGUID AND scenario='{$oBudget->id}' AND posted=1
					LEFT JOIN vw_profit ON pccID=fixProfitID
					WHERE DATEDIFF(fixDeprEnd,'{$dateBudgetStart}')>0 
						AND fixFlagDeleted=0 
						AND fixFlagFolder=0
						AND particulars IS NULL					 
					ORDER BY fixProfitID, fixItemID";
			
	$rs =$oSQL->q($sql);
	while ($rw=$oSQL->f($rs)){
		// print_r($rw);
		echo "<li>[{$rw['fixID']}] {$rw["fixTitle"]}, {$rw["pccTitle$strLocal"]}
			<div><small>".$rw['fixDeprStart']." &ndash; ".$rw['fixDeprEnd']."</small></div>
			</li>";
	}
	?>
	</ol>
	<h2>Misplaced assets</h2>
	<ol>
	<?php
	$sql = "SELECT vw_fixed_assets.*, pcFix.pccTitle as fixProfit, pcDep.pccTitle as depProfit 
						FROM reg_depreciation
						LEFT JOIN vw_fixed_assets ON particulars=fixGUID
						LEFT JOIN vw_profit pcFix ON pcFix.pccID=fixProfitID
						LEFT JOIN vw_profit pcDep ON pcDep.pccID=pc
						WHERE scenario='{$oBudget->id}' 
							AND fixProfitID<>pc
						ORDER BY fixProfitID, fixItemID";
			
	$rs =$oSQL->q($sql);
	while ($rw=$oSQL->f($rs)){
		// print_r($rw);
		echo "<li>[{$rw['fixID']}] {$rw["fixTitle"]}, {$rw["fixProfit"]} registered in {$rw["depProfit"]}
			<div><small>".$rw['fixDeprStart']." &ndash; ".$rw['fixDeprEnd']."</small></div>
			</li>";
	}
	?>
	</ol>
	</div>
	<?php
	
	die();
}

include ('includes/inc-frame_top.php');



echo '<h1>',$arrUsrData["pagTitle$strLocal"],'</h1>';
echo Budget::getScenarioTabs(true);



include ('includes/inc-frame_bottom.php');
?>