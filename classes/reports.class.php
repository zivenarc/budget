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
				?>
				<tr class='graph'>
				<?php
				echo "<td><a href='javascript:getCustomerKPI({activity:{$rw['prtID']}});'>",$rw['Activity'],'</a></td>';
				echo '<td class="unit">',$rw['Unit'],'</td>';
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
					$sqlWhere AND posted=1 AND salary>0
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
			$sql = "SELECT prtGHQ, account, Title, ".Budget::getMonthlySumSQL().", SUM(".Budget::getYTDSQL().") as Total 
			FROM `vw_master`
			$sqlWhere
			GROUP BY prtGHQ, account
			ORDER BY prtGHQ, account			
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
				<tr><th>Activity</th><th>Account</th><th>Title</th><?php echo Budget::getTableHeader(); ?><th class='budget-ytd'>Total</th></tr>
			</thead>			
			<tbody>
			<?php			
			while ($rw=$oSQL->f($rs)){
				echo '<tr>';
				echo '<th>',$rw['prtGHQ'],'</th>';
				echo '<th>',$rw['account'],'</th>';
				echo '<th>',$rw['Title'],'</th>';
				for ($m=1;$m<13;$m++){
					$month = date('M',mktime(0,0,0,$m,15));
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
				<tr>
					<th>Activity</th><th>Account</th><?php echo Budget::getTableHeader(); ?><th class='budget-ytd'>Total</th>
				</tr>
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
		
	
	public function masterbyCustomerEst($sqlWhere, $currency=643){
		
		GLOBAL $budget_scenario;
		$Budget = new Budget($budget_scenario);
		
		$strFields = self::_getMonthlyFields($currency);
		
		ob_start();
			$sql = "SELECT Customer_name as 'GroupLevel1', customer as 'level1_code', `Budget item`, `Group`, `item`, 
			{$strFields}
			FROM `vw_master` 
			LEFT JOIN tbl_scenario ON scnID=scenario
			{$sqlWhere} AND Group_code=94 ## Gross margin only
			GROUP BY `vw_master`.customer, `vw_master`.item
			ORDER BY `vw_master`.customer, `Group`, `vw_master`.itmOrder ASC			
			";
			
			self::firstLevelReport($sql, 'Customer', $Budget);
			//==========================================================================================================================Non-customer-related data
			self::noFirstLevelReport($sqlWhere, $currency);
			?>
			</tbody>
			</table>
			<?php			
			ob_flush();
	}
	
	public function masterbyProfitEst($sqlWhere, $currency=643){
		
		$strFields = self::_getMonthlyFields($currency);
		
		ob_start();
			$sql = "SELECT `Budget item` as 'GroupLevel1', `item` as 'level1_code', `Profit` as 'Budget item', `Group`, `pc` as 'item', 
			{$strFields}
			FROM `vw_master` 
			##LEFT JOIN tbl_scenario ON scnID=scenario
			{$sqlWhere}
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
	
	public function masterbyActivityEst($sqlWhere, $currency=643){
		
		GLOBAL $budget_scenario;
		$Budget = new Budget($budget_scenario);
		
		$strFields = self::_getMonthlyFields($currency);
		
		ob_start();
			$sql = "SELECT Activity_title as 'GroupLevel1', activity as 'level1_code', `Budget item`, `Group`, `item`,
					{$strFields}
			FROM `vw_master` 
			##LEFT JOIN tbl_scenario ON scnID=scenario
			$sqlWhere AND Group_code=94 ## Gross margin only
			GROUP BY `vw_master`.activity, `vw_master`.item
			ORDER BY prtRHQ, prtGHQ,`vw_master`.activity, `Group`, `vw_master`.itmOrder ASC			
			";
			
			self::firstLevelReport($sql, 'Activity', $Budget);
			//==========================================================================================================================Non-customer-related data
			self::noFirstLevelReport($sqlWhere, $currency);
			?>
			</tbody>
			</table>
			<?php			
			ob_flush();
	}
	
	public function masterbyGHQEst($sqlWhere, $currency=643){
		
		GLOBAL $budget_scenario;
		$Budget = new Budget($budget_scenario);
		
		$strFields = self::_getMonthlyFields($currency);
		
		ob_start();
			$sql = "SELECT prtGHQ as 'GroupLevel1', prtGHQ as 'level1_code', `Budget item`, `Group`, `item`,
					{$strFields}
			FROM `vw_master` 			
			{$sqlWhere} AND Group_code=94 ## Gross margin only
			GROUP BY `vw_master`.prtGHQ, `vw_master`.item
			ORDER BY prtGHQ, `Group`, `vw_master`.itmOrder ASC			
			";
			
			self::firstLevelReport($sql, 'Activity', $Budget);
			//==========================================================================================================================Non-customer-related data
			self::noFirstLevelReport($sqlWhere, $currency);
			?>
			</tbody>
			</table>
			<?php			
			ob_flush();
	}
	
	public function masterYactbyActivityEst($sqlWhere){
		global $oSQL;
		
		$strFields = self::_getMonthlyFields($currency);
		
		ob_start();
			$sql = "SELECT prtGHQ as 'GroupLevel1', activity as 'level1_code', CONCAT(`account`,': ',`Title`) as `Budget item`, Yact_group as `Group`, account as `item`,
					{$strFields}				
			FROM `vw_master` 
			{$sqlWhere} 
			AND yact_group_code IN ('450000','400000') ## Gross margin only
			GROUP BY `vw_master`.prtGHQ, `vw_master`.account
			ORDER BY prtGHQ,`vw_master`.activity, `Yact_group`, `vw_master`.account ASC			
			";
			
			self::firstLevelReport($sql, 'Activity');
			//==========================================================================================================================Non-customer-related data
			self::noFirstLevelReport_YACT($sqlWhere, $currency);
			?>
			</tbody>
			</table>
			<?php			
			ob_flush();
	}
	
	private function firstLevelReport($sql, $firstLevelTitle, $Budget=null){
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
					<th class='budget-ytd'><?php echo $Budget->type=='Budget'?'Budget':'FYE';?></th>
					<th><?php echo $Budget->type=='Budget'?'Estimate':'Budget';?></th>
					<th>Diff</th>
					<th>%</th>
					<th class='budget-ytd FYE_analysis'>YTD Actual</th>
					<th class='FYE_analysis'>YTD Budget</th>
					<th class='FYE_analysis'>Diff</th>
					<th class='FYE_analysis'>%</th>
					<th class='budget-ytd FYE_analysis'>ROY Est</th>
					<th class='FYE_analysis'>ROY Budget</th>
					<th class='FYE_analysis'>Diff</th>
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
						self::echoBudgetItemString($data,'budget-subtotal', $Budget);
					}
					//------------------------Collecting subtotals---------------------------------------
					$local_subtotal = 0;
					for ($m=1;$m<13;$m++){
						$month = date('M',mktime(0,0,0,$m,15));
						$subtotal[$rw['GroupLevel1']][$month]+=$rw[$month];
						$subtotal[$rw['GroupLevel1']]['Q'.$m]+=$rw['Q'.$m];
						$local_subtotal += $rw[$month];
						
					}
						
					$subtotal[$rw['GroupLevel1']]['YTD_A'] += $rw['YTD_A'];
					$subtotal[$rw['GroupLevel1']]['YTD'] += $rw['YTD'];
					$subtotal[$rw['GroupLevel1']]['ROY_A'] += $rw['ROY_A'];
					$subtotal[$rw['GroupLevel1']]['ROY'] += $rw['ROY'];
					
					$subtotal[$rw['GroupLevel1']]['Total'] += $local_subtotal;
					$subtotal[$rw['GroupLevel1']]['estimate'] += $rw['estimate'];
														
					
					$data = $rw;
					if ($data['GroupLevel1']==$GroupLevel1 && $GroupLevel1) $data['GroupLevel1']="&nbsp;";
					self::echoBudgetItemString($data,$tr_class, $Budget);
					
					$GroupLevel1 = $rw['GroupLevel1'];
					$group = $rw['Group'];
				}
				$data = $subtotal[$GroupLevel1];
				$data['Budget item']=$group;
				self::echoBudgetItemString($data,'budget-subtotal', $Budget);
				
				
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
	
	private function noFirstLevelReport($sqlWhere, $currency=643){
				
		global $oSQL;		
		
		$strFields = self::_getMonthlyFields($currency);
		
		$sql = "SELECT `Budget item`, `item`, `Group`, `Group_code`, 
					{$strFields}
			FROM `vw_master`
			##LEFT JOIN tbl_scenario ON scnID=scenario
			{$sqlWhere} 
			GROUP BY `Group`, `Budget item`
			ORDER BY `Group`, `itmOrder` ASC";
			
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
	
	private function _getMonthlyFields($currency){
		GLOBAL $budget_scenario;
		$Budget = new Budget($budget_scenario);
		$arrRates = $Budget->getMonthlyRates($currency);
		
		$res=	Budget::getMonthlySumSQL(1,12,$arrRates).", ".
				Budget::getQuarterlySumSQL($arrRates).", 
				SUM(".Budget::getYTDSQL(1,12,$arrRates).") as Total ,
				SUM(estimate/{$arrRates['YTD']}) as estimate, 
				SUM(".Budget::getYTDSQL(1, (integer)date('n',$Budget->date_start)-1,$arrRates).") as YTD_A, 
				SUM(YTD/{$arrRates['YTD']}) as YTD, 
				SUM(".Budget::getYTDSQL((integer)date('n',$Budget->date_start),12,$arrRates).") as ROY_A, 
				SUM(ROY/{$arrRates['YTD']}) as ROY";
		
		return ($res);
		
	}
	
	private function echoBudgetItemString($data, $strClass=''){					
		
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
				$ytd = 0;
				$roy = 0;
				for ($m=1;$m<13;$m++){
					$month = date('M',mktime(0,0,0,$m,15));
					
					?>
					<td class='budget-decimal budget-monthly budget-<?php echo $month;?>'><?php self::render($data[$month],0);?></td>
					<?php
				}
				
				//--------------------- quarterly data -----------------------
				if(isset($data['Q1'])){
					for ($m=1;$m<5;$m++){
						?>
						<td class='budget-decimal budget-quarterly budget-<?php echo 'q'.$m;?>'><?php self::render($data['Q'.$m],0);?></td>
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
				<tr id="tr_<?php echo $data[$i]['guid'];?>">
					<td><?php echo $data[$i]['title'];?></td>
					<td><?php echo $data[$i]['id'];?></td>
					<td><a class="budget-document-link" target="_blank" href="<?php echo $data[$i]['script'].'?'.$data[$i]['prefix'].'ID='.$data[$i]['id'];?>"><?php echo $data[$i]['guid'];?></a></td>
					<td class="td-posted <?php echo ($data[$i]['posted']?'budget-icon-posted':'');?>">&nbsp;</td>
					<td class="td-deleted <?php echo ($data[$i]['deleted']?'budget-icon-deleted':'');?>">&nbsp;</td>
					<td id="amount_<?php echo $data[$i]['guid'];?>" class="budget-decimal"><?php self::render($data[$i]['amount']);?></td>
					<td><?php echo $data[$i]['pccTitle'];?></td>
					<td><?php echo $data[$i]['comment'];?></td>
					<td id="usrTitle_<?php echo $data[$i]['guid'];?>"><?php echo $data[$i]['usrTitle'];?></td>
					<td id="timestamp_<?php echo $data[$i]['guid'];?>"><?php echo date('d.m.Y H:i',strtotime($data[$i]['timestamp']));?></td>
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
						<td><?php self::render($total);?></td>
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
	
	function render_ratio ($n1, $n2){
		if ((integer)$n2==0){
			echo 'n/a';
			return;			
		} else {
			self::render($n1/$n2*100,1);
		}
	}
	
}

?>

