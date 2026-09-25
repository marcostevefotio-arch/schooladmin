@extends('layouts.layout')

@section('breadcrum')
    <li><i class="ace-icon fa fa-home home-icon"></i><a href="{{ route("home") }}">Home</a></li>
    <li><i class="ace-icon fa fa-hand-o-up  home-icon"></i><a href="{{ route("myspace") }}">Mon espace</a></li>
    <li class="active">Accueil</li>
@endsection

@section('title')
    My Space
@endsection

@section('content')
    <div class="page-content" >
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

                    <div class="ace-settings-item">
                        <input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-sidebar" autocomplete="off" />
                        <label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
                    </div>

                    <div class="ace-settings-item">
                        <input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-breadcrumbs" autocomplete="off" />
                        <label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
                    </div>

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

        <div class="row" >
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-12">
                        <h3 class="header smaller lighter blue">Mon espace de travail</h3>

                        <div class="clearfix">
                            <div class="pull-right tableTools-container"></div>
                        </div>

                        <!-- div.table-responsive -->

                        <!-- div.dataTables_borderWrap -->
                        <div class="col-lg-12 col-xs-12">
                            <div id="clockContaine" onload="showTime()">
                                <div id="MyClockDisplay" class="clock text-center">
                                    <div id="hours" class="lines"></div>
                                    <div id="seconds" class="lines"></div>
                                </div>
                            </div>
                        </div>

                        @if(isset(auth()->user()->etudiant))
                        {{--espace etudiant--}}
                        <div class="col-lg-3 col-xs-12">
                            <a href="{{ route("mnote", ["slug"=>auth()->user()->id]) }}" style="text-decoration: none; ">
                                <div class="jumbotron jumbotron-fluid text-center" style="background: #1279ff; border: 2px solid #1279ff">
                                    <div class="panel primary">
                                        <div class="panel-body">
                                            <h1 style="color: #000000; font-weight: bold">20/20</h1>
                                        </div>
                                    </div>
                                    <div class="text-white">
                                        <h3 style="color: #ffffff; text-transform: uppercase">Mes Notes</h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-xs-12">
                            <a href="{{ route("mplaning", ["slug"=>auth()->user()->id]) }}" style="text-decoration: none; ">
                                <div class="jumbotron jumbotron-fluid text-center" style="background: #1279ff; border: 2px solid #1279ff">
                                    <div class="panel primary">
                                        <div class="panel-body">
                                            <h1 style="color: #000000; font-weight: bold"><i class="fa fa-calendar"></i></h1>
                                        </div>
                                    </div>
                                    <div class="text-white">
                                        <h3 style="color: #ffffff; text-transform: uppercase">Emploi de temps</h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-xs-12">
                            <a href="{{ route("mevaluation", ["slug"=>auth()->user()->id]) }}" style="text-decoration: none; ">
                                <div class="jumbotron jumbotron-fluid text-center" style="background: #1279ff; border: 2px solid #1279ff">
                                    <div class="panel primary">
                                        <div class="panel-body">
                                            <h1 style="color: #000000; font-weight: bold"><i class="fa fa-edit"></i></h1>
                                        </div>
                                    </div>
                                    <div class="text-white">
                                        <h3 style="color: #ffffff; text-transform: uppercase">Evaluations</h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-xs-12">
                            <a href="{{ route("mdiscipline", ["slug"=>auth()->user()->id]) }}" style="text-decoration: none; ">
                                <div class="jumbotron jumbotron-fluid text-center" style="background: #1279ff; border: 2px solid #1279ff">
                                    <div class="panel primary">
                                        <div class="panel-body">
                                            <h1 style="color: #000000; font-weight: bold"><i class="fa fa-exclamation-triangle"></i></h1>
                                        </div>
                                    </div>
                                    <div class="text-white">
                                        <h3 style="color: #ffffff; text-transform: uppercase">Disciplines</h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endif

                        @if(isset(auth()->user()->personnel))
                        {{--espace enseignants--}}
                        <div class="col-lg-3 col-xs-12">
                            <a href="{{ route("tevaluation", ["slug"=>auth()->user()->id]) }}" style="text-decoration: none; ">
                                <div class="jumbotron jumbotron-fluid text-center" style="background: #1279ff; border: 2px solid #1279ff">
                                    <div class="panel primary">
                                        <div class="panel-body">
                                            <h1 style="color: #000000; font-weight: bold"><i class="fa fa-edit"></i></h1>
                                        </div>
                                    </div>
                                    <div class="text-white">
                                        <h3 style="color: #ffffff; text-transform: uppercase">Evaluation</h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-xs-12">
                            <a href="{{ route("tplaning", ["slug"=>auth()->user()->id]) }}" style="text-decoration: none; ">
                                <div class="jumbotron jumbotron-fluid text-center" style="background: #1279ff; border: 2px solid #1279ff">
                                    <div class="panel primary">
                                        <div class="panel-body">
                                            <h1 style="color: #000000; font-weight: bold"><i class="fa fa-calendar"></i></h1>
                                        </div>
                                    </div>
                                    <div class="text-white">
                                        <h3 style="color: #ffffff; text-transform: uppercase">Emploi de temps</h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endif



                    </div>
                </div>

            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
@endsection

@section("style")
    <style type="text/css">
        #clockContaine{
            height: 100px;
            padding-top: 0px;
            margin-top:0px;
            width: 100%;
        }
        #MyClockDisplay{
            float: right;
            width: 150px;
            background: linear-gradient(45deg, rgba(218,94,0,0.5),rgba(255,218,58, 1));
        }

        .clock {
            top: 50%;
            left: 50%;
            color: #111111;
            font-weight: bold;
            font-size: 25px;
            font-family: Orbitron;
            letter-spacing: 7px;
        }
        .lines{
            width: 100%;
            float: right;
        }
        #seconds{
            font-size: 12px;
        }
    </style>
@endsection

@section("script")
    <script type="text/javascript">
        function showTime(){
            var date = new Date();
            var h = date.getHours(); // 0 - 23
            var m = date.getMinutes(); // 0 - 59
            var s = date.getSeconds(); // 0 - 59
            var session = "AM";

            if(h == 0){
                h = 12;
            }

            if(h > 12){
                h = h - 12;
                session = "PM";
            }

            h = (h < 10) ? "0" + h : h;
            m = (m < 10) ? "0" + m : m;
            s = (s < 10) ? "0" + s : s;

            var hour = h + ":" + m ;
            var second = s + " " + session;
            document.getElementById("hours").innerText = hour;
            document.getElementById("hours").textContent = hour;
            document.getElementById("seconds").innerText = second;
            document.getElementById("seconds").textContent = second;

            setTimeout(showTime, 1000);

        }

        showTime();
    </script>
@endsection
