@extends('layouts.layout')

@section('title')
    {{ isset($title)? $title : "" }}
@endsection

@section('breadcrum')
    <li><i class="ace-icon fa fa-home home-icon"></i><a href="{{ route("home") }}">Home</a></li>
    <li><i class="ace-icon home-icon"></i><a href="{{ isset($module)? route($module->code_menu) : "" }}">{{ isset($parent)? $parent : "" }}</a></li>
    <li><i class="ace-icon home-icon"></i><a href="{{ $option_route }}">{{ isset($title)? $title : "" }}</a></li>
    <li class="active">Liste</li>
@endsection

@section('content')

    <div class="row" style="padding: 10px">
        <div class="col-xs-12">
            <div class="clearfix">
                {{--<div class="pull-right tableTools-container"></div>--}}
                <div class="btn-group">
                    @foreach($module->menu_enfants as $m)
                        @if(strtolower($m->libelle_menu)!=strtolower($title))
                            <a href="{{ route($m->code_menu) }}" target="{{ $m->libelle_menu=="Fiches d'inscription"? "_blank" : ""  }}" class="btn btn-primary btn-sm"><i class="fa {{ $m->icon_menu }}"></i>&nbsp;{{ $m->libelle_menu }}</a>
                        @endif
                    @endforeach
                </div>
                <br>
                <br>
            </div>

            <div class="clearfix">
                <div class="pull-right tableTools-container"></div>
                <div class="btn-group">
                    <a href="{{ route("matiere") }}" class="btn btn-info btn-sm"><i class="fa fa-table"></i>&nbsp;Matieres</a>
                    <a href="{{ route("enseignant") }}" class="btn btn-warning btn-sm"><i class="fa fa-tablet"></i>&nbsp;Enseignants</a>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                @foreach($data as $d)
                    <div class="space"></div>
                    <div class="row">
                        <div class="col-xs-11 label label-lg label-warning arrowed-in arrowed-right">
                            <b>{{ $d->libelleFiliere }}</b>
                        </div>
                    </div>
                    <br>
                    @foreach($d->specialites as $sp)
                        <div class="col-sm-4">
                            <a href="{{ route("programmeShow", ["slug"=>$sp->id]) }}"  class="ling-dashboard">
                                <div class="widget-box h3 bg-primary text-center" style="padding: 10px">
                                    <div class="">

                                        <h2><i class="fa fa-graduation-cap"></i>&nbsp;{{ $sp->codeSpecialite }}</h2>
                                    </div>
                                    <div class="hr hr8 hr-double"></div>
                                    <h6>{{ $sp->libelleSpecialite }}</h6>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endforeach
            </div>

            <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div>

@endsection


@section("style")
    <style type="text/css">
        .ling-dashboard:hover{
            text-decoration: none;
        }
    </style>
@endsection

@section("script")

@endsection

