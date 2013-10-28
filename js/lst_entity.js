//Common UI function for entity lists
$(document).ready(function(){
	$('#tabs').tabs({
				beforeLoad: function( event, ui ) {
					ui.panel.html("<div class='spinner'>Loading...</div>");
					console.log(ui);
					ui.jqXHR.error(function() {
					  $(ui.panel).html(
						"Error loading the tab" );
					});
				  },								
				spinner:''
				});
});