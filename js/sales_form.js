$(document).ready(function(){
	$('#input_salPOL').on( "autocompleteselect", function( event, ui ){
		updateRoute();
	});
	$('#input_salPOD').on( "autocompleteselect", function( event, ui ){
		updateRoute();
	});
});

function updateRoute(){
	var pol = $('#salPOL').val();
	var pod = $('#salPOD').val();
	
	$.load(location.href,{DataAction:'route',pol:pol,pod:pod},function(data){
		$('#salRouteID').val(data.route);
	});
	
}