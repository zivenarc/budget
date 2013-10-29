<?php
class Reports{
	
	public function salesByActivity($sqlWhere=''){
		GLOBAL $oSQL;
		ob_start();
			$sql = "SELECT prtRHQ, prtTitle as 'Activity', vw_product_type.prtUnit as 'Unit', ".Budget::getMonthlySumSQL().", SUM(".Budget::getYTDSQL().") as Total FROM `reg_sales`
					LEFT JOIN vw_product ON prdID=product
					LEFT JOIN vw_product_type ON prtID=prdCategoryID
					$sqlWhere
					GROUP BY `reg_sales`.`activity`, `reg_sales`.`unit`
					ORDER BY prtRHQ";
			$rs = $oSQL->q($sql);
			if (!$oSQL->num_rows($rs)){
				echo "<div class='warning'>No data found</div>";
				return (false);
			}			
			?>
			<table class='budget'>
			<thead>
				<tr><th>Activity</th><th>Unit</th><?php echo Budget::getTableHeader(); ?><th class='budget-ytd'>Total</th></tr>
			</thead>			
			<tbody>
			<?php
			while ($rw=$oSQL->f($rs)){
				echo '<tr>';
				echo '<td>',$rw['Activity'],'</td>';
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
	
	public function costsBySupplier($sqlWhere=''){
		GLOBAL $oSQL;
		ob_start();
			$sql = "SELECT cntTitle as 'Supplier', unit as 'Unit', ".Budget::getMonthlySumSQL().", SUM(".Budget::getYTDSQL().") as Total FROM `reg_costs`
					LEFT JOIN vw_supplier ON cntID=supplier
					LEFT JOIN vw_item ON itmGUID=item
					$sqlWhere
					GROUP BY `reg_costs`.`supplier`, `reg_costs`.`item`
					ORDER BY supplier";
			$rs = $oSQL->q($sql);
			if (!$oSQL->num_rows($rs)){
				echo "<div class='warning'>No data found</div>";
				return (false);
			}			
			?>
			<table class='budget'>
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
			$sql = "SELECT prtRHQ, prtTitle as 'Activity', funTitle , ".Budget::getMonthlySumSQL().", SUM(".Budget::getYTDSQL().")/12 as Total 
					FROM `reg_headcount`
					LEFT JOIN vw_function ON funGUID=function
					LEFT JOIN vw_product_type ON prtID=activity
					$sqlWhere
					GROUP BY `activity`, `function`
					ORDER BY prtRHQ";
			$rs = $oSQL->q($sql);			
			if (!$oSQL->num_rows($rs)){
				echo "<div class='warning'>No data found</div>";
				return (false);
			}
			?>
			<table class='budget'>
			<thead>
				<tr><th>Activity</th><th>Function</th><?php echo Budget::getTableHeader(); ?><th class='budget-ytd'>Average</th></tr>
			</thead>			
			<tbody>
			<?php
			while ($rw=$oSQL->f($rs)){
				echo '<tr>';
				echo '<td>',$rw['Activity'],'</td>';
				echo '<td>',$rw['funTitle'],'</td>';
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
	
	public function masterByProfit($sqlWhere=''){
		global $oSQL;
		
		ob_start();
			$sql = "SELECT Profit as 'Profit', `Budget item`, `Group`, ".Budget::getMonthlySumSQL().", SUM(".Budget::getYTDSQL().") as Total FROM `vw_master`
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
			<table class='budget'>
			<thead>
				<tr><th>Profit center</th><th>Account</th><?php echo Budget::getTableHeader(); ?><th class='budget-ytd'>Total</th></tr>
			</thead>			
			<tbody>
			<?php
			$profit = '';
			while ($rw=$oSQL->f($rs)){
				if($profit && $profit!=$rw['Profit']){
					echo '<tr class=\'budget-subtotal\'>';
					echo '<td colspan=\'2\'>',$rw['Group'],'</td>';
					for ($m=1;$m<13;$m++){
						$month = date('M',mktime(0,0,0,$m,15));
						echo "<td class='budget-decimal budget-$month ".($subtotal[$profit][$month]<0?'budget-negative':'')."'>",number_format($subtotal[$profit][$month]),'</td>';
					}
					echo "<td class='budget-decimal budget-$month ".(array_sum($subtotal[$profit])<0?'budget-negative':'')."'>",number_format(array_sum($subtotal[$profit])),'</td>'; 
					echo '</tr>';
				}
				echo '<tr>';
				echo '<td>',($profit!=$rw['Profit']?$rw['Profit']:''),'</td>';
				echo '<td>',$rw['Budget item'],'</td>';
				for ($m=1;$m<13;$m++){
					$month = date('M',mktime(0,0,0,$m,15));
					echo "<td class='budget-decimal budget-$month ".($rw[$month]<0?'budget-negative':'')."'>",number_format($rw[$month]),'</td>';
					$subtotal[$rw['Profit']][$month]+=$rw[$month];
				}
				echo "<td class='budget-decimal budget-ytd ".($rw['Total']<0?'budget-negative':'')."'>",number_format($rw['Total']),'</td>';
				echo "</tr>\r\n";
				$profit = $rw['Profit'];
				$group = $rw['Group'];
			}
			echo '<tr class=\'budget-subtotal\'>';
			echo '<td colspan=\'2\'>',$group,'</td>';
			for ($m=1;$m<13;$m++){
				$month = date('M',mktime(0,0,0,$m,15));
				echo "<td class='budget-decimal budget-$month ".($subtotal[$profit][$month]<0?'budget-negative':'')."'>",number_format($subtotal[$profit][$month]),'</td>';
			}
			echo "<td class='budget-decimal budget-$month ".(array_sum($subtotal[$profit])<0?'budget-negative':'')."'>",number_format(array_sum($subtotal[$profit])),'</td>'; 
			echo '</tr>';
			?>
			</tbody>
			</table>
			<?php			
			ob_flush();
	}
	
	public function masterByCustomer($sqlWhere=''){
		global $oSQL;
		
		ob_start();
			$sql = "SELECT Customer_name as 'Customer', `Budget item`, `Group`, ".Budget::getMonthlySumSQL().", SUM(".Budget::getYTDSQL().") as Total FROM `vw_master`
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
			<table class='budget'>
			<thead>
				<tr><th>Customer</th><th>Account</th><?php echo Budget::getTableHeader(); ?><th class='budget-ytd'>Total</th></tr>
			</thead>			
			<tbody>
			<?php
			$customer = '';
			while ($rw=$oSQL->f($rs)){
				if($customer && $customer!=$rw['Customer']){
					echo '<tr class=\'budget-subtotal\'>';
					echo '<td colspan=\'2\'>',$rw['Group'],'</td>';
					for ($m=1;$m<13;$m++){
						$month = date('M',mktime(0,0,0,$m,15));
						echo "<td class='budget-decimal budget-$month ".($subtotal[$customer][$month]<0?'budget-negative':'')."'>",number_format($subtotal[$customer][$month]),'</td>';
					}
					echo "<td class='budget-decimal budget-$month ".(array_sum($subtotal[$customer])<0?'budget-negative':'')."'>",number_format(array_sum($subtotal[$customer])),'</td>'; 
					echo '</tr>';
				}
				echo '<tr>';
				echo '<td>',($customer!=$rw['Customer']?$rw['Customer']:''),'</td>';
				echo '<td>',$rw['Budget item'],'</td>';
				for ($m=1;$m<13;$m++){
					$month = date('M',mktime(0,0,0,$m,15));
					echo "<td class='budget-decimal budget-$month ".($rw[$month]<0?'budget-negative':'')."'>",number_format($rw[$month]),'</td>';
					$subtotal[$rw['Customer']][$month]+=$rw[$month];
				}
				echo "<td class='budget-decimal budget-ytd ".($rw['Total']<0?'budget-negative':'')."'>",number_format($rw['Total']),'</td>';
				echo "</tr>\r\n";
				$customer = $rw['Customer'];
				$group = $rw['Group'];
			}
			echo '<tr class=\'budget-subtotal\'>';
			echo '<td colspan=\'2\'>',$group,'</td>';
			for ($m=1;$m<13;$m++){
				$month = date('M',mktime(0,0,0,$m,15));
				echo "<td class='budget-decimal budget-$month ".($subtotal[$customer][$month]<0?'budget-negative':'')."'>",number_format($subtotal[$customer][$month]),'</td>';
			}
			echo "<td class='budget-decimal budget-$month ".(array_sum($subtotal[$customer])<0?'budget-negative':'')."'>",number_format(array_sum($subtotal[$customer])),'</td>'; 
			echo '</tr>';
			?>
			</tbody>
			</table>
			<?php			
			ob_flush();
	}
	
	public function masterbyCustomerEst($sqlWhere){
		global $oSQL;
		
		ob_start();
			$sql = "SELECT Customer_name as 'Customer', `Budget item`, `Group`, ".Budget::getMonthlySumSQL().", SUM(".Budget::getYTDSQL().") as Total, SUM(estimate) as estimate
			FROM `vw_master` $sqlWhere AND Group_code=94 ## Gross margin only
			GROUP BY `vw_master`.customer, `vw_master`.item
			ORDER BY `vw_master`.customer, `Group`, `vw_master`.item DESC			
			";
			if (!$rs = $oSQL->q($sql)){
				echo "<div class='error'>SQL error:</div>";
				echo "<pre>$sql</pre>";
				return (false);
			};
			?>
			<table class='budget'>
			<thead>
				<tr><th>Customer</th><th>Account</th><?php echo Budget::getTableHeader(); ?><th class='budget-ytd'>Total</th><th>Estimate</th><th>Diff</th><th>%</th></tr>
			</thead>			
			<tbody>
			<?php
			if ($oSQL->num_rows($rs)){
				$customer = '';		
				while ($rw=$oSQL->f($rs)){
					if($customer && $customer!=$rw['Customer']){
						$data = $subtotal[$customer];
						$data['Budget item']=$group;
						self::echoBudgetItemString($data,'budget-subtotal');
					}
					//------------------------Collecting subtotals---------------------------------------
					$local_subtotal = 0;
					for ($m=1;$m<13;$m++){
						$month = date('M',mktime(0,0,0,$m,15));
						$subtotal[$rw['Customer']][$month]+=$rw[$month];
						$local_subtotal += $rw[$month];
					}
					$subtotal[$rw['Customer']]['Total'] += $local_subtotal;
					$subtotal[$rw['Customer']]['estimate'] += $rw['estimate'];
					
					$data = $rw;
					if ($data['Customer']==$customer && $customer) $data['Customer']="&nbsp;";
					self::echoBudgetItemString($data,$tr_class);
					
					$customer = $rw['Customer'];
					$group = $rw['Group'];
				}
				$data = $subtotal[$customer];
				$data['Budget item']=$group;
				self::echoBudgetItemString($data,'budget-subtotal');
			}
			//==========================================================================================================================Non-customer-related data
			$sql = "SELECT `Budget item`, `Group`, `Group_code`, ".Budget::getMonthlySumSQL().", SUM(".Budget::getYTDSQL().") as Total ,SUM(estimate) as estimate
			FROM `vw_master` $sqlWhere 
			GROUP BY `Group`, `Budget item`
			ORDER BY `Group`, `Budget item` DESC";
			
			$group = '';
			$subtotal = Array();
			$grandTotal = Array();
			$rs = $oSQL->q($sql);
			while ($rw=$oSQL->f($rs)){
				
				if ($rw['Group_code']==94){
					$tr_class = "budget-total";
				} else {
					$tr_class = '';
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
					$local_subtotal += $rw[$month];
					$grandTotal[$month] += $rw[$month];
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
			?>
			</tbody>
			</table>
			<?php			
			ob_flush();
	}
	private function echoBudgetItemString($data, $strClass='' ){		
		ob_start();
		static $customer;
		?>
		<tr class='<?php echo $strClass;?>'>
			<?php 			
			if (strlen($data['Customer'])){				
			?>
			<td class='budget-tdh'><?php echo $data['Customer'];?></td>
			<td><?php echo $data['Budget item'];?></td>
			<?php } else {	?>
			<td colspan="2"><?php echo ($data['Group_code']==94?'Total '.strtolower($data['Budget item']):$data['Budget item']);?></td>
			<?php
			}
				$local_subtotal = 0;
				for ($m=1;$m<13;$m++){
					$month = date('M',mktime(0,0,0,$m,15));
					echo "<td class='budget-decimal budget-$month ".($data[$month]<0?'budget-negative':'')."'>",number_format($data[$month]),'</td>';					
				}
			?>
			<td class='budget-decimal budget-ytd <?php echo $data['Total']<0?'budget-negative':'';?>'><?php echo number_format($data['Total']);?></td>
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
		</tr>
		<?php
		ob_flush();
	}
	
}

?>

