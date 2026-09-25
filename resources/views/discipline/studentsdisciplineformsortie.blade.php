@extends('layouts.layout')

@section('language')
    {{ (Session::has("locale"))? Session::get("locale") : "en" }}
@endsection

@section('lang')
    {{ (Session::has("locale"))? app()->setLocale(Session::get("locale")) : app()->setLocale('en') }}
@endsection

@section('breadcrum')
    <li class="active">Bibliothèque</li>
@endsection

@section('page')
    {{ Session::put("page", "discipline") }}
    Discipline
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
            </div>
        </div>

        <div class="page-header">
            <h1>
                Gestion de la discipline
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    Enregistrer les absences
                </small>
            </h1>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <form action="" method="post">
                    {{ csrf_field() }}

                    <table class="table table-bordered table-striped">
                        <tr>
                            <td>Specialité</td>
                            <td>Journée</td>
                            <td>Specialité</td>
                            <td>Journée</td>
                            <td>Journée</td>
                        </tr>
                        <tr>
                            <td>
                                {{--<select name="specialite" id="specialite" class="form-control form-control-sm">--}}
                                {{--<option value=""></option>--}}
                                {{--@foreach($specialite as $s)--}}
                                {{--<option value="{{ $s->id }}">{{ $s->libelleSpecialite }}</option>--}}
                                {{--@endforeach--}}
                                {{--</select>--}}
                                <div>

                                    <select class="my_select_box" data-placeholder="Select Your Options">
                                        <option value=""></option>
                                        <option value="1">Option 1</option>
                                        <option value="2">Option 2</option>
                                        <option value="3">Option 3</option>
                                    </select>
                                </div>

                            </td>
                            <td>
                                <input type="date" name="journee" id="journee"  class="form-control form-control-sm"/>
                            </td>
                            <td>
                                <input type="date" name="journee" id="journee"  class="form-control form-control-sm"/>
                            </td>
                            <td>
                                <input type="date" name="journee" id="journee"  class="form-control form-control-sm"/>
                            </td>
                            <td>
                                <input type="date" name="journee" id="journee"  class="form-control form-control-sm"/>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>

    </div>
@endsection

@section("style")
    <link rel="stylesheet" href="{{ asset("") }}assets/css/chosen.css" />
@endsection

@section("script")
    <script src="{{ asset("") }}assets/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset("") }}assets/js/jquery.dataTables.bootstrap.min.js"></script>
    <script src="{{ asset("") }}assets/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset("") }}assets/js/chosen.jquery.js"></script>
    <script src="{{ asset("") }}assets/js/buttons.flash.min.js"></script>
    <script src="{{ asset("") }}assets/js/buttons.html5.min.js"></script>
    <script src="{{ asset("") }}assets/js/buttons.print.min.js"></script>
    <script src="{{ asset("") }}assets/js/buttons.colVis.min.js"></script>
    <script src="{{ asset("") }}assets/js/dataTables.select.min.js"></script>


    <!-- inline scripts related to this page -->
    <script type="text/javascript">
        $(document).ready(function(){
            $(".my_select_box").chosen();
        })
    </script>

@endsection
