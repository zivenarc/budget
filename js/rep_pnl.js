if (window.google){
	google.load("visualization", "1", {packages:["corechart"]});
}

var months = Array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');

function drawChart(arrData, target, options){
	var data = google.visualization.arrayToDataTable(arrData);
	
	var options = options || {
		title: arrData[0][1],
		hAxis: {title: 'Month', textStyle: {fontSize:10}},
		series: {0:{targetAxisIndex:0},
				1: {targetAxisIndex:1, type: "line",annotations: {pointShape:'square'}}},
		height: 400,
		legend: { position: "none" }
	};
	
	var chart = new google.visualization.ColumnChart(target);
	chart.draw(data, options);
}

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
					console.log(ui);
					localStorage.repPnlTab = $(this).tabs('option','active');
				},	
			};

function spinner_div(){
	var res = $('<div>',{'class':'spinner',html:'Loading...'});
	return (res);
}

var header = document.title;

$(document).ready(function(){
	$('#tabs').tabs(tabs_options);
	$('#budget_scenario').change(function(){		
		location.search = 'budget_scenario='+$(this).val();
	});
	$('#reference').change(function(){		
		location.search = 'reference='+$(this).val();
	});	
	$('#bu_group').change(function(){		
		location.search = 'bu_group='+$(this).val();
	});	
});

function init_panel(o){
		
		var pccGUID = $('#pccGUID',o).val();
		
		var request_uri = $('#request_uri',o).val();
		$('.budget',o).each(function(){
			var report_id = $(this).attr('id');//+'_'+pccGUID;
			//$(this).attr('id',report_id);
		});
		
		
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
		
		if ($('#period_switch',o).length){
			$('.budget-monthly',o).hide();
		};
		
	if (typeof(report_id)!='undefined'){
		$('#'+report_id).find('td').each(function(){		
					$(this).click(function(){					
						$('#'+report_id).find('tr').removeClass('report-selected');
						$('#'+report_id).find('td').removeClass('report-selected');
						var tr = $(this).parent('tr');
						
						tr.addClass('report-selected');
						$(this).addClass('report-selected'); 
						
						if (tr.hasClass('graph')){		
							var activity = $('td:first',tr).text();
							var ggData = [['Month',activity, 'Productivity']];
							var mV;
							
							
							
							var request = {'pccGUID':localStorage.pccGUID,'activity':activity,'budget_scenario':$('#budget_scenario').val()};													
							$.post('rep_headcount.php',request, function(data){
								console.log(data);
								for (i=0;i<12;i++){
									mV = parseInt($('td.budget-'+months[i],tr).text().replace(',',''));
									headcount = data[months[i]];
									ggData.push([months[i],mV, headcount!=0?mV/headcount:null]);
								}
								drawChart(ggData, $('#graph',o).get(0));							
							});
							console.log (ggData);
							
							
						}
						
					});
				});
			};
			
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
	data.budget_scenario = $('#budget_scenario').val();
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
	// console.log(data);
				
}

function getCustomerKPI(data){
	
	data.pccGUID = localStorage.pccGUID;	
	data.budget_scenario = $('#budget_scenario').val();
	
	$('#sources').detach();
	$('<div>',{id:'sources'}).load('rep_customer_kpi.php #output',data, function(){
		$(this).dialog({
			'title':'Customer KPI',
			'modal':true,
			'width':'auto'
		});
	});
	
	// $('<div>').dialog({
		// create:function(event, ui){
			// $(this).html('Lorem ipsum');
		// }
	// });
	// console.log(data);
}