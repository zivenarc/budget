<?php
require ('common/auth.php');

   $arrActions[] = Array(
   "title" => ShowFieldTitle('print')
   , "class" => "print"
   , "action" => "javascript:window.print();"
   );
   $arrActions[] = Array(
   "title" => ShowFieldTitle('help')
   , "class" => "question"
   , "action" => "/wiki/Treasury"
   );

$arrJS[] = "/common/jquery/jquery.jscroll.min.js";   
$arrJS[]='/common/jquery/fullcalendar-1.4.1/fullcalendar.js';
$arrJS[]='js/about.js';
$arrCSS[] = '/common/jquery/fullcalendar-1.4.1/fullcalendar.css';
$arrCSS[] = 'common/calendar.css';
require ('includes/inc-frame_top.php');

$sql = "SELECT *, DATEDIFF(calDateStart,NOW()) as nDaysToPay 
		FROM tbl_calendar 
		WHERE DATEDIFF(calDateStart,NOW())>=0 
		ORDER BY calDateStart 
		LIMIT 0,1";
$rs = $oSQL->do_query($sql);
$boolPaymentRun = ($oSQL->num_rows($rs));
$rwPR = $oSQL->fetch_array($rs);
?>

<h1><?php echo ($strLocal?"Сегодня ":"Today "),iconv('cp1251','utf-8',strftime("%A %d %B %Y", time()))?></h1>
<h2><?php if ($boolPaymentRun){
				if ($rwPR['nDaysToPay']){
					echo "Next event - ",$rwPR['calTitle']," on ",date('d.m.Y',strtotime($rwPR['calDateStart']));
				} else {
					echo $rwPR['calTitle']," today!";
				}
			}?></h2>

<!--<div class='warning'><a id="WebLinkDescLink" target='_blank' href="http://www.surveymonkey.com/s/D8F73N3">Примите, пожалуйста, участие в опросе пользователей Treasury</a></div>-->

<table style='width:100%;'>
	<tr><td style='width:50%;'>
		<div id="new_accounts">
		</div>
		<div id="new_contracts">
		</div>
		<fieldset id="vacation"><legend><?php echo ($strLocal?"Календарь":"Calendar");?></legend>
		<div id='calendar'></div>
		</ol>
		</fieldset>
	</td>
	<td>
		<div id="bookmarks">
		</div>
		<!--<div id="tasks"></div>-->
		<div id="active_drafts">
		</div>
	</td></tr>
</table>
<?php
require ('includes/inc-frame_bottom.php');
?>