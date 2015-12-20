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
            	<div class="col-md-12"><h1>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h1></div>
            </div>
            <div class="row ad_detail_publish_info">
                <div class="col-md-12"><a href="">London</a> | <span class="text-muted">Added on 2015.01.01y. 22:00h.</span></div>
            </div>
            <div class="row ad_detail_ad_info">
                <div class="col-md-12"><span class="text-muted">Ad Id: 123 | Views: 500</span></div>
            </div>
            
            <div class="row">
                <div class="col-md-8">
                	
                    <div class="row">
                    	<div class="col-md-12">
                			<img src="{{ asset('data/ad.jpg') }}" class="img-responsive thumbnail">
                        </div>
                    </div>
                    
                    <div class="row">
                    	<div class="col-md-3">
                			<a href=""><img src="data/ad.jpg" class="img-responsive thumbnail"></a>
                        </div>
                        <div class="col-md-3">
                			<a href=""><img src="data/ad.jpg" class="img-responsive thumbnail"></a>
                        </div>
                        <div class="col-md-3">
                			<a href=""><img src="data/ad.jpg" class="img-responsive thumbnail"></a>
                        </div>
                        <div class="col-md-3">
                			<a href=""><img src="data/ad.jpg" class="img-responsive thumbnail"></a>
                        </div>
                    </div>
                    
                    <div class="row ad_detail_detail_info">
                    	<div class="col-md-6"><span class="text-muted">Condition:</span> <span class="text-primary"><strong>used</strong></span></div>
                        <div class="col-md-6"><span class="text-muted">Delivery:</span> <strong><span class="text-primary">buyer</strong></span></div>
                    </div>
                    
                    <div class="row ad_detail_ad_text">
                    	<div class="col-md-12">
                			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean sit amet porttitor turpis, vitae posuere ligula. Nam eu commodo dui. Mauris vestibulum aliquet gravida. Ut sit amet sapien pulvinar, suscipit est at, accumsan nisi. Proin eleifend, urna in ornare pretium, ex nulla condimentum lectus, vitae venenatis eros lorem et velit. Duis vel nibh leo. Nunc in malesuada elit. Proin imperdiet velit tellus, at feugiat purus pulvinar quis. Nulla lobortis faucibus turpis. Ut egestas convallis ante, vel ultricies orci cursus non. Sed accumsan hendrerit diam at volutpat. Aliquam euismod justo vel hendrerit gravida. Nulla facilisi. Aenean quis sollicitudin diam. Vivamus at sodales nisl. In porta diam vitae mi tincidunt, rutrum scelerisque neque ultricies. 
                        </div>
                    </div>
                    
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
                	<div class="ad_detail_price text-center"><h2>100&euro;</h2></div>
                    
                    <div class="ad_detail_panel">
                    	<h4>Ad from <a href="">John Doe</a></h4>
                    </div>
                    
                    <div class="ad_detail_panel">
                        <a href="">Print this ad</a><br />
                        <a href="">Edit this ad</a><br />
                        <a href="" class="text-danger">Report this ad</a><br />
                    </div>
                    
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
