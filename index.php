<?php
require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/reports.class.php');
require ('classes/waterfall.class.php');

if (isset($_GET['no_activity'])){
	$arrNoActivity = $_GET['no_activity'];
	$sqlActivityFilter = " AND activity NOT IN(".implode(",",$arrNoActivity).") ";
	
	$filter['no_activity']=$_GET['no_activity'];
	
	$sql = "SELECT prtTitle FROM vw_product_type WHERE prtID IN (".implode(",",$arrNoActivity).") ";
	$rs = $oSQL->q($sql);
	while ($rw = $oSQL->f($rs)){
		$arrActivityFilter[] = $rw['prtTitle'];
	}
	$strActivity = implode(", ",$arrActivityFilter)." excluded";
	
}

   $arrActions[] = Array(
   "title" => ShowFieldTitle('Print')
   , "class" => "print"
   , "action" => "javascript:window.print();"
   );



$denominator = 1000;
$oActual = new Budget($arrSetup['stpFYEID']);
$oBudget = new Budget($arrSetup['stpScenarioID']);

if($_GET['DataAction']=='summary'){
	$oReport = new Reports(Array('budget_scenario'=>$oActual->id, 'currency'=>643, 'denominator'=>$denominator, 'reference'=>$oActual->reference_scenario->id, 'filter'=>$filter));
	$oReport->shortMonthlyReport();	
	die();
}

$arrJS[]='js/about.js';
require ('includes/inc-frame_top.php');

// echo '<pre>';print_r($arrUsrData);echo '</pre>';
$arrDefaultParams = Array('currency'=>643,'period_type'=>'cm','denominator'=>1000,'bu_group'=>($arrUsrData['PCC']['pccFlagProd']?$arrUsrData['PCC']['pccParentCode1C']:''));
$strQuery = http_build_query($arrDefaultParams);

?>
<h1>Current scenario - <?php echo $oActual->title; ?>, current budget - <?php echo $oBudget->title; ?></h1>
<?php
if($oActual->flagUpdate){
	$sql = "SELECT COUNT(guid) as nCount FROM vw_journal WHERE scenario='{$oActual->id}' AND responsible='{$arrUsrData['usrID']}' AND posted=0 AND deleted=0";
	$rs = $oSQL->q($sql);
	if($oSQL->n($rs)){
		$rw = $oSQL->f($rs);
		echo "<div class='warning'>You have {$rw['nCount']} <a href='sp_my.php?ownerID={$arrUsrData['usrID']}'>unposted documents</a> in [{$oActual->title}]</div>";
	}
}
if($oBudget->flagUpdate){
	$sql = "SELECT COUNT(guid) as nCount FROM vw_journal WHERE scenario='{$oBudget->id}' AND responsible='{$arrUsrData['usrID']}' AND posted=0 AND deleted=0";
	$rs = $oSQL->q($sql);
	if($oSQL->n($rs)){
		$rw = $oSQL->f($rs);
		echo "<div class='warning'>You have {$rw['nCount']} <a href='sp_my.php?ownerID={$arrUsrData['usrID']}'>unposted documents</a> in [{$oBudget->title}]</div>";
	}
	
	?>
	<nav><span><?php echo $oBudget->title;?>: </span>
		<a href="rep_summary.php?<?php echo $strQuery;?>&budget_scenario=<?php echo $oBudget->id;?>&reference=<?php echo $oBudget->reference_scenario->id;?>">Summary</a>|
		<a href="rep_monthly.php?<?php echo $strQuery;?>&budget_scenario=<?php echo $oBudget->id;?>&reference=<?php echo $oBudget->reference_scenario->id;?>">Monthly report</a>|
		<a href="rep_pnl.php?<?php echo $strQuery;?>&budget_scenario=<?php echo $oBudget->id;?>&reference=<?php echo $oBudget->reference_scenario->id;?>">Full-year estimate</a>|
		<a href="rep_totals.php?<?php echo $strQuery;?>&budget_scenario=<?php echo $oBudget->id;?>&reference=<?php echo $oBudget->reference_scenario->id;?>">Results per BU</a>|
		<a href="rep_waterfall.php?<?php echo $strQuery;?>&budget_scenario=<?php echo $oBudget->id;?>&reference=<?php echo $oBudget->reference_scenario->id;?>">Waterfall</a>|
		<a href="rep_graphs.php?<?php echo $strQuery;?>&budget_scenario=<?php echo $oBudget->id;?>&reference=<?php echo $oBudget->reference_scenario->id;?>">Charts</a>
	</nav>
	<?php
}

?>
<nav><span><?php echo $oActual->title;?> vs <?php echo $oActual->reference_scenario->title;?>:</span>
	<a href="rep_summary.php?<?php echo $strQuery;?>&budget_scenario=<?php echo $oActual->id;?>&reference=<?php echo $oActual->reference_scenario->id;?>">Summary</a>|
	<a href="rep_monthly.php?<?php echo $strQuery;?>&budget_scenario=<?php echo $oActual->id;?>&reference=<?php echo $oActual->reference_scenario->id;?>">Monthly report</a>|
	<a href="rep_pnl.php?<?php echo $strQuery;?>&budget_scenario=<?php echo $oActual->id;?>&reference=<?php echo $oActual->reference_scenario->id;?>">Full-year estimate</a>|
	<a href="rep_totals.php?<?php echo $strQuery;?>&budget_scenario=<?php echo $oActual->id;?>&reference=<?php echo $oActual->reference_scenario->id;?>">Results per BU</a>|
	<a href="rep_waterfall.php?<?php echo $strQuery;?>&budget_scenario=<?php echo $oActual->id;?>&reference=<?php echo $oActual->reference_scenario->id;?>">Waterfall</a>|
	<a href="rep_graphs.php?<?php echo $strQuery;?>&budget_scenario=<?php echo $oActual->id;?>&reference=<?php echo $oActual->reference_scenario->id;?>">Charts</a>
</nav>

<br/>
<?php
if ($strActivity) {
	echo '<div class="info">',$strActivity,'</div>';
}
//-----------------Waterfall
?>
<script>
	$(document).ready(function(){
		$('#summary').addClass('spinner').html('<h2>Loading summary...</h2>');
		$.get('index.php?DataAction=summary',function(data){
			$('#summary').html(data).removeClass('spinner');
		});
	});
</script>
<div id='summary'></div>
<div id='waterfall'>
<?php
$period_type = 'cm';

$sqlActual = "SUM(".$oActual->getThisYTDSQL($period_type,$arrActualRates).")";
$sqlBudget = "SUM(".$oActual->getThisYTDSQL($period_type,$arrBudgetRates).")";
$settings['gpcus'] = Array('title'=>"GP by customer, current month",
					'sqlBase' => "SELECT customer_group_code as optValue, 
											customer_group_title as optText,  
										{$sqlActual} as Actual, 
										0 as Budget, 
										{$sqlActual} as Diff
								FROM vw_master 
								WHERE scenario='{$oActual->id}'  AND company='{$company}'
									AND account IN ('J00400', 'J00802')
									{$sqlActivityFilter}
								GROUP BY customer_group_code
								UNION ALL
								SELECT customer_group_code as optValue, 
											customer_group_title as optText,  
											0 as Actual, 
								{$sqlBudget}  as Budget, -{$sqlBudget} as Diff
								FROM vw_master 
								WHERE scenario='{$oActual->reference_scenario->id}'  AND company='{$company}'
									AND source<>'Estimate' 
									AND account IN ('J00400', 'J00802')
									{$sqlActivityFilter}
								GROUP BY customer_group_code",
						'tolerance'=>0.05,
						'denominator'=>$denominator,
						'limit'=>10);	

$oWF = new Waterfall($settings['gpcus']);

$oWF->draw();
?>
</div>
<?php
require ('includes/inc-frame_bottom.php');
?>