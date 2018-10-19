<?php
function renderDataByPC($data, $arrProfit, $strTitle, $strClass=""){
	?>
	<tr class="<?php echo $strClass;?>">
		<td><?php echo $strTitle;?></td>
		<?php
		foreach($arrProfit as $pc=>$flag){
			?>
			<td class='budget-decimal'><?php Reports::render($data['this'][$pc]);?></td>
			<?php
		}
		?>
		<td class='budget-decimal budget-ytd'><?php if(is_array($data['this'])) Reports::render(array_sum($data['this']));?></td>
		<td class='budget-decimal '><?php if(is_array($data['last'])) Reports::render(array_sum($data['last']));?></td>
		<td class='budget-decimal '><?php if(is_array($data['last'])&&is_array($data['this'])) Reports::render(array_sum($data['this']) - array_sum($data['last']));?></td>
		<td class='budget-decimal budget-ratio'><?php if(is_array($data['last'])&&is_array($data['this'])) Reports::render_ratio(array_sum($data['this']) , array_sum($data['last']),0);?></td>
	</tr>
	<?php
}

function renderActualVsBudget($data, $arrProfit, $strTitle,$strLastTitle){
		?>
		<tr class="budget-subtotal">
			<td><?php echo $strTitle;?></td>
			<?php
			foreach($arrProfit as $pc=>$flag){
				?>
				<td class='budget-decimal'><?php Reports::render($data['this'][$pc]);?></td>
				<?php
			}
			?>
			<td class='budget-decimal budget-ytd'><?php Reports::render(array_sum($data['this']));?></td>
			<td class='budget-decimal '><?php Reports::render(array_sum($data['last']));?></td>
			<td class='budget-decimal '><?php Reports::render(array_sum($data['this']) - array_sum($data['last']));?></td>
			<td class='budget-decimal budget-ratio'><?php Reports::render_ratio(array_sum($data['this']) , array_sum($data['last']));?></td>
		</tr>
		<tr>
			<td><?php echo $strTitle,', ',$strLastTitle;?></td>
			<?php
			foreach($arrProfit as $pc=>$flag){
				?>
				<td class='budget-decimal'><?php Reports::render($data['last'][$pc]);?></td>
				<?php
			}
			?>
				<td class='budget-decimal budget-ytd'><?php Reports::render(array_sum($data['last']));?></td>	
			</tr>
			<tr>
				<td>Diff</td>
			<?php
			foreach($arrProfit as $pc=>$flag){
				?>
				<td class='budget-decimal'><?php Reports::render($data['this'][$pc] - $data['last'][$pc]);?></td>
				<?php
			}
			?>
			<td class='budget-decimal budget-ytd'><?php Reports::render(array_sum($data['this']) - array_sum($data['last']));?></td>	
		</tr>
		<?php
}

function getTableHeader($arrHeader = null){
	GLOBAL $oBudget, $oReference, $arrProfit, $periodTitle;
	ob_start();
	?>
		<tr>
		<th>Account</th>
		<?php 
		if(is_array($arrHeader)){
				foreach($arrHeader as $title){
					echo '<th>',$title,'</th>';
				}
		}
		foreach($arrProfit as $pc=>$flag){
					echo '<th>',$pc,'</th>';
		};?>
		<th class='budget-ytd'><?php echo $oBudget->type=='FYE'?'FYE':'Total';?><br/><small><?php echo $periodTitle;?></small></th>
		<th title="<?php echo $oReference->id;?>"><?php echo $oReference->title;?></th>
		<th>Diff</th>
		<th>%</th>
	</tr>
	<?php
	$res = ob_get_clean();
	return($res);
}

function getTableHeaderAct($arrHeader = null){
	GLOBAL $oBudget, $oReference, $arrActivity, $periodTitle;
	ob_start();
	?>
		<tr>
		<th>Account</th>
		<?php 
		if(is_array($arrHeader)){
				foreach($arrHeader as $title){
					echo '<th>',$title,'</th>';
				}
		}
		foreach($arrActivity as $key=>$title){
		echo "<th><div title='[{$key}] {$title}'>{$title}</div></th>";
		};?>
		<th class='budget-ytd'><?php echo $oBudget->type=='FYE'?'FYE':'Total';?><br/><small><?php echo $periodTitle;?></small></th>
		<th title="<?php echo $oReference->id;?>"><?php echo $oReference->title;?></th>
		<th>Diff</th>
		<th>%</th>
	</tr>
	<?php
	$res = ob_get_clean();
	return($res);
}

?>