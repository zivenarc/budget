function autocomplete_callback(field_id){
	
	if(field_id=='salPOL' || field_id=='salPOD'){
		var pol = $('#salPOL').val();
		var pod = $('#salPOD').val();
		
		if(pol && pod){
			
			$.post(location.href,{DataAction:'route',pol:pol,pod:pod},function(data){
				console.log(data);
				if (data.route!="0"){
					$('#salRoute').val(data.route).attr('readonly',true);
				} else {
					initRouteDialog(data);
				}
			});
		} else {
			return(false);
		}
	}
}

function initRouteDialog(data){
	var prompt="Route has not been defined between <strong>"+data.polTitle+"</strong> and <strong>"+data.podTitle+"</strong>";	
	$('#route_select_prompt').html(prompt);
	$('#route_select_select').html($('#salRoute').html());
	$('#route_select').dialog({
						title:"Select route",
						modal:true,
						width:'auto',
						buttons: {
							Ok:function(){
								var $dialog = $(this);
								var route = $('#route_select_select').val();
								console.log(route);
								$.post(location.href,{DataAction:'route_update',pol_country:data.pol_country,pod_country:data.pod_country,route:route},function(response){
									if(response.status=='success'){
										$('#salRoute').val(route);
										$dialog.dialog("close");
									} else {
										$(this).append('<p>'+response.description+'</p>');
										return(false);
									}
								});
								
							}
						}
					});
}