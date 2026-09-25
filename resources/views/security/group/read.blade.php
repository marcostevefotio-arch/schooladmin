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

        <div id="user-profile-2" class="user-profile">
            <div class="tabbable">
                <ul class="nav nav-tabs padding-18">
                    <li class="active">
                        <a data-toggle="tab" href="#home">
                            <i class="green ace-icon fa fa-cube bigger-120"></i>
                            Groupe
                        </a>
                    </li>

                    <li>
                        <a data-toggle="tab" href="#feed">
                            <i class="orange ace-icon fa fa-users bigger-120"></i>
                            Membres ({{ count($groupes->personnels) }})
                        </a>
                    </li>

                    <li>
                        <a data-toggle="tab" href="#friends">
                            <i class="blue ace-icon fa fa-key bigger-120"></i>
                            Droits et acces ({{ count($groupes->permission) }})
                        </a>
                    </li>
                </ul>

                <div class="tab-content no-border padding-24">
                    <div id="home" class="tab-pane in active">
                        <div class="row">
                            <div class="col-xs-12 col-sm-3 center">
                                <span class="profile-picture">
                                    <i class="fa fa-cube fa-5x text-info" style="zoom: 3.2"></i>
                                </span>

                                <div class="space space-4"></div>
                            </div><!-- /.col -->

                            <div class="col-xs-12 col-sm-9">
                                <h4 class="blue">
                                    <span class="middle">{{ $groupes->titre_groupe }}</span>

                                    <span class="label label-{{ ($groupes->editing)? "info" : "danger" }} arrowed-in-right">
                                        <i class="ace-icon fa fa-{{ ($groupes->editing)? "unlock" : "lock" }} smaller-80 align-middle"></i>
                                        {{ ($groupes->editing)? "Libre" : "Restrinct" }}
                                    </span>
                                </h4>

                                <div class="profile-user-info">
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Titre </div>

                                        <div class="profile-info-value">
                                            <span>{{ $groupes->titre_groupe }}</span>
                                        </div>
                                    </div>

                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Description </div>

                                        <div class="profile-info-value">
                                            <span>{{ $groupes->description_groupe }}</span>
                                        </div>
                                    </div>

                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Nombre de membres </div>

                                        <div class="profile-info-value">
                                            <span>{{ count($groupes->personnels) }}</span>
                                        </div>
                                    </div>

                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Total des accès </div>

                                        <div class="profile-info-value">
                                            <span>{{ count($groupes->permission) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="hr hr-8 dotted"></div>

                            </div><!-- /.col -->
                        </div><!-- /.row -->

                        <div class="space-20"></div>

                    </div><!-- /#home -->

                    <div id="feed" class="tab-pane">
                        <div class="profile-feed row">
                            @foreach($groupes->personnels as $p)
                            <div class="col-sm-6">
                                <div class="profile-activity clearfix">
                                    <div>
                                        <img class="pull-left" alt="Alex Doe's avatar" src="assets/images/avatars/avatar5.png" />
                                        <a class="user" href="#"> {{ $p->lastname }} {{ $p->firstname }} </a>
                                        {{ $p->adresse }}
                                        <a href="#">{{ $p->phone }}</a>

                                        <div class="time">
                                            <i class="ace-icon fa fa-flag bigger-110"></i>
                                            {{ $p->country }}
                                        </div>
                                        <h4><span class="label label-lg label-info"><i class="fa fa-lock"></i>&nbsp;Comptes utilisé</span></h4>
                                        <ul class="nav">
                                            @foreach($p->user as $u)
                                                <li class="nav"><i class="fa fa-chevron-right fa-sm">&nbsp;{{ $u->email }} - <span class="label label-sm label-{{ ($u->active==1)? "success" : "danger" }}">{{ ($u->active==1)? "Compte actif" : "Compte inactif" }}</span></i></li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    <div class="tools action-buttons">
                                        <a href="{{ route("userEdit", ["slug"=>$p->id]) }}" class="blue">
                                            <i class="ace-icon fa fa-pencil bigger-125"></i>
                                        </a>
                                        @if($groupes->editing)
                                        <a href="{{ route("userDelete", ["slug"=>$p->id]) }}" class="red">
                                            <i class="ace-icon fa fa-times bigger-125"></i>
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div><!-- /.col -->
                            @endforeach
                        </div><!-- /.row -->

                        <div class="space-12"></div>
                    </div><!-- /#feed -->

                    <div id="friends" class="tab-pane">
                        <div class="table-responssive">
                            <table class="table table-bordered text-center" id="dynamic-table">
                                <thead>
                                <th>Menus</th>
                                <th>Creation</th>
                                <th>Lecture</th>
                                <th>Modification</th>
                                <th>Supression</th>
                                <th>Exportation</th>
                                </thead>
                                <tbody>
                                @php
                                    $i=0;
                                @endphp
                                @foreach($menu as $m)
                                    <tr class="bg-primary text-white">
                                        <td class="text-left"><b>{{ $m->libelle_menu }}</b></td>
                                        @foreach($m->permission as $p)
                                            <td><i class="fa fa-{{ $groupes->permission->contains($p)? "check text-white" : "close text-white"  }}" ></i></td>
                                        @endforeach
                                    </tr>
                                    @if(count($m->menu_enfants)>0)
                                        @foreach($m->menu_enfants as $sm)
                                            <tr>
                                                <td>{{ $sm->libelle_menu }}</td>
                                                @foreach($sm->permission as $p)
                                                    <td><i class="fa fa-{{ $groupes->permission->contains($p)? "check text-success" : "close text-danger"  }}" ></i></td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div><!-- /#friends -->
                </div>
            </div>
        </div>


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
                            null,
                            { "bSortable": false },
                            { "bSortable": false },
                            { "bSortable": false },
                            { "bSortable": false },
                            { "bSortable": false }
                        ],
                        "aaSorting": [],
                    } );

        })
    </script>
@endsection
