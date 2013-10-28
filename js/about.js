var jscroll_options = {nextSelector:'a.jscroll-next:last',
						loadingHtml:'<div class="spinner">Loading...</div>'};

$(document).ready(function() {
						
			
		$('#calendar').fullCalendar({
		
			editable: false,
			
			firstDay: 1,
			weekMode: 'variable',
			events: "json_vacation.php",
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay'
			},
			defaultView: 'basicWeek',
			loading: function(bool) {
				if (bool) $('#loading').show();
				else $('#loading').hide();
			}
			
		});
		
});

var delay = 30000;
function refresh(){
		//--put recurring tasks here
		setTimeout('refresh()',delay);
}

setTimeout('refresh()',delay);