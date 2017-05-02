function autocomplete_callback(field_id){
	
	if(field_id=='input_salPOL' || field_id=='input_salPOD'){
		var pol = $('#salPOL').val();
		var pod = $('#salPOD').val();
		
		$.load(location.href,{DataAction:'route',pol:pol,pod:pod},function(data){
			$('#salRouteID').val(data.route);
		});
	}
}