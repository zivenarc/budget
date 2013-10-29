var months = Array('jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov','dec');

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

function rowTotalsInitialize(){
	var styles = new Array();
	if (doc!=undefined){
		for (m=0;m<months.length;m++){
			styles.push('.'+doc.gridName+'_'+months[m]);	
		};
		$(styles.join()).each(function(){
			$(this).change(function(){
				recalcYTD($(this));
			})
		});
		$('form').submit(function(){
			event.preventDefault();
		});
	}
}

function recalcYTD($o){
	var $row = $o.parent('tr');
	if(doc!=undefined){
		var $ytd = $row.find('td.'+doc.gridName+'_YTD div');
		
		var res = 0;
		for (m=0;m<months.length;m++){
			res += parseFloat($row.find('td.'+doc.gridName+'_'+months[m]+' input').val());
		}
		$ytd.text(res);
	}
}

function save(arg){
	arg=arg||'update';
	$('#DataAction').val(arg);
	var data = $( "input, textarea, select" ).serialize();
	//console.log(data);
	$('#loader').show();
	$.post(location.pathname,data, function(responseText){
		console.log(responseText);
		
		if (responseText.status=='success'){
			
			$("input[name='inp_"+doc.gridName+"_updated[]']").val();
			$("input[name='inp_"+doc.gridName+"_deleted']").val();
			
			$('#timestamp').text(responseText.timestamp);
			$menu = $('ul.menu-h');
			$menu.children('li').detach();
		
			if(doc.flagPosted!=responseText.flagPosted || doc.ID!=responseText.ID){
				location.href = location.pathname+'?'+responseText.prefix+'ID='+responseText.ID;
			}
			
			for(i=0;i<responseText.arrActions.length;i++){
				console.log(responseText.arrActions[i]);
				var $li = $('<li>').append($('<a>',{'class':responseText.arrActions[i].class,'href':responseText.arrActions[i].action,'text':responseText.arrActions[i].title}))
				$menu.append($li);
			}
		}
		$('#loader').hide();
	});
}