$(document).ready(function(){
	$('ul.ui-menu').menu({ position: { my: "right top", at: "right-15 top+20" },
							icons: { submenu: "ui-icon-circle-triangle-e" } })
					.find('ul').css('z-index',999);
	$('.accordion').accordion({
		create:function(event,ui){
			var opt = $.parseJSON(ui.header.attr('data-source'));
			ui.panel.load(opt.url);
		},
		collapsible:true,
		heightStyle:'content',
		beforeActivate:function(event,ui){
			ui.newPanel.html($('<div>',{'class':'spinner',text:strLocal?'Загрузка...':'Loading...'}));
		},
		activate:function(event,ui){
			var opt = $.parseJSON(ui.newHeader.attr('data-source'));
			ui.newPanel.load(opt.url);
		}
	});
});