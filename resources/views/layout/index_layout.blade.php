<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>{{ config('dc.site_home_page_title') }}</title>
        
        <script src="{{ asset('js/pace/pace.min.js') }}"></script>
        <link href="{{ asset('js/pace/themes/red/pace-theme-minimal.css') }}" rel="stylesheet" />
        
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('js/chosen/chosen.css') }}" />
        <link rel="stylesheet" href="{{ asset('js/chosen/chosen-bootstrap.css') }}" />
        <link rel="stylesheet" href="{{ asset('js/bootstrap-multiselect/bootstrap-multiselect.css') }}" />
        
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
                    <a class="navbar-brand" href="{{ route('home') }}">{{ config('dc.site_logo_name') }}</a>
                </div>
        
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        @if(isset($headerMenu) && !$headerMenu->isEmpty())
                            @foreach($headerMenu as $k => $v)
                                <li><a href="{{ url('p/' . $v->page_slug) }}">{{ $v->page_title }}</a></li>
                            @endforeach
                        @endif
                        @if( Auth::check() && Auth::user()->isAdmin() )
                            <li><a href="{{ url('admin') }}">{{ trans('index_layout.admin_panel') }}</a></li>
                        @endif
                        @if( Auth::check() )
                            <li class="dropdown">
                               <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ trans('index_layout.my_profile') }} <span class="caret"></span></a>
                               <ul class="dropdown-menu">
                                   <li><a href="{{ url('myprofile') }}">{{ trans('index_layout.my_profile') }}</a></li>
                                   <li><a href="{{ url('myads') }}">{{ trans('index_layout.my_classifieds') }}</a></li>
                                   <li><a href="{{ url('mymail') }}">{{ trans('index_layout.my_messages') }}</a></li>
                                   <li role="separator" class="divider"></li>
                                   <li><a href="{{ url('logout') }}">{{ trans('index_layout.logout') }}</a></li>
                               </ul>
                            </li>
                        @else
                            <li>
                                <a href="{{ url('login') }}">My Profile</a>
                            </li>
                        @endif
                        <li>
                            <p class="navbar-btn" style="margin:0px;">
                                <a href="{{ route('publish') }}" class="btn btn-danger navbar-btn">{{ trans('index_layout.post_an_ad') }}</a>
                            </p>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        
        @yield('search_filter')
        
        @include('common.central_banner');
        
        @yield('content')
        
        <footer class="footer">
            <div class="container">
                <p class="text-muted">{{ trans('index_layout.copyright') }} &copy; {{ date('Y') }} <a href="{{ config('dc.site_url') }}">{{ config('dc.site_copyright_name') }}</a>
                @if(isset($footerMenu) && !$footerMenu->isEmpty())
                    @foreach($footerMenu as $k => $v)
                        | <a href="{{ url('p/' . $v->page_slug) }}">{{ $v->page_title }}</a>
                    @endforeach
                @endif
                {!! trans('index_layout.icons_credit')  !!}
            </div>
        </footer>
        
        <script>
            __AX_GET_CAR_MODELS = '{{ url('axgetcarmodels') }}';
            __ALL_CATEGORIES_TEXT = '{{ trans('index_layout.All Categories') }}';
            __ALL_LOCATIONS_TEXT = '{{ trans('index_layout.All Locations') }}';
            __NO_RESULTS_TEXT = '{{ trans('index_layout.No results') }}';
        </script>
    
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        
        <script src="{{ asset('js/chosen/chosen.jquery.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap-multiselect/bootstrap-multiselect.js') }}"></script>
        <script src="{{ asset('js/common.js') }}"></script>
        
        @yield('js')
        
    </body>
</html>