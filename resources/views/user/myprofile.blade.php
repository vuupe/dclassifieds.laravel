@extends('layout.index_layout')

@section('content')
		<div class="container">
        	<div class="row">
            	<div class="col-md-12">
                    <ol class="breadcrumb">
                    	  <li><a href="{{ route('home') }}">Home</a></li>
                          <li class="active">My Profile</li>
                    </ol>
                </div>
            </div>
        </div>
        
        <div class="container">
        	<div class="row">
            	<div class="col-md-12">
                    <ul class="nav nav-pills">
                      <li role="presentation" class="active"><a href="{{ url('myprofile') }}">My Profile</a></li>
                      <li role="presentation"><a href="{{ url('myads') }}">My Classifieds</a></li>
                      <li role="presentation"><a href="{{ url('mymail') }}">My Messages</a></li>
                    </ul>
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
                    	<div class="row">
                            <div class="col-md-offset-4 col-md-8">
                                <h2>My Profile</h2>
                            </div>
                        </div>
                    
                        <div class="form-group required {{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>
                            <div class="col-md-5">
                            	<input type="text" class="form-control" id="name" name="name" value="{{ Util::getOldOrModelValue('name', $user) }}" maxlength="255"/>
                            	
                            	@if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group required {{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail</label>
                            <div class="col-md-5">
                            	<input type="text" class="form-control" id="email" name="email" value="{{ Util::getOldOrModelValue('email', $user) }}" maxlength="255" readonly/>
                            	
                            	@if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group {{ $errors->has('avatar_img') ? ' has-error' : '' }}">
                        	<label for="avatar_img" class="col-md-4 control-label">Avatar</label>
                            <div class="col-md-5">
                                <input type="file" name="avatar_img">
                                @if ($errors->has('avatar_img'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('avatar_img') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>                        
                        
                        <hr>
                        
                        <div class="row">
                            <div class="col-md-offset-2 col-md-8">
                                <h4>If you want to change your password, type new one, if not leave blank</h4>
                            </div>
                        </div>
                        
                        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>
                            <div class="col-md-5">
                            	<input type="password" class="form-control" id="password" name="password" value="{{ Util::getOldOrModelValue('password', $user) }}" maxlength="255" />
                            	
                            	@if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password Again</label>
                            <div class="col-md-5">
                            	<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value="{{ Util::getOldOrModelValue('password_confirmation', $user) }}" maxlength="255" />
                            	
                            	@if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="form-group">
                            <div class="col-md-offset-4 col-md-8">
                            	<button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
@endsection