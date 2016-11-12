<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>@yield('title')</title>

        @section('header_tags')
            <meta name="revisit-after" content="1 Days" />
            <meta name="robots" content="index, follow" />
            <meta name="googlebot" content="index, follow" />
            <meta name="rating" content="general" />
        @show

        @if(config('dc.enable_rss'))
            <link rel="alternate"  type="application/rss+xml" href="{{ route('rss') }}" />
        @endif
        
        <script src="{{ asset('js/pace/pace.min.js') }}"></script>
        <link href="{{ asset('js/pace/themes/red/pace-theme-minimal.css') }}" rel="stylesheet" />
        
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">-->

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,400italic">
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

        {!! config('dc.head_scripts') !!}
    </head>
    <body>

        {!! config('dc.start_body_scripts') !!}

        <nav class="navbar navbar-default top_nav">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#dc-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ route('home') }}">
                        @if( !empty( config('dc.site_logo_img') ) )
                            <img src="{{ asset('uf/settings/' . config('dc.site_logo_img')) }}" style="height: 50px;" alt="{{ config('dc.site_logo_alt') }}">
                        @else
                            {{ config('dc.site_logo_name') }}
                        @endif
                    </a>
                </div>
        
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="dc-navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        @if(isset($headerMenu) && !$headerMenu->isEmpty())
                            @foreach($headerMenu as $k => $v)
                                <li><a href="{{ url('p/' . $v->page_slug) }}">{{ $v->page_title }}</a></li>
                            @endforeach
                        @endif
                        @if( Auth::check() && Auth::user()->isAdmin() )
                            <li><a href="{{ url('admin') }}">{{ trans('index_layout.admin_panel') }}</a></li>
                        @endif
                        <li><a href="{{ url('myfav') }}"><i class="fa fa-star" style="font-size:22px; color: #FFD700;"></i></a></li>
                        @if( Auth::check() )
                            <li class="dropdown">
                               <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                   @if(!empty(Auth::user()->avatar))
                                        <img src="{{ asset('uf/udata/100_' . Auth::user()->avatar) }}" class="user-image">
                                   @else
                                        <img src="{{ 'https://www.gravatar.com/avatar/' . md5(trim(Auth::user()->email)) . '?s=100&d=identicon' }}" class="user-image">
                                   @endif
                                   {{ Auth::user()->name }} <span class="caret"></span></a>
                               <ul class="dropdown-menu">
                                   <li><a href="{{ url('myprofile') }}">{{ trans('index_layout.my_profile') }}</a></li>
                                   <li><a href="{{ url('myads') }}">{{ trans('index_layout.my_classifieds') }}</a></li>
                                   @if(config('dc.enable_promo_ads'))
                                       <li><a href="{{ url('mywallet') }}">{{ trans('index_layout.my_wallet') }}</a></li>
                                   @endif
                                   <li><a href="{{ url('mymail') }}">{{ trans('index_layout.my_messages') }}</a></li>
                                   <li role="separator" class="divider"></li>
                                   <li><a href="{{ url('logout') }}">{{ trans('index_layout.logout') }}</a></li>
                               </ul>
                            </li>
                        @else
                            <li>
                                <a href="{{ url('login') }}">{{ trans('index_layout.My Profile') }}</a>
                            </li>
                        @endif
                        <li>
                            <p class="navbar-btn btn_publish">
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
                <p class="text-muted">{{ trans('index_layout.copyright') }} &copy; {{ date('Y') }} <a href="{{ config('dc.site_url') }}">{{ config('dc.site_copyright_name') }}</a> {{ trans('index_layout.All rights reserved.') }}
                | <a href="{{ route('contact') }}">{{ trans('index_layout.Contact') }}</a>
                @if(isset($footerMenu) && !$footerMenu->isEmpty())
                    @foreach($footerMenu as $k => $v)
                        | <a href="{{ url('p/' . $v->page_slug) }}">{{ $v->page_title }}</a>
                    @endforeach
                @endif
                </p>
                {!! config('dc.footer_html')  !!}
            </div>
        </footer>
        
        <script>
            __AX_GET_CAR_MODELS = '{{ url('axgetcarmodels') }}';
            __AX_GET_CATEGORY = '{{ url('axgetcategory') }}';
            __AX_GET_LOCATION = '{{ url('axgetlocation') }}';
            __ALL_CATEGORIES_TEXT = '{{ trans('index_layout.All Categories') }}';
            __ALL_LOCATIONS_TEXT = '{{ trans('index_layout.All Locations') }}';
            __NO_RESULTS_TEXT = '{{ trans('index_layout.No results') }}';
            __START = '{{ trans('publish_edit.Start') }}';
        </script>
    
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        
        <script src="{{ asset('js/chosen/chosen.jquery.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap-multiselect/bootstrap-multiselect.js') }}"></script>
        <script src="{{ asset('js/jquery.matchHeight-min.js') }}"></script>
        <script src="{{ asset('js/common.js') }}"></script>
        
        @yield('js')

        {!! config('dc.end_body_scripts') !!}
        
    </body>
</html>