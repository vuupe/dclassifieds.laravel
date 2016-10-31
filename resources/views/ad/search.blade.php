@extends('layout.index_layout')

@section('title', join(' / ', $title))

@section('search_filter')
    <div class="search_panel">
        <div class="container">
            <form method="GET" action="{{ url('proxy') }}" class="form" id="search_form">
                <div class="row row_equal_height">
                    {!! csrf_field() !!}
                    <div class="col-md-3 padding_bottom_15">
                        <input type="text" name="search_text" id="search_text" class="form-control" placeholder="{{ trans('search.1 000 000 Ads') }}" value="{{ isset($params['search_text']) ? stripslashes($params['search_text']) : ''}}"/>
                    </div>

                    <div class="col-md-3 padding_bottom_15">
                        @if(isset($c) && !empty($c))
                        <select name="cid" id="cid" class="form-control cid_select" onchange="$('#search_form').submit();">
                            <option value="0"></option>
                            @foreach ($c as $k => $v)
                                @if(isset($cid) && $cid == $v['cid'])
                                    <option value="{{$v['cid']}}" style="font-weight: bold;" selected data-type="{{ $v['category_type'] }}">{{$v['title']}}</option>
                                @else
                                    <option value="{{$v['cid']}}" style="font-weight: bold;" data-type="{{ $v['category_type'] }}">{{$v['title']}}</option>
                                @endif
                                @if(isset($v['c']) && !empty($v['c'])){
                                    @include('common.cselect', ['c' => $v['c']])
                                @endif
                            @endforeach
                        </select>
                        @endif
                    </div>

                    <div class="col-md-3 padding_bottom_15">
                        @if(isset($l) && !empty($l))
                        <select name="lid" id="lid" class="form-control lid_select">
                            <option value="0"></option>
                            @foreach ($l as $k => $v)
                                @if(isset($lid) && $lid == $v['lid'])
                                    <option value="{{$v['lid']}}" style="font-weight: bold;" selected>{{$v['title']}}</option>
                                @else
                                    <option value="{{$v['lid']}}" style="font-weight: bold;">{{$v['title']}}</option>
                                @endif
                                @if(isset($v['c']) && !empty($v['c'])){
                                    @include('common.lselect', ['c' => $v['c']])
                                @endif
                            @endforeach
                        </select>
                        @endif
                    </div>

                    <div class="col-md-3 padding_bottom_15">
                        @if(!$ac->isEmpty())
                        <select name="condition_id[]" id="condition_id" class="form-control multi_select" data-placeholder="{{ trans('search.Condition') }}" multiple="multiple">
                            @foreach ($ac as $k => $v)
                                @if(in_array($v->ad_condition_id, old('condition_id', [])))
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
                        <select name="type_id[]" id="type_id" class="form-control multi_select" data-placeholder="{{ trans('search.Private/Business Ad') }}" multiple="multiple">
                            @foreach ($at as $k => $v)
                                @if(in_array($v->ad_type_id, old('type_id', [])))
                                    <option value="{{ $v->ad_type_id }}" selected>{{ $v->ad_type_name }}</option>
                                @else
                                    <option value="{{ $v->ad_type_id }}">{{ $v->ad_type_name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @endif
                    </div>

                    <div class="col-md-3 padding_bottom_15">
                        <input type="text" name="price_from" id="price_from" class="form-control" placeholder="{{ trans('search.Price from') }}" value="{{ old('price_from') }}"/>
                    </div>

                    <div class="col-md-3 padding_bottom_15">
                        <input type="text" name="price_to" id="price_to" class="form-control" placeholder="{{ trans('search.Price to') }}" value="{{ old('price_to') }}"/>
                    </div>

                    <div class="col-md-3 padding_bottom_15">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="price_free" id="price_free" {{ !empty(old('price_free')) ? 'checked' : ''}} value="1"> {{ trans('search.Free') }}
                            </label>
                        </div>
                    </div>

                    @if(isset($selected_category_info) && !empty($selected_category_info))
                        @if($selected_category_info['category_type'] == 2)
                            <div class="col-md-3 padding_bottom_15">
                                @if(!$estate_type->isEmpty())
                                <select name="estate_type_id[]" id="estate_type_id" class="form-control multi_select" data-placeholder="{{ trans('search.Estate Type') }}" multiple="multiple">
                                    @foreach ($estate_type as $k => $v)
                                        @if(in_array($v->estate_type_id, old('estate_type_id', [])))
                                            <option value="{{ $v->estate_type_id }}" selected>{{ $v->estate_type_name }}</option>
                                        @else
                                            <option value="{{ $v->estate_type_id }}">{{ $v->estate_type_name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @endif
                            </div>

                            <div class="col-md-3 padding_bottom_15">
                                <input type="text" class="form-control" id="estate_sq_m_from" name="estate_sq_m_from" value="{{ old('estate_sq_m_from') }}" placeholder="{{ trans('search.Estate sq. m. from') }}" />
                            </div>

                            <div class="col-md-3 padding_bottom_15">
                                <input type="text" class="form-control" id="estate_sq_m_to" name="estate_sq_m_to" value="{{ old('estate_sq_m_to') }}" placeholder="{{ trans('search.Estate sq. m. to') }}" />
                            </div>

                            <div class="col-md-3 padding_bottom_15">
                                <input type="text" class="form-control" id="estate_year_from" name="estate_year_from" value="{{ old('estate_year_from') }}" placeholder="{{ trans('search.Estate year of construction from') }}" />
                            </div>

                            <div class="col-md-3 padding_bottom_15">
                                <input type="text" class="form-control" id="estate_year_to" name="estate_year_to" value="{{ old('estate_year_to') }}" placeholder="{{ trans('search.Estate year of construction to') }}" />
                            </div>

                            <div class="col-md-3 padding_bottom_15">
                                @if(!$estate_construction_type->isEmpty())
                                <select name="estate_construction_type_id[]" id="estate_construction_type_id" class="form-control multi_select" data-placeholder="{{ trans('search.Estate Construction Type') }}" multiple="multiple">
                                    @foreach ($estate_construction_type as $k => $v)
                                        @if(in_array($v->estate_construction_type_id, old('estate_construction_type_id', [])))
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
                                <select name="estate_heating_type_id[]" id="estate_heating_type_id" class="form-control multi_select" data-placeholder="{{ trans('search.Estate Heating') }}" multiple="multiple">
                                    @foreach ($estate_heating_type as $k => $v)
                                        @if(in_array($v->estate_heating_type_id, old('estate_heating_type_id', [])))
                                            <option value="{{ $v->estate_heating_type_id }}" selected>{{ $v->estate_heating_type_name }}</option>
                                        @else
                                            <option value="{{ $v->estate_heating_type_id }}">{{ $v->estate_heating_type_name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @endif
                            </div>

                            <div class="col-md-3 padding_bottom_15">
                                <input type="text" class="form-control" id="estate_floor_from" name="estate_floor_from" value="{{ old('estate_floor_from') }}" placeholder="{{ trans('search.Estate floor from') }}" />
                            </div>

                            <div class="col-md-3 padding_bottom_15">
                                <input type="text" class="form-control" id="estate_floor_to" name="estate_floor_to" value="{{ old('estate_floor_to') }}" placeholder="{{ trans('search.Estate floor to') }}" />
                            </div>

                            <div class="col-md-3 padding_bottom_15">
                                <input type="text" class="form-control" id="estate_num_floors_in_building" name="estate_num_floors_in_building" value="{{ old('estate_num_floors_in_building') }}" placeholder="{{ trans('search.Num Floors in Building') }}" />
                            </div>

                            <div class="col-md-3 padding_bottom_15">
                                @if(!$estate_furnishing_type->isEmpty())
                                <select name="estate_furnishing_type_id[]" id="estate_furnishing_type_id" class="form-control multi_select" data-placeholder="{{ trans('search.Estate Furnishing') }}" multiple="multiple">
                                    @foreach ($estate_furnishing_type as $k => $v)
                                        @if(in_array($v->estate_furnishing_type_id, old('estate_furnishing_type_id', [])))
                                            <option value="{{ $v->estate_furnishing_type_id }}" selected>{{ $v->estate_furnishing_type_name }}</option>
                                        @else
                                            <option value="{{ $v->estate_furnishing_type_id }}">{{ $v->estate_furnishing_type_name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @endif
                            </div>
                        @endif

                        @if($selected_category_info['category_type'] == 3)
                            <div class="col-md-3 padding_bottom_15">
                                @if(!$car_engine->isEmpty())
                                <select name="car_engine_id[]" id="car_engine_id" class="form-control multi_select" data-placeholder="{{ trans('search.Car Engine') }}" multiple="multiple">
                                    @foreach ($car_engine as $k => $v)
                                        @if(in_array($v->car_engine_id, old('car_engine_id', [])))
                                            <option value="{{ $v->car_engine_id }}" selected>{{ $v->car_engine_name }}</option>
                                        @else
                                            <option value="{{ $v->car_engine_id }}">{{ $v->car_engine_name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @endif
                            </div>

                            <div class="col-md-3 padding_bottom_15">
                                @if(!$car_brand->isEmpty())
                                <select name="car_brand_id" id="car_brand_id" class="form-control chosen_select" data-placeholder="{{ trans('search.Car Brand') }}">
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
                            </div>

                            <div class="col-md-3 padding_bottom_15">
                                <div id="car_model_loader"><img src="{{ asset('images/small_loader.gif') }}" /></div>
                                @if(isset($car_model) && !empty($car_model))
                                    <select name="car_model_id" id="car_model_id" class="form-control chosen_select" data-placeholder="{{ trans('search.Car Model') }}">
                                        @foreach ($car_model as $k => $v)
                                            @if(old('car_model_id') == $k)
                                                <option value="{{ $k }}" selected>{{ $v }}</option>
                                            @else
                                                <option value="{{ $k }}">{{ $v }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                @else
                                    <select name="car_model_id" id="car_model_id" class="form-control chosen_select" data-placeholder="{{ trans('search.Car Model') }}" disabled>
                                        <option value="0"></option>
                                    </select>
                                @endif
                            </div>

                            <div class="col-md-3 padding_bottom_15">
                                @if(!$car_transmission->isEmpty())
                                <select name="car_transmission_id[]" id="car_transmission_id" class="form-control multi_select" data-placeholder="{{ trans('search.Car Tranmission') }}" multiple="multiple">
                                    @foreach ($car_transmission as $k => $v)
                                        @if(in_array($v->car_transmission_id, old('car_transmission_id', [])))
                                            <option value="{{ $v->car_transmission_id }}" selected>{{ $v->car_transmission_name }}</option>
                                        @else
                                            <option value="{{ $v->car_transmission_id }}">{{ $v->car_transmission_name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @endif
                            </div>

                            <div class="col-md-3 padding_bottom_15">
                                @if(!$car_modification->isEmpty())
                                <select name="car_modification_id[]" id="car_modification_id" class="form-control multi_select" data-placeholder="{{ trans('search.Car Modification') }}" multiple="multiple">
                                    @foreach ($car_modification as $k => $v)
                                        @if(in_array($v->car_modification_id, old('car_modification_id', [])))
                                            <option value="{{ $v->car_modification_id }}" selected>{{ $v->car_modification_name }}</option>
                                        @else
                                            <option value="{{ $v->car_modification_id }}">{{ $v->car_modification_name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @endif
                            </div>

                            <div class="col-md-3 padding_bottom_15">
                                <input type="text" class="form-control" id="car_year_from" name="car_year_from" value="{{ old('car_year_from') }}" placeholder="{{ trans('search.Car Year From') }}" />
                            </div>

                            <div class="col-md-3 padding_bottom_15">
                                <input type="text" class="form-control" id="car_year_to" name="car_year_to" value="{{ old('car_year_to') }}" placeholder="{{ trans('search.Car Year To') }}" />
                            </div>

                            <div class="col-md-3 padding_bottom_15">
                                <input type="text" class="form-control" id="car_kilometeres_from" name="car_kilometeres_from" value="{{ old('car_kilometeres_from') }}" placeholder="{{ trans('search.Car Kilometeres From') }}" />
                            </div>

                            <div class="col-md-3 padding_bottom_15">
                                <input type="text" class="form-control" id="car_kilometeres_to" name="car_kilometeres_to" value="{{ old('car_kilometeres_to') }}" placeholder="{{ trans('search.Car Kilometeres To') }}" />
                            </div>

                            <div class="col-md-3 padding_bottom_15">
                                @if(!$car_condition->isEmpty())
                                <select name="car_condition_id[]" id="car_condition_id" class="form-control multi_select" data-placeholder="{{ trans('search.Car Condition') }}" multiple="multiple">
                                    @foreach ($car_condition as $k => $v)
                                        @if(in_array($v->car_condition_id, old('car_condition_id', [])))
                                            <option value="{{ $v->car_condition_id }}" selected>{{ $v->car_condition_name }}</option>
                                        @else
                                            <option value="{{ $v->car_condition_id }}">{{ $v->car_condition_name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @endif
                            </div>
                        @endif

                        @if($selected_category_info['category_type'] == 5)
                            <div class="col-md-3 padding_bottom_15">
                                @if(!$clothes_sizes->isEmpty())
                                <select name="clothes_size_id[]" id="clothes_size_id" class="form-control multi_select" data-placeholder="{{ trans('search.Select Clothes Sizes') }}" multiple="multiple">
                                    @foreach ($clothes_sizes as $k => $v)
                                        @if(in_array($v->clothes_size_id, old('clothes_size_id', [])))
                                            <option value="{{ $v->clothes_size_id }}" selected>{{ $v->clothes_size_name }}</option>
                                        @else
                                            <option value="{{ $v->clothes_size_id }}">{{ $v->clothes_size_name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @endif
                            </div>
                        @endif

                        @if($selected_category_info['category_type'] == 6)
                            <div class="col-md-3 padding_bottom_15">
                                @if(!$shoes_sizes->isEmpty())
                                <select name="shoes_size_id[]" id="shoes_size_id" class="form-control multi_select" data-placeholder="{{ trans('search.Select Shoes Sizes') }}" multiple="multiple">
                                    @foreach ($shoes_sizes as $k => $v)
                                        @if(in_array($v->shoes_size_id, old('shoes_size_id', [])))
                                            <option value="{{ $v->shoes_size_id }}" selected>{{ $v->shoes_size_name }}</option>
                                        @else
                                            <option value="{{ $v->shoes_size_id }}">{{ $v->shoes_size_name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @endif
                            </div>
                        @endif

                        @if($selected_category_info['category_type'] == 7)
                            <div class="col-md-3 padding_bottom_15">
                                <input type="text" class="form-control" id="estate_sq_m_from" name="estate_sq_m_from" value="{{ old('estate_sq_m_from') }}" placeholder="{{ trans('search.Estate sq. m. from') }}" />
                            </div>

                            <div class="col-md-3 padding_bottom_15">
                                <input type="text" class="form-control" id="estate_sq_m_to" name="estate_sq_m_to" value="{{ old('estate_sq_m_to') }}" placeholder="{{ trans('search.Estate sq. m. to') }}" />
                            </div>
                        @endif
                    @endif

                    <div class="col-md-3 pull-right padding_bottom_15" style="margin-left:auto;">
                        <button type="submit" class="btn btn-primary" style="width: 100%;">
                            <span class="glyphicon glyphicon glyphicon-search" aria-hidden="true"></span> {{ trans('search.Search') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> {{ trans('search.Home') }}</a></li>
                    @if(isset($breadcrump['c']) && !empty($breadcrump['c']))
                        @foreach ($breadcrump['c'] as $k => $v)
                            <li><a href="{{ $v['category_url'] }}">{{ $v['category_title'] }}</a></li>
                        @endforeach
                    @endif
                </ol>
            </div>
        </div>
    </div>

    @if(isset($first_level_childs) && !$first_level_childs->isEmpty())
        <div class="container category_panel">
            <div class="row">
                @foreach ($first_level_childs as $k => $v)
                    <div class="col-md-3 padding_top_bottom_15"><a href="{{ $v->category_url }}">{{ $v->category_title }}</a></div>
                @endforeach
            </div>
        </div>
    @endif

    @if(isset($promo_ad_list) && !$promo_ad_list->isEmpty() && !$show_only_promo)
        <div class="container home_promo_ads_panel">
            <div class="row margin_bottom_15">
                <div class="col-md-12">
                    <h3>{{ trans('search.Promo Classifieds') }}</h3>
                </div>
            </div>

            <!-- ad row-->
            <div class="row margin_bottom_15">
                @foreach ($promo_ad_list as $k => $v)
                    @if(config('dc.show_small_item_ads_list'))
                        @include('common.ad_list_small')
                    @else
                        @include('common.ad_list')
                    @endif
                @endforeach
            </div>
            <!--end of ad row -->
        </div>
    @endif

    <div class="container home_promo_ads_panel">
        <div class="row margin_bottom_15">
            <div class="col-md-12">
                @if(!$show_only_promo)
                    <h3>{{ trans('search.Latest Classifieds') }}</h3>
                    <a href="{{ url('publish') }}">{{ trans('search.pusblish an ad') }}</a>
                @else
                    <h3>{{ trans('search.Promo Classifieds') }}</h3>
                @endif
            </div>
        </div>

        <!-- ad row-->
        <div class="row margin_bottom_15">
            @if(isset($ad_list) && !$ad_list->isEmpty())
                @foreach ($ad_list as $k => $v)
                    @if(config('dc.show_small_item_ads_list'))
                        @include('common.ad_list_small')
                    @else
                        @include('common.ad_list')
                    @endif
                @endforeach
            @else
                <div class="col-md-12">
                    <h3>{{ trans('search.No results found...') }}</h3>
                </div>
            @endif
        </div>
        <!--end of ad row -->
    </div>

    @if(isset($ad_list) && !$ad_list->isEmpty())
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav>{{  $ad_list->appends($params)->links() }}</nav>
            </div>
        </div>
    </div>
    @endif
@endsection