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
            <div class="card" style="background: #569bff">
                <div class="card-body" style="background: #569bff; color: #ffffff">
                    <table class="table table-bordered table-responsive-lg bg-transparent">
                        <tr>
                            <td colspan="2">
                                <h5>Dossier N° : {{ $data->inscription->dossier->numeroDossier }}</h5>
                                <h5>Matricule N° : {{ $data->inscription->dossier->matriculeDossier }}</h5>
                                <h5>Nom et prénom : {{ $data->inscription->dossier->etudiant->firstname }} {{ $data->inscription->dossier->etudiant->lastname }}</h5>
                                <h5>Spécialité : {{ $data->scolarite->specialite->libelleSpecialite }}</h5>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-xs-12">
            <div class="card card-body" style="background: #569bff; color: #ffffff">
                <table class="table table-bordered">
                    <tr>
                        <td>CODE : {{ $data->codeVerssement }}</td>
                        <td>{{ $data->scolarite->compte->libelleCompte }}</td>
                        <td>{{ $data->montantVerssement }}</td>
                        <td>{{ date("d/m/Y", strtotime($data->dateVerssement)) }}</td>
                        <td>{{ $data->descriptionVerssement }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="col-xs-12">
            <div class="card card-body">
                <h4>Autres verssements</h4>
                <table class="table table-bordered table-striped">
                    @foreach($data->inscription->verssement as $v)
                        @if($v->id != $data->id)
                            <tr>
                                <td>CODE : {{ $v->codeVerssement }}</td>
                                <td>{{ $v->scolarite->compte->libelleCompte }}</td>
                                <td>{{ $v->montantVerssement }}</td>
                                <td>{{ date("d/m/Y", strtotime($v->dateVerssement)) }}</td>
                                <td>{{ $v->descriptionVerssement }}</td>
                            </tr>
                        @endif
                    @endforeach
                </table>
            </div>
        </div>
        {{--<div class="col-xs-9">--}}
            {{--<div class="card card-body">--}}
                {{--<table class="table table-bordered table-responsive-lg table-striped">--}}
                    {{--<tr>--}}
                        {{--<td colspan="2">--}}
                            {{--<h2>({{ $data->ues->codeUE }}){{ $data->ues->libelleUE }}</h2>--}}
                        {{--</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td>Semestre</td>--}}
                        {{--<td>{{ $data->ues->semestre->libelleSemestre }}</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td>Spécialité</td>--}}
                        {{--<td>{{ $data->ues->specialite->libelleSpecialite }}</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td>CM</td>--}}
                        {{--<td>{{ $data->ues->cm }}</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td>TD</td>--}}
                        {{--<td>{{ $data->ues->td }}</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td>TP</td>--}}
                        {{--<td>{{ $data->ues->tp }}</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td>TPE</td>--}}
                        {{--<td>{{ $data->ues->tpe }}</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td>TOTAL</td>--}}
                        {{--<td>{{ $data->ues->total }}</td>--}}
                    {{--</tr>--}}
                {{--</table>--}}
            {{--</div>--}}
        {{--</div>--}}
    </div>

@endsection


@section("script")

@endsection
