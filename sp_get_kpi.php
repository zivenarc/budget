<?php
$flagNoAuth = true;
require ('common/auth.php');
require ('classes/budget.class.php');
require ('classes/reports.class.php');

include ('includes/inc_report_settings.php');
include ('includes/inc-frame_top.php');

$arrCSS[] = "../common/report.css";

$oBudget = new Budget($budget_scenario);

if (strpos($oBudget->type,'Budget')) die('Wrong budget type, cannot fill in the actuals');

$ytd = $oBudget->cm;
$year = $oBudget->year;

set_time_limit($ytd*60);

$arrKPI[] = Array('prtID'=>48,'filter'=>Array(48,72), 'ghq'=>'Ocean import','kpi'=>'SUM(jobTEU)', 'date'=>'IFNULL(jobATAPort,jobETAPort)', 'sqlWhere'=>" AND jobBLTypeID IN (10157,10159)",'output'=>true);
$arrKPI[] = Array('prtID'=>58,'filter'=>Array(58),'ghq'=>'Ocean import, non-DWE','kpi'=>'SUM(jobTEU)', 'date'=>'IFNULL(jobATAPort,jobETAPort)', 'sqlWhere'=>" AND jobBLTypeID IN (10157,10159)",'output'=>false );
$arrKPI[] = Array('prtID'=>63,'filter'=>Array(63,91),'ghq'=>'Ocean export','kpi'=>'SUM(jobTEU)', 'date'=>'jobShipmentDate','output'=>true);
$arrKPI[] = Array('prtID'=>52,'filter'=>Array(52),'ghq'=>'Ocean export, non-DWE','kpi'=>'SUM(jobTEU)', 'date'=>'jobShipmentDate','output'=>false);
$arrKPI[] = Array('prtID'=>46,'filter'=>Array(46,92),'ghq'=>'Air import','kpi'=>'SUM(jobGrossWeight)', 'date'=>'IFNULL(jobATAPort,jobETAPort)','output'=>true);
$arrKPI[] = Array('prtID'=>43,'filter'=>Array(46,92),'ghq'=>'Air import','kpi'=>'COUNT(DISTINCT jobID)', 'date'=>'IFNULL(jobATAPort,jobETAPort)','output'=>false);
$arrKPI[] = Array('prtID'=>47,'filter'=>Array(47,93),'ghq'=>'Air export','kpi'=>'SUM(jobGrossWeight)', 'date'=>'jobShipmentDate','output'=>true);
$arrKPI[] = Array('prtID'=>44,'filter'=>Array(47,93),'ghq'=>'Air export','kpi'=>'COUNT(DISTINCT jobID)', 'date'=>'jobShipmentDate','output'=>false);
$arrKPI[] = Array('prtID'=>7,'filter'=>Array(7),'ghq'=>'Distribution','kpi'=>'COUNT(DISTINCT jobID)', 'date'=>'jobShipmentDate');
$arrKPI[] = Array('prtID'=>6,'filter'=>Array(6),'ghq'=>'Delivery to plant','kpi'=>'COUNT(DISTINCT jobID)', 'date'=>'jobShipmentDate');
$arrKPI[] = Array('prtID'=>3,'filter'=>Array(3),'ghq'=>'Transportation','kpi'=>'COUNT(DISTINCT jobID)', 'date'=>'jobShipmentDate');
$arrKPI[] = Array('prtID'=>4,'filter'=>Array(4),'ghq'=>'Customs','kpi'=>'COUNT(DISTINCT jobID)', 'date'=>'jobShipmentDate');
$arrKPI[] = Array('prtID'=>13,'filter'=>Array(13),'ghq'=>'Int.trucking','kpi'=>'COUNT(DISTINCT jobID)', 'date'=>'jobShipmentDate');
$arrKPI[] = Array('prtID'=>2,'filter'=>Array(2),'ghq'=>'Port forwarding','kpi'=>'SUM((SELECT COUNT(jcnID) FROM nlogjc.tbl_job_container WHERE jcnJobID=jobID))', 'date'=>'IFNULL(jobATAPort,jobETAPort)','output'=>true);
$arrKPI[] = Array('prtID'=>50,'filter'=>Array(50),'ghq'=>'AFF c/c','kpi'=>'COUNT(DISTINCT jobID)', 'date'=>'jobShipmentDate');
$arrKPI[] = Array('prtID'=>69,'filter'=>Array(69),'ghq'=>'Rail','kpi'=>'COUNT(DISTINCT jobID)', 'date'=>'jobShipmentDate');
$arrKPI[] = Array('prtID'=>61,'filter'=>Array(61),'ghq'=>'Rail, OFF','kpi'=>'COUNT(DISTINCT jobID)', 'date'=>'jobETAPort');
$arrKPI[] = Array('prtID'=>53,'filter'=>Array(53),'ghq'=>'Door delivery','kpi'=>'SUM((SELECT COUNT(jcnID) FROM nlogjc.tbl_job_container WHERE jcnJobID=jobID))', 'date'=>'jobETAPort');
$arrKPI[] = Array('prtID'=>55,'filter'=>Array(55),'ghq'=>'Precarriage','kpi'=>'SUM((SELECT COUNT(jcnID) FROM nlogjc.tbl_job_container WHERE jcnJobID=jobID))', 'date'=>'jobShipmentDate');

$sql = Array();

$sql[] = "SET @scenario='{$oBudget->id}'";
$sql[] = "DELETE FROM `reg_sales` WHERE scenario=@scenario AND source='Actual';";
?>
<div class='tabs'>
<ul>
	<?php
		for ($i=0; $i<count($arrKPI);$i++){
			if($arrKPI[$i]['output']){
			?>
			<li><a href='#<?php echo $arrKPI[$i]['prtID'];?>'><?php echo $arrKPI[$i]['ghq'];?></a></li>
			<?php
			}
		}
	?>
	<li><a href='#other'>Other</a></li>
</ul>
<?php
for ($i=0; $i<count($arrKPI);$i++){

	if($arrKPI[$i]['output']){
		?>
		<div id='<?php echo $arrKPI[$i]['prtID'];?>'>
			<div class='tabs'>
				<ul>
					<?php
					for($m=1+$oBudget->offset;$m<=$ytd;$m++){
					?>
					<li><a href="#<?php echo $arrKPI[$i]['prtID'].'_'.$m;?>"><?php echo $oBudget->arrPeriod[$m];?></a></li>
					<?php
					}
					?>
				</ul>
		<?php
	}
	
	$sql[] = "SELECT  @prtID:=`prtID`, @jobGHQ:=`prtGHQ`, @unit:=`prtUnit` 
				FROM `vw_product_type` 
				WHERE `prtID`={$arrKPI[$i]['prtID']}";
	for($m=1+$oBudget->offset;$m<=$ytd;$m++){
	
		$repDateStart = date('Y-m-d',mktime(0,0,0,$m,1,$year));
		$repDateEnd = date('Y-m-d H:i:s',mktime(23,59,59,$m+1,0,$year));
		$month = $oBudget->arrPeriod[$m];

		$sql[] = "SET @dateStart:='{$repDateStart}', @dateEnd:='{$repDateEnd}'";
		$sql[] = "UPDATE budget.reg_sales SET `{$month}`=0 WHERE scenario=@scenario AND source<>'Actual';";
		$sql[] = "INSERT INTO budget.reg_sales (pc,activity,unit,customer,`{$month}`,source,scenario,active,posted,kpi,sales, bdv, bo, jo, pol, pod, gbr)
					SELECT jobProfitID, @prtID, @unit, cntID, {$arrKPI[$i]['kpi']} as '{$month}', 'Actual', @scenario, 1,1,1, cntUserID, usrProfitID, IFNULL(jobGDSBusinessOwnerID,714), jobGDSOwnerID, jobPOL, jobPOD,jobFlagSAP
					FROM nlogjc.tbl_job
					JOIN common_db.tbl_counterparty ON cntID=jobCustomerID
					JOIN common_db.stbl_user ON usrID=cntUserID
					WHERE {$arrKPI[$i]['date']} BETWEEN @dateStart AND @dateEnd
						AND jobStatusID BETWEEN 15 AND 40
						AND jobProfitID IS NOT NULL
						{$arrKPI[$i]['sqlWhere']}
						AND (SELECT COUNT(jitGUID) 
									FROM nlogjc.tbl_job_item 
									LEFT JOIN common_db.tbl_product ON prdID=jitProductID 
									WHERE jitJobID=jobID 
										AND prdCategoryID IN (".implode(',',$arrKPI[$i]['filter']).")
									)>0				
					GROUP BY jobCustomerID, jobProfitID, jobPOL, jobPOD,jobFlagSAP, IFNULL(jobGDSBusinessOwnerID,714), jobGDSOwnerID
					HAVING `{$month}` IS NOT NULL";
					// HAVING  {$arrKPI[$i]['kpi']} IS NOT NULL";
		
		
		if($arrKPI[$i]['output']){
				$sqlDetails = "SELECT jobID, cntTitle, {$arrKPI[$i]['kpi']} as 'TEU', jobShipmentDate, jobETAPort, jobATAPort, jobPOL, jobPOD, jobFlagSAP, pccTitle
					FROM nlogjc.tbl_job
					JOIN common_db.tbl_counterparty ON cntID=jobCustomerID
					JOIN common_db.tbl_profit ON pccID=jobProfitID
					WHERE {$arrKPI[$i]['date']} BETWEEN '{$repDateStart}' AND '{$repDateEnd}'
						AND jobStatusID BETWEEN 15 AND 40
						AND (SELECT COUNT(jitGUID) 
									FROM nlogjc.tbl_job_item 
									LEFT JOIN common_db.tbl_product ON prdID=jitProductID 
									WHERE jitJobID=jobID AND prdCategoryID='{$arrKPI[$i]['prtID']}'
									)>0				
					GROUP BY jobID
					ORDER BY jobID, jobCustomerID";
				$rsDetails = $oSQL->q($sqlDetails);
				$nSumKPI = 0; $j=1;
				$tableID = "details_".$arrKPI[$i]['prtID']."_".$month;
				?>
				<div id="<?php echo $arrKPI[$i]['prtID'].'_'.$m;?>">
				<table class="budget" id="<?php echo $tableID;?>">
					<thead>
						<caption><?php echo $arrKPI[$i]['ghq'],' from ',$repDateStart,' to ',$repDateEnd;?></caption>
						<tr>
							<th>#</th>
							<th>Job</th>
							<th>SAP</th>
							<th>Customer</th>
							<th>TEU</th>
							<th>From</th>
							<th>To</th>
							<th>BU</th>
							<th>ATD</th>
							<th>ETA</th>
							<th>ATA</th>
						</tr>
					</thead>
					<tbody>
				<?php
				while ($rw = $oSQL->f($rsDetails)){
					?>
					<tr>
						<td><?php echo $j;?></td>
						<td><a target='job' href="/nlogjc/job_form.php?jobID=<?php echo $rw['jobID'];?>"><?php echo $rw['jobID'];?></a></td>
						<td><?php echo $rw['jobFlagSAP']?"&bull;":"";?></td>
						<td><?php echo $rw['cntTitle'];?></td>
						<td><?php echo $rw['TEU'];?></td>
						<td><?php echo $rw['jobPOL'];?></td>
						<td><?php echo $rw['jobPOD'];?></td>
						<td><?php echo $rw['pccTitle'];?></td>
						<td><?php echo $rw['jobShipmentDate'];?></td>
						<td><?php echo $rw['jobETAPort'];?></td>
						<td><?php echo $rw['jobATAPort'];?></td>
					</tr>
					<?php
					$j++;
					$nSumKPI += $rw['TEU'];
				}
				?>
				</tbody>
				<tfoot>
				<tr class="budget-subtotal">
					<td colspan="4">Total:</td>
					<td><?php echo number_format($nSumKPI,0,'.',',');?></td>
				</tr>
				</tfoot>
				</table>
				</div>
				<?php
		};
	};
	if($arrKPI[$i]['output']){
		?>
			</div>
		</div>
		<?php
	}
};
?>
<div id='other'>
<?php
//-------------- Intercompany -----------------
$arrKPI = Array();
$arrKPI[] = Array('prtID'=>3,'ghq'=>'Transport','kpi'=>'COUNT(DISTINCT jobID)', 'date'=>'jobShipmentDate');
$arrKPI[] = Array('prtID'=>6,'ghq'=>'Delivery to plant','kpi'=>'COUNT(DISTINCT jobID)', 'date'=>'jobShipmentDate');
$arrKPI[] = Array('prtID'=>11,'ghq'=>'Shunting','kpi'=>'COUNT(DISTINCT jobID)', 'date'=>'jobShipmentDate');

for ($i=0; $i<count($arrKPI);$i++){

	echo '<pre>',$arrKPI[$i]['ghq'],'</pre>';
	
	$sql[] = "SELECT  @prtID:=prtID, @jobGHQ:=prtGHQ, @unit:=prtUnit 
				FROM vw_product_type WHERE prtID={$arrKPI[$i]['prtID']};";
	for($m=1+$oBudget->offset;$m<=$ytd;$m++){
	$repDateStart = date('Y-m-d',mktime(0,0,0,$m,1,$year));
	$repDateEnd = date('Y-m-d H:i:s',mktime(23,59,59,$m+1,0,$year));
	$month = $oBudget->arrPeriod[$m];
	$sql[] = "SET @dateStart:='{$repDateStart}', @dateEnd:='{$repDateEnd}'";
	$sql[] = "INSERT INTO reg_sales (pc,activity,unit,customer,`{$month}`,source,scenario,active,posted,kpi,sales, bdv)
				SELECT jobOwnerProfitID, @prtID, @unit, cntID, {$arrKPI[$i]['kpi']} as '{$month}', 'Actual', @scenario, 1,1,1,cntUserID, usrProfitID
				FROM intercompany.tbl_job
				JOIN common_db.tbl_counterparty ON cntID=jobCustomerID
				JOIN common_db.stbl_user ON usrID=cntUserID
				WHERE {$arrKPI[$i]['date']} BETWEEN @dateStart AND @dateEnd
					AND jobStatusID BETWEEN 15 AND 40
					AND (SELECT COUNT(jitGUID) 
								FROM intercompany.tbl_job_item 
								LEFT JOIN common_db.tbl_product ON prdID=jitProductID 
								WHERE jitJobID=jobID AND prdCategoryID=@prtID
								)>0				
				GROUP BY jobCustomerID, jobProfitID
				HAVING  {$arrKPI[$i]['kpi']} IS NOT NULL";
	};
};

////////// Special arrangement for TOYOTA
$sql[] = "SELECT @cntUserID:=cntUserID, @usrProfitID:=usrProfitID
			FROM common_db.tbl_counterparty 
			JOIN common_db.stbl_user ON usrID=cntUserID
			WHERE cntID=17218;";
for($m=1+$oBudget->offset;$m<=$ytd;$m++){
	$repDateStart = date('Y-m-d',mktime(0,0,0,$m,1,$year));
	$repDateEnd = date('Y-m-d H:i:s',mktime(23,59,59,$m+1,0,$year));
	$month = $oBudget->arrPeriod[$m];
	$sql[] = "INSERT INTO reg_sales (pc,activity,unit,customer,`{$month}`,source,scenario,active,posted,kpi,sales, bdv)
			SELECT 3, 4, 'CCD', 17218, COUNT(shpID) as '{$month}', 'Actual', @scenario, 1,1,1,@cntUserID, @usrProfitID
			FROM tnt.tbl_shipment WHERE shpCCendDate BETWEEN @dateStart AND @dateEnd";	
	$sql[] = "INSERT INTO reg_sales (pc,activity,unit,customer,`{$month}`,source,scenario,active,posted,kpi,sales, bdv)
			SELECT 3, 3, 'Trips', 17218, COUNT(shpID) as '{$month}', 'Actual', @scenario, 1,1,1,@cntUserID, @usrProfitID
			FROM tnt.tbl_shipment WHERE shpTransitFromPort BETWEEN @dateStart AND @dateEnd";
	$sql[] = "INSERT INTO reg_sales (pc,activity,unit,customer,`{$month}`,source,scenario,active,posted,kpi,sales, bdv)
			SELECT 3, 50, 'CCD', 17218, COUNT(ashID) as '{$month}', 'Actual', @scenario, 1,1,1,@cntUserID, @usrProfitID
			FROM tnt.tbl_air_shipment WHERE ashCCDate BETWEEN @dateStart AND @dateEnd";
};

$sql[] = "INSERT IGNORE INTO ref_route
			SELECT LEFT(pol,2),LEFT(pod,2),0 
			FROM reg_sales
			WHERE IFNULL(pol,'')<>'' AND IFNULL(pod,'')<>''
			GROUP by pol, pod";

$sql[] = "UPDATE reg_sales, ref_route SET reg_sales.route=ref_route.route WHERE LEFT(pol,2)=pol_country AND LEFT(pod,2)=pod_country AND scenario=@scenario";
$sql[] = "UPDATE reg_sales SET freehand=1 WHERE bo=714 AND activity IN (46,47,48,63,52,58) AND scenario=@scenario";
// $sql[] = "UPDATE reg_sales SET freehand=1 WHERE bo=714 and jo=714 AND activity=63 AND scenario=@scenario";
$sql[] = "update reg_sales set customer_group_code=common_db.fn_parentl2(customer) where customer is not null and scenario=@scenario";

for ($i=0;$i<count($sql);$i++){	
	if (!$oSQL->q($sql[$i]) || $_GET['debug']){
		echo '<h2>Error:</h2>';
		echo '<pre>',$sql[$i],'</pre>';
	}
}
?>
</div>
</div>
<?php
include ('includes/inc-frame_bottom.php');
?>