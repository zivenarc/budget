var tabs_options = {beforeLoad: function( event, ui ) {
			$(ui.panel).html(spinner_div());
			ui.jqXHR.error(function() {
				  $(ui.panel).html(
					"<div class='error'>Error loading the data</div>" );
				});
			 },
			spinner:'',
			create: function (event, ui){
				tablist = $(this).find('li').find('a');
				for(i=0;i<tablist.length;i++){
					if(location.hash && tablist[i].href.match('tab='+location.hash.substr(1))){
						$(this).tabs('option','active',i);
					}
				}
			},
			load: function (event, ui) {
				$('button',ui.panel).button();
				$('input:checkbox',ui.panel).button();
				var url = ui.tab.find('a').attr('href');
				$('.scnFlagReadOnly',ui.panel).change(function(){
					if($(this).prop('checked')){
						$.post(url,{DataAction:'readonly'}, function(data){
							updateTab(ui, data)
						});
					} else {
						$.post(url,{DataAction:'readwrite'}, function(data){
							updateTab(ui, data)
						});
					}
				});
				$('.scnFlagArchive',ui.panel).change(function(){					
					if($(this).prop('checked')){
						$.post(url,{DataAction:'archive'});
					} else {
						$.post(url,{DataAction:'unarchive'});
					}
				});
				$('.default', ui.panel).click(function(){
					$.post(url,{DataAction:'default'}, function (data){
						console.log(data);
					});
				});
			},
			activate: function(event, ui) {
				var query = ui.newTab[0].firstChild.href.split('?')[1];
				var vars = query.split('&');
					for (var i = 0; i < vars.length; i++) {
					var pair = vars[i].split('=');
					if (decodeURIComponent(pair[0]) == 'tab') {
						window.location.hash = decodeURIComponent(pair[1]);
					}
				}
			}				
		};
			
$(document).ready(function(){
		$('#tabs').tabs(tabs_options);
});

function  updateTab(ui, data) {
	// console.log(data);
	if(data.flagUpdate){
		ui.tab.find('a').removeClass('budget-readonly');
	} else {
		ui.tab.find('a').addClass('budget-readonly');
	}
}