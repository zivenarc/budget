<?php
$flagNoAuth = true;
require ('common/auth.php');
require ('classes/budget.class.php');

$oBudget = new Budget($budget_scenario);

$sql = "SELECT customer_group_code, cntTitle, SUM(".$oBudget->getThisYTDSQL('ytd').") as YTD 
		FROM reg_master 
		LEFT JOIN common_db.tbl_counterparty ON cntID=customer_group_code
		WHERE account IN ('J00400','J00802') AND scenario IN ('{$arrSetup['stpFYEID']}','{$arrSetup['stpScenarioID']}')
		GROUP BY customer_group_code		
		ORDER BY YTD DESC
		";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	$arrJQCloud[] = Array('text'=>$rw['cntTitle'],'weight'=>(integer)$rw['YTD'],'link'=>"rep_sales_kpi_new.php?cntID={$rw['customer_group_code']}");
}

$arrJS[] = "../common/jquery/jQCloud/jqcloud/jqcloud-1.0.4.min.js";
$arrCSS[] = "../common/jquery/jQCloud/jqcloud/jqcloud.css";
include ('includes/inc-frame_top.php');
?>
<div id='cloud' style='width:1900px; height: 800px;'></div>
<script>
$(document).ready(function(){
	var words = <?php echo json_encode($arrJQCloud); ?>;
	
	$('#cloud').jQCloud(words,{
	  autoResize: false
	});
});
</script>
<?php
include ('includes/inc-frame_bottom.php');