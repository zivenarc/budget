function autocomplete_callback(field_id){
	
	if(field_id=='salPOL' || field_id=='salPOD'){
		var pol = $('#salPOL').val();
		var pod = $('#salPOD').val();
		
		if(pol && pod){
			
			$.post(location.href,{DataAction:'route',pol:pol,pod:pod},function(data){
				console.log(data);
				$('#salRoute').val(data.route);
			});
		} else {
			return(false);
		}
	}
}