@extends('layouts.layout')


@section('title')
    {{ isset($title)? $title : "WELCOME" }}
@endsection

@section('breadcrum')
    <li><i class="ace-icon fa fa-home home-icon"></i><a href="{{ route("home") }}">Home</a></li>
    <li class="active">Tableau de bord</li>
@endsection


@section('content')
    <div class="row text-center">
        <div class="col-xs-12 text-center">
            <img src="assets/images/welcome/welcome2.gif" alt="" class="img-responsive" style="margin:auto">
        </div>
    </div>
    <div class="page-header">
        <h1>
            Dernieres activités
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                historique
            </small>
        </h1>
    </div><!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="message-container">
                        <div id="id-message-list-navbar" class="message-navbar clearfix">
                            <div class="message-bar">
                                <div class="message-infobar" id="id-message-infobar">
                                    <span class="blue bigger-150">Opérations</span>
                                    <span class="grey bigger-110">(total: {{ count($logs) }})</span>
                                </div>

                            </div>
                        </div>

                        <div class="message-list-container">
                            <div class="message-list" id="message-list">
                                @foreach($logs as $l)
                                    <div class="message-item message-unread">
                                        <label class="inline">
                                            <input type="checkbox" class="ace" />
                                            <span class="lbl"></span>
                                        </label>

                                        <i class="message-star ace-icon fa fa-star orange2"></i>
                                        <span class="sender">{{ $l->operation }} </span>
                                        <span class="sender">{{ $l->tablename }} </span>
                                        <span class="sender">{{ date("d/m/Y", strtotime($l->created_at)) }}</span>
                                        <span class="sender">{{ date("h:i:s", strtotime($l->created_at)) }}</span>
                                        <span class="time"><a class="blue" href="{{ route("logsShow", ["slug"=>$l->id]) }}"><i class="ace-icon fa fa-search-plus bigger-130"></i></a></span>

                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection
