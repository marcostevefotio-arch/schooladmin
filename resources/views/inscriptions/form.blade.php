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
            @if(!isset($data))
            <div class="card">
                <div class="card-body">
                    <form action="{{ route("inscriptionNewInscription") }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="allEtudiant"></label>
                            <select class="form-control text-center" id="allEtudiant" name="allEtudiant">
                                <option value="---">Rehercher un etudiants existant</option>
                                @foreach($etudiants as $et)
                                    <option value="{{ $et->etID }}">({{ $et->matriculeDossier }}) {{ $et->firstname }} {{ $et->lastname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-sm btn-block" id="validate" disabled>Inscrire maintenant</button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <div class="widget-box">
                        @if(Session::has("error"))
                            <div class="alert alert-danger">
                                {{ Session::get("error") }}
                            </div>
                        @endif
                        @if(Session::has("success"))
                            <div class="alert alert-success">
                                {{ Session::get("success") }}
                            </div>
                        @endif
                        <div class="widget-header widget-header-blue widget-header-flat">
                            <h4 class="widget-title lighter">Formulaire d'inscription</h4>

                            <div class="widget-toolbar">
                                <label>
                                    <small class="green">
                                        <b>Validation</b>
                                    </small>

                                    <input id="skip-validation" type="checkbox" class="ace ace-switch ace-switch-4" />
                                    <span class="lbl middle"></span>
                                </label>
                            </div>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main">
                                <div id="fuelux-wizard-container">
                                    <div>
                                        <ul class="steps">
                                            <li data-step="1" class="active">
                                                <span class="step">1</span>
                                            </li>

                                            <li data-step="2">
                                                <span class="step">2</span>
                                            </li>

                                            <li data-step="3">
                                                <span class="step">3</span>
                                            </li>

                                            <li data-step="4">
                                                <span class="step">4</span>
                                            </li>

                                            <li data-step="5">
                                                <span class="step">5</span>
                                            </li>
                                        </ul>
                                    </div>

                                    <hr />

                                    <div class="step-content pos-rel"  style="padding: 0px 50px">
                                        <form action="{{ isset($data)? route("inscriptionUpdate", ["slug"=>$data->id]) : route("inscriptionStore") }}" method="post" id="formInscription" enctype="multipart/form-data">
                                            @csrf
                                            <div class="step-pane active" data-step="1">
                                                <h3 class="lighter block green">INFORMATION DE BASE</h3>
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group">
                                                            <label for="">
                                                                <h5>N° de dossier *</h5>
                                                            </label>
                                                            <input type="text" readonly name="dossier" id="dossier" class="form-control" value="{{ !empty($year)? (isset($data)? $data->dossier->numeroDossier : (($max<10)? "000".$max : (($max<100)? "000".$max : (($max<1000)? "00".$max : (($max<10)? "0".$max : $max ))))."/".date("y", strtotime($year->numeroAnnee."-01-01"))) : ""  }}" placeholder="Numero de dossier du candidat">
                                                            <input type="hidden" name="matricule" id="matricule" class="form-control" value="{{ !empty($year)? (isset($data)? $data->dossier->matriculeDossier : date("Y", strtotime($year->numeroAnnee."-01-01")).(($max<10)? "IFPSTA000".$max : (($max<100)? "IFPSTA00".$max : (($max<1000)? "IFPSTA0".$max : (($max<10000)? "IFPSTA".$max : $max ))))) : ""  }}" placeholder="Numero de dossier du candidat">
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-12  col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <h5 class="">Cycle de formation *</h5>
                                                            </label>

                                                            <select class="form-control @error('cycle') is-invalid @enderror" id="cycle" name="cycle" value="{{ isset($data)? $data->cycle_id : old('cycle') }}">
                                                                <option value=""></option>
                                                                @foreach($cycle as $c)
                                                                    <option value="{{ $c->id }}" {{ (isset($data) && $data->dossier->cycle_id==$c->id)?  "selected" : "" }}>{{ $c->codeCycle }} : {{ $c->titreCycle }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('cycle')
                                                            <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                            @enderror
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-12  col-md-12">
                                                        <div class="card card-body bg-dark">
                                                            <h4>Formation</h4>
                                                            <table class="table table-responsive-lg table-bordered">
                                                                <thead style="background: rgb(255,193,7);">
                                                                <th>Premier choix</th>
                                                                <th>Deuxieme choix</th>
                                                                <th>Troixieme choix</th>
                                                                </thead>
                                                                <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <label>Domaine 1 *</label>
                                                                        <select class="form-control @error('formation') is-invalid @enderror" id="formation1" name="formation1" value="{{ isset($data)? $data->formation : old('formation1') }}">
                                                                            <option value=""></option>
                                                                            @if(isset($filiere))
                                                                                @foreach($filiere as $f)
                                                                                <option value="{{ $f->id }}" {{ (empty($data->choice))? "" :  (($data->choice[0]->specialite->filiere->codeFiliere==$f->codeFiliere)?  "selected" : "") }}>{{ $f->libelleFiliere }}</option>
                                                                                @endforeach
                                                                            @endif                                                                  </select>
                                                                        @error('formation1')
                                                                        <span class="invalid-feedback" role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                        @enderror
                                                                    </td>

                                                                    <td>
                                                                        <label>Domaine 2 *</label>
                                                                        <select class="form-control @error('formation') is-invalid @enderror" id="formation2" name="formation2" value="{{ isset($data)? $data->formation : old('formation2') }}">
                                                                            <option value=""></option>
                                                                            @foreach($filiere as $f)
                                                                                <option value="{{ $f->id }}" {{ (empty($data->choice))? "" :  (($data->choice[0]->specialite->filiere->codeFiliere==$f->codeFiliere)?  "selected" : "") }}>{{ $f->libelleFiliere }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @error('formation2')
                                                                        <span class="invalid-feedback" role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                        @enderror
                                                                    </td>

                                                                    <td>
                                                                        <label>Domaine 3 *</label>
                                                                        <select class="form-control @error('formation') is-invalid @enderror" id="formation3" name="formation3" value="{{ isset($data)? $data->formation : old('formation3') }}">
                                                                            <option value=""></option>
                                                                            @foreach($filiere as $f)
                                                                                <option value="{{ $f->id }}" {{ (empty($data->choice))? "" :  (($data->choice[0]->specialite->filiere->codeFiliere==$f->codeFiliere)?  "selected" : "") }}>{{ $f->libelleFiliere }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @error('formation3')
                                                                        <span class="invalid-feedback" role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                        @enderror
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                        <label>Spécialité 1 *</label>

                                                                        <select  class="form-control @error('speciality') is-invalid @enderror" id="speciality1" name="speciality1" value="{{ isset($data)? $data->speciality : old('speciality') }}" required>
                                                                            {{--@if(isset($data))--}}
                                                                            {{--<option value="{{ $data->choice[0]->specialite_id }}">{{ $data->choice[0]->specialite->libelleSpecialite }}</option>--}}
                                                                            {{--@endif--}}
                                                                        </select>

                                                                        @error('speciality1')
                                                                        <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                        @enderror
                                                                    </td>

                                                                    <td>
                                                                        <label>Spécialité 2 *</label>

                                                                        <select  class="form-control @error('speciality') is-invalid @enderror" id="speciality2" name="speciality2" value="{{ isset($data)? $data->speciality : old('speciality') }}" required>
                                                                            {{--@if(isset($data))--}}
                                                                            {{--<option value="{{ $data->choice[1]->specialite_id }}">{{ $data->choice[1]->specialite->libelleSpecialite }}</option>--}}
                                                                            {{--@endif--}}
                                                                        </select>

                                                                        @error('speciality2')
                                                                        <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                        @enderror
                                                                    </td>
                                                                    <td>
                                                                        <label>Spécialité 3*</label>

                                                                        <select  class="form-control @error('speciality') is-invalid @enderror" id="speciality3" name="speciality3" value="{{ isset($data)? $data->speciality : old('speciality') }}" required>
                                                                            {{--@if(isset($data))--}}
                                                                            {{--<option value="{{ $data->choice[2]->specialite_id }}">{{ $data->choice[2]->specialite->libelleSpecialite }}</option>--}}
                                                                            {{--@endif--}}
                                                                        </select>

                                                                        @error('speciality3')
                                                                        <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                        @enderror
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-4 col-md-12">
                                                        <div class="form-group">
                                                            <label for="">
                                                                <h5>Niveau *</h5>
                                                            </label>
                                                            <select class="form-control @error('level') is-invalid @enderror" id="level" name="level" value="{{ isset($data)? $data->level : old('level') }}">
                                                                <option value=""></option>
                                                                @foreach($level as $l)
                                                                    <option value="{{ $l->id }}" {{ isset($data) && $data->level_id==$l->id? "selected" : "" }}>{{ $l->numeroLevel }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('level')
                                                            <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4  col-md-12">
                                                        <div class="form-group">
                                                            <label for="">
                                                                <h5>Année *</h5>
                                                            </label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control input-mask-date" style="width: 100%" name="start" id="start" placeholder="Debut" value="{{ isset($data)?  $data->anneacademique->numeroAnnee : $year->numeroAnnee }}" required readonly>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-4  col-md-12">
                                                        <div class="form-group">
                                                            <label for="">
                                                                <h5>Date de depot de dossier *</h5>
                                                            </label>
                                                            <input class="form-control date-picker" name="depositeDate" id="id-date-picker-1" type="text" data-date-format="yyyy-mm-dd" min="1997-01-01" placeholder="Date de dépot du dossier du candidat" value="{{ isset($data)?  date("Y-m-d", strtotime($data->dateInscription)) : date("Y-m-d")}}"/>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="step-pane" data-step="2">
                                                <h3 class="lighter block green">IDENTIFICATION DU CANDIDAT</h3>
                                                <div class="card card-body">
                                                    <div class="row">
                                                        <div class="col-lg-9  col-md-12">
                                                            <div class="col-lg-6  col-md-12">
                                                                <div class="form-group">
                                                                    <label>
                                                                        <h5 class="">Nom *</h5>
                                                                    </label>
                                                                    <input placeholder="Prénom du candidat" class="form-control @error('lastname') is-invalid @enderror" type="text" id="lastname" name="lastname" value="{{ isset($data)? $data->dossier->etudiant->lastname : old('lastname') }}" required/>

                                                                    @error('lastname')
                                                                    <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-md-12">
                                                                <div class="form-group">
                                                                    <label>
                                                                        <h5 class="">Prénom(s) </h5>
                                                                    </label>
                                                                    <input placeholder="Nom du candidat" class="form-control @error('firstname') is-invalid @enderror" type="text" id="firstname" name="firstname" value="{{ isset($data)? $data->dossier->etudiant->firstname : old('firstname') }}" required/>

                                                                    @error('firstname')
                                                                    <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-md-12">
                                                                <div class="form-group">
                                                                    <label>
                                                                        <h5 class="">Date de naissance *</h5>
                                                                    </label>
                                                                    <input class="form-control date-picker" name="birthday" id="id-date-picker-1" type="text" data-date-format="yyyy-mm-dd" min="1930-01-01" value="{{ isset($data)? $data->dossier->etudiant->birthday : old('birthday') }}" placeholder="Date de naissance"/>

                                                                    @error('birthday')
                                                                    <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-md-12">
                                                                <div class="form-group">
                                                                    <label>
                                                                        <h5 class="">Lieu de naissance *</h5>
                                                                    </label>
                                                                    <input placeholder="Lieu de naissance" class="form-control  @error('birthplace') is-invalid @enderror" type="text" id="birthplace" name="birthplace" value="{{ isset($data)? $data->dossier->etudiant->birthplace : old('birthplace') }}" required/>

                                                                    @error('birthplace')
                                                                    <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                    @enderror
                                                                </div>
                                                            </div>


                                                            <div class="col-lg-6 col-md-12">
                                                                <div class="form-group">
                                                                    <label>
                                                                        <h5 class="">Sexe *</h5>
                                                                    </label>

                                                                    <select class="form-control  @error('language') is-invalid @enderror" id="sexe" name="sexe" required>
                                                                        <option value=""></option>
                                                                        <option value="MASCULIN" {{ isset($data)? (($data->dossier->etudiant->sexe=="MASCULIN")? "selected" : "") : "" }}>Masculin</option>
                                                                        <option value="FEMININ" {{ isset($data)? (($data->dossier->etudiant->sexe=="FEMININ")? "selected" : "") : "" }}>Féminin</option>
                                                                    </select>

                                                                    @error('language')
                                                                    <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-md-12">
                                                                <div class="form-group">
                                                                    <label>
                                                                        <h5 class="">Nationalité *</h5>
                                                                    </label>

                                                                    <div class="input-group">
                                                                        <select class="form-control  @error('nationality') is-invalid @enderror" id="nationality" name="nationality" required>
                                                                            <option></option>
                                                                            @foreach($pays as $p)
                                                                                <option {{ isset($data)? (($data->dossier->etudiant->nationality==$p->nomPays)? "selected" : "") : old('nationality') }}>{{ $p->nomPays }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        <span class="input-group-addon"><a href="{{ route("paysCreate") }}" title="Enregistrer un nouveau"><i class="fa fa-plus"></i></a></span>
                                                                    </div>

                                                                    @error('nationality')
                                                                    <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-md-12">
                                                                <div class="form-group">
                                                                    <label>
                                                                        <h5 class="">Region *</h5>
                                                                    </label>

                                                                    <div class="input-group">
                                                                        <select class="form-control  @error('region') is-invalid @enderror" id="region" name="region" required>
                                                                            <option></option>
                                                                            @foreach($region as $r)
                                                                                <option {{ isset($data)? (($data->dossier->etudiant->region==$r->nomRegion)? "selected" : "") : old('nationality') }}>{{ $r->nomRegion }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        <span class="input-group-addon"><a href="{{ route("regionCreate") }}" title="Enregistrer un nouveau"><i class="fa fa-plus"></i></a></span>
                                                                    </div>
                                                                    @error('region')
                                                                    <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-md-12">
                                                                <div class="form-group">
                                                                    <label>
                                                                        <h5 class="">Télephone *</h5>
                                                                    </label>
                                                                    <input placeholder="Contact téléphonique" class="form-control input-mask-phone @error('phone') is-invalid @enderror" type="text" id="phone" name="phone" value="{{ isset($data)? $data->dossier->etudiant->phonenumber : old('phone') }}" required/>

                                                                    @error('phone')
                                                                    <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-md-12">
                                                                <div class="form-group">
                                                                    <label>
                                                                        <h5 class="">E-mail *</h5>
                                                                    </label>
                                                                    <input placeholder="Adresse email du candidat" class="form-control  @error('email') is-invalid @enderror" type="email" id="email" name="email" value="{{ isset($data)? $data->dossier->etudiant->email : old('email') }}" required/>

                                                                    @error('email')
                                                                    <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-md-12">
                                                                <div class="form-group">
                                                                    <label>
                                                                        <h5 class="">Adresse de résidence *</h5>
                                                                    </label>
                                                                    <input placeholder="Adresse de residence" class="form-control  @error('residence') is-invalid @enderror" type="text" id="residence" name="residence" value="{{ isset($data)? $data->dossier->etudiant->residence : old('residence') }}" required/>

                                                                    @error('residence')
                                                                    <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-md-12">
                                                                <div class="form-group">
                                                                    <label>
                                                                        <h5 class="">Langues officielles *</h5>
                                                                    </label>

                                                                    <select class="form-control  @error('language') is-invalid @enderror" id="language" name="language" required>
                                                                        <option value=""></option>
                                                                        <option value="english" {{ isset($data)? (($data->dossier->etudiant->language=="english")? "selected" : "") : "" }}>Anglais</option>
                                                                        <option value="frensh" {{ isset($data)? (($data->dossier->etudiant->language=="frensh")? "selected" : "") : "" }}>Francais</option>
                                                                    </select>

                                                                    @error('language')
                                                                    <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-12">
                                                            <div class="form-group">
                                                                <br>
                                                                <img src="{{ (isset($data) && !empty($data->dossier->etudiant->photo))? $data->dossier->etudiant->photo : "assets/images/avatars/avatar.png" }}" alt="" class="img-fluid" style="width:100%">
                                                                <input type="file" name="photo" id="photo" class="file-image" title="Choisir un fichier">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="step-pane" data-step="3">
                                                <h3 class="lighter block green">PROFIL SCOLAIRE</h3>
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group">
                                                            <label for="diploma">
                                                                <h5 class="">Diplôme d’admission *</h5>
                                                            </label>
                                                            <div class="input-group">
                                                                <select class="form-control  @error('diploma') is-invalid @enderror" id="diploma" name="diploma" required>
                                                                    <option></option>
                                                                    @foreach($diplome as $d)
                                                                        <option {{ isset($data)? (($data->dossier->parcours[0]->admissiondiploma==$d->intuleDiplome)? "selected" : "") : old('school') }}>{{ $d->intuleDiplome }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <span class="input-group-addon"><a href="{{ route("diplomeCreate") }}" title="Enregistrer un nouveau"><i class="fa fa-plus"></i></a></span>
                                                            </div>
                                                            @error('diploma')
                                                            <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group">
                                                            <label for="serie">
                                                                <h5 class="">Serie *</h5>
                                                            </label>
                                                            <input class="form-control  @error('serie') is-invalid @enderror" type="text" id="serie" name="serie" value="{{ isset($data)? $data->dossier->parcours[0]->option : old('serie') }}" placeholder="Serie" required/>

                                                            @error('serie')
                                                            <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group">
                                                            <label for="yearobtain">
                                                                <h5 class="">Année d’obtention *</h5>
                                                            </label>
                                                            <input class="form-control  @error('yearobtain') is-invalid @enderror" type="text" id="yearobtain" name="yearobtain" value="{{ isset($data)? $data->dossier->parcours[0]->schoolyear : old('yearobtain') }}" required/>

                                                            @error('yearobtain')
                                                            <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <h5 class="">Pays d’obtention *</h5>
                                                            </label>
                                                            <div class="input-group">
                                                                <select class="form-control  @error('countryobtain') is-invalid @enderror" id="countryobtain" name="countryobtain" required>
                                                                    <option></option>
                                                                    @foreach($pays as $p)
                                                                        <option {{ isset($data)? (($data->dossier->parcours[0]->diplomacountry==$p->nomPays)? "selected" : "") : old('countryobtain') }}>{{ $p->nomPays }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <span class="input-group-addon"><a href="{{ route("paysCreate") }}" title="Enregistrer un nouveau"><i class="fa fa-plus"></i></a></span>
                                                            </div>


                                                            @error('countryobtain')
                                                            <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <h5 class="">Etablissement *</h5>
                                                            </label>
                                                            <div class="input-group">
                                                                <select class="form-control  @error('school') is-invalid @enderror" id="school" name="school" required>
                                                                    <option></option>
                                                                    @foreach($ecole as $e)
                                                                        <option {{ isset($data)? (($data->dossier->parcours[0]->school==$e->nomEcole)? "selected" : "") : old('school') }}>{{ $e->nomEcole }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <span class="input-group-addon"><a href="{{ route("ecoleCreate") }}" title="Enregistrer un nouveau"><i class="fa fa-plus"></i></a></span>
                                                            </div>

                                                            @error('school')
                                                            <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="step-pane" data-step="4">
                                                <h3 class="lighter block green">ANTECEDENTS MEDICAUX</h3>
                                                <div class="row">
                                                    <div class="col-lg-12  col-md-12">
                                                        <table class="table table-bordered table-responsive-lg">
                                                            <thead  >
                                                            <th>Maladie</th>
                                                            <th>Derniere consultation</th>
                                                            <th>état</th>
                                                            <th><button type="button" id="addAntecedant" class="btn btn-sm btn-primary">Ajouter</button></th>
                                                            </thead>
                                                            <tbody id="antecedants">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="step-pane" data-step="5">
                                                <h3 class="lighter block green">INFORMATIONS COMPLEMENTAIRES</h3>
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <h5 class="">Noms du père</h5>
                                                            </label>
                                                            <input class="form-control  @error('fathername') is-invalid @enderror" type="text" id="fathername" name="fathername" value="{{ isset($data)? $data->dossier->etudiant->parents->fathername : old('fathername') }}" required/>

                                                            @error('fathername')
                                                            <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <h5 class="">Profession</h5>
                                                            </label>
                                                            <input class="form-control  @error('fatherprofession') is-invalid @enderror" type="text" id="fatherprofession" name="fatherprofession" value="{{ isset($data)? $data->dossier->etudiant->parents->fatherprofession : old('fatherprofession') }}" required/>

                                                            @error('fatherprofession')
                                                            <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <h5 class="">Contact</h5>
                                                            </label>
                                                            <input class="form-control  @error('fathercontact') is-invalid @enderror" type="text" id="fathercontact" name="fathercontact" value="{{ isset($data)? $data->dossier->etudiant->parents->fathercontact : old('fathercontact') }}" required/>

                                                            @error('fathercontact')
                                                            <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <h5 class="">Noms de la mère</h5>
                                                            </label>
                                                            <input class="form-control  @error('mothername') is-invalid @enderror" type="text" id="mothername" name="mothername" value="{{ isset($data)? $data->dossier->etudiant->parents->mothername : old('mothername') }}" required/>

                                                            @error('mothername')
                                                            <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <h5 class="">Profession</h5>
                                                            </label>
                                                            <input class="form-control  @error('motherprofession') is-invalid @enderror" type="text" id="motherprofession" name="motherprofession" value="{{ isset($data)? $data->dossier->etudiant->parents->motherprofession : old('motherprofession') }}" required/>

                                                            @error('motherprofession')
                                                            <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <h5 class="">Contact</h5>
                                                            </label>
                                                            <input class="form-control  @error('mothercontact') is-invalid @enderror" type="text" id="mothercontact" name="mothercontact" value="{{ isset($data)? $data->dossier->etudiant->parents->mothercontact : old('mothercontact') }}" required/>

                                                            @error('mothercontact')
                                                            <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <h5 class="">Personne à contacter *</h5>
                                                            </label>
                                                            <input class="form-control  @error('emergencepersonne') is-invalid @enderror" type="text" id="emergencepersonne" name="emergencepersonne" value="{{ isset($data)? $data->dossier->etudiant->parents->emergencyname : old('emergencepersonne') }}" required/>

                                                            @error('emergencepersonne')
                                                            <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <h5 class="">Contact *</h5>
                                                            </label>
                                                            <input class="form-control  @error('emergencecontact') is-invalid @enderror" type="text" id="emergencecontact" name="emergencecontact" value="{{ isset($data)? $data->dossier->etudiant->parents->emergencycontact : old('emergencecontact') }}" required/>

                                                            @error('emergencecontact')
                                                            <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <h5 class="">Sport préféré</h5>
                                                            </label>
                                                            <input class="form-control  @error('bestsport') is-invalid @enderror" type="text" id="bestsport" name="bestsport" value="{{ isset($data)? $data->dossier->etudiant->sport : old('bestsport') }}" required/>

                                                            @error('bestsport')
                                                            <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <h5 class="">Loisir</h5>
                                                            </label>
                                                            <input class="form-control  @error('leisure') is-invalid @enderror" type="text" id="leisure" name="leisure" value="{{ isset($data)? $data->dossier->etudiant->leisure : old('leisure') }}" required/>

                                                            @error('leisure')
                                                            <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <h5 class="">Divers</h5>
                                                            </label>
                                                            <textarea class="form-control  @error('leisure') is-invalid @enderror" id="divers" row="4" name="divers">{{ isset($data)? $data->dossier->etudiant->leisure : old('leisure') }}</textarea>

                                                            @error('leisure')
                                                            <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <hr />
                                <div class="wizard-actions">
                                    <button class="btn btn-prev">
                                        <i class="ace-icon fa fa-arrow-left"></i>
                                        Précedent
                                    </button>

                                    <button class="btn btn-success btn-next" data-last="Terminer">
                                        Suivant
                                        <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                                    </button>
                                </div>
                            </div><!-- /.widget-main -->
                        </div><!-- /.widget-body -->
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section("style")
    <link rel="stylesheet" href="{{ asset("") }}assets/css/chosen.css" />
@endsection

@section("script")

    <script src="assets/js/bootstrap-datepicker.min.js"></script>
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/daterangepicker.min.js"></script>


    <script src="assets/js/wizard.min.js"></script>
    <script src="assets/js/jquery.validate.min.js"></script>
    <script src="assets/js/jquery-additional-methods.min.js"></script>
    <script src="assets/js/bootbox.js"></script>
    <script src="assets/js/jquery.maskedinput.min.js"></script>
    <script src="assets/js/select2.min.js"></script>

    <script src="{{ asset("") }}assets/js/chosen.jquery.js"></script>


    <!-- inline scripts related to this page -->
    <script type="text/javascript">
        jQuery(function($) {

            $('[data-rel=tooltip]').tooltip();

            $('.select2').css('width','200px').select2({allowClear:true})
                .on('change', function(){
                    $(this).closest('form').validate().element($(this));
                });


            var $validation = false;
            $('#fuelux-wizard-container')
                .ace_wizard({
                    //step: 2 //optional argument. wizard will jump to step "2" at first
                    //buttons: '.wizard-actions:eq(0)'
                })
                .on('actionclicked.fu.wizard' , function(e, info){
                    if(info.step == 1 && $validation) {
                        if(!$('#validation-form').valid()) e.preventDefault();
                    }
                })
                .on('finished.fu.wizard', function(e) {
                    $("#formInscription").submit();

//                    bootbox.dialog({
//                        message: "Thank you! Your information was successfully saved!",
//                        buttons: {
//                            "success" : {
//                                "label" : "OK",
//                                "className" : "btn-sm btn-primary"
//                            }
//                        }
//                    });
                }).on('stepclick.fu.wizard', function(e){
            });

            $('#skip-validation').removeAttr('checked').on('click', function(){
                $validation = this.checked;
                if(this.checked) {
                    $('#sample-form').hide();
                    $('#validation-form').removeClass('hide');
                }
                else {
                    $('#validation-form').addClass('hide');
                    $('#sample-form').show();
                }
            })

        })
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            @if(isset($data))
                @if(count($data->choice)>0)
                    $.ajax({
                        url: "{{ route("filiereJson") }}",
                        data: {filiere: $("#formation1").val()},
                        dataType: "json",
                        type: "get",
                        success: function(response){
                            $("#speciality1").empty();
                            $("#speciality1").append('<option value=""></option>');
                            if(response.length!=0){
                                response.forEach(function(item, index){

                                    if(item.id=={{ $data->choice[0]->specialite->id }}){
                                        $("#speciality1").append('<option value="'+item.id+'" selected>'+item.libelleSpecialite+'</option>');
                                    }else{
                                        $("#speciality1").append('<option value="'+item.id+'">'+item.libelleSpecialite+'</option>');
                                    }
                                });

                            }else{
                                $("#speciality1").empty();
                                $("#speciality1").append('<option value=""></option>');
                            }
                        },
                    })

                    $.ajax({
                        url: "{{ route("filiereJson") }}",
                        data: {filiere: $("#formation2").val()},
                        dataType: "json",
                        type: "get",
                        success: function(response){
                            $("#speciality2").empty();
                            $("#speciality2").append('<option value=""></option>');

                            if(response.length!=0){
                                response.forEach(function(item, index){
                                    if(item.id=={{ $data->choice[1]->specialite->id }}){
                                        $("#speciality2").append('<option value="'+item.id+'" selected>'+item.libelleSpecialite+'</option>');
                                    }else{
                                        $("#speciality2").append('<option value="'+item.id+'">'+item.libelleSpecialite+'</option>');
                                    }
                                });

                            }else{
                                $("#speciality2").empty();
                                $("#speciality2").append('<option value=""></option>');
                            }
                        },
                    })

                    $.ajax({
                        url: "{{ route("filiereJson") }}",
                        data: {filiere: $("#formation3").val()},
                        dataType: "json",
                        type: "get",
                        success: function(response){
                            $("#speciality3").empty();
                            $("#speciality3").append('<option value=""></option>');

                            if(response.length!=0){
                                response.forEach(function(item, index){
                                    if(item.id=={{ $data->choice[2]->specialite->id }}){
                                        $("#speciality3").append('<option value="'+item.id+'" selected>'+item.libelleSpecialite+'</option>');
                                    }else{
                                        $("#speciality3").append('<option value="'+item.id+'">'+item.libelleSpecialite+'</option>');
                                    }
                                });

                            }else{
                                $("#speciality3").empty();
                                $("#speciality3").append('<option value=""></option>');
                            }
                        },
                    })
                @endif
            @endif

            $("#formation1").change(function(){
                var filiere = $(this).val();
                $.ajax({
                    url: "{{ route("filiereJson") }}",
                    data: {filiere: $(this).val()},
                    dataType: "json",
                    type: "get",
                    success: function(response){
                        $("#speciality1").empty();
                        $("#speciality1").append('<option value=""></option>');
                        if(response.length!=0){
                            response.forEach(function(item, index){
                                $("#speciality1").append('<option value="'+item.id+'">'+item.libelleSpecialite+'</option>');
                            });

                        }else{
                            $("#speciality1").empty();
                            $("#speciality1").append('<option value=""></option>');
                        }
                    },
                })
            });

            $("#formation2").change(function(){
                var filiere = $(this).val();
                $.ajax({
                    url: "{{ route("filiereJson") }}",
                    data: {filiere: $(this).val()},
                    dataType: "json",
                    type: "get",
                    success: function(response){
                        $("#speciality2").empty();
                        $("#speciality2").append('<option value=""></option>');

                        if(response.length!=0){
                            response.forEach(function(item, index){
                                $("#speciality2").append('<option value="'+item.id+'">'+item.libelleSpecialite+'</option>');
                            });

                        }else{
                            $("#speciality2").empty();
                            $("#speciality2").append('<option value=""></option>');
                        }
                    },
                })
            });

            $("#formation3").change(function(){
                var filiere = $(this).val();
                $.ajax({
                    url: "{{ route("filiereJson") }}",
                    data: {filiere: $(this).val()},
                    dataType: "json",
                    type: "get",
                    success: function(response){
                        $("#speciality3").empty();
                        $("#speciality3").append('<option value=""></option>');

                        if(response.length!=0){
                            response.forEach(function(item, index){
                                $("#speciality3").append('<option value="'+item.id+'">'+item.libelleSpecialite+'</option>');
                            });

                        }else{
                            $("#speciality3").empty();
                            $("#speciality3").append('<option value=""></option>');
                        }
                    },
                })
            });

            $('.date-picker').datepicker({
                autoclose: true,
                todayHighlight: true
            })
            //show datepicker when clicking on the icon
                .next().on(ace.click_event, function(){
                $(this).prev().focus();
            });
            $('.input-mask-date').mask('9999');
            $('.input-mask-phone').mask('999 999 999');




            $("#addAntecedant").click(function(){
                var count = $("#antecedants").find("tr").length;

                if(count<10){
                    var html = "<tr id='"+count+"'>";
                    html += "<td><input type='text' name='maladie"+count+"' placeholder='Maladie "+(count+1)+"'/></td>";
                    html += "<td><input type='date' name='dateConsultation"+count+"' placeholder='Date de derniere consultation' /></td>";
                    html += "<td><input type='text' name='etat"+count+"' placeholder='Observation'/></td>";
                    html += "<td><button type='button' class='btn btn-danger antecedant' onclick='removeItem("+count+")'><i class='fa fa-trash'></i></button></td>";
                    html += "</tr>";
                    $("#antecedants").append(html);
                }
            });

            $(".antecedant").click(function(){
                alert("bien")
            })



        });

        function removeItem(id){
            $("#"+id).remove();
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#allEtudiant").chosen({
                no_results_text: "Oops, nothing found!",
                width: "100%",
            });

            $("#allEtudiant").change(function(){
                var mylist = $(this).val();
                if(mylist){
//                    $("#validate").removeAttr("disabled");
                    document.getElementById("validate").removeAttribute("disabled")
                }else{
                    console.log(mylist);
                    document.getElementById("validate").setAttribute("disabled","");
                }
            })
        });
    </script>
@endsection
