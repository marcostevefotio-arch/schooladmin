<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>{{ config("app.name") }} - @yield("title", "Welcome")</title>

    <meta name="description" content="Mailbox with some customizations as described in docs" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="{{ asset("") }}assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{{ asset("") }}assets/font-awesome/4.5.0/css/font-awesome.min.css" />

    <!-- page specific plugin styles -->

    <link rel="icon" href="{{ asset("") }}assets/images/logo/issat.png" type="image/x-icon" />
    <!-- text fonts -->
    <link rel="stylesheet" href="{{ asset("") }}assets/css/fonts.googleapis.com.css" />

    <!-- ace styles -->
    <link rel="stylesheet" href="{{ asset("") }}assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

    <!--[if lte IE 9]>
    <link rel="stylesheet" href="{{ asset("") }}assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
    <![endif]-->
    <link rel="stylesheet" href="{{ asset("") }}assets/css/ace-skins.min.css" />
    <link rel="stylesheet" href="{{ asset("") }}assets/css/ace-rtl.min.css" />

    @yield("style")

    <!--[if lte IE 9]>
    <link rel="stylesheet" href="{{ asset("") }}assets/css/ace-ie.min.css" />
    <![endif]-->



</head>

<body class="no-skin">
<div id="navbar" class="navbar navbar-default          ace-save-state">
    <div class="navbar-container ace-save-state" id="navbar-container">
        <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
            <span class="sr-only">Toggle sidebar</span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>
        </button>

        <div class="navbar-header pull-left">
            <a href="{{ route("home") }}" class="navbar-brand">
                <small>
                    <i class="fa fa-building"></i>
                    <span class="dark"><b>{{ config("app.name") }}</b></span>&nbsp;<span><b>APP</b></span>
                </small>
            </a>
        </div>

        <div class="navbar-buttons navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">
                <li class="grey dropdown-modal">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <i class="ace-icon fa fa-tasks"></i>
                        <span class="badge badge-grey">0</span>
                    </a>

                    <ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
                        <li class="dropdown-header">
                            <i class="ace-icon fa fa-check"></i>
                            0 Tasks to complete
                        </li>

                        <li class="dropdown-content">
                            <ul class="dropdown-menu dropdown-navbar">
                                {{--<li>--}}
                                    {{--<a href="#">--}}
                                        {{--<div class="clearfix">--}}
                                            {{--<span class="pull-left">Software Update</span>--}}
                                            {{--<span class="pull-right">65%</span>--}}
                                        {{--</div>--}}

                                        {{--<div class="progress progress-mini">--}}
                                            {{--<div style="width:65%" class="progress-bar"></div>--}}
                                        {{--</div>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                            </ul>
                        </li>

                        <li class="dropdown-footer">
                            <a href="{{ route("maintenance") }}">
                                See tasks with details
                                <i class="ace-icon fa fa-arrow-right"></i>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="purple dropdown-modal">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <i class="ace-icon fa fa-bell icon-animated-bell"></i>
                        <span class="badge badge-important">0</span>
                    </a>

                    <ul class="dropdown-menu-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
                        <li class="dropdown-header">
                            <i class="ace-icon fa fa-exclamation-triangle"></i>
                            0 Notifications
                        </li>

                        <li class="dropdown-content">
                            <ul class="dropdown-menu dropdown-navbar navbar-pink">
                                {{--<li>--}}
                                    {{--<a href="#">--}}
                                        {{--<div class="clearfix">--}}
													{{--<span class="pull-left">--}}
														{{--<i class="btn btn-xs no-hover btn-pink fa fa-comment"></i>--}}
														{{--New Comments--}}
													{{--</span>--}}
                                            {{--<span class="pull-right badge badge-info">+12</span>--}}
                                        {{--</div>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                            </ul>
                        </li>

                        <li class="dropdown-footer">
                            <a href="{{ route("maintenance") }}">
                                See all notifications
                                <i class="ace-icon fa fa-arrow-right"></i>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="green dropdown-modal">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <i class="ace-icon fa fa-envelope icon-animated-vertical"></i>
                        <span class="badge badge-success">0</span>
                    </a>

                    <ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
                        <li class="dropdown-header">
                            <i class="ace-icon fa fa-envelope-o"></i>
                            0 Messages
                        </li>

                        <li class="dropdown-content">
                            <ul class="dropdown-menu dropdown-navbar">
                                {{--<li>--}}
                                    {{--<a href="#" class="clearfix">--}}
                                        {{--<img src="{{ asset("") }}assets/images/avatars/avatar.png" class="msg-photo" alt="Alex's Avatar" />--}}
                                        {{--<span class="msg-body">--}}
													{{--<span class="msg-title">--}}
														{{--<span class="blue">Alex:</span>--}}
														{{--Ciao sociis natoque penatibus et auctor ...--}}
													{{--</span>--}}

													{{--<span class="msg-time">--}}
														{{--<i class="ace-icon fa fa-clock-o"></i>--}}
														{{--<span>a moment ago</span>--}}
													{{--</span>--}}
												{{--</span>--}}
                                    {{--</a>--}}
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown-footer">
                            <a href="{{ route("maintenance") }}">
                                See all messages
                                <i class="ace-icon fa fa-arrow-right"></i>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="light-blue dropdown-modal">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        <img class="nav-user-photo" src="{{ asset("") }}assets/images/avatars/avatar.png" alt="{{ isset(auth()->user()->personnel)? auth()->user()->personnel->lastname : (isset(auth()->user()->etudiant)? auth()->user()->etudiant->lastname." ".auth()->user()->etudiant->firstname : "") }}" width="30" height="30">
                        <span class="user-info">
									<small>Welcome,</small>
                                    {{ isset(auth()->user()->personnel)? auth()->user()->personnel->lastname : "" }}
                                    {{ isset(auth()->user()->etudiant)? auth()->user()->etudiant->lastname." ".auth()->user()->etudiant->firstname : "" }}
								</span>

                        <i class="ace-icon fa fa-caret-down"></i>
                    </a>

                    <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">

                        <li>
                            <a href="{{ route("userProfile", ["slug"=>auth()->user()->id]) }}">
                                <i class="ace-icon fa fa-user"></i>
                                Profile
                            </a>
                        </li>

                        <li class="divider"></li>

                        <li>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i class="ace-icon fa fa-power-off"></i>
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div><!-- /.navbar-container -->
</div>

<div class="main-container ace-save-state" id="main-container" >
    <script type="text/javascript">
        try{ace.settings.loadState('main-container')}catch(e){}
    </script>

    @include("layouts.nav")

    {{--@include("layouts.nav")--}}
    <div class="main-content">
        <div class="main-content-inner">
            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <ul class="breadcrumb">
                    @yield("breadcrum")
                </ul><!-- /.breadcrumb -->

                <div class="nav-search" id="nav-search">
                    <form class="form-search">
                        <span class="input-icon">
                            <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
                            <i class="ace-icon fa fa-search nav-search-icon"></i>
                        </span>
                    </form>
                </div><!-- /.nav-search -->
            </div>

            <div class="page-content">
                <div class="ace-settings-container" id="ace-settings-container">
                    <div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
                        <i class="ace-icon fa fa-cog bigger-130"></i>
                    </div>

                    <div class="ace-settings-box clearfix" id="ace-settings-box">
                        <div class="pull-left width-50">
                            <div class="ace-settings-item">
                                <div class="pull-left">
                                    <select id="skin-colorpicker" class="hide">
                                        <option data-skin="no-skin" value="#438EB9">#438EB9</option>
                                        <option data-skin="skin-1" value="#222A2D">#222A2D</option>
                                        <option data-skin="skin-2" value="#C6487E">#C6487E</option>
                                        <option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
                                    </select>
                                </div>
                                <span>&nbsp; Choose Skin</span>
                            </div>

                            <div class="ace-settings-item">
                                <input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-navbar" autocomplete="off" />
                                <label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
                            </div>

                            {{--<div class="ace-settings-item">--}}
                                {{--<input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-sidebar" autocomplete="off" />--}}
                                {{--<label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>--}}
                            {{--</div>--}}

                            {{--<div class="ace-settings-item">--}}
                                {{--<input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-breadcrumbs" autocomplete="off" />--}}
                                {{--<label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>--}}
                            {{--</div>--}}

                            <div class="ace-settings-item">
                                <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" autocomplete="off" />
                                <label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
                            </div>

                            <div class="ace-settings-item">
                                <input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-add-container" autocomplete="off" />
                                <label class="lbl" for="ace-settings-add-container">
                                    Inside
                                    <b>.container</b>
                                </label>
                            </div>
                        </div><!-- /.pull-left -->

                        <div class="pull-left width-50">
                            <div class="ace-settings-item">
                                <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-hover" autocomplete="off" />
                                <label class="lbl" for="ace-settings-hover"> Submenu on Hover</label>
                            </div>

                            <div class="ace-settings-item">
                                <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact" autocomplete="off" />
                                <label class="lbl" for="ace-settings-compact"> Compact Sidebar</label>
                            </div>

                            <div class="ace-settings-item">
                                <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight" autocomplete="off" />
                                <label class="lbl" for="ace-settings-highlight"> Alt. Active Item</label>
                            </div>
                        </div><!-- /.pull-left -->
                    </div><!-- /.ace-settings-box -->
                </div><!-- /.ace-settings-container -->
                <div class="page-header">
                    <h1>
                        <i class="fa {{ isset($module)? $module->icon_menu : "fa-smile-o" }}"></i>
                        {{ isset($title)? $title : " WELCOME" }}
                    </h1>
                </div><!-- /.page-header -->
                <div class="row">
                    @if(Session::has('message'))
                        <div class="col-xs-12">
                            <div class="alert {{ Session::get('alert-class', 'alert-info') }}">
                                <button type="button" class="close" data-dismiss="alert">
                                    <i class="icon-remove"></i>
                                </button>

                                <strong>
                                    <i class="icon-remove"></i>
                                    {{ Session::get('alert-title') }}
                                </strong>

                                {{ Session::get('message') }}
                                <br />
                            </div>
                        </div>
                    @endif
                </div>
                @yield("content")
            </div>
        </div>
    </div><!-- /.main-content -->

    <div class="footer">
        <div class="footer-inner">
            <div class="footer-content">
                <span class="bigger-120">
                    <span class="blue bolder">Steve M.</span>
                    Application &copy; {{ date("Y") }}
                </span>

                &nbsp; &nbsp;
                <span class="action-buttons">
                    <a href="#">
                        <i class="fa fa-address-card " aria-hidden="true"></i>
                    </a>
                </span>
            </div>
        </div>
    </div>

    <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
        <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
    </a>
</div><!-- /.main-container -->

<!-- basic scripts -->

<!--[if !IE]> -->
<script src="{{ asset("") }}assets/js/jquery-2.1.4.min.js"></script>
@yield("script2")
<script type="text/javascript">
    if('ontouchstart' in document.documentElement) document.write("<script src='{{ asset("") }}assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>
<script src="{{ asset("") }}assets/js/bootstrap.min.js"></script>

<!-- page specific plugin scripts -->
<script src="{{ asset("") }}assets/js/bootstrap-tag.min.js"></script>
<script src="{{ asset("") }}assets/js/jquery.hotkeys.index.min.js"></script>
<script src="{{ asset("") }}assets/js/bootstrap-wysiwyg.min.js"></script>

<!-- ace scripts -->
<script src="{{ asset("") }}assets/js/ace-elements.min.js"></script>
<script src="{{ asset("") }}assets/js/ace.min.js"></script>

<!-- inline scripts related to this page -->
@yield("script")
</body>
</html>
