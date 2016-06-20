@extends('layout.index_layout')

@section('content')
		<div class="container">
        	<div class="row">
            	<div class="col-md-12">
                    <ol class="breadcrumb">
                    	  <li><a href="{{ route('home') }}">Home</a></li>
                          <li class="active">My Messages</li>
                    </ol>
                </div>
            </div>
        </div>
        
        <div class="container">
        	<div class="row">
            	<div class="col-md-12">
                    <ul class="nav nav-pills">
                      <li role="presentation"><a href="{{ url('myprofile') }}">My Profile</a></li>
                      <li role="presentation"><a href="{{ url('myads') }}">My Classifieds</a></li>
                      <li role="presentation" class="active"><a href="{{ url('mymail') }}">My Messages</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        
        <div class="container margin_bottom_15">
        	<div class="row">
            	<div class="col-md-12">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h2>My Messages ({{ $mailList->count() }})</h2>
                        </div>
                    </div>
                
                    <?if(!$mailList->isEmpty()){?>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Mail #</th>
                                        <th>Ad #</th>
                                        <th>Date</th>
                                        <th>From</th>
                                        <th>Text</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?foreach($mailList as $k => $v){?>
                                    <?$link = route('mailview', ['hash' => $v->mail_hash, 'user_id_from' => $v->user_id_from, 'mail_id' => $v->ad_id]);?>
                                    <tr>
                                        <td>{{ $v->mail_id }}</td>
                                        <td>{{ $v->ad_id }}</td>
                                        <td>{{ $v->mail_date }}</td>
                                        <td>{{ $v->name }}</td>
                                        <td><a href="{{ $link }}">{{ str_limit($v->mail_text, 60) }}</a></td>
                                        <td>{{ $v->mail_status == 0 ? 'New' : ''}}</td>
                                        <td nowrap>
                                            <a href="{{ $link }}" class="btn btn-primary btn-block btn-sm">View</a> 
                                        </td>
                                    </tr>
                                <?}//end of foreach?>
                                </tbody>
                            </table>
                        </div>
                    <?} else {?>
                        <div class="alert alert-info">You dont't have messages.</div>
                    <?}?>
                    
                </div>
            </div>
        </div>
@endsection