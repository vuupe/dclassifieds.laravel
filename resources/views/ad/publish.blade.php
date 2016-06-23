@extends('layout.index_layout')

@section('content')
		<div class="container">
        	<div class="row">
            	<div class="col-md-12">
                    <ol class="breadcrumb">
                    	  <li><a href="#">Home</a></li>
                          <li class="active">Post an ad</li>
                    </ol>
                </div>
            </div>
        </div>
        
        
        <div class="container">
        	<div class="row">
            	<div class="col-md-12">
                	
                	@if (session()->has('message'))
					    <div class="alert alert-info">{{ session('message') }}</div>
					@endif
                
                    <form class="form-horizontal" method="POST" enctype="multipart/form-data">
                    
                    	{!! csrf_field() !!}
                    	<input type="hidden" id="category_type" name="category_type" value="{{ old('category_type') ? old('category_type') : 0 }}" />
                    
                    	<div class="row">
                            <div class="col-md-offset-4 col-md-8">
                                <h2>Post an ad</h2>
                            </div>
                        </div>
                    
                        <div class="form-group required {{ $errors->has('ad_title') ? ' has-error' : '' }}">
                            <label for="ad_title" class="col-md-4 control-label">Ad Title</label>
                            <div class="col-md-5">
                            	<input type="text" class="form-control" id="ad_title" name="ad_title" value="{{ old('ad_title') }}" maxlength="255"/>
                            	
                            	@if ($errors->has('ad_title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ad_title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group required {{ $errors->has('category_id') ? ' has-error' : '' }}">
                            <label for="category_id" class="col-md-4 control-label">Category</label>
                            <div class="col-md-5">
                            	@if(isset($c) && !empty($c))
		                   		<select name="category_id" id="category_id" class="form-control cid_select">
		                   			<option value="0"></option>
		                   			@foreach ($c as $k => $v)
		                   				<optgroup label="{{$v['title']}}">
		                   					@if(isset($v['c']) && !empty($v['c'])){
		                   						@include('common.cselect', ['c' => $v['c'], 'cid' => old('category_id')])
		                   					@endif
		                   				</optgroup>
		                   			@endforeach
		                   		</select>
		                   		@endif
		                   		
		                   		@if ($errors->has('category_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('category_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group required {{ $errors->has('ad_description') ? ' has-error' : '' }}">
                            <label for="ad_description" class="col-md-4 control-label">Ad Description</label>
                            <div class="col-md-5">
                            	<textarea class="form-control" name="ad_description" id="ad_description" rows="{{ config('dc.num_rows_ad_description_textarea') }}">{{ old('ad_description') }}</textarea>
                            	
                            	@if ($errors->has('ad_description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ad_description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <hr>
                        
                        <!-- category type 1 common goods -->
                        
                        <div id="type_1" class="common_fields_container">
                        <div class="form-group required {{ $errors->has('ad_price_type_1') ? ' has-error' : '' }}" style="margin-bottom: 0px;">
                            <label for="ad_price_type_1" class="col-md-4 control-label">Price</label>
                            <div class="col-md-5">
                            	<div class="pull-left checkbox"><input type="radio" name="price_radio" id="price_radio" value="1" {{ old('price_radio') == 1 ? 'checked' : '' }}></div>
                            	<div class="pull-left" style="margin-left:5px;">
                            		<input type="text" class="form-control" id="ad_price_type_1" name="ad_price_type_1" value="{{ old('ad_price_type_1') }}" />
                            	</div>
                            	
                            	@if ($errors->has('ad_price_type_1'))
                            		<div class="clearfix"></div>
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ad_price_type_1') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-offset-4 col-md-6">
                          		<label class="radio-inline">
                            		<input type="radio" name="price_radio" id="price_radio" value="2" {{ old('price_radio') == 2 ? 'checked' : '' }}> Free
                            	</label>
                            </div>
                        </div>
                        
                        <div class="form-group required {{ $errors->has('condition_id_type_1') ? ' has-error' : '' }}">
                            <label for="condition_id_type_1" class="col-md-4 control-label">Condition</label>
                            <div class="col-md-5">
                            	@if(!$ac->isEmpty())
		                   		<select name="condition_id_type_1" id="condition_id_type_1" class="form-control chosen_select" data-placeholder="Select Condition">
		                   			<option value="0"></option>
		                   			@foreach ($ac as $k => $v)
		                   				@if(old('condition_id_type_1') == $v->ad_condition_id)
											<option value="{{ $v->ad_condition_id }}" selected>{{ $v->ad_condition_name }}</option>
										@else
											<option value="{{ $v->ad_condition_id }}">{{ $v->ad_condition_name }}</option>
										@endif
		                   			@endforeach
		                   		</select>
		                   		@endif
		                   		
		                   		@if ($errors->has('condition_id_type_1'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('condition_id_type_1') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <hr>
                        <!-- end of type 1 -->
                        </div>
                        
                        <!-- category type 2 real estate -->
                        <div id="type_2" class="common_fields_container">
                        
                        <div class="form-group required {{ $errors->has('ad_price_type_2') ? ' has-error' : '' }}">
                            <label for="ad_price_type_2" class="col-md-4 control-label">Price</label>
                            <div class="col-md-5">
                            	<div><input type="text" class="form-control" id="ad_price_type_2" name="ad_price_type_2" value="{{ old('ad_price_type_2') }}" /></div>
                            	@if ($errors->has('ad_price_type_2'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ad_price_type_2') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group required {{ $errors->has('estate_type_id') ? ' has-error' : '' }}">
                            <label for="estate_type_id" class="col-md-4 control-label">Estate Type</label>
                            <div class="col-md-5">
                            	@if(!$estate_type->isEmpty())
		                   		<select name="estate_type_id" id="estate_type_id" class="form-control chosen_select" data-placeholder="Select Estate Type">
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
		                   		@if ($errors->has('estate_type_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('estate_type_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group required {{ $errors->has('estate_sq_m') ? ' has-error' : '' }}">
                            <label for="estate_sq_m" class="col-md-4 control-label">Estate sq. m.</label>
                            <div class="col-md-5">
                            	<input type="text" class="form-control" id="estate_sq_m" name="estate_sq_m" value="{{ old('estate_sq_m') }}" />
                            	@if ($errors->has('estate_sq_m'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('estate_sq_m') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="estate_year" class="col-md-4 control-label">Estate year of construction</label>
                            <div class="col-md-5">
                            	<input type="text" class="form-control" id="estate_year" name="estate_year" value="{{ old('estate_year') }}" />
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="estate_construction_type_id" class="col-md-4 control-label">Estate Construction Type</label>
                            <div class="col-md-5">
                            	@if(!$estate_construction_type->isEmpty())
		                   		<select name="estate_construction_type_id" id="estate_construction_type_id" class="form-control chosen_select" data-placeholder="Select Estate Construction Type">
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
                        </div>
                        
                        <div class="form-group">
                            <label for="estate_floor" class="col-md-4 control-label">Estate floor</label>
                            <div class="col-md-5">
                            	<input type="text" class="form-control" id="estate_floor" name="estate_floor" value="{{ old('estate_floor') }}" />
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="estate_num_floors_in_building" class="col-md-4 control-label">Num Floors in Building</label>
                            <div class="col-md-5">
                            	<input type="text" class="form-control" id="estate_num_floors_in_building" name="estate_num_floors_in_building" value="{{ old('estate_num_floors_in_building') }}" />
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="estate_heating_type_id" class="col-md-4 control-label">Estate Heating</label>
                            <div class="col-md-5">
                            	@if(!$estate_heating_type->isEmpty())
		                   		<select name="estate_heating_type_id" id="estate_heating_type_id" class="form-control chosen_select" data-placeholder="Select Estate Heating">
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
                        </div>
                        
                        <div class="form-group">
                            <label for="estate_furnishing_type_id" class="col-md-4 control-label">Estate Furnishing</label>
                            <div class="col-md-5">
                            	@if(!$estate_furnishing_type->isEmpty())
		                   		<select name="estate_furnishing_type_id" id="estate_furnishing_type_id" class="form-control chosen_select" data-placeholder="Select Estate Furnishing">
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
                        </div>
                        
                        <hr>
                        <!-- end of type 2 -->
                        </div>
                        
                        <!-- category type 3 cars -->
                        <div id="type_3" class="common_fields_container">
                        
                        <div class="form-group required {{ $errors->has('car_brand_id') ? ' has-error' : '' }}">
                            <label for="car_brand_id" class="col-md-4 control-label">Car Brand</label>
                            <div class="col-md-5">
                            	@if(!$car_brand_id->isEmpty())
		                   		<select name="car_brand_id" id="car_brand_id" class="form-control chosen_select" data-placeholder="Select Car Brand">
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
		                   		@if ($errors->has('car_brand_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('car_brand_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group required {{ $errors->has('car_model_id') ? ' has-error' : '' }}">
                            <label for="car_model_id" class="col-md-4 control-label">Car Model</label>
                            <div class="col-md-5">
                            	<div id="car_model_loader"><img src="{{ asset('images/small_loader.gif') }}" /></div>
                            	<?if(isset($car_model_id) && !empty($car_model_id)){?>
    		                   		<select name="car_model_id" id="car_model_id" class="form-control chosen_select" data-placeholder="Select Car Model">
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
		                   			
		                   		
		                   		
		                   		@if ($errors->has('car_model_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('car_model_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group required {{ $errors->has('car_engine_id') ? ' has-error' : '' }}">
                            <label for="car_engine_id" class="col-md-4 control-label">Car Engine</label>
                            <div class="col-md-5">
                            	@if(!$car_engine_id->isEmpty())
		                   		<select name="car_engine_id" id="car_engine_id" class="form-control chosen_select" data-placeholder="Select Car Engine">
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
		                   		@if ($errors->has('car_engine_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('car_engine_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group required {{ $errors->has('car_transmission_id') ? ' has-error' : '' }}">
                            <label for="car_transmission_id" class="col-md-4 control-label">Car Transmission</label>
                            <div class="col-md-5">
                            	@if(!$car_transmission_id->isEmpty())
		                   		<select name="car_transmission_id" id="car_transmission_id" class="form-control chosen_select" data-placeholder="Select Car Tranmission">
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
		                   		@if ($errors->has('car_transmission_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('car_transmission_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group required {{ $errors->has('car_modification_id') ? ' has-error' : '' }}">
                            <label for="car_transmission_id" class="col-md-4 control-label">Car Modification</label>
                            <div class="col-md-5">
                            	@if(!$car_modification_id->isEmpty())
		                   		<select name="car_modification_id" id="car_modification_id" class="form-control chosen_select" data-placeholder="Select Car Modification">
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
		                   		@if ($errors->has('car_modification_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('car_modification_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group required {{ $errors->has('car_year') ? ' has-error' : '' }}">
                            <label for="car_year" class="col-md-4 control-label">Car Year</label>
                            <div class="col-md-5">
                            	<div><input type="text" class="form-control" id="car_year" name="car_year" value="{{ old('car_year') }}" /></div>
                            	@if ($errors->has('car_year'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('car_year') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group required {{ $errors->has('car_kilometeres') ? ' has-error' : '' }}">
                            <label for="car_kilometeres" class="col-md-4 control-label">Car Kilometers</label>
                            <div class="col-md-5">
                            	<div><input type="text" class="form-control" id="car_kilometeres" name="car_kilometeres" value="{{ old('car_kilometeres') }}" /></div>
                            	@if ($errors->has('car_kilometeres'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('car_kilometeres') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group required {{ $errors->has('condition_id_type_3') ? ' has-error' : '' }}">
                            <label for="condition_id_type_3" class="col-md-4 control-label">Condition</label>
                            <div class="col-md-5">
                            	@if(!$ac->isEmpty())
		                   		<select name="condition_id_type_3" id="condition_id_type_3" class="form-control chosen_select" data-placeholder="Select Condition">
		                   			<option value="0"></option>
		                   			@foreach ($ac as $k => $v)
		                   				@if(old('condition_id_type_3') == $v->ad_condition_id)
											<option value="{{ $v->ad_condition_id }}" selected>{{ $v->ad_condition_name }}</option>
										@else
											<option value="{{ $v->ad_condition_id }}">{{ $v->ad_condition_name }}</option>
										@endif
		                   			@endforeach
		                   		</select>
		                   		@endif
		                   		
		                   		@if ($errors->has('condition_id_type_3'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('condition_id_type_3') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group required {{ $errors->has('car_condition_id') ? ' has-error' : '' }}">
                            <label for="car_condition_id" class="col-md-4 control-label">Car Condition</label>
                            <div class="col-md-5">
                            	@if(!$car_condition_id->isEmpty())
		                   		<select name="car_condition_id" id="car_condition_id" class="form-control chosen_select" data-placeholder="Select Car Condition">
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
		                   		@if ($errors->has('car_condition_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('car_condition_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group required {{ $errors->has('ad_price_type_3') ? ' has-error' : '' }}">
                            <label for="ad_price_type_3" class="col-md-4 control-label">Price</label>
                            <div class="col-md-5">
                            	<div><input type="text" class="form-control" id="ad_price_type_3" name="ad_price_type_3" value="{{ old('ad_price_type_3') }}" /></div>
                            	@if ($errors->has('ad_price_type_3'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ad_price_type_3') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <hr>
                        <!-- end of type 3 -->
                        </div>
                        
                        <div class="form-group required {{ $errors->has('type_id') ? ' has-error' : '' }}">
                            <label for="type_id" class="col-md-4 control-label">Private/Business Ad</label>
                            <div class="col-md-5">
                            	@if(!$at->isEmpty())
		                   		<select name="type_id" id="type_id" class="form-control chosen_select" data-placeholder="Please Select">
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
		                   		@if ($errors->has('type_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('type_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <?
                        $num_image = config('dc.ad_num_images');
                        $file_has_error = 0;
                        for($i = 1; $i <= $num_image; $i++){
                            if($errors->has('ad_image.' . ($i-1))){
                                $file_has_error = 1;
                            }        
                        }
                        if($errors->has('ad_image')){
                        	$file_has_error = 1;
                        }
                        ?>
                        <div class="form-group {{ $file_has_error ? ' has-error' : '' }}">
                        	<label for="ad_image" class="col-md-4 control-label">Pics</label>
                            <div class="col-md-5">
                            	<?for($i = 1; $i <= $num_image; $i++){?>
                                    <input type="file" name="ad_image[]">
                                    @if ($errors->has('ad_image.' . ($i-1)))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('ad_image.' . ($i-1)) }}</strong>
                                        </span>
                                    @endif
                                <?}//end of for?>
                            </div>
                            <div class="col-md-offset-4 col-md-5">
                                    @if ($errors->has('ad_image'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('ad_image') }}</strong>
                                        </span>
                                    @endif
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="form-group required {{ $errors->has('location_id') ? ' has-error' : '' }}">
                            <label for="location_id" class="col-md-4 control-label">Location</label>
                            <div class="col-md-5">
                            	@if(isset($l) && !empty($l))
		                   		<select name="location_id" id="location_id" class="form-control lid_select">
		                   			<option value="0"></option>
		                   			@foreach ($l as $k => $v)
		                   				<optgroup label="{{$v['title']}}">
		                   					@if(isset($v['c']) && !empty($v['c'])){
		                   						@include('common.lselect', ['c' => $v['c'], 'lid' => Util::getOldOrModelValue('location_id', $user, 'user_location_id')])
		                   					@endif
		                   				</optgroup>
		                   			@endforeach
		                   		</select>
		                   		@endif
		                   		@if ($errors->has('location_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('location_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ad_address" class="col-md-4 control-label">Address</label>
                            <div class="col-md-5">
                                <div class="input-group">
                                	<input type="text" class="form-control" id="ad_address" name="ad_address" value="{{ Util::getOldOrModelValue('ad_address', $user, 'user_address') }}" >
                                	<span class="input-group-btn">
                                        <input type="button" class="btn btn-info" id="ad_address_show_map" name="ad_address_show_map" value="Find on Map" >
                                    </span>
                                </div>
                            	<input type="hidden" class="form-control" id="ad_lat_lng" name="ad_lat_lng" value="{{ Util::getOldOrModelValue('ad_lat_lng', $user, 'user_lat_lng') }}" >
                            </div>
                        </div>
                        
                        <div class="form-group required {{ $errors->has('ad_puslisher_name') ? ' has-error' : '' }}">
                            <label for="ad_puslisher_name" class="col-md-4 control-label">Contact Name</label>
                            <div class="col-md-5">
                            	<input type="text" class="form-control" id="ad_puslisher_name" name="ad_puslisher_name" value="{{ Util::getOldOrModelValue('ad_puslisher_name', $user, 'name') }}" />
                            	@if ($errors->has('ad_puslisher_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ad_puslisher_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group required {{ $errors->has('ad_email') ? ' has-error' : '' }}">
                            <label for="ad_email" class="col-md-4 control-label">E-Mail</label>
                            <div class="col-md-5">
                            	<input type="email" class="form-control" id="ad_email" name="ad_email" value="{{ Util::getOldOrModelValue('ad_email', $user, 'email') }}" />
                            	@if ($errors->has('ad_email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ad_email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ad_phone" class="col-md-4 control-label">Phone</label>
                            <div class="col-md-5">
                            	<input type="text" class="form-control" id="ad_phone" name="ad_phone" value="{{ Util::getOldOrModelValue('ad_phone', $user, 'user_phone') }}" >
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ad_skype" class="col-md-4 control-label">Skype</label>
                            <div class="col-md-5">
                            	<input type="text" class="form-control" id="ad_skype" name="ad_skype" value="{{ Util::getOldOrModelValue('ad_skype', $user, 'user_phone') }}" >
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ad_link" class="col-md-4 control-label">Web Site</label>
                            <div class="col-md-5">
                            	<input type="text" class="form-control" id="ad_link" name="ad_link" value="{{ Util::getOldOrModelValue('ad_link', $user, 'user_site') }}" >
                            	<span id="helpBlock" class="help-block">Insert link to your site in this format: http://www.site.com</span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ad_video" class="col-md-4 control-label">Video</label>
                            <div class="col-md-5">
                            	<input type="text" class="form-control" id="ad_video" name="ad_video" value="{{ old('ad_video') }}" >
                            	<span id="helpBlock" class="help-block">Insert link to youtube.com video</span>
                            </div>
                        </div>
                        
                        <div class="form-group required {{ $errors->has('policy_agree') ? ' has-error' : '' }}">
                        	<label for="policy_agree" class="col-md-4 control-label"></label>
                            <div class="col-md-8">
	                            <div class="checkbox">
		                            <label>
		                            	<input type="checkbox" name="policy_agree" {{ old('policy_agree') ? 'checked' : '' }}> I agree with <a href="">"Privacy Policy"</a>
		                            </label>
		                            @if ($errors->has('policy_agree'))
	                                    <span class="help-block">
	                                        <strong>{{ $errors->first('policy_agree') }}</strong>
	                                    </span>
	                                @endif
	                            </div>
                            </div>
                        </div>
                        
                        
                        <div class="form-group">
                            <div class="col-md-offset-4 col-md-8">
                            	<button type="submit" class="btn btn-primary">Publish</button>
                            </div>
                        </div>
                    </form>
                
                
                
                
                
                </div>
            </div>
        </div>
        
        
        
        
        
        <div id="google_map_container" style="display:none;">
            <div style="margin:10px 0px 20px 0px">
        		<form class="form-inline">
        		    <div class="form-group">
            			<input type="text" name="address" id="address" class="form-control" style="width:445px;"/>
            			<input type="hidden" name="lat" id="lat"/>
            			<button type="button" name="location_find" id="location_find" class="btn btn-primary">
            			    <span class="glyphicon glyphicon glyphicon-search" aria-hidden="true"></span> Find on the map
            			</button>
            			<button type="button" name="location_ok" id="location_ok" class="btn btn-success">
            			    <span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> Yes, this is my location
            			</button>
        			</div>
        		</form>
        	</div>
        	<div style="width: 800px; height:400px;" id="map_canvas"></div>
        </div>
        
        
        
@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset('js/fancybox/jquery.fancybox.css')}}" />
@endsection

@section('js')
    <script src="{{asset('js/fancybox/jquery.fancybox.pack.js')}}"></script>
    <script src="http://maps.googleapis.com/maps/api/js?sensor=true&language=en"></script>
    <script src="{{asset('js/google.map.js')}}"></script>
@endsection

