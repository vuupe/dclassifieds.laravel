@extends('layout.index_layout')

@section('search_filter')
        <div class="container search_panel">
            <form method="GET" action="{{ url('proxy') }}" class="form">
                <div class="row">
                    {!! csrf_field() !!}
                    <div class="col-md-3 padding_bottom_15">
                    	<input type="text" name="search_text" id="search_text" class="form-control" placeholder="1 000 000 Ads" value="{{ isset($params['search_text']) ? stripslashes($params['search_text']) : ''}}"/>
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
                    	@if(!$ac->isEmpty())
                   		<select name="condition_id" id="condition_id" class="form-control chosen_select" data-placeholder="Condition">
                   			<option value="0"></option>
                   			@foreach ($ac as $k => $v)
                   				@if(old('condition_id') == $v->ad_condition_id)
									<option value="{{ $v->ad_condition_id }}" selected>{{ $v->ad_condition_name }}</option>
								@else
									<option value="{{ $v->ad_condition_id }}">{{ $v->ad_condition_name }}</option>
								@endif
                   			@endforeach
                   		</select>
                   		@endif
                    </div>
                    
                    <div class="col-md-3 padding_bottom_15">
                    	@if(!$at->isEmpty())
                   		<select name="type_id" id="type_id" class="form-control chosen_select" data-placeholder="Private/Business Ad">
                   			<option value="0"></option>
                   			@foreach ($at as $k => $v)
                   				@if(old('type_id') == $v->ad_type_id)
									<option value="{{ $v->ad_type_id }}" selected>{{ $v->ad_type_name }}</option>
								@else
									<option value="{{ $v->ad_type_id }}">{{ $v->ad_type_name }}</option>
								@endif
                   			@endforeach
                   		</select>
                   		@endif
                    </div>
                    
                    <div class="col-md-3 padding_bottom_15">
                    	<input type="text" name="price_from" id="price_from" class="form-control" placeholder="Price from" value="{{ old('price_from') }}"/>
                    </div>
                    
                    <div class="col-md-3 padding_bottom_15">
                    	<input type="text" name="price_to" id="price_to" class="form-control" placeholder="Price to" value="{{ old('price_to') }}"/>
                    </div>
                    
                    <?if(isset($selected_category_info) && !empty($selected_category_info)){?>
                        <?if($selected_category_info['category_type'] == 2){?>
                        
                            <div class="col-md-3 padding_bottom_15">
                            	@if(!$estate_type->isEmpty())
		                   		<select name="estate_type_id" id="estate_type_id" class="form-control chosen_select" data-placeholder="Estate Type">
		                   			<option value="0"></option>
		                   			@foreach ($estate_type as $k => $v)
		                   				@if(old('estate_type_id') == $v->estate_type_id)
											<option value="{{ $v->estate_type_id }}" selected>{{ $v->estate_type_name }}</option>
										@else
											<option value="{{ $v->estate_type_id }}">{{ $v->estate_type_name }}</option>
										@endif
		                   			@endforeach
		                   		</select>
		                   		@endif
                            </div>
                            
                            <div class="col-md-3 padding_bottom_15">
                            	<input type="text" class="form-control" id="estate_sq_m_from" name="estate_sq_m_from" value="{{ old('estate_sq_m_from') }}" placeholder="Estate sq. m. from" />
                            </div>
                            
                            <div class="col-md-3 padding_bottom_15">
                            	<input type="text" class="form-control" id="estate_sq_m_to" name="estate_sq_m_to" value="{{ old('estate_sq_m_to') }}" placeholder="Estate sq. m. to" />
                            </div>
                            
                            <div class="col-md-3 padding_bottom_15">
                            	<input type="text" class="form-control" id="estate_year_from" name="estate_year_from" value="{{ old('estate_year_from') }}" placeholder="Estate year of construction from" />
                            </div>
                            
                            <div class="col-md-3 padding_bottom_15">
                            	<input type="text" class="form-control" id="estate_year_to" name="estate_year_to" value="{{ old('estate_year_to') }}" placeholder="Estate year of construction to" />
                            </div>
                            
                            <div class="col-md-3 padding_bottom_15">
                            	@if(!$estate_construction_type->isEmpty())
		                   		<select name="estate_construction_type_id" id="estate_construction_type_id" class="form-control chosen_select" data-placeholder="Estate Construction Type">
		                   			<option value="0"></option>
		                   			@foreach ($estate_construction_type as $k => $v)
		                   				@if(old('estate_construction_type_id') == $v->estate_construction_type_id)
											<option value="{{ $v->estate_construction_type_id }}" selected>{{ $v->estate_construction_type_name }}</option>
										@else
											<option value="{{ $v->estate_construction_type_id }}">{{ $v->estate_construction_type_name }}</option>
										@endif
		                   			@endforeach
		                   		</select>
		                   		@endif
                            </div>
                            
                            <div class="col-md-3 padding_bottom_15">
                            	@if(!$estate_heating_type->isEmpty())
		                   		<select name="estate_heating_type_id" id="estate_heating_type_id" class="form-control chosen_select" data-placeholder="Estate Heating">
		                   			<option value="0"></option>
		                   			@foreach ($estate_heating_type as $k => $v)
		                   				@if(old('estate_heating_type_id') == $v->estate_heating_type_id)
											<option value="{{ $v->estate_heating_type_id }}" selected>{{ $v->estate_heating_type_name }}</option>
										@else
											<option value="{{ $v->estate_heating_type_id }}">{{ $v->estate_heating_type_name }}</option>
										@endif
		                   			@endforeach
		                   		</select>
		                   		@endif
                            </div>
                            
                            <div class="col-md-3 padding_bottom_15">
                            	<input type="text" class="form-control" id="estate_floor_from" name="estate_floor_from" value="{{ old('estate_floor_from') }}" placeholder="Estate floor from" />
                            </div>
                            
                            <div class="col-md-3 padding_bottom_15">
                            	<input type="text" class="form-control" id="estate_floor_to" name="estate_floor_to" value="{{ old('estate_floor_to') }}" placeholder="Estate floor to" />
                            </div>
                            
                            <div class="col-md-3 padding_bottom_15">
                            	<input type="text" class="form-control" id="estate_num_floors_in_building" name="estate_num_floors_in_building" value="{{ old('estate_num_floors_in_building') }}" placeholder="Num Floors in Building" />
                            </div>
                            
                            <div class="col-md-3 padding_bottom_15">
                            	@if(!$estate_furnishing_type->isEmpty())
		                   		<select name="estate_furnishing_type_id" id="estate_furnishing_type_id" class="form-control chosen_select" data-placeholder="Estate Furnishing">
		                   			<option value="0"></option>
		                   			@foreach ($estate_furnishing_type as $k => $v)
		                   				@if(old('estate_furnishing_type_id') == $v->estate_furnishing_type_id)
											<option value="{{ $v->estate_furnishing_type_id }}" selected>{{ $v->estate_furnishing_type_name }}</option>
										@else
											<option value="{{ $v->estate_furnishing_type_id }}">{{ $v->estate_furnishing_type_name }}</option>
										@endif
		                   			@endforeach
		                   		</select>
		                   		@endif
                            </div>
                        <?}?>
                        
                        <?if($selected_category_info['category_type'] == 3){?>
                            <div class="col-md-3 padding_bottom_15">
                            	@if(!$car_engine_id->isEmpty())
		                   		<select name="car_engine_id" id="car_engine_id" class="form-control chosen_select" data-placeholder="Car Engine">
		                   			<option value="0"></option>
		                   			@foreach ($car_engine_id as $k => $v)
		                   				@if(old('car_engine_id') == $v->car_engine_id)
											<option value="{{ $v->car_engine_id }}" selected>{{ $v->car_engine_name }}</option>
										@else
											<option value="{{ $v->car_engine_id }}">{{ $v->car_engine_name }}</option>
										@endif
		                   			@endforeach
		                   		</select>
		                   		@endif
                            </div>
                        
                            <div class="col-md-3 padding_bottom_15">
                            	@if(!$car_brand_id->isEmpty())
		                   		<select name="car_brand_id" id="car_brand_id" class="form-control chosen_select" data-placeholder="Car Brand">
		                   			<option value="0"></option>
		                   			@foreach ($car_brand_id as $k => $v)
		                   				@if(old('car_brand_id') == $v->car_brand_id)
											<option value="{{ $v->car_brand_id }}" selected>{{ $v->car_brand_name }}</option>
										@else
											<option value="{{ $v->car_brand_id }}">{{ $v->car_brand_name }}</option>
										@endif
		                   			@endforeach
		                   		</select>
		                   		@endif
                            </div>
                            
                            <div class="col-md-3 padding_bottom_15">
                            	<div id="car_model_loader"><img src="{{ asset('images/small_loader.gif') }}" /></div>
                            	<?if(isset($car_model_id) && !empty($car_model_id)){?>
    		                   		<select name="car_model_id" id="car_model_id" class="form-control chosen_select" data-placeholder="Car Model">
                           			    <?foreach ($car_model_id as $k => $v){?>
                           			        <?if(old('car_model_id') == $k){?>
                           			            <option value="<?=$k?>" selected><?=$v?></option>
                           			        <?} else {?>
                           			            <option value="<?=$k?>"><?=$v?></option>
                           			        <?}//end of if?>
                           			    <?}//end of foreach?>
                       			    </select>
	                   			<?} else {?>
	                   			    <select name="car_model_id" id="car_model_id" class="form-control chosen_select" data-placeholder="Select Car Model" disabled>
	                   			        <option value="0"></option>
	                   			    </select>
	                   			<?}?>
                            </div>
                            
                            <div class="col-md-3 padding_bottom_15">
                            	@if(!$car_transmission_id->isEmpty())
		                   		<select name="car_transmission_id" id="car_transmission_id" class="form-control chosen_select" data-placeholder="Car Tranmission">
		                   			<option value="0"></option>
		                   			@foreach ($car_transmission_id as $k => $v)
		                   				@if(old('car_transmission_id') == $v->car_transmission_id)
											<option value="{{ $v->car_transmission_id }}" selected>{{ $v->car_transmission_name }}</option>
										@else
											<option value="{{ $v->car_transmission_id }}">{{ $v->car_transmission_name }}</option>
										@endif
		                   			@endforeach
		                   		</select>
		                   		@endif
                            </div>
                            
                            <div class="col-md-3 padding_bottom_15">
                            	@if(!$car_modification_id->isEmpty())
		                   		<select name="car_modification_id" id="car_modification_id" class="form-control chosen_select" data-placeholder="Car Modification">
		                   			<option value="0"></option>
		                   			@foreach ($car_modification_id as $k => $v)
		                   				@if(old('car_modification_id') == $v->car_modification_id)
											<option value="{{ $v->car_modification_id }}" selected>{{ $v->car_modification_name }}</option>
										@else
											<option value="{{ $v->car_modification_id }}">{{ $v->car_modification_name }}</option>
										@endif
		                   			@endforeach
		                   		</select>
		                   		@endif
                            </div>
                            
                            <div class="col-md-3 padding_bottom_15">
                            	<input type="text" class="form-control" id="car_year_from" name="car_year_from" value="{{ old('car_year_from') }}" placeholder="Car Year From" />
                            </div>
                            
                            <div class="col-md-3 padding_bottom_15">
                            	<input type="text" class="form-control" id="car_year_to" name="car_year_to" value="{{ old('car_year_to') }}" placeholder="Car Year To" />
                            </div>
                            
                            <div class="col-md-3 padding_bottom_15">
                            	<input type="text" class="form-control" id="car_kilometeres_from" name="car_kilometeres_from" value="{{ old('car_kilometeres_from') }}" placeholder="Car Kilometeres From" />
                            </div>
                            
                            <div class="col-md-3 padding_bottom_15">
                            	<input type="text" class="form-control" id="car_kilometeres_to" name="car_kilometeres_to" value="{{ old('car_kilometeres_to') }}" placeholder="Car Kilometeres To" />
                            </div>
                            
                            <div class="col-md-3 padding_bottom_15">
                            	@if(!$car_condition_id->isEmpty())
		                   		<select name="car_condition_id" id="car_condition_id" class="form-control chosen_select" data-placeholder="Car Condition">
		                   			<option value="0"></option>
		                   			@foreach ($car_condition_id as $k => $v)
		                   				@if(old('car_condition_id') == $v->car_condition_id)
											<option value="{{ $v->car_condition_id }}" selected>{{ $v->car_condition_name }}</option>
										@else
											<option value="{{ $v->car_condition_id }}">{{ $v->car_condition_name }}</option>
										@endif
		                   			@endforeach
		                   		</select>
		                   		@endif
                            </div>
                        
                        
                        <?}?>
                    <?}?>
                    
                    <div class="col-md-3 pull-right padding_bottom_15">
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
                <?if(isset($promo_ad_list) && !$promo_ad_list->isEmpty()){?>
                    <?foreach ($promo_ad_list as $k => $v){?>
                        @include('common.ad_list')
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
                <?if(isset($ad_list) && !$ad_list->isEmpty()){?>
                    <?foreach ($ad_list as $k => $v){?>
                        @include('common.ad_list')
                    <?}?>
                <?} else {?>
                    <div class="col-md-12">
                        <h3>No results found...</h3>
                    </div>
                <?}?>
            </div>
            <!--end of ad row -->
        </div>
        
        <?if(isset($ad_list) && !$ad_list->isEmpty()){?>
        <div class="container">
        	<div class="row">
            	<div class="col-md-12">
                    <nav>
                        <?=$ad_list->appends($params)->links()?>
                    </nav>
                </div>
            </div>
        </div>
        <?}//end of if?>
        
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
