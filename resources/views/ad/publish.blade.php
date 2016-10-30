@extends('layout.index_layout')

@section('title', join(' / ', $title))

@section('search_filter')
    <div style="margin-bottom: 20px;"></div>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="{{ route('home') }}">{{ trans('publish_edit.Home') }}</a></li>
                    <li class="active">{{ trans('publish_edit.Post an ad') }}</li>
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
                            <h2>{{ trans('publish_edit.Post an ad') }}</h2>
                        </div>
                    </div>

                    <div class="form-group required {{ $errors->has('ad_title') ? ' has-error' : '' }}">
                        <label for="ad_title" class="col-md-4 control-label">{{ trans('publish_edit.Ad Title') }}</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" id="ad_title" name="ad_title" value="{{ old('ad_title') }}" maxlength="255" />
                            @if ($errors->has('ad_title'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('ad_title') }}</strong>
                                </span>
                            @endif
                            @if(trans('publish_edit.Write the most descriptive title'))
                                <span class="help-block">
                                    {!! trans('publish_edit.Write the most descriptive title') !!}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group required {{ $errors->has('category_id') ? ' has-error' : '' }}">
                        <label for="category_id" class="col-md-4 control-label">{{ trans('publish_edit.Category') }}</label>
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
                            @if(trans('publish_edit.Choose the most appropriate category'))
                                <span class="help-block">
                                    {!! trans('publish_edit.Choose the most appropriate category') !!}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group required {{ $errors->has('ad_description') ? ' has-error' : '' }}">
                        <label for="ad_description" class="col-md-4 control-label">{{ trans('publish_edit.Ad Description') }}</label>
                        <div class="col-md-5">
                            <textarea class="form-control" name="ad_description" id="ad_description" rows="{{ config('dc.num_rows_ad_description_textarea') }}">{{ old('ad_description') }}</textarea>
                            @if ($errors->has('ad_description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('ad_description') }}</strong>
                                </span>
                            @endif
                            @if(trans('publish_edit.Write the most descriptive description'))
                                <span class="help-block">
                                    {!! trans('publish_edit.Write the most descriptive description') !!}
                                </span>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <!-- category type 1 common goods -->

                    <div id="type_1" class="common_fields_container">
                        <div class="form-group required {{ $errors->has('ad_price_type_1') ? ' has-error' : '' }}" style="margin-bottom: 0px;">
                            <label for="ad_price_type_1" class="col-md-4 control-label">{{ trans('publish_edit.Price') }}</label>
                            <div class="col-md-5">
                                <div class="pull-left checkbox"><input type="radio" name="price_radio" id="price_radio" value="1" {{ old('price_radio') == 1 ? 'checked' : '' }}></div>
                                <div class="pull-left" style="margin-left:5px;">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="ad_price_type_1" name="ad_price_type_1" value="{{ old('ad_price_type_1') }}" />
                                        <div class="input-group-addon">{{ config('dc.site_price_sign') }}</div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                @if ($errors->has('ad_price_type_1'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ad_price_type_1') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-4 col-md-6">
                                <label class="radio-inline">
                                    <input type="radio" name="price_radio" id="price_radio" value="2" {{ old('price_radio') == 2 ? 'checked' : '' }}> {{ trans('publish_edit.Free') }}
                                </label>
                                @if(trans('publish_edit.Select a price for your ad'))
                                    <span class="help-block">
                                        {!! trans('publish_edit.Select a price for your ad') !!}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group required {{ $errors->has('condition_id_type_1') ? ' has-error' : '' }}">
                            <label for="condition_id_type_1" class="col-md-4 control-label">{{ trans('publish_edit.Condition') }}</label>
                            <div class="col-md-5">
                                @if(!$ac->isEmpty())
                                <select name="condition_id_type_1" id="condition_id_type_1" class="form-control chosen_select" data-placeholder="{{ trans('publish_edit.Select Condition') }}">
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
                                @if(trans('publish_edit.In what condition is your item'))
                                    <span class="help-block">
                                        {!! trans('publish_edit.In what condition is your item') !!}
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
                            <label for="ad_price_type_2" class="col-md-4 control-label">{{ trans('publish_edit.Price') }}</label>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="ad_price_type_2" name="ad_price_type_2" value="{{ old('ad_price_type_2') }}" />
                                    <div class="input-group-addon">{{ config('dc.site_price_sign') }}</div>
                                </div>
                                @if ($errors->has('ad_price_type_2'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ad_price_type_2') }}</strong>
                                    </span>
                                @endif
                                @if(trans('publish_edit.Enter Price'))
                                    <span class="help-block">
                                        {!! trans('publish_edit.Enter Price') !!}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group required {{ $errors->has('estate_type_id') ? ' has-error' : '' }}">
                            <label for="estate_type_id" class="col-md-4 control-label">{{ trans('publish_edit.Estate Type') }}</label>
                            <div class="col-md-5">
                                @if(!$estate_type->isEmpty())
                                <select name="estate_type_id" id="estate_type_id" class="form-control chosen_select" data-placeholder="{{ trans('publish_edit.Select Estate Type') }}">
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
                                @if(trans('publish_edit.Choose Estate Type'))
                                    <span class="help-block">
                                        {!! trans('publish_edit.Choose Estate Type') !!}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group required {{ $errors->has('estate_sq_m') ? ' has-error' : '' }}">
                            <label for="estate_sq_m" class="col-md-4 control-label">{{ trans('publish_edit.Estate sq. m.') }}</label>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="estate_sq_m" name="estate_sq_m" value="{{ old('estate_sq_m') }}" />
                                    <div class="input-group-addon">{{ config('dc.site_metric_system') }}</div>
                                </div>
                                @if ($errors->has('estate_sq_m'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('estate_sq_m') }}</strong>
                                    </span>
                                @endif
                                @if(trans('publish_edit.Enter Estate sq. m.'))
                                    <span class="help-block">
                                        {!! trans('publish_edit.Enter Estate sq. m.') !!}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="estate_year" class="col-md-4 control-label">{{ trans('publish_edit.Estate year of construction') }}</label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" id="estate_year" name="estate_year" value="{{ old('estate_year') }}" />
                                @if(trans('publish_edit.Enter Estate year'))
                                    <span class="help-block">
                                        {!! trans('publish_edit.Enter Estate year') !!}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="estate_construction_type_id" class="col-md-4 control-label">{{ trans('publish_edit.Estate Construction Type') }}</label>
                            <div class="col-md-5">
                                @if(!$estate_construction_type->isEmpty())
                                <select name="estate_construction_type_id" id="estate_construction_type_id" class="form-control chosen_select" data-placeholder="{{ trans('publish_edit.Select Estate Construction Type') }}">
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
                                @if(trans('publish_edit.Enter Estate Construction Type'))
                                    <span class="help-block">
                                        {!! trans('publish_edit.Enter Estate Construction Type') !!}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="estate_floor" class="col-md-4 control-label">{{ trans('publish_edit.Estate floor') }}</label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" id="estate_floor" name="estate_floor" value="{{ old('estate_floor') }}" />
                                @if(trans('publish_edit.Enter Estate Floor'))
                                    <span class="help-block">
                                        {!! trans('publish_edit.Enter Estate Floor') !!}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="estate_num_floors_in_building" class="col-md-4 control-label">{{ trans('publish_edit.Num Floors in Building') }}</label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" id="estate_num_floors_in_building" name="estate_num_floors_in_building" value="{{ old('estate_num_floors_in_building') }}" />
                                @if(trans('publish_edit.Enter num floors in building'))
                                    <span class="help-block">
                                        {!! trans('publish_edit.Enter num floors in building') !!}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="estate_heating_type_id" class="col-md-4 control-label">{{ trans('publish_edit.Estate Heating') }}</label>
                            <div class="col-md-5">
                                @if(!$estate_heating_type->isEmpty())
                                <select name="estate_heating_type_id" id="estate_heating_type_id" class="form-control chosen_select" data-placeholder="{{ trans('publish_edit.Select Estate Heating') }}">
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
                                @if(trans('publish_edit.Enter Estate Heating'))
                                    <span class="help-block">
                                        {!! trans('publish_edit.Enter Estate Heating') !!}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="estate_furnishing_type_id" class="col-md-4 control-label">{{ trans('publish_edit.Estate Furnishing') }}</label>
                            <div class="col-md-5">
                                @if(!$estate_furnishing_type->isEmpty())
                                <select name="estate_furnishing_type_id" id="estate_furnishing_type_id" class="form-control chosen_select" data-placeholder="{{ trans('publish_edit.Select Estate Furnishing') }}">
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
                                @if(trans('publish_edit.Enter Estate Furnishing'))
                                    <span class="help-block">
                                        {!! trans('publish_edit.Enter Estate Furnishing') !!}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('condition_id_type_2') ? ' has-error' : '' }}">
                            <label for="condition_id_type_2" class="col-md-4 control-label">{{ trans('publish_edit.Estate Condition') }}</label>
                            <div class="col-md-5">
                                @if(!$ac->isEmpty())
                                <select name="condition_id_type_2" id="condition_id_type_2" class="form-control chosen_select" data-placeholder="{{ trans('publish_edit.Select Condition') }}">
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
                                @if(trans('publish_edit.Choose Estate Condition'))
                                    <span class="help-block">
                                        {!! trans('publish_edit.Choose Estate Condition') !!}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <hr>
                    <!-- end of type 2 -->
                    </div>

                    <!-- category type 3 cars -->
                    <div id="type_3" class="common_fields_container">

                        <div class="form-group required {{ $errors->has('car_brand_id') ? ' has-error' : '' }}">
                            <label for="car_brand_id" class="col-md-4 control-label">{{ trans('publish_edit.Car Brand') }}</label>
                            <div class="col-md-5">
                                @if(!$car_brand->isEmpty())
                                <select name="car_brand_id" id="car_brand_id" class="form-control chosen_select" data-placeholder="{{ trans('publish_edit.Select Car Brand') }}">
                                    <option value="0"></option>
                                    @foreach ($car_brand as $k => $v)
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
                                @if(trans('publish_edit.Choose Car Brand'))
                                    <span class="help-block">
                                        {!! trans('publish_edit.Choose Car Brand') !!}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group required {{ $errors->has('car_model_id') ? ' has-error' : '' }}">
                            <label for="car_model_id" class="col-md-4 control-label">{{ trans('publish_edit.Car Model') }}</label>
                            <div class="col-md-5">
                                <div id="car_model_loader"><img src="{{ asset('images/small_loader.gif') }}" /></div>
                                @if(isset($car_model) && !empty($car_model))
                                    <select name="car_model_id" id="car_model_id" class="form-control chosen_select" data-placeholder="{{ trans('publish_edit.Select Car Model') }}">
                                        @foreach ($car_model as $k => $v)
                                            @if(old('car_model_id') == $k)
                                                <option value="{{ $k }}" selected>{{ $v }}</option>
                                            @else
                                                <option value="{{ $k }}">{{ $v }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                @else
                                    <select name="car_model_id" id="car_model_id" class="form-control chosen_select" data-placeholder="{{ trans('publish_edit.Select Car Model') }}" disabled>
                                        <option value="0"></option>
                                    </select>
                                @endif
                                @if ($errors->has('car_model_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('car_model_id') }}</strong>
                                    </span>
                                @endif
                                @if(trans('publish_edit.Choose Car Model'))
                                    <span class="help-block">
                                        {!! trans('publish_edit.Choose Car Model') !!}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group required {{ $errors->has('car_engine_id') ? ' has-error' : '' }}">
                            <label for="car_engine_id" class="col-md-4 control-label">{{ trans('publish_edit.Car Engine') }}</label>
                            <div class="col-md-5">
                                @if(!$car_engine->isEmpty())
                                <select name="car_engine_id" id="car_engine_id" class="form-control chosen_select" data-placeholder="{{ trans('publish_edit.Select Car Engine') }}">
                                    <option value="0"></option>
                                    @foreach ($car_engine as $k => $v)
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
                                @if(trans('publish_edit.Choose Car Engine'))
                                    <span class="help-block">
                                        {!! trans('publish_edit.Choose Car Engine') !!}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group required {{ $errors->has('car_transmission_id') ? ' has-error' : '' }}">
                            <label for="car_transmission_id" class="col-md-4 control-label">{{ trans('publish_edit.Car Transmission') }}</label>
                            <div class="col-md-5">
                                @if(!$car_transmission->isEmpty())
                                <select name="car_transmission_id" id="car_transmission_id" class="form-control chosen_select" data-placeholder="{{ trans('publish_edit.Select Car Tranmission') }}">
                                    <option value="0"></option>
                                    @foreach ($car_transmission as $k => $v)
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
                                @if(trans('publish_edit.Choose Car Transmission'))
                                    <span class="help-block">
                                        {!! trans('publish_edit.Choose Car Transmission') !!}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group required {{ $errors->has('car_modification_id') ? ' has-error' : '' }}">
                            <label for="car_transmission_id" class="col-md-4 control-label">{{ trans('publish_edit.Car Modification') }}</label>
                            <div class="col-md-5">
                                @if(!$car_modification->isEmpty())
                                <select name="car_modification_id" id="car_modification_id" class="form-control chosen_select" data-placeholder="{{ trans('publish_edit.Select Car Modification') }}">
                                    <option value="0"></option>
                                    @foreach ($car_modification as $k => $v)
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
                                @if(trans('publish_edit.Choose Car Modification'))
                                    <span class="help-block">
                                        {!! trans('publish_edit.Choose Car Modification') !!}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group required {{ $errors->has('car_year') ? ' has-error' : '' }}">
                            <label for="car_year" class="col-md-4 control-label">{{ trans('publish_edit.Car Year') }}</label>
                            <div class="col-md-5">
                                <div><input type="text" class="form-control" id="car_year" name="car_year" value="{{ old('car_year') }}" /></div>
                                @if ($errors->has('car_year'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('car_year') }}</strong>
                                    </span>
                                @endif
                                @if(trans('publish_edit.Enter Car Year'))
                                    <span class="help-block">
                                        {!! trans('publish_edit.Enter Car Year') !!}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group required {{ $errors->has('car_kilometeres') ? ' has-error' : '' }}">
                            <label for="car_kilometeres" class="col-md-4 control-label">{{ trans('publish_edit.Car Kilometers') }}</label>
                            <div class="col-md-5">
                                <div><input type="text" class="form-control" id="car_kilometeres" name="car_kilometeres" value="{{ old('car_kilometeres') }}" /></div>
                                @if ($errors->has('car_kilometeres'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('car_kilometeres') }}</strong>
                                    </span>
                                @endif
                                @if(trans('publish_edit.Enter Car Kilometers'))
                                    <span class="help-block">
                                        {!! trans('publish_edit.Enter Car Kilometers') !!}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group required {{ $errors->has('condition_id_type_3') ? ' has-error' : '' }}">
                            <label for="condition_id_type_3" class="col-md-4 control-label">{{ trans('publish_edit.Condition') }}</label>
                            <div class="col-md-5">
                                @if(!$ac->isEmpty())
                                <select name="condition_id_type_3" id="condition_id_type_3" class="form-control chosen_select" data-placeholder="{{ trans('publish_edit.Select Condition') }}">
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
                                @if(trans('publish_edit.Choose Condition'))
                                    <span class="help-block">
                                        {!! trans('publish_edit.Choose Condition') !!}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group required {{ $errors->has('car_condition_id') ? ' has-error' : '' }}">
                            <label for="car_condition_id" class="col-md-4 control-label">{{ trans('publish_edit.Car Condition') }}</label>
                            <div class="col-md-5">
                                @if(!$car_condition->isEmpty())
                                <select name="car_condition_id" id="car_condition_id" class="form-control chosen_select" data-placeholder="{{ trans('publish_edit.Select Car Condition') }}">
                                    <option value="0"></option>
                                    @foreach ($car_condition as $k => $v)
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
                                @if(trans('publish_edit.Choose Car Condition'))
                                    <span class="help-block">
                                        {!! trans('publish_edit.Choose Car Condition') !!}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group required {{ $errors->has('ad_price_type_3') ? ' has-error' : '' }}">
                            <label for="ad_price_type_3" class="col-md-4 control-label">{{ trans('publish_edit.Price') }}</label>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="ad_price_type_3" name="ad_price_type_3" value="{{ old('ad_price_type_3') }}" />
                                    <div class="input-group-addon">{{ config('dc.site_price_sign') }}</div>
                                </div>
                                @if ($errors->has('ad_price_type_3'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ad_price_type_3') }}</strong>
                                    </span>
                                @endif
                                @if(trans('publish_edit.Enter Price'))
                                    <span class="help-block">
                                        {!! trans('publish_edit.Enter Price') !!}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <hr>
                    <!-- end of type 3 -->
                    </div>

                    <!-- category type 4 services -->
                    <div id="type_4" class="common_fields_container">
                        <div class="form-group required {{ $errors->has('ad_price_type_4') ? ' has-error' : '' }}" style="margin-bottom: 0px;">
                            <label for="ad_price_type_4" class="col-md-4 control-label">{{ trans('publish_edit.Price') }}</label>
                            <div class="col-md-5">
                                <div class="pull-left checkbox"><input type="radio" name="price_radio_type_4" id="price_radio_type_4" value="1" {{ old('price_radio_type_4') == 1 ? 'checked' : '' }}></div>
                                <div class="pull-left" style="margin-left:5px;">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="ad_price_type_4" name="ad_price_type_4" value="{{ old('ad_price_type_4') }}" />
                                        <div class="input-group-addon">{{ config('dc.site_price_sign') }}</div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                @if ($errors->has('ad_price_type_4'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ad_price_type_4') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-4 col-md-6">
                                <label class="radio-inline">
                                    <input type="radio" name="price_radio_type_4" id="price_radio_type_4" value="2" {{ old('price_radio_type_4') == 2 ? 'checked' : '' }}> {{ trans('publish_edit.Free') }}
                                </label>
                                @if(trans('publish_edit.Select a price for your ad'))
                                    <span class="help-block">
                                        {!! trans('publish_edit.Select a price for your ad') !!}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <hr>
                    <!-- end of type 4 -->
                    </div>

                    <!-- category type 5 clothes -->
                    <div id="type_5" class="common_fields_container">
                        <div class="form-group required {{ $errors->has('ad_price_type_5') ? ' has-error' : '' }}" style="margin-bottom: 0px;">
                            <label for="ad_price_type_5" class="col-md-4 control-label">{{ trans('publish_edit.Price') }}</label>
                            <div class="col-md-5">
                                <div class="pull-left checkbox"><input type="radio" name="price_radio_type_5" id="price_radio_type_5" value="1" {{ old('price_radio_type_5') == 1 ? 'checked' : '' }}></div>
                                <div class="pull-left" style="margin-left:5px;">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="ad_price_type_5" name="ad_price_type_5" value="{{ old('ad_price_type_5') }}" />
                                        <div class="input-group-addon">{{ config('dc.site_price_sign') }}</div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                @if ($errors->has('ad_price_type_5'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ad_price_type_5') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-4 col-md-6">
                                <label class="radio-inline">
                                    <input type="radio" name="price_radio_type_5" id="price_radio_type_5" value="2" {{ old('price_radio_type_5') == 2 ? 'checked' : '' }}> {{ trans('publish_edit.Free') }}
                                </label>
                                @if(trans('publish_edit.Select a price for your ad'))
                                    <span class="help-block">
                                        {!! trans('publish_edit.Select a price for your ad') !!}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group required {{ $errors->has('clothes_size_id') ? ' has-error' : '' }}">
                            <label for="clothes_size_id" class="col-md-4 control-label">{{ trans('publish_edit.Clothes Size') }}</label>
                            <div class="col-md-5">
                                @if(!$clothes_sizes->isEmpty())
                                <select name="clothes_size_id" id="clothes_size_id" class="form-control chosen_select" data-placeholder="{{ trans('publish_edit.Select Clothes Size') }}">
                                    <option value="0"></option>
                                    @foreach ($clothes_sizes as $k => $v)
                                        @if(old('clothes_size_id') == $v->clothes_size_id)
                                            <option value="{{ $v->clothes_size_id }}" selected>{{ $v->clothes_size_name }}</option>
                                        @else
                                            <option value="{{ $v->clothes_size_id }}">{{ $v->clothes_size_name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @endif
                                @if ($errors->has('clothes_size_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('clothes_size_id') }}</strong>
                                    </span>
                                @endif
                                @if(trans('publish_edit.Choose Clothes Size'))
                                    <span class="help-block">
                                        {!! trans('publish_edit.Choose Clothes Size') !!}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <hr>
                    <!-- end of type 5 -->
                    </div>

                    <!-- category type 6 shoes -->
                    <div id="type_6" class="common_fields_container">
                        <div class="form-group required {{ $errors->has('ad_price_type_6') ? ' has-error' : '' }}" style="margin-bottom: 0px;">
                            <label for="ad_price_type_6" class="col-md-4 control-label">{{ trans('publish_edit.Price') }}</label>
                            <div class="col-md-5">
                                <div class="pull-left checkbox"><input type="radio" name="price_radio_type_6" id="price_radio_type_6" value="1" {{ old('price_radio_type_6') == 1 ? 'checked' : '' }}></div>
                                <div class="pull-left" style="margin-left:5px;">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="ad_price_type_6" name="ad_price_type_6" value="{{ old('ad_price_type_6') }}" />
                                        <div class="input-group-addon">{{ config('dc.site_price_sign') }}</div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                @if ($errors->has('ad_price_type_6'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ad_price_type_6') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-4 col-md-6">
                                <label class="radio-inline">
                                    <input type="radio" name="price_radio_type_6" id="price_radio_type_6" value="2" {{ old('price_radio_type_6') == 2 ? 'checked' : '' }}> {{ trans('publish_edit.Free') }}
                                </label>
                                @if(trans('publish_edit.Select a price for your ad'))
                                    <span class="help-block">
                                        {!! trans('publish_edit.Select a price for your ad') !!}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group required {{ $errors->has('shoes_size_id') ? ' has-error' : '' }}">
                            <label for="shoes_size_id" class="col-md-4 control-label">{{ trans('publish_edit.Shoes Size') }}</label>
                            <div class="col-md-5">
                                @if(!$shoes_sizes->isEmpty())
                                <select name="shoes_size_id" id="shoes_size_id" class="form-control chosen_select" data-placeholder="{{ trans('publish_edit.Select Shoes Size') }}">
                                    <option value="0"></option>
                                    @foreach ($shoes_sizes as $k => $v)
                                        @if(old('shoes_size_id') == $v->shoes_size_id)
                                            <option value="{{ $v->shoes_size_id }}" selected>{{ $v->shoes_size_name }}</option>
                                        @else
                                            <option value="{{ $v->shoes_size_id }}">{{ $v->shoes_size_name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @endif
                                @if ($errors->has('shoes_size_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('shoes_size_id') }}</strong>
                                    </span>
                                @endif
                                @if(trans('publish_edit.Choose Shoes Size'))
                                    <span class="help-block">
                                        {!! trans('publish_edit.Choose Shoes Size') !!}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <hr>
                    <!-- end of type 6 -->
                    </div>

                    <!-- category type 7 real estate land -->
                    <div id="type_7" class="common_fields_container">
                        <div class="form-group required {{ $errors->has('ad_price_type_7') ? ' has-error' : '' }}">
                            <label for="ad_price_type_7" class="col-md-4 control-label">{{ trans('publish_edit.Price') }}</label>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="ad_price_type_7" name="ad_price_type_7" value="{{ old('ad_price_type_7') }}" />
                                    <div class="input-group-addon">{{ config('dc.site_price_sign') }}</div>
                                </div>
                                @if ($errors->has('ad_price_type_7'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ad_price_type_7') }}</strong>
                                    </span>
                                @endif
                                @if(trans('publish_edit.Enter Price'))
                                    <span class="help-block">
                                        {!! trans('publish_edit.Enter Price') !!}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group required {{ $errors->has('estate_sq_m_type_7') ? ' has-error' : '' }}">
                            <label for="estate_sq_m_type_7" class="col-md-4 control-label">{{ trans('publish_edit.Estate/Land sq. m.') }}</label>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="estate_sq_m_type_7" name="estate_sq_m_type_7" value="{{ old('estate_sq_m_type_7') }}" />
                                    <div class="input-group-addon">{{ config('dc.site_metric_system') }}</div>
                                </div>
                                @if ($errors->has('estate_sq_m_type_7'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('estate_sq_m_type_7') }}</strong>
                                    </span>
                                @endif
                                @if(trans('publish_edit.Enter Estate/Land sq. m.'))
                                    <span class="help-block">
                                        {!! trans('publish_edit.Enter Estate/Land sq. m.') !!}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <hr>
                    <!-- end of type 7 -->
                    </div>

                    <div class="form-group required {{ $errors->has('type_id') ? ' has-error' : '' }}">
                        <label for="type_id" class="col-md-4 control-label">{{ trans('publish_edit.Private/Business Ad') }}</label>
                        <div class="col-md-5">
                            @if(!$at->isEmpty())
                            <select name="type_id" id="type_id" class="form-control chosen_select" data-placeholder="{{ trans('publish_edit.Please Select') }}">
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
                            @if(trans('publish_edit.Are you private or business seller'))
                                <span class="help-block">
                                    {!! trans('publish_edit.Are you private or business seller') !!}
                                </span>
                            @endif
                        </div>
                    </div>

                    <hr>

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

                    $required = '';
                    if(config('dc.require_ad_image')){
                        $required = 'required';
                    }
                    ?>
                    <div class="form-group {{ $required }} {{ $file_has_error ? ' has-error' : '' }}">
                        <label for="ad_image" class="col-md-4 control-label">{{ trans('publish_edit.Pics') }}</label>
                        <div class="col-md-5">
                            @for($i = 1; $i <= $num_image; $i++)
                                <div style="margin-bottom:5px;"><input type="file" name="ad_image[]" id="ad_image_{{ $i }}" style="display:inline;"> <button class="btn btn-danger btn-xs clear" data-id="{{ $i }}">{{ trans('publish_edit.Clear') }}</button></div>
                                @if ($errors->has('ad_image.' . ($i-1)))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ad_image.' . ($i-1)) }}</strong>
                                    </span>
                                @endif
                            @endfor
                        </div>
                        <div class="col-md-offset-4 col-md-5">
                            @if ($errors->has('ad_image'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('ad_image') }}</strong>
                                </span>
                            @endif
                            @if(trans('publish_edit.Choose the best picture for your ad'))
                                <span class="help-block">
                                    {!! trans('publish_edit.Choose the best picture for your ad') !!}
                                </span>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <div class="form-group required {{ $errors->has('location_id') ? ' has-error' : '' }}">
                        <label for="location_id" class="col-md-4 control-label">{{ trans('publish_edit.Location') }}</label>
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
                            @if(trans('publish_edit.Choose your Location'))
                                <span class="help-block">
                                    {!! trans('publish_edit.Choose your Location') !!}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="ad_address" class="col-md-4 control-label">{{ trans('publish_edit.Address') }}</label>
                        <div class="col-md-5">
                            <div class="input-group">
                                <input type="text" class="form-control" id="ad_address" name="ad_address" value="{{ Util::getOldOrModelValue('ad_address', $user, 'user_address') }}" >
                                <span class="input-group-btn">
                                    <input type="button" class="btn btn-info" id="ad_address_show_map" name="ad_address_show_map" value="{{ trans('publish_edit.Find on Map') }}" >
                                </span>
                            </div>
                            <input type="hidden" class="form-control" id="ad_lat_lng" name="ad_lat_lng" value="{{ Util::getOldOrModelValue('ad_lat_lng', $user, 'user_lat_lng') }}" >
                            @if(trans('publish_edit.Choose your Address'))
                                <span class="help-block">
                                    {!! trans('publish_edit.Choose your Address') !!}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group required {{ $errors->has('ad_puslisher_name') ? ' has-error' : '' }}">
                        <label for="ad_puslisher_name" class="col-md-4 control-label">{{ trans('publish_edit.Contact Name') }}</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" id="ad_puslisher_name" name="ad_puslisher_name" value="{{ Util::getOldOrModelValue('ad_puslisher_name', $user, 'name') }}" />
                            @if ($errors->has('ad_puslisher_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('ad_puslisher_name') }}</strong>
                                </span>
                            @endif
                            @if(trans('publish_edit.Enter your name'))
                                <span class="help-block">
                                    {!! trans('publish_edit.Enter your name') !!}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group required {{ $errors->has('ad_email') ? ' has-error' : '' }}">
                        <label for="ad_email" class="col-md-4 control-label">{{ trans('publish_edit.E-Mail') }}</label>
                        <div class="col-md-5">
                            <input type="email" class="form-control" id="ad_email" name="ad_email" value="{{ Util::getOldOrModelValue('ad_email', $user, 'email') }}" />
                            @if ($errors->has('ad_email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('ad_email') }}</strong>
                                </span>
                            @endif
                            @if(trans('publish_edit.Enter contact mail'))
                                <span class="help-block">
                                    {!! trans('publish_edit.Enter contact mail') !!}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="ad_phone" class="col-md-4 control-label">{{ trans('publish_edit.Phone') }}</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" id="ad_phone" name="ad_phone" value="{{ Util::getOldOrModelValue('ad_phone', $user, 'user_phone') }}" >
                            @if(trans('publish_edit.Enter contact phone'))
                                <span class="help-block">
                                    {!! trans('publish_edit.Enter contact phone') !!}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="ad_skype" class="col-md-4 control-label">{{ trans('publish_edit.Skype') }}</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" id="ad_skype" name="ad_skype" value="{{ Util::getOldOrModelValue('ad_skype', $user, 'user_phone') }}" >
                            @if(trans('publish_edit.Enter contact skype'))
                                <span class="help-block">
                                    {!! trans('publish_edit.Enter contact skype') !!}
                                </span>
                            @endif
                        </div>
                    </div>

                    @if(config('dc.enable_link_in_ad'))
                    <div class="form-group">
                        <label for="ad_link" class="col-md-4 control-label">{{ trans('publish_edit.Web Site') }}</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" id="ad_link" name="ad_link" value="{{ Util::getOldOrModelValue('ad_link', $user, 'user_site') }}" >
                            @if(trans('publish_edit.Insert link to your site in this format: http://www.site.com'))
                                <span id="helpBlock" class="help-block">
                                    {{ trans('publish_edit.Insert link to your site in this format: http://www.site.com') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    @endif

                    @if(config('dc.enable_video_in_ad'))
                    <div class="form-group">
                        <label for="ad_video" class="col-md-4 control-label">{{ trans('publish_edit.Video') }}</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" id="ad_video" name="ad_video" value="{{ old('ad_video') }}" >
                            @if(trans('publish_edit.Insert link to youtube.com video'))
                                <span id="helpBlock" class="help-block">
                                    {{ trans('publish_edit.Insert link to youtube.com video') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    @endif

                    @if(config('dc.enable_promo_ads') && !$payment_methods->isEmpty())
                        <div class="form-group">
                            <label class="col-md-4 control-label">{{ trans('publish_edit.Choose Ad Promo Type') }}</label>

                            <div class="col-md-8">
                                <?
                                $checked = 0;
                                if($enable_pay_from_wallet){
                                    $checked = 1000;
                                }
                                if(old('ad_type_pay')){
                                    $checked = old('ad_type_pay');
                                }
                                ?>

                                <div class="radio">
                                    <label>
                                        <input type="radio" name="ad_type_pay" value="0" {{ (0 == $checked) ? 'checked' : '' }}> {{ trans('publish_edit.Free Ad') }}
                                    </label>
                                </div>

                                @if($enable_pay_from_wallet)
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="ad_type_pay" value="1000" {{ (1000 == $checked) ? 'checked' : '' }}> {{ trans('publish_edit.Pay promo ad from wallet', ['sum' => config('dc.wallet_promo_ad_price'), 'cur' => config('dc.site_price_sign'), 'period' => config('dc.wallet_promo_ad_period')]) }}
                                        </label>
                                    </div>
                                @endif

                                @foreach($payment_methods as $k => $v)
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="ad_type_pay" value="{{ $v->pay_id }}" {{ ($v->pay_id == $checked) ? 'checked' : '' }}> {{ trans('publish_edit.Pay promo ad payment method', ['sum' => number_format($v->pay_sum, 2, '.', ''), 'cur' => config('dc.site_price_sign'), 'period' => $v->pay_promo_period, 'pay_type' => $v->pay_name]) }}
                                        </label>
                                    </div>
                                @endforeach

                                @if(trans('publish_edit.Choose Ad Promo Type'))
                                    <span id="helpBlock" class="help-block">
                                        {{ trans('publish_edit.Choose Ad Promo Type') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="form-group required {{ $errors->has('policy_agree') ? ' has-error' : '' }}">
                        <label for="policy_agree" class="col-md-4 control-label"></label>
                        <div class="col-md-8">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="policy_agree" {{ old('policy_agree') ? 'checked' : '' }}> {{ trans('publish_edit.I agree with') }} <a href="{{ config('dc.privacy_policy_link') }}" target="_blank">{{ trans('publish_edit."Privacy Policy"') }}</a>
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
                            <button type="submit" class="btn btn-primary">{{ trans('publish_edit.Publish') }}</button>
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
                        <span class="glyphicon glyphicon glyphicon-search" aria-hidden="true"></span> {{ trans('publish_edit.Find on the map') }}
                    </button>
                    <button type="button" name="location_ok" id="location_ok" class="btn btn-success">
                        <span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> {{ trans('publish_edit.Yes, this is my location') }}
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