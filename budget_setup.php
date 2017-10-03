<?php
require ('common/auth.php');
include ('classes/budget.class.php');

if ($_GET['option']=='full'){
	include ('includes/inc-frame_top.php');
	$sql = "SELECT * FROM tbl_scenario ORDER BY scnDateStart";
	$rs = $oSQL->q($sql);
	?>
	<table class='log'>
	<tr>
		<th>ID</th>
		<th>Title</th>
		<th>Year</th>
		<th>Start date</th>
		<th>Action</th>
	</tr>
	<?php
	while ($rw = $oSQL->f($rs)){
		?>
		<tr id="<?php echo $rw['scnID'];?>">
			<td><?php echo $rw['scnID'];?></td>
			<td><?php echo $rw['scnTitle'];?></td>
			<td><?php echo $rw['scnYear'];?></td>
			<td><?php echo $rw['scnDateStart'];?></td>
			<td>
			<?php if($rw['scnFlagArchive'] && $rw['scnFlagReadOnly']){ ?>
				<a class='scenario_delete' href="?tab=<?php echo $rw['scnID'];?>&DataAction=delete">[delete]</a>
			<?php } ?>
			</td>
		</tr>
		<?php
	}
	?>
	</table>
	<script>
		$(document).ready(function(){
			$('a.scenario_delete').click(function(event){
				event.preventDefault();
				$(this).addClass('spinner');
				$.get($(this).attr('href'),null,function(data){
					console.log(data);
					if(data.status=='success'){
						$('#'+data.id).remove();
					};
				});
			});
		});
	</script>
	<?php
	include ('includes/inc-frame_bottom.php');	
	die();
}


if ($_GET['tab']){
$oBudget = new Budget($_GET['tab']);
	
	$arrDefaultParams = Array('currency'=>643,'period_type'=>'cm','denominator'=>1000,'bu_group'=>($arrUsrData['PCC']['pccFlagProd']?$arrUsrData['PCC']['pccParentCode1C']:''));
	$strQuery = http_build_query($arrDefaultParams);
	
	if ($_GET['DataAction']=='delete'){		
		$res = $oBudget->delete();
		header('Content-type:application/json');
		echo json_encode($res);
		die();
	}

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
		case 'default':
			$oBudget->setAsDefault(false);
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
	<h2><?php echo $oBudget->title;?></h2>
	<div id='controlPanel' style="display:inline-block;">
	<table><tr>
	<td>
		<label for='scnLastID'>Reference period</label>
		<?php echo $oBudget->getScenarioSelect(Array('budget_scenario'=>$oBudget->reference_scenario->id)); ?>
	</td>
	<td>
	<label for="scnFlagReadOnly">Read-only</label><input type='checkbox' <?php echo $oBudget->flagUpdate?"":"checked";?> name='scnFlagReadOnly' id='scnFlagReadOnly'>
	<label for="scnFlagArchive">Archived</label><input type='checkbox' <?php echo $oBudget->flagArchive?"checked":"";?> name='scnFlagArchive' id='scnFlagArchive'>
	<?php
	if ($oBudget->id==$arrSetup['stpScenarioID']){
	?>
	<span class='info'>Default budget</span>
	<?php
	} elseif ($oBudget->id==$arrSetup['stpFYEID']){
	?>
	<span class='info'>Default actual scenario</span>
	<?php
	} else {
	?>
	<span><input type='button' value='Set as default' id='default'/></span>
	<span><input type='button' value='Get KPIs' onclick='sp_get_kpi.php?budget_scenario=<?php echo $oBudget->id;?>' id='kpis'/></span>
	<span><input type='button' value='Get headcount' onclick='rep_staff_costs.php?budget_scenario=<?php echo $oBudget->id;?>' id='headcount'/></span>
	<?php
	}
	?>
	</td>
	</tr></table>
	</div>
	<nav>
		<a target='_blank' href='sp_get_kpi.php?budget_scenario=<?php echo $_GET['tab'];?>'>Get KPIs from Nlogjc</a>|
		<a  target='_blank' href='rep_staff_costs.php?budget_scenario=<?php echo $_GET['tab'];?>'>Refresh headcount</a>|	
	</nav>
	<nav><span>Compare to <?php echo $oBudget->reference_scenario->title;?>:</span>
		<a href="rep_summary.php?<?php echo $strQuery;?>&budget_scenario=<?php echo $oBudget->id;?>&reference=<?php echo $oBudget->reference_scenario->id;?>">Summary</a>|
		<a href="rep_monthly.php?<?php echo $strQuery;?>&budget_scenario=<?php echo $oBudget->id;?>&reference=<?php echo $oBudget->reference_scenario->id;?>">Monthly report</a>|
		<a href="rep_pnl.php?<?php echo $strQuery;?>&budget_scenario=<?php echo $oBudget->id;?>&reference=<?php echo $oBudget->reference_scenario->id;?>">Full-year estimate</a>|
		<a href="rep_totals.php?<?php echo $strQuery;?>&budget_scenario=<?php echo $oBudget->id;?>&reference=<?php echo $oBudget->reference_scenario->id;?>">Results per BU</a>|
		<a href="rep_waterfall.php?<?php echo $strQuery;?>&budget_scenario=<?php echo $oBudget->id;?>&reference=<?php echo $oBudget->reference_scenario->id;?>">Waterfall</a>|
		<a href="rep_graphs.php?<?php echo $strQuery;?>&budget_scenario=<?php echo $oBudget->id;?>&reference=<?php echo $oBudget->reference_scenario->id;?>">Charts</a>|
		<a href="sp_ghq.php?<?php echo $strQuery;?>&budget_scenario=<?php echo $oBudget->id;?>&reference=<?php echo $oBudget->reference_scenario->id;?>">GHQ report</a>|
		<a href="rep_summary_ghq.php?<?php echo $strQuery;?>&budget_scenario=<?php echo $oBudget->id;?>&reference=<?php echo $oBudget->reference_scenario->id;?>">GHQ summary</a>|
		<a href="rep_sales_kpi.php?<?php echo $strQuery;?>&budget_scenario=<?php echo $oBudget->id;?>&reference=<?php echo $oBudget->reference_scenario->id;?>">Sales KPI</a>
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
			<th>YTD</th>
			<th>FYE</th>
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
				<td class="budget-decimal budget-ytd"><?php echo number_format($data['YTD'],4,'.',',');?></td>
				<td class="budget-decimal budget-quarterly"><?php echo number_format($data['Total'],4,'.',',');?></td>
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