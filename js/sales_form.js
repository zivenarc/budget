$(document).ready(function(){
	$('#salPOL').on( "autocompleteselect", function( event, ui ){
		updateRoute();
	});
	$('#salPOD').on( "autocompleteselect", function( event, ui ){
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