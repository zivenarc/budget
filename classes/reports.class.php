<?php
require_once ('budget.class.php');

class Reports{
	
	private $ID;
	public $oBudget;
	public $Currency;
	public $Denominator;
	private $oSQL;
	
	private $company;
	
	const GP_CODE = 94;
	const CNT_GROUP_EXEMPTION = 723;
	const OP_FILTER = "AND (account NOT LIKE '6%' AND account NOT LIKE '7%' AND account NOT LIKE 'SZ%') AND pccFlagProd=1 ";	
	const SC_FILTER = "AND group_code=95";
	const REVENUE_FILTER = "AND account IN ('J00400','J40010') ";
	const DIRECT_COST_FILTER = "AND account IN ('J00802','J45010') ";
	const GP_FILTER = "AND account IN ('J00400', 'J00802','J45010','J40010') ";
	const GOP_FILTER = "AND account LIKE 'J%' ";
	const RFC_FILTER = "AND (account LIKE 'J%' AND account NOT IN ('J00400', 'J00802','J45010','J40010'))\r\n";
	const SGA_FILTER = "AND (account LIKE '5%' AND account NOT IN ('5999CO','5999BD','527000')) AND (pccFLagProd = 1 OR pc IN (9,130))\r\n";
	const CORP_FILTER = "AND account IN ('5999CO')";
	const MSF_FILTER = "AND account IN ('527000')";
	const REVENUE_ITEM = 'cdce3c68-c8da-4655-879e-cd8ec5d98d95';
	const PROFIT_SHARE_ITEM = 'fd09fb23-efd0-11e3-926a-00155d010e0b';
	const SALARY_THRESHOLD = 10000;
	const ACTUAL_DATA_FILTER = "`source` IN ('Actual','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec','Correction')\r\n";
	const GROSS_REVENUE_ITEMS = Array('cdce3c68-c8da-4655-879e-cd8ec5d98d95','17ae174f-48e3-11e1-b30e-005056930d2f','dea4c740-5201-11e8-a94c-000d3ab6a5d8','f5a44e49-5201-11e8-a94c-000d3ab6a5d8');
	const GROSS_REVENUE_FILTER = " AND `item` IN ('cdce3c68-c8da-4655-879e-cd8ec5d98d95','17ae174f-48e3-11e1-b30e-005056930d2f','dea4c740-5201-11e8-a94c-000d3ab6a5d8','f5a44e49-5201-11e8-a94c-000d3ab6a5d8')\r\n";
	const OWN_OPERATING_PROFIT = " AND (account NOT LIKE '6%' AND account NOT LIKE '7%' AND account NOT LIKE 'SZ%' AND account NOT LIKE '5999%' AND pccFlagProd=1)\r\n";
	
	function __construct($params){
		
		GLOBAL $oSQL;
		GLOBAL $company;
		
		$this->oSQL = $oSQL;
		
		$this->oBudget = new Budget($params['budget_scenario']);
		$this->oReference = $params['reference']?new Budget($params['reference']):$this->oBudget->reference_scenario;
		$this->company = $company;
		
		$this->Currency = $params['currency']?$params['currency']:643;
		
		if($this->Currency=='rhq'){
			$this->CurrencyTitle = 'RHQ EUR rate';
		} else {
			$sql = "SELECT curTitle FROM common_db.tbl_currency WHERE curID={$this->Currency}";
			$rs = $this->oSQL->q($sql);
			$this->CurrencyTitle = $this->oSQL->get_data($rs);
		}
		
		$this->Denominator = $params['denominator']?$params['denominator']:1;
		$this->ID = md5(time());
		
		$this->YACT = $params['yact']?true:false;
		// echo '<pre>';print_r($this);echo '</pre>';
		$this->filter = $params['filter'];
		$this->_setWhere();
		
		$this->caption = $this->oBudget->title.' vs '.$this->oReference->title.', '.$this->CurrencyTitle.($this->Denominator!=1?'x'.$this->Denominator:'');
	}
	
	private function _setWhere(){
		
		$this->sqlWhere = "";
		
		if(is_array($this->filter)){
			foreach($this->filter as $key=>$value){
				if (strpos($key,'no_')!==false){
					$key = str_replace("no_","",$key);
										if (is_array($value)){
						$arrWhere[] = $key." NOT IN ('".implode("','",$value)."')";
					} else {
						$arrWhere[] = $key." <> '{$value}'";
					}
				} else {
					if (is_array($value)){
						$arrWhere[] = $key." IN ('".implode("','",$value)."')";
					} else {
						if ($value==''){
							$arrWhere[] = "IFNULL({$key},'')=''";
						} else {
							$arrWhere[] = $key." = '{$value}'";
						}
					}
				}
			}
			$this->sqlWhere = "WHERE ".implode (" AND ",$arrWhere)." AND `company`='{$this->company}'";		
		} else {
			$this->sqlWhere = "WHERE `company`='{$this->company}' ";
		}
		
		return($this->sqlWhere);
	}
	
	public function employees($filter){
		$this->filter = is_array($this->filter)?array_merge($this->filter,$filter):$filter;
		$this->_setWhere();
		$sql = "SELECT scenario, account, Title, particulars, empTitleLocal, empSalary, empMonthly, ".$this->oBudget->getMonthlySumSQL($this->oBudget->nm,12+$this->oBudget->offset)." 
				FROM `vw_master`
				LEFT JOIN common_db.tbl_employee ON particulars=empGUID1C
				{$this->sqlWhere}  AND item='453d8da7-963b-4c4f-85ca-99e26d9fc7a2' AND scenario='{$this->oBudget->id}' 
				GROUP BY particulars,account
					UNION ALL
				SELECT scenario, account, Title, particulars,empTitleLocal, empSalary, empMonthly , ".$this->oBudget->getMonthlySumSQL($this->oBudget->nm,12+$this->oBudget->offset)." 
				FROM `vw_master`
				LEFT JOIN common_db.tbl_employee ON particulars=empGUID1C 
				{$this->sqlWhere}  AND item='453d8da7-963b-4c4f-85ca-99e26d9fc7a2' AND scenario='{$this->oReference->id}' 
				GROUP BY particulars,account
				ORDER BY empSalary DESC, particulars, scenario";
		$rs = $this->oSQL->q($sql);
		
		while ($rw=$this->oSQL->f($rs)){
			$section = $rw['account']."::".$rw['Title'];
			$arrReport[$section][$rw['particulars']]['title']=$rw['empTitleLocal'];
			$arrReport[$section][$rw['particulars']]['salary']=$rw['empSalary'];
			$arrReport[$section][$rw['particulars']]['bonus']=$rw['empMonthly'];
			if (!is_array($arrReport[$section][$rw['particulars']]['data'])) $arrReport[$section][$rw['particulars']]['data'] = Array('actual'=>Array(),'budget'=>Array());
			if ($rw['scenario']==$this->oBudget->id){
				for ($m=$this->oBudget->nm;$m<=12+$this->oBudget->offset;$m++){
					$month = $this->oBudget->arrPeriod[$m];
					$arrReport[$section][$rw['particulars']]['data']['actual'][$month] += $rw[$month];
					$arrSubtotal[$section]['actual'][$month] += $rw[$month];
				}
							
			}
			if ($rw['scenario']==$this->oReference->id){
				for ($m=$this->oBudget->nm;$m<=12+$this->oBudget->offset;$m++){
					$month = $this->oBudget->arrPeriod[$m];
					$arrReport[$section][$rw['particulars']]['data']['budget'][$month] += $rw[$month];
					$arrSubtotal[$section]['budget'][$month] += $rw[$month];
				}
			}

					
		}

		$arrVacation = Array();	
		for($m=$this->oBudget->nm;$m<=12+$this->oBudget->offset;$m++){ 
			$month = $this->oBudget->arrPeriod[$m];
			
			$current_month_start = mktime(0,0,0,$m,1,$this->oBudget->year);
			$current_month_end = mktime(23,59,59,$m+1,0,$this->oBudget->year);
			
			$sqlV = Array();
			$sqlV[]="SET @dateStart:='".date('Y-m-d',$current_month_start)."',@dateEnd:='".date('Y-m-d',$current_month_end)."', @daysMonth = nlogjc.fn_daycount(@dateStart, @dateEnd, 'workdays');";
			$sqlV[] = "SELECT empGUID1C, vacEmployeeID, empTitle, vacDateStart, vacDateEnd, IF(vacDateStart<@dateStart,@dateStart, vacDateStart),IF(vacDateEnd>@dateEnd,@dateEnd, vacDateEnd), 
				nlogjc.fn_daycount(IF(vacDateStart<@dateStart,@dateStart, vacDateStart),IF(vacDateEnd>@dateEnd,@dateEnd, vacDateEnd),'workdays') as Duration,@daysMonth as daysMonth
			FROM treasury.tbl_vacation
			JOIN common_db.tbl_employee ON empID=vacEmployeeID
			WHERE ((vacDateStart BETWEEN @dateStart AND @dateEnd) OR (vacDateEnd BETWEEN @dateStart AND @dateEnd))
			AND vacStateID BETWEEN 410 AND 450
			AND empProfitID={$this->filter['pc']}";
			
			for($i=0;$i<count($sqlV);$i++){
				$rs = $this->oSQL->q($sqlV[$i]);
			};
			while ($rw = $this->oSQL->f($rs)){
				$arrVacation[$rw['empGUID1C']][$month] = $rw['Duration'];
			}
		}
		// echo '<pre>';print_r($sqlV);echo '</pre>';
		foreach($arrReport as $section=>$arrTable){
			$tableID = "kpi_".md5($sql.$section);
			$arrPayroll = Array();
			?>
			<table id='<?php echo $tableID;?>' class='budget'>
				<caption><?php echo $section;?></caption>
				<thead>
					<tr>
						<th>Employee</th>
						<th>Salary</th>
						<th>M.Bonus</th>
						<th>Scenario</th>
						<?php 
						echo $this->oBudget->getTableHeader('monhtly',$this->oBudget->nm, 12+$this->oBudget->offset); 
						?>
						<th class='budget-ytd'>Total</th>
					</tr>
				</thead>			
				<tbody>
			<?php
			foreach ($arrTable as $employee=>$details){
				$arrPayroll['salary'] += $details['salary'];
				$arrPayroll['bonus'] += $details['bonus'];
				?>
				<tr>
					<td rowspan="3"><?php echo $details['title'];?></td>
					<td rowspan="3" class='budget-decimal'><?php self::render($details['salary'])?></td>
					<td rowspan="3" class='budget-decimal'><?php self::render($details['bonus']);?></td>
					<td>Actual</td>
					<?php
					for ($m=$this->oBudget->nm;$m<=12+$this->oBudget->offset;$m++){
						// $month = $this->oBudget->arrPeriod[$m];
						$month = $this->oBudget->arrPeriod[$m];
						if($arrVacation[$employee][$month]){
							$title  = "Vacation, ".$arrVacation[$employee][$month].' working days';
						} else {
							$title = '';
						}
						echo "<td title='{$title}' class='budget-decimal budget-monthly budget-$month'>",self::render($details['data']['actual'][$month]),'</td>';
					}
					?>
					<td class='budget-ytd budget-decimal '><?php self::render(array_sum($details['data']['actual']));?></td>
				</tr>
				<tr>
					<td>Budget</td>
					<?php
					for ($m=$this->oBudget->nm;$m<=12+$this->oBudget->offset;$m++){
						// $month = $this->oBudget->arrPeriod[$m];
						$month = $this->oBudget->arrPeriod[$m];
						echo "<td class='budget-decimal budget-monthly budget-$month'>",self::render($details['data']['budget'][$month]),'</td>';
					}
					?>
					<td class='budget-ytd budget-decimal'><?php self::render(array_sum($details['data']['budget']));?></td>
				</tr>
				<tr class='budget-subtotal'>
					<td>Diff</td>
					<?php
					for ($m=$this->oBudget->nm;$m<=12+$this->oBudget->offset;$m++){
						// $month = $this->oBudget->arrPeriod[$m];
						$month = $this->oBudget->arrPeriod[$m];
						echo "<td class='budget-decimal budget-monthly budget-$month'>",self::render($details['data']['actual'][$month]-$details['data']['budget'][$month]),'</td>';
					}
					?>
					<td class='budget-ytd budget-decimal'><?php self::render(array_sum($details['data']['actual'])-array_sum($details['data']['budget']));?></td>
				</tr>
				<?php
			}
			?>
			<tr class="budget-total">
					<td rowspan="3">Total</td>
					<td rowspan="3" class='budget-decimal'><?php self::render($arrPayroll['salary'])?></td>
					<td rowspan="3" class='budget-decimal'><?php self::render($arrPayroll['bonus']);?></td>
					<td>Actual</td>
					<?php
					for ($m=$this->oBudget->nm;$m<=12+$this->oBudget->offset;$m++){
						// $month = $this->oBudget->arrPeriod[$m];
						$month = $this->oBudget->arrPeriod[$m];
						echo "<td title='{$title}' class='budget-decimal budget-monthly budget-$month'>",self::render($arrSubtotal[$section]['actual'][$month]),'</td>';
					}
					?>
					<td class='budget-ytd budget-decimal '><?php self::render(array_sum($details['data']['actual']));?></td>
				</tr>
				<tr>
					<td>Budget</td>
					<?php
					for ($m=$this->oBudget->nm;$m<=12+$this->oBudget->offset;$m++){
						// $month = $this->oBudget->arrPeriod[$m];
						$month = $this->oBudget->arrPeriod[$m];
						echo "<td class='budget-decimal budget-monthly budget-$month'>",self::render($arrSubtotal[$section]['budget'][$month]),'</td>';
					}
					?>
					<td class='budget-ytd budget-decimal'><?php self::render(array_sum($details['data']['budget']));?></td>
				</tr>
				<tr class='budget-subtotal'>
					<td>Diff</td>
					<?php
					for ($m=$this->oBudget->nm;$m<=12+$this->oBudget->offset;$m++){
						// $month = $this->oBudget->arrPeriod[$m];
						$month = $this->oBudget->arrPeriod[$m];
						echo "<td class='budget-decimal budget-monthly budget-$month'>",self::render($arrSubtotal[$section]['actual'][$month]-$arrSubtotal[$section]['budget'][$month]),'</td>';
					}
					?>
					<td class='budget-ytd budget-decimal'><?php self::render(array_sum($arrSubtotal[$section]['actual'])-array_sum($arrSubtotal[$section]['budget']));?></td>
				</tr>
			<?php
		}
		?>
		</tbody>
		<tfoot>
		
		</tfoot>
		</table>
		<?php
		$this->_echoButtonCopyTable($tableID);
	}
	
	public function salesByActivity(){
		GLOBAL $oSQL;
		ob_start();
			
			switch ($this->oBudget->type){
				case 'Budget':
				case 'Budget_AM':
					$sql = "SELECT prtGHQ, prtRHQ, pc, prtID, prtTitle as 'Activity', prtUnit as 'Unit', ".$this->oBudget->getMonthlySumSQL(1,15).", 
								SUM(".$this->oBudget->getYTDSQL(1+$this->oBudget->offset,12+$this->oBudget->offset).") as Total, 
								SUM(".$this->oBudget->getYTDSQL(4,15).") as Total_AM 
							FROM `reg_sales`					
							LEFT JOIN vw_product_type ON prtID=activity
							{$this->sqlWhere} AND posted=1 AND kpi=1 AND scenario='{$this->oBudget->id}' 
							GROUP BY `reg_sales`.`activity`, `reg_sales`.`unit`
							ORDER BY prtGHQ, prtRHQ";
					break;
				default:	
					$mthStart = (integer)date('n',$this->oBudget->date_start);					
					
					$sql = "SELECT prtGHQ, prtRHQ, pc, prtID, prtTitle as 'Activity', prtUnit as 'Unit',
							".$this->oBudget->getMonthlySumSQL(1,15).",
							SUM(".$this->oBudget->getYTDSQL(1+$this->oBudget->offset,12+$this->oBudget->offset).") as Total, 
							SUM(".$this->oBudget->getYTDSQL(4,15).") as Total_AM
						FROM 
							(SELECT pc, activity, unit,
									".$this->oBudget->getMonthlySumSQL(1,15)."
							FROM `reg_sales` 			
							{$this->sqlWhere} AND scenario='{$this->oBudget->id}' AND kpi=1 and ".self::ACTUAL_DATA_FILTER."
							GROUP BY activity, unit
							UNION ALL
							SELECT pc, activity, unit,
									".str_repeat("0, ",$mthStart-1).$this->oBudget->getMonthlySumSQL($mthStart,15)."
							FROM `reg_sales` 			
							{$this->sqlWhere} AND scenario='{$this->oBudget->id}' AND kpi=1 AND posted=1 and source<>'Actual' 
							GROUP BY activity, unit) U
					LEFT JOIN vw_product_type ON prtID=activity
					GROUP BY U.activity, unit
					ORDER BY prtGHQ, activity ASC";		
					break;
			}		
			$rs = $oSQL->q($sql);
			if (!$oSQL->num_rows($rs)){
				echo "<div class='warning'>No sales KPI found</div>";
				return (false);
			}
			$tableID = "kpi_".md5($sql);
			?>
			<table id='<?php echo $tableID;?>' class='budget'>
			<thead>
				<tr>
					<th>Activity</th><th>Unit</th>
					<?php 
					echo $this->oBudget->getTableHeader('monhtly',1+$this->oBudget->offset, 12+$this->oBudget->offset); 
					echo $this->oBudget->getTableHeader('quarterly'); 
					?>
					<th class='budget-ytd'>Total</th>
					<!--<th class='budget-monthly'>Jan+</th>
					<th class='budget-monthly'>Feb+</th>
					<th class='budget-monthly'>Mar+</th>
					<th>Q5</th>
					<th class='budget-ytd'>Apr-Mar</th>-->
				</tr>
			</thead>			
			<tbody>
			<?php
			$prtGHQ = '';
			while ($rw=$oSQL->f($rs)){
				if ($rw['Unit']=='TEU') {
					$flagShowOFFReport = true;
				}
				
				if ($rw['Unit']=='Kgs') {
					$flagShowAFFReport = true;
				}
				
				if ($rw['prtID']==12 || $rw['prtID']==9){
					$flagShowWHReport = true;
				}
				?>
				<tr class='graph'>
				<?php
				if ($rw['prtGHQ']!=$prtGHQ){
					?>
					<tr><th colspan="20"><?php echo $rw['prtGHQ'];?></th></tr>
					<?php
				};
				$arrMetadata = Array('filter' => $this->filter, 'DataAction' => 'kpiByCustomer', 'title'=>$rw['prtTitle']);
				$arrMetadata['filter']['activity'] = $rw['prtID'];
				
				echo "<td><a href='javascript:getCustomerKPI(".json_encode($arrMetadata).");'>",$rw['Activity'],'</a></td>';
				echo '<td class="unit">',$rw['Unit'],'</td>';
				for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
					// $month = $this->oBudget->arrPeriod[$m];
					$month = $this->oBudget->arrPeriod[$m];
					echo "<td class='budget-decimal budget-monthly budget-$month ".($m==$this->oBudget->cm?'budget-current':'')."'>",self::render($rw[$month]),'</td>';
				}
				$arrQuarter = $this->_getQuarterTotals($rw);
				
				for ($q=1+$this->oBudget->offset/3;$q<=4+$this->oBudget->offset/3;$q++){		
					$quarter = 'Q'.$q;
					echo "<td class='budget-decimal budget-quarterly budget-$quarter'>",number_format($arrQuarter[$quarter],0,'.',','),'</td>';
				}				
									
				echo '<td class=\'budget-decimal budget-ytd\'>',number_format($rw['Total'],0,'.',','),'</td>';
				// for ($m=13;$m<=15;$m++){					
					// $month = $this->oBudget->arrPeriod[$m];
					// echo "<td class='budget-decimal budget-monthly budget-$month'>",self::render($rw[$month]),'</td>';
				// }
				// echo '<td class=\'budget-decimal budget-Q5\'>',number_format($arrQuarter['Q5'],0,'.',','),'</td>';
				// echo '<td class=\'budget-decimal budget-ytd\'>',number_format($rw['Total_AM'],0,'.',','),'</td>';
				echo "</tr>\r\n";
				$prtGHQ = $rw['prtGHQ'];
			}
			?>
			</tbody>
			</table>			
			<?php
			$this->_echoButtonCopyTable($tableID);
			
			if ($flagShowOFFReport) {
				$this->iffByRoute('OFF');
			}
			
			if ($flagShowAFFReport) {
				$this->iffByRoute('AFF');
			}
			
			if ($flagShowWHReport) {
				$this->whByCustomer();
			}
			
			ob_flush();
	}
	
	function iffByRoute($type='OFF'){
		
		
		$this->oSQL->q("UPDATE reg_sales, tbl_sales SET bo=IFNULL(salBO,0),jo=salJO, posted=salFlagPosted WHERE source=salGUID");
		$this->oSQL->q("UPDATE reg_sales SET freehand = IF( bo =714, 1, 0 )");
		
		switch ($type){
			case 'OFF':
				$activity_filter = Array(48,63,52,58);
				break;
			case 'AFF':
				$activity_filter = Array(46,47) ;
				break;
		}
		
		switch($this->oBudget->type){
			case 'Budget':
			case 'Budget_AM':
				$sqlFrom = "SELECT activity, route, source, ".$this->oBudget->getMonthlySumSQL(1,15).", freehand
							FROM `reg_sales` 							
							{$this->sqlWhere} AND scenario='{$this->oBudget->id}' 
							AND kpi=1 AND posted=1
							AND activity IN (".implode(',',$activity_filter).")
							AND `company`='{$this->company}'
							GROUP BY activity, route, unit, freehand
							";
				break;
			default:
				$sqlFrom = "SELECT activity, route,  source, ".$this->oBudget->getMonthlySumSQL(1,15).", freehand
							FROM `reg_sales` 							
							{$this->sqlWhere} AND scenario='{$this->oBudget->id}' AND kpi=1 and ".self::ACTUAL_DATA_FILTER."
							AND activity IN (".implode(',',$activity_filter).")
							AND `company`='{$this->company}'
							GROUP BY activity, route, unit, source, freehand
							UNION ALL
						SELECT activity, route, source, ".str_repeat("0, ",$this->oBudget->cm).$this->oBudget->getMonthlySumSQL($this->oBudget->cm+1,15).", freehand
						FROM `reg_sales` 										
						{$this->sqlWhere} AND scenario='{$this->oBudget->id}' AND kpi=1 AND posted=1 and source<>'Actual'
						AND activity IN (".implode(',',$activity_filter).")
						AND `company`='{$this->company}'
					GROUP BY activity, route, unit, freehand";
				break;
		}
		
		$sql = "SELECT activity, route, rteTitle, prtGHQ, prtTitle, ".$this->oBudget->getMonthlySumSQL(1,15).", 
				SUM(".$this->oBudget->getYTDSQL(1+$this->oBudget->offset,12+$this->oBudget->offset).") as Total, freehand
				FROM 
					({$sqlFrom}) U 		
				LEFT JOIN vw_product_type ON prtID=activity
				LEFT JOIN tbl_route ON rteID=route
				GROUP BY prtGHQ, U.route, freehand
				ORDER BY prtGHQ";
		try {
			$rs = $this->oSQL->q($sql); 
		} catch (Exception $e) {
			echo '<pre>Caught exception: ',  $e->getMessage(), "</pre>";
			echo '<pre>',$sql,'</pre>';
			echo '<pre>',print_r($this->oBudget),'</pre>';
		};
		
		$tableID = "kpi_".md5($sql);
			?>
			<h2>Business owner volume <?php echo $type; ?></h2>
			<table id='<?php echo $tableID;?>' class='budget'>
			<thead>
				<tr>
					<th>Activity/route</th>
					<?php 
					echo $this->oBudget->getTableHeader('monhtly',1+$this->oBudget->offset, 12+$this->oBudget->offset); 
					echo $this->oBudget->getTableHeader('quarterly'); 
					?>
					<th class='budget-ytd'>Total</th>
				</tr>
			</thead>			
			<tbody>
			<?php			
			$arrSubtotal = Array();
			while ($rw=$this->oSQL->f($rs)){				
				if($rw['freehand']){
				?>
				<tr class='graph'>
				<?php
				}
				if ($rw['prtGHQ']!=$prtGHQ){
					?>
					<tr><th colspan="20"><?php echo $rw['prtGHQ'];?></th></tr>
					<?php
				};
				if($rw['freehand']) {
					?>
					<td><a href="javascript:getCustomerKPI({prtGHQ:'<?php echo $rw['prtGHQ'];?>',route:<?php echo $rw['route'];?> ,freehand:true});"><?php echo $rw['rteTitle'];?></a></td>								
					<?php
				}
				for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
					// $month = $this->oBudget->arrPeriod[$m];
					$month = $this->oBudget->arrPeriod[$m];
					if($rw['freehand']) { 
						echo "<td class='budget-decimal budget-monthly budget-$month ".($m==$this->oBudget->cm?'budget-current':'')."'>",self::render($rw[$month]),'</td>';
					}
					$arrTotal[$rw['freehand']][$month]+=$rw[$month];
					$arrSubtotal[$rw['prtGHQ']][$rw['freehand']][$month]+=$rw[$month];
					$arrSubtotalAll[$rw['prtGHQ']][$month]+=$rw[$month];
				};
				$arrTotal[$rw['freehand']]['Total']+=$rw['Total'];				
				$arrSubtotal[$rw['prtGHQ']][$rw['freehand']]['Total']+=$rw['Total'];				
				$arrSubtotalAll[$rw['prtGHQ']]['Total']+=$rw['Total'];				
				
				$arrQuarter = $this->_getQuarterTotals($rw);
				
				for ($q=1+$this->oBudget->offset/3;$q<=4+$this->oBudget->offset/3;$q++){		
					$quarter = 'Q'.$q;
					if($rw['freehand']) {
						echo "<td class='budget-decimal budget-quarterly budget-$quarter'>",self::render($arrQuarter[$quarter]),'</td>';
					}
					$arrTotal[$rw['freehand']][$quarter]+=$arrQuarter[$quarter];
					$arrSubtotal[$rw['prtGHQ']][$rw['freehand']][$quarter]+=$arrQuarter[$quarter];
					$arrSubtotalAll[$rw['prtGHQ']][$quarter]+=$arrQuarter[$quarter];
				}				
				
				if($rw['freehand']) {
					echo '<td class=\'budget-decimal budget-ytd\'>',self::render($rw['Total']),'</td>';								
					echo "</tr>\r\n";	
				}
				
				$prtGHQ = $rw['prtGHQ'];
			}
			?>
			</tbody>
			<tfoot>
				<?php foreach ($arrSubtotal as $prtGHQ=>$data){
					?>
					<tr class='budget-subtotal'>
					<td>Total <?php echo $prtGHQ;?> freehand</td>
					<?php
						for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
						// $month = $this->oBudget->arrPeriod[$m];
						$month = $this->oBudget->arrPeriod[$m];
						echo "<td class='budget-decimal budget-monthly budget-$month'>",self::render($data[1][$month]),'</td>';
		
						}
						for ($q=1+$this->oBudget->offset/3;$q<=4+$this->oBudget->offset/3;$q++){		
						$quarter = 'Q'.$q;
						echo "<td class='budget-decimal budget-quarterly budget-$quarter'>",self::render($data[1][$quarter]),'</td>';

						}	
						echo '<td class=\'budget-decimal budget-ytd\'>',self::render($data[1]['Total']),'</td>';					
					?>
					</tr>
					<tr class='budget-subtotal'>
					<td>Total <?php echo $prtGHQ;?> NBO</td>
					<?php
						for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
						// $month = $this->oBudget->arrPeriod[$m];
						$month = $this->oBudget->arrPeriod[$m];
						echo "<td class='budget-decimal budget-monthly budget-$month'>",self::render($data[0][$month]),'</td>';
		
						}
						for ($q=1+$this->oBudget->offset/3;$q<=4+$this->oBudget->offset/3;$q++){		
						$quarter = 'Q'.$q;
						echo "<td class='budget-decimal budget-quarterly budget-$quarter'>",self::render($data[0][$quarter]),'</td>';

						}	
						echo '<td class=\'budget-decimal budget-ytd\'>',self::render($data[0]['Total']),'</td>';					
					?>
					</tr>
					<tr class='budget-ratio'>
					<td>Owner ratio</td>
					<?php
						for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
						// $month = $this->oBudget->arrPeriod[$m];
						$month = $this->oBudget->arrPeriod[$m];
						echo "<td class='budget-decimal budget-monthly budget-$month'>",self::render_ratio($data[1][$month],$arrSubtotalAll[$prtGHQ][$month]),'</td>';
		
						}
						for ($q=1+$this->oBudget->offset/3;$q<=4+$this->oBudget->offset/3;$q++){		
						$quarter = 'Q'.$q;
						echo "<td class='budget-decimal budget-quarterly budget-$quarter'>",self::render_ratio($data[1][$quarter],$arrSubtotalAll[$prtGHQ][$quarter]),'</td>';

						}	
						echo '<td class=\'budget-decimal budget-ytd\'>',self::render_ratio($data[1]['Total'],$arrSubtotalAll[$prtGHQ]['Total']),'</td>';					
					?>
					</tr>
					<?php
				}
				?>
				<tr class='budget-subtotal'>
					<td>Total freehand volume</td>
					<?php
					for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
					// $month = $this->oBudget->arrPeriod[$m];
					$month = $this->oBudget->arrPeriod[$m];
					echo "<td class='budget-decimal budget-monthly budget-$month'>",self::render($arrTotal[1][$month]),'</td>';
	
					}
					for ($q=1+$this->oBudget->offset/3;$q<=4+$this->oBudget->offset/3;$q++){		
					$quarter = 'Q'.$q;
					echo "<td class='budget-decimal budget-quarterly budget-$quarter'>",self::render($arrTotal[1][$quarter]),'</td>';

					}	
					echo '<td class=\'budget-decimal budget-ytd\'>',self::render($arrTotal[1]['Total']),'</td>';					
					?>
				</tr>
			</tfoot>
			</table>			
		<?php
		$this->_echoButtonCopyTable($tableID);
		
	}
	
		
	function whByCustomer(){
		
		require_once('item.class.php');
		$empty = 1894;
		
		$arrRates = $this->oBudget->getMonthlyRates($this->Currency);
		$sql = "SELECT customer, activity, cntTitle, ".$this->oBudget->getMonthlySumSQL(1,15, $arrRates).", 
						SUM(".$this->oBudget->getYTDSQL(1+$this->oBudget->offset,12+$this->oBudget->offset,$arrRates).") as Total,
						SUM(".$this->oBudget->getYTDSQL(4,15,$arrRates).") as Total_AM 
		FROM reg_master 
		LEFT JOIN vw_customer ON cntID=customer
		{$this->sqlWhere} 
		AND item='".Items::REVENUE."' 
		AND scenario='{$this->oBudget->id}' 
		AND `activity` IN (9,12)
		GROUP BY customer, activity";
		$rs = $this->oSQL->q($sql); 
		while ($rw = $this->oSQL->f($rs)){
			$arrRevenue[$rw['customer']][$rw['activity']] = $rw;
			$arrCustomer[$rw['customer']] = $rw['cntTitle'];
		}
		
		$sql = "SELECT cntTitle,customer, ".$this->oBudget->getMonthlySumSQL(1,15).", 
					SUM(".$this->oBudget->getYTDSQL(1+$this->oBudget->offset,12+$this->oBudget->offset).") as Total,
					SUM(".$this->oBudget->getYTDSQL(4,15).") as Total_AM
				FROM reg_rent 
				LEFT JOIN vw_customer ON cntID=customer
				{$this->sqlWhere} AND posted=1 AND item='".Items::WH_RENT."' AND scenario='{$this->oBudget->id}' AND `company`='{$this->company}'
				GROUP BY customer";
		$rs = $this->oSQL->q($sql); 
		while ($rw=$this->oSQL->f($rs)){
			$arrRent[$rw['customer']] = $rw;
			$arrCustomer[$rw['customer']] = $rw['cntTitle'];
		}
		
		$tableID = "kpi_".md5($sql);
			?>
			<h2>WH utilization, m<sup>2</sup></h2>
			<table id='<?php echo $tableID;?>' class='budget'>
			<thead>
				<tr>
					<th>Customer</th>
					<th>Storage</th>
					<th>Handling</th>
					<th>Revenue per sqm</th>
					<?php 
					echo $this->oBudget->getTableHeader('monthly',1+$this->oBudget->offset,12+$this->oBudget->offset); 
					echo $this->oBudget->getTableHeader('quarterly'); 
					?>
					<th class='budget-ytd'>Total</th>
					<!--<th>Q5</th>
					<th class='budget-ytd'>Apr-Mar</th>-->
				</tr>
			</thead>			
			<tbody>
			<?php			
			foreach($arrCustomer as $customer=>$title){				
				?>
				<tr class='graph'>
				<?php
				echo "<td class='code-".$customer."'>",$title,'</td>';				
				echo "<td class='budget-decimal'>",$this->render($arrRevenue[$customer][12]['Total']),'</td>';				
				echo "<td class='budget-decimal'>",$this->render($arrRevenue[$customer][9]['Total']),'</td>';				
				echo "<td class='budget-decimal'>",$this->render_ratio(($arrRevenue[$customer][12]['Total']+$arrRevenue[$customer][9]['Total'])/10,$arrRent[$customer]['Total'],0),'</td>';				
				for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
					// $month = $this->oBudget->arrPeriod[$m];
					$month = $this->oBudget->arrPeriod[$m];
					echo "<td class='budget-decimal budget-monthly budget-$month'>",self::render($arrRent[$customer][$month]),'</td>';
					$arrTotal[$month]+=$arrRent[$customer][$month];
					if ($customer!=$empty){
						$arrUtil[$month]+=$arrRent[$customer][$month];
					}	
					
				}
				$arrTotal['Total']+=$rw['Total'];
				$arrTotal['Total_AM']+=$rw['Total_AM'];
				if ($customer!=$empty){
						$arrUtil['Total']+=$arrRent[$customer]['Total'];
						$arrUtil['Total_AM']+=$arrRent[$customer]['Total_AM'];
				}
				
				$arrQuarter = $this->_getQuarterTotals($arrRent[$customer],'average');
				
				if ($customer!=$empty){
						$arrUtil['Q1']+=$arrQuarter['Q1'];
						$arrUtil['Q2']+=$arrQuarter['Q2'];
						$arrUtil['Q3']+=$arrQuarter['Q3'];
						$arrUtil['Q4']+=$arrQuarter['Q4'];
						$arrUtil['Q5']+=$arrQuarter['Q5'];
				}
				
				for ($q=1+$this->oBudget->offset/3;$q<=4+$this->oBudget->offset/3;$q++){		
					$quarter = 'Q'.$q;
					echo "<td class='budget-decimal budget-quarterly budget-$quarter'>",number_format($arrQuarter[$quarter],0,'.',','),'</td>';
					$arrTotal[$quarter]+=$arrQuarter[$quarter];
				}				
							
				// $arrTotal['Q5']+=$arrQuarter['Q5'];
				
				echo '<td class=\'budget-decimal budget-ytd\'>',number_format($arrRent[$customer]['Total']/12,0,'.',','),'</td>';				
				echo "</tr>\r\n";				
			}
			?>
			</tbody>
			<tfoot>
				<tr class='budget-subtotal'>
					<td colspan='4'>Total space</td>
					<?php
					for ($m=1;$m<=12;$m++){
					// $month = $this->oBudget->arrPeriod[$m];
					$month = $this->oBudget->arrPeriod[$m];
					echo "<td class='budget-decimal budget-monthly budget-$month'>",self::render($arrTotal[$month]),'</td>';
	
					}
					for ($q=1+$this->oBudget->offset/3;$q<=4+$this->oBudget->offset/3;$q++){		
					$quarter = 'Q'.$q;
					echo "<td class='budget-decimal budget-quarterly budget-$quarter'>",self::render($arrTotal[$quarter]),'</td>';

					}	
					echo '<td class=\'budget-decimal budget-ytd\'>',self::render($arrTotal['Total']/12),'</td>';					
					?>
				</tr>
				<tr class='budget-subtotal budget-ratio'>
					<td colspan="4">Utilization, %</td>
					<?php
					for ($m=1;$m<=12;$m++){
					// $month = $this->oBudget->arrPeriod[$m];
					$month = $this->oBudget->arrPeriod[$m];
					echo "<td class='budget-decimal budget-monthly budget-$month'>",self::render_ratio($arrUtil[$month],$arrTotal[$month]),'</td>';
	
					}
					for ($q=1+$this->oBudget->offset/3;$q<=4+$this->oBudget->offset/3;$q++){	
					$quarter = 'Q'.$q;
					echo "<td class='budget-decimal budget-quarterly budget-$quarter'>",self::render_ratio($arrUtil[$quarter],$arrTotal[$quarter]),'</td>';

					}	
					echo '<td class=\'budget-decimal budget-ytd\'>',self::render_ratio($arrUtil['Total']/12,$arrTotal['Total']/12),'</td>';					
					?>
				</tr>
			</tfoot>
			</table>
		<?php
		$this->_echoButtonCopyTable($tableID);
	}
	
	public function masterDocument($source, $docClass=''){
		
		$sql = "SELECT * FROM vw_master WHERE `source`='{$source}' ORDER BY pc, customer, activity, account, item";
		$rs = $this->oSQL->q($sql);
		$i = 1;
		?>
		<div id='report'>
		<h2>Master registry {<?php echo $source;?>}</h2>
		<table class='budget' id='<?php echo $source;?>'>
		<thead>
			<tr>
				<th>#</th>
				<th>PC</th>
				<th>Customer</th>
				<th>prdID</th>
				<th>Activity</th>
				<th colspan="2">YACT</th>
				<th>Item</th>
				<th>Sales</th>
				<th>Sal.dept</th>
				<?php echo $this->oBudget->getTableHeader('monthly',1+$this->oBudget->offset,max(12+$this->oBudget->offset,$this->oBudget->length)); ?>
				<th class='budget-ytd'>Total</th>
			</tr>
		</thead>
		<?php
		while ($rw = $this->oSQL->f($rs)){
			?>
			<tr>
				<td><?php echo $i;?></td>
				<td><?php echo $rw['Profit'];?></td>
				<td><?php echo $rw['Customer_name'];?></td>
				<td><?php echo $rw['activity'];?></td>
				<td><?php echo $rw['Activity_title'];?></td>
				<td><?php echo $rw['account'];?></td>
				<td><?php echo $rw['Title'];?></td>
				<td><?php echo $rw['Budget item'];?></td>
				<td><?php echo $rw['usrTitle'];?></td>
				<td><?php echo $rw['bdvTitle'];?></td>
				<?php
					$rowTotal = 0;
					for($m=1+$this->oBudget->offset;$m<=max(12+$this->oBudget->offset,$this->oBudget->length);$m++){
						$month = $this->oBudget->arrPeriod[$m];
						$arrTotal[$month] += $rw[$month];
						$rowTotal += $rw[$month];
						?>
						<td class='budget-decimal'><?php self::render($rw[$month]);?></td>
						<?php
					}
				?>
				<td class='budget-ytd budget-decimal'><?php self::render($rowTotal);?></td>
			</tr>
			<?php
			$i++;
		}
		?>
		<tfoot>
			<tr class='budget-subtotal'>
				<td colspan="10">Total:</td>
				<?php
					for($m=1+$this->oBudget->offset;$m<=max(12+$this->oBudget->offset,$this->oBudget->length);$m++){
						$month = $this->oBudget->arrPeriod[$m];
						?>
						<td class='budget-decimal'><?php self::render($arrTotal[$month]);?></td>
						<?php
					}
				?>
				<td class='budget-ytd budget-decimal'><?php self::render(array_sum($arrTotal));?></td>
			</tr>
		</tfoot>
		</table>
		<?php
		$this->_echoButtonCopyTable($source);
		
		if ($docClass=='Interco_sales' || $docClass=='Sales'){
			$sql = "SELECT reg_sales.*, tbl_profit.pccTitle as Profit, tbl_counterparty.cntTitle as Customer_name, tbl_product.prdTitle as Product_title, tbl_product_type.prtGHQ as Activity_title
					FROM reg_sales 
					LEFT JOIN common_db.tbl_profit ON pc=pccID
					LEFT JOIN common_db.tbl_counterparty ON customer=cntID
					LEFT JOIN common_db.tbl_product ON product=prdID
					LEFT JOIN common_db.tbl_product_type ON activity=prtID
					WHERE `source`='{$source}' ORDER BY pc, customer, activity";
			$rs = $this->oSQL->q($sql);
			$i = 1;
			?>
			<h2>Sales registry</h2>
			<table class='budget' id='sales_<?php echo $source;?>'>
			<thead>
				<tr>
					<th>#</th>
					<th>PC</th>
					<th>Customer</th>
					<th>Activity</th>					
					<th>Product</th>
					<th>KPI</th>
					<?php echo $this->oBudget->getTableHeader('monthly',1+$this->oBudget->offset,max(12+$this->oBudget->offset,$this->oBudget->length)); ?>
					<th class="budget-ytd">Total</th>
				</tr>
			</thead>
			<tbody>
			<?php			
			while ($rw = $this->oSQL->f($rs)){
				?>
				<tr>
					<td><?php echo $i;?></td>
					<td><?php echo $rw['Profit'];?></td>
					<td><?php echo $rw['Customer_name'];?></td>
					<td><?php echo $rw['Activity_title'];?></td>
					<td><?php echo $rw['Product_title'];?></td>					
					<td><?php echo $rw['kpi']?"&#10004;":"&nbsp;";?></td>					
					<?php
						$rowTotal = 0;
						for($m=1+$this->oBudget->offset;$m<=max(12+$this->oBudget->offset,$this->oBudget->length);$m++){
							$month = $this->oBudget->arrPeriod[$m];
							$arrTotal[$month] += $rw[$month];
							$rowTotal += $rw[$month];
							?>
							<td class='budget-decimal <?php echo $m<=$this->oBudget->cm?'budget-inactive':'';?>'><?php self::render($rw[$month]);?></td>
							<?php
						}
					?>
					<td class="budget-ytd budget-decimal"><?php self::render($rowTotal);?></td>
				</tr>
				<?php
				$i++;
			}
			?>
			</tbody>
			</table>
			<?php
			$this->_echoButtonCopyTable('sales_'.$source);
		}
		?>
		</div>
		<?php
	}
	
	public function salesByCustomer($groupOption='pc'){
		
		$arrOptions['pc']=Array('key'=>'pc','title'=>'pccTitle');
		$arrOptions['sales']=Array('key'=>'sales','title'=>'usrTitle', 'href'=>'rep_my.php?ownerID=');
		
		ob_start();
			$sql = "SELECT unit, CUS.cntTitle as 'Customer', ".$this->oBudget->getMonthlySumSQL(1,15).", 
							SUM(".$this->oBudget->getYTDSQL(1+$this->oBudget->offset,12+$this->oBudget->offset).") as Total, 
							`{$arrOptions[$groupOption]['title']}` as groupTitle, 
							`{$arrOptions[$groupOption]['key']}`  as groupKey,
							freehand
					FROM `reg_sales`
					LEFT JOIN common_db.tbl_counterparty CUS ON customer=CUS.cntID					
					LEFT JOIN vw_profit ON pc=pccID	
					LEFT JOIN stbl_user ON sales=usrID
					## LEFT JOIN tbl_sales ON salGUID=source
					{$this->sqlWhere} AND posted=1 AND scenario='{$this->oBudget->id}' and kpi=1 
					GROUP BY `{$arrOptions[$groupOption]['key']}`, `reg_sales`.`customer`, unit, freehand
					ORDER BY `{$arrOptions[$groupOption]['key']}`, Total DESC"; 
			// echo '<pre>',$sql,'</pre>';
			$rs = $this->oSQL->q($sql);
			if (!$this->oSQL->num_rows($rs)){
				echo "<div class='warning'>No data found</div>";
				echo '<pre>',$sql,'</pre>';
				return (false);
			}
			$tableID = "report_".md5($sql);
			?>
			<table id='<?php echo $tableID;?>' class='budget'>
			<thead>
				<tr><th>Customer</th><th>Unit</th><th>FH</th>
					<?php 
					echo $this->oBudget->getTableHeader('monthly',1+$this->oBudget->offset,12+$this->oBudget->offset); 
					echo $this->oBudget->getTableHeader('quarterly'); 
					?>
				<th class='budget-ytd'>Total</th></tr>
			</thead>			
			<tbody>
			<?php
			$currentGroup = null;
			while ($rw=$this->oSQL->f($rs)){
				if ($rw['groupTitle']!=$currentGroup){
					?>
					<tr>
						<th colspan="21">By <?php echo $rw['groupTitle'];?></th>
					</tr>
					<?php 
				}				
				?>
				<tr>
					<td><?php echo $rw['Customer'];?></td>
					<td><?php echo $rw['unit'];?></td>
					<td><?php echo $rw['freehand']?"FH":"";?></td>
				<?php
				for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
					$month = $this->oBudget->arrPeriod[$m];
					$arrTotal[$rw['unit']][$month] += $rw[$month];
					echo "<td class='budget-decimal budget-monthly budget-$month ".($m==$this->oBudget->cm?'budget-current':'')."'>",self::render($rw[$month]),'</td>';
				}
				$arrQuarter = $this->_getQuarterTotals($rw);
				
				for ($q=1+$this->oBudget->offset/3;$q<5+$this->oBudget->offset/3;$q++){		
					$quarter = 'Q'.$q;
					$arrQTotal[$rw['unit']][$quarter] += $arrQuarter[$quarter];
					?>
					<td class='budget-decimal budget-quarterly budget-<?php echo $quarter;?>'><?php self::render($arrQuarter[$quarter])?></td>
					<?php
				}				
				
				?>
				<td class='budget-decimal budget-ytd'><?php self::render($rw['Total']);?></td>				
				</tr>
				<?php
				$currentGroup = $rw['groupTitle'];
			}
			?>
			</tbody>
			<tfoot>
				<?php 
				foreach ($arrTotal as $unit=>$data){
				?>
				<tr class="budget-subtotal">
					<td colspan="3">Total <?php echo $unit?$unit:"<...>";?></td>
					<?php
					for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
						$month = $this->oBudget->arrPeriod[$m];
						?>
						<td class='budget-decimal budget-monthly budget-<?php echo $month;?>'><?php self::render($data[$month]);?></td>
						<?php
					}
					for ($q=1+$this->oBudget->offset/3;$q<5+$this->oBudget->offset/3;$q++){		
						$quarter = 'Q'.$q;						
						?>
						<td class='budget-decimal budget-quarterly budget-<?php echo $quarter;?>'><?php self::render($arrQTotal[$unit][$quarter])?></td>
						<?php
					}
					?>
					<td class='budget-decimal budget-ytd'><?php self::render(array_sum($data));?></td>
				</tr>
				<?php 
				}
				?>
			</tfoot>
			</table>
			<?php
			$this->_echoButtonCopyTable($tableID);
			ob_flush();
	}
	
	public function costsBySupplier($sqlWhere=''){
		GLOBAL $oSQL;
		ob_start();
			$sql = "SELECT cntTitle as 'Supplier', unit as 'Unit', ".Budget::getMonthlySumSQL().", SUM(".Budget::getYTDSQL().") as Total FROM `reg_costs`
					LEFT JOIN vw_supplier ON cntID=supplier
					LEFT JOIN vw_item ON itmGUID=item
					{$sqlWhere} AND posted=1 AND `company`='{$this->company}'
					GROUP BY `reg_costs`.`supplier`, `reg_costs`.`item`
					ORDER BY supplier";
			$rs = $oSQL->q($sql);
			if (!$oSQL->num_rows($rs)){
				echo "<div class='warning'>No data found</div>";
				return (false);
			}			
			?>
			<table id='report' class='budget'>
			<thead>
				<tr><th>Supplier</th><th>Unit</th><?php echo Budget::getTableHeader(); ?><th class='budget-ytd'>Total</th></tr>
			</thead>			
			<tbody>
			<?php
			while ($rw=$oSQL->f($rs)){
				echo '<tr>';
				echo '<td>',$rw['Supplier'],'</td>';
				echo '<td>',$rw['Unit'],'</td>';
				for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
					$month = $this->oBudget->arrPeriod[$m];
					echo "<td class='budget-decimal budget-$month'>",$rw[$month],'</td>';
				}
				echo '<td class=\'budget-decimal budget-ytd\'>',$rw['Total'],'</td>';
				echo "</tr>\r\n";
			}
			?>
			</tbody>
			</table>
			<?php
			ob_flush();
	}
	
	public function headcountByJob($sqlWhere=''){
		GLOBAL $oSQL;
		$denominator = 1000;
		ob_start();
			
			// $sqlSelect = "SELECT prtGHQ, locTitle as 'Location', prtTitle as 'Activity', funTitle, funTitleLocal, pc, pccTitle,pccTitleLocal , wc,
						// ".$this->oBudget->getMonthlySumSQL(1+$this->oBudget->offset, 12+$this->oBudget->offset).", 
						// SUM(".$this->oBudget->getYTDSQL(1+$this->oBudget->offset, 12+$this->oBudget->offset).")/12 as Total 
					// FROM `vw_headcount`
					// LEFT JOIN vw_function ON funGUID=function
					// LEFT JOIN common_db.tbl_profit ON pccID=pc
					// LEFT JOIN vw_product_type ON prtID=IFNULL(activity, pccProductTypeID)
					// LEFT JOIN vw_location ON locID=location
					// {$sqlWhere} 
					// AND posted=1 AND active=1 AND salary>10000";
			
				$sqlSelect = "SELECT prtGHQ, Location, Activity, funTitle, funTitleLocal, pc, pccTitle, pccTitleLocal , wc,
				".$this->oBudget->getMonthlySumSQL(1+$this->oBudget->offset, 12+$this->oBudget->offset).", 
				SUM(Total) as Total, SUM(Total_AM) as Total_AM, SUM(Q1) as Q1, SUM(Q2) as Q2, SUM(Q3) as Q3, SUM(Q4) as Q4, SUM(Q5) as Q5
			FROM `vw_headcount`			
			{$sqlWhere} AND `company`='{$this->company}' AND salary>10000";
			
			$sql = $sqlSelect." GROUP BY `prtGHQ`,wc
					ORDER BY prtRHQ,wc";
			try {
				$rs = $oSQL->q($sql);
				if (!$oSQL->num_rows($rs)){
					echo "<div class='warning'>No data found</div>";
				return (false);
				}
			} catch (Exception $e) {
				echo  "<div class='error'>SQL error</div>",'<pre>',$sql,'</pre>';
			};
			

			
			$tableID = md5($sql);
			
			?>
			<div style="display:none;"><pre><?php echo $sql;?></pre></div>
			<table id='<?php echo $tableID;?>' class='budget'>
			<thead>
				<tr><th>Activity</th><?php echo $this->oBudget->getTableHeader('monthly',1+$this->oBudget->offset, 12+$this->oBudget->offset); ?><th class='budget-ytd'>Average</th></tr>
			</thead>			
			<tbody>
			<?php
			while ($rw=$oSQL->f($rs)){
				?>
				<tr>
					<td><?php echo $rw['prtGHQ'], ": ",($rw['wc']?'White':'Blue');?></td>					
				<?php
				self::_renderHeadcountArray($rw);
				for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
					$headcount[$m] += $rw[$this->oBudget->arrPeriod[$m]];
				}
				$headcount['ytd'] += $rw['Total'];
			}
			
			$sql = $sqlSelect." GROUP BY `location`";
			$rs = $oSQL->q($sql);			
			?>
			<tr><th>Location</th><?php echo $this->oBudget->getTableHeader('monthly',1+$this->oBudget->offset, 12+$this->oBudget->offset); ?><th class='budget-ytd'>Average</th></tr>
			<?php
			while ($rw=$oSQL->f($rs)){
				?>
				<tr>
					<td><?php echo $rw['Location'];?></td>					
				<?php
				self::_renderHeadcountArray($rw, Array('location'=>$rw['location']));
				
			}
			$sql = $sqlSelect." GROUP BY `function` ORDER BY funRHQ, wc";
			$rs = $oSQL->q($sql);			
			?>
			<tr><th>Function</th><?php echo $this->oBudget->getTableHeader('monthly',1+$this->oBudget->offset, 12+$this->oBudget->offset); ?><th class='budget-ytd'>Average</th></tr>
			<?php
			while ($rw=$oSQL->f($rs)){
				?>
				<tr>
					<td><?php echo '<strong>',$rw['funTitle'],'</strong> | ',$rw['funTitleLocal'];?></td>					
				<?php
				self::_renderHeadcountArray($rw, Array('function'=>$rw['function']));
				
			}
			
			$sql = $sqlSelect." GROUP BY `pc` ORDER BY pccFlagProd, pccParentCode1C";
			$rs = $oSQL->q($sql);			
			if ($oSQL->num_rows($rs)>1){
				?>
				<tr><th>Business unit</th><?php echo $this->oBudget->getTableHeader('monthly',1+$this->oBudget->offset, 12+$this->oBudget->offset); ?><th class='budget-ytd'>Average</th></tr>
				<?php
				while ($rw=$oSQL->f($rs)){
					?>
					<tr>
						<td><?php echo '<strong>',$rw['pccTitle'],'</strong> | ',$rw['pccTitleLocal'];?></td>					
					<?php
					self::_renderHeadcountArray($rw, Array('pc'=>$rw['pc']));
					
				}
			}
			?>
			
			<tr class='budget-subtotal'><td>Total headcount</td>
			<?php
			for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
				echo '<td class="budget-decimal">',self::render($headcount[$m],1),'</td>';
			}
			
			?>
				<td class="budget-decimal budget-ytd"><?php self::render($headcount['ytd'],1);?></td>
			</tr>
			<?php
				$sql = "SELECT account, ".$this->oBudget->getMonthlySumSQL(1+$this->oBudget->offset, 12+$this->oBudget->offset).", 
							SUM(".$this->oBudget->getYTDSQL(1+$this->oBudget->offset, 12+$this->oBudget->offset).")/12 as Total 
						FROM `reg_master`
						$sqlWhere
						".self::GP_FILTER."
						AND active=1 AND `company`='{$this->company}'
						GROUP BY account";
				$rs = $oSQL->q($sql);	
				if ($oSQL->num_rows($rs)){
					while ($rw = $oSQL->f($rs)){
						if ($rw['account']=='J00400'){
							?>
							<tr><td>Revenue, RUBx1,000</td>
								<?php
								for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
									$month = $this->oBudget->arrPeriod[$m];
									echo '<td class="budget-decimal">',self::render($rw[$month]/$denominator),'</td>';
									if ($headcount[$m]){
										$arrRevenuePerFTE[$m] = $rw[$month]/$headcount[$m]/$denominator;									
									}
								}
								?>
								<td class='budget-decimal budget-ytd'><?php self::render($rw['Total']/$denominator);?></td>
							</tr>
							<tr><td>Revenue per FTE</td>
								<?php
								for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){						
									echo '<td class="budget-decimal">',self::render($arrRevenuePerFTE[$m]),'</td>';									
								}
								?>
								<td class='budget-decimal budget-ytd'><?php self::render($rw['Total']/$headcount['ytd']/$denominator);?></td>
							</tr>
							<?php
						}
						for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
							$month = $this->oBudget->arrPeriod[$m];
							$arrGP[$month] += $rw[$month];
						}
						$arrGP['Total'] += $rw['Total'];
					}
					?>
					<tr><td>Gross profit, RUBx1,000</td>
						<?php
						for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
									$month = $this->oBudget->arrPeriod[$m];
									echo '<td class="budget-decimal">',self::render($arrGP[$month]/$denominator),'</td>';
									if ($headcount[$m]){
										$arrGPPerFTE[$m] = $arrGP[$month]/$headcount[$m]/$denominator;
									}
						}
						?>
						<td class='budget-decimal budget-ytd'><?php self::render($arrGP['Total']/$denominator);?></td>
					</tr>
					<tr class='budget-subtotal'><td>GP per FTE</td>
						<?php
						for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
							$month = $this->oBudget->arrPeriod[$m];						
							?>
							<td class="budget-decimal"><?php self::render_ratio($arrGP[$month]/100/$denominator,$headcount[$m],0);?></td>
							<?php
						}
						?>
						<td class='budget-decimal budget-ytd'><?php self::render_ratio($arrGP['Total']/100/$denominator,$headcount['ytd'],0);?></td>
					</tr>
					<?php
				}
				
				//---------------- Total staff costs
				$sql = "SELECT account, ".$this->oBudget->getMonthlySumSQL(1+$this->oBudget->offset, 12+$this->oBudget->offset).", 
							SUM(".$this->oBudget->getYTDSQL(1+$this->oBudget->offset, 12+$this->oBudget->offset).")/12 as Total 
						FROM `vw_master`
						$sqlWhere
							AND Group_code IN (95) AND `company`='{$this->company}'
						";
				$rs = $oSQL->q($sql);	
				if ($oSQL->num_rows($rs)){
					while ($rw = $oSQL->f($rs)){						
							?>
							<tr><td>Staff costs, RUBx1,000</td>
								<?php
								for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
									$month = $this->oBudget->arrPeriod[$m];
									echo '<td class="budget-decimal">',number_format(-$rw[$month]/$denominator,0,'.',','),'</td>';
									$arrSC[$month] = -$rw[$month];
									//$arrSCPerFTE[$m] = $headcount[$m]?-$rw[$month]/$headcount[$m]/1000:'n/a';									
								}
								?>
								<td class='budget-decimal budget-ytd'><?php echo number_format(-$rw['Total']/$denominator,0,'.',',');?></td>
							</tr>							
							<?php
							$arrSC['Total'] = -$rw['Total'];
					}
					?>
					<tr>
						<td>Gross profit/Staff costs</td>
						<?php
						for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
									$month = $this->oBudget->arrPeriod[$m];
									?>
									<td class="budget-decimal"><?php self::render_ratio($arrGP[$month]/100,$arrSC[$month],1);?></td>
									<?php
						}
						?>
						<td class='budget-decimal budget-ytd'><?php self::render_ratio($arrGP['Total']/100,$arrSC['Total']);?></td>
					</tr>
					<tr class='budget-subtotal'>
						<td>Cost per FTE</td>
						<?php
						for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
							$month = $this->oBudget->arrPeriod[$m];						
							echo '<td class="budget-decimal">',self::render_ratio($arrSC[$month]/100/$denominator,$headcount[$m],0),'</td>';									
						}
						?>
						<td class='budget-decimal budget-ytd'><?php self::render_ratio($arrSC['Total']/100/$denominator,$headcount['ytd'],0);?></td>
					</tr>
					<?php
				}
				
			?>
			</tbody>
			</table>			
			<?php
			$this->_echoButtonCopyTable($tableID);
			ob_flush();
	}
	
	private function _renderHeadcountArray($data, $meta=Array()){
		for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
					$month = $this->oBudget->arrPeriod[$m];
					?>
					<td class="budget-decimal budget-<?php echo $month;?> <?php echo ($m==$this->oBudget->cm?'budget-current':'');?>" data-meta='<?php echo json_encode($meta);?>'><?php self::render($data[$month],1);?></td>
					<?php
				
				}
				if ($this->oBudget->offset==3){
					$totalField = "Total_AM";
				} else {
					$totalField = "Total";
				};
				?>
					<td class='budget-decimal budget-ytd'><?php echo self::render($data[$totalField],1);?></td>
				</tr>
		<?php
	}
	
	public function masterByYACT($sqlWhere=''){
		global $oSQL;
		
		ob_start();
			$sql = "SELECT prtGHQ, account, Title, ".$this->oBudget->getMonthlySumSQL(1+$this->oBudget->offset, 12+$this->oBudget->offset).", 
							SUM(".$this->oBudget->getYTDSQL(1+$this->oBudget->offset, 12+$this->oBudget->offset).") as Total 
			FROM `vw_master`
			$sqlWhere
			GROUP BY prtGHQ, account
			ORDER BY prtGHQ, account			
			";
			$rs = $oSQL->q($sql);
			$tableID = "YACT_".md5($sql);
			if (!$oSQL->num_rows($rs)){
				echo "<div class='warning'>No data found</div>";
				//echo "<pre>$sql</pre>";
				return (false);
			}
			?>
			<table id='<?php echo $tableID;?>' class='budget'>
			<caption><?php echo $this->caption;?></caption>
			<thead>
				<tr>
					<th>Activity</th>
					<th>Account</th>
					<th>Title</th>
					<?php echo $this->oBudget->getTableHeader('monthly',1+$this->oBudget->offset, 12+$this->oBudget->offset); ?>
					<th class='budget-ytd'>Total</th>
				</tr>
			</thead>			
			<tbody>
			<?php			
			while ($rw=$oSQL->f($rs)){
				?>
				<tr>
					<td class='budget-tdh'><?php echo $rw['prtGHQ'];?></td>
					<td class='budget-tdh'><?php echo $rw['account'];?></td>
					<td class='budget-tdh'><?php echo $rw['Title'];?></td>
				<?php
				for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
					// $month = $this->oBudget->arrPeriod[$m];
					$month = $this->oBudget->arrPeriod[$m];
					?>
					<td class="budget-decimal"><?php self::render($rw[$month],0);?></td>
					<?php
				}
				?>
				<td class="budget-decimal budget-ytd"><?php self::render($rw['Total'],0);?></td>
				<?php
			}
			?>
			</tbody>
			</table>
			<?php		
			$this->_echoButtonCopyTable($tableID);
			ob_flush();
		
		
	}
	
	public function allocation($sqlWhere=''){
		echo "<div class='warning'>Under construction</div>";
	}
	
	public function masterByProfit($sqlWhere=''){
		
		$this->_documentPnL($sqlWhere, Array('field_data'=>'pc','field_title'=>'Profit','title'=>'Profit center'));
	
	}
	
	public function masterByActivity($sqlWhere=''){
		
		$this->_documentPnL($sqlWhere, Array('field_data'=>'activity','field_title'=>"CONCAT(Activity_title,' (',Activity_title_local,')')",'title'=>'Activity'));
		
	}
	
	public function masterByCustomer($sqlWhere=''){
	
		$this->_documentPnL($sqlWhere, Array('field_data'=>'customer','field_title'=>'Customer_name','title'=>'Customer'));
	
	}
		
	private function _documentPnL($sqlWhere, $params = Array('field_data','field_title','title')){
		
		for($m=$this->oBudget->nm;$m<=$this->oBudget->offset+12;$m++){
			$this->columns[] = $this->oBudget->arrPeriod[$m];
		}
		
		$this->columns[] = 'ROY_A';
		
		$strFields = $this->_getPeriodicFields();
		
		ob_start();
		$sql = "SELECT {$params['field_title']} as 'Level1_title', {$params['field_data']} as 'level1_code', `Budget item` as `level2_title`, `Group`, `item` as `level2_code`,
					{$strFields['actual']}
			FROM `vw_master` 			
			{$sqlWhere}
			GROUP BY `vw_master`.`{$params['field_data']}`, `vw_master`.item
			ORDER BY `{$params['field_data']}`, `Group`, `vw_master`.itmOrder ASC			
			";
		
		$arrGT = $this->_firstLevelPeriodic($sql, $params['title'], $this->oBudget);
		?>
		</tbody>
		<tfoot>
		<?php
			$this->echoBudgetItemString($arrGT, 'budget-total');
		?>
		</tfoot>
		</table>
		<?php			
		$this->_echoButtonCopyTable($this->ID);
		ob_flush();
		
	}
	
	public function periodicPnL($type='ghq'){ //$params = Array('field_data','field_title','title','yact'=>false)){
		
		$sqlWhere = $this->sqlWhere;
		
		$this->columns = Array('Total','Total_AM','estimate','estimate_AM','YTD_A','YTD_B','ROY_A','ROY_B');
		$this->sqlSelect = "";
		for ($m = 1;$m<=15;$m++){
			$this->columns[] = $this->oBudget->arrPeriod[$m];
		}
		for ($q = 1;$q<=5;$q++){
			$this->columns[] = 'Q'.$q;
		}
		foreach($this->columns as $i=>$field){
			$this->sqlSelect .= ($this->sqlSelect?",\r\n":"")."SUM(`{$field}`) as '{$field}'";
		}
		
		$strFields = $this->_getPeriodicFields();
		
		$arrMeasure = $this->_getSQLMeasure($type);
				
		// $this->structure = 'monthly';
		// $strFields = $this->_getPeriodicFields();
		
		// $strFields = $this->_getMRFields();
		$sqlGroup = "GROUP BY Level1_title, level1_code, `level2_title`, `level2_code`, `Group`";
		$sqlOrder = "ORDER BY `level1_code`, `Group`, `itmOrder` ASC";

		
		ob_start();
		
		$sql = "SELECT {$arrMeasure['sql']}
					{$strFields['actual']}
			FROM `vw_master`			
			{$sqlWhere}  
				AND scenario='{$strFields['from_a']}' 
				AND {$this->strGPFilter}
			{$sqlGroup}	
			UNION ALL
				SELECT {$arrMeasure['sql']}
				{$strFields['budget']}
			FROM `vw_master`				
			{$sqlWhere} 
				AND scenario='{$strFields['from_b']}' 
				AND {$this->strGPFilter}
			{$sqlGroup}			
			";
		
		$sql = "SELECT `Level1_title`, `level1_code`, `level2_title`, `Group`, `level2_code`,`itmOrder`,
					{$this->sqlSelect}
				FROM ({$sql}) U 
				{$sqlGroup} 
				{$sqlOrder}";
		
		// echo '<pre>',$sql,'</pre>';
		$this->_firstLevelPeriodic($sql, $arrMeasure['title'], $this->oBudget);
		//==========================================================================================================================Non-customer-related data
		$this->_nofirstLevelPeriodic($sqlWhere);
		?>
		</tbody>
		</table>
		<?php
		$this->_echoButtonCopyTable($this->ID);		
		ob_flush();
	}
	
	public function periodicGraph(){
					
		$sqlWhere = $this->sqlWhere;
		
		$strFields = $this->_getPeriodicFields();		
		
		if ($this->YACT){
			$strAccountTitle = "title";
			$strAccountGroup = "yact_group";
			$strAccountCode = "account";
			$strGPFilter = "yact_group_code IN ('449000','499000')"; 
		} else {
			$strAccountTitle = "Budget item";
			$strAccountGroup = "Group";
			$strAccountCode = "item";
			$strGPFilter = "Group_code=".self::GP_CODE; 
		}
		
		$arrRates_this = $this->oBudget->getMonthlyRates($this->Currency);
		$arrRates_that = $this->oReference->getMonthlyRates($this->Currency);
		
		ob_start();
			
		$sqlSelect = $this->oBudget->getMonthlySumSQL(1+$this->oBudget->offset,max($this->oBudget->length,12+$this->oBudget->offset),$arrRates_this, $this->Denominator).", ".
				"SUM(".$this->oBudget->getYTDSQL(1,3,$arrRates_this, $this->Denominator).") as Q1, ".
				"SUM(".$this->oBudget->getYTDSQL(4,15,$arrRates_this, $this->Denominator).") as Total_AM";
		
		$sql = "SELECT {$sqlSelect}
				FROM `vw_master` 			
				{$sqlWhere} AND scenario='{$this->oBudget->id}' AND account='J00400'";
		$rs = $this->oSQL->q($sql);
		$rwGR = $this->oSQL->f($rs);
		
		
		$sql = "SELECT {$sqlSelect}
				FROM `vw_master` 			
				{$sqlWhere} AND scenario='{$this->oBudget->id}' AND Group_code=".self::GP_CODE;
		$rs = $this->oSQL->q($sql);
		$rwGP = $this->oSQL->f($rs);
		
		$sql = "SELECT {$sqlSelect}
				FROM `vw_master` 			
				{$sqlWhere} AND scenario='{$this->oReference->id}' AND Group_code=".self::GP_CODE;
		$rs = $this->oSQL->q($sql);
		$rwBGP = $this->oSQL->f($rs);
		
		$sql = "SELECT {$sqlSelect}
				FROM `vw_master` 			
				{$sqlWhere} AND scenario='{$this->oBudget->id}' AND Group_code=95";
		$rs = $this->oSQL->q($sql);
		$rwSC = $this->oSQL->f($rs);
		
		$sql = "SELECT {$sqlSelect}
				FROM `vw_master` 			
				{$sqlWhere} AND scenario='{$this->oBudget->id}' ".self::OP_FILTER;
		$rs = $this->oSQL->q($sql);
		$rwOP = $this->oSQL->f($rs);
		
		$sql = "SELECT {$sqlSelect}
				FROM `vw_master` 			
				{$sqlWhere} AND scenario='{$this->oReference->id}' ".self::OP_FILTER;
		$rs = $this->oSQL->q($sql);
		$rwBOP = $this->oSQL->f($rs);
		
		
		//-----------------------------------Natural KPIs------------------------
		$arrKPI = Array(
					'AFF'=>Array(
							'Export'=>Array('activity'=>47),
							'Import'=>Array('activity'=>46)
					),
					'OFF'=>Array(
							'Export'=>Array('activity'=>63),
							'Import'=>Array('activity'=>48)
					),
					'RFF'=>Array(
							'Domestic'=>Array('activity'=>3),
							'Intl'=>Array('activity'=>13)
					)
				);
		
		foreach($arrKPI as $segment=>$activity){
			foreach($activity as $key=>$arrData){
				$arrKPI[$segment][$key] = $this->_getKPIGraphData($sqlWhere,$arrData['activity']);				
			};
		}
		
		// echo '<pre>';print_r($arrKPI);echo '</pre>';		
		
		$arrHighChartsAFF = Array(
				'title'=>Array('text'=>'AFF volumes','x'=>-20),				
				'subtitle'=>Array('text'=>$this->oBudget->title." vs ".$this->oReference->title,'x'=>-20),						
				'chart'=>Array('type'=>'column'),
				'yAxis'=>Array('min'=>0,'title'=>Array('text'=>'Kg')),
				'plotOptions'=>Array('column'=>Array('stacking'=>'normal'))
		);

		$arrHighChartsOFF = Array(
				'title'=>Array('text'=>'OFF volumes','x'=>-20),				
				'subtitle'=>Array('text'=>$this->oBudget->title." vs ".$this->oReference->title,'x'=>-20),						
				'chart'=>Array('type'=>'column'),
				'yAxis'=>Array('min'=>0,'title'=>Array('text'=>'TEU')),
				'plotOptions'=>Array('column'=>Array('stacking'=>'normal'))
		);
		
		$arrHighChartsRFF = Array(
				'title'=>Array('text'=>'RFF volumes','x'=>-20),				
				'subtitle'=>Array('text'=>$this->oBudget->title." vs ".$this->oReference->title,'x'=>-20),						
				'chart'=>Array('type'=>'column'),
				'yAxis'=>Array('min'=>0,'title'=>Array('text'=>'Ttips')),
				'plotOptions'=>Array('column'=>Array('stacking'=>'normal'))
		);
		
		//-------------------------------------------------------------------------
		$arrHighCharts = Array(
						'title'=>Array('text'=>'Performance by month','x'=>-20),
						'subtitle'=>Array('text'=>$this->oBudget->title." vs ".$this->oReference->title,'x'=>-20)						
					);
		for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
			$period = $this->oBudget->arrPeriod[$m];
		
			// $arrGraph[] = Array($period,(double)$rwGR[$period],(double)$rwGP[$period], (double)$rwBGP[$period], -(double)$rwSC[$period], (double)$rwOP[$period], (double)$rwBOP[$period]);
			$arrHighCharts['xAxis']['categories'][] = $period;
			$arrHighChartsAFF['xAxis']['categories'][] = $period;
			$arrHighChartsOFF['xAxis']['categories'][] = $period;
			$arrHighChartsRFF['xAxis']['categories'][] = $period;
			$arrHSSeries[0][] = (integer)$rwGR[$period];
			$arrHSSeries[1][] = (integer)$rwGP[$period];
			$arrHSSeries[2][] = (integer)$rwBGP[$period];
			$arrHSSeries[3][] = -(integer)$rwSC[$period];
			$arrHSSeries[4][] = (integer)$rwOP[$period];
			$arrHSSeries[5][] = (integer)$rwBOP[$period];
						
		}
		$arrHighCharts['series']=Array(
									// Array('name'=>'Gross revenue','data'=>$arrHSSeries[0])
									Array('name'=>"Gross profit, {$this->oBudget->title}",'data'=>$arrHSSeries[1])
									,Array('name'=>"Gross profit, {$this->oReference->title}",'data'=>$arrHSSeries[2])
									// ,Array('name'=>'Staff costs','data'=>$arrHSSeries[3])
									// ,Array('name'=>"OP, {$this->oBudget->title}",'data'=>$arrHSSeries[4])
									// ,Array('name'=>"OP, {$this->oReference->title}",'data'=>$arrHSSeries[5])
								);
								
		$arrHighChartsAFF['series'] = Array(
									Array('name'=>"Export, {$this->oBudget->title}",'stack'=>'Actual','data'=>array_map('intval',array_values(array_slice($arrKPI['AFF']['Export']['Actual'],0,12))))									
									,Array('name'=>"Import, {$this->oBudget->title}",'stack'=>'Actual','data'=>array_map('intval',array_values(array_slice($arrKPI['AFF']['Import']['Actual'],0,12))))									
									,Array('name'=>"Export, {$this->oReference->title}",'stack'=>'Budget','data'=>array_map('intval',array_values(array_slice($arrKPI['AFF']['Export']['Budget'],0,12))))									
									,Array('name'=>"Import, {$this->oReference->title}",'stack'=>'Budget','data'=>array_map('intval',array_values(array_slice($arrKPI['AFF']['Import']['Budget'],0,12))))									
								);
								
		$arrHighChartsOFF['series'] = Array(
									Array('name'=>"Export, {$this->oBudget->title}",'stack'=>'Actual','data'=>array_map('intval',array_values(array_slice($arrKPI['OFF']['Export']['Actual'],0,12))))									
									,Array('name'=>"Import, {$this->oBudget->title}",'stack'=>'Actual','data'=>array_map('intval',array_values(array_slice($arrKPI['OFF']['Import']['Actual'],0,12))))									
									,Array('name'=>"Export, {$this->oReference->title}",'stack'=>'Budget','data'=>array_map('intval',array_values(array_slice($arrKPI['OFF']['Export']['Budget'],0,12))))									
									,Array('name'=>"Import, {$this->oReference->title}",'stack'=>'Budget','data'=>array_map('intval',array_values(array_slice($arrKPI['OFF']['Import']['Budget'],0,12))))									
								);		
		$arrHighChartsRFF['series'] = Array(
							Array('name'=>"Domestic, {$this->oBudget->title}",'stack'=>'Actual','data'=>array_map('intval',array_values(array_slice($arrKPI['RFF']['Domestic']['Actual'],0,12))))									
							,Array('name'=>"Intl, {$this->oBudget->title}",'stack'=>'Actual','data'=>array_map('intval',array_values(array_slice($arrKPI['RFF']['Intl']['Actual'],0,12))))									
							,Array('name'=>"Domestic, {$this->oReference->title}",'stack'=>'Budget','data'=>array_map('intval',array_values(array_slice($arrKPI['RFF']['Domestic']['Budget'],0,12))))									
							,Array('name'=>"Intl, {$this->oReference->title}",'stack'=>'Budget','data'=>array_map('intval',array_values(array_slice($arrKPI['RFF']['Intl']['Budget'],0,12))))									
						);
		// echo '<pre>';print_r($arrGraph);echo '</pre>';
		?>
		<table class='budget' id='<?php echo $this->ID;?>'>
		<tr>
			<th colspan="2">Period</th>
		<?php
			// foreach ($this->oBudget->arrPeriod as $period){
			for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
				$period = $this->oBudget->arrPeriod[$m];
				echo '<th>',$period,'</th>';
			}
		?>
		<th>FYE</th>
		</tr>
		<tr><td colspan="2">Gross revenue</td>
		<?php
			// foreach ($this->oBudget->arrPeriod as $period){
			for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
				$period = $this->oBudget->arrPeriod[$m];
				echo '<td class="budget-decimal">',self::render($rwGR[$period]),'</td>';
			}
		// echo '<td class="budget-decimal budget-quarterly">',self::render($rwGR['Q1']),'</td>';
		echo '<td class="budget-decimal budget-ytd">',self::render($rwGR['Total_AM']),'</td>';
		?>
		</tr>
		<tr><td rowspan="4">Gross profit</td><td>This</td>
		<?php
			for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
				$period = $this->oBudget->arrPeriod[$m];
				echo '<td class="budget-decimal">',self::render($rwGP[$period]),'</td>';
			}
		// echo '<td class="budget-decimal budget-quarterly">',self::render($rwGP['Q1']),'</td>';
		echo '<td class="budget-decimal budget-ytd">',self::render($rwGP['Total_AM']),'</td>';
		?>
		</tr>
		<tr class="budget-ratio"><td>%</td>
		<?php
			for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
				$period = $this->oBudget->arrPeriod[$m];
				echo '<td class="budget-decimal">',self::render_ratio($rwGP[$period],$rwGR[$period]),'</td>';
			}
		// echo '<td class="budget-decimal budget-quarterly">',self::render_ratio($rwGP['Q1'], $rwGR['Q1']),'</td>';
		echo '<td class="budget-decimal budget-ytd">',self::render_ratio($rwGP['Total_AM'], $rwGR['Total_AM']),'</td>';
		?>
		</tr>
		<tr><td><?php echo $this->oReference->id;?></td>
		<?php
			for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
				$period = $this->oBudget->arrPeriod[$m];
				echo '<td class="budget-decimal">',self::render($rwBGP[$period]),'</td>';
			}
		// echo '<td class="budget-decimal budget-quarterly">',self::render($rwBGP['Q1']),'</td>';
		echo '<td class="budget-decimal budget-ytd">',self::render($rwBGP['Total_AM']),'</td>';
		?>
		</tr>
		<tr><td>Diff</td>
		<?php
			for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
				$period = $this->oBudget->arrPeriod[$m];
				echo '<td class="budget-decimal">',self::render($rwGP[$period]-$rwBGP[$period]),'</td>';
			}
		// echo '<td class="budget-decimal budget-quarterly">',self::render($rwGP['Q1']-$rwBGP['Q1']),'</td>';
		echo '<td class="budget-decimal budget-ytd">',self::render($rwGP['Total_AM']-$rwBGP['Total_AM']),'</td>';
		?>
		</tr>
		<tr><td rowspan="4">Operating income</td><td>This</td>
		<?php
			for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
				$period = $this->oBudget->arrPeriod[$m];
				echo '<td class="budget-decimal">',self::render($rwOP[$period]),'</td>';
			}
		// echo '<td class="budget-decimal budget-quarterly">',self::render($rwOP['Q1']),'</td>';
		echo '<td class="budget-decimal budget-ytd">',self::render($rwOP['Total_AM']),'</td>';
		?>
		</tr>
		<tr class="budget-ratio"><td>% of revenue</td>
		<?php
			for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
				$period = $this->oBudget->arrPeriod[$m];
				echo '<td class="budget-decimal">',self::render_ratio($rwOP[$period],$rwGR[$period]),'</td>';
			}
		// echo '<td class="budget-decimal budget-quarterly">',self::render_ratio($rwOP['Q1'], $rwGR['Q1']),'</td>';
		echo '<td class="budget-decimal budget-ytd">',self::render_ratio($rwOP['Total_AM'],$rwGR['Total_AM']),'</td>';
		?>
		</tr>
		<tr><td><?php echo $this->oReference->id;?></td>
		<?php
			for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
				$period = $this->oBudget->arrPeriod[$m];
				echo '<td class="budget-decimal">',self::render($rwBOP[$period]),'</td>';
			}
		// echo '<td class="budget-decimal budget-quarterly">',self::render($rwBOP['Q1']),'</td>';
		echo '<td class="budget-decimal budget-ytd">',self::render($rwBOP['Total_AM']),'</td>';
		?>
		</tr>
		<tr><td>Diff</td>
		<?php
			for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
				$period = $this->oBudget->arrPeriod[$m];
				echo '<td class="budget-decimal">',self::render($rwOP[$period]-$rwBOP[$period]),'</td>';
			}
		// echo '<td class="budget-decimal budget-quarterly">',self::render($rwOP['Q1']-$rwBOP['Q1']),'</td>';
		echo '<td class="budget-decimal budget-ytd">',self::render($rwOP['Total_AM']-$rwBOP['Total_AM']),'</td>';
		?>
		</tr>
		<tr><td colspan="2">Staff costs</td>
		<?php
			for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
				$period = $this->oBudget->arrPeriod[$m];
				echo '<td class="budget-decimal">',self::render(-$rwSC[$period]),'</td>';
			}
		// echo '<td class="budget-decimal budget-quarterly">',self::render(-$rwSC['Q1']),'</td>';
		echo '<td class="budget-decimal budget-ytd">',self::render(-$rwSC['Total_AM']),'</td>';
		?>
		</tr>
		<tr class="budget-ratio"><td colspan="2">Staff efficiency (GP/Cost)</td>
		<?php
			for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
				$period = $this->oBudget->arrPeriod[$m];
				echo '<td class="budget-decimal">',self::render_ratio($rwGP[$period],-$rwSC[$period]*100),'</td>';
			}
		// echo '<td class="budget-decimal budget-quarterly">',self::render_ratio($rwGP['Q1'], -$rwSC['Q1']*100),'</td>';
		echo '<td class="budget-decimal budget-ytd">',self::render_ratio($rwGP['Total_AM'],-$rwSC['Total_AM']*100),'</td>';
		?>
		</tr>
		<tr><td rowspan="2">AFF volume</td><td>Export</td>
		<?php
			for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
				$period = $this->oBudget->arrPeriod[$m];
				echo '<td class="budget-decimal">',self::render($arrKPI['AFF']['Export']['Actual'][$period]),'</td>';
			}
		// echo '<td class="budget-decimal budget-quarterly">',self::render($rwOP['Q1']),'</td>';
		echo '<td class="budget-decimal budget-ytd">',self::render($arrKPI['AFF']['Export']['Actual']['Total_AM']),'</td>';
		?>
		</tr>
		<tr><td>Import</td>
		<?php
			for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
				$period = $this->oBudget->arrPeriod[$m];
				echo '<td class="budget-decimal">',self::render($arrKPI['AFF']['Import']['Actual'][$period]),'</td>';
			}
		// echo '<td class="budget-decimal budget-quarterly">',self::render($rwOP['Q1']),'</td>';
		echo '<td class="budget-decimal budget-ytd">',self::render($arrKPI['AFF']['Import']['Actual']['Total_AM']),'</td>';
		?>
		</tr>
		<tr><td rowspan="2">OFF volume</td><td>Export</td>
		<?php
			for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
				$period = $this->oBudget->arrPeriod[$m];
				echo '<td class="budget-decimal">',self::render($arrKPI['OFF']['Export']['Actual'][$period]),'</td>';
			}
		// echo '<td class="budget-decimal budget-quarterly">',self::render($rwOP['Q1']),'</td>';
		echo '<td class="budget-decimal budget-ytd">',self::render($arrKPI['OFF']['Export']['Actual']['Total_AM']),'</td>';
		?>
		</tr>
		<tr><td>Import</td>
		<?php
			for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
				$period = $this->oBudget->arrPeriod[$m];
				echo '<td class="budget-decimal">',self::render($arrKPI['OFF']['Import']['Actual'][$period]),'</td>';
			}
		// echo '<td class="budget-decimal budget-quarterly">',self::render($rwOP['Q1']),'</td>';
		echo '<td class="budget-decimal budget-ytd">',self::render($arrKPI['OFF']['Import']['Actual']['Total_AM']),'</td>';
		?>
		</tr>
		<tr><td rowspan="2">RFF volume</td><td>Domestic</td>
		<?php
			for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
				$period = $this->oBudget->arrPeriod[$m];
				echo '<td class="budget-decimal">',self::render($arrKPI['RFF']['Domestic']['Actual'][$period]),'</td>';
			}
		// echo '<td class="budget-decimal budget-quarterly">',self::render($rwOP['Q1']),'</td>';
		echo '<td class="budget-decimal budget-ytd">',self::render($arrKPI['RFF']['Domestic']['Actual']['Total_AM']),'</td>';
		?>
		</tr>
		<tr><td>Intl</td>
		<?php
			for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
				$period = $this->oBudget->arrPeriod[$m];
				echo '<td class="budget-decimal">',self::render($arrKPI['RFF']['Intl']['Actual'][$period]),'</td>';
			}
		// echo '<td class="budget-decimal budget-quarterly">',self::render($rwOP['Q1']),'</td>';
		echo '<td class="budget-decimal budget-ytd">',self::render($arrKPI['RFF']['Intl']['Actual']['Total_AM']),'</td>';
		?>
		</tr>
		</table>
		<?php
		$this->_echoButtonCopyTable($this->ID);
		?>
		
		<div id='graph_<?php echo $this->ID;?>'>Line chart loading...</div>
		<div id='aff_<?php echo $this->ID;?>'>AFF chart loading...</div>
		<div id='off_<?php echo $this->ID;?>'>OFF chart loading...</div>
		<div id='rff_<?php echo $this->ID;?>'>RFF chart loading...</div>
		<script type='text/javascript'>
			console.log('Here should be a chart!');
			var target = '#graph_<?php echo $this->ID;?>';
			var targetAFF = '#aff_<?php echo $this->ID;?>';
			var targetOFF = '#off_<?php echo $this->ID;?>';
			var targetRFF = '#rff_<?php echo $this->ID;?>';
			$(target).ready(function(){				
				var options = <?php echo json_encode($arrHighCharts);?>;		
				var optionsAFF = <?php echo json_encode($arrHighChartsAFF);?>;		
				var optionsOFF = <?php echo json_encode($arrHighChartsOFF);?>;		
				var optionsRFF = <?php echo json_encode($arrHighChartsRFF);?>;		
				console.log(optionsAFF);
				// target = document.getElementById(target);	
				// drawGraph(arrData, target, options);
				$(target).highcharts(options);
				$(targetAFF).highcharts(optionsAFF);
				$(targetOFF).highcharts(optionsOFF);
				$(targetRFF).highcharts(optionsRFF);
			});
		</script>
		<?php			
		ob_flush();
	}
	
	private function _getKPIGraphData($sqlWhere,$activity){
			
			$sqlSelect = $this->oBudget->getMonthlySumSQL(1+$this->oBudget->offset,max($this->oBudget->length,12+$this->oBudget->offset)).", ".				
				"SUM(".$this->oBudget->getYTDSQL(4,15,$arrRates_this, $this->Denominator).") as Total_AM";
			
			
			$sql = "SELECT {$sqlSelect}
					FROM `reg_sales` 			
					{$sqlWhere} AND scenario='{$this->oReference->id}' AND activity={$activity} AND ".self::ACTUAL_DATA_FILTER."";			
			$rs = $this->oSQL->q($sql);
			$res['Budget'] = $this->oSQL->f($rs);
			
			$sql = "SELECT {$sqlSelect}
					FROM `reg_sales` 			
					{$sqlWhere} AND scenario='{$this->oReference->id}' AND activity={$activity} AND source<>'Actual'";			
			$rs = $this->oSQL->q($sql);
			$rw = $this->oSQL->f($rs); 
			for ($m=(integer)date('n',$this->oReference->date_start);$m<=12+$this->oBudget->offset;$m++){
				$month = $this->oBudget->arrPeriod[$m];
				$res['Budget'][$month] += (integer)$rw[$month];
				$res['Budget']['Total_AM'] += (integer)$rw[$month];
			}
			
			$sql = "SELECT {$sqlSelect}
					FROM `reg_sales` 			
					{$sqlWhere} AND scenario='{$this->oBudget->id}' AND activity={$activity} AND ".self::ACTUAL_DATA_FILTER."";
			$rs = $this->oSQL->q($sql);			
			$res['Actual'] = $this->oSQL->f($rs);
			
			$sql = "SELECT {$sqlSelect}
					FROM `reg_sales` 			
					{$sqlWhere} AND scenario='{$this->oBudget->id}' AND activity={$activity} AND source<>'Actual'";
			// echo '<pre>',$sql,'</pre>';
			$rs = $this->oSQL->q($sql);
			$rw = $this->oSQL->f($rs); 
			for ($m=(integer)date('n',$this->oBudget->date_start);$m<=12+$this->oBudget->offset;$m++){
				$month = $this->oBudget->arrPeriod[$m];
				$res['Actual'][$month] += (integer)$rw[$month];
				$res['Actual']['Total_AM'] += (integer)$rw[$month];
			}
			
			return($res);
	}
	
	public function monthlyReport($type='ghq',$options=Array()){
		
		// GLOBAL $budget_scenario;
		// $oBudget = new Budget($budget_scenario);
		if(($this->oBudget->cm % 3 && $this->oBudget->nm % 3) || $this->oBudget->cm==6){
			$this->colspan = 14;
		} else {
			$this->colspan = 18;
		}
		
		$sqlWhere = $this->sqlWhere;		
		// echo '<pre>',$sqlWhere,'</pre>';
		
		$this->columns = Array('CM_A','CM_B','YTD_A','YTD_B','Q_A','Q_B','NM_A','NM_B','FYE_A','FYE_B');
		$this->sqlSelect = "";
		foreach($this->columns as $i=>$field){
			$this->sqlSelect .= ($this->sqlSelect?",\r\n":"")."SUM(`{$field}`) as '{$field}'";
		}
		
		//$sqlLevel2Default = "`Budget item` as `level2_title`, `Group`, `item` as `level2_code`,`itmOrder`,";
		$arrMeasure = $this->_getSQLMeasure($type);
		
		
		$this->structure = 'monthly';
		// $strFields = $this->_getPeriodicFields();
		
		$strFields = $this->_getMRFields();
		$sqlGroup = "GROUP BY Level1_title, level1_code, `level2_title`, `level2_code`, `Group`";
		$sqlOrder = "ORDER BY `level1_code`, `Group`, `itmOrder` ASC";

		
		ob_start();
		
		$sql = "SELECT {$arrMeasure['sql']}
					{$strFields['actual']}
			FROM `vw_master`			
			{$sqlWhere}  AND scenario='{$strFields['from_a']}' AND Group_code=".self::GP_CODE." 
			{$sqlGroup}	
			UNION ALL
				SELECT {$arrMeasure['sql']}
				{$strFields['budget']}
			FROM `vw_master`				
			{$sqlWhere} AND scenario='{$strFields['from_b']}' AND Group_code=".self::GP_CODE."  
			{$sqlGroup}			
			";
		
		$sql = "SELECT `Level1_title`, `level1_code`, `level2_title`, `Group`, `level2_code`,`itmOrder`,
					{$this->sqlSelect}
				FROM ({$sql}) U 
				{$sqlGroup} 
				{$sqlOrder}";
			
			// echo '<pre>',$sql,'</pre>';
			
			self::firstLevelReportMR($sql, $arrMeasure['title'], $this->oBudget);
			$tableID = "FLR_".md5($sql);
			//==========================================================================================================================Non-customer-related data
			self::_noFirstLevelMonthly($this->currency, $options);
			?>
			</tbody>
			</table>			
			<?php		
			$this->_echoButtonCopyTable($tableID);
			ob_flush();
	}
	
	private function _getSQLMeasure($type){
		
		if ($this->YACT){
			// $strAccountTitle = "title";
			// $strAccountGroup = "yact_group";
			// $strAccountCode = "account";
			$this->strGPFilter = "yact_group_code IN ('449000','499000')"; 
			$sqlLevel2Default = "`title` as `level2_title`, `yact_group` as 'Group', `account` as `level2_code`, `account` as itmOrder, ";
		} else {
			// $strAccountTitle = "Budget item";
			// $strAccountGroup = "Group";
			// $strAccountCode = "item";
			$this->strGPFilter = "Group_code=".self::GP_CODE; 
			$sqlLevel2Default = "`Budget item` as `level2_title`, `Group`, `item` as `level2_code`,`itmOrder`,";
		}
		
		
		switch($type){
			case 'activity':
				$res['sql'] = "Activity_title as 'Level1_title', activity as 'level1_code', {$sqlLevel2Default}";
				$res['title'] = 'Activity';
				break;
			case 'customer':
				$res['sql'] = "Customer_name as 'Level1_title', customer as 'level1_code', {$sqlLevel2Default}";
				$res['title'] = 'Customer';
				break;
			case 'customer_group':
				$res['sql'] = "customer_group_title as 'Level1_title'
						, customer_group_code as 'level1_code', `Budget item`, {$sqlLevel2Default}";
				$res['title'] = 'Customer group';
				break;
			case 'sales':
				$res['sql'] = "usrTitle as 'Level1_title', sales as 'level1_code', {$sqlLevel2Default}";
				$res['title'] = 'BDV employee';
				break;
			case 'bdv':
				$res['sql'] = "bdvTitle as 'Level1_title', bdv as 'level1_code', {$sqlLevel2Default}";
				$res['title'] = 'Selling unit';
				break;
			case 'pc':
				$res['sql'] = "Profit as 'Level1_title', pc as 'level1_code', {$sqlLevel2Default}";
				$res['title'] = 'Business unit';
				break;
			case 'bu_group':				
				$res['sql'] = "bu_group_title as 'Level1_title', bu_group as 'level1_code', `customer_group_title` as `level2_title`, `".($this->YACT?'yact_group':'Group')."` as 'Group', `customer_group_code` as `level2_code`,-SUM(Total_AM) as itmOrder,";				
				$res['title'] = 'BU Group';
				break;
			case 'ghq_group':				
				$res['sql'] = "prtGHQ as 'Level1_title', prtGHQ as 'level1_code', `Activity_title` as `level2_title`, `".($this->YACT?'yact_group':'Group')."` as 'Group', `activity` as `level2_code`,-SUM(Total_AM) as itmOrder,";				
				$res['title'] = 'Product Group';
				break;				
			case 'iv':
				$res['sql'] = "ivlGroup as 'Level1_title', ivlGroup as 'level1_code', `customer_group_title` as `level2_title`, `".($this->YACT?'yact_group':'Group')."` as 'Group', `customer_group_code` as `level2_code`,-SUM(Total_AM) as itmOrder,";				
				$res['title'] = 'Industry vertical';
				break;
			case 'ghq':
			default:
				$res['sql'] = "prtGHQ as 'Level1_title', prtGHQ as 'level1_code', {$sqlLevel2Default}";
				$res['title'] = 'GHQ segment';
				break;
		}
		
		return($res);
	}
	
	public function monthlyReportGHQ($type='ghq'){
		
		GLOBAL $budget_scenario;
		$oBudget = new Budget($budget_scenario);
		
		$sqlWhere = $this->sqlWhere;
		$arrMeasure = $this->_getSQLMeasure($type);
		
		$sqlLevel2Default = "`Budget item` as `level2_title`, `Group`, `item` as `level2_code`,`itmOrder`,";
		
		// $strFields = $this->_getPeriodicFields();
		
		$strFields = $this->_getMRFields();
		
		$sqlGroup = "GROUP BY Level1_title, level1_code, `level2_title`, `level2_code`, `Group`";
		
		ob_start();
		
		$sql = "SELECT {$arrMeasure['sql']}
					{$strFields['actual']}
			FROM `vw_master`			
			{$sqlWhere}  AND scenario='{$strFields['from_a']}' AND Group_code=".self::GP_CODE." 
			{$sqlGroup}	
			UNION ALL
				SELECT {$arrMeasure['sql']}
				{$strFields['budget']}
			FROM `vw_master`				
			{$sqlWhere} AND scenario='{$strFields['from_b']}' AND Group_code=".self::GP_CODE."  
			{$sqlGroup}			
			ORDER BY `Group`, `itmOrder` ASC";
		
		$sql = "SELECT `Level1_title`, `level1_code`, `level2_title`, `Group`, `level2_code`,`itmOrder`,
					SUM(CM_A) as CM_A,
					SUM(CM_B) as CM_B,
					SUM(Q_A) as Q_A,
					SUM(Q_B) as Q_B,
					SUM(YTD_A) as YTD_A,
					SUM(YTD_B) as YTD_B,
					SUM(NM_A) as NM_A,
					SUM(NM_B) as NM_B
				FROM ({$sql}) U {$sqlGroup} 
				ORDER BY `level1_code`, `Group`, `itmOrder` ASC";
			
			
			self::firstLevelReportMR($sql, $arrMeasure['title'], $oBudget);
			$tableID = "FLR_".md5($sql);
			//==========================================================================================================================Non-customer-related data
			// self::_noFirstLevelMonthly($this->currency);
			?>
			</tbody>
			</table>			
			<?php			
			$this->_echoButtonCopyTable($tableID);
			ob_flush();
	}
	
	public function masterYactbyActivityEst($sqlWhere){
		global $oSQL;
		
		$strFields = self::_getPeriodicFields();
		
		ob_start();
			$sql = "SELECT prtGHQ as 'Level1_title', activity as 'level1_code', CONCAT(`account`,': ',`Title`) as `Budget item`, Yact_group as `Group`, account as `item`,
					{$strFields['actual']}				
			FROM `vw_master` 
			{$sqlWhere} 
			AND yact_group_code IN ('450000','400000') ## Gross margin only
			GROUP BY `vw_master`.prtGHQ, `vw_master`.account
			ORDER BY prtGHQ,`vw_master`.activity, `Yact_group`, `vw_master`.account ASC			
			";
			
			self::_firstLevelPeriodic($sql, 'Activity');
			//==========================================================================================================================Non-customer-related data
			self::noFirstLevelReport_YACT($sqlWhere, $currency);
			?>
			</tbody>
			</table>
			<?php			
			ob_flush();
	}
	
	private function _firstLevelPeriodic($sql, $firstLevelTitle){	
		
		$tableID = $this->ID?$this->ID:"FLR_".md5($sql);
		
		$this->colspan = $this->oBudget->length + 10;
		
		if (!$rs = $this->oSQL->q($sql)){
				echo "<div class='error'>SQL error:</div>";
				echo "<pre>",$sql,"</pre>";
				return (false);
			};
			?>
			<table id='<?php echo $tableID;?>' class='budget'>
			<caption><?php echo $this->caption;?></caption>
			<thead>
				<tr>
					<th><?php echo $firstLevelTitle; ?></th>
					<th>Account</th>					
					<?php 
						echo $this->oBudget->getTableHeader('monthly',1+$this->oBudget->offset,12+$this->oBudget->offset);
						echo $this->oBudget->getTableHeader('quarterly');
					?>		
					<th class='budget-ytd'><?php echo strpos($this->oBudget->type,'Budget')!==false?'Budget':'FYE';?></th>
					<th><?php echo strpos($this->oBudget->type,'Budget')!==false?$this->oReference->id:'Budget';?></th>
					<th>Diff</th>
					<th>%</th>
					<?php 
					if ($this->oBudget->length>12){
					?>
						<th class='budget-monthly'>Jan+</th>
						<th class='budget-monthly'>Feb+</th>
						<th class='budget-monthly'>Mar+</th>
						<th class='budget-quarterly'>Q5(Jan-Mar)</th>
						<th class='budget-ytd'><?php echo $this->oBudget->type=='Budget'?'Budget':'FYE';?> Apr-Mar</th>
						<th><?php echo $this->oBudget->type=='Budget'?$this->oReference->id:'Budget';?> Apr-Mar</th>
						<th>Diff</th>
					<?php
						$this->colspan += 4;
					}					
					if (strpos($this->oBudget->type,'FYE')!== false) {
					?>
					<th class='budget-ytd FYE_analysis'>YTD Actual</th>
					<th class='FYE_analysis'>YTD Budget</th>
					<th class='FYE_analysis'>Diff</th>
					<th class='FYE_analysis'>%</th>
					<th class='budget-ytd FYE_analysis'>ROY Est</th>
					<th class='FYE_analysis'>ROY Budget</th>
					<th class='FYE_analysis'>Diff</th>
					<th>%</th>
					<?php
						$this->colspan += 8;
					}
					?>
				</tr>
			</thead>			
			<tbody>
			<?php
			return ($this->_processFLData($rs));
	}
	
	private function _firstLevelQuarterly($sql, $firstLevelTitle){	
		
		$tableID = $this->ID?$this->ID:"QR_".md5($sql);
		
		$this->colspan = 14;
		
		try {
			$rs = $this->oSQL->q($sql);
		} catch (Exception $e) {
				echo "<div class='error'>SQL error:</div>";
				echo "<pre>",$sql,"</pre>";
				return (false);
		};
			?>
			<table id='<?php echo $tableID;?>' class='budget'>
			<caption><?php echo $this->caption;?></caption>
			<thead>
				<tr>
					<th rowspan="2"><?php echo $firstLevelTitle; ?></th>
					<th rowspan="2">Account</th>					
					<th colspan="4"><?php echo $this->oReference->year;?></th>
					<th colspan="4"><?php echo $this->oBudget->year;?></th>
					<th rowspan="2" class='budget-ytd'><?php echo strpos($this->oBudget->type,'Budget')!==false?'Budget':'FYE';?></th>
					<th rowspan="2" ><?php echo (strpos($this->oBudget->type,'Budget')!==false)?$this->oReference->id:'Budget';?></th>
					<th rowspan="2">Diff</th>
					<th rowspan="2">%</th>
				</tr>
				<tr>
					<?php 						
						echo $this->oBudget->getTableHeader('quarterly');
						echo $this->oBudget->getTableHeader('quarterly');
					?>		
				</tr>
			</thead>			
			<tbody>
			<?php
			return ($this->_processFLData($rs));
	}
	
	private function firstLevelReportMR($sql, $firstLevelTitle, $oBudget=null){
		global $oSQL;				
		
		$tableID = "FLR_".md5($sql);
		
		if (!$rs = $oSQL->q($sql)){
				echo "<div class='error'>SQL error:</div>";
				echo "<pre>$sql</pre>";
				return (false);
			};
			?>
			<table id='<?php echo $tableID;?>' class='budget'>
			<caption><?php echo $this->caption;?></caption>
			<thead>
				<tr>
					<th rowspan="2"><?php echo $firstLevelTitle; ?></th>
					<th rowspan="2">Account</th>
					<?php echo $this->oBudget->getTableHeader('mr'); 							
					?>					
			</thead>			
			<tbody>
			<?php
			return ($this->_processFLData($rs));
	}
	
	public function productivityReport(){
		$sqlWhere = $this->sqlWhere;
		$this->columns = Array('Total','Total_AM','estimate','estimate_AM','YTD_A','YTD_B','ROY_A','ROY_B');
		$this->sqlSelect = "";
		for ($m = 1;$m<=15;$m++){
			$this->columns[] = $this->oBudget->arrPeriod[$m];
		}
		for ($q = 1;$q<=5;$q++){
			$this->columns[] = 'Q'.$q;
		}
		foreach($this->columns as $i=>$field){
			$this->sqlSelect .= ($this->sqlSelect?",\r\n":"")."SUM(`{$field}`) as '{$field}'";
		}
		
		$strFields = $this->_getPeriodicFields(Array('denominator'=>1));
		$strGPFilter = "Group_code=".self::GP_CODE; 
		$sqlMeasure = "customer_group_title as 'Level1_title'
						, customer_group_code as 'level1_code', `Budget item`, `Group` as `level2_title`, `Group_code` as `level2_code`,`itmOrder`,";
		$strGroupTitle = 'Customer group';			
		$sqlGroup = "GROUP BY Level1_title, level1_code, `level2_title`, `level2_code`";
		$sqlOrder = "ORDER BY `level1_code` ASC";

		
		ob_start();
				$sql = "SELECT customer_group_title as 'Level1_title', customer_group_code as 'level1_code', `unit` as `level2_title`, `unit` as `level2_code`,
					{$strFields['actual']}
			FROM `vw_sales`			
			{$sqlWhere}  
				AND scenario='{$strFields['from_a']}' 
				
			GROUP BY level1_code,level2_code
			UNION ALL
				SELECT customer_group_title as 'Level1_title', customer_group_code as 'level1_code', `unit` as `level2_title`, `unit` as `level2_code`,
				{$strFields['budget']}
			FROM `vw_sales`				
			{$sqlWhere} 
				AND scenario='{$strFields['from_b']}' 
				
			GROUP BY level1_code,level2_code	
			";
		
		$sql = "SELECT `Level1_title`, `level1_code`, `level2_title`, `level2_code`,
					{$this->sqlSelect}
				FROM ({$sql}) U 
				{$sqlGroup} 
				{$sqlOrder}";
		
		$rs = $this->oSQL->q($sql);
		
		while ($rw=$this->oSQL->f($rs)){
				
			$l1Code = (string)$rw['level1_code'];
			$arrSubreport[$l1Code][$rw['level2_code']] = Array('Level1_title'=>$rw['Level1_title'],'Budget item'=>$rw['level2_title'],'level1_code'=>$l1Code);
			
			for($i=0;$i<count($this->columns);$i++){
				$arrSubreport[$l1Code][$rw['level2_code']][$this->columns[$i]] += $rw[$this->columns[$i]];
				$arrTotal[$rw['level2_code']]['Budget item'] = 'Total '.$rw['level2_title'];
				$arrTotal[$rw['level2_code']][$this->columns[$i]] += $rw[$this->columns[$i]];
			}		
		}
		
		
		$strFields = $this->_getPeriodicFields();
		$sql = "SELECT {$sqlMeasure}
					{$strFields['actual']}
			FROM `vw_master`			
			{$sqlWhere}  
				AND scenario='{$strFields['from_a']}' 
				AND {$strGPFilter}
			{$sqlGroup}	
			UNION ALL
				SELECT {$sqlMeasure}
				{$strFields['budget']}
			FROM `vw_master`				
			{$sqlWhere} 
				AND scenario='{$strFields['from_b']}' 
				AND {$strGPFilter}
			{$sqlGroup}			
			";
		
		$sql = "SELECT `Level1_title`, `level1_code`, `level2_title`, `level2_code`,`itmOrder`,
					{$this->sqlSelect}
				FROM ({$sql}) U 
				{$sqlGroup} 
				{$sqlOrder}";
		
		$rs = $this->oSQL->q($sql);
		
		while ($rw=$this->oSQL->f($rs)){
			
			foreach ($rw as $key=>$value){
				$arrGrandTotal[$key] += $value;
			}
			
			$l1Code = (string)$rw['level1_code'];
			$arrSubreport[$l1Code][$rw['level2_code']] = Array('Level1_title'=>$rw['Level1_title'],'Budget item'=>$rw['level2_title'],'level1_code'=>$l1Code);
			
			for($i=0;$i<count($this->columns);$i++){
				$arrSubreport[$l1Code][$rw['level2_code']][$this->columns[$i]] += $rw[$this->columns[$i]];
			}
								
			$arrSort[$l1Code]['value'] += $rw['YTD_A']+$rw['YTD_B']+$rw['Total_AM']+$rw['estimate_AM'];	
			//if (!$template) $template = $rw;
			
		}
		
		foreach($arrSubreport as $l1Code=>$data){
			if($this->filter['activity']==53){
				//Profitability per Container
				$arrSubreport[$l1Code]['ratio'] = Array('Level1_title'=>$data['Level1_title'],'Budget item'=>"GP per Cntr",'level1_code'=>$l1Code,'class'=>'budget-ratio');
				for($i=0;$i<count($this->columns);$i++){
					if ($arrSubreport[$l1Code]['Cont.'][$this->columns[$i]]) {
						$arrSubreport[$l1Code]['ratio'][$this->columns[$i]] = $arrSubreport[$l1Code]['94'][$this->columns[$i]]/$arrSubreport[$l1Code]['Cont.'][$this->columns[$i]];
					} else {
						$arrSubreport[$l1Code]['ratio'][$this->columns[$i]] = 'n/a';
					}
				}
			} else {
				//Profitability per TEU
				$arrSubreport[$l1Code]['ratio'] = Array('Level1_title'=>$data['Level1_title'],'Budget item'=>"GP per TEU",'level1_code'=>$l1Code,'class'=>'budget-ratio');
				for($i=0;$i<count($this->columns);$i++){
					if ($arrSubreport[$l1Code]['TEU'][$this->columns[$i]]) {
						$arrSubreport[$l1Code]['ratio'][$this->columns[$i]] = $arrSubreport[$l1Code]['94'][$this->columns[$i]]/$arrSubreport[$l1Code]['TEU'][$this->columns[$i]];
					} else {
						$arrSubreport[$l1Code]['ratio'][$this->columns[$i]] = 'n/a';
					}
				}
			}
		}
		
		arsort($arrSort);
		foreach ($arrSort as $key=>$value){
			$arrReport[$key] = $arrSubreport[$key];
		}		
				
		?>
		<table id='<?php echo $this->ID;?>' class='budget'>
			<caption><?php echo $this->caption;?></caption>
			<thead>
				<tr>
					<th><?php echo $firstLevelTitle; ?></th>
					<th>Account</th>					
					<?php 
						echo $this->oBudget->getTableHeader('monthly',1+$this->oBudget->offset,12+$this->oBudget->offset);
						echo $this->oBudget->getTableHeader('quarterly');
					?>		
					<th class='budget-ytd'><?php echo strpos($this->oBudget->type,'Budget')!==false?'Budget':'FYE';?></th>
					<th><?php echo strpos($this->oBudget->type,'Budget')!==false?$this->oReference->id:'Budget';?></th>
					<th>Diff</th>
					<th>%</th>
					<?php 
					if ($this->oBudget->length>12){
					?>
						<th class='budget-monthly'>Jan+</th>
						<th class='budget-monthly'>Feb+</th>
						<th class='budget-monthly'>Mar+</th>
						<th class='budget-quarterly'>Q5(Jan-Mar)</th>
						<th class='budget-ytd'><?php echo $this->oBudget->type=='Budget'?'Budget':'FYE';?> Apr-Mar</th>
						<th><?php echo $this->oBudget->type=='Budget'?$this->oReference->id:'Budget';?> Apr-Mar</th>
						<th>Diff</th>
					<?php
						$this->colspan += 4;
					}					
					if (strpos($this->oBudget->type,'FYE')!== false) {
					?>
					<th class='budget-ytd FYE_analysis'>YTD Actual</th>
					<th class='FYE_analysis'>YTD Budget</th>
					<th class='FYE_analysis'>Diff</th>
					<th class='FYE_analysis'>%</th>
					<th class='budget-ytd FYE_analysis'>ROY Est</th>
					<th class='FYE_analysis'>ROY Budget</th>
					<th class='FYE_analysis'>Diff</th>
					<th>%</th>
					<?php
						$this->colspan += 8;
					}
					?>
				</tr>
			</thead>			
			<tbody>
		<?php
		foreach ($arrReport as $key=>$data){			
			$this->echoBudgetItemString($data, 'budget-item',false);
		}
		$this->echoBudgetItemString($arrTotal, 'budget-subtotal');
		$this->_getOtherFinancials('','','',Array('headcount'=>true));
		?>
		</tbody>
		</table>
		<?php
		$this->_echoButtonCopyTable($this->ID);
		
		return ($arrGrandTotal);
	}
	
	private function _processFLData($rs){
		if ($this->oSQL->num_rows($rs)){
				$Level1_title = '';		
				
				while ($rw=$this->oSQL->f($rs)){
					
					foreach ($rw as $key=>$value){
						$arrGrandTotal[$key] += $value;
					}
					
					$l1Code = (string)$rw['level1_code'];
					$arrSubreport[$l1Code][$rw['level2_code']] = Array('Level1_title'=>$rw['Level1_title'],'Budget item'=>$rw['level2_title'],'level1_code'=>$l1Code);
					
					foreach($this->columns as $column){
						$arrSubreport[$l1Code][$rw['level2_code']][$column]+=$rw[$column];	
					}
					
					/*
					for ($m=1;$m<=15;$m++){						
						$month = $this->oBudget->arrPeriod[$m];
						$arrSubreport[$l1Code][$rw['level2_code']][$month]+=$rw[$month];
						if ($m<=5){
							$arrSubreport[$l1Code][$rw['level2_code']]['Q'.$m]+=$rw['Q'.$m];
							$arrSubreport[$l1Code][$rw['level2_code']]['Q'.$m.'_B']+=$rw['Q'.$m.'_B'];
						};						
					};
					
					$arrSubreport[$l1Code][$rw['level2_code']]['ROY_A']+=$rw['ROY_A'];
					$arrSubreport[$l1Code][$rw['level2_code']]['ROY_B']+=$rw['ROY_B'];
					$arrSubreport[$l1Code][$rw['level2_code']]['Total']+=$rw['Total'];
					$arrSubreport[$l1Code][$rw['level2_code']]['Total_AM']+=$rw['Total_AM'];
					$arrSubreport[$l1Code][$rw['level2_code']]['estimate']+=$rw['estimate'];
					$arrSubreport[$l1Code][$rw['level2_code']]['estimate_AM']+=$rw['estimate_AM'];
					$arrSubreport[$l1Code][$rw['level2_code']]['Total_AprMar']+=$rw['Total_AprMar'];
					$arrSubreport[$l1Code][$rw['level2_code']]['Total_15']+=$rw['Total_15'];
					
					$arrSubreport[$l1Code][$rw['level2_code']]['CM_A'] += $rw['CM_A'];
					$arrSubreport[$l1Code][$rw['level2_code']]['CM_B'] += $rw['CM_B'];
					$arrSubreport[$l1Code][$rw['level2_code']]['YTD_A'] += $rw['YTD_A'];
					$arrSubreport[$l1Code][$rw['level2_code']]['YTD_B'] += $rw['YTD_B'];
					$arrSubreport[$l1Code][$rw['level2_code']]['Q_A'] += $rw['Q_A'];
					$arrSubreport[$l1Code][$rw['level2_code']]['Q_B'] += $rw['Q_B'];
					$arrSubreport[$l1Code][$rw['level2_code']]['NM_A'] += $rw['NM_A'];
					$arrSubreport[$l1Code][$rw['level2_code']]['NM_B'] += $rw['NM_B'];
					$arrSubreport[$l1Code][$rw['level2_code']]['FYE_A'] += $rw['FYE_A'];
					$arrSubreport[$l1Code][$rw['level2_code']]['FYE_B'] += $rw['FYE_B'];
					*/
					
					$arrSort[$l1Code]['value'] += $rw['YTD_A']+$rw['YTD_B']+$rw['Total_AM']+$rw['estimate_AM'];
					
					if (!$template) $template = $rw;
					
				}
							
				arsort($arrSort);
				foreach ($arrSort as $key=>$value){
					$arrReport[$key] = $arrSubreport[$key];
				}
				
				// echo '<pre>';print_r($arrReport);echo '</pre>';die();
				foreach ($arrReport as $key=>$data){
									
					// if(!$printed){
						// echo '<pre>';print_r($data);echo '</pre>';
						// $printed = true;
					// }
					
					$this->echoBudgetItemString($data, 'budget-item');
				}
				
					$arrGrandTotal['Budget item'] = 'Grand total';
					return ($arrGrandTotal);
			}
	}
	
	private function noFirstLevelReport_YACT($sqlWhere){
				
		global $oSQL;
		
		$strFields = self::_getPeriodicFields();
		
		$sql = "SELECT CONCAT(`account`,': ',`Title`) as `Budget item`, `item`, yact_group as `Group`, yact_group_code as `Group_code`, 
			{$strFields['actual']}
			FROM `vw_master`
			##LEFT JOIN tbl_scenario ON scnID=scenario
			$sqlWhere 
			GROUP BY `yact_group`, `account`
			ORDER BY `yact_group`, `account` ASC";
			
			// echo '<pre>',$sql,'</pre>';
			
			$group = '';
			$subtotal = Array();
			$grandTotal = Array();
			$rs = $oSQL->q($sql);
			while ($rw=$oSQL->f($rs)){
				
				if ($rw['Group_code']==self::GP_CODE){
					$tr_class = "budget-total";
				} else {
					$tr_class = 'budget-item';
				}
				
				if($group && $group!=$rw['Group']){
					$data = $subtotal[$group];
					$data['Budget item']=$group;
					$this->echoBudgetItemString($data,'budget-subtotal');
				}
				
				//------------------------Collecting subtotals---------------------------------------
				$local_subtotal = 0;
				for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
					$month = $this->oBudget->arrPeriod[$m];
					$subtotal[$rw['Group']][$month]+=$rw[$month];					
					$subtotal[$rw['Group']]['Q'.$m]+=$rw['Q'.$m];					
					$local_subtotal += $rw[$month];
					$grandTotal[$month] += $rw[$month];
					$grandTotal['Q'.$m] += $rw['Q'.$m];
				}
				$subtotal[$rw['Group']]['Total'] += $local_subtotal;
				$subtotal[$rw['Group']]['estimate'] += $rw['estimate'];
				$subtotal[$rw['Group']]['YTD_A'] += $rw['YTD_A'];
				$subtotal[$rw['Group']]['YTD'] += $rw['YTD'];
				$subtotal[$rw['Group']]['ROY_A'] += $rw['ROY_A'];
				$subtotal[$rw['Group']]['ROY_B'] += $rw['ROY_B'];
				
				$grandTotal['Total'] += $local_subtotal;
				$grandTotal['estimate'] += $rw['estimate'];
				$grandTotal['YTD_A'] += $rw['YTD_A'];
				$grandTotal['YTD'] += $rw['YTD'];
				$grandTotal['ROY_A'] += $rw['ROY_A'];
				$grandTotal['ROY_B'] += $rw['ROY_B'];
				
				$this->echoBudgetItemString($rw,$tr_class);				
				$group = $rw['Group'];
			}
			//last group subtotal
			$data = $subtotal[$group];
			$data['Budget item']=$group;
			$this->echoBudgetItemString($data,'budget-subtotal');
			//Grand total
			$data = $grandTotal;
			$data['Budget item']='Grand total';
			$this->echoBudgetItemString($data,'budget-grandtotal');
			
		//------ Operating income -------
		
		$sqlOps = str_replace($sqlWhere, $sqlWhere." AND (account NOT LIKE '6%' AND account NOT LIKE '7%' AND account NOT LIKE 'SZ%')", $sql);
		$sqlOps = str_replace('GROUP BY `yact_group`, `account`', '', $sqlOps);
		$rs = $oSQL->q($sqlOps);
		$rw = $oSQL->f($rs);
		$rw['Budget item'] = "Operating income";
		$this->echoBudgetItemString($rw,'budget-subtotal');
		
		
	}
	
	private function _nofirstLevelPeriodic($sqlWhere){
				
		$strFields = $this->_getPeriodicFields();	
		
		if ($this->YACT){
			$strAccountTitle = "title";
			$strAccountGroup = "yact_group";
			$strAccountCode = "account";
			$strGroupCode = 'yact_group_code';
			$strGPFilter = "yact_group_code IN ('449000','499000')"; 
			$sqlGroup = "GROUP BY `account`";
		} else {
			$strAccountTitle = "Budget item";
			$strAccountGroup = "Group";
			$strAccountCode = "item";
			$strGroupCode = 'Group_code';
			$strGPFilter = "Group_code=".self::GP_CODE; 
			$sqlGroup = "GROUP BY item, `Budget item`";
		}
			
		$sql = "SELECT {$this->sqlSelect},
				`Budget item`,`Group`, `item`, `Group_code`
			FROM 
				(SELECT `{$strAccountTitle}` as 'Budget item',`{$strAccountGroup}` as 'Group', `{$strAccountCode}` as 'item', {$strGroupCode} as Group_code,
						{$strFields['actual']}
				FROM `vw_master` 			
				{$sqlWhere} AND company='{$this->company}' AND scenario='{$this->oBudget->id}' AND `{$strAccountCode}` IS NOT NULL
				GROUP BY `{$strAccountCode}`
				UNION ALL
				SELECT `{$strAccountTitle}` as 'Budget item',`{$strAccountGroup}` as 'Group', `{$strAccountCode}` as 'item', {$strGroupCode} as Group_code,
						{$strFields['budget']}
				FROM `vw_master` 			
				{$sqlWhere} AND company='{$this->company}' AND scenario='{$this->oReference->id}' AND `{$strAccountCode}` IS NOT NULL 
				GROUP BY `{$strAccountCode}`) Q
			##GROUPING BY ITEM
			GROUP BY item, `Budget item`
			ORDER BY `Group` ASC			
			";
			
			// echo '<pre>',$sql,'</pre>';
			
			$group = '';
			$subtotal = Array();
			$grandTotal = Array();
			$rs = $this->oSQL->q($sql);
			while ($rw=$this->oSQL->f($rs)){
				
				if ($rw['Group_code']==self::GP_CODE){
					$tr_class = "budget-total";
				} else {
					$tr_class = 'budget-item';
				}
				
				if($group && $group!=$rw['Group']){
					$data = $subtotal[$group];
					$data['Budget item']=$group;
					$this->echoBudgetItemString($data,'budget-subtotal');
				}
				
				//------------------------Collecting subtotals---------------------------------------
				$local_subtotal = 0;

				if($rw['item']){
						
					foreach($this->columns as $i=>$field){
						$subtotal[$rw['Group']][$field] += $rw[$field];
						$grandTotal[$field] += $rw[$field];
					}
									
				}
								
				$this->echoBudgetItemString($rw,$tr_class);				
				$group = $rw['Group'];
			}
			//last group subtotal
			$data = $subtotal[$group];
			$data['Budget item']=$group;
			$this->echoBudgetItemString($data,'budget-subtotal');
			//Grand total
			$data = $grandTotal;
			$data['Budget item']='Profit before tax';
			$this->echoBudgetItemString($data,'budget-total');
			
		
		$this->_getOtherFinancials($sql,$sqlGroup,$sqlOrder,Array('summary'=>true,'kpi'=>true,'headcount'=>true));
		
	}
	
	private function _getOtherFinancials($sql,$sqlGroup,$sqlOrder,$options = Array()){
		
		$sqlWhere = $this->sqlWhere;
		$oSQL = $this->oSQL;
		
		if ($options['summary']){
			?>
			<tr><th colspan="<?php echo $this->colspan;?>">Other financials</th></tr>
			<?php							
			$arrOther[] = Array('title'=>'Gross revenue','sqlWhere'=>" AND (account = 'J00400')");
					
			if (!(isset($this->filter['customer']) || isset($this->filter['sales']) || isset($this->filter['bdv']))){
				$arrOther[] = Array('title'=>'Gross operatng profit','sqlWhere'=>self::GOP_FILTER);
				$arrOther[] = Array('title'=>'Net operatng profit','sqlWhere'=>" AND (account NOT LIKE '6%' AND account NOT LIKE '7%' AND account NOT LIKE 'SZ%')");	
				$arrOther[] = Array('title'=>'Own operatng profit','sqlWhere'=>self::OWN_OPERATING_PROFIT);	
			}
			
			if (!(isset($this->filter['customer']) || isset($this->filter['sales']) )){
				$arrOther[] = Array('title'=>'BD costs','sqlWhere'=>" AND (account = '5999BD')");				
			}
			
			for($i=0;$i<count($arrOther);$i++){
				$sqlOps = str_replace($sqlWhere, $sqlWhere.$arrOther[$i]['sqlWhere'], $sql);
				$nPos = strpos($sqlOps,"##GROUPING BY ITEM");
				if ($nPos!==false){
					$sqlOps = substr($sqlOps,0,$nPos);
				}
				
				if (!$rs = $oSQL->q($sqlOps)){
					echo 'Error: <pre>',$sqlOps,'</pre>';
				}
				while ($rw = $oSQL->f($rs)){
					$rw['Budget item'] = $arrOther[$i]['title'];
					$this->echoBudgetItemString($rw,$arrOther[$i]['class']);
				}
			}		
		}
		
		//------- KPIs -----------------
		if ($options['kpi']){		
			switch ($this->structure){
				case 'monthly':
				case 'forecast':
					$strFieldsKPI = self::_getMRFields(Array('currency'=>643,'denominator'=>1));
					break;
				case 'periodic':
				case 'quarterly':
				default:
					$strFieldsKPI = self::_getPeriodicFields(Array('currency'=>643,'denominator'=>1));
					break;
			}
			
			$sql = "SELECT activity, unit, 
						{$strFieldsKPI['actual']}
				FROM `reg_sales`			
				{$sqlWhere}  AND scenario='{$strFieldsKPI['from_a']}' AND kpi=1 AND posted=1 AND ".self::ACTUAL_DATA_FILTER."
				GROUP BY activity, unit
				UNION ALL
				SELECT activity, unit, 
						{$strFieldsKPI['next']}
				FROM `reg_sales`			
				{$sqlWhere}  AND scenario='{$strFieldsKPI['from_a']}' AND kpi=1 AND posted=1 AND source<>'Actual'
				GROUP BY activity, unit
				UNION ALL
					SELECT activity, unit, 
					{$strFieldsKPI['budget']}
				FROM `reg_sales`				
				{$sqlWhere} AND scenario='{$strFieldsKPI['from_b']}' AND kpi=1 AND posted=1 
				GROUP BY activity, unit
				ORDER BY activity, unit";
				
			$sql = "SELECT prtTitle, activity, unit, 
						{$this->sqlSelect}					
					FROM ($sql) U
					LEFT JOIN vw_product_type ON activity=prtID
					WHERE unit<>''
					GROUP BY activity, unit
					ORDER BY prtGHQ";
			// echo '<pre>',$sql,'</pre>';
			$rs = $oSQL->q($sql);
			if ($oSQL->n($rs)){
				?>
				<tr><th colspan="<?php echo $this->colspan;?>">Operational KPIs</th></tr>
				<?php		
				while ($rw = $oSQL->f($rs)){			
					$rw['Budget item'] = $rw['prtTitle']." ({$rw['unit']})";
					$filter = $this->filter;
					$filter['activity'] = $rw['activity'];
					$arrMetadata = Array('filter' => $filter, 'DataAction' => 'kpiByCustomer', 'title'=>$rw['prtTitle']);
					$rw['metadata'] = json_encode($arrMetadata);
					$rw['href'] = "javascript:getCustomerKPI(".json_encode($arrMetadata).");";
					$this->echoBudgetItemString($rw);
				}
			}
		}
		
		//------- Headcount -----------------
		if ($options['headcount']){
			if (!(isset($this->filter['customer']) || isset($this->filter['sales']) || isset($this->filter['bdv']))){
				$this->_getMRHeadcount($sqlWhere,'funTitle');
			}
		}
	}
	
	private function _noFirstLevelMonthly($currency=643, $options=Array()){
				
		global $oSQL;		
		$sqlWhere = $this->sqlWhere;
		
		$settings = Array('financial'=>true,'summary'=>true,'headcount'=>true,'kpi'=>true);
		foreach($options as $key=>$value){
			$settings[$key] = $value;
		}
		
		$strFields = self::_getMRFields($currency);
				
		$sqlGroup = "`Budget item`, `item`, `Group`, `Group_code`";
		$sqlOrder = "`Group`, `itmOrder` ASC";
		
		$sql = "SELECT `Budget item`, `item`, `Group`, `Group_code`,`itmOrder`, 
							{$strFields['actual']}
					FROM `vw_master`			
					{$sqlWhere}  AND scenario='{$strFields['from_a']}'
					GROUP BY {$sqlGroup}	
					UNION ALL
						SELECT `Budget item`, `item`, `Group`, `Group_code`,`itmOrder`, 
						{$strFields['budget']}
					FROM `vw_master`				
					{$sqlWhere} AND scenario='{$strFields['from_b']}' AND `item` IS NOT NULL
					GROUP BY {$sqlGroup}			
					ORDER BY {$sqlOrder}";
			
		echo '<tr class="sql" style="display:none;"><td><pre>',$sql,'</pre></td></tr>';
		
		$sql = self::_unionMRQueries($sql, $sqlGroup);
			
			$group = '';
			$subtotal = Array();
			$grandTotal = Array();
			$rs = $oSQL->q($sql);
			while ($rw=$oSQL->f($rs)){				
				if ($rw['Group_code']==94){
					$tr_class = "budget-total";
				} else {
					$tr_class = 'budget-item';
				}
				
				if($group && $group!=$rw['Group']){
					$data = $subtotal[$group];
					$data['Budget item']=$group;
					$this->echoBudgetItemString($data,'budget-subtotal');
				}
				
				if ($rw['Budget item']){
					foreach($this->columns as $i=>$field){
						$subtotal[$rw['Group']][$field] += $rw[$field];
						$grandTotal[$field] += $rw[$field];
					}		
				}
				
				$this->echoBudgetItemString($rw,$tr_class);				
				$group = $rw['Group'];
			}
			//last group subtotal
			$data = $subtotal[$group];
			$data['Budget item']=$group;
			$this->echoBudgetItemString($data,'budget-subtotal');
			//Grand total
			$data = $grandTotal;
			$data['Budget item']='Profit before tax';
			$this->echoBudgetItemString($data,'budget-total');
		
		$this->_getOtherFinancials($sql,$sqlGroup,$sqlOrder, $settings);
		
	}
	
	private function _getMRHeadcount($sqlWhere, $type='collars'){
		
		switch ($this->structure){
			case 'monthly':
			case 'budget':
			case 'forecast':
				$strFieldsKPI = self::_getMRFields(Array('currency'=>643,'denominator'=>1));
				break;
			case 'periodic':
			default:
				$strFieldsKPI = self::_getPeriodicFields(Array('currency'=>643,'denominator'=>1));
				break;
		}
		
		switch($type){
			case 'funRHQ':
				$field = "IF(funRHQ='',funTitleLocal, funRHQ)";
				$groupBy = "IF(funRHQ='',funTitleLocal, funRHQ)";	
				break;
			case 'funTitle':
				$field = "funTitle$strLocal";
				$groupBy = "funTitle$strLocal";	
				break;
			default:
				$field = "IF(`wc`=1,'White collars','Blue collars')";
				$groupBy = 'wc';
				break;
		}
		
		$sql = "SELECT  {$field} as `Budget item`, 
					{$strFieldsKPI['actual']}
			FROM `vw_headcount`			
			{$sqlWhere}  AND scenario='{$strFieldsKPI['from_a']}' AND ".self::ACTUAL_DATA_FILTER." AND salary>".self::SALARY_THRESHOLD."
			GROUP BY  {$groupBy}
			UNION ALL
			SELECT   {$field}, 
					{$strFieldsKPI['next']}
			FROM `vw_headcount`			
			{$sqlWhere}  AND scenario='{$strFieldsKPI['from_a']}' AND source<>'Actual' AND salary>".self::SALARY_THRESHOLD."
			GROUP BY  {$groupBy}
			UNION ALL
				SELECT   {$field}, 
				{$strFieldsKPI['budget']}
			FROM `vw_headcount`				
			{$sqlWhere} AND scenario='{$strFieldsKPI['from_b']}' AND salary>".self::SALARY_THRESHOLD."
			GROUP BY  {$groupBy}
			";
			
		$sql = "SELECT  `Budget item`, 
					{$this->sqlSelect}					
				FROM ($sql) U	
				GROUP BY `Budget item`
				ORDER BY `Budget item`";
		// echo '<pre>',$sql,'</pre>';
		
		$cm = $this->oBudget->cm;
		
		$rs = $this->oSQL->q($sql);
		if (!$this->oSQL->n($rs)){
			// echo '<pre>',$sql,'</pre>';
			?>
			<tr><td colspan="<?php echo $this->colspan;?>">No headcount data</td></tr>
			<?php
		} else {
			?>
			<tr><th colspan="<?php echo $this->colspan;?>">Headcount</th></tr>
			<?php
			while ($rw = $this->oSQL->f($rs)){			
				// $rw['Budget item'] = $rw['wc']?"White collars":"Blue collars";
				
				$monthsYTD = $cm-$this->oBudget->offset;
				
				if($monthsYTD){
					$rw['YTD_A'] = $rw['YTD_A']/($monthsYTD);
					$rw['YTD_B'] = $rw['YTD_B']/($monthsYTD);
				}
				
				$rw['Q_A'] = $rw['Q_A']/3;
				$rw['Q_B'] = $rw['Q_B']/3;
				
				$rw['FYE_A'] = $rw['FYE_A']/12;
				$rw['FYE_B'] = $rw['FYE_B']/12;
				
				for($q=1;$q<=5;$q++){
					$rw["Q$q"] = $rw["Q$q"]/3;
				}
				
				$rw['Total_AM'] = $rw['Total_AM']/12;
				$rw['estimate_AM'] = $rw['estimate_AM']/12;
				$rw['Total'] = $rw['Total']/12;
				$rw['estimate'] = $rw['estimate']/12;
				
				if(12-($cm-$this->oBudget->offset)){
					$rw['ROY_A'] = $rw['ROY_A']/(12-($cm-$this->oBudget->offset));
					$rw['ROY_B'] = $rw['ROY_B']/(12-($cm-$this->oBudget->offset));
				}
				
				foreach($this->columns as $i=>$field){
					$grandTotal[$field] +=$rw[$field];
				}
				
				$this->echoBudgetItemString($rw);
			}
			$grandTotal['Budget item'] = 'Total headcount';
			$this->echoBudgetItemString($grandTotal,'budget-subtotal');
		}
	}
	
	public function kpiByCustomerMR(){
		
		GLOBAL $oSQL;
		
		$sqlWhere = $this->sqlWhere;
		$strFields = self::_getMRFields(643);
		
		
		$sql = "SELECT customer,cntTitle, customer_group_code,customer_group_title, 
					{$strFields['actual']}
			FROM `vw_sales`			
			{$sqlWhere}  AND scenario='{$strFields['from_a']}' AND kpi=1 AND posted=1 AND ".self::ACTUAL_DATA_FILTER."
			GROUP BY customer
			UNION ALL
			SELECT customer,cntTitle, customer_group_code,customer_group_title, 
					{$strFields['next']}
			FROM `vw_sales`			
			{$sqlWhere}  AND scenario='{$strFields['from_a']}' AND kpi=1 AND posted=1 AND source<>'Actual'
			GROUP BY customer
			UNION ALL
				SELECT customer,cntTitle, customer_group_code,customer_group_title , 
				{$strFields['budget']}
			FROM `vw_sales`				
			{$sqlWhere} AND scenario='{$strFields['from_b']}' AND kpi=1 AND posted=1 
			GROUP BY customer
			ORDER BY customer";
			
		$sql = "SELECT cntTitle, CASE WHEN customer_group_code=".self::CNT_GROUP_EXEMPTION." THEN cntTitle ELSE CONCAT('&#x1F4C2;',customer_group_title) END as 'Customer_name',
					SUM(CM_A) as CM_A,
					SUM(CM_B) as CM_B,
					SUM(Q_A) as Q_A,
					SUM(Q_B) as Q_B,
					SUM(YTD_A) as YTD_A,
					SUM(YTD_B) as YTD_B,
					SUM(NM_A) as NM_A,
					SUM(NM_B) as NM_B					
				FROM ($sql) U
				##LEFT JOIN common_db.tbl_counterparty ON customer=cntID
				WHERE customer IS NOT NULL
				GROUP BY Customer_name
				ORDER BY CM_A DESC, CM_B DESC";
		// echo '<pre>',$sql,'</pre>';		
		$rs = $oSQL->q($sql);
		if ($oSQL->n($rs)){		
			$tableID = "KPI_".md5($sql);
			?>
			<table id='<?php echo $tableID;?>' class='budget'>
			<thead>
				<tr>
					<th colspan="2" rowspan="2">Customer</th>					
					<?php echo $this->oBudget->getTableHeader('mr'); 							
					?>					
			</thead>			
			<tbody>
			<?php
			while ($rw = $oSQL->f($rs)){			
				$rw['Budget item'] = $rw['Customer_name'];
				$this->echoBudgetItemString($rw);
				foreach ($rw as $key=>$value){
					$arrSubtotal[$key] += $value;
				}
			}
			$arrSubtotal['Budget item'] = "Total";
			?>
			</tbody>
			<tfoot>
			<?php
				$this->echoBudgetItemString($arrSubtotal, 'budget-subtotal');
			?>
			</tfoot>
			</table>			
			<?php
			$this->_echoButtonCopyTable($tableID);
		} else {
			echo '<h3>No records found</h3>';
			echo '<pre>',$sql,'</pre>';
		}
			
	}
	
	private function _getPeriodicFields($params=Array()){
		
		$currency = $params['currency']?$params['currency']:$this->Currency;
		$denominator = $params['denominator']?$params['denominator']:$this->Denominator;
		
		$arrRates = $this->oBudget->getMonthlyRates($currency);
		
		$cm = $this->oBudget->cm;
		$nm = $this->oBudget->nm;
		
		$arrRates = $this->oBudget->getMonthlyRates($currency);
		
		$res['actual']=	$this->oBudget->getMonthlySumSQL(1,15,$arrRates, $denominator).", \r\n".
					$this->oBudget->getQuarterlySumSQL($arrRates, $denominator).", \r\n 
					SUM(".$this->oBudget->getYTDSQL(1+$this->oBudget->offset,12+$this->oBudget->offset,$arrRates, $denominator).") as Total,\r\n
					SUM(".$this->oBudget->getYTDSQL(1,12,$arrRates, $denominator).") as Total_JD ,\r\n
					SUM(".$this->oBudget->getYTDSQL(4,15,$arrRates, $denominator).") as Total_AM ,\r\n
					0 as estimate, 
					0 as estimate_JD, 
					0 as estimate_AM, 
					SUM(".$this->oBudget->getYTDSQL(1+$this->oBudget->offset, $cm ,$arrRates, $denominator).") as YTD_A, 
					0 as YTD_B, 
					SUM(".$this->oBudget->getYTDSQL($nm, 12+$this->oBudget->offset,$arrRates, $denominator).") as ROY_A, 
					0 as ROY_B,
					0 as Q1_B,
					0 as Q2_B,
					0 as Q3_B,
					0 as Q4_B,
					0 as Q5_B";
		
		$res['next'] = $res['actual'];
		
		$arrRates = $this->oReference->getMonthlyRates($currency);
		
		$res['budget']=	str_repeat('0,',15)." \r\n".
					str_repeat('0,',5)." \r\n
					0 as Total, \r\n
					0 as Total_JD, \r\n
					0 as Total_AM, \r\n
					SUM(".$this->oBudget->getYTDSQL(1+$this->oBudget->offset,12+$this->oBudget->offset,$arrRates, $denominator).") as estimate ,
					SUM(".$this->oBudget->getYTDSQL(1,12,$arrRates, $denominator).") as estimate_JD ,
					SUM(".$this->oBudget->getYTDSQL(4,15,$arrRates, $denominator).") as estimate_AM ,
					0 as YTD_A,
					SUM(".$this->oBudget->getYTDSQL(1+$this->oBudget->offset, $cm ,$arrRates, $denominator).") as YTD_B, 
					0 as ROY_A,
					SUM(".$this->oBudget->getYTDSQL($nm,12+$this->oBudget->offset,$arrRates, $denominator).") as ROY_B,
					".$this->oBudget->getQuarterlySumSQL($arrRates, $denominator,'_B')."\r\n ";
		
		// echo '<pre>';print_r($arrRates);echo '</pre>';
		
		$res['from_a'] = $this->oBudget->id;
		$res['from_b'] = $this->oReference->id;
		
		return ($res);
		
	}
	
	private function _getMRFields($params=Array()){
		
		$currency = $params['currency']?$params['currency']:$this->Currency;
		$denominator = $params['denominator']?$params['denominator']:$this->Denominator;
		
		$arrRates = $this->oBudget->getMonthlyRates($currency);
		
		$cm = $this->oBudget->arrPeriod[$this->oBudget->cm];
		$res['cm'] = $cm;
		$nm = $this->oBudget->arrPeriod[$this->oBudget->nm];
		$res['nm'] = $nm;		
		
		$sqlNM = $nm?"SUM(`$nm`)/{$arrRates[$nm]}/{$denominator}":"0";
		
		$nCurrent = $this->oBudget->cm;
		
		$res['actual']=	"SUM(`{$cm}`)/{$arrRates[$cm]}/{$denominator} as CM_A, 
						0 as CM_B,								
						SUM(".$this->oBudget->getYTDSQL(1+$this->oBudget->offset,$nCurrent,$arrRates).")/{$denominator} as YTD_A ,
						0 as YTD_B, 
						SUM(".$this->oBudget->getYTDSQL(max($nCurrent-2,1+$this->oBudget->offset),$nCurrent,$arrRates).")/{$denominator} as Q_A ,
						0 as Q_B, 
						{$sqlNM} as NM_A , 
						0 as NM_B,
						SUM(".$this->oBudget->getYTDSQL($nCurrent+1,12+$this->oBudget->offset,$arrRates).")/{$denominator} as ROY_A ,
						0 as ROY_B,
						SUM(".$this->oBudget->getYTDSQL(1+$this->oBudget->offset,12+$this->oBudget->offset,$arrRates).")/{$denominator} as FYE_A ,
						0 as FYE_B
						";
		$res['next']=	"0 as CM_A, 
						0 as CM_B,								
						0 as YTD_A ,
						0 as YTD_B,
						0 as Q_A,
						0 as Q_B,
						{$sqlNM} as NM_A , 
						0 as NM_B,
						SUM(".$this->oBudget->getYTDSQL($nCurrent+1,12+$this->oBudget->offset,$arrRates).")/{$denominator} as ROY_A,
						0 as ROY_B,
						SUM(".$this->oBudget->getYTDSQL(1+$this->oBudget->offset,12+$this->oBudget->offset,$arrRates).")/{$denominator} as FYE_A,
						0 as FYE_B";
		$res['budget'] = "0 as CM_A, 
						SUM(`{$cm}`)/{$arrRates[$cm]}/{$denominator} as CM_B,								
						0 as YTD_A,
						SUM(".$this->oBudget->getYTDSQL(1+$this->oBudget->offset,$nCurrent,$arrRates).")/{$denominator} as YTD_B, 
						0 as Q_A,
						SUM(".$this->oBudget->getYTDSQL(max($nCurrent-2,1+$this->oBudget->offset),$nCurrent,$arrRates).")/{$denominator} as Q_B, 
						0 as NM_A , 
						{$sqlNM} as NM_B,
						0 as ROY_A ,
						SUM(".$this->oBudget->getYTDSQL($nCurrent+1,12+$this->oBudget->offset,$arrRates).")/{$denominator} as ROY_B,
						0 as FYE_A ,
						SUM(".$this->oBudget->getYTDSQL(1+$this->oBudget->offset,12+$this->oBudget->offset,$arrRates).")/{$denominator} as FYE_B";
		
		$res['from_a'] = $this->oBudget->id;
		$res['from_b'] = $this->oReference->id;
		
		// echo '<pre>';print_r($res); echo '</pre>'; 
		
		return ($res);
		
	}
	
	private function _echoNumericTDs($data){
		
		// echo '<pre>';print_r($data);echo '</pre>';
	
		$local_subtotal = 0;
		$ytd = 0;
		$roy = 0;
		
		switch($this->structure){
			case 'quarterly':			
				?>
				<td class='budget-decimal <?php echo $this->oReference->flagPublic?"":"budget-cloak";?>'><?php self::render($data['Q2_B'],0);?></td>
				<td class='budget-decimal <?php echo $this->oReference->flagPublic?"":"budget-cloak";?>'><?php self::render($data['Q3_B'],0);?></td>
				<td class='budget-decimal <?php echo $this->oReference->flagPublic?"":"budget-cloak";?>'><?php self::render($data['Q4_B'],0);?></td>
				<td class='budget-decimal <?php echo $this->oReference->flagPublic?"":"budget-cloak";?>'><?php self::render($data['Q5_B'],0);?></td>
				<td class='budget-decimal <?php echo $this->oBudget->flagPublic?"":"budget-cloak";?>'><?php self::render($data['Q2'],0);?></td>
				<td class='budget-decimal <?php echo $this->oBudget->flagPublic?"":"budget-cloak";?>'><?php self::render($data['Q3'],0);?></td>
				<td class='budget-decimal <?php echo $this->oBudget->flagPublic?"":"budget-cloak";?>'><?php self::render($data['Q4'],0);?></td>
				<td class='budget-decimal <?php echo $this->oBudget->flagPublic?"":"budget-cloak";?>'><?php self::render($data['Q5'],0);?></td>
				<td class='budget-decimal budget-ytd<?php echo $this->oReference->flagPublic?"":"budget-cloak";?>'><?php self::render($data['Total_AM'],0);?></td>
				<td class='budget-decimal budget-ytd<?php echo $this->oReference->flagPublic?"":"budget-cloak";?>'><?php self::render($data['estimate_AM'],0);?></td>
				<td class='budget-decimal <?php echo $this->oBudget->flagPublic?"":"budget-cloak";?>'><?php self::render($data['Total_AM']-$data['estimate_AM'],0);?></td>
				<td class='budget-decimal <?php echo $this->oBudget->flagPublic?"":"budget-cloak";?>'><em><?php self::render_ratio($data['Total_AM'],$data['estimate_AM'],0);?></em></td>
				<?php
				break;
			case 'monthly':
			?>
				<td class='budget-decimal budget-quarterly <?php echo $this->oBudget->flagPublic?"":"budget-cloak";?>'><?php self::render($data['CM_A'],0);?></td>
				<td class='budget-decimal <?php echo $this->oReference->flagPublic?"":"budget-cloak";?>'><?php self::render($data['CM_B'],0);?></td>
				<td class='budget-decimal <?php echo $this->oBudget->flagPublic?"":"budget-cloak";?>'><?php self::render($data['CM_A']-$data['CM_B'],0);?></td>
				<td class='budget-decimal <?php echo $this->oBudget->flagPublic?"":"budget-cloak";?>'><em><?php self::render_ratio($data['CM_A'],$data['CM_B'],0);?></em></td>
				<?php
				if (!($this->oBudget->cm % 3) && $this->oBudget->cm>6){
				?>
				<td class='budget-decimal budget-quarterly <?php echo $this->oBudget->flagPublic?"":"budget-cloak";?>'><?php self::render($data['Q_A'],0);?></td>
				<td class='budget-decimal <?php echo $this->oReference->flagPublic?"":"budget-cloak";?>'><?php self::render($data['Q_B'],0);?></td>
				<td class='budget-decimal <?php echo $this->oBudget->flagPublic?"":"budget-cloak";?>'><?php self::render($data['Q_A']-$data['Q_B'],0);?></td>
				<td class='budget-decimal <?php echo $this->oBudget->flagPublic?"":"budget-cloak";?>'><em><?php self::render_ratio($data['Q_A'],$data['Q_B'],0);?></em></td>
				<?php
				}
				?>	
				<td class='budget-decimal budget-ytd <?php echo $this->oBudget->flagPublic?"":"budget-cloak";?>'><?php self::render($data['YTD_A'],0);?></td>
				<td class='budget-decimal  <?php echo $this->oReference->flagPublic?"":"budget-cloak";?>'><?php self::render($data['YTD_B'],0);?></td>
				<td class='budget-decimal <?php echo $this->oBudget->flagPublic?"":"budget-cloak";?>'><?php self::render($data['YTD_A']-$data['YTD_B'],0);?></td>
				<td class='budget-decimal <?php echo $this->oBudget->flagPublic?"":"budget-cloak";?>'><em><?php self::render_ratio($data['YTD_A'],$data['YTD_B'],0);?></em></td>
				
				<td class='budget-decimal budget-quarterly'><?php self::render($data['NM_A'],0);?></td>
				<td class='budget-decimal'><?php self::render($data['NM_B'],0);?></td>
				<td class='budget-decimal'><?php self::render($data['NM_A']-$data['NM_B'],0);?></td>
				<td class='budget-decimal'><em><?php self::render_ratio($data['NM_A'],$data['NM_B'],0);?></em></td>
				<?php		
				if (!($this->oBudget->nm % 3)){
				?>
				<td class='budget-decimal budget-ytd'><?php self::render($data['FYE_A'],0);?></td>
				<td class='budget-decimal'><?php self::render($data['FYE_B'],0);?></td>
				<td class='budget-decimal'><?php self::render($data['FYE_A']-$data['FYE_B'],0);?></td>
				<td class='budget-decimal'><em><?php self::render_ratio($data['FYE_A'],$data['FYE_B'],0);?></em></td>
				<?php
				}
				break;
			case 'forecast':
				?>		
				<td class='budget-decimal budget-ytd <?php echo $this->oBudget->flagPublic?"":"budget-cloak";?>'><?php self::render($data['YTD_A'],0);?></td>
				<td class='budget-decimal  <?php echo $this->oReference->flagPublic?"":"budget-cloak";?>'><?php self::render($data['YTD_B'],0);?></td>
				<td class='budget-decimal <?php echo $this->oBudget->flagPublic?"":"budget-cloak";?>'><?php self::render($data['YTD_A']-$data['YTD_B'],0);?></td>
				<td class='budget-decimal <?php echo $this->oBudget->flagPublic?"":"budget-cloak";?>'><em><?php self::render_ratio($data['YTD_A'],$data['YTD_B'],0);?></em></td>
				
				<td class='budget-decimal budget-quarterly'><?php self::render($data['ROY_A'],0);?></td>
				<td class='budget-decimal'><?php self::render($data['ROY_B'],0);?></td>
				<td class='budget-decimal'><?php self::render($data['ROY_A']-$data['ROY_B'],0);?></td>
				<td class='budget-decimal'><em><?php self::render_ratio($data['ROY_A'],$data['ROY_B'],0);?></em></td>
				
				<td class='budget-decimal budget-ytd'><?php self::render($data['FYE_A'],0);?></td>
				<td class='budget-decimal'><?php self::render($data['FYE_B'],0);?></td>
				<td class='budget-decimal'><?php self::render($data['FYE_A']-$data['FYE_B'],0);?></td>
				<td class='budget-decimal'><em><?php self::render_ratio($data['FYE_A'],$data['FYE_B'],0);?></em></td>
				<?php
				break;
			case 'budget':
				?>
				<td class='budget-decimal budget-ytd'><?php self::render($data['FYE_A'],0);?></td>
				<td class='budget-decimal'><?php self::render($data['FYE_B'],0);?></td>
				<td class='budget-decimal'><?php self::render($data['FYE_A']-$data['FYE_B'],0);?></td>
				<td class='budget-decimal'><em><?php self::render_ratio($data['FYE_A'],$data['FYE_B'],0);?></em></td>
				<?php
				break;
			case 'periodic':
			default:
					
				for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
					// $month = $this->oBudget->arrPeriod[$m];
					$month = $this->oBudget->arrPeriod[$m];
					?>
					<td class='budget-decimal budget-monthly budget-<?php echo $month;?> <?php echo !$this->oBudget->flagPublic && $m<=$this->oBudget->cm?"budget-cloak":"";?>'><?php self::render($data[$month],0);?></td>
					<?php
				}
					
				for ($q=1+$this->oBudget->offset/3;$q<5+$this->oBudget->offset/3;$q++){
						?>
						<td class='budget-decimal budget-quarterly budget-<?php echo 'q'.$q;?>'><?php self::render($data['Q'.$q],0);?></td>
						<?php
					}
				
				?>
				<td class='budget-decimal budget-ytd'><?php self::render($data['Total'],0);?></td>			
				<?php 
				if (isset($data['estimate'])){
					?>
					<td class='budget-decimal'><?php self::render($data['estimate'],0);?></td>
					<td class='budget-decimal'><?php self::render($data['Total']-$data['estimate'],0);?></td>
					<td class='budget-decimal'><em><?php self::render_ratio($data['Total'],$data['estimate'],0);?></em></td>
					<?php 
					if ($this->oBudget->length>12){ 
						
						for ($m=13;$m<=15;$m++){
							// $month = $this->oBudget->arrPeriod[$m];
							$month = $this->oBudget->arrPeriod[$m];
							?>
							<td class='budget-decimal budget-monthly budget-<?php echo $month;?>'><?php self::render($data[$month],0);?></td>
							<?php
							}
						?>
						<td class='budget-decimal budget-quarterly '><?php self::render($data['Q5'],0);?></td>				
						<td class='budget-decimal budget-ytd'><?php self::render($data['Total_AM'],0);?></td>				
						<td class='budget-decimal'><?php self::render($data['estimate_AM'],0);?></td>				
						<td class='budget-decimal'><?php self::render($data['Total_AM'] - $data['estimate_AM'],0);?></td>				
					<?php };
					if (strpos($this->oBudget->type,'FYE')!== false || strpos($this->oBudget->type,'Actual')!==false){ 
					?>					
						<!--Data for YTD actual-->
						<td class='budget-decimal budget-ytd <?php echo $this->oBudget->flagPublic?"":"budget-cloak";?>'><?php self::render($data['YTD_A'],0);?></td>
						<td class='budget-decimal'><?php self::render($data['YTD_B'],0);?></td>
						<td class='budget-decimal <?php echo $this->oBudget->flagPublic?"":"budget-cloak";?>'><?php self::render($data['YTD_A']-$data['YTD_B'],0);?></td>
						<td class='budget-decimal  <?php echo $this->oBudget->flagPublic?"":"budget-cloak";?>'><em><?php self::render_ratio($data['YTD_A'],$data['YTD_B'],0);?></em></td>
						<!--Data for rest-of-year-->
						<td class='budget-decimal budget-ytd'><?php self::render($data['ROY_A'],0);?></td>
						<td class='budget-decimal'><?php self::render($data['ROY_B'],0);?></td>
						<td class='budget-decimal'><?php self::render($data['ROY_A']-$data['ROY_B'],0);?></td>
						<td class='budget-decimal'><em><?php self::render_ratio($data['ROY_A'],$data['ROY_B'],0);?></em></td>
					<?php
					}
				}
				break;	
			}
	}
	
	private function echoBudgetItemString($data, $strClass='',$flagSubtotal=true){							
		GLOBAL $arrUsrData;
		ob_start();
		static $Level1_title;
		
		// echo '<pre>';print_r($data);echo '</pre>';die();
		
		if (!is_array($data)){
			return (false);
		}
		
		?>
		<tr class='<?php echo $strClass;?>'>
			<?php 			
			$first = reset($data);
			if (is_array($first)){				
				?>
				<td class="budget-tdh code-<?php echo urlencode($first['level1_code']);?>" data-code='<?php echo $first['metadata'];?>' rowspan='<?php echo count($data);?>'>
					<?php 					
					if ($first['level1_code']==$arrUsrData['usrID']) echo '<strong>';
					echo $first['Level1_title'];
					if ($first['level1_code']==$arrUsrData['usrID']) echo '</strong>';
					?>
				</td>				
				<?php
				$row = 1;				
				foreach ($data as $item=>$values){
					if ($row>1){ ?>
						</tr>
						<tr class="budget-item <?php echo $values['class'];?>">					
					<?php };
					?>
					<td><?php echo (isset($values['href'])?"<a href='{$values['href']}'>":""), $values['Budget item'].(isset($values['href'])?"</a>":"");?></td>
					<?php
					$this->_echoNumericTDs($values);
					$row++;
					
					if ($item){
						foreach ($values as $column=>$value){						
							$arrSubtotal[$column] += $value;
						};	
					}
				}
				$arrSubtotal['Budget item'] = "Subtotal";						
				if ($flagSubtotal) $this->echoBudgetItemString($arrSubtotal,'budget-subtotal budget-item');
				// $this->echoBudgetItemString($arrSubtotal,'budget-subtotal budget-item');
			} else {	
			?>
			<td colspan="2" title="<?php echo $data['title'];?>" data-code='<?php echo $data['metadata'];?>'>
			<?php
				if ($data['Group_code']==self::GP_CODE) {
					echo 'Total '.strtolower($data['Budget item']); 
				} else {
					if (!isset($data['href'])){
						echo $data['Budget item']?$data['Budget item']:'<None>';
					} else {
						// echo '<a target="_blank" href="javascript:getSource({\'item\':\''.$data['item'].'\'})">'.$data['Budget item'].'</a>';
						echo "<a target='_blank' href='{$data['href']}'>{$data['Budget item']}</a>";
					}
				}
			?>
			</td>
			<?php
				$this->_echoNumericTDs($data);
			}
			?>
		</tr>
		<?php
		ob_flush();
	}
	
	function getJournalEntries($data){
		
		if (!count($data)){
			echo "<div id='sources' class='error'>No documents found</div>";
			return (false);
		}	
		
		ob_start();
		
		$total = 0;	
		for($i=0;$i<count($data);$i++){
		
				$total += $data[$i]['amount'];	
				?>
				<tr id="tr_<?php echo $data[$i]['guid'];?>" class="<?php echo ($data[$i]['posted']?'journal-posted':'')?> <?php echo ($data[$i]['deleted']?'journal-deleted':'')?>">										
					<td><input class='journal-cb' type='checkbox'/></td>
					<td><?php echo $i+1;?></td>
					<td><a class="budget-document-link" target="_blank" href="<?php echo $data[$i]['script'].'?'.$data[$i]['prefix'].'ID='.$data[$i]['id'];?>"><?php echo $data[$i]['title'],' #',$data[$i]['id'];?></a></td>
					<td class="td-posted <?php echo ($data[$i]['posted']?'budget-icon-posted':'');?>">&nbsp;</td>
					<td class="td-deleted <?php echo ($data[$i]['deleted']?'budget-icon-deleted':'');?>">&nbsp;</td>
					<td id="amount_<?php echo $data[$i]['guid'];?>" class="journal-current budget-decimal"><?php self::render($data[$i]['amount']);?></td>
					<td><?php echo $data[$i]['PL'];?></td>
					<td><?php echo $data[$i]['comment'];?></td>
					<td id="usrTitle_<?php echo $data[$i]['guid'];?>"><?php echo $data[$i]['usrTitle'];?></td>
					<td id="timestamp_<?php echo $data[$i]['guid'];?>"><?php echo date('d.m.Y H:i',strtotime($data[$i]['timestamp']));?></td>
					<td id="responsible_<?php echo $data[$i]['guid'];?>"><?php echo $data[$i]['responsible'];?></td>
				</tr>
				<?php
		}
		
		// ob_flush();
		
		$strTbody = ob_get_clean();
		$id = md5(implode('#',$data));
		?>
			<div id="<?php echo $id;?>">
			<table id='sources' class='log'>
				<thead>
					<tr>
						<th><input class='journal-cb-all' type='checkbox'/></th>
						<th>#</th>
						<th>Document</th>
						<!--<th>ID</th>
						<th>GUID</th>-->
						<th>Posted</th>
						<th>Deleted</th>
						<th class='journal-current'>Amount</th>
						<th>Profit</th>
						<th>Comment</th>
						<th>Editor</th>
						<th>Timestamp</th>
						<th>Responsible</th>
					</tr>
				</thead>
				<tfoot>
					<tr class="budget-subtotal">
						<td colspan="5">Total:</td>
						<td class='journal-current budget-decimal' id='journal_total'><?php self::render($total);?></td>
					</tr>
				</tfoot>
				<tbody>
					<?php echo $strTbody; ?>
				</tbody>
			</table>			
			</div>			
		<?php
		self::_echoButtonCopyTable($id);
	}
	
	function render($number, $decimals=0, $dec_separator='.',$thousand_separator=',',$negative='budget-negative'){
		if ($number==0) {
			echo '';
			return;
		}
		
		if ($number<0){
			echo "<span class='{$negative}'>",number_format($number,$decimals,$dec_separator,$thousand_separator),"</span>";
		} else {
			echo "<span>",number_format($number,$decimals,$dec_separator,$thousand_separator),"</span>";
		}
		
	}
	
	function render_ratio ($n1, $n2, $decimals=1){
		if ((integer)$n2==0 || ($n1*$n2<0)){
			echo 'n/a';
			return;			
		} else {
			self::render($n1/$n2*100,$decimals);
		}
	}
		
	private function _unionMRQueries($sql, 
			$sqlGroup="`Budget item`, `item`, `Group`, `Group_code`,`itmOrder`", 
			$sqlOrder="`Group`, `itmOrder` ASC", 
			$fields = Array()){
		
		if(!count($fields)) $fields = $this->columns;
		
		for($i = 0;$i<count($fields);$i++){
			$arrUnion[] = "SUM({$fields[$i]}) as {$fields[$i]}";
		}
		$sql = "SELECT ".($sqlGroup?"{$sqlGroup},":'')."
					".implode(',',$arrUnion)."
				FROM ({$sql}) U 
				##GROUPING BY ITEM
				".($sqlGroup?"GROUP BY {$sqlGroup}":'')."
				".($sqlOrder?"ORDER BY {$sqlOrder}":'');
		return($sql);
		
	}
	
	private function _getQuarterTotals($rw, $type=''){
		
		if($type=='average'){
			$divider = 3;
		} else {
			$divider=1;
		}
	
		$res = Array('Q1'=>($rw['jan']+$rw['feb']+$rw['mar'])/$divider,
					'Q2'=>($rw['apr']+$rw['may']+$rw['jun'])/$divider,
					'Q3'=>($rw['jul']+$rw['aug']+$rw['sep'])/$divider,
					'Q4'=>($rw['oct']+$rw['nov']+$rw['dec'])/$divider,
					'Q5'=>($rw['jan_1']+$rw['feb_1']+$rw['mar_1'])/$divider);
		return ($res);
	}

	public function shortMonthlyReport($type='cm'){
		
		// $this->oSQL->startProfiling();
		
		$sqlWhere = $this->sqlWhere;

	if(($this->oBudget->cm % 3 && $this->oBudget->nm % 3) || $this->oBudget->cm==6){
			$this->colspan = 14;
		} else {
			$this->colspan = 18;
		}
		
		//---------------check if summary is up to date--------------------
		if($this->oBudget->checksum != $this->oBudget->get_checksum()){
			$this->oBudget->write_checksum();
		}
		if($this->oReference->checksum != $this->oReference->get_checksum()){
			$this->oReference->write_checksum();
		}
		
		$strFields = $this->_getMRFields();
		$strFieldsKPI = $this->_getMRFields(Array('denominator'=>1,'currency'=>643));
		
		//$sqlGroup = "GROUP BY `item`";
		
		$sql = "SELECT 
					{$strFields['actual']}
			FROM `reg_summary`			
			{$sqlWhere}  AND scenario='{$strFields['from_a']}' AND `item` IS NOT NULL			
			UNION ALL
				SELECT 
				{$strFields['budget']}
			FROM `reg_summary`				
			{$sqlWhere} AND scenario='{$strFields['from_b']}' AND `item` IS NOT NULL			
			";
		
		switch ($type){
			case 'budget':
				$this->columns = Array('FYE_A','FYE_B');
				$this->structure = 'budget';
				$strHeader = $this->oBudget->getTableHeader('budget');	
				$this->colspan = 6;				
				break;
			case 'fye':
				$this->columns = Array('YTD_A','YTD_B','ROY_A','ROY_B','FYE_A','FYE_B');
				$this->structure = 'forecast';
				$strHeader = $this->oBudget->getTableHeader('roy');				
				break;
			case 'ytd':
			case 'cm':
			default:
				$this->columns = Array('CM_A','CM_B','YTD_A','YTD_B','Q_A','Q_B','NM_A','NM_B','FYE_A','FYE_B');
				$this->structure = 'monthly';
				$strHeader = $this->oBudget->getTableHeader('mr');				
		}
		
		
		$this->sqlSelect = "";
		foreach($this->columns as $i=>$field){
			$this->sqlSelect .= ($this->sqlSelect?",\r\n":"")."SUM(`{$field}`) as '{$field}'";
		}
		
		$sql = self::_unionMRQueries($sql,'','', $this->columns);
		
		//$tableID = "SUMMARY_".md5($sql);
		// die( $sql);
		if (!$rs = $this->oSQL->q($sql)){
				echo "<div class='error'>SQL error:</div>";
				echo "<pre>$sql</pre>";
				return (false);
		};
			?>
			<table id='<?php echo $this->ID;?>' class='budget' style='font-size:1.2em;'>
			<caption><?php echo $this->caption;?></caption>
			<thead>				
				<tr>					
					<th rowspan="2" colspan="2"><?php echo $this->CurrencyTitle, "&nbsp;", number_format($this->Denominator);?></th>
					<?php echo $strHeader; ?>					
			</thead>			
			<tbody>
		<?php
		echo '<tr class="sql" style="display:none;"><td><pre>',$sql,'</pre></td></tr>';
		
		
		$sqlOps = str_replace($sqlWhere, $sqlWhere." AND item IN('".implode("','",self::GROSS_REVENUE_ITEMS)."') AND pccFlagProd=1", $sql);
		$sqlOps = str_replace($sqlGroup, '', $sqlOps);
		$rs = $this->oSQL->q($sqlOps);
		while ($rw = $this->oSQL->f($rs)){
			$rw['Budget item'] = "Gross revenue";
			$this->echoBudgetItemString($rw, 'budget-ratio');
		}
		
		
		$sqlOps = str_replace($sqlWhere, $sqlWhere.self::REVENUE_FILTER, $sql);
		$sqlOps = str_replace($sqlGroup, '', $sqlOps);
		$rs = $this->oSQL->q($sqlOps);
		while ($rw = $this->oSQL->f($rs)){
			$rw['Budget item'] = "Net revenue";
			$rw['title'] = "Revenue less proceeds from import freight";
			$this->echoBudgetItemString($rw);
		}
		
		$sqlOps = str_replace($sqlWhere, $sqlWhere.self::DIRECT_COST_FILTER, $sql);
		$sqlOps = str_replace($sqlGroup, '', $sqlOps);
		$rs = $this->oSQL->q($sqlOps);
		// echo '<pre>',$sqlOps,'</pre>';
		while ($rw = $this->oSQL->f($rs)){
			$rw['Budget item'] = "Direct costs";
			$rw['title'] = "Subcontractor costs, except import freight";
			$this->echoBudgetItemString($rw);
		}
		
		$sqlOps = str_replace($sqlWhere, $sqlWhere.self::GP_FILTER, $sql);
		$sqlOps = str_replace($sqlGroup, '', $sqlOps);
		$rs = $this->oSQL->q($sqlOps);
		while ($rw = $this->oSQL->f($rs)){
			$rw['Budget item'] = "Gross profit";
			$this->echoBudgetItemString($rw, 'budget-subtotal');
		}
		
		
		//-------Reclassified fixed costs --------------------------------------------------------------
		$arrYCT = Array();
		$_rs = $this->oSQL->q("SELECT yctID FROM vw_yact WHERE yctID LIKE 'J%' AND yctID NOT IN ('J00400', 'J00802','J45010','J40010')");
		while ($rw = $this->oSQL->f($_rs)){
				$arrYCT[] = $rw['yctID'];
		}
		
		$sqlOps = str_replace($sqlWhere, $sqlWhere.self::RFC_FILTER." AND pccFlagProd=1", $sql);
		$sqlOps = str_replace($sqlGroup, '', $sqlOps);
		try {
			$rs = $this->oSQL->q($sqlOps);
		} catch (Exception $e) {
			echo $e;
			echo '<pre>',$sqlOps,'</pre>';
		}
		while ($rw = $this->oSQL->f($rs)){
			$rw['Budget item'] = "Reclassified fixed costs";
			$rw['title'] = "Direct production costs: labor, rent, fuel, depreciation";
			$metadata = Array('filter'=>$this->filter, 'DataAction'=>'budget_item');
			$metadata['filter']['account'] = $arrYCT;
			$metadata['title'] = $rw['Budget item'];
			$rw['href'] = "javascript:getYACTDetails(".json_encode($metadata).");";
			$this->echoBudgetItemString($rw);
		}
		
		$sqlOps = str_replace($sqlWhere, $sqlWhere.self::GOP_FILTER." AND pccFlagProd=1", $sql);
		$sqlOps = str_replace($sqlGroup, '', $sqlOps);
		$rs = $this->oSQL->q($sqlOps);
		while ($rw = $this->oSQL->f($rs)){
			$rw['Budget item'] = "Gross operating profit";
			$this->echoBudgetItemString($rw, 'budget-subtotal');
		}
		
		// if (!($this->filter['activity'])){
			$arrYCT = Array();
			$_rs = $this->oSQL->q("SELECT yctID FROM vw_yact WHERE yctID LIKE '5%' AND yctID NOT IN('5999CO','527000')");
			while ($rw = $this->oSQL->f($_rs)){
					$arrYCT[] = $rw['yctID'];
			}
			
			$sqlOps = str_replace($sqlWhere, $sqlWhere." AND (account IN ('".implode("','",$arrYCT)."') AND pccFlagProd=1)", $sql);
			$sqlOps = str_replace($sqlGroup, '', $sqlOps);
			$rs = $this->oSQL->q($sqlOps);
			while ($rw = $this->oSQL->f($rs)){
				$rw['Budget item'] = "Selling & general";
				$rw['title'] = "Costs of sales and BU management";
				$metadata = Array('filter'=>$this->filter, 'DataAction'=>'budget_item');
				$metadata['filter']['account'] = $arrYCT;
				$metadata['filter']['pccFlagProd'] = 1;
				$metadata['title'] = $rw['Budget item'];
				$rw['href'] = "javascript:getYACTDetails(".json_encode($metadata).");";
				$this->echoBudgetItemString($rw);
			}
			
			$sqlOps = str_replace($sqlWhere, $sqlWhere.self::CORP_FILTER, $sql);
			$sqlOps = str_replace($sqlGroup, '', $sqlOps);
			$rs = $this->oSQL->q($sqlOps);
			while ($rw = $this->oSQL->f($rs)){
				$rw['Budget item'] = "Corporate costs";
				$rw['title'] = "Costs of headquarters, except BDV";
				$metadata = Array('filter'=>$this->filter, 'DataAction'=>'budget_item');
				$metadata['filter']['account'] = '5999CO';
				$metadata['title'] = $rw['Budget item'];
				$rw['href'] = "javascript:getYACTDetails(".json_encode($metadata).");";
				$this->echoBudgetItemString($rw);
			}
			
			$sqlOps = str_replace($sqlWhere, $sqlWhere.self::MSF_FILTER, $sql);
			$sqlOps = str_replace($sqlGroup, '', $sqlOps);
			$rs = $this->oSQL->q($sqlOps);
			while ($rw = $this->oSQL->f($rs)){
				$rw['Budget item'] = "MSF";
				$rw['title'] = "Costs of regional and global HQ";
				$metadata = Array('filter'=>$this->filter, 'DataAction'=>'budget_item');
				$metadata['filter']['account'] = '527000';
				$metadata['title'] = $rw['Budget item'];
				$rw['href'] = "javascript:getYACTDetails(".json_encode($metadata).");";
				$this->echoBudgetItemString($rw);
			}
			
			$sqlOps = str_replace($sqlWhere, $sqlWhere." AND (account NOT LIKE '6%' AND account NOT LIKE '7%' AND account NOT LIKE 'SZ%' AND pccFlagProd=1)", $sql);
			$sqlOps = str_replace($sqlGroup, '', $sqlOps);
			$rs = $this->oSQL->q($sqlOps);
			while ($rw = $this->oSQL->f($rs)){
				$rw['Budget item'] = "Operating profit";				
				$this->echoBudgetItemString($rw, 'budget-subtotal');
			}
			
			// $sqlOps = str_replace($sqlWhere, $sqlWhere." AND (account NOT LIKE '6%' AND account NOT LIKE '7%' AND account NOT LIKE 'SZ%' AND account NOT LIKE '5999%' AND pccFlagProd=1)", $sql);
			$sqlOps = str_replace($sqlWhere, $sqlWhere.self::OWN_OPERATING_PROFIT, $sql);
			$sqlOps = str_replace($sqlGroup, '', $sqlOps);
			$rs = $this->oSQL->q($sqlOps);
			while ($rw = $this->oSQL->f($rs)){
				$rw['Budget item'] = "Own operating profit";		
				$rw['title'] = "Result of business unit without any corporate costs";				
				$this->echoBudgetItemString($rw, 'budget-ratio');
			}
			
			$arrYCT = Array();
			$_rs = $this->oSQL->q("SELECT yctID FROM vw_yact WHERE yctID LIKE '60%' AND yctID<>'607000'");
			while ($rw = $this->oSQL->f($_rs)){
					$arrYCT[] = $rw['yctID'];
			}
			$sqlOps = str_replace($sqlWhere, $sqlWhere." AND (account IN('".implode("','",$arrYCT)."'))", $sql);
			$sqlOps = str_replace($sqlGroup, '', $sqlOps);
			$rs = $this->oSQL->q($sqlOps);
			while ($rw = $this->oSQL->f($rs)){
				$rw['Budget item'] = "Non-operating income";
				$rw['title'] = "Interest receivable, sublease, sale of assets";
				$metadata['filter']['account'] = $arrYCT;
				$metadata['title'] = $rw['Budget item'];
				$rw['href'] = "javascript:getYACTDetails(".json_encode($metadata).");";
				$this->echoBudgetItemString($rw);
			}
			
			$arrYCT = Array();
			$_rs = $this->oSQL->q("SELECT yctID FROM vw_yact WHERE yctID LIKE '65%' OR yctID LIKE '66%'");
			while ($rw = $this->oSQL->f($_rs)){
					$arrYCT[] = $rw['yctID'];
			}
			$sqlOps = str_replace($sqlWhere, $sqlWhere." AND (account IN('".implode("','",$arrYCT)."'))", $sql);
			$sqlOps = str_replace($sqlGroup, '', $sqlOps);
			$rs = $this->oSQL->q($sqlOps);
			while ($rw = $this->oSQL->f($rs)){
				$rw['Budget item'] = "Non-operating losses";
				$rw['title'] = "Interest and FX losses";
				$metadata['filter']['account'] = $arrYCT;
				$metadata['title'] = $rw['Budget item'];
				$rw['href'] = "javascript:getYACTDetails(".json_encode($metadata).");";
				$this->echoBudgetItemString($rw);
			}
			
			$sqlOps = str_replace($sqlWhere, $sqlWhere." AND (account LIKE '7%')", $sql);
			$sqlOps = str_replace($sqlGroup, '', $sqlOps);
			$rs = $this->oSQL->q($sqlOps);
			while ($rw = $this->oSQL->f($rs)){
				$rw['Budget item'] = "Extraordinary";
				$this->echoBudgetItemString($rw);
			}
			
			$sqlOps = str_replace($sqlWhere, $sqlWhere." AND pccFlagProd=1", $sql);
			$sqlOps = str_replace($sqlGroup, '', $sqlOps);
			// echo '<pre>',$sqlOps,'</pre>';
			$rs = $this->oSQL->q($sqlOps);
			while ($rw = $this->oSQL->f($rs)){
				$rw['Budget item'] = "Profit before tax";
				$this->echoBudgetItemString($rw, 'budget-subtotal');
			}
		// } else {
			//------- KPIs -----------------	
			// $strFields = self::_getMRFields(Array('denominator'=>1,'currency'=>643));
			
			if (strpos($this->oBudget->type,'Budget')!==false){
				$sql = "SELECT activity, unit, prtTitle,
					{$strFieldsKPI['actual']}
				FROM `vw_sales`				
				{$sqlWhere} AND scenario='{$strFieldsKPI['from_a']}' 
				GROUP BY activity, unit
				";
			} else {
				$sql = "SELECT activity, unit, prtTitle,
						{$strFieldsKPI['actual']}
				FROM `vw_sales`			
				{$sqlWhere}  AND scenario='{$strFieldsKPI['from_a']}' AND ".self::ACTUAL_DATA_FILTER."
				GROUP BY activity, unit
				UNION ALL
				SELECT activity, unit, prtTitle, 
						{$strFieldsKPI['next']}
				FROM `vw_sales`			
				{$sqlWhere}  AND scenario='{$strFieldsKPI['from_a']}' AND source<>'Actual'
				GROUP BY activity, unit
				";
			}
			$sql .= "UNION ALL
					SELECT activity, unit, prtTitle,
					{$strFieldsKPI['budget']}
				FROM `vw_sales`				
				{$sqlWhere} AND scenario='{$strFieldsKPI['from_b']}' 
				GROUP BY activity, unit
				";
				
			$sql = self::_unionMRQueries($sql,"`prtTitle`, `activity`, `unit`",'', $arrUnion);
			
			// echo '<pre>',$sql,'</pre>';
			$rs = $this->oSQL->q($sql);
			
			if ($this->oSQL->n($rs)){
				?>
				<tr><th colspan="<?php echo $this->colspan;?>">Operational KPIs</th></tr>				
				<?php		
				while ($rw = $this->oSQL->f($rs)){			
					$rw['Budget item'] = $rw['prtTitle'];//." ({$rw['unit']})";
					$rw['Level1_title'] = $rw['unit'];
					$rw['Level1_code'] = $rw['unit'];
					$filter = $this->filter;
					$filter['activity'] = $rw['activity'];
					$arrMetadata = Array('filter' => $filter, 'DataAction' => 'kpiByCustomer', 'title'=>$rw['prtTitle']);
					$rw['metadata'] = json_encode($arrMetadata);
					$rw['href'] = "javascript:getCustomerKPI(".json_encode($arrMetadata).");";
					$arrKPIReport[$rw['unit']][$rw['activity']] = $rw;
					
				}
				
				foreach($arrKPIReport as $unit=>$data){
					$this->echoBudgetItemString($data);
				}
				
				
			}
		// }
		
		$this->_getMRHeadcount($sqlWhere);
		$this->_getMRHeadcount($sqlWhere,'funRHQ');
		
		
		?>
		</tbody>
		</table>
		<?php
		$this->_echoButtonCopyTable($this->ID);
		// $this->oSQL->showProfileInfo();
	}
	
	function getCustomerGroup($rw){
		switch ($rw['customer_group_code']){
			case 31158:
				$cusGroup = "TOYOTA";
				break;
			case 33239: //
			case 40933: // New 2017
			case 42763: // New 2017 J
			case 44265: // New 2018 J
			case 44264: // New 2018 
				switch ($rw['customer']){
					case 33242:
					case 40934:
					case 41976:
					case 44267:
					case 44266:
						$cusGroup = 'New customers, unknown';
						break;
					default:
						$cusGroup = "New and landed";
						break;
				}
				break;
			case 31153:
				$cusGroup = 'Brought in 2015';
				break;
			default:
				$cusGroup = 'Existing customers';
				break;
		}
		return($cusGroup);
	}
	
	function GOP($period_type){
		$strFields = $this->_getMRFields();
		$sql = "SELECT customer, Customer_name, account, Title, {$strFields['actual']}
				FROM vw_master
				{$this->sqlWhere}
				AND scenario='{$this->oBudget->id}'
				".self::GOP_FILTER."
				GROUP by customer, account
				ORDER BY account, customer";
			
		switch($period_type){
			case 'budget':
			case 'fye':
				$field = "FYE_A";
				break;
			case 'cm':
				$field = "CM_A";
				break;
			case 'ytd':
			default:
				$field = "YTD_A";
				break;
		}
		
		// echo '<pre>',$sql,'</pre>';
		$rs = $this->oSQL->q($sql);
		while ($rw = $this->oSQL->f($rs)){
				$arrSort[$rw['customer']] += $rw[$field];
				$arrReport[$rw['customer']][$rw['account']] += $rw[$field];
				$arrAccount[$rw['account']] = $rw['Title'];
				$arrCustomer[$rw['customer']] = $rw['Customer_name'];
				$arrTotal[$rw['account']] += $rw[$field];
		}
		arsort($arrSort);
		?>
		<h3>Accounting breakdown</h3>
		<table class='budget' id='<?php echo $this->ID;?>'>
			<caption>
			<?php echo $this->caption;?>
			</caption>
			<thead>
				<tr>
					<th>Customer</th>
					<?php
					foreach ($arrAccount as $id=>$title){
						?>
						<th><?php echo $id,'<br/>','<small>',$title,'</small>';?></th>
						<?php
					}	
					?>
					<th class='budget-ytd'>Gross Operating Profit</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($arrSort as $customer=>$GOP){
					?>
					<tr>
						<td><?php echo $arrCustomer[$customer];?></td>
						<?php
						foreach ($arrAccount as $account=>$title){
						?>
						<td class='budget-decimal'><?php $this->render($arrReport[$customer][$account]);?></td>
						<?php
						}
						?>
						<td class='budget-decimal budget-ytd'><?php $this->render(array_sum($arrReport[$customer]));?></td>
					</tr>
					<?php
				}
				?>
			</tbody>
			<tfoot>
				<tr class='budget-subtotal'>
					<td>Total</td>
					<?php
						foreach ($arrAccount as $id=>$title){
						?>
						<td class='budget-decimal'><?php $this->render($arrTotal[$id]);?></td>
						<?php
						}
						?>
					<td class='budget-decimal budget-ytd'><?php $this->render(array_sum($arrTotal));?></td>
				</tr>
			</tfoot>
		</table>		
		<?php
		$this->_echoButtonCopyTable($this->ID);
		
		$sql = "SELECT customer, Customer_name, Group_code, `Group`, {$strFields['actual']}
				FROM vw_master
				{$this->sqlWhere}
				AND scenario='{$this->oBudget->id}'
				".self::GOP_FILTER."
				GROUP by customer, Group_code
				ORDER BY Group_code, customer";

		$rs = $this->oSQL->q($sql);
		$arrReport = Array();
		$arrTotal = Array();
		while ($rw = $this->oSQL->f($rs)){
				$arrReport[$rw['customer']][$rw['Group_code']] += $rw[$field];
				$arrGroup[$rw['Group_code']] = $rw['Group'];
				$arrTotal[$rw['Group_code']] += $rw[$field];
		}
		?>
		<h3>Functional breakdown</h3>
		<table class='budget' id='<?php echo $this->ID;?>_items'>
			<caption>
			<?php echo $this->caption;?>
			</caption>
			<thead>
				<tr>
					<th>Customer</th>
					<?php
					foreach ($arrGroup as $id=>$title){
						?>
						<th><?php echo $title;?></th>
						<?php
					}	
					?>
					<th class='budget-ytd'>Gross Operating Profit</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($arrSort as $customer=>$GOP){
					?>
					<tr>
						<td><?php echo $arrCustomer[$customer];?></td>
						<?php
						foreach ($arrGroup as $account=>$title){
						?>
						<td class='budget-decimal'><?php $this->render($arrReport[$customer][$account]);?></td>
						<?php
						}
						?>
						<td class='budget-decimal budget-ytd'><?php $this->render(array_sum($arrReport[$customer]));?></td>
					</tr>
					<?php
				}
				?>
			</tbody>
			<tfoot>
				<tr class='budget-subtotal'>
					<td>Total</td>
					<?php
						foreach ($arrGroup as $id=>$title){
						?>
						<td class='budget-decimal'><?php $this->render($arrTotal[$id]);?></td>
						<?php
						}
						?>
					<td class='budget-decimal budget-ytd'><?php $this->render(array_sum($arrTotal));?></td>
				</tr>
			</tfoot>
		</table>		
		<?php
		$this->_echoButtonCopyTable($this->ID.'_items');
	}
	
	function _echoButtonCopyTable($id){
		?>
		<button onclick="SelectContent('<?php echo $id;?>');">Copy table</button>
		<?php
	}
	
	function quarterly($type='ghq'){
		
		$sqlWhere = $this->sqlWhere;
		
		$this->structure = 'quarterly';
		$this->columns = Array('Q2','Q3','Q4','Q5','Q2_B','Q3_B','Q4_B','Q5_B','Total_AM','estimate_AM');
		$this->sqlSelect = "";
		
		foreach($this->columns as $i=>$field){
			$this->sqlSelect .= ($this->sqlSelect?",\r\n":"")."SUM(`{$field}`) as '{$field}'";
		}
		
		$strFields = $this->_getPeriodicFields();
		
		$arrMeasure = $this->_getSQLMeasure($type);
				
		// $this->structure = 'monthly';
		// $strFields = $this->_getPeriodicFields();
		
		// $strFields = $this->_getMRFields();
		$sqlGroup = "GROUP BY Level1_title, level1_code, `level2_title`, `level2_code`, `Group`";
		$sqlOrder = "ORDER BY `level1_code`, `Group`, `itmOrder` ASC";

		
		ob_start();
		
		$sql = "SELECT {$arrMeasure['sql']}
					{$strFields['actual']}
			FROM `vw_master`			
			{$sqlWhere}  
				AND scenario='{$strFields['from_a']}' 
				AND {$this->strGPFilter}
			{$sqlGroup}	
			UNION ALL
				SELECT {$arrMeasure['sql']}
				{$strFields['budget']}
			FROM `vw_master`				
			{$sqlWhere} 
				AND scenario='{$strFields['from_b']}' 
				AND {$this->strGPFilter}
			{$sqlGroup}			
			";
		
		$sql = "SELECT `Level1_title`, `level1_code`, `level2_title`, `Group`, `level2_code`,`itmOrder`,
					{$this->sqlSelect}
				FROM ({$sql}) U 
				{$sqlGroup} 
				{$sqlOrder}";
		
		// echo '<pre>',$sql,'</pre>'; die();
		$this->_firstLevelQuarterly($sql, $arrMeasure['title'], $this->oBudget);
		//==========================================================================================================================Non-customer-related data
		$this->_nofirstLevelPeriodic($sqlWhere);
		?>
		</tbody>
		</table>
		<?php
		$this->_echoButtonCopyTable($this->ID);		
		ob_flush(); 
	}
}
?>