<?php
require ('common/auth.php');
include ('classes/budget.class.php');

if ($_GET['tab']){
$oBudget = new Budget($_GET['tab']);

switch ($_POST['DataAction']){
	case 'readonly':
		$oBudget->readOnly(true);
		break;
	case 'readwrite':
		$oBudget->readOnly(false);
		break;
	case 'archive':
		$oBudget->archive(true);
		break;
	case 'unarchive':
		$oBudget->archive(false);
		break;
	default:
		//do nothing
		break;
};

$oBudget->getSettings();
$arrData = $oBudget->extendedSettings;

$sql = "SELECT * FROM vw_currency JOIN tbl_variable ON curTitle=varID";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	$arrRates[$rw['curTitle']] = $oBudget->getMonthlyRates($rw['curID']);
}

?>
<div>
<h2><?php echo $oBudget->title;?> :: 
Read-only<input type='checkbox' <?php echo $oBudget->flagUpdate?"":"checked";?> name='scnFlagReadOnly' id='scnFlagReadOnly'>
Archived<input type='checkbox' <?php echo $oBudget->flagArchive?"checked":"";?> name='scnFlagArchive' id='scnFlagArchive'>
</h2>
	<div class='f-row'>
		<label for='scnLastID'>Reference period</label>
		<?php echo $oBudget->getScenarioSelect(Array('budget_scenario'=>$oBudget->reference_scenario->id)); ?>
	</div>
<nav>
	<a href='sp_get_kpi.php?budget_scenario=<?php echo $_GET['tab'];?>'>Get KPIs from Nlogjc</a>|
	<a href='rep_staff_costs.php?budget_scenario=<?php echo $_GET['tab'];?>'>Refresh headcount</a>|	
</nav>
</div>
<h2>Budget variables</h2>
<table class='log'>
<thead>
	<tr><th>Title</th><th>Variable</th><th>Value</th></tr>
</thead>
<?php
	if (count($arrData)){
		foreach($arrData as $key=>$setting){
			echo '<tr>';
			echo '<td>',$setting['title'],'</td>';
			echo '<td><tt>',$key,'</tt></td>';
			echo '<td class="budget-decimal">',$setting['value'],'</td>';
			echo '</tr>';
		};
	} else {
		echo '<tr><td colspan="3">No settings defined for this scenario</td></tr>';
	}
?>
</table>
<h2>Currency rates</h2>
<table class='log'>
	<thead>
		<tr>
		<th>Currency</th>
		<?php
		echo $oBudget->getTableHeader('monthly', 1+$oBudget->offset, 12+$oBudget->offset);
		?>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ($arrRates as $cur=>$data){
		?>
		<tr>
		<td><?php echo $cur;?></td>
		<?php
		for ($m=1+$oBudget->offset;$m<=12+$oBudget->offset;$m++){
			$month = $oBudget->arrPeriod[$m];		
			//$month = $oBudget->arrPeriod[$m];
			echo '<td class="budget-decimal">',number_format($data[$month],4,'.',','),'</td>';
		}
		?>
		</tr>
		<?php
		}
		?>
	</tbody>
</table>
<?php
} else {
	$arrJS[] = 'js/journal.js';
	$arrJS[] = 'js/budget_setup.js';
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],'</h1>';
	Budget::getScenarioTabs();
	?>
	<nav>
		<a href='sp_post_all.php'>Post all</a>|
		<a href='sp_repost_hr.php'>HR docs</a>|
		<a href='sp_repost_loc.php'>Location costs</a>|
		<a href='sp_repost_hq.php'>HQ costs</a>
	</nav>
	<?php
	include ('includes/inc-frame_bottom.php');
}

?>