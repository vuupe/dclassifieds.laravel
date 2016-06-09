@extends('layout.index_layout')

@section('content')
		<div class="container">
        	<div class="row">
            	<div class="col-md-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ url('l-' . $ad_detail->location_slug)}}">{{ $ad_detail->location_name }}</a></li>
                        <?if(isset($breadcrump['c']) && !empty($breadcrump['c'])){?>
                            <?foreach ($breadcrump['c'] as $k => $v){?>
                                <li><a href="{{ $v['category_url'] }}"><?=$v['category_title']?></a></li>
                            <?}//end of foreach?>
                        <?}//end of if?>
                        <li class="active">{{ $ad_detail->ad_title }}</li>
                    </ol>
                </div>
            </div>
        </div>
        
        <div class="container ad_detail_container">
        	<div class="row">
            	<div class="col-md-12"><h1>{{ $ad_detail->ad_title }}</h1></div>
            </div>
            <div class="row ad_detail_publish_info">
                <div class="col-md-12"><a href="{{ url('l-' . $ad_detail->location_slug)}}">{{ $ad_detail->location_name }}</a> | <span class="text-muted">Added on {{ $ad_detail->ad_publish_date }}.</span></div>
            </div>
            <div class="row ad_detail_ad_info">
                <div class="col-md-12"><span class="text-muted">Ad Id: {{ $ad_detail->ad_id }} | Views: {{ $ad_detail->ad_view }}</span></div>
            </div>
            
            <div class="row">
                <div class="col-md-8">
                	
                    <div class="row">
                    	<div class="col-md-12">
                    	    <?if(!empty($ad_detail->ad_pic)){?>
                			<a href="{{ asset('uf/adata/1000_' . $ad_detail->ad_pic) }}" class="fancybox" rel="group"><img src="{{ asset('uf/adata/740_' . $ad_detail->ad_pic) }}" class="img-responsive thumbnail"  /></a>
                			<?} else {?>
                			<img src="" class="img-responsive thumbnail">
                			<?}?>
                        </div>
                    </div>
                    
                    <?if(isset($ad_pic) && !$ad_pic->isEmpty()){?>
                    <div class="row">
                        <?foreach($ad_pic as $k => $v){?>
                    	<div class="col-md-3">
                			<a href="{{ asset('uf/adata/1000_' . $v->ad_pic) }}" class="fancybox" rel="group">
                			    <img src="{{ asset('uf/adata/1000_' . $v->ad_pic) }}" class="img-responsive thumbnail" class="fancybox" rel="group" />
                			</a>
                        </div>
                        <?}//end of foreach?>
                    </div>
                    <?}//end of ad pic if?>
                    
                    <hr>
                    
                    <div class="row ad_detail_detail_info">
                        <?if(!empty($ad_detail->condition_id)){?>
                    	<div class="col-md-6"><span class="text-muted">Condition:</span> <span class="text-primary"><strong>{{ $ad_detail->ad_condition_name}}</strong></span></div>
                    	<?}?>
                    	<div class="col-md-6"><span class="text-muted">Ad Type:</span> <span class="text-primary"><strong>{{ $ad_detail->ad_type_name}}</strong></span></div>
                    	
                    	<!-- estate info -->
                    	<?if(!empty($ad_detail->estate_type_id)){?>
                    	<div class="col-md-6"><span class="text-muted">Estate Type:</span> <span class="text-primary"><strong>{{ $ad_detail->estate_type_name}}</strong></span></div>
                    	<?}?>
                    	
                    	<?if(!empty($ad_detail->estate_sq_m)){?>
                    	<div class="col-md-6"><span class="text-muted">Estate sq. m.:</span> <span class="text-primary"><strong>{{ $ad_detail->estate_sq_m}}</strong></span></div>
                    	<?}?>
                    	
                    	<?if(!empty($ad_detail->estate_year)){?>
                    	<div class="col-md-6"><span class="text-muted">Estate year of construction:</span> <span class="text-primary"><strong>{{ $ad_detail->estate_year}}</strong></span></div>
                    	<?}?>
                    	
                    	<?if(!empty($ad_detail->estate_construction_type_id)){?>
                    	<div class="col-md-6"><span class="text-muted">Estate Construction Type:</span> <span class="text-primary"><strong>{{ $ad_detail->estate_construction_type_name}}</strong></span></div>
                    	<?}?>
                    	
                    	<?if(!empty($ad_detail->estate_floor)){?>
                    	<div class="col-md-6"><span class="text-muted">Estate floor:</span> <span class="text-primary"><strong>{{ $ad_detail->estate_floor}}</strong></span></div>
                    	<?}?>
                    	
                    	<?if(!empty($ad_detail->estate_num_floors_in_building)){?>
                    	<div class="col-md-6"><span class="text-muted">Num Floors in Building:</span> <span class="text-primary"><strong>{{ $ad_detail->estate_num_floors_in_building}}</strong></span></div>
                    	<?}?>
                    	
                    	<?if(!empty($ad_detail->estate_heating_type_id)){?>
                    	<div class="col-md-6"><span class="text-muted">Estate Heating:</span> <span class="text-primary"><strong>{{ $ad_detail->estate_heating_type_name}}</strong></span></div>
                    	<?}?>
                    	
                    	<?if(!empty($ad_detail->estate_furnishing_type_id)){?>
                    	<div class="col-md-6"><span class="text-muted">Estate Furnishing:</span> <span class="text-primary"><strong>{{ $ad_detail->estate_furnishing_type_name}}</strong></span></div>
                    	<?}?>
                    	
                    	<!-- cars info -->
                    	<?if(!empty($ad_detail->car_brand_id)){?>
                    	<div class="col-md-6"><span class="text-muted">Car Brand:</span> <span class="text-primary"><strong>{{ $ad_detail->car_brand_name}}</strong></span></div>
                    	<?}?>
                    	
                    	<?if(!empty($ad_detail->car_model_id)){?>
                    	<div class="col-md-6"><span class="text-muted">Car Model:</span> <span class="text-primary"><strong>{{ $ad_detail->car_model_name}}</strong></span></div>
                    	<?}?>
                    	
                    	<?if(!empty($ad_detail->car_modification_id)){?>
                    	<div class="col-md-6"><span class="text-muted">Modification:</span> <span class="text-primary"><strong>{{ $ad_detail->car_modification_name}}</strong></span></div>
                    	<?}?>
                    	
                    	<?if(!empty($ad_detail->car_engine_id)){?>
                    	<div class="col-md-6"><span class="text-muted">Car Engine:</span> <span class="text-primary"><strong>{{ $ad_detail->car_engine_name}}</strong></span></div>
                    	<?}?>
                    	
                    	<?if(!empty($ad_detail->car_transmission_id)){?>
                    	<div class="col-md-6"><span class="text-muted">Car Transmission:</span> <span class="text-primary"><strong>{{ $ad_detail->car_transmission_name}}</strong></span></div>
                    	<?}?>
                    	
                    	<?if(!empty($ad_detail->car_year)){?>
                    	<div class="col-md-6"><span class="text-muted">Car Year:</span> <span class="text-primary"><strong>{{ $ad_detail->car_year}}</strong></span></div>
                    	<?}?>
                    	
                    	<?if(!empty($ad_detail->car_kilometeres)){?>
                    	<div class="col-md-6"><span class="text-muted">Car Kilometers:</span> <span class="text-primary"><strong>{{ $ad_detail->car_kilometeres}}km.</strong></span></div>
                    	<?}?>
                    	
                    	<?if(!empty($ad_detail->car_condition_id)){?>
                    	<div class="col-md-6"><span class="text-muted">Car Condition:</span> <span class="text-primary"><strong>{{ $ad_detail->car_condition_name}}</strong></span></div>
                    	<?}?>
                    	
                    </div>
                    
                    <hr>
                    
                    <div class="row ad_detail_ad_text">
                    	<div class="col-md-12">
                			{!! $ad_detail->ad_description !!} 
                        </div>
                    </div>
                    
                    <hr>
                    
                    <?if(!empty($ad_detail->ad_video)){?>
                    <div class="row">
                        <div class="col-md-12">
                        	<div class="embed-responsive embed-responsive-16by9">
                    			{!! $ad_detail->ad_video_fixed !!} 
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    <?}?>
                    
                    <?if(!$other_ads->isEmpty()){?>
                    <div class="row">
                    	<div class="col-md-12">
                        	<h4>Other Classifieds from this user</h4>
                        </div>
                    </div>
                    
                    <?foreach($other_ads as $k => $v){
                        $link = url(str_slug($v->ad_title) . '-' . 'ad' . $v->ad_id . '.html');
                        ?>
                    <div class="row margin_bottom_15">
                    	<div class="col-md-2">
                        	<a href="<?=$link?>"><img src="<?=asset('uf/adata/' . '740_' . $v->ad_pic);?>" class="img-responsive"></a>
                        </div>
                        <div class="col-md-6">
                        	<a href="<?=$link?>">{{ str_limit($v->ad_description, 200) }}</a>
                        </div>
                        <div class="col-md-4">
                        	<?=$v->ad_price ? $v->ad_price . '&euro;' : '&nbsp;'?>
                        </div>
                    </div>
                    <hr />
                    <?}//end of foreach?>
                    <?}//end of if?>
                    
                    <?if(session()->has('last_view') && !empty(session('last_view'))){?>
                    <div class="row">
                    	<div class="col-md-12">
                        	<h4>Last Viewed</h4>
                        </div>
                    </div>
                    
                    <div class="row">
                        <?
                        $last_view_array = array_reverse(session('last_view'));
                        foreach($last_view_array as $k => $v){
                            $link = url(str_slug($v['ad_title']) . '-' . 'ad' . $v['ad_id'] . '.html');
                            ?>
                    	<!-- ad -->
                        <div class="col-md-3">
                            <div class="thumbnail">
                                <a href="<?=$link?>"><img src="<?=asset('uf/adata/' . '740_' . $v['ad_pic']);?>" alt=""></a>
                            	<div class="caption">
                                    <h4><a href="<?=$link?>"><?=str_limit($v['ad_title'], 23)?></a></h4>
                                    <p><?=$v['location_name']?></p>
                                    <h3><?=$v['ad_price'] ? $v['ad_price'] . '&euro;' : '&nbsp;'?></h2>
                            	</div>
                            </div>
                        </div>
                        <!-- end of ad-->
                        <?}//end of foreach?>
                    </div>
                    <?}//end of if session?>
                    
                    
                </div>
                <div class="col-md-4">
                	<div class="ad_detail_price text-center">
                	    <h2>
                	        <?if($ad_detail->ad_free){
                	            echo 'free';
                	        } else {
                                echo number_format($ad_detail->ad_price, 2, '.', '') . '&euro;';
                            }?>
                	    </h2>
                	</div>
                	<hr>
                	
                	<div class="ad_detail_panel">
                    	<h4>Ad from <a href="{{ url('ad/user/' . $ad_detail->user_id) }}">{{ $ad_detail->name}}</a></h4>
                    	<small><span class="text-muted">(Registered: {{ $ad_detail->created_at }})</span></small>
                    </div>
                    <hr>
                    
                    <div class="ad_detail_panel">
                        
                        <a href="{{ route('ad_contact', ['ad_id' => $ad_detail->ad_id]) }}" class="btn btn-primary btn-block btn-lg"><span class="fa fa-envelope-o" aria-hidden="true"></span> Send Message</a>
                        
                        <?if(!empty($ad_detail->ad_phone)){?>
                        <a href="callto:{{ $ad_detail->ad_phone }}" class="btn btn-primary btn-block btn-lg"><span class="fa fa-phone" aria-hidden="true"></span> {{ $ad_detail->ad_phone }}</a>
                        <?}?>
                        
                        <?if(!empty($ad_detail->ad_skype)){?>
                        <a href="callto:{{ $ad_detail->ad_skype }}" class="btn btn-primary btn-block btn-lg"><span class="fa fa-skype"></span> {{ $ad_detail->ad_skype }}</a>
                        <?}?>
                    
                    </div>
                    <hr>
                    
                    <div class="ad_detail_panel">
                        <?if($ad_fav){?>
                        <a href="#" id="add_to_fav" class="btn btn-default btn-block btn-sm" data-loading-text="Saving..." data-addfav-text='<span class="fa fa-star"></span> Add to favorites' data-removefav-text='<span class="fa fa-star"></span> Remove from favorites'>
                            <span class="fa fa-star"></span> Remove from favorites
                        </a>
                        <?} else {?>
                        <a href="#" id="add_to_fav" class="btn btn-default btn-block btn-sm" data-loading-text="Saving..." data-addfav-text='<span class="fa fa-star"></span> Add to favorites' data-removefav-text='<span class="fa fa-star"></span> Remove from favorites'>
                            <span class="fa fa-star"></span> Add to favorites
                        </a>
                        <?}?>
                        
                        <a href="#" onclick="window.print(); return false;" class="btn btn-default btn-block btn-sm"><span class="fa fa-print"></span> Print this ad</a>
                        <?if(Auth::check() && Auth::user()->user_id == $ad_detail->user_id){?>
                            <a href="{{ url('ad/edit/' . $ad_detail->ad_id) }}" class="btn btn-default btn-block btn-sm"><span class="fa fa-pencil-square-o"></span> Edit this ad</a>
                        <?}?>
                        <button class="btn btn-danger btn-block btn-sm" data-toggle="modal" data-target="#report_modal"><span class="fa fa-exclamation-triangle"></span> Report this ad</button>
                        
                    </div>
                    <hr>
                	
                	<?if(!empty($ad_detail->ad_lat_lng)){?>
                    <div class="row">
                        <div class="col-md-12">
                        	<div id="gmap_detail" style="width: 100%; height:300px;"></div>
        		        </div>
                    </div>
                    
                    <hr>
                    <?}?>
                    
                    <div class="ad_detail_panel">
                        <img src="{{ asset('images/banner300x250.gif') }}" class="img-responsive center-block">
                    </div>
                
                
                </div>
            </div>
        </div>
        
        <div class="container home_info_link_panel">
        	<div class="row">
            	<div class="col-md-12">
                    <ol class="breadcrumb">
                          <li class="active">Main Cateegories</li>
                          <li><a href="#">Real Eastates</a></li>
                          <li><a href="#">Cars and Parts</a></li>
                          <li><a href="#">Electronics</a></li>
                          <li><a href="#">Sport, Books, Hobby</a></li>
                          <li><a href="#">Home and Garden</a></li>
                          <li><a href="#">Fashion</a></li>
                          <li><a href="#">Baby and Kids</a></li>
                          <li><a href="#">Тourism</a></li>
                          <li><a href="#">Business, Services</a></li>
                          <li><a href="#">Job</a></li>
                    </ol>
                </div>
            </div>
        </div>
        
        
        <div class="modal fade" id="report_modal" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Report this ad</h4>
                    </div>
                    <div class="modal-body">
                        <form method="POST" id="report_form" name="report_form">
                            {!! csrf_field() !!}
                            <input type="hidden" name="report_ad_id" id="report_ad_id" value="{{ $ad_detail->ad_id }}">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="report_radio" id="report_radio_1" value="1">
                                    Spam
                                </label>
                            </div>
                            
                            <div class="radio">
                                <label>
                                    <input type="radio" name="report_radio" id="report_radio_2" value="2">
                                    Scam
                                </label>
                            </div>
                            
                            <div class="radio">
                                <label>
                                    <input type="radio" name="report_radio" id="report_radio_3" value="3">
                                    Wrong category
                                </label>
                            </div>
                            
                            <div class="radio">
                                <label>
                                    <input type="radio" name="report_radio" id="report_radio_4" value="4">
                                    Prohibited goods or services
                                </label>
                            </div>
                            
                            <div class="radio">
                                <label>
                                    <input type="radio" name="report_radio" id="report_radio_5" value="5">
                                    Ad outdated
                                </label>
                            </div>
                            
                            <div class="form-group">
                                <label for="exampleInputEmail1">More information</label>
                                <textarea name="report_more_info" id="report_more_info" class="form-control" rows="3"></textarea>
                            </div>
                        </form>
                        
                        <div class="alert alert-info" role="alert" id="report_result_info" style="display:none;"></div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="btn_send_report" data-loading-text="Sending Report...">Send Report</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        
        
        
@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset('js/fancybox/jquery.fancybox.css')}}" />
@endsection

@section('js')
    <script src="{{asset('js/fancybox/jquery.fancybox.pack.js')}}"></script>
    <script src="http://maps.googleapis.com/maps/api/js?sensor=true&language=en"></script>
	<script type="text/javascript">
		var latlng = new google.maps.LatLng(<?=trim($ad_detail->ad_lat_lng, '()')?>);
		var myOptions = {
		  zoom: 16,
		  center: latlng,
		  mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		map = new google.maps.Map(document.getElementById("gmap_detail"), myOptions);
		marker = new google.maps.Marker({
		  map: map,
		  draggable:true,
		  position: latlng
		});
	</script>
	<script type="text/javascript">
    	$(document).ready(function() {
    		$(".fancybox").fancybox();

    		$('#btn_send_report').click(function(){
    			var token = $('input[name=_token]').val();
    			var btn = $(this).button('loading');
    			var checked = $("input[name='report_radio']:checked").val();
    			$('#report_result_info').hide();
    			if(checked){
        			$.ajax({
        				url: '{{ url('axreportad') }}',
        				headers: {'X-CSRF-TOKEN': token},
        				type: 'POST',
        				data: {'form_data': $('#report_form').serialize()},
        				dataType: "json",
        	     		success: function( data ) {
        	     			$("input[name='report_radio']:checked").prop('checked',false);
        	     			$('#report_more_info').val('');
        	     			btn.button('reset');
        	     			$('#report_result_info').html(data.message);
                		    $('#report_result_info').show();
        				}
        			});
        		} else {
        			btn.button('reset');
        		    $('#report_result_info').html('Please select reason for your report.');
        		    $('#report_result_info').show();
        		}
        		return false;
        	});

    		$('#add_to_fav').click(function(){
    			var token = $('input[name=_token]').val();
    			var btn = $(this).button('loading');
    		    $.ajax({
    				url: '{{ url('axsavetofav') }}',
    				headers: {'X-CSRF-TOKEN': token},
    				type: 'POST',
    				data: {'ad_id': $('#report_ad_id').val()},
    				dataType: "json",
    	     		success: function( data ) {
    	     			if(data.code == 200){
    	     				btn.button('removefav');
    	     			}
    	     			if(data.code == 201){
    	     				btn.button('addfav');
    	     			}
    				}
    			});
        		return false;
        	});
    	});
    </script>
@endsection
