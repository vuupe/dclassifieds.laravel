@extends('layout.index_layout')
@section('content')
        <div class="container">
        	<div class="row">
            	<div class="col-md-12">
                    <ol class="breadcrumb">
                    	  <li><a href="#">Home</a></li>
                          <li class="active">My Classifieds</li>
                    </ol>
                </div>
            </div>
        </div>
        
        <div class="container">
        	<div class="row">
            	<div class="col-md-12">
                    <ul class="nav nav-pills">
                      <li role="presentation"><a href="{{ url('myprofile') }}">My Profile</a></li>
                      <li role="presentation" class="active"><a href="{{ url('myads') }}">My Classifieds</a></li>
                      <li role="presentation"><a href="{{ url('mymail') }}">My Messages</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        
        <div class="container margin_bottom_15">
        	<div class="row">
            	<div class="col-md-12">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h2>My Classifieds ({{ $my_ad_list->count() }})</h2>
                        </div>
                    </div>
                
                    <?if(!$my_ad_list->isEmpty()){?>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th style="max-width: 100px;">Image</th>
                                        <th>Title</th>
                                        <th>Views</th>
                                        <th>Price</th>
                                        <th>Promo</th>
                                        <th>Publish date</th>
                                        <th>Expire date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?foreach($my_ad_list as $k => $v){?>
                                    <?$link = url(str_slug($v->ad_title) . '-' . 'ad' . $v->ad_id . '.html');?>
                                    <tr>
                                        <td>{{ $v->ad_id }}</td>
                                        <td style="max-width: 100px;">
                                            <a href="{{ $link }}" target="_blank"><img src="<?=asset('uf/adata/' . '740_' . $v->ad_pic);?>" class="img-responsive" /></a>
                                        </td>
                                        <td><a href="{{ $link }}" target="_blank">{{ $v->ad_title }}</a></td>
                                        <td>{{ $v->ad_view }}</td>
                                        <td><?=$v->ad_price ? Util::formatPrice($v->ad_price) . '&euro;' : 'Free'?></td>
                                        <td>{!! $v->ad_promo ? '<span style="color:#CFB53B; font-weight:bold;">Promo</span>' : '' !!}</td>
                                        <td>{{ $v->ad_publish_date }}</td>
                                        <td>{!! date('Y-m-d') > $v->ad_valid_until ? '<span style="color:red; font-weight:bold;">Expired</span>' : $v->ad_valid_until !!}</td>
                                        <td nowrap>
                                            <a href="" class="btn btn-warning btn-block btn-sm">Make Promo</a> 
                                            <a href="{{ route('republish', ['token' => $v->code]) }}" class="btn btn-success btn-block btn-sm">Republish</a> 
                                            <a href="{{ route('adedit', array('id' => $v->ad_id)) }}" class="btn btn-primary btn-block btn-sm">Edit</a> 
                                            <a href="{{ route('delete', ['token' => $v->code]) }}" class="btn btn-danger btn-block need_confirm btn-sm">Delete</a> 
                                        </td>
                                    </tr>
                                <?}//end of foreach?>
                                </tbody>
                            </table>
                        </div>
                    <?} else {?>
                        <div class="alert alert-info">You dont't have classifieds. <a href="{{ url('publish') }}">Click here to publish.</a></div>
                    <?}?>
                    
                </div>
            </div>
        </div>
@endsection        
