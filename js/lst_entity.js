//Common UI function for entity lists
$(document).ready(function(){
	$('.tabs').tabs({
				beforeLoad: function( event, ui ) {
					ui.panel.html("<div class='spinner'>Connecting...</div>");
					ui.jqXHR.error(function() {
					  $(ui.panel).html(
						"Error loading the tab" );
					});
				  },								
				spinner:'',
				create: function (){
					var tablist = $(this).find('li').find('a');
					var matchstring = 'tab='+location.hash.substr(1)+'$';
					console.log(matchstring);
						for(i=0;i<tablist.length;i++){
							if(location.hash && tablist[i].href.match(matchstring)){
								$(this).tabs('option','active',i);
							}
						}
				},
				load: function(event, ui){
					sessionStorage['tabNo_'+$(this).attr('id')] = $(this).tabs('option','active');
					ui.panel.find('.eiseList').eiseList();
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
				});


	var $lstcnt = $('.list-tabs-container'), 
		$tabs = $lstcnt.find('.tabs'),
		$tabsNav = $tabs.find('.ui-tabs-nav')
		$footer = $lstcnt.find('.link-footer'),
		$prev = $lstcnt.prev(),
		topPrev = $prev.offset().top,
		bottomPrev = topPrev + $prev.outerHeight(),
		hFoot = ($footer[0] ? $footer.outerHeight(true) : 0);

	$lstcnt.css('top', bottomPrev);

	$tabs.css('padding', hFoot);

	$footer.css('position', 'absolute')
		.css('bottom', $lstcnt.css('padding-bottom'));

	$tabs.find('.ui-tabs-panel').css('margin-top', '-'+$tabsNav.outerHeight(true)+'px')

});