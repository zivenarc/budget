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
</div>
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