<?php
if($_GET['DataAction']=='master'){
	require_once ('classes/reports.class.php');
	$oReport = new Reports(Array('budget_scenario'=>$oDocument->budget->id));
	$oReport->masterDocument($oDocument->GUID, get_class($oDocument));
	die();
}

if($_GET['DataAction']=='copy'){
	$newid = $oDocument->copy($_GET['new_scenario']);
	redirect($_SERVER['PHP_SELF']."?".$oDocument->prefix."ID=".$newid);
	die();
}

echo '<h1>';
if ($oDocument->ID){
	echo $oDocument->budget->title,' :: ';
	echo "<a href='{$_SERVER['REQUEST_URI']}'>",$arrUsrData["pagTitle"], " #",$oDocument->ID,"</a>";
} else {
 echo 'New ',$arrUsrData["pagTitle"];
}
echo '</h1>';
?>
<pre class='sql' style='display:none;'>
SELECT * FROM `<?php echo $oDocument->register;?>` WHERE `source`='<?php echo $oDocument->GUID;?>';
SELECT * FROM `reg_master` WHERE `source`='<?php echo $oDocument->GUID;?>';
</pre>
<p id="timestamp">
<?php
	echo $oDocument->timestamp;
	if($oDocument->CopyOf){
		echo ". Copied from <a href='?{$oDocument->prefix}ID={$oDocument->CopyOf}'>".$arrUsrData["pagTitle"], " #",$oDocument->CopyOf."</a>";
	};
?>
</p>

<?php
if($oDocument->flagPosted){
	echo '<p id="doc_status" class="budget-doc-posted">',($strLocal?'Проведен':'Posted'),'</p>';
}

if($oDocument->flagDeleted){
	echo '<p id="doc_status" class="budget-doc-deleted">',($strLocal?'Удален':'Deleted'),'</p>';
}

if(isset($oDocument->budget) && !$oDocument->budget->flagUpdate){
	$arrWarning[] = Array('class'=>'warning','text'=>'The budget has been submitted and cannot be updated');
}

if ($oDocument->classified) {
	?>
	<div class='warning'>Classified by <?php echo strtoupper($oDocument->classified); ?></div>
	<?php
	if (strtoupper($oDocument->classified) != $arrUsrData['usrID'] && !in_array('FM', $arrUsrData['roleIDs'])){		
		require ('includes/inc-frame_bottom.php');
		die();
	}
}

for($i=0;$i<count($arrWarning);$i++){
	?>
	<div class='<?php echo $arrWarning[$i]['class']?$arrWarning[$i]['class']:'info';?>'><?php echo $arrWarning[$i]['text'];?></div>
	<?php
}
?>
<script>
	var doc = <?php $oDocument->getJSON(); ?>;
	$(window).load(function(){
		//$('#<?php echo $oDocument->gridName;?>').eiseGrid();
	});
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
		<button onclick='parse_textarea();' style='margin:auto;'>Parse into data table</button>
		<button class='fa-help' onclick='parse_textarea_help();' style='margin:auto;'><i class=' fa fa-question-circle'></i></button>
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
			<li><a href="javascript:$('#<?php echo $oDocument->gridName;?>').eiseGrid('addRow');">Add row</a></li>
			<?php } ?>
			<li><a href='javascript:SelectContent("<?php echo $oDocument->gridName;?>");'>Copy table</a></li>
		</ul>
	</div>
	<div id='tabs-kpi'>
	
	</div>
	<div id='tabs-fin'>
	
	</div>
</div>

<div id="sticky_notes"></div>

<!-------------- Container for messages-------------------->
<div id='sendTo' style='display:none;'><form id='send_form'>
<div><label for="input_recipient">To: </label>
	<input type="hidden" id="recipient" name="recipient" value="" >
	<input id="input_recipient" type="text" class="autocomplete" style="width:270px;" 
		data-autocomplete='{"table":"stbl_user","prefix":"usr"}'>
<div id='recipient_details'></div>
</div>
<div><label for="input_recipient_cc">Cc: </label><input type="hidden" id="recipient_cc" name="recipient_cc" value="" ><input id="input_recipient_cc" type="text" class="autocomplete" style="width:270px;" data-autocomplete='{"table":"stbl_user","prefix":"usr"}'>
<div id='recipient_cc_details'></div>
</div>
<hr/>
<div>
<label for="message"><?php echo $strLocal?"Текст сообщения":"Message text";?></label><br/>
<textarea rows="10" style="width:350px" name="message" id="message"></textarea>
</div></form>
</div>

