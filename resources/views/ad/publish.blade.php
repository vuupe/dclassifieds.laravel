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
                	
                	@include('common.errors')
                	@if (session()->has('message'))
					    <div class="alert alert-info">{{ session('message') }}</div>
					@endif
                
                    <form class="form-horizontal" method="POST" enctype="multipart/form-data">
                    
                    	{!! csrf_field() !!}
                    
                    	<div class="row">
                            <div class="col-md-offset-2 col-md-10">
                                <h2>Post an ad</h2>
                            </div>
                        </div>
                    
                        <div class="form-group">
                            <label for="ad_title" class="col-md-2 control-label">Ad Title</label>
                            <div class="col-md-5">
                            	<input type="text" class="form-control" id="ad_title" name="ad_title" value="{{ old('ad_title') }}" />
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="category_id" class="col-md-2 control-label">Category</label>
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
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ad_description" class="col-md-2 control-label">Ad Description</label>
                            <div class="col-md-5">
                            	<textarea class="form-control" name="ad_description" id="ad_description">{{ old('ad_description') }}</textarea>
                            </div>
                        </div>
                        
                        <div class="form-group">
                        	<label for="ad_image" class="col-md-2 control-label">Pics</label>
                            <div class="col-md-5">
                            	<?for($i = 1; $i < 6; $i++){?>
                                <input type="file" name="ad_image[]">
                                <?}//end of for?>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="location_id" class="col-md-2 control-label">Location</label>
                            <div class="col-md-5">
                            	@if(isset($l) && !empty($l))
		                   		<select name="location_id" id="location_id" class="form-control lid_select">
		                   			<option value="0"></option>
		                   			@foreach ($l as $k => $v)
		                   				<optgroup label="{{$v['title']}}">
		                   					@if(isset($v['c']) && !empty($v['c'])){
		                   						@include('common.lselect', ['c' => $v['c'], 'lid' => old('location_id')])
		                   					@endif
		                   				</optgroup>
		                   			@endforeach
		                   		</select>
		                   		@endif
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ad_puslisher_name" class="col-md-2 control-label">Contact Name</label>
                            <div class="col-md-5">
                            	<input type="text" class="form-control" id="ad_puslisher_name" name="ad_puslisher_name" value="{{ old('ad_puslisher_name') }}" />
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ad_email" class="col-md-2 control-label">E-Mail</label>
                            <div class="col-md-5">
                            	<input type="email" class="form-control" id="ad_email" name="ad_email" value="{{ old('ad_email') }}" />
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ad_phone" class="col-md-2 control-label">Phone</label>
                            <div class="col-md-5">
                            	<input type="text" class="form-control" id="ad_phone" name="ad_phone" value="{{ old('ad_phone') }}" >
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ad_skype" class="col-md-2 control-label">Skype</label>
                            <div class="col-md-5">
                            	<input type="text" class="form-control" id="ad_skype" name="ad_skype" value="{{ old('ad_skype') }}" >
                            </div>
                        </div>

                        
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-10">
                            <div class="checkbox">
                            <label>
                            	<input type="checkbox" name="policy_agree" {{ old('policy_agree') ? 'checked' : '' }}> I agree with <a href="">"Privacy Policy"</a>
                            </label>
                            </div>
                            </div>
                        </div>
                        
                        
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-10">
                            	<button type="submit" class="btn btn-primary">Publish</button>
                            </div>
                        </div>
                    </form>
                
                
                
                
                
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

