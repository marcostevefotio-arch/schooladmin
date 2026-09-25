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

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route("inscriptionNewInscriptionStore") }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="level">Niveau</label>
                            <select class="form-control" id="level" name="level" required>
                                <option value=""></option>
                                @foreach($level as $l)
                                    @if($l->numeroLevel>=$maxlevel)
                                        <option value="{{ $l->id }}" }}>{{ $l->numeroLevel }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">
                                <h5>Date de depot de dossier *</h5>
                            </label>
                            <input class="form-control date-picker" name="depositeDate" id="id-date-picker-1" type="text" data-date-format="yyyy-mm-dd" min="1997-01-01" placeholder="Date de dépot du dossier du candidat" value="{{ isset($data)?  date("Y-m-d", strtotime($data->dateInscription)) : date("Y-m-d")}}"/>
                        </div>
                        <table class="table table-bordered">
                            <tr>
                                <td class="bg-primary">Dossier</td>
                                <td>{{ $etudiant->numeroDossier }}</td>
                                <td class="bg-primary">Matricule</td>
                                <td>{{ $etudiant->matriculeDossier }}</td>
                            </tr>

                            <tr>
                                <td class="bg-primary">Cycle</td>
                                <td colspan="3">{{ $etudiant->dossier[0]->cycle->codeCycle }}</td>
                            </tr>

                            <tr>
                                <td class="bg-primary">Specialite</td>
                                <td colspan="3">
                                    @foreach($inscription->choice as $k=>$c)
                                        @if($c->etat == 1)
                                            <i class="fa fa-check-circle text-success"></i>&nbsp;{{ $c->specialite->codeSpecialite }}={{ $c->specialite->libelleSpecialite }}
                                            <input type="hidden" name="choix{{ $k+1 }}" value="{{ $c->specialite_id }}">
                                            <input type="hidden" name="choixValide" value="{{ $c->specialite_id }}">
                                        @else
                                            <input type="hidden" name="choix{{ $k+1 }}" value="{{ $c->specialite_id }}">
                                        @endif
                                    @endforeach
                                    <input type="hidden" name="dossier" value="{{ $inscription->dossieretudiant_id }}">
                                </td>
                            </tr>
                            <tr>
                                <td class="bg-primary">Nom et prénom</td>
                                <td colspan="3">{{ $etudiant->firstname }} {{ $etudiant->lastname }}</td>
                            </tr>
                            <tr>
                                <td class="bg-primary">Date et lieu de naissance</td>
                                <td colspan="3">{{ $etudiant->birthday }} à {{ $etudiant->birthplace }}</td>
                            </tr>
                            <tr>
                                <td class="bg-primary">Sexe</td>
                                <td colspan="3">{{ $etudiant->sexe }}</td>
                            </tr>
                        </table>
                        <div class="form-group">
                            <button class="btn btn-primary btn-sm btn-block" id="validate" >Valider l'inscription maintenant</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


@section("style")
    <link rel="stylesheet" href="{{ asset("") }}assets/css/chosen.css" />
@endsection

@section("script")


    <script src="{{ asset("") }}assets/js/chosen.jquery.js"></script>


@endsection
