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
<div id='topbar-search'>
	<form method="GET" id="customer-search" action='rep_sales_kpi_new.php'>
		<input type="hidden" name="cntID" id="cntID" value=""/>
		<input placeholder='Customer...' id="input_cntID" class="autocomplete" type="text" value=""  autocomplete="off" data-autocomplete='{"table":"vw_counterparty","prefix":"cnt"}'/>
		<!--<span id="customerSearchButton" class='fa fa-lg fa-search'></span>-->
	</form>

</div>
<script>
	$(document).ready(function(){
		
		initialize_autocomplete($('#customer-search'));
		
		$('#customerSearchButton').click(function(){
			$('#customer-search').submit();
		});
		$('#company-select').change(function(){
			location.search = 'company='+$(this).val();
		});
	});
	
	function initialize_autocomplete(oForm){
	oForm.find("input.autocomplete").each(function(){
	
		arrData = $.parseJSON($(this).attr('data-autocomplete'));
		var url = 'json_list.php?table='+arrData.table;
						
		var field_id = $(this).attr('id').replace('input_','');
		var cache = {},	lastXhr;
		
		if ($("#"+field_id ).val().length && !$(this).val().length){
			var that = $(this);
			$.getJSON(url, {'id':$( "#"+field_id ).val()}, function(data){				
				that.val(data[0].label);
			}); 
		}
		
		$(this).autocomplete({
			minLength: 3,
			source: function( request, response ) {
				var term = request.term;
				if ( term in cache ) {
					response( cache[ term ] );
					return;
				}
			
				lastXhr = $.getJSON( url, request, function( data, status, xhr ) {
					cache[ term ] = data;
					if ( xhr === lastXhr ) {
						response( data );
					}
				});
			},
			search: function (event,ui) {
				$( "#input_"+field_id).addClass('autocomplete-loading');
			},
			select: function( event, ui ) {
				$( "#"+field_id ).val(ui.item.value);
				$( "#input_"+field_id).val(ui.item.label).removeClass('autocomplete-loading') ;
				//$('#result').html('').append($('<div>',{'class':'spinner',text:'Loading...'}));
				$('#result').html(spinner_div());
				//specific handler for customer form
				location.href='rep_sales_kpi_new.php?cntID='+ui.item.value;
				// if (window.autocomplete_callback) {
					// autocomplete_callback(field_id,ui.item.value); //---defined in {entity_form}.js
				// }
				return false;
			}
		});
	});
}
</script>
<?php
}
if (is_object($Intra)) $Intra->projectTopbar = ob_get_clean();
include('../common/izintra/inc-frame_top.php');
?>