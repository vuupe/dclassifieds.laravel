@extends('layout.index_layout')

@section('content')
		<div class="container category_panel">
            <!-- 
            <div class="row">
            	<div class="col-md-3 padding_top_bottom_15"><a href=""><img src="images/icons/house158.png" /> Real Estates</a></div>
                <div class="col-md-3 padding_top_bottom_15"><a href=""><img src="images/icons/car189.png" /> Cars and Parts</a></div>
                <div class="col-md-3 padding_top_bottom_15"><a href=""><img src="images/icons/personal5.png" /> Electronics</a></div>
                <div class="col-md-3 padding_top_bottom_15"><a href=""><img src="images/icons/man459.png" /> Sport, Books, Hobby</a></div>
            </div>
            <div class="row">
            	<div class="col-md-3 padding_top_bottom_15"><a href=""><img src="images/icons/sofa9.png" /> Home and Garden</a></div>
                <div class="col-md-3 padding_top_bottom_15"><a href=""><img src="images/icons/tshirt18.png" /> Fashion</a></div>
            	<div class="col-md-3 padding_top_bottom_15"><a href=""><img src="images/icons/babies35.png" /> Baby and Kids</a></div>
                <div class="col-md-3 padding_top_bottom_15"><a href=""><img src="images/icons/flying.png" /> Тourism</a></div>
            </div>
            <div class="row">
                <div class="col-md-3 padding_top_bottom_15"><a href=""><img src="images/icons/two205.png" /> Business, Services</a></div>
                <div class="col-md-3 padding_top_bottom_15"><a href=""><img src="images/icons/man337.png" /> Job</a></div>
                <div class="col-md-3 padding_top_bottom_15"></div>
                <div class="col-md-3 padding_top_bottom_15"></div>
            </div>
            --> 
            
            <?
            $i = 1;
            $closed = 0;
            foreach ($clist as $k => $v){?>
            	<?if($i == 1){?>
            		<div class="row">
            	<?}?>
            	<div class="col-md-3 padding_top_bottom_15"><a href="{{ Util::buildUrl('search', ['cid' => $v->category_id]) }}"><img src="{{ asset('images/icons/' . $v->category_img) }}" /> <?=$v->category_title?></a></div>
            	<?
				$i++;
				if($i > 4){
					$closed = 1;
					$i = 1;
					?></div><?
				}
			}//end foreach
			
			if(!$closed){?>
				</div>
			<?}?>
            
        </div>
        
        <div class="container home_promo_ads_panel">
        	<div class="row margin_bottom_15">
            	<div class="col-md-12">
                    <h2>Promo Classifieds</h2>
                    <a href="">promote your ad</a> | <a href="">view all promo ads</a>
                </div>
            </div>
            
            <!-- ad row-->
            <div class="row margin_bottom_15">
            
                <!-- ad -->
                <div class="col-md-3">
                    <div class="thumbnail">
                    	<a href="#"><img src="data/ad.jpg" alt=""></a>
                    	<div class="caption">
                            <h4><a href="#">Lorem ipsum dolor sit amet ...</a></h4>
                            <p>Lorem ipsum dolor sit amet</p>
                            <h3>25000€</h2>
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
                            <h3>25000€</h2>
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
                            <h3>25000€</h2>
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
                            <h3>25000€</h2>
                    	</div>
                    </div>
                </div>
                <!-- end of ad-->
            </div>
            <!--end of ad row -->
            
            <!-- ad row-->
            <div class="row margin_bottom_15">
            
                <!-- ad -->
                <div class="col-md-3">
                    <div class="thumbnail">
                    	<a href="#"><img src="data/ad.jpg" alt=""></a>
                    	<div class="caption">
                            <h4><a href="#">Lorem ipsum dolor sit amet ...</a></h4>
                            <p>Lorem ipsum dolor sit amet</p>
                            <h3>25000€</h2>
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
                            <h3>25000€</h2>
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
                            <h3>25000€</h2>
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
                            <h3>25000€</h2>
                    	</div>
                    </div>
                </div>
                <!-- end of ad-->
            </div>
            <!--end of ad row -->
            
            <!-- ad row-->
            <div class="row margin_bottom_15">
            
                <!-- ad -->
                <div class="col-md-3">
                    <div class="thumbnail">
                    	<a href="#"><img src="data/ad.jpg" alt=""></a>
                    	<div class="caption">
                            <h4><a href="#">Lorem ipsum dolor sit amet ...</a></h4>
                            <p>Lorem ipsum dolor sit amet</p>
                            <h3>25000€</h2>
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
                            <h3>25000€</h2>
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
                            <h3>25000€</h2>
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
                            <h3>25000€</h2>
                    	</div>
                    </div>
                </div>
                <!-- end of ad-->
            </div>
            <!--end of ad row -->
            
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
                          <li><a href="#">Real Estates</a></li>
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
