@extends('layouts.layout')

@section('title')
    {{ isset($title)? $title : "" }}
@endsection

@section('breadcrum')
    <li><i class="ace-icon fa fa-home home-icon"></i><a href="{{ route("home") }}">Home</a></li>
    <li><i class="ace-icon home-icon"></i><a href="{{ isset($module)? route($module->code_menu) : "" }}">{{ isset($parent)? $parent : "" }}</a></li>
    <li><i class="ace-icon home-icon"></i><a href="{{ $option_route }}">{{ isset($title)? $title : "" }}</a></li>
    <li class="active">liste</li>
@endsection


@section('content')

        <div id="user-profile-2" class="user-profile">
            <div class="tabbable">
                <ul class="nav nav-tabs padding-18">
                    <li class="active">
                        <a data-toggle="tab" href="#home">
                            <i class="green ace-icon fa fa-cube bigger-120"></i>
                            Details
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
                                    <span class="middle">{{ $log->Opération }}</span>
                                </h4>

                                <div class="profile-user-info">
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Opération </div>

                                        <div class="profile-info-value">
                                            <span>{{ $log->operation }}</span>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Table </div>

                                        <div class="profile-info-value">
                                            <span>{{ $log->tablename }}</span>
                                        </div>
                                    </div>

                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Date </div>

                                        <div class="profile-info-value">
                                            <span>{{ $log->created_at }}</span>
                                        </div>
                                    </div>

                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Utilisateur </div>

                                        <div class="profile-info-value">
                                            <span>{{ $log->user->email }}</span>
                                        </div>
                                    </div>

                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Adresse </div>

                                        <div class="profile-info-value">
                                            <span>{{ $log->ipadresse }}</span>
                                        </div>
                                    </div>
                                    @if(auth()->user()->personnel->groupe->id == 1)
                                    {{--<div class="profile-info-row">--}}
                                        {{--<div class="profile-info-name"> Avant </div>--}}

                                        {{--<div class="profile-info-value">--}}
                                            {{--<span>{{ $log->Before }}</span>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}

                                    {{--<div class="profile-info-row">--}}
                                        {{--<div class="profile-info-name"> Après </div>--}}

                                        {{--<div class="profile-info-value">--}}
                                            {{--<span>{{ $log->After }}</span>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}

                                    {{--<div class="profile-info-row">--}}
                                        {{--<div class="profile-info-name"> Données </div>--}}

                                        {{--<div class="profile-info-value">--}}
                                            {{--<span>{{ $log->Data }}</span>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    @endif
                                </div>

                                <div class="hr hr-8 dotted"></div>

                            </div><!-- /.col -->
                        </div><!-- /.row -->

                        <div class="space-20"></div>

                    </div><!-- /#home -->
                </div>
            </div>
        </div>

@endsection

@section("script")

@endsection
