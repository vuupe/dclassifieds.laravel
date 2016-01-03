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
                
                
                    <form class="form-horizontal">
                    
                    	<div class="row">
                            <div class="col-md-offset-2 col-md-10">
                                <h2>Post an ad</h2>
                            </div>
                        </div>
                    
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-2 control-label">Ad Title</label>
                            <div class="col-md-5">
                            	<input type="text" class="form-control" id="inputEmail3" >
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-2 control-label">Category</label>
                            <div class="col-md-5">
                            	<select class="form-control"><option>Fashion</option></select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-2 control-label">Ad Description</label>
                            <div class="col-md-5">
                            	<textarea class="form-control"></textarea>
                            </div>
                        </div>
                        
                        <div class="form-group">
                        	<label for="exampleInputFile" class="col-md-2 control-label">Pics</label>
                            <div class="col-md-5">
                                <input type="file" id="exampleInputFile1">
                                <input type="file" id="exampleInputFile2">
                                <input type="file" id="exampleInputFile3">
                                <input type="file" id="exampleInputFile4">
                                <input type="file" id="exampleInputFile5">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-2 control-label">Contact Name</label>
                            <div class="col-md-5">
                            	<input type="text" class="form-control" id="inputEmail3">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-2 control-label">E-Mail</label>
                            <div class="col-md-5">
                            	<input type="email" class="form-control" id="inputEmail3" >
                            </div>
                        </div>

                        
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-10">
                            <div class="checkbox">
                            <label>
                            <input type="checkbox"> I agree with <a href="">"Privacy Policy"</a>
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

