@extends('layouts.layout')

@section('title')
    {{ isset($title)? $title : "" }}
@endsection


@section('breadcrum')
    <li><i class="ace-icon fa fa-home home-icon"></i><a href="{{ route("home") }}">Home</a></li>
    <li class="active">{{ isset($title)? $title : "" }}</li>
@endsection


@section('content')
    @if(count($module->menu_enfants)>0)
        <div class="row">
            @foreach($module->menu_enfants as $sm)
                @if(!empty($sm->permission))
                    @foreach(auth()->user()->personnel->groupe->permission as $p)
                        @if($p->menu_id == $sm->id)
                            <div class="col-lg-4">
                                <a href="{{ route($sm->code_menu) }}" class="">
                                    <div class="card text-center  padd-2" style="background: rgb({{ rand(0, 100) }},{{ rand(0, 200) }},255); color: #ffffff; text-decoration: none!important;">
                                        <div class="card-body">
                                            <i class="fa {{ $sm->icon_menu }} fa-5x"></i>
                                        </div>
                                        <div class="card-title text-uppercase h4">{{ $sm->libelle_menu }}</div>
                                    </div>
                                </a>
                            </div>
                            @break
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>
    @endif
@endsection
