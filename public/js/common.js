$(document).ready(function(){
	/**
	 * commmon
	 */
	$(".cid_select").chosen({'placeholder_text_single' : 'All Categories', 'no_results_text' : 'No results', 'width' : '100%', 'allow_single_deselect': true});
	$(".lid_select").chosen({'placeholder_text_single' : 'All Locations', 'no_results_text' : 'No results', 'width' : '100%', 'allow_single_deselect': true});
	
	/**
	 * ad publish
	 */
	$('#category_id').change(function(){
		var data_type = $(this).find('option:selected').data('type');
		$('.common_fields_container').hide();
		switch (data_type){
			case 1:
				$('#type_1').show();
				break;
			case 2:
				$('#type_2').show();
				break;
			case 3:
				$('#type_3').show();
				break
		}
	});
});