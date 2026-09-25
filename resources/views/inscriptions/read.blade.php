@extends('layouts.layout')

@section('title')
    {{ isset($title)? $title : "" }}
@endsection

@section('breadcrum')
    <li><i class="ace-icon fa fa-home home-icon"></i><a href="{{ route("home") }}">Home</a></li>
    <li><i class="ace-icon home-icon"></i><a href="{{ isset($module)? route($module->code_menu) : "" }}">{{ isset($parent)? $parent : "" }}</a></li>
    <li><i class="ace-icon home-icon"></i><a href="{{ $option_route }}">{{ isset($title)? $title : "" }}</a></li>
    <li class="active">Fiche</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    <div class="widget-box transparent">
                        <div class="widget-header widget-header-large">
                            <h3 class="widget-title grey lighter">
                                <i class="ace-icon fa fa-eye green"></i>
                                Fiche d'inscription
                            </h3>

                            <div class="widget-toolbar invoice-info">
                                <span class="invoice-info-label">N° de dossier :</span>
                                <span class="red">{{ $data->dossier->numeroDossier }}</span>

                                <br />
                                <span class="invoice-info-label">Cycle :</span>
                                <span class="blue">{{ isset($data->dossier->cycle)? $data->dossier->cycle->codeCycle : "inconnu" }}</span>

                                <br />
                                <span class="invoice-info-label">Matricule :</span>
                                <span class="blue">{{ $data->dossier->matriculeDossier }}</span>
                            </div>

                            <div class="widget-toolbar hidden-480">
                                <h5 class="text-dark">Impression</h5>
                                <a href="{{ route("inscriptionPrint", ["slug"=>$data->id]) }}" title="Fiche de préinscription" target="_blank">
                                    <i class="ace-icon fa fa-clipboard fa-lg"></i>
                                </a>&nbsp;&nbsp;
                                <a href="{{ route("carte", ["slug"=>$data->dossier->etudiant_id]) }}" title="Carte d'etudiant"  target="_blank">
                                    <i class="ace-icon fa fa-credit-card fa-lg"></i>
                                </a>&nbsp;&nbsp;
                                <a href="{{ route("carte2", ["slug"=>$data->dossier->etudiant_id]) }}" title="Carte de bibliothèque"  target="_blank">
                                    <i class="ace-icon fa fa-book fa-lg"></i>
                                </a>&nbsp;&nbsp;
                                <a href="{{ route("inscriptionPrintCertificat", ["slug"=>$data->dossier->etudiant_id]) }}" title="Certificat de scolarite"  target="_blank">
                                    <i class="ace-icon fa fa-certificate fa-lg"></i>
                                </a>
                            </div>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main padding-24">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <img src="{{ !empty($data->dossier->etudiant->avatar)? asset('').$data->dossier->etudiant->avatar :  asset('').'assets/images/avatars/avatar.png' }}" alt="" class="img-fluid" style="width:100%">
                                        <button class="btn btn-info btn-block" id="changeLogo"><i class="fa fa-camera">&nbsp;</i>Changer la photo</button>
                                        <form action="{{ route('etudiantAvatar') }}" method="post" enctype="multipart/form-data" id="imageForm">
                                            @csrf
                                            <input type="file" class="hidden" name="image" id="image" accept=".png, .jpg, .jpeg">
                                            <input type="hidden" name="etudiant" id="etudiant" value="{{ $data->dossier->etudiant->id }}"/>
                                        </form>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="row">
                                            <div class="col-xs-11 label label-lg label-info arrowed-in arrowed-right">
                                                <b>INFORMATION DE BASE</b>
                                            </div>
                                        </div>

                                        <div>
                                            <ul class="list-unstyled spaced">
                                                <li>
                                                    <i class="ace-icon fa fa-caret-right blue"></i>{{ $data->dossier->numeroDossier }}
                                                </li>

                                                <li>
                                                    <i class="ace-icon fa fa-caret-right blue"></i>
                                                    Niveau :
                                                    <b class="red">{{ $data->level->numeroLevel }}</b>
                                                </li>

                                                <li>
                                                    <i class="ace-icon fa fa-caret-right blue"></i>
                                                    Année scolaire :
                                                    <b class="red">{{ $data->anneacademique->numeroAnnee }}</b>
                                                </li>

                                                <li>
                                                    <i class="ace-icon fa fa-caret-right blue"></i>
                                                    Date de dépot de dossier :
                                                    <b class="red">{{ $data->dateInscription }}</b>
                                                </li>
                                            </ul>
                                        </div>
                                    </div><!-- /.col -->

                                    <div class="col-sm-4">
                                        <div class="row">
                                            <div class="col-xs-11 label label-lg label-success arrowed-in arrowed-right">
                                                <b>IDENTIFICATION DU CANDIDAT</b>
                                            </div>
                                        </div>

                                        <div>
                                            <ul class="list-unstyled  spaced">
                                                <li>
                                                    <i class="ace-icon fa fa-caret-right green"></i>{{ $data->dossier->etudiant->firstname }} {{ $data->dossier->etudiant->lastname }}
                                                </li>

                                                <li>
                                                    <i class="ace-icon fa fa-caret-right green"></i>Né le {{ $data->dossier->etudiant->birthday }} à {{ $data->dossier->etudiant->birthplace }}
                                                </li>

                                                <li>
                                                    <i class="ace-icon fa fa-caret-right green"></i>{{ $data->dossier->etudiant->nationality }}, {{ $data->dossier->etudiant->region }}
                                                </li>

                                                <li>
                                                    <i class="ace-icon fa fa-caret-right green"></i>{{ $data->dossier->etudiant->phonenumber }}
                                                </li>

                                                <li>
                                                    <i class="ace-icon fa fa-caret-right green"></i>{{ $data->dossier->etudiant->email }}
                                                </li>

                                                <li>
                                                    <i class="ace-icon fa fa-caret-right green"></i>{{ $data->dossier->etudiant->residence }}
                                                </li>

                                                <li>
                                                    <i class="ace-icon fa fa-caret-right green"></i>{{ $data->dossier->etudiant->language }}
                                                </li>

                                                <li>
                                                    <i class="ace-icon fa fa-caret-right blue"></i>
                                                    Sport & loisir :
                                                    <b class="red">{{ $data->dossier->etudiant->sport }}, {{ $data->dossier->etudiant->leisure }}</b>
                                                </li>
                                            </ul>
                                        </div>
                                    </div><!-- /.col -->

                                </div><!-- /.row -->

                                <div class="space"></div>
                                <br>
                                <div>
                                    @if(count($data->frais)>0)
                                        <table class="table table-bordered table-striped">
                                            <tr>
                                                <td>Préinscription</td>
                                                <td>Visite médical</td>
                                                <td>Scolarité verssé</td>
                                                <td>Solvabilité</td>
                                            </tr>
                                            <tr>
                                                <td><h5 class="font-weight-bold">{{ $data->frais[0]->preinscription }}</h5></td>
                                                <td><h5 class="font-weight-bold">{{ $data->frais[0]->visitemedical }}</h5></td>
                                                <td><h5 class="font-weight-bold">{{ $data->frais[0]->deuxieme }}&nbsp;/&nbsp;{{ $data->frais[0]->total }}</h5></td>
                                                <td><i class="fa {{ ($data->frais[0]->etat)? "fa-check text-success" : "fa-close text-warning" }}">{{ ($data->frais[0]->etat)? "Soldé" : "Non soldé" }}</i></td>
                                            </tr>
                                        </table>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="btn-group">
                                            <a href="{{ route("inscriptionEdit", ["slug"=>$data->id]) }}" class="btn btn-info">Modifier</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="space"></div>
                                <div class="row">
                                    <div class="col-xs-11 label label-lg label-warning arrowed-in arrowed-right">
                                        <b>Choix de formation</b>
                                    </div>
                                </div>
                                <br>
                                <div>
                                    <table class="table table-bordered table-striped">
                                        <tr>
                                            <td>Choix N°1</td>
                                            <td>Choix N°2</td>
                                            <td>Choix N°3</td>
                                        </tr>
                                        <tr>
                                            <td>{{ $data->choice[0]->specialite->libelleSpecialite }}&nbsp;<a href="{{ ($data->choice[0]->etat==1)? "" : route("inscriptionChoix", ["choix"=>$data->choice[0]->id]) }}" class="btn {{ ($data->choice[0]->etat==1)? "btn-success" : "btn-info" }} btn-round btn-sm">{{ ($data->choice[0]->etat==1)? "Selectioné" : "Choisir" }}</a></td>
                                            <td>{{ $data->choice[1]->specialite->libelleSpecialite }}&nbsp;<a href="{{ ($data->choice[1]->etat==1)? "" : route("inscriptionChoix", ["choix"=>$data->choice[1]->id]) }}" class="btn {{ ($data->choice[1]->etat==1)? "btn-success" : "btn-info" }} btn-round btn-sm">{{ ($data->choice[1]->etat==1)? "Selectioné" : "Choisir" }}</a></td>
                                            <td>{{ $data->choice[2]->specialite->libelleSpecialite }}&nbsp;<a href="{{ ($data->choice[2]->etat==1)? "" : route("inscriptionChoix", ["choix"=>$data->choice[2]->id]) }}" class="btn {{ ($data->choice[2]->etat==1)? "btn-success" : "btn-info" }} btn-round btn-sm">{{ ($data->choice[2]->etat==1)? "Selectioné" : "Choisir" }}</a></td>
                                        </tr>
                                    </table>
                                </div>



                                <div class="space"></div>
                                <div class="row">
                                    <div class="col-xs-11 label label-lg label-warning arrowed-in arrowed-right">
                                        <b>PROFIL SCOLAIRE</b>
                                    </div>
                                </div>
                                <br>
                                <div>
                                    @if(isset($data->dossier->parcours))
                                        @foreach($data->dossier->parcours as $d)
                                            <table class="table table-striped table-bordered" style="line-height: 5px">
                                                <tbody>

                                                <tr>
                                                    <td class="center"><h6>Diplome d'admission :</h6></td>

                                                    <td>
                                                        <a href="#">{{ $d->admissiondiploma }}</a>
                                                    </td>
                                                    <td class="hidden-xs">
                                                        <h6>Série :</h6>
                                                    </td>
                                                    <td class="hidden-480"> {{ $d->option }} </td>
                                                </tr>
                                                <tr>
                                                    <td class="center"><h6>Année d'obtention :</h6></td>

                                                    <td>
                                                        <a href="#">{{ $d->schoolyear }}</a>
                                                    </td>
                                                    <td class="hidden-xs">
                                                        <h6>Ecole :</h6>
                                                    </td>
                                                    <td class="hidden-480"> {{ $d->schoolattended }} </td>
                                                </tr>
                                                <tr>
                                                    <td class="center font-weight-bold" colspan="2"><h6>Pays d'obtention :</h6></td>

                                                    <td  colspan="2">
                                                        <a href="#">{{ $d->diplomacountry }}</a>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        @endforeach
                                    @else
                                        <table class="table table-striped table-bordered">
                                            <tbody>

                                            <tr>
                                                <td class="center"><h6>Aucune entrée</h6></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    @endif
                                </div>

                                <div class="space"></div>
                                <div class="row">
                                    <div class="col-xs-11 label label-lg label-warning arrowed-in arrowed-right">
                                        <b>INFORMATIONS COMPLEMENTAIRES</b>
                                    </div>
                                </div>
                                <br>
                                <div>
                                    @if(isset($data->dossier->etudiant->parents))
                                        {{--@foreach($data->dossier->etudiant->parent as $p)--}}
                                            <table class="table table-striped table-bordered">
                                                <tbody>
                                                <tr>
                                                    <td class="center">Nom du père :</td>

                                                    <td><a href="#">{{ $data->dossier->etudiant->parents->fathername }}</a></td>
                                                    <td class="hidden-xs">Profession :</td>
                                                    <td class="hidden-480">{{ $data->dossier->etudiant->parents->fatherprofession }} </td>
                                                    <td>Contact :</td>
                                                    <td>{{ $data->dossier->etudiant->parents->fathercontact }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="center">Nom de la mère :</td>

                                                    <td><a href="#">{{ $data->dossier->etudiant->parents->mothername }}</a></td>
                                                    <td class="hidden-xs">Profession :</td>
                                                    <td class="hidden-480">{{ $data->dossier->etudiant->parents->motherprofession }} </td>
                                                    <td>Contact :</td>
                                                    <td>{{ $data->dossier->etudiant->parents->mothercontact }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="center">Personne à contacter :</td>

                                                    <td><a href="#" colspan="2">{{ $data->dossier->etudiant->parents->emergencyname }}</a></td>
                                                    <td class="hidden-xs">Contact :</td>
                                                    <td class="hidden-480" colspan="2">{{ $data->dossier->etudiant->parents->emergencycontact }} </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        {{--@endforeach--}}
                                    @else
                                        <table class="table table-striped table-bordered">
                                            <tbody>

                                            <tr>
                                                <td class="center"><h6>Aucune entrée</h6></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    @endif
                                </div>

                                <div class="space"></div>
                                <div class="row">
                                    <div class="col-xs-11 label label-lg label-warning arrowed-in arrowed-right">
                                        <b>ANTECEDANTS MEDICAUX</b>
                                    </div>
                                </div>
                                <br>
                                <div>
                                    @if(isset($data->dossier->etudiant->antecedants))
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                            <th>Maladie</th>
                                            <th>Date de derniere consultation</th>
                                            <th>état</th>
                                            </thead>
                                            <tbody>
                                            @foreach($data->dossier->etudiant->antecedants as $a)
                                                <tr>
                                                    <td class="center">{{ $a->maladie }}</td>

                                                    <td>{{ $a->dateconsultation }}</td>
                                                    <td class="hidden-xs">{{ $a->etat }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <table class="table table-striped table-bordered">
                                            <tbody>

                                            <tr>
                                                <td class="center"><h6>Aucune entrée</h6></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div>
@endsection

@section("script")
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/jquery.dataTables.bootstrap.min.js"></script>
    <script src="assets/js/dataTables.buttons.min.js"></script>
    <script src="assets/js/buttons.flash.min.js"></script>
    <script src="assets/js/buttons.html5.min.js"></script>
    <script src="assets/js/buttons.print.min.js"></script>
    <script src="assets/js/buttons.colVis.min.js"></script>
    <script src="assets/js/dataTables.select.min.js"></script>

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
