var tabs_options = {beforeLoad: function( event, ui ) {
				$(ui.panel).html(spinner_div());
				ui.jqXHR.error(function() {
					  $(ui.panel).html(
						"<div class='error'>Error loading the data</div>" );
					});
				 },
				spinner:'',
				load: function (event, ui) {
					
				},	
			};

function spinner_div(){
	var res = $('<div>',{'class':'spinner',html:'Loading...'});
	return (res);
}

$(document).ready(function(){
	$('#tabs').tabs(tabs_options);
});

function repost(tab, event){
		var total;
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
							total+=data.amount;							
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
		$('#journal_total',$('#div_'+tab)).text(number_format(total,0,'.',','));
}