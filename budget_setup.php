<?php
require ('common/auth.php');
include ('classes/reports.class.php');
$arrJS[] = 'js/journal.js';
$arrJS[] = 'js/budget_setup.js';

if ($_GET['DataAction']=='excel_gp'){
	$oBudget = new Budget($_GET['budget_scenario']);
	include_once ("../common/eiseList/inc_excelXML.php");
	$xl = new excelXML();            
	$arrHeader = Array('Company','IV','Customer group','Customer','Account','Account Group','Activity','GHQ Product','Amount');	
	$xl->addHeader($arrHeader);
	
	$sql = "SELECT comTitle, ivlGroup, customer_group_title, Customer_name, Title, yact_group, Activity_title, prtGHQ, SUM(".$oBudget->getThisYTDSQL('fye').") as Amount
			FROM vw_master
			LEFT JOIN common_db.tbl_company ON comID=company
			WHERE scenario='{$_GET['budget_scenario']}'
			".Reports::GP_FILTER."
			GROUP BY company, ivlGroup, customer_group_code, customer, account, activity
			ORDER BY company, ivlGroup, customer_group_code, customer, account, activity";
			
			
	// die($sql);
	
	$rs = $oSQL->q($sql);
	while ($rw = $oSQL->f($rs)){
	
			$arrRow = Array();
			$arrRow[] = $rw['comTitle'];	
			$arrRow[] = $rw['ivlGroup'];					
			$arrRow[] = $rw['customer_group_title'];					
			$arrRow[] = $rw['Customer_name'];					
			$arrRow[] = $rw['Title'];					
			$arrRow[] = $rw['yact_group'];					
			$arrRow[] = $rw['Activity_title'];					
			$arrRow[] = $rw['prtGHQ'];								
			$arrRow[] = number_format($rw['Amount'],2,'.','');			
			$xl->addRow($arrRow);
	}
     
	$xl->Output("GP_".urlencode($oBudget->title)."_".date('Ymd'));
	die();	
}

if ($_GET['DataAction']=='excel_nop'){
	$oBudget = new Budget($_GET['budget_scenario']);
	
	$oSQL->q("Update reg_master, common_db.tbl_counterparty 
				set customer_group_code=IFNULL(cntGroupID, customer)
				where customer=cntID and scenario='{$oBudget->id}';";
	
	include_once ("../common/eiseList/inc_excelXML.php");
	$xl = new excelXML();            
	$arrHeader = Array('Company','Site','Customer','Industry','YACT','Account','Account Group','Activity','GHQ Product');
	for($m=4;$m<=15;$m++){
		$month = $oBudget->arrPeriodTitle[$m];
		$arrHeader[] = $month;
	}
	
	$arrHeader[] = 'Total';
	
	$xl->addHeader($arrHeader);
	
	$sql = "SELECT comTitle, Profit, ivlGroup, customer_group_title, Title, yact_group, account,  Activity_title, prtGHQ, ".$oBudget->getMonthlySumSQL().", SUM(".$oBudget->getThisYTDSQL('fye').") as Total
			FROM vw_master
			LEFT JOIN common_db.tbl_company ON comID=company
			WHERE scenario='{$_GET['budget_scenario']}'
				AND company='{$company}'
				".Reports::OP_FILTER."
				AND prtGHQ IN ('Warehouse','Land transport')
			GROUP BY company, pc, ivlGroup, customer_group_code, account, activity
			ORDER BY company, pc, ivlGroup, customer_group_code, account, activity";
			
			
	// die($sql);
	
	$rs = $oSQL->q($sql);
	while ($rw = $oSQL->f($rs)){
	
			$arrRow = Array();
			$arrRow[] = $rw['comTitle'];	
			$arrRow[] = $rw['Profit'];
			$arrRow[] = $rw['customer_group_title'];	
			$arrRow[] = $rw['ivlGroup'];			
			$arrRow[] = $rw['account'];					
			$arrRow[] = $rw['Title'];								
			$arrRow[] = $rw['yact_group'];					
			$arrRow[] = $rw['Activity_title'];					
			$arrRow[] = $rw['prtGHQ'];
			for($m=4;$m<=15;$m++){
				$month = $oBudget->arrPeriod[$m];
				$arrRow[] = number_format($rw[$month],0,'.','');
			}		
			$arrRow[] = number_format($rw['Total'],0,'.','');			
			$xl->addRow($arrRow);
	}
     
	$xl->Output("CL_NOP_".urlencode($oBudget->title)."_".date('Ymd'));
	die();	
}
		
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
	if(isset($_POST['DataAction'])){
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
		header('Content-type:application/json');
		echo json_encode(get_object_vars($oBudget));
		die();
	}
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
	<p>Deadline for completion <?php echo $oBudget->deadline;?></p>
	<pre>Checksum: <?php echo $oBudget->checksum; ?></pre>
	<pre>Current:  <?php echo $oBudget->get_checksum(); ?></pre>
	<div id='controlPanel' style="display:inline-block;">
	<table><tr>
	<td>
		<label for='scnLastID'>Default reference period</label>
		<?php echo $oBudget->getScenarioSelect(Array('budget_scenario'=>$oBudget->reference_scenario->id)); ?>
	</td>
	<td>
		<label for='scnForecastID'>Forecast period</label>
		<?php echo $oBudget->getScenarioSelect(Array('budget_scenario'=>$oBudget->forecast)); ?>
	</td>
	<td>
		<label for='scnForecastID'>Last year</label>
		<?php echo $oBudget->getScenarioSelect(Array('budget_scenario'=>$oBudget->lastyear)); ?>
	</td>
	<td>
	<label for="scnFlagReadOnly|<?php echo $oBudget->id;?>">Read-only</label><input type='checkbox' <?php echo $oBudget->flagUpdate?"":"checked";?> class='scnFlagReadOnly' id='scnFlagReadOnly|<?php echo $oBudget->id;?>'>
	<label for="scnFlagArchive|<?php echo $oBudget->id;?>">Archived</label><input type='checkbox' <?php echo $oBudget->flagArchive?"checked":"";?> class='scnFlagArchive' id='scnFlagArchive|<?php echo $oBudget->id;?>'>
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
	<span><button class='default' id='default|<?php echo $oBudget->id;?>'>Set as default</button></span>

	<?php
	}
	?>
	<span><button onclick="window.open('sp_get_kpi.php?budget_scenario=<?php echo $oBudget->id;?>','_blank');" id='kpis'>Get KPIs</button></span>
	<span><button onclick="window.open('rep_staff_costs.php?budget_scenario=<?php echo $oBudget->id;?>','_blank');" id='headcount'>Get headcount</button></span>
	</td>
	</tr></table>
	</div>
	<nav><strong>Compare to <?php echo $oBudget->reference_scenario->title;?>:</strong>
		<a href="rep_summary.php?<?php echo $strQuery;?>&budget_scenario=<?php echo $oBudget->id;?>&reference=<?php echo $oBudget->reference_scenario->id;?>">Summary</a>|
		<a href="rep_monthly.php?<?php echo $strQuery;?>&budget_scenario=<?php echo $oBudget->id;?>&reference=<?php echo $oBudget->reference_scenario->id;?>">Monthly report</a>|
		<a href="rep_pnl.php?<?php echo $strQuery;?>&budget_scenario=<?php echo $oBudget->id;?>&reference=<?php echo $oBudget->reference_scenario->id;?>">Full-year estimate</a>|
		<a href="rep_totals.php?<?php echo $strQuery;?>&budget_scenario=<?php echo $oBudget->id;?>&reference=<?php echo $oBudget->reference_scenario->id;?>">Results per BU</a>|
		<a href="rep_waterfall.php?<?php echo $strQuery;?>&budget_scenario=<?php echo $oBudget->id;?>&reference=<?php echo $oBudget->reference_scenario->id;?>">Waterfall</a>|
		<a href="rep_graphs.php?<?php echo $strQuery;?>&budget_scenario=<?php echo $oBudget->id;?>&reference=<?php echo $oBudget->reference_scenario->id;?>">Charts</a>|
		<a href="sp_ghq.php?<?php echo $strQuery;?>&budget_scenario=<?php echo $oBudget->id;?>&reference=<?php echo $oBudget->reference_scenario->id;?>">GHQ report</a>|
		<a href="rep_summary_ghq.php?<?php echo $strQuery;?>&budget_scenario=<?php echo $oBudget->id;?>&reference=<?php echo $oBudget->reference_scenario->id;?>">GHQ summary</a>|
		<a href="rep_sales_kpi.php?<?php echo $strQuery;?>&budget_scenario=<?php echo $oBudget->id;?>&reference=<?php echo $oBudget->reference_scenario->id;?>">Sales KPI</a>
		<a href="<?php echo $_SERVER['PHP_SELF'];?>?&budget_scenario=<?php echo $oBudget->id;?>&DataAction=excel_gp">GP Excel</a>
		<a href="<?php echo $_SERVER['PHP_SELF'];?>?&budget_scenario=<?php echo $oBudget->id;?>&DataAction=excel_nop">NOP Excel</a>
	</nav>
	<nav>
		<a href='sp_post_all.php#<?php echo $_GET['tab'];?>'>Post all</a>|
		<a href='sp_repost_hr.php#<?php echo $_GET['tab'];?>'>HR docs</a>|
		<a href='sp_repost_loc.php#<?php echo $_GET['tab'];?>'>Location costs</a>|
		<a href='sp_repost_hq.php#<?php echo $_GET['tab'];?>'>HQ costs</a>
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
		include ('includes/inc-frame_top.php');
		echo '<h1>',$arrUsrData["pagTitle$strLocal"],'</h1>';
		Budget::getScenarioTabs();
		include ('includes/inc-frame_bottom.php');
}

?>