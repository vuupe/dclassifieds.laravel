<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{  strip_tags(config('dc.admin_logo_name')) }} {{ trans('admin_common.Admin') }}</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="{{ asset('adminlte/bootstrap/css/bootstrap.min.css') }}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

        @yield('styles')

        <link rel="stylesheet" href="{{ asset('adminlte/dist/css/AdminLTE.min.css') }}">
        <link rel="stylesheet" href="{{ asset('adminlte/dist/css/skins/skin-' . config('dc.admin_skin') . '.min.css') }}">
        <link rel="stylesheet" href="{{ asset('adminlte/style.css') }}">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="hold-transition skin-{{ config('dc.admin_skin') }} sidebar-mini">
        <div class="wrapper">
            <!-- Main Header -->
            <header class="main-header">
                <!-- Logo -->
                <a href="{{ url('admin') }}" class="logo">
                  <!-- mini logo for sidebar mini 50x50 pixels -->
                  <span class="logo-mini">{!! config('dc.admin_short_logo_name') !!}</span>
                  <!-- logo for regular state and mobile devices -->
                  <span class="logo-lg">{!! config('dc.admin_logo_name') !!}</span>
                </a>

                <!-- Header Navbar -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                      <span class="sr-only">Toggle navigation</span>
                    </a>
                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- User Account Menu -->
                            <li class="dropdown user user-menu">
                                <!-- Menu Toggle Button -->
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <!-- The user image in the navbar-->
                                    @if(!empty(Auth::user()->avatar))
                                        <img src="{{ asset('uf/udata/100_' . Auth::user()->avatar) }}" class="user-image">
                                    @else
                                        <img src="{{ 'https://www.gravatar.com/avatar/' . md5(trim(Auth::user()->email)) . '?s=100&d=identicon' }}" class="user-image">
                                    @endif
                                    <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                    <span class="hidden-xs">{{ Auth::user()->name }}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- The user image in the menu -->
                                    <li class="user-header">
                                        @if(!empty(Auth::user()->avatar))
                                            <img src="{{ asset('uf/udata/100_' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="img-circle">
                                        @else
                                            <img src="{{ 'https://www.gravatar.com/avatar/' . md5(trim(Auth::user()->email)) . '?s=100&d=identicon' }}" class="img-circle">
                                        @endif
                                        <p>
                                            {{ Auth::user()->name }}
                                            <small>Member since {{ Auth::user()->created_at }}</small>
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-right">
                                            <a href="{{ url('logout') }}" class="btn btn-default btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel">
                        <div class="pull-left image">
                          @if(!empty(Auth::user()->avatar))
                              <img src="{{ asset('uf/udata/100_' . Auth::user()->avatar) }}" class="img-circle">
                          @else
                              <img src="{{ 'https://www.gravatar.com/avatar/' . md5(trim(Auth::user()->email)) . '?s=100&d=identicon' }}" class="img-circle">
                          @endif
                        </div>
                        <div class="pull-left info">
                            <p>{{ Auth::user()->name }}</p>
                            <!-- Status -->
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>

                    <!-- Sidebar Menu -->
                    <?$controller = Util::getController();?>
                    <ul class="sidebar-menu">
                        <li class="header">Main Menu</li>
                        @include('admin.common.main_menu')
                    </ul>
                    <!-- /.sidebar-menu -->
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                @yield('content')
            </div>
            <!-- /.content-wrapper -->

            <!-- Main Footer -->
            <footer class="main-footer">
                <!-- To the right -->
                <div class="pull-right hidden-xs">
                    <a href="https://almsaeedstudio.com/" target="_blank">Thanks to AdminLTE v.2.3.5</a>
                </div>

                <div class="pull-left">
                    <strong>{{ trans('index_layout.copyright') }} &copy; {{ date('Y') }} <a href="{{ config('dc.site_url') }}">{{ config('dc.site_copyright_name') }}</a>.</strong> {{ trans('index_layout.All rights reserved.') }}
                </div>

                <div class="pull-left" style="margin-left:20px;">
                    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                    <input type="hidden" name="cmd" value="_s-xclick">
                    <input type="hidden" name="hosted_button_id" value="MYTBDEBGLYX56">
                    <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                    <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                    </form>
                </div>

                <div class="clearfix"></div>
            </footer>
        </div>
        <!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.2.3 -->
    <script src="{{ asset('adminlte/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="{{ asset('adminlte/bootstrap/js/bootstrap.min.js') }}"></script>

    @yield('js')

    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/app.min.js') }}"></script>

    <script>
    var __AX_GET_CAR_MODELS = '<?=url('axgetcarmodels');?>';
    </script>

    <!-- dclassifieds common -->
    <script src="{{ asset('adminlte/common.js') }}"></script>
    </body>
</html>
