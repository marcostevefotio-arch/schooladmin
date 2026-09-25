@extends('layouts.layout')

@section('title')
    {{ isset($title)? $title : "" }}
@endsection

@section('breadcrum')
    <li><i class="ace-icon fa fa-home home-icon"></i><a href="{{ route("home") }}">Home</a></li>
    <li><i class="ace-icon home-icon"></i><a href="{{ isset($module)? route($module->code_menu) : "" }}">{{ isset($parent)? $parent : "" }}</a></li>
    <li><i class="ace-icon home-icon"></i><a href="{{ $option_route }}">{{ isset($title)? $title : "" }}</a></li>
    <li class="active">Update</li>
@endsection

@section('content')

    <div class="card card-body">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h1>ISSAT</h1>
                        <form action="{{ route("etablissementUpdate", ["slug"=>$data->id]) }}" method="post">
                            @csrf
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon bg-white">
                                        <i class="">&nbsp;Nom</i>
                                    </span>
                                    <input class="form-control input-mask-phone" type="text" id="form-field-mask-2" name="etname" value="{{ $data->scoolname }}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon bg-white">
                                        <i class="">&nbsp;Email</i>
                                    </span>
                                    <input class="form-control input-mask-phone" type="text" id="form-field-mask-2" name="etemail" value="{{ $data->schoolEmail }}"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon bg-white">
                                        <i>Telephone</i>
                                    </span>
                                    <input class="form-control input-mask-phone" type="text" id="form-field-mask-2" name="etphone" value="{{ $data->schoolPhone }}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon bg-white">
                                        <i>Boite postale</i>
                                    </span>
                                    <input class="form-control input-mask-phone" type="text" id="form-field-mask-2" name="etpobox" value="{{ $data->schoolPobox }}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon bg-white">
                                        <i>Localisation</i>
                                    </span>
                                    <input class="form-control input-mask-phone" type="text" id="form-field-mask-2" name="etadresse" value="{{ $data->schoolAdresse }}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon bg-white">
                                        <i>Site internet</i>
                                    </span>
                                    <input class="form-control input-mask-phone" type="text" id="form-field-mask-2" name="etsite" value="{{ $data->schoolSite }}" />
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
