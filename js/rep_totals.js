$(document).ready(function(){

	var report_id='report';
	
		$('#budget_scenario').change(function(){		
		$(this).wrap($('<form>',{method:'GET',id:'scenario'}));		
		// console.log($(this));
		$('#frameContent').addClass('ui-widget-overlay');
		$('#scenario').submit();
	});
	
		$('#'+report_id).find('td').each(function(){		
					$(this).click(function(){					
						$('#'+report_id).find('tr').removeClass('report-selected');
						var tr = $(this).parent('tr');
						tr.addClass('report-selected');
					});
				});
				
});				