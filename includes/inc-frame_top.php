<?php
ob_start();
if (is_object($oSQL)){
?>
<div id='topbar-company-select'>
	<select id='company-select' name='company'>
	<?php
	$sql = "SELECT * FROM common_db.tbl_company";
	$rs = $oSQL->q($sql);
	while ($rw = $oSQL->f($rs)){
		?>
		<option value="<?php echo $rw['comID'];?>" <?php if ($rw['comID']==$company) echo 'selected';?>><?php echo $rw["comTitle$strLocal"];?></option>
		<?php
	}
	?>
	</select>
</div>
<?php
}
?>
<div id='topbar-search'>
	<form method="GET" id="customer-search" action='rep_sales_kpi_new.php'>
		<input name='cntID' placeholder='Customer...'/>
		<span id="customerSearchButton" class='fa fa-lg fa-search'></span>
	</form>

</div>
<script>
	$(document).ready(function(){
		$('#customerSearchButton').click(function(){
			$('#customer-search').submit();
		});
		$('#company-select').change(function(){
			location.search = 'company='+$(this).val();
		});
	});
</script>
<?php
$Intra->projectTopbar = ob_get_clean();
include('../common/izintra/inc-frame_top.php');
?>