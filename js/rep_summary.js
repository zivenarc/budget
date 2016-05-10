if (window.google){
	google.load("visualization", "1", {packages:["corechart"]});
	//google.setOnLoadCallback(draw);
};
		
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
					// init_panel(ui.panel); 
					console.log(ui);
					localStorage.repPnlTab = $(this).tabs('option','active');
					draw();
				},	
			};

function spinner_div(){
	var res = $('<div>',{'class':'spinner',html:'Loading...'});
	return (res);
}

var header = document.title;

$(document).ready(function(){
	$('#tabs').tabs(tabs_options);
});