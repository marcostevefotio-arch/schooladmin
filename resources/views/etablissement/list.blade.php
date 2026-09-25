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
            <div class="col-lg-6 col-md-6 text-center bg-info">
                <div class="card">
                    <div class="card-body">
                        <img src="assets/images/logo/issat.png" style="width: 350px; margin: auto"  class="img-fluid" alt="">
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3>{{ $data->scoolname }}</h3>
                        <hr>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon bg-white">
                                    <i class="">&nbsp;Email</i>
                                </span>
                                <input class="form-control input-mask-phone" type="text" id="form-field-mask-2" value="{{ $data->schoolEmail }}" disabled/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon bg-white">
                                    <i>Telephone</i>
                                </span>
                                <input class="form-control input-mask-phone" type="text" id="form-field-mask-2" value="{{ $data->schoolPhone }}" disabled />
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon bg-white">
                                    <i>Boite postale</i>
                                </span>
                                <input class="form-control input-mask-phone" type="text" id="form-field-mask-2" value="{{ $data->schoolPobox }}" disabled/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon bg-white">
                                    <i>Localisation</i>
                                </span>
                                <input class="form-control input-mask-phone" type="text" id="form-field-mask-2" value="{{ $data->schoolAdresse }}" disabled/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon bg-white">
                                    <i>Site internet</i>
                                </span>
                                <input class="form-control input-mask-phone" type="text" id="form-field-mask-2" value="{{ $data->schoolSite }}" disabled/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="btn-group">
                                <button class="btn btn-info" id="changeLogo"><i class="fa fa-camera">&nbsp;</i>Changer le logo</button>
                                <a href="{{ route("etablissementEdit", ["slug"=>$data->id]) }}" class="btn btn-primary">Mettre à jour les informations</a>
                                <form action="{{ route('logoChange') }}" method="post" enctype="multipart/form-data" id="imageForm">
                                    @csrf
                                    <input type="file" class="hidden" name="image" id="image" accept=".png">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-xs-12">
            <div class="table-header" style="background: #ffca04; color: #000;">
                Parametres par defaut
            </div>

            <div>
                <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Options</th>
                            <th>Description</th>
                            <th>Valeur</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach($param as $p)
                        <tr>
                            <td>{{ $p->option }}</td>
                            <td>{{ $p->description }}</td>
                            <td>{{ $p->valeur }}</td>
                            <td><a href="{{ route("parametreEdit", ["slug"=>$p->id]) }}"><i class="fa fa-edit" title="Modifier"></i></a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <hr>

    {{--<div class="row">--}}
        {{--<div class="col-xs-12">--}}
            {{--<div class="table-header" style="background: #ffca04; color: #000;">--}}
                {{--Sauvegarde et restauration--}}
            {{--</div>--}}

            {{--<div class="btn-group">--}}
                {{--<a href="" class="btn btn-info"><i class="fa fa-cloud-download"></i>&nbsp;Sauvegarde Cloud ver local</a>--}}
                {{--<a href="" class="btn btn-primary"><i class="fa fa-cloud-upload"></i>&nbsp;Restauration local ver cloud</a>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

    </div>
@endsection


@section("script")

    <script type="text/javascript">
        $(document).ready(function(){
            $("#changeLogo").click(function(){
                $("#image").click();
            });

            $("#image").change(function(){
                $("#imageForm").submit();
            });
        });
    </script>
@endsection
