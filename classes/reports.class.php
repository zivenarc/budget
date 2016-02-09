<?php
require_once ('budget.class.php');

class Reports{
	
	private $ID;
	public $oBudget;
	public $Currency;
	public $Denominator;
	private $oSQL;
	
	const GP_CODE = 94;
	
	function __construct($params){
		
		GLOBAL $oSQL;
		$this->oSQL = $oSQL;
		
		$this->oBudget = new Budget($params['budget_scenario']);
		$this->oReference = $params['reference']?new Budget($params['reference']):$this->oBudget->reference_scenario;
		
		$this->Currency = $params['currency']?$params['currency']:643;
		$this->Denominator = $params['denominator']?$params['denominator']:1;
		$this->ID = md5(time());
		
		$this->YACT = $params['yact']?true:false;
		// echo '<pre>';print_r($this);echo '</pre>';
	
	}
	
	public function salesByActivity($sqlWhere=''){
		GLOBAL $oSQL;
		ob_start();
			
			switch ($this->oBudget->type){
				case 'Budget':
					$sql = "SELECT prtGHQ, prtRHQ, pc, prtID, prtTitle as 'Activity', prtUnit as 'Unit', ".$this->oBudget->getMonthlySumSQL(1,$this->oBudget->length).", SUM(".$this->oBudget->getYTDSQL().") as Total 
							FROM `reg_sales`					
							LEFT JOIN vw_product_type ON prtID=activity
							{$sqlWhere} AND posted=1 AND kpi=1
							GROUP BY `reg_sales`.`activity`, `reg_sales`.`unit`
							ORDER BY prtGHQ, prtRHQ";
					break;
				default:	
					$mthStart = (integer)date('n',$this->oBudget->date_start);					
					
					$sql = "SELECT prtGHQ, prtRHQ, pc, prtID, prtTitle as 'Activity', prtUnit as 'Unit',
							".$this->oBudget->getMonthlySumSQL(1,15).",
							SUM(".$this->oBudget->getYTDSQL().") as Total, SUM(".$this->oBudget->getYTDSQL(4,15).") as Total_AM
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
					echo $this->oBudget->getTableHeader(); 
					echo $this->oBudget->getTableHeader('quarterly'); 
					?>
					<th class='budget-ytd'>Total</th>
					<th class='budget-monthly'>Jan+</th>
					<th class='budget-monthly'>Feb+</th>
					<th class='budget-monthly'>Mar+</th>
					<th>Q5</th>
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
				for ($m=1;$m<13;$m++){
					// $month = $this->oBudget->arrPeriod[$m];
					$month = $this->oBudget->arrPeriod[$m];
					echo "<td class='budget-decimal budget-monthly budget-$month'>",self::render($rw[$month]),'</td>';
				}
				$arrQuarter = Array('Q1'=>$rw['jan']+$rw['feb']+$rw['mar'],
									'Q2'=>$rw['apr']+$rw['may']+$rw['jun'],
									'Q3'=>$rw['jul']+$rw['aug']+$rw['sep'],
									'Q4'=>$rw['oct']+$rw['nov']+$rw['dec'],
									'Q5'=>$rw['jan_1']+$rw['feb_1']+$rw['mar_1']);
				
				for ($q=1;$q<5;$q++){		
					$quarter = 'Q'.$q;
					echo "<td class='budget-decimal budget-quarterly budget-$quarter'>",number_format($arrQuarter[$quarter],0,'.',','),'</td>';
				}				
									
				echo '<td class=\'budget-decimal budget-ytd\'>',number_format($rw['Total'],0,'.',','),'</td>';
				for ($m=13;$m<=15;$m++){
					// $month = $this->oBudget->arrPeriod[$m];
					$month = $this->oBudget->arrPeriod[$m];
					echo "<td class='budget-decimal budget-monthly budget-$month'>",self::render($rw[$month]),'</td>';
				}
				echo '<td class=\'budget-decimal budget-Q5\'>',number_format($arrQuarter['Q5'],0,'.',','),'</td>';
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
		
		$sql = "SELECT OFF_Route, ".$this->oBudget->getMonthlySumSQL(1,$this->oBudget->length).", SUM(".$this->oBudget->getYTDSQL().") as Total 
				FROM vw_sales {$sqlWhere} AND posted=1 AND kpi=1 AND unit='TEU' AND OFF_Route IS NOT NULL 
				GROUP BY OFF_Route";
		$rs = $this->oSQL->q($sql); 
		$tableID = "kpi_".md5($sql);
			?>
			<h2>Freehand OFF by route:</h2>
			<table id='<?php echo $tableID;?>' class='budget'>
			<thead>
				<tr>
					<th>Route</th>
					<?php 
					echo $this->oBudget->getTableHeader(); 
					echo $this->oBudget->getTableHeader('quarterly'); 
					?>
					<th class='budget-ytd'>Total</th>
					<th class='budget-monthly'>Jan+</th>
					<th class='budget-monthly'>Feb+</th>
					<th class='budget-monthly'>Mar+</th>
					<th>Q5</th>
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
				echo "<td>",$rw['OFF_Route'],'</td>';				
				for ($m=1;$m<=12;$m++){
					// $month = $this->oBudget->arrPeriod[$m];
					$month = $this->oBudget->arrPeriod[$m];
					echo "<td class='budget-decimal budget-monthly budget-$month'>",self::render($rw[$month]),'</td>';
					$arrTotal[$month]+=$rw[$month];
				}
				$arrTotal['Total']+=$rw['Total'];
				
				$arrQuarter = Array('Q1'=>$rw['jan']+$rw['feb']+$rw['mar'],
									'Q2'=>$rw['apr']+$rw['may']+$rw['jun'],
									'Q3'=>$rw['jul']+$rw['aug']+$rw['sep'],
									'Q4'=>$rw['oct']+$rw['nov']+$rw['dec'],
									'Q5'=>$rw['jan_1']+$rw['feb_1']+$rw['mar_1']);
				
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
		$sql = "SELECT customer, ".$this->oBudget->getMonthlySumSQL(1,$this->oBudget->length, $arrRates).", 
						SUM(".$this->oBudget->getYTDSQL(1,12,$arrRates).") as Total 
		FROM reg_master 
		{$sqlWhere} AND item='".Items::REVENUE."'
		GROUP BY customer";
		$rs = $this->oSQL->q($sql); 
		while ($rw = $this->oSQL->f($rs)){
			$arrRevenue[$rw['customer']] = $rw;
		}
		
		$sql = "SELECT cntTitle,customer, ".$this->oBudget->getMonthlySumSQL(1,$this->oBudget->length).", SUM(".$this->oBudget->getYTDSQL().") as Total 
				FROM reg_rent 
				LEFT JOIN vw_customer ON cntID=customer
				{$sqlWhere} AND posted=1 AND item='".Items::WH_RENT."'
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
					echo $this->oBudget->getTableHeader(); 
					echo $this->oBudget->getTableHeader('quarterly'); 
					?>
					<th class='budget-ytd'>Total</th>
					<th>Q5</th>
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
				if ($rw['customer']!=$empty){
						$arrUtil['Total']+=$rw['Total'];
				}
				
				$arrQuarter = Array('Q1'=>($rw['jan']+$rw['feb']+$rw['mar'])/3,
									'Q2'=>($rw['apr']+$rw['may']+$rw['jun'])/3,
									'Q3'=>($rw['jul']+$rw['aug']+$rw['sep'])/3,
									'Q4'=>($rw['oct']+$rw['nov']+$rw['dec'])/3,
									'Q5'=>($rw['jan_1']+$rw['feb_1']+$rw['mar_1'])/3);
				
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
			$sql = "SELECT unit, cntTitle as 'Customer', ".$this->oBudget->getMonthlySumSQL(1,$this->oBudget->length).", SUM(".$this->oBudget->getYTDSQL().") as Total, usrTitle as responsible, sales
					FROM `reg_sales`
					LEFT JOIN vw_customer ON customer=cntID					
					LEFT JOIN vw_profit ON pc=pccID	
					LEFT JOIN stbl_user ON sales=usrID
					WHERE posted=1 AND scenario='{$this->oBudget->id}' and kpi=1 $sqlWhere
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
					echo $this->oBudget->getTableHeader(); 
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
						<th colspan="21">By <a target="sales_report" href="rep_my.php?usrID=<?php echo $rw['sales'];?>"><?php echo $rw['responsible'];?></a></th>
					</tr>
					<?php 
				}				
				?>
				<tr>
					<td><?php echo $rw['Customer'];?></td>
					<td><?php echo $rw['unit'];?></td>
				<?php
				for ($m=1;$m<13;$m++){
					$month = $this->oBudget->arrPeriod[$m];
					$arrTotal[$rw['unit']][$month] += $rw[$month];
					echo "<td class='budget-decimal budget-monthly budget-$month'>",self::render($rw[$month]),'</td>';
				}
				$arrQuarter = Array('Q1'=>$rw['jan']+$rw['feb']+$rw['mar'],
									'Q2'=>$rw['apr']+$rw['may']+$rw['jun'],
									'Q3'=>$rw['jul']+$rw['aug']+$rw['sep'],
									'Q4'=>$rw['oct']+$rw['nov']+$rw['dec'],
									'Q5'=>$rw['jan_1']+$rw['feb_1']+$rw['mar_1']);
				
				for ($q=1;$q<5;$q++){		
					$quarter = 'Q'.$q;
					$arrQTotal[$rw['unit']][$quarter] += $arrQuarter[$quarter];
					?>
					<td class='budget-decimal budget-quarterly budget-<?php echo $quarter;?>'><?php self::render($arrQuarter[$quarter])?></td>
					<?php
				}				
				
				?>
				<td class='budget-decimal budget-ytd'><?php self::render($rw['Total']);?></td>				
				<td class='budget-decimal'><?php self::render($arrQuarter['Q5']);?></td>				
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
					for ($m=1;$m<13;$m++){
						$month = $this->oBudget->arrPeriod[$m];
						?>
						<td class='budget-decimal budget-monthly budget-<?php echo $month;?>'><?php self::render($data[$month]);?></td>
						<?php
					}
					for ($q=1;$q<5;$q++){		
						$quarter = 'Q'.$q;						
						?>
						<td class='budget-decimal budget-quarterly budget-<?php echo $quarter;?>'><?php self::render($arrQTotal[$unit][$quarter])?></td>
						<?php
					}
					?>
					<td class='budget-decimal budget-ytd'><?php self::render(array_sum($data));?></td>
					<td class='budget-decimal budget-<?php echo $quarter;?>'><?php self::render($arrQTotal[$unit]['Q5'])?></td>
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
				for ($m=1;$m<13;$m++){
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
			
			$sqlSelect = "SELECT prtGHQ, locTitle as 'Location', prtTitle as 'Activity', funTitle, funTitleLocal, pc, pccTitle,pccTitleLocal , wc,
						".$this->oBudget->getMonthlySumSQL().", 
						SUM(".$this->oBudget->getYTDSQL().")/12 as Total 
					FROM `reg_headcount`
					LEFT JOIN vw_function ON funGUID=function
					LEFT JOIN vw_product_type ON prtID=activity
					LEFT JOIN vw_location ON locID=location
					LEFT JOIN vw_profit ON pccID=pc
					$sqlWhere AND posted=1 AND active=1 AND salary>0";
			
			$sql = $sqlSelect." GROUP BY `prtGHQ`,wc
					ORDER BY prtRHQ,wc";
			$rs = $oSQL->q($sql);			
			if (!$oSQL->num_rows($rs)){
				echo "<div class='warning'>No data found</div>";
				return (false);
			}
			
			$tableID = md5($sql);
			
			?>
			<div style="display:none;"><pre><?php echo $sql;?></pre></div>
			<table id='<?php echo $tableID;?>' class='budget'>
			<thead>
				<tr><th>Activity</th><?php echo $this->oBudget->getTableHeader('monthly'); ?><th class='budget-ytd'>Average</th></tr>
			</thead>			
			<tbody>
			<?php
			while ($rw=$oSQL->f($rs)){
				?>
				<tr>
					<td><?php echo $rw['prtGHQ'], ": ",($rw['wc']?'White':'Blue');?></td>					
				<?php
				self::_renderHeadcountArray($rw);
				for ($m=1;$m<13;$m++){
					$headcount[$m] += $rw[$this->oBudget->arrPeriod[$m]];
				}
				$headcount['ytd'] += $rw['Total'];
			}
			
			$sql = $sqlSelect." GROUP BY `location`";
			$rs = $oSQL->q($sql);			
			?>
			<tr><th>Location</th><?php echo $this->oBudget->getTableHeader('monthly'); ?><th class='budget-ytd'>Average</th></tr>
			<?php
			while ($rw=$oSQL->f($rs)){
				?>
				<tr>
					<td><?php echo $rw['Location'];?></td>					
				<?php
				self::_renderHeadcountArray($rw, Array('location'=>$rw['location']));
				
			}
			$sql = $sqlSelect." GROUP BY `function` ORDER BY funRHQ, funFlagWC";
			$rs = $oSQL->q($sql);			
			?>
			<tr><th>Function</th><?php echo $this->oBudget->getTableHeader('monthly'); ?><th class='budget-ytd'>Average</th></tr>
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
				<tr><th>Business unit</th><?php echo $this->oBudget->getTableHeader('monthly'); ?><th class='budget-ytd'>Average</th></tr>
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
			for ($m=1;$m<13;$m++){
				echo '<td class="budget-decimal">',self::render($headcount[$m],1),'</td>';
			}
			
			?>
				<td class="budget-decimal budget-ytd"><?php self::render($headcount['ytd'],1);?></td>
			</tr>
			<?php
				$sql = "SELECT account, ".$this->oBudget->getMonthlySumSQL().", SUM(".$this->oBudget->getYTDSQL().")/12 as Total 
						FROM `reg_master`
						$sqlWhere
							AND account IN ('J00400','J00802') AND active=1
						GROUP BY account";
				$rs = $oSQL->q($sql);	
				if ($oSQL->num_rows($rs)){
					while ($rw = $oSQL->f($rs)){
						if ($rw['account']=='J00400'){
							?>
							<tr>
								<td>Revenue, RUBx1,000</td>
								<?php
								for ($m=1;$m<13;$m++){
									$month = $this->oBudget->arrPeriod[$m];
									echo '<td class="budget-decimal">',self::render($rw[$month]/$denominator),'</td>';
									$arrRevenuePerFTE[$m] = $rw[$month]/$headcount[$m]/$denominator;									
								}
								?>
								<td class='budget-decimal budget-ytd'><?php self::render($rw['Total']/$denominator);?></td>
							</tr>
							<tr>
								<td>Revenue per FTE</td>
								<?php
								for ($m=1;$m<13;$m++){									
									echo '<td class="budget-decimal">',self::render($arrRevenuePerFTE[$m]),'</td>';									
								}
								?>
								<td class='budget-decimal budget-ytd'><?php self::render($rw['Total']/$headcount['ytd']/$denominator);?></td>
							</tr>
							<?php
						}
						for ($m=1;$m<13;$m++){
							$month = $this->oBudget->arrPeriod[$m];
							$arrGP[$month] += $rw[$month];
						}
						$arrGP['Total'] += $rw['Total'];
					}
					?>
					<tr>
						<td>Gross profit, RUBx1,000</td>
						<?php
						for ($m=1;$m<13;$m++){
									$month = $this->oBudget->arrPeriod[$m];
									echo '<td class="budget-decimal">',self::render($arrGP[$month]/$denominator),'</td>';
									$arrGPPerFTE[$m] = $arrGP[$month]/$headcount[$m]/$denominator;
						}
						?>
						<td class='budget-decimal budget-ytd'><?php self::render($arrGP['Total']/$denominator);?></td>
					</tr>
					<tr class='budget-subtotal'>
						<td>GP per FTE</td>
						<?php
						for ($m=1;$m<13;$m++){
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
				$sql = "SELECT account, ".$this->oBudget->getMonthlySumSQL().", SUM(".$this->oBudget->getYTDSQL().")/12 as Total 
						FROM `vw_master`
						$sqlWhere
							AND Group_code IN (95)
						";
				$rs = $oSQL->q($sql);	
				if ($oSQL->num_rows($rs)){
					while ($rw = $oSQL->f($rs)){						
							?>
							<tr>
								<td>Staff costs, RUBx1,000</td>
								<?php
								for ($m=1;$m<13;$m++){
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
						for ($m=1;$m<13;$m++){
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
						for ($m=1;$m<13;$m++){
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
		for ($m=1;$m<13;$m++){
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
			$sql = "SELECT prtGHQ, account, Title, ".$this->oBudget->getMonthlySumSQL(1,$this->oBudget->length).", SUM(".$this->oBudget->getYTDSQL().") as Total 
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
				<tr><th>Activity</th><th>Account</th><th>Title</th><?php echo $this->oBudget->getTableHeader(); ?><th class='budget-ytd'>Total</th></tr>
			</thead>			
			<tbody>
			<?php			
			while ($rw=$oSQL->f($rs)){
				echo '<tr>';
				echo '<th>',$rw['prtGHQ'],'</th>';
				echo '<th>',$rw['account'],'</th>';
				echo '<th>',$rw['Title'],'</th>';
				for ($m=1;$m<13;$m++){
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
	
	public function periodicPnL($sqlWhere, $params = Array('field_data','field_title','title','yact'=>false)){
		
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
				",SUM(Total) as Total, SUM(Total_AM) as Total_AM, SUM(estimate) as estimate,Level1_title,level1_code,`{$strAccountTitle}` as 'Budget item',`{$strAccountGroup}` as 'Group', `{$strAccountCode}` as 'item'
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
	
	public function monthlyReport($sqlWhere, $type='ghq'){
		
		GLOBAL $budget_scenario;
		$oBudget = new Budget($budget_scenario);
		
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
				$sqlMeasure = "CASE WHEN Customer_group_code=723 THEN Customer_name ELSE Customer_group_title END as 'Level1_title'
						, CASE WHEN Customer_group_code=723 THEN customer ELSE Customer_group_code END as 'level1_code', `Budget item`, `Group`, `item`,`itmOrder`,";
				$strGroupTitle = 'Customer group';
				break;
			case 'sales':
				$sqlMeasure = "usrTitle as 'Level1_title', sales as 'level1_code', `Budget item`, `Group`, `item`,`itmOrder`,";
				$strGroupTitle = 'BDV employee';
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
			self::noFirstLevelReportMR($sqlWhere, $this->currency);
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
						echo $this->oBudget->getTableHeader();
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
					<?php
					}					
					if ($this->oBudget->type=='FYE'){
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
					
					foreach ($rw as $key=>$value){
						$arrGrandTotal[$key] += $value;
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
					<?php echo Budget::getTableHeader('mr'); 							
					?>					
			</thead>			
			<tbody>
			<?php
			if ($oSQL->num_rows($rs)){
				$Level1_title = '';		
				while ($rw=$oSQL->f($rs)){
					if($Level1_title && $Level1_title!=$rw['Level1_title']){
						$data = $subtotal[$Level1_title];
						$data['Budget item']=$group;
						self::echoMRItemString($data,'budget-subtotal', $oBudget);
					}
						
					$subtotal[$rw['Level1_title']]['CM_A'] += $rw['CM_A'];
					$subtotal[$rw['Level1_title']]['CM_B'] += $rw['CM_B'];
					$subtotal[$rw['Level1_title']]['YTD_A'] += $rw['YTD_A'];
					$subtotal[$rw['Level1_title']]['YTD_B'] += $rw['YTD_B'];
					$subtotal[$rw['Level1_title']]['NM_A'] += $rw['NM_A'];
					$subtotal[$rw['Level1_title']]['NM_B'] += $rw['NM_B'];
					
														
					
					$data = $rw;
					if ($data['Level1_title']==$Level1_title && $Level1_title) $data['Level1_title']="&nbsp;";
					
					// echo '<pre>';print_r($data);echo '</pre>';
					
					self::echoMRItemString($data,$tr_class, $oBudget);
					
					$Level1_title = $rw['Level1_title'];
					$group = $rw['Group'];
				}
				$data = $subtotal[$Level1_title];
				$data['Budget item']=$group;
				self::echoMRItemString($data,'budget-subtotal', $oBudget);
				
				
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
				for ($m=1;$m<13;$m++){
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
		
		$sqlOps = str_replace($sqlWhere, $sqlWhere." AND account NOT LIKE '6%'", $sql);
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
		
		$sql = "SELECT ".$this->oBudget->getMonthlySumSQL(1,15).",\r\n".
				$this->oBudget->getQuarterlySumSQL().
				",SUM(Total) as Total, SUM(Total_AM) as Total_AM, SUM(estimate) as estimate,`Budget item`,`Group`, `item`, Group_code
			FROM 
			(SELECT `Budget item`, `Group`, `item`,Group_code,
					{$strFields_this}
			FROM `vw_master` 			
			{$sqlWhere} AND scenario='{$this->oBudget->id}' 
			{$sqlGroup}
			UNION ALL
			SELECT `Budget item`, `Group`, `item`,Group_code,
					{$strFields_last}
			FROM `vw_master` 			
			{$sqlWhere} AND scenario='{$this->oReference->id}' 
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
				for ($m=1;$m<13;$m++){
					// $month = $this->oBudget->arrPeriod[$m];
					$month = $this->oBudget->arrPeriod[$m];
					$subtotal[$rw['Group']][$month]+=$rw[$month];					
					$subtotal[$rw['Group']]['Q'.$m]+=$rw['Q'.$m];					
					$local_subtotal += $rw[$month];
					$grandTotal[$month] += $rw[$month];
					$grandTotal['Q'.$m] += $rw['Q'.$m];
				}
				$subtotal[$rw['Group']]['Total'] += $rw['Total'];
				$subtotal[$rw['Group']]['Total_AM'] += $rw['Total_AM'];
				$subtotal[$rw['Group']]['estimate'] += $rw['estimate'];
				$subtotal[$rw['Group']]['YTD_A'] += $rw['YTD_A'];
				$subtotal[$rw['Group']]['YTD'] += $rw['YTD'];
				$subtotal[$rw['Group']]['ROY_A'] += $rw['ROY_A'];
				$subtotal[$rw['Group']]['ROY'] += $rw['ROY'];
				
				$grandTotal['Total'] += $rw['Total'];
				$grandTotal['Total_AM'] += $rw['Total_AM'];
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
			$data['Budget item']='Profit before tax';
			$this->echoBudgetItemString($data,'budget-total');
			
		//------ Operating income -------
		
		$sqlOps = str_replace($sqlWhere, $sqlWhere." AND account NOT LIKE '6%'", $sql);
		$sqlOps = str_replace($sqlGroup, '', $sqlOps);
		$rs = $this->oSQL->q($sqlOps);
		while ($rw = $this->oSQL->f($rs)){
			$rw['Budget item'] = "Operating income";
			$this->echoBudgetItemString($rw,'budget-subtotal');
		}
			
	}
	
	private function noFirstLevelReportMR($sqlWhere, $currency=643){
				
		global $oSQL;		
		
		$strFields = self::_getMRFields($currency);
		
		$sqlGroup = "GROUP BY `Budget item`, `item`, `Group`, `Group_code`";
		
		$sql = "SELECT `Budget item`, `item`, `Group`, `Group_code`,`itmOrder`, 
					{$strFields['actual']}
			FROM `vw_master`			
			{$sqlWhere}  AND scenario='{$strFields['from_a']}'
			{$sqlGroup}	
			UNION ALL
				SELECT `Budget item`, `item`, `Group`, `Group_code`,`itmOrder`, 
				{$strFields['budget']}
			FROM `vw_master`				
			{$sqlWhere} AND scenario='{$strFields['from_b']}'
			{$sqlGroup}			
			ORDER BY `Group`, `itmOrder` ASC";
			
			// echo '<pre>',$sql,'</pre>';
		
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
					self::echoMRItemString($data,'budget-subtotal');
				}
				

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
				
				
				self::echoMRItemString($rw,$tr_class);				
				$group = $rw['Group'];
			}
			//last group subtotal
			$data = $subtotal[$group];
			$data['Budget item']=$group;
			self::echoMRItemString($data,'budget-subtotal');
			//Grand total
			$data = $grandTotal;
			$data['Budget item']='Profit before tax';
			self::echoMRItemString($data,'budget-total');
			
		//------ Operating income -------
		
		$sqlOps = str_replace($sqlWhere, $sqlWhere." AND account NOT LIKE '6%'", $sql);
		$sqlOps = str_replace($sqlGroup, '', $sqlOps);
		$rs = $oSQL->q($sqlOps);
		while ($rw = $oSQL->f($rs)){
			$rw['Budget item'] = "Operating income";
			self::echoMRItemString($rw,'budget-subtotal');
		}
		
		//------- KPIs -----------------
		
		echo '<tr><th colspan="13">Operational KPIs</th></tr>';
		
		$sql = "SELECT activity, unit, 
					{$strFields['actual']}
			FROM `reg_sales`			
			{$sqlWhere}  AND scenario='{$strFields['from_a']}' AND kpi=1 AND posted=1 AND source='Actual'
			GROUP BY activity, unit
			UNION ALL
			SELECT activity, unit, 
					{$strFields['next']}
			FROM `reg_sales`			
			{$sqlWhere}  AND scenario='{$strFields['from_a']}' AND kpi=1 AND posted=1
			GROUP BY activity, unit
			UNION ALL
				SELECT activity, unit, 
				{$strFields['budget']}
			FROM `reg_sales`				
			{$sqlWhere} AND scenario='{$strFields['from_b']}' AND kpi=1 AND posted=1 
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
		while ($rw = $oSQL->f($rs)){			
			$rw['Budget item'] = $rw['prtTitle']." ({$rw['unit']})";
			self::echoMRItemString($rw);
		}	
	
	}
	
	private function _getMonthlyFields($type='this'){
		// GLOBAL $budget_scenario;
		// $oBudget = new Budget($budget_scenario);
		switch ($type){
		case 'this':
			$arrRates = $this->oBudget->getMonthlyRates($this->Currency);
			// echo '<pre>';print_r($arrRates);echo '</pre>';
			$res=	$this->oBudget->getMonthlySumSQL(1,15,$arrRates).", \r\n".
					$this->oBudget->getQuarterlySumSQL($arrRates).", \r\n 
					SUM(".$this->oBudget->getYTDSQL(1,12,$arrRates).") as Total ,\r\n
					SUM(".$this->oBudget->getYTDSQL(4,15,$arrRates).") as Total_AM ,\r\n
					0 as estimate, 
					SUM(".$this->oBudget->getYTDSQL(1, (integer)date('n',$this->oBudget->date_start)-1,$arrRates).") as YTD_A, 
					SUM(YTD/{$arrRates['YTD']}) as YTD, 
					SUM(".$this->oBudget->getYTDSQL((integer)date('n',$this->oBudget->date_start),12,$arrRates).") as ROY_A, 
					SUM(ROY/{$arrRates['YTD']}) as ROY";
			break;
		case 'last':
			$arrRates = $this->oReference->getMonthlyRates($this->Currency);
			$res=	str_repeat('0,',15)." \r\n".
					str_repeat('0,',5)." \r\n".
					"0 as Total, \r\n".
					"0 as Total_AM, \r\n".
					"SUM(".$this->oBudget->getYTDSQL(1,12,$arrRates).") as estimate ,
					SUM(".$this->oBudget->getYTDSQL(1, (integer)date('n',$this->oBudget->date_start)-1,$arrRates).") as YTD_A, 
					SUM(YTD/{$arrRates['YTD']}) as YTD, 
					SUM(".$this->oBudget->getYTDSQL((integer)date('n',$this->oBudget->date_start),12,$arrRates).") as ROY_A, 
					SUM(ROY/{$arrRates['YTD']}) as ROY";
			break;
		}
		// echo '<pre>';print_r($arrRates);echo '</pre>';
		return ($res);
		
	}
	
	private function _getMRFields(){
				
		$arrRates = $this->oBudget->getMonthlyRates($this->Currency);
		
		$cm = $this->oBudget->arrPeriod[date('n',$this->oBudget->date_start - 1)];
		$nm = $this->oBudget->arrPeriod[date('n',$this->oBudget->date_start)];
				
		$nCurrent = (integer)date('m',$this->oBudget->date_start - 1);
		
		$res['actual']=	"SUM(`{$cm}`)/{$arrRates[$cm]} as CM_A, 
						0 as CM_B,								
						SUM(".$this->oBudget->getYTDSQL(1,$nCurrent,$arrRates).") as YTD_A ,
						0 as YTD_B, 
						SUM(`$nm`)/{$arrRates[$nm]} as NM_A , 
						0 as NM_B";
		$res['next']=	"0 as CM_A, 
						0 as CM_B,								
						0 as YTD_A ,
						0 as YTD_B, 
						SUM(`$nm`)/{$arrRates[$nm]} as NM_A , 
						0 as NM_B";
		$res['budget'] = "0 as CM_A, 
						SUM(`{$cm}`)/{$arrRates[$cm]} as CM_B,								
						0 as YTD_A,
						SUM(".$this->oBudget->getYTDSQL(1,$nCurrent,$arrRates).") as YTD_B, 
						0 as NM_A , 
						SUM(`$nm`)/{$arrRates[$nm]} as NM_B";
		
		$res['from_a'] = $this->oBudget->id;
		$res['from_b'] = $this->oReference->id;
		
		// echo '<pre>',$res,'</pre>'; 
		
		return ($res);
		
	}
	
	private function _echoNumericTDs($data){
		$local_subtotal = 0;
		$ytd = 0;
		$roy = 0;
				for ($m=1;$m<=12;$m++){
					// $month = $this->oBudget->arrPeriod[$m];
					$month = $this->oBudget->arrPeriod[$m];
					?>
					<td class='budget-decimal budget-monthly budget-<?php echo $month;?>'><?php self::render($data[$month],0);?></td>
					<?php
				}
				
				//--------------------- quarterly data -----------------------
				if(isset($data['Q1'])){
					for ($q=1;$q<5;$q++){
						?>
						<td class='budget-decimal budget-quarterly budget-<?php echo 'q'.$m;?>'><?php self::render($data['Q'.$q],0);?></td>
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
				<?php };
				if ($this->oBudget->type == 'FYE'){ ?>
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
	}
	
	private function echoBudgetItemString($data, $strClass=''){							
		GLOBAL $arrUsrData;
		ob_start();
		static $Level1_title;
		?>
		<tr class='<?php echo $strClass;?>'>
			<?php 			
			$first = reset($data);
			if (is_array($first)){				
				?>
				<td class="budget-tdh code-<?php echo urlencode($first['level1_code']);?>" data-code="<?php echo $first['metadata'];?>" rowspan="<?php echo count($data);?>">
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
					foreach ($values as $column=>$value){						
						$arrSubtotal[$column] += $value;
					};	
				}
				$arrSubtotal['Budget item'] = "Subtotal";
				$this->echoBudgetItemString($arrSubtotal,'budget-subtotal budget-item');
			} else {	
			?>
			<td colspan="2">
			<?php
				if ($data['Group_code']==self::GP_CODE) {
					echo 'Total '.strtolower($data['Budget item']); 
				} else {
					if (strpos($strClass,'total') || !isset($data['item'])){
						echo $data['Budget item'];
					} else {
						echo '<a target="_blank" href="javascript:getSource({\'item\':\''.$data['item'].'\'})">'.$data['Budget item'].'</a>';
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
	
	private function echoMRItemString($data, $strClass=''){					
		
		ob_start();
		static $Level1_title;
		?>
		<tr class='<?php echo $strClass;?>'>
			<?php 			
			if (strlen($data['Level1_title'])){				
			?>
			<td class='budget-tdh code-<?php echo urlencode($data['level1_code']);?>' data-code='<?php echo $data['level1_code'];?>'><span><?php echo $data['Level1_title'];?></span></td>
			<td><?php echo '<a target="_blank" href="javascript:getSource({\'item\':\''.$data['item'].'\',\'level1\':\''.$data['level1_code'].'\'})">'.$data['Budget item'].'</a>';?></td>
			<?php 
			} 
			else 			
			{	
			?>
			<td colspan="2">
			<?php
				if ($data['Group_code']==self::GP_CODE) {
					echo 'Total '.strtolower($data['Budget item']); 
				} else {
					if (strpos($strClass,'total') || !isset($data['item'])){
						echo $data['Budget item'];
					} else {
						echo '<a target="_blank" href="javascript:getSource({\'item\':\''.$data['item'].'\'})">'.$data['Budget item'].'</a>';
					}
				}
			?>
			</td>
			<?php
			}
				// echo '<pre>';print_r($data);echo '</pre>';		
					?>
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
					<?php				
				
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
					<td><?php echo $data[$i]['title'];?></td>
					<td><?php echo $data[$i]['id'];?></td>
					<td><a class="budget-document-link" target="_blank" href="<?php echo $data[$i]['script'].'?'.$data[$i]['prefix'].'ID='.$data[$i]['id'];?>"><?php echo $data[$i]['guid'];?></a></td>
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
						<th>Document type</th>
						<th>ID</th>
						<th>GUID</th>
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
		
	private function _unionMRQueries($sql, $sqlGroup){
		$sql = "SELECT `Budget item`, `item`, `Group`, `Group_code`,`itmOrder`, 
					SUM(CM_A) as CM_A,
					SUM(CM_B) as CM_B,
					SUM(YTD_A) as YTD_A,
					SUM(YTD_B) as YTD_B,
					SUM(NM_A) as NM_A,
					SUM(NM_B) as NM_B
				FROM ({$sql}) U {$sqlGroup} 
				ORDER BY `Group`, `itmOrder` ASC";
		return($sql);
		
	}
}

?>

