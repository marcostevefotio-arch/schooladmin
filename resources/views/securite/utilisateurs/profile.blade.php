@extends('layouts.layout')

@section('language')
    {{ (Session::has("locale"))? Session::get("locale") : "en" }}
@endsection

@section('lang')
    {{ (Session::has("locale"))? app()->setLocale(Session::get("locale")) : app()->setLocale('en') }}
@endsection

@section('breadcrum')
    <li class="breadcrumb-item"><a href="{{ route("enseignant") }}">Profile</a></li>
    <li class="active">{{ $data->lastname }}</li>
@endsection

@section('page')
    {{ Session::put("page", "profile") }}
    Profile utilisateur
@endsection


@section('content')
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

        <div class="page-header">
            <h1>
                Profile utilisateur
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    Details
                </small>
            </h1>
        </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    <div class="widget-box transparent">
                        <div class="widget-header widget-header-large">
                            <h3 class="widget-title grey lighter">
                                <i class="ace-icon fa fa-eye green"></i>
                                Details
                            </h3>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main padding-24">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <img src="{{ (isset($data) && !empty($data->avatar))? "data:image/" .auth()->user()->avatarType. ";base64," .base64_encode( auth()->user()->avatar) : "assets/images/avatars/avatar.png" }}" alt="" class="img-fluid" style="width:100%">
                                    </div>

                                    <div class="col-sm-8">
                                        <div class="row">
                                            <div class="col-xs-11 label label-lg label-info arrowed-in arrowed-right">
                                                <b>IDENTIFICATION</b>
                                            </div>
                                        </div>

                                        <div>
                                            <ul class="list-unstyled  spaced">
                                                <li>
                                                    <i class="ace-icon fa fa-caret-right green"></i><b>Nom:</b> {{ $data->personnel->lastname }} {{ $data->personnel->firstname }}
                                                </li>

                                                <li>
                                                    <i class="ace-icon fa fa-caret-right green"></i><b>Email:</b> {{ $data->email }}
                                                </li>

                                                <li>
                                                    <i class="ace-icon fa fa-caret-right green"></i><b>Groupe:</b>
                                                    {{ isset($data->etudiant)? $data->etudiant->groupe->titre_groupe : (isset($data->personnel)? $data->personnel->groupe->titre_groupe : "") }}
                                                </li>

                                                <li>
                                                    <i class="ace-icon fa fa-caret-right green"></i><b>Permissions:</b>
                                                    {{ isset($data->etudiant)? count($data->etudiant->groupe->permission) : (isset($data->personnel)? count($data->personnel->groupe->permission) : 0) }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div><!-- /.col -->

                                    <div class="col-sm-8">
                                        <div class="row">
                                            <div class="col-xs-11 label label-lg label-success arrowed-in arrowed-right">
                                                <b>Operations</b>
                                            </div>
                                        </div>

                                        <div>
                                            <ul class="list-unstyled  spaced">
                                                <li>
                                                    <form action="{{ route("userAvatar") }}" id="form-avatar" method="post" enctype="multipart/form-data">
                                                        {{ csrf_field() }}
                                                        <input type="file" id="avatar" name="avatar" class="hide"/>
                                                        <button type="button" id="avatarForm" class="btn btn-info">Changer de photo de profile</button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <a href="{{ route("passwordEdit", ["slug"=>auth()->user()->id]) }}" class="btn btn-{{ Session::has("success")? "success" : "primary" }}"><i class="fa fa-{{ Session::has("success")? "check" : "" }}"></i>&nbsp;Modifier le mot de passe</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div><!-- /.col -->
                                    @yield("passwordform")

                                </div><!-- /.row -->


                                <div class="space"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    <div class="widget-box transparent">
                        <div class="widget-header widget-header-large">
                            <h3 class="widget-title grey lighter">
                                <i class="ace-icon fa fa-archive green"></i>
                                Activités
                            </h3>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main padding-24">
                                <div class="row">

                                </div><!-- /.row -->


                                <div class="space"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.col -->
    </div>

@endsection

@section("script")
    {{--<script src="assets/js/jquery.dataTables.min.js"></script>--}}
    {{--<script src="assets/js/jquery.dataTables.bootstrap.min.js"></script>--}}
    {{--<script src="assets/js/dataTables.buttons.min.js"></script>--}}
    {{--<script src="assets/js/buttons.flash.min.js"></script>--}}
    {{--<script src="assets/js/buttons.html5.min.js"></script>--}}
    {{--<script src="assets/js/buttons.print.min.js"></script>--}}
    {{--<script src="assets/js/buttons.colVis.min.js"></script>--}}
    {{--<script src="assets/js/dataTables.select.min.js"></script>--}}


    <!-- inline scripts related to this page -->
    <script type="text/javascript">
        $(document).ready(function(){
            $("#avatarForm").click(function(){
                $("#avatar").click();
            });

            $("#avatar").change(function(){
                $("#form-avatar").submit();
            });

        });
    </script>
@endsection
