@extends('layout.index_layout')

@section('search_filter')
        <div class="container search_panel">
            <form method="GET" action="{{url('proxy')}}" class="form">
                <div class="row">
                    <div class="col-md-3 padding_bottom_15">
                    	<input type="text" name="search_text" id="search_text" class="form-control" placeholder="1 000 000 Ads" value="{{isset($search_text) ? stripslashes($search_text) : ''}}"/>
                    </div>
                    <div class="col-md-3 padding_bottom_15">
                    	@if(isset($c) && !empty($c))
                   		<select name="cid" id="cid" class="form-control cid_select">
                   			<option value="0"></option>
                   			@foreach ($c as $k => $v)
                   				<optgroup label="{{$v['title']}}">
                   					@if(isset($v['c']) && !empty($v['c'])){
                   						@include('common.cselect', ['c' => $v['c']])
                   					@endif
                   				</optgroup>
                   			@endforeach
                   		</select>
                   		@endif
                    </div>
                    <div class="col-md-3 padding_bottom_15">
                    	@if(isset($l) && !empty($l))
                   		<select name="lid" id="lid" class="form-control lid_select">
                   			<option value="0"></option>
                   			@foreach ($l as $k => $v)
                   				<optgroup label="{{$v['title']}}">
                   					@if(isset($v['c']) && !empty($v['c'])){
                   						@include('common.lselect', ['c' => $v['c']])
                   					@endif
                   				</optgroup>
                   			@endforeach
                   		</select>
                   		@endif	
                    </div>
                    <div class="col-md-3 padding_bottom_15">
                        <button type="submit" class="btn btn-primary" style="width: 100%;">
                            <span class="glyphicon glyphicon glyphicon-search" aria-hidden="true"></span> Search
                        </button>
                    </div>
                </div>
            </form>
        </div>
@endsection


@section('content')		
		
		<div class="container">
        	<div class="row">
            	<div class="col-md-12">
                    <ol class="breadcrumb">
                    	  <li><a href="{{ route('home') }}">Home</a></li>
                          <!--<li class="active">Fashion</li>-->
                          <?if(isset($breadcrump['c']) && !empty($breadcrump['c'])){?>
                          	<?foreach ($breadcrump['c'] as $k => $v){?>
                          	<li><a href="{{ $v['category_url'] }}"><?=$v['category_title']?></a></li>
                          	<?}//end of foreach?>
                          <?}//end of if?>
                    </ol>
                </div>
            </div>
        </div>
        
        <?if(isset($clist) && !empty($clist)){?>
        <div class="container category_panel">
            <?
            $i = 1;
            $closed = 0;
            foreach ($clist as $k => $v){?>
            	<?if($i == 1){?>
            		<div class="row">
            	<?}?>
            	<div class="col-md-3 padding_top_bottom_15"><a href="{{ $v->category_url }}"><?=$v->category_title?></a></div>
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
                <?if(isset($promo_ad_list) && !empty($promo_ad_list)){?>
                    <?foreach ($promo_ad_list as $k => $v){
                        $link = url(str_slug($v->ad_title) . '-' . 'ad' . $v->ad_id . '.html');
                        ?>
                        <!-- ad -->
                        <div class="col-md-3">
                            <div class="thumbnail">
                            	<a href="<?=$link?>"><img src="<?=asset('uf/adata/' . '740_' . $v->ad_pic);?>" alt=""></a>
                            	<div class="caption">
                                    <h4><a href="<?=$link?>"><?=str_limit($v->ad_title, 23)?></a></h4>
                                    <h3><?=$v->ad_price ? $v->ad_price . '&euro;' : '&nbsp;'?></h2>
                            	</div>
                            </div>
                        </div>
                        <!-- end of ad-->
                    <?}?>
                <?}?>
            </div>
            <!--end of ad row -->
        </div>
        
        <div class="container home_promo_ads_panel">
        	<div class="row margin_bottom_15">
            	<div class="col-md-12">
                    <h2>New Classifieds</h2>
                    <a href="<?=url('publish')?>">pusblish an ad</a>
                </div>
            </div>
            
            <!-- ad row-->
            <div class="row margin_bottom_15">
                <?if(isset($ad_list) && count($ad_list) > 0){?>
                    <?foreach ($ad_list as $k => $v){
                        $link = url(str_slug($v->ad_title) . '-' . 'ad' . $v->ad_id . '.html');
                        ?>
                        <!-- ad -->
                        <div class="col-md-3">
                            <div class="thumbnail">
                            	<a href="<?=$link?>"><img src="<?=asset('uf/adata/' . '740_' . $v->ad_pic);?>" alt=""></a>
                            	<div class="caption">
                                    <h4><a href="<?=$link?>"><?=str_limit($v->ad_title, 23)?></a></h4>
                                    <p><?=$v->location_name?></p>
                                    <h3><?=$v->ad_price ? $v->ad_price . '&euro;' : '&nbsp;'?></h2>
                            	</div>
                            </div>
                        </div>
                        <!-- end of ad-->
                    <?}?>
                <?} else {?>
                    <div class="col-md-12">
                        <h3>No results found...</h3>
                    </div>
                <?}?>
            </div>
            <!--end of ad row -->
        </div>
        
        <div class="container">
        	<div class="row">
            	<div class="col-md-12">
                    <nav>
                        <?=$ad_list->links()?>
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
