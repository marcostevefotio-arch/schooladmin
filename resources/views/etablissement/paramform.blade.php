@extends('layouts.layout')

@section('title')
    {{ isset($title)? $title : "" }}
@endsection

@section('breadcrum')
    <li><i class="ace-icon fa fa-home home-icon"></i><a href="{{ route("home") }}">Home</a></li>
    <li><i class="ace-icon home-icon"></i><a href="{{ isset($module)? route($module->code_menu) : "" }}">{{ isset($parent)? $parent : "" }}</a></li>
    <li><i class="ace-icon home-icon"></i><a href="{{ $option_route }}">{{ isset($title)? $title : "" }}</a></li>
    <li class="active">Configuration</li>
@endsection


@section('content')

    <div class="card card-body">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h1>ISSAT</h1>
                        <form action="{{ route("parametreUpdate", ["slug"=>$data->id]) }}" method="post">
                            @csrf
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon bg-white">
                                        <i class="">&nbsp;Option</i>
                                    </span>
                                    <input class="form-control input-mask-phone" type="text" id="form-field-mask-2" value="{{ $data->option }}" disabled=""/>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon bg-white">
                                        <i>Description</i>
                                    </span>
                                    <input class="form-control input-mask-phone" type="text" id="form-field-mask-2" name="description" value="{{ $data->description }}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon bg-white">
                                        <i>Valeur</i>
                                    </span>
                                    @if($data->typevaleur == "password")
                                        <input class="form-control input-mask-phone" type="password" id="form-field-mask-2" name="valeur" value="{{ $data->valeur }}" />
                                    @endif
                                    @if($data->typevaleur == "liste")
                                        <select name="valeur" id="valeur" class="form-control input-mask-phone">
                                            <option value=""></option>
                                            @foreach(explode(",",$data->valeurspossible) as $d)
                                                <option value="{{ $d }}" {{ ($d==$data->valeur)? "selected" : "" }}>{{ $d }}</option>
                                            @endforeach
                                        </select>
                                    @endif

                                    @if($data->typevaleur == "matricule")
                                        <select name="valeur" id="valeur" class="form-control input-mask-phone">
                                            <option value=""></option>
                                            <option value="manuel" {{ ("manuel"==$data->valeur)? "selected" : "" }}>Manuel</option>
                                            <option value="automatique" {{ ("automatique"==$data->valeur)? "selected" : "" }}>Automatique</option>
                                        </select>
                                    @endif

                                    @if($data->typevaleur == "dossier")
                                        <select name="valeur" id="valeur" class="form-control input-mask-phone">
                                            <option value=""></option>
                                            <option value="manuel" {{ ("manuel"==$data->valeur)? "selected" : "" }}>Manuel</option>
                                            <option value="automatique" {{ ("automatique"==$data->valeur)? "selected" : "" }}>Automatique</option>
                                        </select>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save">&nbsp;</i>Enregistrer</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section("script")

@endsection
