@extends('layout.index_layout')

@section('content')		
		
		<div class="container">
        	<div class="row">
            	<div class="col-md-12">
                    <ol class="breadcrumb">
                    	  <li><a href="{{ route('home') }}">Home</a></li>
                          <!--<li class="active">Fashion</li>-->
                          <?if(isset($breadcrump['c']) && !empty($breadcrump['c'])){?>
                          	<?foreach ($breadcrump['c'] as $k => $v){?>
                          	<li><a href="{{ route('category_slug', ['category_slug' => $v['category_full_path']]) }}"><?=$v['category_title']?></a></li>
                          	<?}//end of foreach?>
                          <?}//end of if?>
                    </ol>
                </div>
            </div>
        </div>
        
        <?if(isset($clist) && !empty($clist)){?>
        <div class="container category_panel">
            <!-- <div class="row">
            	<div class="col-md-3 padding_top_bottom_15"><a href="">Clothes <span class="text-muted">204601</span></a></div>
                <div class="col-md-3 padding_top_bottom_15"><a href="">Shoes <span class="text-muted">74767</span></a></div>
                <div class="col-md-3 padding_top_bottom_15"><a href="">Accessories <span class="text-muted">40133</span></a></div>
                <div class="col-md-3 padding_top_bottom_15"><a href="">Perfumery and Cosmetics <span class="text-muted">10615</span></a></div>
            </div>
            <div class="row">
            	<div class="col-md-3 padding_top_bottom_15"><a href="">Bijouterie <span class="text-muted">21827</span></a></div>
                <div class="col-md-3 padding_top_bottom_15"><a href="">Watches <span class="text-muted">12335</span></a></div>
            	<div class="col-md-3 padding_top_bottom_15"></div>
                <div class="col-md-3 padding_top_bottom_15"></div>
            </div> -->
            
            <?
            $i = 1;
            $closed = 0;
            foreach ($clist as $k => $v){?>
            	<?if($i == 1){?>
            		<div class="row">
            	<?}?>
            	<div class="col-md-3 padding_top_bottom_15"><a href="{{ route('category_slug', ['category_slug' => $v->category_full_path]) }}"><?=$v->category_title?></a></div>
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
        <?}//end of if?>
        
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
                            <h3>25000 €</h2>
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
                            <h3>25000 €</h2>
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
                            <h3>25000 €</h2>
                    	</div>
                    </div>
                </div>
                <!-- end of ad-->
            </div>
            <!--end of ad row -->
        </div>
        
        <div class="container home_promo_ads_panel">
        	<div class="row margin_bottom_15">
            	<div class="col-md-12">
                    <h2>New Classifieds</h2>
                    <a href="">pusblish and ad</a>
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
                            <h3>25000 €</h2>
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
                            <h3>25000 €</h2>
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
                            <h3>25000 €</h2>
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
                            <h3>25000 €</h2>
                    	</div>
                    </div>
                </div>
                <!-- end of ad-->
            </div>
            <!--end of ad row -->
        </div>
        
        <div class="container">
        	<div class="row">
            	<div class="col-md-12">
                
                
                <nav>
                    <ul class="pagination">
                        <li>
                            <a href="#" aria-label="Previous">
                            	<span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li>
                            <a href="#" aria-label="Next">
                            	<span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                
                
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
