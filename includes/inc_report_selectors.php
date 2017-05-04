<div id="report_selectors">
	<form>
	<table>
	<tr>
	<td>
	<div id="currency_selector">
		<?php 		
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
			// $arrDSelector = Array(1=>'1',1000=>'1k',1000000=>'1M');
			$arrDSelector = Array(1=>'1',1000=>'1k');
			foreach ($arrDSelector as $key=>$title){
				$label = "denominator_".$key;
			?>		
			<input type="radio" id="<?php echo $label;?>" name="denominator" <?php if ($denominator==$key) echo "checked='checked'";?> value="<?php echo $key;?>"><label for="<?php echo $label;?>"><?php echo $title;?></label>
			<?php } ?>
	</div>
	</td>
	<td>
	<div><label for='budget_scenario'>Select scenario</label><?php echo $oBudget->getScenarioSelect();?></div>
	</td>
	<td>
	<div><label for='reference'>Compare to</label><?php echo $oBudget->getScenarioSelect(Array('active'=>false,'name'=>'reference','budget_scenario'=>$reference)); ?></div>
	</td>
	<td>
	<div><label for='bu_group'>Group</label><?php echo $oBudget->getBUGroupSelect(); ?></div>
	</td>
	<td>
	<input type="submit" id="submit_button" value="Request"/>
	</td>
	</tr>
	</table>
	</form>
	<script>
		$(document).ready(function(){			
			$('#currency_selector, #denominator_selector').buttonset();
			$('#submit_button').button();
			$('input[name="currency"]').change(function(){
				location.search = 'currency='+$(this).val();
			});
			$('input[name="denominator"]').change(function(){
				location.search = 'denominator='+$(this).val();
			});
			$('#budget_scenario').selectmenu({
				change: function(event,data) {
					location.search = 'budget_scenario='+data.item.value;
				}
			});
			$('#reference').selectmenu({
				change: function(event,data) {
					location.search = 'reference='+data.item.value;
				}
			});	
			$('#bu_group').selectmenu({
				change: function(event,data) {
					location.search = 'bu_group='+data.item.value;
				}
			});
		});
	</script>
</div>