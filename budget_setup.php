<?php
require ('common/auth.php');
include ('classes/budget.class.php');

if ($_GET['tab']){
$oBudget = new Budget($_GET['tab']);

echo '<h2>',$oBudget->title,'</h2>';
$arrData = $oBudget->getSettings();
?>
<table class='log'>
<thead>
	<tr><th>Variable</th><th>Value</th></tr>
</thead>
<?php
	foreach($arrData as $key=>$value){
		echo '<tr>';
		echo '<td>',$key,'</td>';
		echo '<td class="budget-decimal">',$value,'</td>';
		echo '</tr>';
	};
?>
</table>

<?php
} else {
	$arrJS[] = 'js/journal.js';
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],'</h1>';
	Budget::getScenarioTabs();
	include ('includes/inc-frame_bottom.php');
}

?>