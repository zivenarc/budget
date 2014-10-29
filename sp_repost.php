<?php
$flagNoAuth =true;
require ('common/auth.php');

if ($_GET['tab']){
	
	?>
<button onclick="repost('<?php echo $_GET['tab']; ?>', event);">Repost</button>

	<?php
	require ('classes/reports.class.php');
	$sql = "SELECT vw_journal.*, stbl_user.*, vw_profit.*, vw_location.*,  edit_date as timestamp FROM vw_journal 				
		LEFT JOIN stbl_user ON usrID=vw_journal.edit_by		
		LEFT JOIN vw_profit ON pccID=vw_journal.pc
		LEFT JOIN vw_location ON locID=vw_journal.pc
		WHERE vw_journal.posted=1 AND vw_journal.scenario='{$_GET['tab']}' 
		AND guid IN (SELECT DISTINCT source FROM reg_sales WHERE selling_curr<>'RUB' OR buying_curr<>'RUB' 
						UNION ALL 
					SELECT DISTINCT source FROM reg_costs WHERE buying_curr<>'RUB')
		GROUP BY vw_journal.guid
		ORDER BY vw_journal.edit_date ASC";	

		$rs =$oSQL->q($sql);
		while ($rw=$oSQL->f($rs)){
			$data[] = $rw;
		}
		
		echo "<div id='div_{$_GET['tab']}'>";
		Reports::getJournalEntries($data);
		echo '</div>';
		
	
} else {
	require ('classes/budget.class.php');
	$arrJS[] = 'js/journal.js';		
	include ('includes/inc-frame_top.php');
	echo '<h1>',$arrUsrData["pagTitle$strLocal"],'</h1>';
	echo Budget::getScenarioTabs(true);
	?>
<script>
	function repost(tab, event){
		$(event.srcElement).addClass('spinner');
		$('.budget-document-link',$('#div_'+tab)).each(function(){
			var href = $(this).attr('href');
			var tr = $(this).parents('tr');
			// console.log(tr);
			var td_posted = tr.find('td.td-posted'); 
			// console.log(td_posted);
			var guid = tr.attr('id').replace('tr_','');
			td_posted.addClass('spinner');
			$.post(href,{DataAction:'unpost'},function(data){
				console.log(data);
				if (data.flagPosted==0){
					td_posted.removeClass('budget-icon-posted');
					tr.find('#amount_'+guid).text('0.00');
					$.post(href,{DataAction:'post'},function(data){
						console.log(data);
						if (data.flagPosted==1){
							td_posted.addClass('budget-icon-posted');
							tr.find('#amount_'+guid).text(number_format(data.amount,0,'.',','));
							tr.find('#usrTitle_'+guid).text(data.editor);
							tr.find('#timestamp_'+guid).text(data.timestamp_short);
						} else {
							td_posted.removeClass('spinner').text('Error');
						}
					});
				} else {
					td_posted.removeClass('spinner').text('Error');
				}
			});
		});
		
		$(event.srcElement).removeClass('spinner');
	}
</script>
	<?php
	include ('includes/inc-frame_bottom.php');
}
?>