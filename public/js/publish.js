$(document).ready(function(){
    $('body').on('click', '.category_selector', function(e){
        e.preventDefault();

        var category_id = $(this).data('id');
        var token = $('input[name=_token]').val();

        $.ajax({
            url: __AX_GET_CATEGORY,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            data: {'category_id': category_id},
            dataType: "json",
            beforeSend: function() {
                $('#quick_category_loader').show();
            },
            success: function( data ) {
                $('#quick_category_loader').hide();
                if(data.code == 200){
                    var html = '';
                    $.each(data.info, function( index, value ) {
                        html += '<a href="" class="category_selector btn-block" data-id="' + index + '">' + value + '</a>';
                    });
                    $('#quick-category-select-container').html(html);
                    var bhtml = '<li><a href="" class="category_selector btn-block" style="display:inline;" data-id="0">' + __START + '</a></li>';
                    $.each(data.binfo, function( index, value ) {
                        bhtml += '<li><a href="" class="category_selector btn-block" style="display:inline;" data-id="' + index + '">' + value + '</a></li>';
                    });
                    $('#quick-category-select-breadcrump').html(bhtml);
                } else {
                    $('#category_id').val(data.info);
                    $('#category_id').trigger("chosen:updated");
                    show_ad_fields($('#category_id'));
                    $('#quick-category-select-modal').modal('hide');
                }
            }
        });
    });

    $('body').on('click', '.location_selector', function(e){
        e.preventDefault();

        var location_id = $(this).data('id');
        var token = $('input[name=_token]').val();

        $.ajax({
            url: __AX_GET_LOCATION,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            data: {'location_id': location_id},
            dataType: "json",
            beforeSend: function() {
                $('#quick_location_loader').show();
            },
            success: function( data ) {
                $('#quick_location_loader').hide();
                if(data.code == 200){
                    var html = '';
                    $.each(data.info, function( index, value ) {
                        html += '<div class="col-md-4 location_modal_item"><a href="" class="location_selector btn-block" data-id="' + index + '">' + value + '</a></div>';
                    });
                    $('#quick-location-select-container').html(html);
                    var bhtml = '<li><a href="" class="location_selector btn-block" style="display:inline;" data-id="0">' + __START + '</a></li>';
                    $.each(data.binfo, function( index, value ) {
                        bhtml += '<li><a href="" class="location_selector btn-block" style="display:inline;" data-id="' + index + '">' + value + '</a></li>';
                    });
                    $('#quick-location-select-breadcrump').html(bhtml);
                    $('.location_modal_item').matchHeight();
                } else {
                    $('#location_id').val(data.info);
                    $('#location_id').trigger("chosen:updated");
                    $('#quick-location-select-modal').modal('hide');
                }
            }
        });
    });
});