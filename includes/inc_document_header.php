<?php
echo '<h1>';
if ($oDocument->ID){
	echo $oDocument->budget->title,' :: ';
	echo $arrUsrData["pagTitle"],' #',$oDocument->ID;
} else {
 echo 'New ',$arrUsrData["pagTitle"];
}
echo '</h1>';
echo '<p id="timestamp">',$oDocument->timestamp,'</p>';

if($oDocument->flagPosted){
	echo '<p id="doc_status" class="budget-doc-posted">Posted</p>';
}

if($oDocument->flagDeleted){
	echo '<p id="doc_status" class="budget-doc-deleted">Deleted</p>';
}

if(isset($oDocument->budget) && !$oDocument->budget->flagUpdate){
	echo '<p class="warning">The budget has been submitted and cannot be updated</p>';
}

?>
<script>
	var doc = <?php $oDocument->getJSON(); ?>
</script>
<div>
<table style='width:100%'>
<tr><td>
<?php 

	$oDocument->Execute($oSQL, "panel", "formlist");

?>
</td>
<?php if ($oDocument->flagUpdate) { ?>
<td style='width:400px;'>
	<div style='text-align:center;'>
		<textarea id='input_textarea' rows='10' style='width:90%;margin:5px;' placeholder='Paste Excel table here (numbers only)'></textarea>
		<a class='a-button' href='javascript:parse_textarea();' style='margin:auto;'>Parse into data table</a>
	</div>
</td>
<?php } ?>
</tr>
</table>
</div>
<div id='tabs'>
	<ul>
		<li><a href='#tabs-input'>Input</a></li>
		<li><a href='<?php echo $_SERVER['REQUEST_URI']."&tab=kpi";?>'>KPI</a></li>
		<li><a href='<?php echo $_SERVER['REQUEST_URI']."&tab=financials";?>'>Financials</a></li>
		<li><a href='<?php echo "json_action_log.php?guid=",$oDocument->GUID;?>'>Action log</a></li>
		<?php
		if ($flagProfitRestriction){
		?>
		<li><a href='<?php echo $_SERVER['REQUEST_URI']."&tab=access";?>'>Access</a></li>
		<?php
		}
		?>
	</ul>
	<div id='tabs-input'>
		<form>
			<input type="hidden" name="DataAction" id="DataAction" value="update">
			<div style="width: 100%; overflow-x: auto;">
			<?php
			if ($oDocument->GUID){
				$oDocument->grid->Execute();
			}
			?>			
			</div>
		</form>
		<ul class='link-footer'>
			<?php if ($oDocument->flagUpdate) { ?>
			<li><a href='javascript:grids["<?php echo $oDocument->gridName;?>"].addRow(null);'>Add row</a></li>
			<?php } ?>
			<li><a href='javascript:SelectContent("<?php echo $oDocument->gridName;?>");'>Select table</a></li>
		</ul>
	</div>
	<div id='tabs-kpi'>
	
	</div>
	<div id='tabs-fin'>
	
	</div>
</div>

