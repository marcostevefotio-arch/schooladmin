@extends('layouts.layout')

@section('title')
    {{ isset($title)? $title : "" }}
@endsection

@section('breadcrum')
    <li><i class="ace-icon fa fa-home home-icon"></i><a href="{{ route("home") }}">Home</a></li>
    <li><i class="ace-icon home-icon"></i><a href="{{ isset($module)? route($module->code_menu) : "" }}">{{ isset($parent)? $parent : "" }}</a></li>
    <li><i class="ace-icon home-icon"></i><a href="{{ $option_route }}">{{ isset($title)? $title : "" }}</a></li>
    <li class="active">Create</li>
@endsection

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="card card-body">
                <table class="table table-bordered table-responsive-lg table-striped">
                    <tr>
                        <td colspan="2">
                            <h2>({{ $data->codeMatiere }}){{ $data->libelleMatiere }}</h2>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="col-xs-3">
            <div class="card card-body">
                <label for="">Code de l'UE</label>
                <h4>{{ $data->ues->codeUE }}</h4>
                <hr>
                <label for="">Intitulé de l'UE</label>
                <h4>{{ $data->ues->libelleUE }}</h4>
                <hr>
                <label for="">Nombre de crédits</label>
                <h4>{{ $data->ues->credit }}</h4>
                <hr>
            </div>
        </div>
        <div class="col-xs-9">
            <div class="card card-body">
                <table class="table table-bordered table-responsive-lg table-striped">
                    <tr>
                        <td colspan="2">
                            <h2>({{ $data->ues->codeUE }}){{ $data->ues->libelleUE }}</h2>
                        </td>
                    </tr>
                    <tr>
                        <td>Semestre</td>
                        <td>{{ $data->ues->semestre->libelleSemestre }}</td>
                    </tr>
                    <tr>
                        <td>Spécialité</td>
                        <td>{{ $data->ues->specialite->libelleSpecialite }}</td>
                    </tr>
                    <tr>
                        <td>CM</td>
                        <td>{{ $data->ues->cm }}</td>
                    </tr>
                    <tr>
                        <td>TD</td>
                        <td>{{ $data->ues->td }}</td>
                    </tr>
                    <tr>
                        <td>TP</td>
                        <td>{{ $data->ues->tp }}</td>
                    </tr>
                    <tr>
                        <td>TPE</td>
                        <td>{{ $data->ues->tpe }}</td>
                    </tr>
                    <tr>
                        <td>TOTAL</td>
                        <td>{{ $data->ues->total }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

@endsection


@section("script")

@endsection
