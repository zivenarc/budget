<?php
class Reports{
	
	public function salesByActivity($sqlWhere=''){
		GLOBAL $oSQL;
		ob_start();
			$sql = "SELECT prtRHQ, pc, prtID, prtTitle as 'Activity', vw_product_type.prtUnit as 'Unit', ".Budget::getMonthlySumSQL().", SUM(".Budget::getYTDSQL().") as Total FROM `reg_sales`
					LEFT JOIN vw_product ON prdID=product
					LEFT JOIN vw_product_type ON prtID=prdCategoryID
					$sqlWhere AND posted=1
					GROUP BY `reg_sales`.`activity`, `reg_sales`.`unit`
					ORDER BY prtGHQ, prtRHQ";
			$rs = $oSQL->q($sql);
			if (!$oSQL->num_rows($rs)){
				echo "<div class='warning'>No data found</div>";
				return (false);
			}			
			?>
			<table id='report' class='budget'>
			<thead>
				<tr><th>Activity</th><th>Unit</th>
					<?php 
					echo Budget::getTableHeader(); 
					echo Budget::getTableHeader('quarterly'); 
					?>
				<th class='budget-ytd'>Total</th></tr>
			</thead>			
			<tbody>
			<?php
			while ($rw=$oSQL->f($rs)){
				echo '<tr>';
				echo "<td><a href='javascript:getCustomerKPI({activity:{$rw['prtID']}});'>",$rw['Activity'],'</a></td>';
				echo '<td>',$rw['Unit'],'</td>';
				for ($m=1;$m<13;$m++){
					$month = date('M',mktime(0,0,0,$m,15));
					echo "<td class='budget-decimal budget-monthly budget-$month'>",number_format($rw[$month],0,'.',','),'</td>';
				}
				$arrQuarter = Array('Q1'=>$rw['Jan']+$rw['Feb']+$rw['Mar'],
									'Q2'=>$rw['Apr']+$rw['May']+$rw['Jun'],
									'Q3'=>$rw['Jul']+$rw['Aug']+$rw['Sep'],
									'Q4'=>$rw['Oct']+$rw['Nov']+$rw['Dec']);
				
				for ($q=1;$q<5;$q++){		
					$quarter = 'Q'.$q;
					echo "<td class='budget-decimal budget-quarterly budget-$quarter'>",number_format($arrQuarter[$quarter],0,'.',','),'</td>';
				}				
									
				echo '<td class=\'budget-decimal budget-ytd\'>',number_format($rw['Total'],0,'.',','),'</td>';
				echo "</tr>\r\n";
			}
			?>
			</tbody>
			</table>
			<?php
			ob_flush();
	}
	
	public function salesByCustomer($sqlWhere=''){
		GLOBAL $oSQL;
		GLOBAL $budget_scenario;
		
		ob_start();
			$sql = "SELECT unit, cntTitle as 'Customer', ".Budget::getMonthlySumSQL().", SUM(".Budget::getYTDSQL().") as Total FROM `reg_sales`
					LEFT JOIN vw_customer ON customer=cntID					
					LEFT JOIN vw_profit ON pc=pccID					
					WHERE posted=1 AND scenario='{$budget_scenario}' $sqlWhere
					GROUP BY `reg_sales`.`customer`
					ORDER BY Total DESC"; 
					echo $sql;
			$rs = $oSQL->q($sql);
			if (!$oSQL->num_rows($rs)){
				echo "<div class='warning'>No data found</div>";
				return (false);
			}			
			?>
			<table id='report' class='budget'>
			<thead>
				<tr><th>Customer</th><th>Unit</th>
					<?php 
					echo Budget::getTableHeader(); 
					echo Budget::getTableHeader('quarterly'); 
					?>
				<th class='budget-ytd'>Total</th></tr>
			</thead>			
			<tbody>
			<?php
			while ($rw=$oSQL->f($rs)){
				echo '<tr>';
				echo "<td>",$rw['Customer'],'</td>';
				echo '<td>',$rw['unit'],'</td>';
				for ($m=1;$m<13;$m++){
					$month = date('M',mktime(0,0,0,$m,15));
					echo "<td class='budget-decimal budget-monthly budget-$month'>",number_format($rw[$month],0,'.',','),'</td>';
				}
				$arrQuarter = Array('Q1'=>$rw['Jan']+$rw['Feb']+$rw['Mar'],
									'Q2'=>$rw['Apr']+$rw['May']+$rw['Jun'],
									'Q3'=>$rw['Jul']+$rw['Aug']+$rw['Sep'],
									'Q4'=>$rw['Oct']+$rw['Nov']+$rw['Dec']);
				
				for ($q=1;$q<5;$q++){		
					$quarter = 'Q'.$q;
					echo "<td class='budget-decimal budget-quarterly budget-$quarter'>",number_format($arrQuarter[$quarter],0,'.',','),'</td>';
				}				
									
				echo '<td class=\'budget-decimal budget-ytd\'>',number_format($rw['Total'],0,'.',','),'</td>';
				echo "</tr>\r\n";
			}
			?>
			</tbody>
			</table>
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
					$month = date('M',mktime(0,0,0,$m,15));
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
		ob_start();
			$sql = "SELECT prtRHQ, locTitle as 'Location', prtTitle as 'Activity', funTitle, funTitleLocal , ".Budget::getMonthlySumSQL().", SUM(".Budget::getYTDSQL().")/12 as Total 
					FROM `reg_headcount`
					LEFT JOIN vw_function ON funGUID=function
					LEFT JOIN vw_product_type ON prtID=activity
					LEFT JOIN vw_location ON locID=location
					$sqlWhere AND posted=1
					GROUP BY `activity`, `location`, `function` 
					ORDER BY location, prtRHQ";
			$rs = $oSQL->q($sql);			
			if (!$oSQL->num_rows($rs)){
				echo "<div class='warning'>No data found</div>";
				return (false);
			}
			?>
			<table id='report' class='budget'>
			<thead>
				<tr><th>Location</th><th>Activity</th><th>Function</th><?php echo Budget::getTableHeader(); ?><th class='budget-ytd'>Average</th></tr>
			</thead>			
			<tbody>
			<?php
			while ($rw=$oSQL->f($rs)){
				echo '<tr>';
				echo '<td>',$rw['Location'],'</td>';
				echo '<td>',$rw['Activity'],'</td>';
				echo '<td><strong>',$rw['funTitle'],'</strong> (',$rw['funTitleLocal'],')</td>';
				for ($m=1;$m<13;$m++){
					$month = date('M',mktime(0,0,0,$m,15));
					echo "<td class='budget-decimal budget-$month'>",($rw[$month]?$rw[$month]:""),'</td>';
					$headcount[$m] += $rw[$month];
				}
				echo '<td class=\'budget-decimal budget-ytd\'>',number_format($rw['Total'],1,'.',','),'</td>';
				$headcount['ytd'] += $rw['Total'];
				echo "</tr>\r\n";
			}
			?>
			<tr class='budget-subtotal'><td colspan='3'>Total</td>
			<?php
			for ($m=1;$m<13;$m++){
				echo '<td class="budget-decimal">',$headcount[$m],'</td>';
			}
			echo '<td class="budget-decimal budget-ytd">',number_format($headcount['ytd'],1,'.',','),'</td>';
			?>
			</tr>
			</tbody>
			</table>
			<?php
			ob_flush();
	}
	
	public function masterByYACT($sqlWhere=''){
		global $oSQL;
		
		ob_start();
			$sql = "SELECT account, Title, ".Budget::getMonthlySumSQL().", SUM(".Budget::getYTDSQL().") as Total 
			FROM `vw_master`
			$sqlWhere
			GROUP BY account
			ORDER BY account			
			";
		$rs = $oSQL->q($sql);
			if (!$oSQL->num_rows($rs)){
				echo "<div class='warning'>No data found</div>";
				//echo "<pre>$sql</pre>";
				return (false);
			}
			?>
			<table id='report' class='budget'>
			<thead>
				<tr><th>Account</th><th>Title</th><?php echo Budget::getTableHeader(); ?><th class='budget-ytd'>Total</th></tr>
			</thead>			
			<tbody>
			<?php			
			while ($rw=$oSQL->f($rs)){
				echo '<tr>';
				echo '<th>',$rw['account'],'</th>';
				echo '<th>',$rw['Title'],'</th>';
				for ($m=1;$m<13;$m++){
					$month = date('M',mktime(0,0,0,$m,15));
					echo '<td class="budget-decimal">',number_format($rw[$month],0,'.',','),'</td>';
				}
				echo '<td class="budget-decimal budget-ytd">',number_format($rw['Total'],0,'.',','),'</td>';
			}
			?>
			</tbody>
			</table>
			<?php			
			ob_flush();
		
		
	}
	
	public function masterByProfit($sqlWhere=''){
		global $oSQL;
		
		ob_start();
			$sql = "SELECT Profit as 'GroupLevel1', `Budget item`, `Group`, ".Budget::getMonthlySumSQL().", SUM(".Budget::getYTDSQL().") as Total 
			FROM `vw_master`
			$sqlWhere
			GROUP BY `vw_master`.Profit, `vw_master`.item
			ORDER BY `vw_master`.Profit,`vw_master`.item DESC
			
			";
			$rs = $oSQL->q($sql);
			if (!$oSQL->num_rows($rs)){
				echo "<div class='warning'>No data found</div>";
				//echo "<pre>$sql</pre>";
				return (false);
			}
			?>
			<table id='report' class='budget'>
			<thead>
				<tr><th>Profit center</th><th>Account</th><?php echo Budget::getTableHeader(); ?><th class='budget-ytd'>Total</th></tr>
			</thead>			
			<tbody>
			<?php
			$GroupLevel1 = '';		
				while ($rw=$oSQL->f($rs)){
					if($GroupLevel1 && $GroupLevel1!=$rw['GroupLevel1']){
						$data = $subtotal[$GroupLevel1];
						$data['Budget item']=$group;
						self::echoBudgetItemString($data,'budget-subtotal');
					}
					//------------------------Collecting subtotals---------------------------------------
					$local_subtotal = 0;
					for ($m=1;$m<13;$m++){
						$month = date('M',mktime(0,0,0,$m,15));
						$subtotal[$rw['GroupLevel1']][$month]+=$rw[$month];
						$local_subtotal += $rw[$month];
						$grandTotal[$month] += $rw[$month];
					}
					$subtotal[$rw['GroupLevel1']]['Total'] += $local_subtotal;
					$grandTotal['Total'] += $local_subtotal;	
					
					$data = $rw;
					if ($data['GroupLevel1']==$GroupLevel1 && $GroupLevel1) $data['GroupLevel1']="&nbsp;";
					self::echoBudgetItemString($data,$tr_class);
					
					$GroupLevel1 = $rw['GroupLevel1'];
					$group = $rw['Group'];
				}
				$data = $subtotal[$GroupLevel1];
				$data['Budget item']=$group;
				self::echoBudgetItemString($data,'budget-subtotal');
				
				$data = $grandTotal;
				$data['Budget item']='Grand total';
				self::echoBudgetItemString($data,'budget-grandtotal');
			?>
			</tbody>
			</table>
			<?php			
			ob_flush();
	}
	
	public function masterByActivity($sqlWhere=''){
		global $oSQL;
		
		ob_start();
			$sql = "SELECT CONCAT(Activity_title,' (',Activity_title_local,')') as 'GroupLevel1', `Budget item`, `Group`, ".Budget::getMonthlySumSQL().", SUM(".Budget::getYTDSQL().") as Total 
			FROM `vw_master`
			$sqlWhere
			GROUP BY `vw_master`.activity, `vw_master`.item
			ORDER BY `vw_master`.activity,`vw_master`.item DESC
			
			";
			$rs = $oSQL->q($sql);
			if (!$oSQL->num_rows($rs)){
				echo "<div class='warning'>No data found</div>";
				//echo "<pre>$sql</pre>";
				return (false);
			}
			?>
			<table id='report' class='budget'>
			<thead>
				<tr><th>Activity</th><th>Account</th><?php echo Budget::getTableHeader(); ?><th class='budget-ytd'>Total</th></tr>
			</thead>			
			<tbody>
			<?php
			$GroupLevel1 = '';		
				while ($rw=$oSQL->f($rs)){
					if($GroupLevel1 && $GroupLevel1!=$rw['GroupLevel1']){
						$data = $subtotal[$GroupLevel1];
						$data['Budget item']=$group;
						self::echoBudgetItemString($data,'budget-subtotal');
					}
					//------------------------Collecting subtotals---------------------------------------
					$local_subtotal = 0;
					for ($m=1;$m<13;$m++){
						$month = date('M',mktime(0,0,0,$m,15));
						$subtotal[$rw['GroupLevel1']][$month]+=$rw[$month];
						$local_subtotal += $rw[$month];
						$grandTotal[$month] += $rw[$month];
					}
					$subtotal[$rw['GroupLevel1']]['Total'] += $local_subtotal;
					$grandTotal['Total'] += $local_subtotal;	
					
					$data = $rw;
					if ($data['GroupLevel1']==$GroupLevel1 && $GroupLevel1) $data['GroupLevel1']="&nbsp;";
					self::echoBudgetItemString($data,$tr_class);
					
					$GroupLevel1 = $rw['GroupLevel1'];
					$group = $rw['Group'];
				}
				$data = $subtotal[$GroupLevel1];
				$data['Budget item']=$group;
				self::echoBudgetItemString($data,'budget-subtotal');
				
				$data = $grandTotal;
				$data['Budget item']='Grand total';
				self::echoBudgetItemString($data,'budget-grandtotal');
			?>
			</tbody>
			</table>
			<?php			
			ob_flush();
	}
	
	public function masterByCustomer($sqlWhere=''){
		global $oSQL;
		
		ob_start();
			$sql = "SELECT Customer_name as 'GroupLevel1', `Budget item`, `Group`, ".Budget::getMonthlySumSQL().", SUM(".Budget::getYTDSQL().") as Total FROM `vw_master`
			$sqlWhere
			GROUP BY `vw_master`.customer, `vw_master`.item
			ORDER BY `vw_master`.customer,`vw_master`.item DESC
			
			";
			$rs = $oSQL->q($sql);
			if (!$oSQL->num_rows($rs)){
				echo "<div class='warning'>No data found</div>";
				//echo "<pre>$sql</pre>";
				return (false);
			}
			?>
			<table id='report' class='budget'>
			<thead>
				<tr><th>Customer</th><th>Account</th><?php echo Budget::getTableHeader(); ?><th class='budget-ytd'>Total</th></tr>
			</thead>			
			<tbody>
			<?php
				$GroupLevel1 = '';		
				while ($rw=$oSQL->f($rs)){
					if($GroupLevel1 && $GroupLevel1!=$rw['GroupLevel1']){
						$data = $subtotal[$GroupLevel1];
						$data['Budget item']=$group;
						self::echoBudgetItemString($data,'budget-subtotal');
					}
					//------------------------Collecting subtotals---------------------------------------
					$local_subtotal = 0;
					for ($m=1;$m<13;$m++){
						$month = date('M',mktime(0,0,0,$m,15));
						$subtotal[$rw['GroupLevel1']][$month]+=$rw[$month];
						$local_subtotal += $rw[$month];
						$grandTotal[$month] += $rw[$month];
					}
					$subtotal[$rw['GroupLevel1']]['Total'] += $local_subtotal;
					$grandTotal['Total'] += $local_subtotal;	
					
					$data = $rw;
					if ($data['GroupLevel1']==$GroupLevel1 && $GroupLevel1) $data['GroupLevel1']="&nbsp;";
					self::echoBudgetItemString($data,$tr_class);
					
					$GroupLevel1 = $rw['GroupLevel1'];
					$group = $rw['Group'];
				}
				$data = $subtotal[$GroupLevel1];
				$data['Budget item']=$group;
				self::echoBudgetItemString($data,'budget-subtotal');
				
				$data = $grandTotal;
				$data['Budget item']='Grand total';
				self::echoBudgetItemString($data,'budget-grandtotal');
			?>
			</tbody>
			</table>
			<?php			
			ob_flush();
	}
		
	
	public function masterbyCustomerEst($sqlWhere){
		
		
		ob_start();
			$sql = "SELECT Customer_name as 'GroupLevel1', customer as 'level1_code', `Budget item`, `Group`, `item`, ".Budget::getMonthlySumSQL().", ".
					Budget::getQuarterlySumSQL().", SUM(".Budget::getYTDSQL().") as Total, SUM(estimate) as estimate
			FROM `vw_master` $sqlWhere AND Group_code=94 ## Gross margin only
			GROUP BY `vw_master`.customer, `vw_master`.item
			ORDER BY `vw_master`.customer, `Group`, `vw_master`.itmOrder ASC			
			";
			
			self::firstLevelReport($sql, 'Customer');
			//==========================================================================================================================Non-customer-related data
			self::noFirstLevelReport($sqlWhere);
			?>
			</tbody>
			</table>
			<?php			
			ob_flush();
	}
	
	public function masterbyProfitEst($sqlWhere){
		
		
		ob_start();
			$sql = "SELECT `Budget item` as 'GroupLevel1', `item` as 'level1_code', `Profit` as 'Budget item', `Group`, `pc` as 'item', ".Budget::getMonthlySumSQL().", ".
					Budget::getQuarterlySumSQL().", SUM(".Budget::getYTDSQL().") as Total, SUM(estimate) as estimate
			FROM `vw_master` $sqlWhere 
			GROUP BY `item`, `pc`
			ORDER BY `Group`, level1_code, item
			";
			
			self::firstLevelReport($sql, 'Items');
			
			?>
			</tbody>
			</table>
			<?php			
			ob_flush();
	}
	
	public function masterbyActivityEst($sqlWhere){
		global $oSQL;
		
		ob_start();
			$sql = "SELECT Activity_title as 'GroupLevel1', activity as 'level1_code', `Budget item`, `Group`, `item`,".
					Budget::getMonthlySumSQL().", ".
					Budget::getQuarterlySumSQL().
					", SUM(".Budget::getYTDSQL().") as Total, SUM(estimate) as estimate
			FROM `vw_master` $sqlWhere AND Group_code=94 ## Gross margin only
			GROUP BY `vw_master`.activity, `vw_master`.item
			ORDER BY prtRHQ, prtGHQ,`vw_master`.activity, `Group`, `vw_master`.itmOrder ASC			
			";
			
			self::firstLevelReport($sql, 'Activity');
			//==========================================================================================================================Non-customer-related data
			self::noFirstLevelReport($sqlWhere);
			?>
			</tbody>
			</table>
			<?php			
			ob_flush();
	}
	
	public function masterYactbyActivityEst($sqlWhere){
		global $oSQL;
		
		ob_start();
			$sql = "SELECT prtGHQ as 'GroupLevel1', activity as 'level1_code', CONCAT(`account`,': ',`Title`) as `Budget item`, Yact_group as `Group`, account as `item`,".
					Budget::getMonthlySumSQL().", ".
					Budget::getQuarterlySumSQL().
					", SUM(".Budget::getYTDSQL().") as Total, SUM(estimate) as estimate
			FROM `vw_master` $sqlWhere AND Group_code=94 ## Gross margin only
			GROUP BY `vw_master`.prtGHQ, `vw_master`.account
			ORDER BY prtGHQ,`vw_master`.activity, `Yact_group`, `vw_master`.account ASC			
			";
			
			self::firstLevelReport($sql, 'Activity');
			//==========================================================================================================================Non-customer-related data
			self::noFirstLevelReport($sqlWhere);
			?>
			</tbody>
			</table>
			<?php			
			ob_flush();
	}
	
	private function firstLevelReport($sql, $firstLevelTitle){
		global $oSQL;
		
		if (!$rs = $oSQL->q($sql)){
				echo "<div class='error'>SQL error:</div>";
				echo "<pre>$sql</pre>";
				return (false);
			};
			?>
			<table id='report' class='budget'>
			<thead>
				<tr>
					<th><?php echo $firstLevelTitle; ?></th>
					<th>Account</th>
					<?php echo Budget::getTableHeader(); 
							echo Budget::getTableHeader('quarterly');
					?>
					<th class='budget-ytd'>Total</th>
					<th>Estimate</th>
					<th>Diff</th>
					<th>%</th>
				</tr>
			</thead>			
			<tbody>
			<?php
			if ($oSQL->num_rows($rs)){
				$GroupLevel1 = '';		
				while ($rw=$oSQL->f($rs)){
					if($GroupLevel1 && $GroupLevel1!=$rw['GroupLevel1']){
						$data = $subtotal[$GroupLevel1];
						$data['Budget item']=$group;
						self::echoBudgetItemString($data,'budget-subtotal');
					}
					//------------------------Collecting subtotals---------------------------------------
					$local_subtotal = 0;
					for ($m=1;$m<13;$m++){
						$month = date('M',mktime(0,0,0,$m,15));
						$subtotal[$rw['GroupLevel1']][$month]+=$rw[$month];
						$subtotal[$rw['GroupLevel1']]['Q'.$m]+=$rw['Q'.$m];
						$local_subtotal += $rw[$month];
						
					}
					$subtotal[$rw['GroupLevel1']]['Total'] += $local_subtotal;
					$subtotal[$rw['GroupLevel1']]['estimate'] += $rw['estimate'];
														
					
					$data = $rw;
					if ($data['GroupLevel1']==$GroupLevel1 && $GroupLevel1) $data['GroupLevel1']="&nbsp;";
					self::echoBudgetItemString($data,$tr_class);
					
					$GroupLevel1 = $rw['GroupLevel1'];
					$group = $rw['Group'];
				}
				$data = $subtotal[$GroupLevel1];
				$data['Budget item']=$group;
				self::echoBudgetItemString($data,'budget-subtotal');
				
				
			}
	}
	
	private function noFirstLevelReport($sqlWhere){
		
		global $oSQL;
	
		$sql = "SELECT `Budget item`, `item`, `Group`, `Group_code`, ".Budget::getMonthlySumSQL().", ".
					Budget::getQuarterlySumSQL().", SUM(".Budget::getYTDSQL().") as Total ,SUM(estimate) as estimate
			FROM `vw_master` $sqlWhere 
			GROUP BY `Group`, `Budget item`
			ORDER BY `Group`, `itmOrder` ASC";
			
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
					self::echoBudgetItemString($data,'budget-subtotal');
				}
				
				//------------------------Collecting subtotals---------------------------------------
				$local_subtotal = 0;
				for ($m=1;$m<13;$m++){
					$month = date('M',mktime(0,0,0,$m,15));
					$subtotal[$rw['Group']][$month]+=$rw[$month];					
					$subtotal[$rw['Group']]['Q'.$m]+=$rw['Q'.$m];					
					$local_subtotal += $rw[$month];
					$grandTotal[$month] += $rw[$month];
					$grandTotal['Q'.$m] += $rw['Q'.$m];
				}
				$subtotal[$rw['Group']]['Total'] += $local_subtotal;
				$subtotal[$rw['Group']]['estimate'] += $rw['estimate'];
				
				$grandTotal['Total'] += $local_subtotal;
				$grandTotal['estimate'] += $rw['estimate'];
				
				self::echoBudgetItemString($rw,$tr_class);				
				$group = $rw['Group'];
			}
			//last group subtotal
			$data = $subtotal[$group];
			$data['Budget item']=$group;
			self::echoBudgetItemString($data,'budget-subtotal');
			//Grand total
			$data = $grandTotal;
			$data['Budget item']='Grand total';
			self::echoBudgetItemString($data,'budget-grandtotal');
	}
	
	private function echoBudgetItemString($data, $strClass='' ){		
		ob_start();
		static $GroupLevel1;
		?>
		<tr class='<?php echo $strClass;?>'>
			<?php 			
			if (strlen($data['GroupLevel1'])){				
			?>
			<td class='budget-tdh code-<?php echo $data['level1_code'];?>' data-code='<?php echo $data['level1_code'];?>'><span><?php echo $data['GroupLevel1'];?></span></td>
			<td><?php echo '<a target="_blank" href="javascript:getSource({\'item\':\''.$data['item'].'\',\'level1\':\''.$data['level1_code'].'\'})">'.$data['Budget item'].'</a>';?></td>
			<?php 
			} 
			else 			
			{	
			?>
			<td colspan="2">
			<?php
				if ($data['Group_code']==94) {
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
				$local_subtotal = 0;
				for ($m=1;$m<13;$m++){
					$month = date('M',mktime(0,0,0,$m,15));
					echo "<td class='budget-decimal budget-monthly budget-$month ".($data[$month]<0?'budget-negative':'')."'>",number_format($data[$month]),'</td>';					
				}
				
				//--------------------- quarterly data -----------------------
				if(isset($data['Q1'])){
					for ($m=1;$m<5;$m++){
						echo "<td class='budget-decimal budget-quarterly budget-q$m ".($data['Q'.$m]<0?'budget-negative':'')."'>",number_format($data['Q'.$m]),'</td>';					
					}
				}
			?>
			<td class='budget-decimal budget-ytd <?php echo $data['Total']<0?'budget-negative':'';?>'><?php echo number_format($data['Total']);?></td>			
			<?php 
			if (isset($data['estimate'])){
			?>
			<td class='budget-decimal <?php echo $data['estimate']<0?'budget-negative':'';?>'><?php echo number_format($data['estimate']);?></td>
			<td class='budget-decimal <?php echo ($data['Total']-$data['estimate'])<0?'budget-negative':'';?>'><?php echo number_format($data['Total']-$data['estimate']);?></td>
			<?php
				if ((integer)$data['estimate']!=0){
					$ratio = $data['Total']/$data['estimate']*100;
				} else {
					$ratio = 'n/a';
				}
			?>
			<td class='budget-decimal <?php echo ($ratio<0?'budget-negative':'');?>'><em><?php echo number_format($ratio);?></em></td>
			<?php
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
				echo '<tr id="tr_',$data[$i]['guid'],'">';
				echo '<td>',$data[$i]['title'],'</td>';
				echo '<td>',$data[$i]['id'],'</td>';
				echo '<td>','<a class="budget-document-link" target="_blank" href="',$data[$i]['script'],'?',$data[$i]['prefix'],'ID=',$data[$i]['id'],'">',$data[$i]['guid'],'</a></td>';
				echo '<td class="td-posted ',($data[$i]['posted']?'budget-icon-posted':''),'">&nbsp;</td>';
				echo '<td class="td-deleted ',($data[$i]['deleted']?'budget-icon-deleted':''),'">&nbsp;</td>';
				echo '<td id="amount_',$data[$i]['guid'],'" class="budget-decimal ',($data[$i]['amount']<0?'budget-negative':''),'">',number_format($data[$i]['amount'],2,'.',','),'</td>';
				echo '<td>',$data[$i]['pccTitle'],'</td>';
				echo '<td>',$data[$i]['comment'],'</td>';
				echo '<td id="usrTitle_',$data[$i]['guid'],'">',$data[$i]['usrTitle'],'</td>';
				echo '<td id="timestamp_',$data[$i]['guid'],'">',date('d.m.Y H:i',strtotime($data[$i]['timestamp'])),'</td>';
				echo '</tr>';
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
						<th>Amount</th>
						<th>Profit</th>
						<th>Comment</th>
						<th>Editor</th>
						<th>Timestamp</th>
					</tr>
				</thead>
				<tfoot>
					<tr class="budget-subtotal">
						<td colspan="5">Total:</td>
						<td><?php echo number_format($total,2,'.',',');?></td>
					</tr>
				</tfoot>
				<tbody>
					<?php echo $strTbody; ?>
				</tbody>
			</table>
		<?php
	}
	
}

?>

