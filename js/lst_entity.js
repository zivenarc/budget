//Common UI function for entity lists
$(window).load(function(){
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
					if (sessionStorage['tabNo_'+$(this).attr('id')]!=undefined) {
						$(this).tabs('option','active',sessionStorage['tabNo_'+$(this).attr('id')]);
					}
				},
				load: function(event, ui){
					sessionStorage['tabNo_'+$(this).attr('id')] = $(this).tabs('option','active');
					ui.panel.find('.eiseList').eiseList();
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