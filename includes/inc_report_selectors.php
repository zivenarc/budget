<?php
$sql = "SELECT prtID, prtTitleLocal as prtTitle,prtGHQ FROM vw_product_type WHERE prtGHQ<>'' ORDER BY prtGHQ, prtTitle";
$rs = $oSQL->q($sql);
while ($rw = $oSQL->f($rs)){
	$arrPRT[$rw['prtID']] = $rw;
}

?>
<div id="activity_list" style='display:none;'>
<?php
$prtGHQ = null;
$fieldsetOpen = 0;
foreach($arrPRT as $key=>$data){
	if($data['prtGHQ']!=$prtGHQ){
		if($fieldsetOpen){
			echo "</fieldset>";
		}
			echo "<fieldset><legend>{$data['prtGHQ']}</legend>";
			$fieldsetOpen = 1;
	}
	echo "<button onclick='javascript:location.search=\"activity={$data['prtID']}\"'>{$data['prtTitle']}</button>";
	$prtGHQ = $data['prtGHQ'];
}
if($fieldsetOpen){
			echo "</fieldset>";
}
if(is_array($arrPRT[$activity])){
	$strFilterSubtitle .= "Product=".$arrPRT[$activity]['prtGHQ']." :: ".$arrPRT[$activity]['prtTitle'];
}
?>
<button  onclick='javascript:location.search="activity=all"'>Reset activity filter</button>
</div>
<div id="category_list" style='display:none;'>
<?php
	$sql = "SELECT * FROM common_db.tbl_category WHERE catTableID='tbl_counterparty'";
	$rs = $oSQL->q($sql);
	while ($data = $oSQL->f($rs)){
		echo "<button onclick='javascript:location.search=\"catID={$data['catID']}\"'>{$data['catTitle']}</button>";
	}
?>
</div>
<script>
function showActivityList(){
	$('#activity_list').dialog(
		{
			title:'Activity filter',
			modal: true,
			width: '70%'
		}
	);
}
function showCategoryList(){
	$('#category_list').dialog(
		{
			title:'Categories',
			modal: true,
			width: '30%'
		}
	);
}
</script>
<?php
echo $strFilterSubtitle ? "<h3>Filter: {$strFilterSubtitle}</h3>":'';
?>
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
	<?php
		$sql = "SELECT S.scnID, S.scnTitle, S.scnLastID, L.scnTitle 
				FROM tbl_scenario S
				LEFT JOIN tbl_scenario L ON L.scnID=S.scnLastID
				WHERE S.scnFlagArchive=0
				ORDER BY S.scnDateStart";
		$rs = $oSQL->q($sql);
		while ($rw = $oSQL->f($rs)){
			$arrScenario[$rw['scnID']] = $rw;
		}
	?>
	<script>
		var arrScenario = <?php echo json_encode($arrScenario); ?>;
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
					var reference = arrScenario[data.item.value].scnLastID;
					$('#reference').val(reference);
					location.search = 'budget_scenario='+data.item.value+'&reference='+reference;
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