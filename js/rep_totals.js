$(document).ready(function(){

	var report_id='report';
	
	$('#budget_scenario').change(function(){		
		location.search = 'budget_scenario='+$(this).val();
	});
	$('#reference').change(function(){		
		location.search = 'reference='+$(this).val();
	});	
	$('#bu_group').change(function(){		
		location.search = 'bu_group='+$(this).val();
	});	
	
		
		$('#'+report_id).find('td').each(function(){		
					$(this).click(function(){					
						$('#'+report_id).find('tr').removeClass('report-selected');
						$('#'+report_id).find('td').removeClass('report-selected');
						var tr = $(this).parent('tr');
						tr.addClass('report-selected');
						$(this).addClass('report-selected');
					});
				});
				
});				