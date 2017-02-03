var tabs_options = {beforeLoad: function( event, ui ) {
			$(ui.panel).html(spinner_div());
			ui.jqXHR.error(function() {
				  $(ui.panel).html(
					"<div class='error'>Error loading the data</div>" );
				});
			 },
			spinner:'',
			load: function (event, ui) {			
				var url = ui.tab.find('a').attr('href');
				$('#scnFlagReadOnly',ui.panel).change(function(){
					if($(this).attr('checked')=='checked'){
						$.post(url,{DataAction:'readonly'});
					} else {
						$.post(url,{DataAction:'readwrite'});
					}
				});
				$('#scnFlagArchive',ui.panel).change(function(){					
					if($(this).attr('checked')=='checked'){
						$.post(url,{DataAction:'archive'});
					} else {
						$.post(url,{DataAction:'unarchive'});
					}
				});
				$('#default', ui.panel).click(function(){
					$.post(url,{DataAction:'default'}, function (data){
						console.log(data);
					});
				});
			},	
		};
			
$(document).ready(function(){
		$('#tabs').tabs(tabs_options);
});