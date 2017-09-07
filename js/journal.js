var tabs_options = {beforeLoad: function( event, ui ) {
				$(ui.panel).html(spinner_div());
				ui.jqXHR.error(function() {
					  $(ui.panel).html(
						"<div class='error'>Error loading the data</div>" );
					});
				 },
				spinner:'',
				load: function (event, ui) {
						$('button',ui.panel).button();
						$('input.journal-cb-all', ui.panel).change(function(){
							var thisCB = $(this); 
							var table = $(this).parents('table');
							var arrCB = table.find('tr input:checkbox');
							arrCB.each(function(){
								$(this).attr('checked',thisCB.prop('checked'));
							})
						});
				},	
			};

function spinner_div(){
	var res = $('<div>',{'class':'spinner',html:'Connecting...'});
	return (res);
}

$(document).ready(function(){
	$('#tabs').tabs(tabs_options);	
});

function repost(tab, event){
		
		var t0 = performance.now();

		var total = 0;
		$(event.srcElement).addClass('spinner');
		
		$('#sources',$('#div_'+tab)).find('tr').each(function(){
			$(this).find('td.journal-current').eq(0).after('<td class="budget-decimal"></td>');
			$(this).find('th.journal-current').eq(0).after('<th class="budget-ytd">New result</th>');
		});
		
		//return;
		
		$('.budget-document-link',$('#div_'+tab)).each(function(){
			var href = $(this).attr('href');
			var tr = $(this).parents('tr');
			var cb = tr.find('input:checkbox');
			//console.log(cb);
			if(cb.prop('checked')){			
				// console.log(tr);
				var td_posted = tr.find('td.td-posted'); 
				// console.log(td_posted);
				var guid = tr.attr('id').replace('tr_','');
				td_posted.addClass('spinner');
				
				if (tr.hasClass('journal-deleted')){
					//skip
				} else if (tr.hasClass('journal-posted')){
					//--unpost, then post
					$.post(href,{DataAction:'unpost'},function(data){
						// console.log(data);
						if (data.flagPosted==0){
							tr.removeClass('journal-posted');
							td_posted.removeClass('budget-icon-posted');
							tr.find('#amount_'+guid).next().text('0.00');
							$.post(href,{DataAction:'post'},function(data){
								// console.log(data);
								if (data.flagPosted==1){
									tr.addClass('journal-posted');
									td_posted.addClass('budget-icon-posted').removeClass('spinner');
									tr.find('#amount_'+guid).next().html($('<span>',{text:number_format(data.amount,0,'.',','), class:(data.amount<0?'budget-negative':'')}));
									tr.find('#usrTitle_'+guid).text(data.editor);
									tr.find('#timestamp_'+guid).text(data.timestamp_short);
									total+=parseFloat(data.amount);console.log(data.amount);console.log(total);
									$('#journal_total',$('#div_'+tab)).next().text(number_format(total,0,'.',','));							
								} else {
									td_posted.removeClass('spinner').text('Error');
								}
							});
						} else {
							td_posted.removeClass('spinner').text('Error');
						}
					});
				} else {
					//post only
					$.post(href,{DataAction:'post'},function(data){
						// console.log(data);
						if (data.flagPosted==1){
							tr.addClass('journal-posted');
							td_posted.addClass('budget-icon-posted').removeClass('spinner');
							tr.find('#amount_'+guid).next().html($('<span>',{text:number_format(data.amount,0,'.',','), class:(data.amount<0?'budget-negative':'')}));
							tr.find('#usrTitle_'+guid).text(data.editor);
							tr.find('#timestamp_'+guid).text(data.timestamp_short);
							total+=parseFloat(data.amount);console.log(data.amount);console.log(total);
							$('#journal_total',$('#div_'+tab)).next().text(number_format(total,0,'.',','));							
						} else {
							td_posted.removeClass('spinner').text('Error');
						}
					});
				}
			} else {
				//skip the line
			}
		});
		
		$(event.srcElement).removeClass('spinner');
		// $('#journal_total',$('#div_'+tab)).text(number_format(total,0,'.',','));
		var t1 = performance.now();
		console.log("Reposting took " + (t1 - t0) + " milliseconds.")
}