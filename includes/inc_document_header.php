<?php
echo '<h1>',$oBudget->title,' :: ';
if ($oDocument->ID){
 echo $arrUsrData["pagTitle"],' #',$oDocument->ID;
} else {
 echo 'New ',$arrUsrData["pagTitle"];
}
echo '</h1>';
echo '<p id="timestamp">',$oDocument->timestamp,'</p>';

$jsonData  = (array)$oDocument;
foreach ($jsonData as $key=>$value){
	if (is_a($value,'sql')){
		$jsonData[$key] = null;
	} 
}
?>
<script>
	var doc = <?php echo json_encode($jsonData);?>
</script>
<div>
<?php 

	$oDocument->Execute($oSQL, "panel", "formlist");

?>
</div>
<div id='tabs'>
	<ul>
		<li><a href='#tabs-input'>Input</a></li>
		<li><a href='<?php echo $_SERVER['REQUEST_URI']."&tab=kpi";?>'>KPI</a></li>
		<li><a href='<?php echo $_SERVER['REQUEST_URI']."&tab=financials";?>'>Financials</a></li>
		<li><a href='<?php echo "json_action_log.php?guid=",$oDocument->GUID;?>'>Action log</a></li>
	</ul>
	<div id='tabs-input'>
		<form>
			<input type="hidden" name="DataAction" id="DataAction" value="update">
			<div style="width: 100%; overflow-x: auto;">
			<?php
			if ($oDocument->GUID){
				$grid->Execute();
			}
			?>
			</div>
		</form>
	</div>
	<div id='tabs-kpi'>
	
	</div>
	<div id='tabs-fin'>
	
	</div>
</div>

