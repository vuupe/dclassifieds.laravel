@extends('admin.layout.admin_index_layout')
@section('content')
	<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Ads
        <small>Edit</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('admin/ad') }}">Ads</a></li>
        <li class="active">Edit</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	<div class="row">
    		<div class="col-md-6">
		    	<div class="box">
		            <div class="box-header with-border">
		              <h3 class="box-title">Edit Ad #{{ $ad_detail->ad_id }}</h3>
		            </div>
		            <!-- /.box-header -->
		            
		            <form action="{{ url('admin/ad/save') }}" role="form" method="post" name="edit_form" id="edit_form" enctype="multipart/form-data">
			            <div class="box-body">
			            
				            {!! csrf_field() !!}
	                    	<input type="hidden" id="category_type" name="category_type" value="{{ Util::getOldOrModelValue('category_type', $ad_detail) ? Util::getOldOrModelValue('category_type', $ad_detail) : 0 }}" />
	                    	<input type="hidden" id="ad_id" name="ad_id" value="{{ $ad_detail->ad_id }}" />
	                    	<input type="hidden" id="user_id" name="user_id" value="{{ $ad_detail->user_id }}" />
	                    
	                        <div class="form-group required {{ $errors->has('ad_title') ? ' has-error' : '' }}">
	                        	<label for="ad_title" class="control-label">Ad Title</label>
	                        	<input type="text" class="form-control" id="ad_title" name="ad_title" value="{{ Util::getOldOrModelValue('ad_title', $ad_detail) }}" maxlength="255"/>
	                        	@if ($errors->has('ad_title'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('ad_title') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                        
	                        <div class="form-group required {{ $errors->has('category_id') ? ' has-error' : '' }}">
	                        	<label for="category_id" class="control-label">Category</label>
	                        	@if(isset($c) && !empty($c))
		                   		<select name="category_id" id="category_id" class="form-control chosen_select" disabled>
		                   			<option value="0"></option>
		                   			@foreach ($c as $k => $v)
		                   				<optgroup label="{{$v['title']}}">
		                   					@if(isset($v['c']) && !empty($v['c'])){
		                   						@include('common.cselect', ['c' => $v['c'], 'cid' => Util::getOldOrModelValue('category_id', $ad_detail)])
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
	                            
	                            <span id="helpBlock" class="help-block">
	                            <?
							    $ad_detail->ad_category_info = array_reverse($ad_detail->ad_category_info);
							    $category_array = array();
							    $slug = '';
							    foreach ($ad_detail->ad_category_info as $k => $v){
							        $slug .= $v['category_slug'] . '/';
							        $link_tpl = '<a href="%s" target="_blank">%s</a>';
							        $category_array[] = sprintf($link_tpl, url($slug), $v['category_title']);
							    }//end of foreach
							    echo join(' / ', $category_array);
							    ?>
							    </span>
	                            <input type="hidden" name="category_id" id="category_id" value="{{ Util::getOldOrModelValue('category_id', $ad_detail) }}">
	                        </div>
	                        
	                        <div class="form-group required {{ $errors->has('ad_description') ? ' has-error' : '' }}">
		                    	<label for="ad_description" class="control-label">Ad Description</label>
		                    	<textarea class="form-control" name="ad_description" id="ad_description" rows="{{ config('dc.num_rows_ad_description_textarea') }}"><?=Util::getOldOrModelValue('ad_description', $ad_detail) ?></textarea>
		                    	@if ($errors->has('ad_description'))
		                            <span class="help-block">
		                                <strong>{{ $errors->first('ad_description') }}</strong>
		                            </span>
		                        @endif
	                        </div>
	                        
	                        <hr>
	                        
	                        <!-- category type 1 common goods -->
	                        
	                        <div id="type_1" class="common_fields_container">
	                        <div class="form-group required {{ $errors->has('ad_price_type_1') ? ' has-error' : '' }}" style="margin-bottom: 0px;">
	                            <label for="ad_price_type_1" class="control-label">Price</label>
	                            <div>
	                            	<div class="pull-left checkbox"><input type="radio" name="price_radio" id="price_radio" value="1" {{ Util::getOldOrModelValue('price_radio', $ad_detail, 'ad_price') > 0 ? 'checked' : '' }}></div>
	                            	<div class="pull-left" style="margin-left:5px;">
	                            		<input type="text" class="form-control" id="ad_price_type_1" name="ad_price_type_1" value="{{ Util::getOldOrModelValue('ad_price_type_1', $ad_detail, 'ad_price') }}" />
	                            	</div>
	                            	
	                            	<div class="clearfix"></div>
	                            	
	                            	<div>
		                          		<label class="radio-inline">
		                          			<?if(empty(old('price_radio')) && $ad_detail->ad_free == 1){?>
		                          				<input type="radio" name="price_radio" id="price_radio" value="2" checked> Free
		                          			<?} else {?>
		                            			<input type="radio" name="price_radio" id="price_radio" value="2" {{ Util::getOldOrModelValue('price_radio', $ad_detail) == 2 ? 'checked' : '' }}> Free
		                            		<?}?>
		                            	</label>
		                            </div>
		                            
		                            <div class="clearfix"></div>
	                            	
	                            	@if ($errors->has('ad_price_type_1'))
	                            		<div class="clearfix"></div>
	                                    <span class="help-block">
	                                        <strong>{{ $errors->first('ad_price_type_1') }}</strong>
	                                    </span>
	                                @endif
	                            </div>
	                        </div>
	                        
	                        <div class="form-group required {{ $errors->has('condition_id_type_1') ? ' has-error' : '' }}">
	                            <label for="condition_id_type_1" class="control-label">Condition</label>
	                        	@if(!$ac->isEmpty())
		                   		<select name="condition_id_type_1" id="condition_id_type_1" class="form-control chosen_select" data-placeholder="Select Condition">
		                   			<option value="0"></option>
		                   			@foreach ($ac as $k => $v)
		                   				@if(Util::getOldOrModelValue('condition_id_type_1', $ad_detail) == $v->ad_condition_id)
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
	                        
	                        <hr>
	                        <!-- end of type 1 -->
	                        </div>
	                        
	                        <!-- category type 2 real estate -->
	                        <div id="type_2" class="common_fields_container">
	                        
	                        <div class="form-group required {{ $errors->has('ad_price_type_2') ? ' has-error' : '' }}">
	                            <label for="ad_price_type_2" class="control-label">Price</label>
	                        	<div><input type="text" class="form-control" id="ad_price_type_2" name="ad_price_type_2" value="{{ Util::getOldOrModelValue('ad_price_type_2', $ad_detail) }}" /></div>
	                        	@if ($errors->has('ad_price_type_2'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('ad_price_type_2') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                        
	                        <div class="form-group required {{ $errors->has('estate_type_id') ? ' has-error' : '' }}">
	                            <label for="estate_type_id" class="control-label">Estate Type</label>
	                        	@if(!$estate_type->isEmpty())
		                   		<select name="estate_type_id" id="estate_type_id" class="form-control chosen_select" data-placeholder="Select Estate Type">
		                   			<option value="0"></option>
		                   			@foreach ($estate_type as $k => $v)
		                   				@if(Util::getOldOrModelValue('estate_type_id', $ad_detail) == $v->estate_type_id)
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
	                        
	                        <div class="form-group required {{ $errors->has('estate_sq_m') ? ' has-error' : '' }}">
	                            <label for="estate_sq_m" class="control-label">Estate sq. m.</label>
	                        	<input type="text" class="form-control" id="estate_sq_m" name="estate_sq_m" value="{{ Util::getOldOrModelValue('estate_sq_m', $ad_detail) }}" />
	                        	@if ($errors->has('estate_sq_m'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('estate_sq_m') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                        
	                        <div class="form-group">
	                            <label for="estate_year" class="control-label">Estate year of construction</label>
	                           	<input type="text" class="form-control" id="estate_year" name="estate_year" value="{{ Util::getOldOrModelValue('estate_year', $ad_detail) }}" />
	                        </div>
	                        
	                        <div class="form-group">
	                            <label for="estate_construction_type_id" class="control-label">Estate Construction Type</label>
	                        	@if(!$estate_construction_type->isEmpty())
		                   		<select name="estate_construction_type_id" id="estate_construction_type_id" class="form-control chosen_select" data-placeholder="Select Estate Construction Type">
		                   			<option value="0"></option>
		                   			@foreach ($estate_construction_type as $k => $v)
		                   				@if(Util::getOldOrModelValue('estate_construction_type_id', $ad_detail) == $v->estate_construction_type_id)
											<option value="{{ $v->estate_construction_type_id }}" selected>{{ $v->estate_construction_type_name }}</option>
										@else
											<option value="{{ $v->estate_construction_type_id }}">{{ $v->estate_construction_type_name }}</option>
										@endif
		                   			@endforeach
		                   		</select>
		                   		@endif
	                        </div>
	                        
	                        <div class="form-group">
	                            <label for="estate_floor" class="control-label">Estate floor</label>
	                           	<input type="text" class="form-control" id="estate_floor" name="estate_floor" value="{{ Util::getOldOrModelValue('estate_floor', $ad_detail) }}" />
	                        </div>
	                        
	                        <div class="form-group">
	                            <label for="estate_num_floors_in_building" class="control-label">Num Floors in Building</label>
	                            <input type="text" class="form-control" id="estate_num_floors_in_building" name="estate_num_floors_in_building" value="{{ Util::getOldOrModelValue('estate_num_floors_in_building', $ad_detail) }}" />
	                        </div>
	                        
	                        <div class="form-group">
	                            <label for="estate_heating_type_id" class="control-label">Estate Heating</label>
	                        	@if(!$estate_heating_type->isEmpty())
		                   		<select name="estate_heating_type_id" id="estate_heating_type_id" class="form-control chosen_select" data-placeholder="Select Estate Heating">
		                   			<option value="0"></option>
		                   			@foreach ($estate_heating_type as $k => $v)
		                   				@if(Util::getOldOrModelValue('estate_heating_type_id', $ad_detail) == $v->estate_heating_type_id)
											<option value="{{ $v->estate_heating_type_id }}" selected>{{ $v->estate_heating_type_name }}</option>
										@else
											<option value="{{ $v->estate_heating_type_id }}">{{ $v->estate_heating_type_name }}</option>
										@endif
		                   			@endforeach
		                   		</select>
		                   		@endif
	                        </div>
	                        
	                        <div class="form-group">
	                            <label for="estate_furnishing_type_id" class="control-label">Estate Furnishing</label>
	                        	@if(!$estate_furnishing_type->isEmpty())
		                   		<select name="estate_furnishing_type_id" id="estate_furnishing_type_id" class="form-control chosen_select" data-placeholder="Select Estate Furnishing">
		                   			<option value="0"></option>
		                   			@foreach ($estate_furnishing_type as $k => $v)
		                   				@if(Util::getOldOrModelValue('estate_furnishing_type_id', $ad_detail) == $v->estate_furnishing_type_id)
											<option value="{{ $v->estate_furnishing_type_id }}" selected>{{ $v->estate_furnishing_type_name }}</option>
										@else
											<option value="{{ $v->estate_furnishing_type_id }}">{{ $v->estate_furnishing_type_name }}</option>
										@endif
		                   			@endforeach
		                   		</select>
		                   		@endif
	                        </div>
	                        
	                        <div class="form-group {{ $errors->has('condition_id_type_2') ? ' has-error' : '' }}">
	                            <label for="condition_id_type_2" class="control-label">Estate Condition</label>
	                        	@if(!$ac->isEmpty())
		                   		<select name="condition_id_type_2" id="condition_id_type_2" class="form-control chosen_select" data-placeholder="Select Condition">
		                   			<option value="0"></option>
		                   			@foreach ($ac as $k => $v)
		                   				@if(old('condition_id_type_2') == $v->ad_condition_id)
											<option value="{{ $v->ad_condition_id }}" selected>{{ $v->ad_condition_name }}</option>
										@else
											<option value="{{ $v->ad_condition_id }}">{{ $v->ad_condition_name }}</option>
										@endif
		                   			@endforeach
		                   		</select>
		                   		@endif
		                   		
		                   		@if ($errors->has('condition_id_type_2'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('condition_id_type_2') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                        
	                        <hr>
	                        <!-- end of type 2 -->
	                        </div>
	                        
	                        <!-- category type 3 cars -->
	                        <div id="type_3" class="common_fields_container">
	                        
	                        <div class="form-group required {{ $errors->has('car_brand_id') ? ' has-error' : '' }}">
	                            <label for="car_brand_id" class="control-label">Car Brand</label>
	                        	@if(!$car_brand_id->isEmpty())
		                   		<select name="car_brand_id" id="car_brand_id" class="form-control chosen_select" data-placeholder="Select Car Brand">
		                   			<option value="0"></option>
		                   			@foreach ($car_brand_id as $k => $v)
		                   				@if(Util::getOldOrModelValue('car_brand_id', $ad_detail) == $v->car_brand_id)
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
	                        
	                        <div class="form-group required {{ $errors->has('car_model_id') ? ' has-error' : '' }}" style="position:relative;">
	                            <label for="car_model_id" class="control-label">Car Model</label>
	                        	<div id="car_model_loader"><img src="{{ asset('images/small_loader.gif') }}" /></div>
	                        	<?if(isset($car_model_id) && !empty($car_model_id)){?>
			                   		<select name="car_model_id" id="car_model_id" class="form-control chosen_select" data-placeholder="Select Car Model">
	                       			    <?foreach ($car_model_id as $k => $v){?>
	                       			        <?if(Util::getOldOrModelValue('car_model_id', $ad_detail) == $k){?>
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
	                        
	                        <div class="form-group required {{ $errors->has('car_engine_id') ? ' has-error' : '' }}">
	                            <label for="car_engine_id" class="control-label">Car Engine</label>
	                        	@if(!$car_engine_id->isEmpty())
		                   		<select name="car_engine_id" id="car_engine_id" class="form-control chosen_select" data-placeholder="Select Car Engine">
		                   			<option value="0"></option>
		                   			@foreach ($car_engine_id as $k => $v)
		                   				@if(Util::getOldOrModelValue('car_engine_id', $ad_detail) == $v->car_engine_id)
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
	                        
	                        <div class="form-group required {{ $errors->has('car_transmission_id') ? ' has-error' : '' }}">
	                            <label for="car_transmission_id" class="control-label">Car Transmission</label>
	                        	@if(!$car_transmission_id->isEmpty())
		                   		<select name="car_transmission_id" id="car_transmission_id" class="form-control chosen_select" data-placeholder="Select Car Tranmission">
		                   			<option value="0"></option>
		                   			@foreach ($car_transmission_id as $k => $v)
		                   				@if(Util::getOldOrModelValue('car_transmission_id', $ad_detail) == $v->car_transmission_id)
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
	                        
	                        <div class="form-group required {{ $errors->has('car_modification_id') ? ' has-error' : '' }}">
	                            <label for="car_transmission_id" class="control-label">Car Modification</label>
	                        	@if(!$car_modification_id->isEmpty())
		                   		<select name="car_modification_id" id="car_modification_id" class="form-control chosen_select" data-placeholder="Select Car Modification">
		                   			<option value="0"></option>
		                   			@foreach ($car_modification_id as $k => $v)
		                   				@if(Util::getOldOrModelValue('car_modification_id', $ad_detail) == $v->car_modification_id)
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
	                        
	                        <div class="form-group required {{ $errors->has('car_year') ? ' has-error' : '' }}">
	                            <label for="car_year" class="control-label">Car Year</label>
	                        	<div><input type="text" class="form-control" id="car_year" name="car_year" value="{{ Util::getOldOrModelValue('car_year', $ad_detail) }}" /></div>
	                        	@if ($errors->has('car_year'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('car_year') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                        
	                        <div class="form-group required {{ $errors->has('car_kilometeres') ? ' has-error' : '' }}">
	                            <label for="car_kilometeres" class="control-label">Car Kilometers</label>
	                        	<div><input type="text" class="form-control" id="car_kilometeres" name="car_kilometeres" value="{{ Util::getOldOrModelValue('car_kilometeres', $ad_detail) }}" /></div>
	                        	@if ($errors->has('car_kilometeres'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('car_kilometeres') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                        
	                        <div class="form-group required {{ $errors->has('condition_id_type_3') ? ' has-error' : '' }}">
	                            <label for="condition_id_type_3" class="control-label">Condition</label>
	                        	@if(!$ac->isEmpty())
		                   		<select name="condition_id_type_3" id="condition_id_type_3" class="form-control chosen_select" data-placeholder="Select Condition">
		                   			<option value="0"></option>
		                   			@foreach ($ac as $k => $v)
		                   				@if(Util::getOldOrModelValue('condition_id_type_3', $ad_detail) == $v->ad_condition_id)
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
	                        
	                        <div class="form-group required {{ $errors->has('car_condition_id') ? ' has-error' : '' }}">
	                            <label for="car_condition_id" class="control-label">Car Condition</label>
	                        	@if(!$car_condition_id->isEmpty())
		                   		<select name="car_condition_id" id="car_condition_id" class="form-control chosen_select" data-placeholder="Select Car Condition">
		                   			<option value="0"></option>
		                   			@foreach ($car_condition_id as $k => $v)
		                   				@if(Util::getOldOrModelValue('car_condition_id', $ad_detail) == $v->car_condition_id)
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
	                        
	                        <div class="form-group required {{ $errors->has('ad_price_type_3') ? ' has-error' : '' }}">
	                            <label for="ad_price_type_3" class="control-label">Price</label>
	                        	<div><input type="text" class="form-control" id="ad_price_type_3" name="ad_price_type_3" value="{{ Util::getOldOrModelValue('ad_price_type_3', $ad_detail) }}" /></div>
	                        	@if ($errors->has('ad_price_type_3'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('ad_price_type_3') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                        
	                        <hr>
	                        <!-- end of type 3 -->
	                        </div>
	                        
	                        <div class="form-group required {{ $errors->has('type_id') ? ' has-error' : '' }}">
	                            <label for="type_id" class=" control-label">Private/Business Ad</label>
	                        	@if(!$at->isEmpty())
		                   		<select name="type_id" id="type_id" class="form-control chosen_select" data-placeholder="Please Select">
		                   			<option value="0"></option>
		                   			@foreach ($at as $k => $v)
		                   				@if(Util::getOldOrModelValue('type_id', $ad_detail) == $v->ad_type_id)
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
	                        
	                        <hr>
	                        
	                        <div class="form-group required {{ $errors->has('location_id') ? ' has-error' : '' }}">
	                            <label for="location_id" class="control-label">Location</label>
	                        	@if(isset($l) && !empty($l))
		                   		<select name="location_id" id="location_id" class="form-control chosen_select">
		                   			<option value="0"></option>
		                   			@foreach ($l as $k => $v)
		                   				<optgroup label="{{$v['title']}}">
		                   					@if(isset($v['c']) && !empty($v['c'])){
		                   						@include('common.lselect', ['c' => $v['c'], 'lid' => Util::getOldOrModelValue('location_id', $ad_detail)])
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
	                        
	                        <div class="form-group">
	                            <label for="ad_address" class="control-label">Address</label>
								<input type="text" class="form-control" id="ad_address" name="ad_address" value="{{ Util::getOldOrModelValue('ad_address', $ad_detail) }}" >
	                        </div>
	                        
	                        <div class="form-group required {{ $errors->has('ad_puslisher_name') ? ' has-error' : '' }}">
	                            <label for="ad_puslisher_name" class="control-label">Contact Name</label>
	                        	<input type="text" class="form-control" id="ad_puslisher_name" name="ad_puslisher_name" value="{{ Util::getOldOrModelValue('ad_puslisher_name', $ad_detail) }}" />
	                        	@if ($errors->has('ad_puslisher_name'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('ad_puslisher_name') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                        
	                        <div class="form-group required {{ $errors->has('ad_email') ? ' has-error' : '' }}">
	                            <label for="ad_email" class="control-label">E-Mail</label>
	                        	<input type="email" class="form-control" id="ad_email" name="ad_email" value="{{ Util::getOldOrModelValue('ad_email', $ad_detail) }}" />
	                        	@if ($errors->has('ad_email'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('ad_email') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                        
	                        <div class="form-group">
	                            <label for="ad_phone" class="control-label">Phone</label>
	                        	<input type="text" class="form-control" id="ad_phone" name="ad_phone" value="{{ Util::getOldOrModelValue('ad_phone', $ad_detail) }}" >
	                        </div>
	                        
	                        <div class="form-group">
	                            <label for="ad_skype" class="control-label">Skype</label>
	                        	<input type="text" class="form-control" id="ad_skype" name="ad_skype" value="{{ Util::getOldOrModelValue('ad_skype', $ad_detail) }}" >
	                        </div>
	                        
	                        <div class="form-group">
	                            <label for="ad_link" class="control-label">Web Site</label>
	                        	<input type="text" class="form-control" id="ad_link" name="ad_link" value="{{ Util::getOldOrModelValue('ad_link', $ad_detail) }}" >
	                        	<span id="helpBlock" class="help-block">Insert link to your site in this format: http://www.site.com</span>
	                        </div>
	                        
	                        <div class="form-group">
	                            <label for="ad_video" class="control-label">Video</label>
	                    		<input type="text" class="form-control" id="ad_video" name="ad_video" value="{{ Util::getOldOrModelValue('ad_video', $ad_detail) }}" >
	                        	<span id="helpBlock" class="help-block">Insert link to youtube.com video</span>
	                        </div>
	                        
	                        <hr>
	                        
	                        <div class="form-group">
	                            <label for="ad_publish_date" class="control-label">Date Published</label>
	                            <div class="input-group date">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<input type="text" class="form-control" id="ad_publish_date" name="ad_publish_date" value="{{ Util::getOldOrModelValue('ad_publish_date', $ad_detail) }}" >
								</div>
	                        </div>
	                        
	                        <div class="form-group">
	                            <label for="ad_valid_until" class="control-label">Valid Until</label>
	                            <div class="input-group date">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<input type="text" class="form-control" id="ad_valid_until" name="ad_valid_until" value="{{ Util::getOldOrModelValue('ad_valid_until', $ad_detail) }}" >
	                           	</div>
	                        </div>
	                        
	                        <div class="form-group">
	                            <label for="ad_ip" class="control-label">IP</label>
	                           	<input type="text" class="form-control" id="ad_ip" name="ad_ip" value="{{ Util::getOldOrModelValue('ad_ip', $ad_detail) }}" >
	                        </div>
	                        
	                        <div class="form-group">
	                            <label for="code" class="control-label">Code</label>
	                           	<input type="text" class="form-control" id="code" name="code" value="{{ Util::getOldOrModelValue('code', $ad_detail) }}" >
	                        </div>
	                        
	                        <div class="form-group">
	                            <label for="ad_view" class="control-label">Views</label>
	                           	<input type="text" class="form-control" id="ad_view" name="ad_view" value="{{ Util::getOldOrModelValue('ad_view', $ad_detail) }}" >
	                        </div>
	                        
	                        <div class="form-group">
	                            <label for="updated_at" class="control-label">Updated at</label>
	                           	<input type="text" class="form-control" id="updated_at" name="updated_at" value="{{ Util::getOldOrModelValue('updated_at', $ad_detail) }}" readonly>
	                        </div>
	                        
	                        <div class="form-group">
		                        <label>
				                	<input type="checkbox" name="ad_promo" {{ Util::getOldOrModelValue('ad_promo', $ad_detail) ? 'checked' : '' }}> Ad is Promo
				                </label>
				            </div>
	                        
	                        <div class="form-group">
	                            <label for="ad_promo_until" class="control-label">Ad is Promo Until</label>
	                            <div class="input-group date">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
	                           		<input type="text" class="form-control" id="ad_promo_until" name="ad_promo_until" value="{{ Util::getOldOrModelValue('ad_promo_until', $ad_detail) }}" >
	                           	</div>
	                        </div>
	                        
	                        <div class="form-group">
		                        <label>
				                	<input type="checkbox" name="ad_active" {{ Util::getOldOrModelValue('ad_active', $ad_detail) ? 'checked' : '' }}> Active
				                </label>
				            </div>
			            
			            </div>
			            <!-- /.box-body -->
			            
			            <div class="box-footer">
							<button type="submit" class="btn btn-primary">Save</button>
						</div>
					</form>
					
		        </div>
		        <!-- /.box -->
	        </div>
	        
	        <div class="col-md-6">
		    	<div class="box">
		            <div class="box-header with-border">
		              <h3 class="box-title">Ad #{{ $ad_detail->ad_id }} Images</h3>
		            </div>
		            <!-- /.box-header -->
			        <div class="box-body">
			        
				        <?$link = url(str_slug($ad_detail->ad_title) . '-' . 'ad' . $ad_detail->ad_id . '.html');?>
				        <p class="help-block">Ad URL: <a href="{{ $link }}" target="_blank">{{ $link }}</a></p>
				        
				        <hr>
				        
				        <?if(isset($ad_detail->ad_pic) && !empty($ad_detail->ad_pic)){?>
				        	<div class="row">
				        		<div class="col-md-3">
							        <a href="<?=asset('uf/adata/1000_' . $ad_detail->ad_pic)?>" target="_blank">
							        	<img src="<?=asset('uf/adata/740_' . $ad_detail->ad_pic)?>" class="img-thumbnail" />
							        </a>
						        </div>
					        </div>
					    <?}?>
					    
					    <hr>
					    
					    <?if(isset($ad_detail->pics) && !$ad_detail->pics->isEmpty()){?>
					    	<div class="row">
					        <?foreach($ad_detail->pics as $k => $v){?>
					        	<div class="col-md-3">
						            <a href="<?=asset('uf/adata/1000_' . $v->ad_pic)?>" target="_blank">
						            	<img src="<?=asset('uf/adata/1000_' . $v->ad_pic)?>" class="img-thumbnail" />
						            </a>
					            </div>
					        <?}//?>
					        </div>
					    <?}?>
			        	
			        </div>
			        <!-- /.box-body -->
		        </div>
		        <!-- /.box -->
	        </div>
	        
		</div>
          
    </section>
    <!-- /.content -->
    
@endsection

@section('styles')
	<link rel="stylesheet" href="{{ asset('js/chosen/chosen.css') }}" />
    <link rel="stylesheet" href="{{ asset('js/chosen/chosen-bootstrap.css') }}" />
    <!-- bootstrap datepicker -->
  	<link rel="stylesheet" href="{{asset('adminlte/plugins/datepicker/datepicker3.css')}}">
  	<!-- iCheck for checkboxes and radio inputs -->
  	<link rel="stylesheet" href="{{asset('adminlte/plugins/iCheck/flat/blue.css')}}">
@endsection

@section('js')
	<script src="{{ asset('js/chosen/chosen.jquery.min.js') }}"></script>
	<!-- bootstrap datepicker -->
	<script src="{{asset('adminlte/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
	<script src="{{asset('adminlte/plugins/fastclick/fastclick.js')}}"></script>
	<!-- iCheck 1.0.1 -->
	<script src="{{asset('adminlte/plugins/iCheck/icheck.min.js')}}"></script>
	<script>
	$(function () {
		//Enable iCheck plugin for checkboxes
        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"]').iCheck({
          checkboxClass: 'icheckbox_flat-blue',
          radioClass: 'iradio_flat-blue'
        });

        $('#ad_valid_until, #ad_promo_until').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
         });
	});
	</script>
@endsection

