<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>dclassifieds html template</title>
        
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">-->
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('js/chosen/chosen.css') }}" />
        <link rel="stylesheet" href="{{ asset('js/chosen/chosen-bootstrap.css') }}" />
        
        @yield('styles')
        
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
    
    
    	<div id="fb-root"></div>
		<script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
    
    	
        <nav class="navbar navbar-default top_nav">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ route('home') }}">DClassifieds</a>
                </div>
        
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                       	<?if (Auth::check()){?>
                        	<li class="dropdown">
	                        	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Profile <span class="caret"></span></a>
	                            
	                            <ul class="dropdown-menu">
	                                <li><a href="{{ url('profile') }}">My Profile</a></li>
	                                <li><a href="{{ url('myads') }}">My Classifieds</a></li>
	                                <li role="separator" class="divider"></li>
	                                <li><a href="{{ url('logout') }}">Exit</a></li>
	                            </ul>
	                            
	                        </li>
                        	
                        <?} else {?>
	                        <li>
	                        	<a href="{{ url('login') }}">My Profile</a>
	                        </li>
                        <?}?>	
                        <li>
                        	<p class="navbar-btn" style="margin:0px;">
                        		<?if (Auth::check()){?>
                        			<a href="{{ route('publish') }}" class="btn btn-danger navbar-btn">Post an ad</a>
                        		<?} else {?>
                        			<a href="{{ url('login') }}" class="btn btn-danger navbar-btn">Post an ad</a>
                        		<?}?>
                        	</p>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        
        @yield('search_filter')
        
        <div class="container centar_banner_728">
        	<div class="row">
            	<div class="col-md-12">
            		<a href=""><img src="{{ asset('images/728x90.png') }}" class="center-block img-responsive"></a>
                </div>
            </div>
        </div>
        
        @yield('content')
        
        <footer class="footer">
            <div class="container">
                <p class="text-muted">Copyright &copy; {{ date('Y') }} <a href="http://www.dclassifieds.eu">DClassifieds</a> | <a href="">About</a> | <a href="">Privacy Policy</a></p>
                <div>Icons made by <a href="http://www.flaticon.com/authors/situ-herrera" title="Situ Herrera">Situ Herrera</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a>             is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a></div>
            </div>
        </footer>
        
        <script>
        	__AX_GET_CAR_MODELS = '<?=url('axgetcarmodels');?>';
        </script>
    
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        
        <script src="{{ asset('js/chosen/chosen.jquery.min.js') }}"></script>
        <script src="{{ asset('js/common.js') }}"></script>
        
        @yield('js')
        
    </body>
</html>