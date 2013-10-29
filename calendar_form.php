<?php
//$_DEBUG = true;
require ('common/auth.php');
$rwEntity = Array('entEntity'=>'tbl_calendar','entTable'=>'tbl_calendar','entPrefix'=>'cal');

if ($arrUsrData["FlagCreate"]){
	$arrActions[]= Array ("title" => "New"
	   , "action" => $_SERVER['PHP_SELF']
	   , "class" => "new"
	);
}
if ($arrUsrData["FlagUpdate"]){
	$arrActions[]= Array ("title" => "Save"
	   , "action" => "javascript:save();"
	   , "class" => "save"
	);
}

require ('includes/inc_ref_form.php');
if ($itemID) {
	$strTitle = $rwMain["calTitle$strLocal"].", ".iconv('cp1251','utf-8',strftime("%A %d %B %Y", strtotime($rwMain['calDateStart'])));
} else {
	$strTitle = ($strLocal?"Новая запись":"New record");
};
	
$arrJS[]="js/ef_common.js";
ob_start()
?>
<script type="text/javascript">
	var strLocal = '<?php echo $strLocal; ?>';
	$(document).ready(function(){
			
		var currentDate = new Date();
		var arrCalDateStart = $('#calDateStart').val().split('.');
		var arrCalDateEnd = $('#calDateStart').val().split('.');
		var calDateStart = new Date(arrCalDateStart[2],arrCalDateStart[1]-1,arrCalDateStart[0]);
		var calDateEnd = new Date(arrCalDateEnd[2],arrCalDateEnd[1]-1,arrCalDateEnd[0]);
		
		if (calDateStart-currentDate<0) $('#calDateStart').attr('disabled',true);
		if (calDateEnd-currentDate<0) $('#calDateEnd').attr('disabled',true);
		
		$('input.date').datepicker({minDate:'now'});
		$('#calDateStart').change(function(){$('#calDateEnd').val($(this).val());});
		
		if ($('#calTitle').val()=="") $('#calTitle').val('Payment run');
		if ($('#calTitleLocal').val()=="") $('#calTitleLocal').val('Платежный день');
		
	});
</script>
<?php
$strHead = ob_get_clean();
require ('includes/inc-frame_top.php');
if($rwMain['calDateStart']){
$arrLinkFooter[] = Array('title'=>'Google Calendar'
,'href'=>'http://www.google.com/calendar/event?action=TEMPLATE&text='.urlencode($rwMain["calTitle$strLocal"])
	.'&dates='.date('Ymd',strtotime($rwMain['calDateStart'])).'T090000Z/'.date('Ymd',strtotime($rwMain['calDateEnd']))
	.'T093000Z&details='.urlencode($rwMain['calComment'])
	.'&location=Office&trp=false&sprop='.urlencode($_SERVER['HTTP_HOST']).'&sprop=name:Treasury'
,'target'=>'_blank');
}
require ('includes/inc_ref_render.php');
require ('includes/inc-frame_bottom.php');
?>