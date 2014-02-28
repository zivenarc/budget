var tabs_options = {beforeLoad: function( event, ui ) {
				$(ui.panel).html(spinner_div());
				ui.jqXHR.error(function() {
					  $(ui.panel).html(
						"<div class='error'>Error loading the data</div>" );
					});
				 },				
				spinner:'',
				create: function (){
					if (localStorage.repPnlTab!=undefined) {
						$(this).tabs('option','active',localStorage.repPnlTab);
					}
				},
				load: function (event, ui) {
					init_panel(ui.panel); 
					localStorage.repPnlTab = $(this).tabs('option','active');
				},	
			};

function spinner_div(){
	var res = $('<div>',{'class':'spinner',html:'Loading...'});
	return (res);
}

$(document).ready(function(){
	$('#tabs').tabs(tabs_options);
	$('#budget_scenario').change(function(){		
		$(this).wrap($('<form>',{method:'GET',id:'scenario'}));		
		console.log($(this));
		$('#scenario').submit();
	});
	
});

function init_panel(o){
		
		var pccGUID = $('#pccGUID',o).val();
		var report_id = 'report_'+pccGUID;
		var request_uri = $('#request_uri',o).val();
		$('#report',o).attr('id',report_id);
		
		var group = $('#group',o).val();
		
		localStorage.group = group;
		localStorage.pccGUID = pccGUID;
		
		$('#period_switch',o).buttonset().children('input').change(function(){
			if($(this).val()=='monthly'){
				$('.budget-monthly',o).show();
				$('.budget-quarterly',o).hide();
			} else {
				$('.budget-monthly',o).hide();
				$('.budget-quarterly',o).show();
			}
		});
		
		$('#detail_switch',o).buttonset().children('input').change(function(){
			if($(this).val()=='all'){
				$('.budget-item',o).show();
			} else {
				$('.budget-item',o).hide();
			}
		});
		
		$('.budget-monthly',o).hide();
		
		$('#'+report_id).find('td').each(function(){		
					$(this).click(function(){					
						$('#'+report_id).find('tr').removeClass('report-selected');
						var tr = $(this).parent('tr');
						tr.addClass('report-selected');
					});
				});
				
		$('.budget-tdh',o).mouseenter(function(){
			if (localStorage.group!='customer' || $(this).hasClass('customer-other')) {
				return (false);
			}
			var data = {};
			data.customer = $(this).attr('data-code');
			var that = $(this);
			var del_button = $('<span>',{'id':'del_button','class':'ui-icon-trash ui-icon ui-button','html':'QQ'}).click(function(){
				
				$('<div id="confirmation_dialog"/>').html('Are you sure yo want to make this customer "Other"?').dialog({
					  resizable: false,
					  height:140,
					  modal: true,
					  title: 'Please confirm',
					  buttons: {
						"Ok": function() {
							data.pccGUID = localStorage.pccGUID;
							$.post('sp_customer_other.php',data,function(textResponse){					
								console.log(textResponse);					
								that.wrapInner('<del>').addClass('customer-other');
							});
							$( this ).dialog( "close" );
						},
						Cancel: function() {
						  $( this ).dialog( "close" );
						}
					  }
				});
				
			});
			if ($(this).html()){
				del_button.appendTo($(this).find('span'));
			}
		}).mouseleave(function(){
			$('#del_button').detach();
		});
}	

function getSource(data){
		
	data.pccGUID = localStorage.pccGUID;
	var key =  ($('#group').val());	
		
	if (data.level1!=undefined){
		data[localStorage.group] = data.level1;
	}
	
	$('#sources').detach();
	$('<div>',{id:'sources'}).load('rep_source.php #sources',data, function(){
		$(this).dialog({
			'title':'Source documents',
			'modal':true,
			'width':'auto'
		});
	});
	
	// $('<div>').dialog({
		// create:function(event, ui){
			// $(this).html('Lorem ipsum');
		// }
	// });
	console.log(data);
				
}