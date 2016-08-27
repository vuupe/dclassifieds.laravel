$(document).ready(function(){
	$('.need_confirm').click(function(){
		if(!confirm('Are you sure, you want to do that?')){
			return false;
		} 
	});
	
	$(".chosen_select").chosen({'no_results_text' : 'No results', 'width' : '100%', 'allow_single_deselect': true, 'search_contains':true});
});