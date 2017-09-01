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
		<td class='budget-decimal budget-ytd'><?php Reports::render(array_sum($data['this']));?></td>
		<td class='budget-decimal '><?php Reports::render(array_sum($data['last']));?></td>
		<td class='budget-decimal '><?php Reports::render(array_sum($data['this']) - array_sum($data['last']));?></td>
		<td class='budget-decimal budget-ratio'><?php Reports::render_ratio(array_sum($data['this']) , array_sum($data['last']));?></td>
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
		<th title="<?php echo $oReference->title;?>"><?php echo $oReference->id;?></th>
		<th>Diff</th>
		<th>%</th>
	</tr>
	<?php
	$res = ob_get_clean();
	return($res);
}
?>