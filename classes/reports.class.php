<?php
require_once ('budget.class.php');

class Reports{
	
	private $ID;
	public $oBudget;
	public $Currency;
	public $Denominator;
	private $oSQL;
	
	const GP_CODE = 94;
	const CNT_GROUP_EXEMPTION = 723;
	const OP_FILTER = "AND (account NOT LIKE '6%' AND account NOT LIKE '7%' AND account NOT LIKE 'SZ%') ";	
	const GP_FILTER = "AND account IN ('J00400', 'J00802') ";
	const REVENUE_ITEM = 'cdce3c68-c8da-4655-879e-cd8ec5d98d95';
	const SALARY_THRESHOLD = 10000;
	
	function __construct($params){
		
		GLOBAL $oSQL;
		$this->oSQL = $oSQL;
		
		$this->oBudget = new Budget($params['budget_scenario']);
		$this->oReference = $params['reference']?new Budget($params['reference']):$this->oBudget->reference_scenario;
		
		$this->Currency = $params['currency']?$params['currency']:643;
		
		$sql = "SELECT curTitle FROM common_db.tbl_currency WHERE curID={$this->Currency}";
		$rs = $this->oSQL->q($sql);
		$this->CurrencyTitle = $this->oSQL->get_data($rs);
		
		$this->Denominator = $params['denominator']?$params['denominator']:1;
		$this->ID = md5(time());
		
		$this->YACT = $params['yact']?true:false;
		// echo '<pre>';print_r($this);echo '</pre>';
		$this->filter = $params['filter'];
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
			$this->sqlWhere = "WHERE ".implode (" AND ",$arrWhere);		
		} else {
			$this->sqlWhere = "WHERE TRUE ";
		}
	}
	
	public function salesByActivity($sqlWhere=''){
		GLOBAL $oSQL;
		ob_start();
			
			switch ($this->oBudget->type){
				case 'Budget':
					$sql = "SELECT prtGHQ, prtRHQ, pc, prtID, prtTitle as 'Activity', prtUnit as 'Unit', ".$this->oBudget->getMonthlySumSQL(1,15).", 
								SUM(".$this->oBudget->getYTDSQL(1+$this->oBudget->offset,12+$this->oBudget->offset).") as Total, 
								SUM(".$this->oBudget->getYTDSQL(4,15).") as Total_AM 
							FROM `reg_sales`					
							LEFT JOIN vw_product_type ON prtID=activity
							{$sqlWhere} AND posted=1 AND kpi=1 AND scenario='{$this->oBudget->id}'
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
							{$sqlWhere} AND scenario='{$this->oBudget->id}' AND kpi=1 and source='Actual'
							GROUP BY activity, unit
							UNION ALL
							SELECT pc, activity, unit,
									".str_repeat("0, ",$mthStart-1).$this->oBudget->getMonthlySumSQL($mthStart,15)."
							FROM `reg_sales` 			
							{$sqlWhere} AND scenario='{$this->oBudget->id}' AND kpi=1 AND posted=1 and source<>'Actual'
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
				echo "<td><a href='javascript:getCustomerKPI({activity:{$rw['prtID']}});'>",$rw['Activity'],'</a></td>';
				echo '<td class="unit">',$rw['Unit'],'</td>';
				for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
					// $month = $this->oBudget->arrPeriod[$m];
					$month = $this->oBudget->arrPeriod[$m];
					echo "<td class='budget-decimal budget-monthly budget-$month'>",self::render($rw[$month]),'</td>';
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
			<ul class='link-footer'>
				<li><a href='javascript:SelectContent("<?php echo $tableID;?>");'>Select table</a></li>
			</ul>
			<?php
			
			if ($flagShowOFFReport) {
				$this->offByRoute($sqlWhere);
			}
			
			if ($flagShowWHReport) {
				$this->whByCustomer($sqlWhere);
			}
			
			ob_flush();
	}
	
	function offByRoute($sqlWhere){
		
		$sql = "SELECT prtTitle, ".$this->oBudget->getMonthlySumSQL(1,15).", 
				SUM(".$this->oBudget->getYTDSQL(1+$this->oBudget->offset,12+$this->oBudget->offset).") as Total, 
				SUM(".$this->oBudget->getYTDSQL(4,15).") as Total_AM
				FROM vw_sales 
				JOIN tbl_sales ON salGUID=source
				{$sqlWhere} 
					AND salBO=714
					AND activity IN (48,63) AND scenario='{$this->oBudget->id}'
				GROUP BY activity";
		$rs = $this->oSQL->q($sql); 
		$tableID = "kpi_".md5($sql);
			?>
			<h2>Freehand OFF</h2>
			<table id='<?php echo $tableID;?>' class='budget'>
			<thead>
				<tr>
					<th>Activity</th>
					<?php 
					echo $this->oBudget->getTableHeader(); 
					echo $this->oBudget->getTableHeader('quarterly'); 
					?>
					<th class='budget-ytd'>Total</th>
					<th class='budget-monthly'>Jan+</th>
					<th class='budget-monthly'>Feb+</th>
					<th class='budget-monthly'>Mar+</th>
					<th>Q5</th>
					<th class='budget-ytd'>Apr-Mar</th>
				</tr>
			</thead>			
			<tbody>
			<?php			
			while ($rw=$this->oSQL->f($rs)){				
				?>
				<tr class='graph'>
				<?php
				if ($rw['prtGHQ']!=$prtGHQ){
					?>
					<tr><th colspan="20"><?php echo $rw['prtGHQ'];?></th></tr>
					<?php
				};
				echo "<td>",$rw['prtTitle'],'</td>';				
				for ($m=1;$m<=12;$m++){
					// $month = $this->oBudget->arrPeriod[$m];
					$month = $this->oBudget->arrPeriod[$m];
					echo "<td class='budget-decimal budget-monthly budget-$month'>",self::render($rw[$month]),'</td>';
					$arrTotal[$month]+=$rw[$month];
				};
				$arrTotal['Total']+=$rw['Total'];
				$arrTotal['Total_AM']+=$rw['Total_AM'];
				
				$arrQuarter = $this->_getQuarterTotals($rw);
				
				for ($q=1;$q<5;$q++){		
					$quarter = 'Q'.$q;
					echo "<td class='budget-decimal budget-quarterly budget-$quarter'>",number_format($arrQuarter[$quarter],0,'.',','),'</td>';
					$arrTotal[$quarter]+=$arrQuarter[$quarter];
				}				
									
				echo '<td class=\'budget-decimal budget-ytd\'>',number_format($rw['Total'],0,'.',','),'</td>';
				for ($m=13;$m<=15;$m++){
					// $month = $this->oBudget->arrPeriod[$m];
					$month = $this->oBudget->arrPeriod[$m];
					echo "<td class='budget-decimal budget-monthly budget-$month'>",self::render($rw[$month]),'</td>';
				}
				echo '<td class=\'budget-decimal budget-quarterly budget-Q5\'>',number_format($arrQuarter['Q5'],0,'.',','),'</td>';
				echo '<td class=\'budget-decimal budget-ytd\'>',number_format($rw['Total_AM'],0,'.',','),'</td>';
				for ($m=13;$m<=15;$m++){
					$month = $this->oBudget->arrPeriod[$m];
					echo "<td class='budget-decimal budget-monthly budget-$month'>",self::render($rw[$month]),'</td>';
				}
				echo "</tr>\r\n";				
			}
			?>
			</tbody>
			<tfoot>
				<tr class='budget-subtotal'>
					<td>Total freehand volume</td>
					<?php
					for ($m=1;$m<=12;$m++){
					// $month = $this->oBudget->arrPeriod[$m];
					$month = $this->oBudget->arrPeriod[$m];
					echo "<td class='budget-decimal budget-monthly budget-$month'>",self::render($arrTotal[$month]),'</td>';
	
					}
					for ($q=1;$q<5;$q++){		
					$quarter = 'Q'.$q;
					echo "<td class='budget-decimal budget-quarterly budget-$quarter'>",self::render($arrTotal[$quarter]),'</td>';

					}	
					echo '<td class=\'budget-decimal budget-ytd\'>',self::render($arrTotal['Total']),'</td>';
					echo '<td class=\'budget-decimal budget-quarterly budget-Q5\'>',self::render($arrTotal['Q5']),'</td>';
					echo '<td class=\'budget-decimal budget-ytd\'>',self::render($arrTotal['Total_AM']),'</td>';
					?>
				</tr>
			</tfoot>
			</table>
			<ul class='link-footer'>
				<li><a href='javascript:SelectContent("<?php echo $tableID;?>");'>Select table</a></li>
			</ul>
		<?php
		
	}
	
	function whByCustomer($sqlWhere){
		
		require_once('item.class.php');
		$empty = 1894;
		
		$arrRates = $this->oBudget->getMonthlyRates($this->Currency);
		$sql = "SELECT customer, ".$this->oBudget->getMonthlySumSQL(1,15, $arrRates).", 
						SUM(".$this->oBudget->getYTDSQL(1+$this->oBudget->offset,12+$this->oBudget->offset,$arrRates).") as Total,
						SUM(".$this->oBudget->getYTDSQL(4,15,$arrRates).") as Total_AM 
		FROM reg_master 
		{$sqlWhere} AND item='".Items::REVENUE."' AND scenario='{$this->oBudget->id}'
		GROUP BY customer";
		$rs = $this->oSQL->q($sql); 
		while ($rw = $this->oSQL->f($rs)){
			$arrRevenue[$rw['customer']] = $rw;
		}
		
		$sql = "SELECT cntTitle,customer, ".$this->oBudget->getMonthlySumSQL(1,15).", 
					SUM(".$this->oBudget->getYTDSQL(1+$this->oBudget->offset,12+$this->oBudget->offset).") as Total,
					SUM(".$this->oBudget->getYTDSQL(4,15).") as Total_AM
				FROM reg_rent 
				LEFT JOIN vw_customer ON cntID=customer
				{$sqlWhere} AND posted=1 AND item='".Items::WH_RENT."' AND scenario='{$this->oBudget->id}'
				GROUP BY customer";
		$rs = $this->oSQL->q($sql); 
		$tableID = "kpi_".md5($sql);
			?>
			<h2>WH utilization, m<sup>2</sup></h2>
			<table id='<?php echo $tableID;?>' class='budget'>
			<thead>
				<tr>
					<th>Customer</th>
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
			while ($rw=$this->oSQL->f($rs)){				
				?>
				<tr class='graph'>
				<?php
				if ($rw['prtGHQ']!=$prtGHQ){
					?>
					<tr><th colspan="20"><?php echo $rw['prtGHQ'];?></th></tr>
					<?php
				};
				echo "<td class='code-".$rw['customer']."'>",$rw['cntTitle'],'</td>';				
				echo "<td class='budget-decimal'>",$this->render_ratio($arrRevenue[$rw['customer']]['Total']/10,$rw['Total'],0),'</td>';				
				for ($m=1;$m<=12;$m++){
					// $month = $this->oBudget->arrPeriod[$m];
					$month = $this->oBudget->arrPeriod[$m];
					echo "<td class='budget-decimal budget-monthly budget-$month'>",self::render($rw[$month]),'</td>';
					$arrTotal[$month]+=$rw[$month];
					if ($rw['customer']!=$empty){
						$arrUtil[$month]+=$rw[$month];
					}	
					
				}
				$arrTotal['Total']+=$rw['Total'];
				$arrTotal['Total_AM']+=$rw['Total_AM'];
				if ($rw['customer']!=$empty){
						$arrUtil['Total']+=$rw['Total'];
						$arrUtil['Total_AM']+=$rw['Total_AM'];
				}
				
				$arrQuarter = $this->_getQuarterTotals($rw,'average');
				
				if ($rw['customer']!=$empty){
						$arrUtil['Q1']+=$arrQuarter['Q1'];
						$arrUtil['Q2']+=$arrQuarter['Q2'];
						$arrUtil['Q3']+=$arrQuarter['Q3'];
						$arrUtil['Q4']+=$arrQuarter['Q4'];
						$arrUtil['Q5']+=$arrQuarter['Q5'];
				}
				
				for ($q=1;$q<5;$q++){		
					$quarter = 'Q'.$q;
					echo "<td class='budget-decimal budget-quarterly budget-$quarter'>",number_format($arrQuarter[$quarter],0,'.',','),'</td>';
					$arrTotal[$quarter]+=$arrQuarter[$quarter];
				}				
							
				$arrTotal['Q5']+=$arrQuarter['Q5'];
				
				echo '<td class=\'budget-decimal budget-ytd\'>',number_format($rw['Total']/12,0,'.',','),'</td>';
				echo '<td class=\'budget-decimal budget-Q5\'>',number_format($arrQuarter['Q5'],0,'.',','),'</td>';
				echo '<td class=\'budget-decimal budget-ytd\'>',number_format($rw['Total_AM']/12,0,'.',','),'</td>';
				echo "</tr>\r\n";				
			}
			?>
			</tbody>
			<tfoot>
				<tr class='budget-subtotal'>
					<td colspan='2'>Total space</td>
					<?php
					for ($m=1;$m<=12;$m++){
					// $month = $this->oBudget->arrPeriod[$m];
					$month = $this->oBudget->arrPeriod[$m];
					echo "<td class='budget-decimal budget-monthly budget-$month'>",self::render($arrTotal[$month]),'</td>';
	
					}
					for ($q=1;$q<5;$q++){		
					$quarter = 'Q'.$q;
					echo "<td class='budget-decimal budget-quarterly budget-$quarter'>",self::render($arrTotal[$quarter]),'</td>';

					}	
					echo '<td class=\'budget-decimal budget-ytd\'>',self::render($arrTotal['Total']/12),'</td>';
					echo '<td class=\'budget-decimal budget-quarterly budget-Q5\'>',self::render($arrTotal['Q5']),'</td>';
					echo '<td class=\'budget-decimal budget-quarterly budget-Q5\'>',self::render($arrTotal['Total_AM']/12),'</td>';
					?>
				</tr>
				<tr class='budget-subtotal budget-ratio'>
					<td colspan="2">Utilization, %</td>
					<?php
					for ($m=1;$m<=12;$m++){
					// $month = $this->oBudget->arrPeriod[$m];
					$month = $this->oBudget->arrPeriod[$m];
					echo "<td class='budget-decimal budget-monthly budget-$month'>",self::render_ratio($arrUtil[$month],$arrTotal[$month]),'</td>';
	
					}
					for ($q=1;$q<5;$q++){		
					$quarter = 'Q'.$q;
					echo "<td class='budget-decimal budget-quarterly budget-$quarter'>",self::render_ratio($arrUtil[$quarter],$arrTotal[$quarter]),'</td>';

					}	
					echo '<td class=\'budget-decimal budget-ytd\'>',self::render_ratio($arrUtil['Total']/12,$arrTotal['Total']/12),'</td>';
					echo '<td class=\'budget-decimal budget-quarterly budget-Q5\'>',self::render_ratio($arrUtil['Q5'],$arrTotal['Q5']),'</td>';
					echo '<td class=\'budget-decimal budget-quarterly budget-Q5\'>',self::render_ratio($arrUtil['Total_AM']/12,$arrTotal['Total_AM']/12),'</td>';
					?>
				</tr>
			</tfoot>
			</table>
			<ul class='link-footer'>
				<li><a href='javascript:SelectContent("<?php echo $tableID;?>");'>Select table</a></li>
			</ul>
		<?php
		
	}
	
	public function salesByCustomer($sqlWhere=''){
		
		ob_start();
			$sql = "SELECT unit, cntTitle as 'Customer', ".$this->oBudget->getMonthlySumSQL(1,15).", SUM(".$this->oBudget->getYTDSQL(1+$this->oBudget->offset,12+$this->oBudget->offset).") as Total, usrTitle as responsible, sales
					FROM `reg_sales`
					LEFT JOIN vw_customer ON customer=cntID					
					LEFT JOIN vw_profit ON pc=pccID	
					LEFT JOIN stbl_user ON sales=usrID
					WHERE posted=1 AND scenario='{$this->oBudget->id}' and kpi=1 {$sqlWhere} 
					GROUP BY sales, `reg_sales`.`customer`, unit
					ORDER BY sales, Total DESC"; 
			//echo $sql;
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
				<tr><th>Customer</th><th>Unit</th>
					<?php 
					echo $this->oBudget->getTableHeader('monthly',1+$this->oBudget->offset,12+$this->oBudget->offset); 
					echo $this->oBudget->getTableHeader('quarterly'); 
					?>
				<th class='budget-ytd'>Total</th></tr>
			</thead>			
			<tbody>
			<?php
			$responsible = null;
			while ($rw=$this->oSQL->f($rs)){
				if ($rw['responsible']!=$responsible){
					?>
					<tr>
						<th colspan="21">By <a target="sales_report" href="rep_my.php?ownerID=<?php echo $rw['sales'];?>"><?php echo $rw['responsible'];?></a></th>
					</tr>
					<?php 
				}				
				?>
				<tr>
					<td><?php echo $rw['Customer'];?></td>
					<td><?php echo $rw['unit'];?></td>
				<?php
				for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
					$month = $this->oBudget->arrPeriod[$m];
					$arrTotal[$rw['unit']][$month] += $rw[$month];
					echo "<td class='budget-decimal budget-monthly budget-$month'>",self::render($rw[$month]),'</td>';
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
				$responsible = $rw['responsible'];
			}
			?>
			</tbody>
			<tfoot>
				<?php 
				foreach ($arrTotal as $unit=>$data){
				?>
				<tr class="budget-subtotal">
					<td colspan="2">Total <?php echo $unit?$unit:"<...>";?></td>
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
			<ul class='link-footer'>
				<li><a href='javascript:SelectContent("<?php echo $tableID;?>");'>Select table</a></li>
			</ul>			
			<?php
			ob_flush();
	}
	
	public function costsBySupplier($sqlWhere=''){
		GLOBAL $oSQL;
		ob_start();
			$sql = "SELECT cntTitle as 'Supplier', unit as 'Unit', ".Budget::getMonthlySumSQL().", SUM(".Budget::getYTDSQL().") as Total FROM `reg_costs`
					LEFT JOIN vw_supplier ON cntID=supplier
					LEFT JOIN vw_item ON itmGUID=item
					$sqlWhere AND posted=1
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
			{$sqlWhere} 
				AND salary>10000";
			
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
						AND active=1
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
							AND Group_code IN (95)
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
			<ul class='link-footer'>
					<li><a href='javascript:SelectContent("<?php echo $tableID;?>");'>Select table</a></li>
			</ul>
			<?php
			ob_flush();
	}
	
	private function _renderHeadcountArray($data, $meta=Array()){
		for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
					$month = $this->oBudget->arrPeriod[$m];
					?>
					<td class="budget-decimal budget-<?php echo $month;?>" data-meta='<?php echo json_encode($meta);?>'><?php self::render($data[$month],1);?></td>
					<?php
				
				}
				?>
					<td class='budget-decimal budget-ytd'><?php echo self::render($data['Total'],1);?></td>
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
				echo '<tr>';
				echo '<th>',$rw['prtGHQ'],'</th>';
				echo '<th>',$rw['account'],'</th>';
				echo '<th>',$rw['Title'],'</th>';
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
			<ul class='link-footer'>
					<li><a href='javascript:SelectContent("<?php echo $tableID;?>");'>Select table</a></li>
			</ul>
			<?php			
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

		$strFields = $this->_getMonthlyFields();
		
		ob_start();
		$sql = "SELECT {$params['field_title']} as 'Level1_title', {$params['field_data']} as 'level1_code', `Budget item`, `Group`, `item`,
					{$strFields}
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
		<ul class='link-footer'>
			<li><a href='javascript:SelectContent("<?php echo $this->ID;?>");'>Select table</a></li>
		</ul>
		<?php			
		ob_flush();
		
	}
	
	public function periodicPnL($sqlWhere, $type='ghq'){ //$params = Array('field_data','field_title','title','yact'=>false)){
		
		switch ($type){
			case 'activity':		
				$params = Array('field_data'=>'activity','field_title'=>'Activity_title','title'=>'Activity');	
				break;
			case 'ghq':
				$params = Array('field_data'=>'prtGHQ','field_title'=>'prtGHQ','title'=>'GHQ');	
				break;
			case 'sales':			
				$params = Array('field_data'=>'sales','field_title'=>'usrTitle','title'=>'Responsible');	
				break;
			case 'bdv':			
				$params = Array('field_data'=>'bdv','field_title'=>'bdvTitle','title'=>'Selling unit');	
				break;
			case 'pc':			
				$params = Array('field_data'=>'pc','field_title'=>'Profit','title'=>'PC');	
				break;
			case 'customer':
				$params = Array('field_data'=>'customer','field_title'=>'Customer_name','title'=>'Customer');
				break;
			case 'customer_group':
			default:			
				$params = Array('field_data'=>'customer_group_code','field_title'=>'customer_group_title','title'=>'Customer group');
				break;
		};		
		
		$strFields_this = $this->_getMonthlyFields();
		$strFields_last = $this->_getMonthlyFields('last');
		
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
		
		ob_start();
		$sql = "SELECT ".$this->oBudget->getMonthlySumSQL(1,15).",\r\n".
				$this->oBudget->getQuarterlySumSQL().
				",SUM(Total) as Total, SUM(Total_AM) as Total_AM, SUM(estimate) as estimate,SUM(estimate_AM) as estimate_AM, 
				SUM(YTD_A) as YTD_A, SUM(YTD) as YTD, SUM(ROY_A) as ROY_A, SUM(ROY) as ROY,
				Level1_title,level1_code,`{$strAccountTitle}` as 'Budget item',`{$strAccountGroup}` as 'Group', `{$strAccountCode}` as 'item'
			FROM 
				(SELECT ({$params['field_title']}) as 'Level1_title', ({$params['field_data']}) as 'level1_code', `{$strAccountTitle}`,`{$strAccountGroup}`, `{$strAccountCode}`,
						{$strFields_this}
				FROM `vw_master` 			
				{$sqlWhere} AND scenario='{$this->oBudget->id}' AND {$strGPFilter} ## Gross margin only
				GROUP BY Level1_code, Level1_title, `{$strAccountCode}` , `{$strAccountTitle}`
				UNION ALL
				SELECT ({$params['field_title']}) as 'Level1_title', ({$params['field_data']}) as 'level1_code', `{$strAccountTitle}`,`{$strAccountGroup}`, `{$strAccountCode}`,
						{$strFields_last}
				FROM `vw_master` 			
				{$sqlWhere} AND scenario='{$this->oReference->id}' AND {$strGPFilter}
				GROUP BY Level1_code, Level1_title,  `{$strAccountCode}` , `{$strAccountTitle}`) Q
			GROUP BY Level1_code, Level1_title, `item` , `Budget item`
			ORDER BY Level1_title, `Group` ASC			
			";
		// echo '<pre>',$sql,'</pre>';
		$this->_firstLevelPeriodic($sql, $params['title'], $this->oBudget);
				
		//==========================================================================================================================Non-customer-related data
		$this->no_firstLevelPeriodic($sqlWhere);
		?>
		</tbody>
		</table>
		<ul class='link-footer'>
			<li><a href='javascript:SelectContent("<?php echo $this->ID;?>");'>Select table</a></li>
		</ul>
		<?php			
		ob_flush();
	}
	
	public function periodicGraph($sqlWhere){
				
		

		
		$strFields_this = $this->_getMonthlyFields();
		$strFields_last = $this->_getMonthlyFields('last');
		
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
		
		$arrGraph[] = Array('Period','Gross revenue','GP','Budget GP','Staff costs','OP','Budget OP');
		
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
		
		//-------------------------------------------------------------------------
		$arrHighCharts = Array(
						'title'=>Array('text'=>'Performance by month','x'=>-20),
						'subtitle'=>Array('text'=>$this->oBudget->title." vs ".$this->oReference->title,'x'=>-20)						
					);
		for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
			$period = $this->oBudget->arrPeriod[$m];
		
			$arrGraph[] = Array($period,(double)$rwGR[$period],(double)$rwGP[$period], (double)$rwBGP[$period], -(double)$rwSC[$period], (double)$rwOP[$period], (double)$rwBOP[$period]);
			$arrHighCharts['xAxis']['categories'][] = $period;
			$arrHighChartsAFF['xAxis']['categories'][] = $period;
			$arrHighChartsOFF['xAxis']['categories'][] = $period;
			$arrHSSeries[0][] = (integer)$rwGR[$period];
			$arrHSSeries[1][] = (integer)$rwGP[$period];
			$arrHSSeries[2][] = (integer)$rwBGP[$period];
			$arrHSSeries[3][] = -(integer)$rwSC[$period];
			$arrHSSeries[4][] = (integer)$rwOP[$period];
			$arrHSSeries[5][] = (integer)$rwBOP[$period];
						
		}
		$arrHighCharts['series']=Array(
									Array('name'=>'Gross revenue','data'=>$arrHSSeries[0])
									,Array('name'=>'Gross profit, actual','data'=>$arrHSSeries[1])
									,Array('name'=>'Gross profit, budget','data'=>$arrHSSeries[2])
									,Array('name'=>'Staff costs','data'=>$arrHSSeries[3])
									,Array('name'=>'OP, actual','data'=>$arrHSSeries[4])
									,Array('name'=>'OP, budget','data'=>$arrHSSeries[5])
								);
								
		$arrHighChartsAFF['series'] = Array(
									Array('name'=>'Export, act','stack'=>'Actual','data'=>array_map('intval',array_values(array_slice($arrKPI['AFF']['Export']['Actual'],0,12))))									
									,Array('name'=>'Import, act','stack'=>'Actual','data'=>array_map('intval',array_values(array_slice($arrKPI['AFF']['Import']['Actual'],0,12))))									
									,Array('name'=>'Export, bud','stack'=>'Budget','data'=>array_map('intval',array_values(array_slice($arrKPI['AFF']['Export']['Budget'],0,12))))									
									,Array('name'=>'Import, bud','stack'=>'Budget','data'=>array_map('intval',array_values(array_slice($arrKPI['AFF']['Import']['Budget'],0,12))))									
								);
								
		$arrHighChartsOFF['series'] = Array(
									Array('name'=>'Export, act','stack'=>'Actual','data'=>array_map('intval',array_values(array_slice($arrKPI['OFF']['Export']['Actual'],0,12))))									
									,Array('name'=>'Import, act','stack'=>'Actual','data'=>array_map('intval',array_values(array_slice($arrKPI['OFF']['Import']['Actual'],0,12))))									
									,Array('name'=>'Export, bud','stack'=>'Budget','data'=>array_map('intval',array_values(array_slice($arrKPI['OFF']['Export']['Budget'],0,12))))									
									,Array('name'=>'Import, bud','stack'=>'Budget','data'=>array_map('intval',array_values(array_slice($arrKPI['OFF']['Import']['Budget'],0,12))))									
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
		</table>
		<ul class='link-footer'>
			<li><a href='javascript:SelectContent("<?php echo $this->ID;?>");'>Select table</a></li>
		</ul>
		<div id='graph_<?php echo $this->ID;?>'>Line chart loading...</div>
		<div id='aff_<?php echo $this->ID;?>'>AFF chart loading...</div>
		<div id='off_<?php echo $this->ID;?>'>OFF chart loading...</div>
		<script type='text/javascript'>
			console.log('Here should be a chart!');
			var target = '#graph_<?php echo $this->ID;?>';
			var targetAFF = '#aff_<?php echo $this->ID;?>';
			var targetOFF = '#off_<?php echo $this->ID;?>';
			$(target).ready(function(){				
				var options = <?php echo json_encode($arrHighCharts);?>;		
				var optionsAFF = <?php echo json_encode($arrHighChartsAFF);?>;		
				var optionsOFF = <?php echo json_encode($arrHighChartsOFF);?>;		
				console.log(optionsAFF);
				// target = document.getElementById(target);	
				// drawGraph(arrData, target, options);
				$(target).highcharts(options);
				$(targetAFF).highcharts(optionsAFF);
				$(targetOFF).highcharts(optionsOFF);
			});
		</script>
		<?php			
		ob_flush();
	}
	
	private function _getKPIGraphData($sqlWhere,$activity){
			
			$sqlSelect = $this->oBudget->getMonthlySumSQL(1+$this->oBudget->offset,max($this->oBudget->length,12+$this->oBudget->offset)).", ".				
				"SUM(".$this->oBudget->getYTDSQL(4,15,$arrRates_this, $this->Denominator).") as Total_AM";
			
			
			$sql = "SELECT {$sqlSelect}
					FROM `vw_sales` 			
					{$sqlWhere} AND scenario='{$this->oReference->id}' AND activity={$activity} AND source='Actual'";
			$rs = $this->oSQL->q($sql);
			$res['Budget'] = $this->oSQL->f($rs);
			
			$sql = "SELECT {$sqlSelect}
					FROM `vw_sales` 			
					{$sqlWhere} AND scenario='{$this->oReference->id}' AND activity={$activity} AND source<>'Actual'";
			$rs = $this->oSQL->q($sql);
			$rw = $this->oSQL->f($rs); 
			for ($m=(integer)date('n',$this->oReference->date_start);$m<=12+$this->oBudget->offset;$m++){
				$month = $this->oBudget->arrPeriod[$m];
				$res['Budget'][$month] += (integer)$rw[$month];
				$res['Budget']['Total_AM'] += (integer)$rw[$month];
			}
			
			$sql = "SELECT {$sqlSelect}
					FROM `vw_sales` 			
					{$sqlWhere} AND scenario='{$this->oBudget->id}' AND activity={$activity} AND source='Actual'";
			$rs = $this->oSQL->q($sql);			
			$res['Actual'] = $this->oSQL->f($rs);
			
			$sql = "SELECT {$sqlSelect}
					FROM `vw_sales` 			
					{$sqlWhere} AND scenario='{$this->oBudget->id}' AND activity={$activity} AND source<>'Actual'";
			$rs = $this->oSQL->q($sql);
			$rw = $this->oSQL->f($rs); 
			for ($m=(integer)date('n',$this->oBudget->date_start);$m<=12+$this->oBudget->offset;$m++){
				$month = $this->oBudget->arrPeriod[$m];
				$res['Actual'][$month] += (integer)$rw[$month];
				$res['Actual']['Total_AM'] += (integer)$rw[$month];
			}
			
			return($res);
	}
	
	public function monthlyReport($type='ghq'){
		
		// GLOBAL $budget_scenario;
		// $oBudget = new Budget($budget_scenario);
		
		$sqlWhere = $this->sqlWhere;
		
		switch($type){
			case 'activity':
				$sqlMeasure = "Activity_title as 'Level1_title', activity as 'level1_code', `Budget item`, `Group`, `item`,`itmOrder`,";
				$strGroupTitle = 'Activity';
				break;
			case 'customer':
				$sqlMeasure = "Customer_name as 'Level1_title', customer as 'level1_code', `Budget item`, `Group`, `item`,`itmOrder`,";
				$strGroupTitle = 'Customer';
				break;
			case 'customer_group':
				$sqlMeasure = "customer_group_title as 'Level1_title'
						, customer_group_code as 'level1_code', `Budget item`, `Group`, `item`,`itmOrder`,";
				$strGroupTitle = 'Customer group';
				break;
			case 'sales':
				$sqlMeasure = "usrTitle as 'Level1_title', sales as 'level1_code', `Budget item`, `Group`, `item`,`itmOrder`,";
				$strGroupTitle = 'BDV employee';
				break;
			case 'bdv':
				$sqlMeasure = "bdvTitle as 'Level1_title', bdv as 'level1_code', `Budget item`, `Group`, `item`,`itmOrder`,";
				$strGroupTitle = 'Selling unit';
				break;
			case 'pc':
				$sqlMeasure = "Profit as 'Level1_title', pc as 'level1_code', `Budget item`, `Group`, `item`,`itmOrder`,";
				$strGroupTitle = 'Business unit';
				break;
			case 'ghq':
			default:
				$sqlMeasure = "prtGHQ as 'Level1_title', prtGHQ as 'level1_code', `Budget item`, `Group`, `item`,`itmOrder`,";
				$strGroupTitle = 'GHQ segment';
				break;
		}
		
		$strFields = $this->_getMonthlyFields();
		
		$strFields = $this->_getMRFields();
		
		$sqlGroup = "GROUP BY Level1_title, level1_code, `Budget item`, `item`, `Group`";
		
		ob_start();
		
		$sql = "SELECT {$sqlMeasure}
					{$strFields['actual']}
			FROM `vw_master`			
			{$sqlWhere}  AND scenario='{$strFields['from_a']}' AND Group_code=".self::GP_CODE." 
			{$sqlGroup}	
			UNION ALL
				SELECT {$sqlMeasure}
				{$strFields['budget']}
			FROM `vw_master`				
			{$sqlWhere} AND scenario='{$strFields['from_b']}' AND Group_code=".self::GP_CODE."  
			{$sqlGroup}			
			ORDER BY `Group`, `itmOrder` ASC";
		
		$sql = "SELECT `Level1_title`, `level1_code`, `Budget item`, `Group`, `item`,`itmOrder`,
					SUM(CM_A) as CM_A,
					SUM(CM_B) as CM_B,
					SUM(YTD_A) as YTD_A,
					SUM(YTD_B) as YTD_B,
					SUM(NM_A) as NM_A,
					SUM(NM_B) as NM_B
				FROM ({$sql}) U {$sqlGroup} 
				ORDER BY `level1_code`, `Group`, `itmOrder` ASC";
			
			
			self::firstLevelReportMR($sql, $strGroupTitle, $this->oBudget);
			$tableID = "FLR_".md5($sql);
			//==========================================================================================================================Non-customer-related data
			self::noFirstLevelReportMR($this->currency);
			?>
			</tbody>
			</table>
			<ul class='link-footer'>
					<li><a href='javascript:SelectContent("<?php echo $tableID;?>");'>Select table</a></li>
			</ul>
			<?php			
			ob_flush();
	}
	
	public function monthlyReportGHQ($type='ghq'){
		
		GLOBAL $budget_scenario;
		$oBudget = new Budget($budget_scenario);
		
		$sqlWhere = $this->sqlWhere;
		
		switch($type){
			case 'activity':
				$sqlMeasure = "Activity_title as 'Level1_title', activity as 'level1_code', `Budget item`, `Group`, `item`,`itmOrder`,";
				$strGroupTitle = 'Activity';
				break;
			case 'customer':
				$sqlMeasure = "Customer_name as 'Level1_title', customer as 'level1_code', `Budget item`, `Group`, `item`,`itmOrder`,";
				$strGroupTitle = 'Customer';
				break;
			case 'customer_group':
				$sqlMeasure = "CASE WHEN customer_group_code=".self::CNT_GROUP_EXEMPTION." THEN Customer_name ELSE customer_group_title END as 'Level1_title'
						, CASE WHEN customer_group_code=".self::CNT_GROUP_EXEMPTION." THEN customer ELSE customer_group_code END as 'level1_code', `Budget item`, `Group`, `item`,`itmOrder`,";
				$strGroupTitle = 'Customer group';
				break;
			case 'sales':
				$sqlMeasure = "usrTitle as 'Level1_title', sales as 'level1_code', `Budget item`, `Group`, `item`,`itmOrder`,";
				$strGroupTitle = 'BDV employee';
				break;
			case 'bdv':
				$sqlMeasure = "bdvTitle as 'Level1_title', bdv as 'level1_code', `Budget item`, `Group`, `item`,`itmOrder`,";
				$strGroupTitle = 'Selling unit';
				break;
			case 'pc':
				$sqlMeasure = "Profit as 'Level1_title', pc as 'level1_code', `Budget item`, `Group`, `item`,`itmOrder`,";
				$strGroupTitle = 'Business unit';
				break;
			case 'ghq':
			default:
				$sqlMeasure = "prtGHQ as 'Level1_title', prtGHQ as 'level1_code', `Budget item`, `Group`, `item`,`itmOrder`,";
				$strGroupTitle = 'GHQ segment';
				break;
		}
		
		$strFields = $this->_getMonthlyFields();
		
		$strFields = $this->_getMRFields();
		
		$sqlGroup = "GROUP BY Level1_title, level1_code, `Budget item`, `item`, `Group`";
		
		ob_start();
		
		$sql = "SELECT {$sqlMeasure}
					{$strFields['actual']}
			FROM `vw_master`			
			{$sqlWhere}  AND scenario='{$strFields['from_a']}' AND Group_code=".self::GP_CODE." 
			{$sqlGroup}	
			UNION ALL
				SELECT {$sqlMeasure}
				{$strFields['budget']}
			FROM `vw_master`				
			{$sqlWhere} AND scenario='{$strFields['from_b']}' AND Group_code=".self::GP_CODE."  
			{$sqlGroup}			
			ORDER BY `Group`, `itmOrder` ASC";
		
		$sql = "SELECT `Level1_title`, `level1_code`, `Budget item`, `Group`, `item`,`itmOrder`,
					SUM(CM_A) as CM_A,
					SUM(CM_B) as CM_B,
					SUM(YTD_A) as YTD_A,
					SUM(YTD_B) as YTD_B,
					SUM(NM_A) as NM_A,
					SUM(NM_B) as NM_B
				FROM ({$sql}) U {$sqlGroup} 
				ORDER BY `level1_code`, `Group`, `itmOrder` ASC";
			
			
			self::firstLevelReportMR($sql, $strGroupTitle, $oBudget);
			$tableID = "FLR_".md5($sql);
			//==========================================================================================================================Non-customer-related data
			// self::noFirstLevelReportMR($this->currency);
			?>
			</tbody>
			</table>
			<ul class='link-footer'>
					<li><a href='javascript:SelectContent("<?php echo $tableID;?>");'>Select table</a></li>
			</ul>
			<?php			
			ob_flush();
	}
	
	public function masterYactbyActivityEst($sqlWhere){
		global $oSQL;
		
		$strFields = self::_getMonthlyFields($currency);
		
		ob_start();
			$sql = "SELECT prtGHQ as 'Level1_title', activity as 'level1_code', CONCAT(`account`,': ',`Title`) as `Budget item`, Yact_group as `Group`, account as `item`,
					{$strFields}				
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
		
		if (!$rs = $this->oSQL->q($sql)){
				echo "<div class='error'>SQL error:</div>";
				echo "<pre>",$sql,"</pre>";
				return (false);
			};
			?>
			<table id='<?php echo $tableID;?>' class='budget'>
			<thead>
				<tr>
					<th><?php echo $firstLevelTitle; ?></th>
					<th>Account</th>					
					<?php 
						echo $this->oBudget->getTableHeader('monthly',1+$this->oBudget->offset,12+$this->oBudget->offset);
						echo $this->oBudget->getTableHeader('quarterly');
					?>		
					<th class='budget-ytd'><?php echo $this->oBudget->type=='Budget'?'Budget':'FYE';?></th>
					<th><?php echo $this->oBudget->type=='Budget'?$this->oReference->id:'Budget';?></th>
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
					}
					?>
				</tr>
			</thead>			
			<tbody>
			<?php
			if ($this->oSQL->num_rows($rs)){
				$Level1_title = '';		
				
				while ($rw=$this->oSQL->f($rs)){
					
					if ($rw['item']){
						foreach ($rw as $key=>$value){						
							 $arrGrandTotal[$key] += $value;
						}
					}
					
					$l1Code = (string)$rw['level1_code'];
					$arrSubreport[$l1Code][$rw['item']] = Array('Level1_title'=>$rw['Level1_title'],'Budget item'=>$rw['Budget item'],'level1_code'=>$l1Code);
			
					for ($m=1;$m<=15;$m++){
						// $month = $this->oBudget->arrPeriod[$m];
						$month = $this->oBudget->arrPeriod[$m];
						
						$arrSubreport[$l1Code][$rw['item']][$month]+=$rw[$month];
						if ($m<=5){
							$arrSubreport[$l1Code][$rw['item']]['Q'.$m]+=$rw['Q'.$m];
						};
						// $local_subtotal += $rw[$month];
						
					};
					
					$arrSubreport[$l1Code][$rw['item']]['YTD_A']+=$rw['YTD_A'];
					$arrSubreport[$l1Code][$rw['item']]['YTD']+=$rw['YTD'];
					$arrSubreport[$l1Code][$rw['item']]['ROY_A']+=$rw['ROY_A'];
					$arrSubreport[$l1Code][$rw['item']]['ROY']+=$rw['ROY'];
					$arrSubreport[$l1Code][$rw['item']]['Total']+=$rw['Total'];
					$arrSubreport[$l1Code][$rw['item']]['Total_AM']+=$rw['Total_AM'];
					$arrSubreport[$l1Code][$rw['item']]['estimate']+=$rw['estimate'];
					$arrSubreport[$l1Code][$rw['item']]['estimate_AM']+=$rw['estimate_AM'];
					$arrSubreport[$l1Code][$rw['item']]['Total_AprMar']+=$rw['Total_AprMar'];
					$arrSubreport[$l1Code][$rw['item']]['Total_15']+=$rw['Total_15'];
										
					$arrSort[$l1Code]['value'] += $rw['Total'];
					
					if (!$template) $template = $rw;
					
				}
							
				arsort($arrSort);
				foreach ($arrSort as $key=>$value){
					$arrReport[$key] = $arrSubreport[$key];
				}
				
				// echo '<pre>';print_r($arrReport);echo '</pre>';die();
				foreach ($arrReport as $key=>$data){
					$this->echoBudgetItemString($data, 'budget-item');
				}
				
					$arrGrandTotal['Budget item'] = 'Grand total';
					return ($arrGrandTotal);
			}
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
			<thead>
				<tr>
					<th rowspan="2"><?php echo $firstLevelTitle; ?></th>
					<th rowspan="2">Account</th>
					<?php echo $this->oBudget->getTableHeader('mr'); 							
					?>					
			</thead>			
			<tbody>
			<?php
			if ($this->oSQL->num_rows($rs)){
				$Level1_title = '';		
				
				while ($rw=$this->oSQL->f($rs)){
					
					foreach ($rw as $key=>$value){
						$arrGrandTotal[$key] += $value;
					}
					
					$l1Code = (string)$rw['level1_code'];
					$arrSubreport[$l1Code][$rw['item']] = Array('Level1_title'=>$rw['Level1_title'],'Budget item'=>$rw['Budget item'],'level1_code'=>$l1Code);
											
					$arrSubreport[$l1Code][$rw['item']]['CM_A'] += $rw['CM_A'];
					$arrSubreport[$l1Code][$rw['item']]['CM_B'] += $rw['CM_B'];
					$arrSubreport[$l1Code][$rw['item']]['YTD_A'] += $rw['YTD_A'];
					$arrSubreport[$l1Code][$rw['item']]['YTD_B'] += $rw['YTD_B'];
					$arrSubreport[$l1Code][$rw['item']]['NM_A'] += $rw['NM_A'];
					$arrSubreport[$l1Code][$rw['item']]['NM_B'] += $rw['NM_B'];

					
					$arrSort[$l1Code]['value'] += $rw['YTD_A'];
					
					if (!$template) $template = $rw;
					
				}
							
				arsort($arrSort);
				foreach ($arrSort as $key=>$value){
					$arrReport[$key] = $arrSubreport[$key];
				}
				
				// echo '<pre>';print_r($arrReport);echo '</pre>';die();
				foreach ($arrReport as $key=>$data){
					$this->echoBudgetItemString($data, 'budget-item', $oBudget);
				}
				
					$arrGrandTotal['Budget item'] = 'Grand total';
					return ($arrGrandTotal);
			}
	}
	
	
	private function noFirstLevelReport_YACT($sqlWhere){
				
		global $oSQL;
		
		$strFields = self::_getMonthlyFields($currency);
		
		$sql = "SELECT CONCAT(`account`,': ',`Title`) as `Budget item`, `item`, yact_group as `Group`, yact_group_code as `Group_code`, 
			{$strFields}
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
				$subtotal[$rw['Group']]['ROY'] += $rw['ROY'];
				
				$grandTotal['Total'] += $local_subtotal;
				$grandTotal['estimate'] += $rw['estimate'];
				$grandTotal['YTD_A'] += $rw['YTD_A'];
				$grandTotal['YTD'] += $rw['YTD'];
				$grandTotal['ROY_A'] += $rw['ROY_A'];
				$grandTotal['ROY'] += $rw['ROY'];
				
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
	
	private function no_firstLevelPeriodic($sqlWhere){
				
		$strFields_this = $this->_getMonthlyFields();
		$strFields_last = $this->_getMonthlyFields('last');
		$sqlGroup = "GROUP BY item, `Budget item`";
		
		if ($this->YACT){
			$strAccountTitle = "title";
			$strAccountGroup = "yact_group";
			$strAccountCode = "account";
			$strGroupCode = 'yact_group_code';
			$strGPFilter = "yact_group_code IN ('449000','499000')"; 
		} else {
			$strAccountTitle = "Budget item";
			$strAccountGroup = "Group";
			$strAccountCode = "item";
			$strGroupCode = 'Group_code';
			$strGPFilter = "Group_code=".self::GP_CODE; 
		}
		
		$sql = "SELECT ".$this->oBudget->getMonthlySumSQL(1,15).",\r\n".
				$this->oBudget->getQuarterlySumSQL().
				",SUM(Total) as Total, SUM(Total_AM) as Total_AM, SUM(estimate) as estimate,SUM(estimate_AM) as estimate_AM,
				SUM(YTD_A) as YTD_A, SUM(YTD) as YTD, SUM(ROY_A) as ROY_A, SUM(ROY) as ROY,
				`Budget item`,`Group`, `item`, `Group_code`
			FROM 
				(SELECT `{$strAccountTitle}` as 'Budget item',`{$strAccountGroup}` as 'Group', `{$strAccountCode}` as 'item', {$strGroupCode} as Group_code,
						{$strFields_this}
				FROM `vw_master` 			
				{$sqlWhere} AND scenario='{$this->oBudget->id}' AND `{$strAccountCode}` IS NOT NULL
				{$sqlGroup}
				UNION ALL
				SELECT `{$strAccountTitle}` as 'Budget item',`{$strAccountGroup}` as 'Group', `{$strAccountCode}` as 'item', {$strGroupCode} as Group_code,
						{$strFields_last}
				FROM `vw_master` 			
				{$sqlWhere} AND scenario='{$this->oReference->id}' AND `{$strAccountCode}` IS NOT NULL 
				{$sqlGroup}) Q
			{$sqlGroup}
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
											
					$subtotal[$rw['Group']]['Total'] += $rw['Total'];
					$subtotal[$rw['Group']]['Total_AM'] += $rw['Total_AM'];
					$subtotal[$rw['Group']]['estimate'] += $rw['estimate'];
					$subtotal[$rw['Group']]['estimate_AM'] += $rw['estimate_AM'];
					$subtotal[$rw['Group']]['YTD_A'] += $rw['YTD_A'];
					$subtotal[$rw['Group']]['YTD'] += $rw['YTD'];
					$subtotal[$rw['Group']]['ROY_A'] += $rw['ROY_A'];
					$subtotal[$rw['Group']]['ROY'] += $rw['ROY'];
					
					for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
					// $month = $this->oBudget->arrPeriod[$m];
						$month = $this->oBudget->arrPeriod[$m];
						$subtotal[$rw['Group']][$month]+=$rw[$month];														
						$local_subtotal += $rw[$month];
						$grandTotal[$month] += $rw[$month];					
					}
					
					$grandTotal['Total'] += $rw['Total'];
					$grandTotal['Total_AM'] += $rw['Total_AM'];
					$grandTotal['estimate'] += $rw['estimate'];
					$grandTotal['estimate_AM'] += $rw['estimate_AM'];
					$grandTotal['YTD_A'] += $rw['YTD_A'];
					$grandTotal['YTD'] += $rw['YTD'];
					$grandTotal['ROY_A'] += $rw['ROY_A'];
					$grandTotal['ROY'] += $rw['ROY'];
					
					for ($q = 1+$this->oBudget->offset/3;$q<=4+$this->oBudget->offset/3;$q++){
						$subtotal[$rw['Group']]['Q'.$q]+=$rw['Q'.$q];	
						$grandTotal['Q'.$q] += $rw['Q'.$q];
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
			
		//------ Operating income -------
		
		$sqlOps = str_replace($sqlWhere, $sqlWhere." AND (account NOT LIKE '6%' AND account NOT LIKE '7%' AND account NOT LIKE 'SZ%')", $sql);
		$sqlOps = str_replace($sqlGroup, '', $sqlOps);
		$rs = $this->oSQL->q($sqlOps);
		while ($rw = $this->oSQL->f($rs)){
			$rw['Budget item'] = "Operating income";
			$this->echoBudgetItemString($rw,'budget-subtotal');
		}
			
	}
	
	private function noFirstLevelReportMR($currency=643){
				
		global $oSQL;		
		$sqlWhere = $this->sqlWhere;
		
		$strFields = self::_getMRFields($currency);
		$strFieldsKPI = self::_getMRFields(Array('currency'=>643,'denominator'=>1));
		
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
					$subtotal[$rw['Group']]['CM_A'] += $rw['CM_A'];
					$subtotal[$rw['Group']]['CM_B'] += $rw['CM_B'];
					$subtotal[$rw['Group']]['YTD_A'] += $rw['YTD_A'];
					$subtotal[$rw['Group']]['YTD_B'] += $rw['YTD_B'];
					$subtotal[$rw['Group']]['NM_A'] += $rw['NM_A'];
					$subtotal[$rw['Group']]['NM_B'] += $rw['NM_B'];
					
					$grandTotal['CM_A'] += $rw['CM_A'];
					$grandTotal['CM_B'] += $rw['CM_B'];
					$grandTotal['YTD_A'] += $rw['YTD_A'];
					$grandTotal['YTD_B'] += $rw['YTD_B'];
					$grandTotal['NM_A'] += $rw['NM_A'];
					$grandTotal['NM_B'] += $rw['NM_B'];				
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
		
		?>
			<tr><th colspan="14">Other financials</th></tr>
		<?php			
		//------ Operating income -------
		
		$sqlOps = str_replace($sqlWhere, $sqlWhere." AND (account NOT LIKE '6%' AND account NOT LIKE '7%' AND account NOT LIKE 'SZ%')", $sql);
		$sqlOps = str_replace(array("GROUP BY $sqlGroup",$sqlGroup.",","ORDER BY $sqlOrder"), '', $sqlOps);
		$rs = $oSQL->q($sqlOps);
		while ($rw = $oSQL->f($rs)){
			$rw['Budget item'] = "Operating income";
			$this->echoBudgetItemString($rw,'budget-subtotal');
		}
		
		//------ Gross revenue -------
		
		$sqlOps = str_replace($sqlWhere, $sqlWhere." AND (account = 'J00400')", $sql);
		$sqlOps = str_replace(array("GROUP BY $sqlGroup",$sqlGroup.",","ORDER BY $sqlOrder"), '', $sqlOps);
		$rs = $oSQL->q($sqlOps);
		while ($rw = $oSQL->f($rs)){
			$rw['Budget item'] = "Gross revenue";
			$this->echoBudgetItemString($rw);
		}
		
		//------ JO freight -------
		
		// $sqlOps = str_replace($sqlWhere, $sqlWhere." AND (account IN ('SZ0001','SZ0011'))", $sql);
		// $sqlOps = str_replace($sqlGroup, 'GROUP BY account', $sqlOps);
		// $rs = $oSQL->q($sqlOps);
		// while ($rw = $oSQL->f($rs)){
			// $rw['Budget item'] = "Job owner's freight revenue";
			// $this->echoBudgetItemString($rw);
		// }
		
		//------- KPIs -----------------
		
		$sql = "SELECT activity, unit, 
					{$strFieldsKPI['actual']}
			FROM `reg_sales`			
			{$sqlWhere}  AND scenario='{$strFieldsKPI['from_a']}' AND kpi=1 AND posted=1 AND source='Actual'
			GROUP BY activity, unit
			UNION ALL
			SELECT activity, unit, 
					{$strFieldsKPI['next']}
			FROM `reg_sales`			
			{$sqlWhere}  AND scenario='{$strFieldsKPI['from_a']}' AND kpi=1 AND posted=1
			GROUP BY activity, unit
			UNION ALL
				SELECT activity, unit, 
				{$strFieldsKPI['budget']}
			FROM `reg_sales`				
			{$sqlWhere} AND scenario='{$strFieldsKPI['from_b']}' AND kpi=1 AND posted=1 
			GROUP BY activity, unit
			ORDER BY activity, unit";
			
		$sql = "SELECT prtTitle, activity, unit, 
					SUM(CM_A) as CM_A,
					SUM(CM_B) as CM_B,
					SUM(YTD_A) as YTD_A,
					SUM(YTD_B) as YTD_B,
					SUM(NM_A) as NM_A,
					SUM(NM_B) as NM_B					
				FROM ($sql) U
				LEFT JOIN vw_product_type ON activity=prtID
				WHERE unit<>''
				GROUP BY activity, unit
				ORDER BY prtGHQ";
		// echo '<pre>',$sql,'</pre>';
		$rs = $oSQL->q($sql);
		if ($oSQL->n($rs)){
			?>
			<tr><th colspan="14">Operational KPIs</th></tr>
			<?php		
			while ($rw = $oSQL->f($rs)){			
				$rw['Budget item'] = $rw['prtTitle']." ({$rw['unit']})";
				$filter = $this->filter;
				$filter['activity'] = $rw['activity'];
				$arrMetadata = Array('filter' => $filter, 'DataAction' => 'kpiByCustomer', 'title'=>$rw['prtTitle']);
				$rw['metadata'] = json_encode($arrMetadata);
				$rw['href'] = "javascript:getDetails(".json_encode($arrMetadata).");";
				$this->echoBudgetItemString($rw);
			}
		}
		//------- Headcount -----------------
		$this->_getMRHeadcount($sqlWhere);
		
	}
	
	private function _getMRHeadcount($sqlWhere, $type='collars'){
		
		$strFieldsKPI = self::_getMRFields(Array('currency'=>643,'denominator'=>1));
		?>
		<tr><th colspan="14">Headcount</th></tr>
		<?php
		
		switch($type){
			case 'funRHQ':
				$field = "IF(funRHQ='',funTitleLocal, funRHQ)";
				$groupBy = "IF(funRHQ='',funTitleLocal, funRHQ)";	
				break;
			default:
				$field = "IF(`wc`=1,'White collars','Blue collars')";
				$groupBy = 'wc';
				break;
		}
		
		$sql = "SELECT  {$field} as `Budget item`, 
					{$strFieldsKPI['actual']}
			FROM `vw_headcount`			
			{$sqlWhere}  AND scenario='{$strFieldsKPI['from_a']}' AND source='Actual' AND salary>".self::SALARY_THRESHOLD."
			GROUP BY  {$groupBy}
			UNION ALL
			SELECT   {$field}, 
					{$strFieldsKPI['next']}
			FROM `vw_headcount`			
			{$sqlWhere}  AND scenario='{$strFieldsKPI['from_a']}'  AND salary>".self::SALARY_THRESHOLD."
			GROUP BY  {$groupBy}
			UNION ALL
				SELECT   {$field}, 
				{$strFieldsKPI['budget']}
			FROM `vw_headcount`				
			{$sqlWhere} AND scenario='{$strFieldsKPI['from_b']}' AND salary>".self::SALARY_THRESHOLD."
			GROUP BY  {$groupBy}
			";
			
		$sql = "SELECT  `Budget item`, 
					SUM(CM_A) as CM_A,
					SUM(CM_B) as CM_B,
					SUM(YTD_A) as YTD_A,
					SUM(YTD_B) as YTD_B,
					SUM(NM_A) as NM_A,
					SUM(NM_B) as NM_B					
				FROM ($sql) U	
				GROUP BY `Budget item`
				ORDER BY `Budget item`";
		// echo '<pre>',$sql,'</pre>';
		
		$cm = date('n',$this->oBudget->date_start - 1);
		
		$rs = $this->oSQL->q($sql);
		if (!$this->oSQL->n($rs)){
			echo '<pre>',$sql,'</pre>';
		}
		while ($rw = $this->oSQL->f($rs)){			
			// $rw['Budget item'] = $rw['wc']?"White collars":"Blue collars";
			
			$rw['YTD_A'] = $rw['YTD_A']/($cm-$this->oBudget->offset);
			$rw['YTD_B'] = $rw['YTD_B']/($cm-$this->oBudget->offset);
			
			$rw['ROY_A'] = $rw['ROY_A']/(12-($cm-$this->oBudget->offset));
			$rw['ROY_B'] = $rw['ROY_B']/(12-($cm-$this->oBudget->offset));
			
			$this->echoBudgetItemString($rw);
		}
	}
	
	public function kpiByCustomerMR(){
		
		GLOBAL $oSQL;
		
		$sqlWhere = $this->sqlWhere;
		$strFields = self::_getMRFields(643);
		
		
		$sql = "SELECT customer,cntTitle, customer_group_code,customer_group_title, 
					{$strFields['actual']}
			FROM `vw_sales`			
			{$sqlWhere}  AND scenario='{$strFields['from_a']}' AND kpi=1 AND posted=1 AND source='Actual'
			GROUP BY customer
			UNION ALL
			SELECT customer,cntTitle, customer_group_code,customer_group_title, 
					{$strFields['next']}
			FROM `vw_sales`			
			{$sqlWhere}  AND scenario='{$strFields['from_a']}' AND kpi=1 AND posted=1
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
			<ul class='link-footer'>
				<li><a href='javascript:SelectContent("<?php echo $tableID;?>");'>Select table</a></li>
			</ul>
			<?php
		} else {
			echo '<h3>No records found</h3>';
			echo '<pre>',$sql,'</pre>';
		}
			
	}
	
	private function _getMonthlyFields($type='this'){
		// GLOBAL $budget_scenario;
		// $oBudget = new Budget($budget_scenario);
		switch ($type){
		case 'this':
			$arrRates = $this->oBudget->getMonthlyRates($this->Currency);
			// echo '<pre>';print_r($arrRates);echo '</pre>';
			$res=	$this->oBudget->getMonthlySumSQL(1,15,$arrRates, $this->Denominator).", \r\n".
					$this->oBudget->getQuarterlySumSQL($arrRates, $this->Denominator).", \r\n 
					SUM(".$this->oBudget->getYTDSQL(1+$this->oBudget->offset,12+$this->oBudget->offset,$arrRates, $this->Denominator).") as Total,\r\n
					SUM(".$this->oBudget->getYTDSQL(1,12,$arrRates, $this->Denominator).") as Total_JD ,\r\n
					SUM(".$this->oBudget->getYTDSQL(4,15,$arrRates, $this->Denominator).") as Total_AM ,\r\n
					0 as estimate, 
					0 as estimate_JD, 
					0 as estimate_AM, 
					SUM(".$this->oBudget->getYTDSQL(1+$this->oBudget->offset, (integer)date('n',$this->oBudget->date_start)-1,$arrRates, $this->Denominator).") as YTD_A, 
					0 as YTD, 
					SUM(".$this->oBudget->getYTDSQL((integer)date('n',$this->oBudget->date_start),12+$this->oBudget->offset,$arrRates, $this->Denominator).") as ROY_A, 
					0 as ROY";
			break;
		case 'last':
			$arrRates = $this->oReference->getMonthlyRates($this->Currency);
			$res=	str_repeat('0,',15)." \r\n".
					str_repeat('0,',5)." \r\n
					0 as Total, \r\n
					0 as Total_JD, \r\n
					0 as Total_AM, \r\n
					SUM(".$this->oBudget->getYTDSQL(1+$this->oBudget->offset,12+$this->oBudget->offset,$arrRates, $this->Denominator).") as estimate ,
					SUM(".$this->oBudget->getYTDSQL(1,12,$arrRates, $this->Denominator).") as estimate_JD ,
					SUM(".$this->oBudget->getYTDSQL(4,15,$arrRates, $this->Denominator).") as estimate_AM ,
					0 as YTD_A,
					SUM(".$this->oBudget->getYTDSQL(1+$this->oBudget->offset, (integer)date('n',$this->oBudget->date_start)-1,$arrRates, $this->Denominator).") as YTD, 
					0 as ROY_A,
					SUM(".$this->oBudget->getYTDSQL((integer)date('n',$this->oBudget->date_start),12+$this->oBudget->offset,$arrRates, $this->Denominator).") as ROY";
					
			break;
		}
		// echo '<pre>';print_r($arrRates);echo '</pre>';
		return ($res);
		
	}
	
	private function _getMRFields($params=Array()){
		
		$currency = $params['currency']?$params['currency']:$this->Currency;
		$denominator = $params['denominator']?$params['denominator']:$this->Denominator;
		
		$arrRates = $this->oBudget->getMonthlyRates($this->Currency);
		
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
		$local_subtotal = 0;
		$ytd = 0;
		$roy = 0;
		if (isset($data['CM_A'])){ ?>
			<td class='budget-decimal budget-ytd'><?php self::render($data['CM_A'],0);?></td>
			<td class='budget-decimal'><?php self::render($data['CM_B'],0);?></td>
			<td class='budget-decimal'><?php self::render($data['CM_A']-$data['CM_B'],0);?></td>
			<td class='budget-decimal'><em><?php self::render_ratio($data['CM_A'],$data['CM_B']);?></em></td>
			
			<td class='budget-decimal budget-quarterly'><?php self::render($data['YTD_A'],0);?></td>
			<td class='budget-decimal'><?php self::render($data['YTD_B'],0);?></td>
			<td class='budget-decimal'><?php self::render($data['YTD_A']-$data['YTD_B'],0);?></td>
			<td class='budget-decimal'><em><?php self::render_ratio($data['YTD_A'],$data['YTD_B']);?></em></td>
			
			<td class='budget-decimal budget-ytd'><?php self::render($data['NM_A'],0);?></td>
			<td class='budget-decimal'><?php self::render($data['NM_B'],0);?></td>
			<td class='budget-decimal'><?php self::render($data['NM_A']-$data['NM_B'],0);?></td>
			<td class='budget-decimal'><em><?php self::render_ratio($data['NM_A'],$data['NM_B']);?></em></td>
		<?php		
		} elseif (isset($data['apr'])) {
			for ($m=1+$this->oBudget->offset;$m<=12+$this->oBudget->offset;$m++){
				// $month = $this->oBudget->arrPeriod[$m];
				$month = $this->oBudget->arrPeriod[$m];
				?>
				<td class='budget-decimal budget-monthly budget-<?php echo $month;?>'><?php self::render($data[$month],0);?></td>
				<?php
			}
			
			//--------------------- quarterly data -----------------------
			if(isset($data['Q1']) || isset($data['Q2']) || isset($data['Q3']) || isset($data['Q4']) || isset($data['Q5'])){
				for ($q=1+$this->oBudget->offset/3;$q<5+$this->oBudget->offset/3;$q++){
					?>
					<td class='budget-decimal budget-quarterly budget-<?php echo 'q'.$q;?>'><?php self::render($data['Q'.$q],0);?></td>
					<?php
				}
			}
			?>
			<td class='budget-decimal budget-ytd'><?php self::render($data['Total'],0);?></td>			
			<?php 
			if (isset($data['estimate'])){
				?>
				<td class='budget-decimal'><?php self::render($data['estimate'],0);?></td>
				<td class='budget-decimal'><?php self::render($data['Total']-$data['estimate'],0);?></td>
				<td class='budget-decimal'><em><?php self::render_ratio($data['Total'],$data['estimate']);?></em></td>
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
					<td class='budget-decimal budget-ytd'><?php self::render($data['YTD_A'],0);?></td>
					<td class='budget-decimal'><?php self::render($data['YTD'],0);?></td>
					<td class='budget-decimal'><?php self::render($data['YTD_A']-$data['YTD'],0);?></td>
					<td class='budget-decimal'><em><?php self::render_ratio($data['YTD_A'],$data['YTD']);?></em></td>
					<!--Data for rest-of-year-->
					<td class='budget-decimal budget-ytd'><?php self::render($data['ROY_A'],0);?></td>
					<td class='budget-decimal'><?php self::render($data['ROY'],0);?></td>
					<td class='budget-decimal'><?php self::render($data['ROY_A']-$data['ROY'],0);?></td>
					<td class='budget-decimal'><em><?php self::render_ratio($data['ROY_A'],$data['ROY']);?></em></td>
				<?php
				}
			}
		} else {
			?>		
			<td class='budget-decimal budget-ytd'><?php self::render($data['YTD_A'],0);?></td>
			<td class='budget-decimal'><?php self::render($data['YTD_B'],0);?></td>
			<td class='budget-decimal'><?php self::render($data['YTD_A']-$data['YTD_B'],0);?></td>
			<td class='budget-decimal'><em><?php self::render_ratio($data['YTD_A'],$data['YTD_B']);?></em></td>
			
			<td class='budget-decimal budget-ytd'><?php self::render($data['ROY_A'],0);?></td>
			<td class='budget-decimal'><?php self::render($data['ROY_B'],0);?></td>
			<td class='budget-decimal'><?php self::render($data['ROY_A']-$data['ROY_B'],0);?></td>
			<td class='budget-decimal'><em><?php self::render_ratio($data['ROY_A'],$data['ROY_B']);?></em></td>
			
			<td class='budget-decimal budget-quarterly'><?php self::render($data['FYE_A'],0);?></td>
			<td class='budget-decimal'><?php self::render($data['FYE_B'],0);?></td>
			<td class='budget-decimal'><?php self::render($data['FYE_A']-$data['FYE_B'],0);?></td>
			<td class='budget-decimal'><em><?php self::render_ratio($data['FYE_A'],$data['FYE_B']);?></em></td>
			<?php
		}
	}
	
	private function echoBudgetItemString($data, $strClass=''){							
		GLOBAL $arrUsrData;
		ob_start();
		static $Level1_title;
		
		// echo '<pre>';print_r($data);echo '</pre>';
		
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
						<tr class="budget-item">					
					<?php };
					?>
					<td><?php echo $values['Budget item'];?></td>
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
				$this->echoBudgetItemString($arrSubtotal,'budget-subtotal budget-item');
			} else {	
			?>
			<td colspan="2" data-code='<?php echo $data['metadata'];?>'>
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
					<td><a class="budget-document-link" target="_blank" href="<?php echo $data[$i]['script'].'?'.$data[$i]['prefix'].'ID='.$data[$i]['id'];?>"><?php echo $data[$i]['title'],' #',$data[$i]['id'];?></a></td>
					<td class="td-posted <?php echo ($data[$i]['posted']?'budget-icon-posted':'');?>">&nbsp;</td>
					<td class="td-deleted <?php echo ($data[$i]['deleted']?'budget-icon-deleted':'');?>">&nbsp;</td>
					<td id="amount_<?php echo $data[$i]['guid'];?>" class="journal-current budget-decimal"><?php self::render($data[$i]['amount']);?></td>
					<td><?php echo $data[$i]['pccTitle']?$data[$i]['pccTitle']:$data[$i]['locTitle'];?></td>
					<td><?php echo $data[$i]['comment'];?></td>
					<td id="usrTitle_<?php echo $data[$i]['guid'];?>"><?php echo $data[$i]['usrTitle'];?></td>
					<td id="timestamp_<?php echo $data[$i]['guid'];?>"><?php echo date('d.m.Y H:i',strtotime($data[$i]['timestamp']));?></td>
					<td id="responsible_<?php echo $data[$i]['guid'];?>"><?php echo $data[$i]['responsible'];?></td>
				</tr>
				<?php
		}
		
		// ob_flush();
		
		$strTbody = ob_get_clean();
		
		?>
			<table id='sources' class='log'>
				<thead>
					<tr>
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
						<td colspan="3">Total:</td>
						<td class='journal-current budget-decimal' id='journal_total'><?php self::render($total);?></td>
					</tr>
				</tfoot>
				<tbody>
					<?php echo $strTbody; ?>
				</tbody>
			</table>
		<?php
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
		if ((integer)$n2==0){
			echo 'n/a';
			return;			
		} else {
			self::render($n1/$n2*100,$decimals);
		}
	}
		
	private function _unionMRQueries($sql, $sqlGroup="`Budget item`, `item`, `Group`, `Group_code`,`itmOrder`", $sqlOrder="`Group`, `itmOrder` ASC", $fields = Array('CM_A','CM_B','YTD_A','YTD_B','NM_A','NM_B')){
		
		for($i = 0;$i<count($fields);$i++){
			$arrUnion[] = "SUM({$fields[$i]}) as {$fields[$i]}";
		}
		$sql = "SELECT ".($sqlGroup?"{$sqlGroup},":'')."
					".implode(',',$arrUnion)."
				FROM ({$sql}) U 
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
		
		$sqlWhere = $this->sqlWhere;

		$strFields = self::_getMRFields();
		$strFieldsKPI = self::_getMRFields(643);
		
		//$sqlGroup = "GROUP BY `item`";
		
		$sql = "SELECT 
					{$strFields['actual']}
			FROM `vw_master`			
			{$sqlWhere}  AND scenario='{$strFields['from_a']}' AND `item` IS NOT NULL			
			UNION ALL
				SELECT 
				{$strFields['budget']}
			FROM `vw_master`				
			{$sqlWhere} AND scenario='{$strFields['from_b']}' AND `item` IS NOT NULL			
			";
		
		switch ($type){
			case 'fye':
				$strHeader = $this->oBudget->getTableHeader('roy');
				$arrUnion = Array('YTD_A','YTD_B','ROY_A','ROY_B','FYE_A','FYE_B');				
				break;
			case 'ytd':
			case 'cm':
			default:
				$strHeader = $this->oBudget->getTableHeader('mr');
				$arrUnion = Array('CM_A','CM_B','YTD_A','YTD_B','NM_A','NM_B');	
		}
		$sql = self::_unionMRQueries($sql,'','', $arrUnion);
		
		//$tableID = "SUMMARY_".md5($sql);
		
		if (!$rs = $this->oSQL->q($sql)){
				echo "<div class='error'>SQL error:</div>";
				echo "<pre>$sql</pre>";
				return (false);
		};
			?>
			<table id='<?php echo $this->ID;?>' class='budget' style='font-size:1.3em;'>
			<caption><?php echo $this->oBudget->title,' vs ',$this->oReference->title;?></caption>
			<thead>				
				<tr>					
					<th rowspan="2" colspan="2"><?php echo $this->CurrencyTitle, "&nbsp;", number_format($this->Denominator);?></th>
					<?php echo $strHeader; ?>					
			</thead>			
			<tbody>
		<?php
		echo '<tr class="sql" style="display:none;"><td><pre>',$sql,'</pre></td></tr>';
		
		
		$sqlOps = str_replace($sqlWhere, $sqlWhere." AND (account = 'J00400')", $sql);
		$sqlOps = str_replace($sqlGroup, '', $sqlOps);
		$rs = $this->oSQL->q($sqlOps);
		while ($rw = $this->oSQL->f($rs)){
			$rw['Budget item'] = "Gross revenue";
			$this->echoBudgetItemString($rw, 'budget-ratio');
		}
		
		
		$sqlOps = str_replace($sqlWhere, $sqlWhere." AND (item = '".self::REVENUE_ITEM."')", $sql);
		$sqlOps = str_replace($sqlGroup, '', $sqlOps);
		$rs = $this->oSQL->q($sqlOps);
		while ($rw = $this->oSQL->f($rs)){
			$rw['Budget item'] = "Net revenue";
			$this->echoBudgetItemString($rw);
		}
		
		$sqlOps = str_replace($sqlWhere, $sqlWhere." AND (account IN ('J00802')) AND item<>'".self::REVENUE_ITEM."'", $sql);
		$sqlOps = str_replace($sqlGroup, '', $sqlOps);
		$rs = $this->oSQL->q($sqlOps);
		while ($rw = $this->oSQL->f($rs)){
			$rw['Budget item'] = "Direct costs";
			$this->echoBudgetItemString($rw);
		}
		
		$sqlOps = str_replace($sqlWhere, $sqlWhere." AND (account IN ('J00400','J00802'))", $sql);
		$sqlOps = str_replace($sqlGroup, '', $sqlOps);
		$rs = $this->oSQL->q($sqlOps);
		while ($rw = $this->oSQL->f($rs)){
			$rw['Budget item'] = "Gross profit";
			$this->echoBudgetItemString($rw, 'budget-subtotal');
		}
		
		
		$sqlOps = str_replace($sqlWhere, $sqlWhere." AND (account IN ('J00801','J00803','J00804','J00805','J00806','J00808','J0080W'))", $sql);
		$sqlOps = str_replace($sqlGroup, '', $sqlOps);
		$rs = $this->oSQL->q($sqlOps);
		while ($rw = $this->oSQL->f($rs)){
			$rw['Budget item'] = "Reclassified fixed costs";
			$this->echoBudgetItemString($rw);
		}
		
		$sqlOps = str_replace($sqlWhere, $sqlWhere." AND (account IN ('J00400','J00802','J00801','J00803','J00804','J00805','J00806','J00808','J0080W'))", $sql);
		$sqlOps = str_replace($sqlGroup, '', $sqlOps);
		$rs = $this->oSQL->q($sqlOps);
		while ($rw = $this->oSQL->f($rs)){
			$rw['Budget item'] = "Gross operating profit";
			$this->echoBudgetItemString($rw, 'budget-subtotal');
		}
		
		if (!($this->filter['activity'])){
			$sqlOps = str_replace($sqlWhere, $sqlWhere." AND (account LIKE '5%' AND (pccFlagProd=1 OR pc IN(9,130)))", $sql);
			$sqlOps = str_replace($sqlGroup, '', $sqlOps);
			$rs = $this->oSQL->q($sqlOps);
			while ($rw = $this->oSQL->f($rs)){
				$rw['Budget item'] = "Selling & general";
				$this->echoBudgetItemString($rw);
			}
			
			$sqlOps = str_replace($sqlWhere, $sqlWhere." AND (account LIKE '5%' AND (pccFlagProd=0 AND pc NOT IN (9,130)))", $sql);
			$sqlOps = str_replace($sqlGroup, '', $sqlOps);
			$rs = $this->oSQL->q($sqlOps);
			while ($rw = $this->oSQL->f($rs)){
				$rw['Budget item'] = "Corporate costs";
				$this->echoBudgetItemString($rw);
			}
			
			$sqlOps = str_replace($sqlWhere, $sqlWhere." AND (account NOT LIKE '6%' AND account NOT LIKE '7%' AND account NOT LIKE 'SZ%')", $sql);
			$sqlOps = str_replace($sqlGroup, '', $sqlOps);
			$rs = $this->oSQL->q($sqlOps);
			while ($rw = $this->oSQL->f($rs)){
				$rw['Budget item'] = "Operating income";
				$this->echoBudgetItemString($rw, 'budget-subtotal');
			}
			
			$sqlOps = str_replace($sqlWhere, $sqlWhere." AND (account LIKE '60%')", $sql);
			$sqlOps = str_replace($sqlGroup, '', $sqlOps);
			$rs = $this->oSQL->q($sqlOps);
			while ($rw = $this->oSQL->f($rs)){
				$rw['Budget item'] = "Non-operating income";
				$this->echoBudgetItemString($rw);
			}
			
			$sqlOps = str_replace($sqlWhere, $sqlWhere." AND (account LIKE '65%')", $sql);
			$sqlOps = str_replace($sqlGroup, '', $sqlOps);
			$rs = $this->oSQL->q($sqlOps);
			while ($rw = $this->oSQL->f($rs)){
				$rw['Budget item'] = "Non-operating losses";
				$this->echoBudgetItemString($rw);
			}
			
			$sqlOps = str_replace($sqlWhere, $sqlWhere." AND (account LIKE '7%')", $sql);
			$sqlOps = str_replace($sqlGroup, '', $sqlOps);
			$rs = $this->oSQL->q($sqlOps);
			while ($rw = $this->oSQL->f($rs)){
				$rw['Budget item'] = "Extraordinary";
				$this->echoBudgetItemString($rw);
			}
			
			$sqlOps = str_replace($sqlWhere, $sqlWhere." AND (account NOT LIKE 'SZ%')", $sql);
			$sqlOps = str_replace($sqlGroup, '', $sqlOps);
			$rs = $this->oSQL->q($sqlOps);
			while ($rw = $this->oSQL->f($rs)){
				$rw['Budget item'] = "Profit before tax";
				$this->echoBudgetItemString($rw, 'budget-subtotal');
			}
		} else {
			//------- KPIs -----------------	
			$strFields = self::_getMRFields(Array('denominator'=>1,'currency'=>643));
			
			$sql = "SELECT activity, unit, prtTitle,
						{$strFields['actual']}
				FROM `vw_sales`			
				{$sqlWhere}  AND scenario='{$strFields['from_a']}' AND source='Actual'
				GROUP BY activity, unit
				UNION ALL
				SELECT activity, unit, prtTitle, 
						{$strFields['next']}
				FROM `vw_sales`			
				{$sqlWhere}  AND scenario='{$strFields['from_a']}'  
				GROUP BY activity, unit
				UNION ALL
					SELECT activity, unit, prtTitle,
					{$strFields['budget']}
				FROM `vw_sales`				
				{$sqlWhere} AND scenario='{$strFields['from_b']}' 
				GROUP BY activity, unit
				";
				
			$sql = self::_unionMRQueries($sql,"`prtTitle`, `activity`, `unit`",'', $arrUnion);
			
			// echo '<pre>',$sql,'</pre>';
			$rs = $this->oSQL->q($sql);
			
			if ($this->oSQL->n($rs)){
				?>
				<tr><th colspan="14">Operational KPIs</th></tr>				
				<?php		
				while ($rw = $this->oSQL->f($rs)){			
					$rw['Budget item'] = $rw['prtTitle']." ({$rw['unit']})";
					$filter = $this->filter;
					$filter['activity'] = $rw['activity'];
					$arrMetadata = Array('filter' => $filter, 'DataAction' => 'kpiByCustomer', 'title'=>$rw['prtTitle']);
					$rw['metadata'] = json_encode($arrMetadata);
					$rw['href'] = "javascript:getDetails(".json_encode($arrMetadata).");";
					$this->echoBudgetItemString($rw);
				}
			}
		}
		
		$this->_getMRHeadcount($sqlWhere);
		$this->_getMRHeadcount($sqlWhere,'funRHQ');
		
		
		?>
		</tbody>
		</table>
		<ul class='link-footer'>
				<li><a href='javascript:SelectContent("<?php echo $this->ID;?>");'>Select table</a></li>
		</ul>
		<?php
		
	}
	
}

?>

