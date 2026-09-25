@extends('layouts.layout')

@section('title')
    {{ isset($title)? $title : "" }}
@endsection

@section('breadcrum')
    <li><i class="ace-icon fa fa-home home-icon"></i><a href="{{ route("home") }}">Home</a></li>
    <li><i class="ace-icon home-icon"></i><a href="{{ isset($module)? route($module->code_menu) : "" }}">{{ isset($parent)? $parent : "" }}</a></li>
    <li><i class="ace-icon home-icon"></i><a href="{{ $option_route }}">{{ isset($title)? $title : "" }}</a></li>
    <li class="active">Read</li>
@endsection

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->

            <div class="hr dotted"></div>

            <div>
                <div id="user-profile-1" class="user-profile row">
                    <div class="col-xs-12 col-sm-3 center">
                        <div>
                            <span class="profile-picture">
                                <img id="avatar" class="editable img-responsive" alt="Alex's Avatar" src="assets/images/avatars/profile-pic.jpg" />
                            </span>

                            <div class="space-4"></div>

                            <div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                                <div class="inline position-relative">
                                    <a href="#" class="user-title-label dropdown-toggle" data-toggle="dropdown">
                                        <i class="ace-icon fa fa-circle light-green"></i>
                                        &nbsp;
                                        <span class="white">{{ $user->personnel->lastname }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="space-6"></div>

                        <div class="profile-contact-info">
                            <div class="profile-contact-links align-left">
                                <a href="#" class="btn btn-link">
                                    <i class="ace-icon fa fa-envelope bigger-120 pink"></i>
                                    {{ $user->email }}
                                </a>
                            </div>

                            <div class="space-6"></div>
                        </div>
                        <div class="profile-contact-info">
                            <div class="profile-contact-links align-left">
                                <a href="#" class="btn btn-link">
                                    <i class="ace-icon fa fa-phone bigger-120 pink"></i>
                                    {{ $user->personnel->phone }}
                                </a>
                            </div>

                            <div class="space-6"></div>
                        </div>

                        <div class="hr hr12 dotted"></div>
                    </div>

                    <div class="col-xs-12 col-sm-9">
                        <div class="space-12"></div>

                        <div class="profile-user-info profile-user-info-striped">
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Nom et prénom </div>

                                <div class="profile-info-value">
                                    <span class="editable" id="username">{{ $user->personnel->lastname }} {{ $user->personnel->firstname }}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> Sexe </div>

                                <div class="profile-info-value">
                                    <i class="fa fa-gender light-orange bigger-110"></i>
                                    <span class="editable" id="country">{{ $user->personnel->sexe }}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> Date de naissance </div>

                                <div class="profile-info-value">
                                    <span class="editable" id="age">{{ $user->personnel->birthday }}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> Numero de la pièce d'identité (CNI)</div>

                                <div class="profile-info-value">
                                    <span class="editable" id="signup">{{ $user->personnel->cni }}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> Telephone </div>

                                <div class="profile-info-value">
                                    <span class="editable" id="login">{{ $user->personnel->phone }}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> Adresse </div>

                                <div class="profile-info-value">
                                    <span class="editable" id="about">{{ $user->personnel->adresse }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-20"></div>

                        <div class="widget-box transparent">
                            <div class="widget-header widget-header-small">
                                <h4 class="widget-title blue smaller">
                                    <i class="ace-icon fa fa-rss orange"></i>
                                    Recent Activities
                                </h4>

                                <div class="widget-toolbar action-buttons">

                                </div>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main padding-8">
                                    <div id="profile-feed-1" class="profile-feed">
                                        @foreach($user->historique as $l)
                                            <div class="profile-activity clearfix">
                                                <div>
                                                    <img class="pull-left" alt="Alex Doe's avatar" src="assets/images/avatars/avatar5.png" />
                                                    <a class="user" href="#"> {{ $l->operation }} </a>
                                                    <a href="#">{{ $l->tablename }}</a>

                                                    <div class="time">
                                                        <i class="ace-icon fa fa-clock-o bigger-110"></i>
                                                        {{ date("d/m/Y", strtotime($l->created_at)) }}({{ date("h:i:s", strtotime($l->created_at)) }})
                                                    </div>
                                                </div>


                                                <div class="tools action-buttons">
                                                    {{--<a href="#" class="blue">--}}
                                                        {{--<i class="ace-icon fa fa-pencil bigger-125"></i>--}}
                                                    {{--</a>--}}

                                                    {{--<a href="#" class="red">--}}
                                                        {{--<i class="ace-icon fa fa-times bigger-125"></i>--}}
                                                    {{--</a>--}}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="hr hr2 hr-double"></div>

                        <div class="space-6"></div>

                    </div>
                </div>
            </div>

            <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->

@endsection

@section("script")
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/jquery.dataTables.bootstrap.min.js"></script>
    <script src="assets/js/dataTables.buttons.min.js"></script>
    <script src="assets/js/buttons.flash.min.js"></script>
    <script src="assets/js/buttons.html5.min.js"></script>
    <script src="assets/js/buttons.print.min.js"></script>
    <script src="assets/js/buttons.colVis.min.js"></script>
    <script src="assets/js/dataTables.select.min.js"></script>

    <script type="text/javascript">
        jQuery(function($) {
            var myTable =
                $('#dynamic-table')
                    .DataTable( {
                        bAutoWidth: false,
                        "aoColumns": [
                            { "bSortable": false },
                            null, null,null, null,
                            { "bSortable": false }
                        ],
                        "aaSorting": [],
                        select: {
                            style: 'multi'
                        }
                    } );

        })
    </script>
@endsection
