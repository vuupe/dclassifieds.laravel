@extends('layout.index_layout')

@section('content')
		<div class="container">
        	<div class="row">
            	<div class="col-md-12">
                    <ol class="breadcrumb">
                    	  <li><a href="#">Home</a></li>
                          <li><a href="#">Fashion</a></li>
                          <li><a href="#">Shoes</a></li>
                          <li><a href="#">London</a></li>
                          <li class="active">Buffalo Shoes</li>
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
                <div class="col-md-12"><span class="text-muted">Ad Id: {{ $ad_detail->ad_id }} | Views: 500</span></div>
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
                			{{ $ad_detail->ad_description }} 
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
                    
                    <div class="row">
                    	<div class="col-md-12">
                        	<h4>Send Message</h4>
                        </div>
                    </div>
                    
                    <div class="row margin_bottom_15">   
                        <div class="col-md-12">
                            <form>
                                <div class="form-group">
                                    <textarea class="form-control"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Send</button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="row">
                    	<div class="col-md-12">
                        	<h4>Other Classifieds from this user</h4>
                        </div>
                    </div>
                    
                    <div class="row margin_bottom_15">
                    	<div class="col-md-2">
                        	<a href=""><img src="data/ad.jpg" class="img-responsive"></a>
                        </div>
                        <div class="col-md-6">
                        	<a href="">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean sit amet porttitor turpis</a>
                        </div>
                        <div class="col-md-4">
                        	150&euro;
                        </div>
                    </div>
                    
                    <div class="row margin_bottom_15">
                    	<div class="col-md-2">
                        	<a href=""><img src="data/ad.jpg" class="img-responsive"></a>
                        </div>
                        <div class="col-md-6">
                        	<a href="">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean sit amet porttitor turpis</a>
                        </div>
                        <div class="col-md-4">
                        	150&euro;
                        </div>
                    </div>
                    
                    
                    <div class="row">
                    	<div class="col-md-12">
                        	<h4>Last Viewed</h4>
                        </div>
                    </div>
                    
                    <div class="row">
                    	<!-- ad -->
                        <div class="col-md-3">
                            <div class="thumbnail">
                                <a href="#"><img src="data/ad.jpg" alt=""></a>
                                <div class="caption">
                                    <h4><a href="#">Lorem ipsum dolor sit amet ...</a></h4>
                                    <p>Lorem ipsum dolor sit amet</p>
                                    <h3>25000&euro;</h2>
                                </div>
                            </div>
                        </div>
                        <!-- end of ad-->
                        <!-- ad -->
                        <div class="col-md-3">
                            <div class="thumbnail">
                                <a href="#"><img src="data/ad.jpg" alt=""></a>
                                <div class="caption">
                                    <h4><a href="#">Lorem ipsum dolor sit amet ...</a></h4>
                                    <p>Lorem ipsum dolor sit amet</p>
                                    <h3>25000&euro;</h2>
                                </div>
                            </div>
                        </div>
                        <!-- end of ad-->
                    </div>
                    
                    
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
                	
                	<?if(!empty($ad_detail->ad_lat_lng)){?>
                    <div class="row">
                        <div class="col-md-12">
                        	<div id="gmap_detail" style="width: 100%; height:300px;"></div>
        		        </div>
                    </div>
                    
                    <hr>
                    <?}?>
                    
                    <div class="ad_detail_panel">
                    	<h4>Ad from <a href="">John Doe</a> <small><span class="text-muted">(Registered: 2015-01-01)</span></small></h4>
                    </div>
                    <hr>
                    
                    <div class="ad_detail_panel">
                    
                        <button class="btn btn-default btn-block">Print this ad</button>
                        <button class="btn btn-default btn-block">Edit this ad</button>
                        <button class="btn btn-danger btn-block">Report this ad</button>
                        
                    </div>
                    <hr>
                    
                    <div class="ad_detail_panel">
                        <img src="images/banner300x250.gif" class="img-responsive center-block">
                    </div>
                
                
                </div>
            </div>
            
            
        </div>
        
        
        
        
        <div class="container home_info_panel">
        	<div class="row">
            	<div class="col-md-10">
                	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer commodo ac purus a cursus. Fusce elementum purus sit amet orci lobortis mattis. Sed sodales velit quis tortor tempor pulvinar. Morbi finibus sem neque, eu suscipit ante suscipit id. Suspendisse laoreet et dolor vel aliquet. Nam eu nisi nec nibh malesuada consectetur. Sed vestibulum consectetur tincidunt. Nulla posuere sapien nec sapien sodales, et posuere dui feugiat. Aenean a odio rutrum sapien faucibus finibus vel ut erat. Cras dignissim vitae ante at molestie. 
                </div>
                <div class="col-md-2">
                	<div class="fb-like" data-href="https://www.facebook.com/Bitak.net" data-layout="box_count" data-action="like" data-show-faces="true" data-share="false"></div>
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
    	});
    </script>
@endsection
