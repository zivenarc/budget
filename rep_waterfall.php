<?php
$flagNoAuth = true;
include('common/auth.php');
require ('classes/budget.class.php');
require ('classes/waterfall.class.php');
include ('includes/inc_report_settings.php');

$oBudget = new Budget($budget_scenario);

$actual = $oBudget->id;
$budget = $oBudget->reference_scenario->id;
$limit = 8;
$denominator = 1000;

$settings['gpcus'] = Array('title'=>"GP by customer",
					'sqlBase' => "SELECT IF(C.cntParentID<>723,C.cntParentID, C.cntID) as optValue, 
										IF(C.cntParentID<>723,(SELECT P.cntTitle FROM common_db.tbl_counterparty P WHERE P.cntID=C.cntParentID),cntTitle) as optText, 
										SUM(".$oBudget->getThisYTDSQL().") as Actual, 
										0 as Budget, 
										SUM(".$oBudget->getThisYTDSQL().") as Diff
								FROM vw_master 
								LEFT JOIN common_db.tbl_counterparty C ON C.cntID=customer
								WHERE scenario='{$actual}' AND source='Actual' AND account IN ('J00400', 'J00802')
								GROUP BY IF(C.cntParentID<>723,C.cntParentID, C.cntID)
								UNION ALL
								SELECT IF(C.cntParentID<>723,C.cntParentID,C.cntID), IF(C.cntParentID<>723,(SELECT P.cntTitle FROM common_db.tbl_counterparty P WHERE P.cntID=C.cntParentID),cntTitle) as optText, 0 as Actual, SUM(".$oBudget->getThisYTDSQL().")  as Budget, -SUM(".$oBudget->getThisYTDSQL().") as Diff
								FROM vw_master 
								LEFT JOIN common_db.tbl_counterparty C ON C.cntID=customer
								WHERE
								scenario='{$budget}' AND source<>'Estimate' AND account IN ('J00400', 'J00802')
								GROUP BY IF(C.cntParentID<>723,C.cntParentID, C.cntID)",
						'tolerance'=>0.05,
						'limit'=>10);

$settings['gpbu'] = Array('title'=>"GP by business unit",
'sqlBase' => "SELECT pc as optValue, 
					Profit as optText, 
					SUM(".$oBudget->getThisYTDSQL().") as Actual, 
					0 as Budget, 
					SUM(".$oBudget->getThisYTDSQL().") as Diff
			FROM vw_master 			
			WHERE scenario='{$actual}' AND source='Actual' AND account IN ('J00400', 'J00802')
			GROUP BY pc
			UNION ALL
			SELECT pc, Profit, 0 as Actual, SUM(".$oBudget->getThisYTDSQL().")  as Budget, -SUM(".$oBudget->getThisYTDSQL().") as Diff
			FROM vw_master 			
			WHERE
			scenario='{$budget}' AND source<>'Estimate' AND account IN ('J00400', 'J00802')
			GROUP BY pc",
			'tolerance'=>0.05
			);

$settings['opbu'] = Array('title'=>"OP by business unit",
'sqlBase' => "SELECT pc as optValue, 
					Profit as optText, 
					SUM(".$oBudget->getThisYTDSQL().") as Actual, 
					0 as Budget, 
					SUM(".$oBudget->getThisYTDSQL().") as Diff
			FROM vw_master 			
			WHERE scenario='{$actual}' AND source='Actual' AND LEFT(account,1) NOT IN ('6', '7')
			GROUP BY pc
			UNION ALL
			SELECT pc, Profit, 0 as Actual, SUM(".$oBudget->getThisYTDSQL().")  as Budget, -SUM(".$oBudget->getThisYTDSQL().") as Diff
			FROM vw_master 			
			WHERE
			scenario='{$budget}' AND source<>'Estimate' AND LEFT(account,1) NOT IN ('6', '7')
			GROUP BY pc"
			);

			
			
$settings['pbt'] = Array('title'=>"PBT by factors",
'sqlBase' => "SELECT IF(`Group_code` IN (108,110,96),item,Group_code)  as optValue, 
					IF(`Group_code` IN (108,110,96),`Budget item`,`Group`) as optText, 
					SUM(".$oBudget->getThisYTDSQL().") as Actual, 
					0 as Budget, 
					SUM(".$oBudget->getThisYTDSQL().") as Diff
			FROM vw_master 			
			WHERE scenario='{$actual}' AND source='Actual' AND Group_code<>121
			GROUP BY IF(`Group_code` IN (108,110,96),item, Group_code)
			UNION ALL
			SELECT IF(`Group_code` IN (108,110,96),item,Group_code), 
				IF(`Group_code` IN (108,110,96),`Budget item`,`Group`), 
				0 as Actual, SUM(".$oBudget->getThisYTDSQL().")  as Budget, -SUM(".$oBudget->getThisYTDSQL().") as Diff
			FROM vw_master 			
			WHERE
			scenario='{$budget}' AND source<>'Estimate' AND Group_code<>121
			GROUP BY IF(`Group_code` IN (108,110,96),item, Group_code)",
			'tolerance'=>0.07);

$settings['pbtwwh'] = Array('title'=>"PBT by factors w/o Warehouse",
'sqlBase' => "SELECT IF(`Group_code` IN (108,110,96),item,Group_code)  as optValue, 
					IF(`Group_code` IN (108,110,96),`Budget item`,`Group`) as optText, 
					SUM(".$oBudget->getThisYTDSQL().") as Actual, 
					0 as Budget, 
					SUM(".$oBudget->getThisYTDSQL().") as Diff
			FROM vw_master 			
			WHERE scenario='{$actual}' AND source='Actual' AND pc NOT IN (5,15) AND Group_code<>121
			GROUP BY IF(`Group_code` IN (108,110,96),item, Group_code)
			UNION ALL
			SELECT IF(`Group_code` IN (108,110,96),item,Group_code), 
				IF(`Group_code` IN (108,110,96),`Budget item`,`Group`), 
				0 as Actual, SUM(".$oBudget->getThisYTDSQL().")  as Budget, -SUM(".$oBudget->getThisYTDSQL().") as Diff
			FROM vw_master 			
			WHERE scenario='{$budget}' AND source<>'Estimate' AND pc NOT IN (5,15) AND Group_code<>121
			GROUP BY IF(`Group_code` IN (108,110,96),item, Group_code)",
			'tolerance'=>0.07);
			
$type = $_GET['type']?$_GET['type']:'gpcus';
			
if (is_array($settings[$type])){
	$oWF = new Waterfall($settings[$type]);
} else {
	die('Wrong report type');
}
					
require ('includes/inc-frame_top.php');

// echo '<pre>';print_r($settings);echo '</pre>';

?>
<h1>Waterfall<?php echo ': ',$oBudget->title;?></h1>
<div class='f-row'><label for='budget_scenario'>Select scenario</label><?php echo Budget::getScenarioSelect();?></div>
<?php
	$oWF->draw();
?>
<script>
var tabs_options = {};
$(document).ready(function(){
	$('#tabs').tabs(tabs_options);
	$('#budget_scenario').change(function(){		
		$(this).wrap($('<form>',{method:'GET',id:'scenario'}));		
		console.log($(this));
		$('#scenario').submit();
	});
		
	
});
</script>
<nav>
<ul class='link-footer'>
<?php
foreach($settings as $type=>$data){
	$temp = $_GET;
	$temp['type'] = $type;
	$url = $_SERVER['PHP_SELF']."?".http_build_query($temp);
	echo '<li><a href="',$url,'">',$data['title'],'</a></li>';
}
?>
</ul>
</nav>
<?php

require ('includes/inc-frame_bottom.php');

?>