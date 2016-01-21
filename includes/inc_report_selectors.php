<form>
<table>
<tr>
<td>
<div id="currency_selector">
	<?php 
		$arrCurrencySelector = Array(978=>'EUR',840=>'USD',643=>'RUB');
		foreach ($arrCurrencySelector as $key=>$title){
			$label = "currency_".$key;
		?>		
		<input type="radio" id="<?php echo $label;?>" name="currency" <?php if ($currency==$key) echo "checked='checked'";?> value="<?php echo $key;?>"><label for="<?php echo $label;?>"><?php echo $title;?></label>
		<?php } ?>
</div>
</td>
<td>
<div id="denominator_selector">
	<?php 
		$arrDSelector = Array(1=>'1',1000=>'1k',1000000=>'1M');
		foreach ($arrDSelector as $key=>$title){
			$label = "denominator_".$key;
		?>		
		<input type="radio" id="<?php echo $label;?>" name="denominator" <?php if ($denominator==$key) echo "checked='checked'";?> value="<?php echo $key;?>"><label for="<?php echo $label;?>"><?php echo $title;?></label>
		<?php } ?>
</div>
</td>
<td>
<div class='f-row'><label for='budget_scenario'>Select scenario</label><?php echo $oBudget->getScenarioSelect();?></div>
</td>
<td>
<div class='f-row'><label for='reference'>Compare to</label><?php echo $oBudget->getScenarioSelect(Array('active'=>false,'name'=>'reference','budget_scenario'=>$reference); ?></div>
</td>
</tr>
</table>
</form>
<script>
	$(document).ready(function(){
		$('#currency_selector, #denominator_selector').buttonset();
		$('input[name="currency"]').change(function(){
			location.search = 'currency='+$(this).val();
		});
		$('input[name="denominator"]').change(function(){
			location.search = 'denominator='+$(this).val();
		});
	});
</script>