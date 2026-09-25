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
    @foreach($data->dossier as $i=>$d)
        <div class="tabbable">
            <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
                <li class="active">
                    <a data-toggle="tab" href="#dossier4">Dossier</a>
                </li>

                <li>
                    <a data-toggle="tab" href="#inscription4">Inscriptions</a>
                </li>

                <li>
                    <a data-toggle="tab" href="#discipline4">Discipline</a>
                </li>

                <li>
                    <a data-toggle="tab" href="#notes4">Notes</a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="dossier4" class="tab-pane in active">
                    <div class="row">
                        <div class="col-xs-10 col-sm-offset-1">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="widget-box transparent">
                                        <div class="widget-header widget-header-large">
                                            <h3 class="widget-title grey lighter">
                                                <i class="ace-icon fa fa-eye green"></i>
                                                Dossier numéro {{ $d->numeroDossier }}
                                            </h3>

                                            <div class="widget-toolbar invoice-info">
                                                <span class="invoice-info-label">Cycle :</span>
                                                <span class="blue">{{ $d->cycle->codeCycle }}</span>

                                                <br />
                                                <span class="invoice-info-label">Matricule :</span>
                                                <span class="blue">{{ $d->matriculeDossier }}</span>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="widget-body">
                                        <div class="widget-main padding-24">
                                            <div class="row">

                                                <div class="col-sm-6">
                                                    <div class="row">
                                                        <div class="col-xs-11 label label-lg label-info arrowed-in arrowed-right">
                                                            <b>INFORMATION DE BASE</b>
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <ul class="list-unstyled spaced">
                                                            <li>
                                                                <i class="ace-icon fa fa-caret-right blue"></i><span class="font-weight-bold text-info text-uppercase">N° dossier :</span> {{ $d->numeroDossier }}
                                                            </li>
                                                            <li>
                                                                <i class="ace-icon fa fa-caret-right blue"></i><span class="font-weight-bold text-info text-uppercase">Cycle : </span>{{ $d->cycle->codeCycle }} ({{ $d->cycle->titreCycle }})
                                                            </li>
                                                            <li>
                                                                <i class="ace-icon fa fa-caret-right blue"></i><span class="font-weight-bold text-info text-uppercase">Matricule : </span>{{ $d->matriculeDossier }}
                                                            </li>

                                                            <li>
                                                                <i class="ace-icon fa fa-caret-right blue"></i>
                                                                <span class="font-weight-bold text-info text-uppercase">Année scolaire : </span>
                                                                <b class="red">{{ $d->anneeacademique->numeroAnnee }}</b>
                                                            </li>

                                                            <li>
                                                                <i class="ace-icon fa fa-caret-right blue"></i>
                                                                <span class="font-weight-bold text-info text-uppercase">Date de dépot de dossier : </span>
                                                                <b class="red">{{ $data->dateInscription }}</b>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div><!-- /.col -->

                                                <div class="col-sm-6">
                                                    <div class="row">
                                                        <div class="col-xs-11 label label-lg label-success arrowed-in arrowed-right">
                                                            <b>IDENTIFICATION DU CANDIDAT</b>
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <ul class="list-unstyled  spaced">
                                                            <li>
                                                                <i class="ace-icon fa fa-caret-right green"></i><span class="font-weight-bold text-info text-uppercase">Nom et prénom :</span>{{ $data->firstname }} {{ $data->lastname }}
                                                            </li>

                                                            <li>
                                                                <i class="ace-icon fa fa-caret-right green"></i><span class="font-weight-bold text-info text-uppercase">Né(e) le :</span> {{ date("d/m/Y", strtotime($data->birthday)) }} <span class="font-weight-bold text-info text-uppercase">a</span> {{ $data->birthplace }}
                                                            </li>

                                                            <li>
                                                                <i class="ace-icon fa fa-caret-right green"></i><span class="font-weight-bold text-info text-uppercase">Genre :</span> {{ $data->sexe }}
                                                            </li>

                                                            <li>
                                                                <i class="ace-icon fa fa-caret-right green"></i>{{ $data->nationality }}, {{ $data->region }}
                                                            </li>

                                                            <li>
                                                                <i class="ace-icon fa fa-caret-right green"></i><span class="font-weight-bold text-info text-uppercase">Télephone :</span>{{ $data->phonenumber }}
                                                            </li>

                                                            <li>
                                                                <i class="ace-icon fa fa-caret-right green"></i><span class="font-weight-bold text-info text-uppercase">E-mail :</span>{{ $data->email }}
                                                            </li>

                                                            <li>
                                                                <i class="ace-icon fa fa-caret-right green"></i><span class="font-weight-bold text-info text-uppercase">Adresse de résidence :</span>{{ $data->residence }}
                                                            </li>

                                                            <li>
                                                                <i class="ace-icon fa fa-caret-right green"></i><span class="font-weight-bold text-info text-uppercase">Langue :</span>{{ $data->language }}
                                                            </li>

                                                            <li>
                                                                <i class="ace-icon fa fa-caret-right blue"></i>
                                                                <span class="font-weight-bold text-info text-uppercase">Sport & loisir :</span>
                                                                <b class="red">{{ $data->sport }}, {{ $data->leisure }}</b>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div><!-- /.col -->

                                            </div><!-- /.row -->
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="space"></div>
                            <div class="row">
                                <div class="col-xs-11 label label-lg label-warning arrowed-in arrowed-right">
                                    <b>PROFIL SCOLAIRE</b>
                                </div>
                            </div>
                            <br>
                            <div>
                                @if(isset($d->parcours))
                                    @foreach($d->parcours as $p)
                                        <table class="table table-striped table-bordered" style="line-height: 5px">
                                            <tbody>
                                            <tr>
                                                <td class="center"><h6>Diplome d'admission :</h6></td>

                                                <td>
                                                    <a href="#">{{ $p->admissiondiploma }}</a>
                                                </td>
                                                <td class="hidden-xs">
                                                    <h6>Série :</h6>
                                                </td>
                                                <td class="hidden-480"> {{ $p->option }} </td>
                                            </tr>
                                            <tr>
                                                <td class="center"><h6>Année d'obtention :</h6></td>

                                                <td>
                                                    <a href="#">{{ $p->schoolyear }}</a>
                                                </td>
                                                <td class="hidden-xs">
                                                    <h6>Ecole :</h6>
                                                </td>
                                                <td class="hidden-480"> {{ $p->schoolattended }} </td>
                                            </tr>
                                            <tr>
                                                <td class="center font-weight-bold" colspan="2"><h6>Pays d'obtention :</h6></td>

                                                <td  colspan="2">
                                                    <a href="#">{{ $p->diplomacountry }}</a>
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
                                @if(isset($data->parents))
                                    <table class="table table-striped table-bordered">
                                        <tbody>
                                        <tr>
                                            <td class="center">Nom du père :</td>

                                            <td><a href="#">{{ $data->parents->fathername }}</a></td>
                                            <td class="hidden-xs">Profession :</td>
                                            <td class="hidden-480">{{ $data->parents->fatherprofession }} </td>
                                            <td>Contact :</td>
                                            <td>{{ $data->parents->fathercontact }}</td>
                                        </tr>
                                        <tr>
                                            <td class="center">Nom de la mère :</td>

                                            <td><a href="#">{{ $data->parents->mothername }}</a></td>
                                            <td class="hidden-xs">Profession :</td>
                                            <td class="hidden-480">{{ $data->parents->motherprofession }} </td>
                                            <td>Contact :</td>
                                            <td>{{ $data->parents->mothercontact }}</td>
                                        </tr>
                                        <tr>
                                            <td class="center">Personne à contacter :</td>
                                            <td><a href="#" colspan="2">{{ $data->parents->emergencyname }}</a></td>
                                            <td class="hidden-xs">Contact :</td>
                                            <td class="hidden-480" colspan="3">{{ $data->parents->emergencycontact }} </td>
                                        </tr>
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

                            <div class="space"></div>
                            <div class="row">
                                <div class="col-xs-11 label label-lg label-warning arrowed-in arrowed-right">
                                    <b>ANTECEDANTS MEDICAUX</b>
                                </div>
                            </div>
                            <br>
                            <div>
                                @if(isset($data->antecedants))
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <th>Maladie</th>
                                        <th>Date de derniere consultation</th>
                                        <th>état</th>
                                        </thead>
                                        <tbody>
                                        @foreach($data->antecedants as $a)
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

                <div id="inscription4" class="tab-pane">
                    @foreach($d->inscriptions as $inscription)
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="well">
                                    <h4 class="green smaller lighter">Année :{{ $inscription->anneacademique->numeroAnnee }}</h4>
                                    <b>Niveau : {{ $inscription->level->numeroLevel }}</b><br>
                                    <b>Date de depot de dossier : {{ date("d/m/Y", strtotime($inscription->dateInscription)) }}</b><br>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <td>Année scolaire {{ $inscription->anneacademique->numeroAnnee }}</td>
                                        <td>Niveau {{ $inscription->level->numeroLevel }}</td>
                                        @foreach($inscription->choice as $choice)
                                            <td><i class="fa {{ ($choice->etat==1)? "fa-check text-success" : "fa-square-o" }}">&nbsp;{{ $choice->specialite->codeSpecialite }} = {{ $choice->specialite->libelleSpecialite }}</i></td>
                                        @endforeach
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <br>
                    @endforeach
                </div>

                <div id="discipline4" class="tab-pane">
                    @foreach($d->inscriptions as $inscription)
                        <table class="table table-bordered table-stacked" id="dynamic-table2" width="100%">
                            <thead>
                                <th>Année</th>
                                <th>Date</th>
                                <th>Absences</th>
                                <th>Rapporteur</th>
                            </thead>
                            <tbody>
                            @foreach($inscription->disciplineetudiant as $de)
                                <tr>
                                    <td>{{ $inscription->anneeacademique->numeroAnnee }}</td>
                                    <td>{{ $de->journee }}</td>
                                    <td>{{ $de->absences }}</td>
                                    <td>{{ $de->user->email }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endforeach
                </div>

                <div id="notes4" class="tab-pane">
                    @foreach($d->inscriptions as $inscription)
                        <table class="table table-bordered table-stacked" id="dynamic-table" width="100%">
                            <thead>
                                <th>Année</th>
                                <th>Semestre</th>
                                <th>Evaluation</th>
                                <th>UE</th>
                                <th>EC</th>
                                <th>Moyenne</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach($inscription->notes as $n)
                                    <tr>
                                        <td>{{ $d->anneeacademique->numeroAnnee }}</td>
                                        <td>{{ $n->semestre->libelleSemestre }}</td>
                                        <td>{{ $n->typeevaluation }}</td>
                                        <td>{{ $n->matiere->ues->libelleUE }}</td>
                                        <td>{{ $n->matiere->libelleMatiere }}</td>
                                        <td class="font-weight-bold h6 {{ ($n->moyenne>=10)? "bg-success" : "bg-danger"}}">{{ $n->moyenne }}</td>
                                        <td>
                                            {{--<a href="" class="btn btn-danger btn-sm"><i class="fa fa-trash fa-sm"></i></a>--}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endforeach
                </div>
            </div>
        </div>

    @endforeach
@endsection

@section("style")
    <link rel="stylesheet" href="{{ asset("") }}assets/css/rowGroup.dataTables.css" />
@endsection

@section("script")
    <script src="{{ asset("") }}assets/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset("") }}assets/js/jquery.dataTables.bootstrap.min.js"></script>
    <script src="{{ asset("") }}assets/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset("") }}assets/js/buttons.flash.min.js"></script>
    <script src="{{ asset("") }}assets/js/buttons.html5.min.js"></script>
    <script src="{{ asset("") }}assets/js/buttons.print.min.js"></script>
    <script src="{{ asset("") }}assets/js/buttons.colVis.min.js"></script>
    <script src="{{ asset("") }}assets/js/dataTables.select.min.js"></script>
    <script src="{{ asset("") }}assets/js/dataTables.rowGroup.js"></script>

    <script type="text/javascript">
        jQuery(function($) {
            //initiate dataTables plugin
            $('#dynamic-table').DataTable( {
                order: [[0, 'asc'], [1, 'asc'], [3,'asc'], [4,'asc'],[2,'asc'],[5,'asc']],
                rowGroup: {
                    dataSrc: [0,1,3,4]
                },
                columnDefs: [ {
                    targets: [0,1,3,4],
                    visible: false
                } ],
                buttons: [ {
                    extend: 'columnsToggle',
                    columns: '.toggle'
                } ]
            } );

            $('#dynamic-table2').DataTable( {
                order: [[0, 'asc'], [1, 'asc'], [2, 'asc'], [3, 'asc']],
                rowGroup: {
                    dataSrc: [0,1]
                },
                columnDefs: [ {
                    targets: [0,1],
                    visible: true
                } ],
                buttons: [ {
                    extend: 'columnsToggle',
                    columns: '.toggle'
                } ]
            } );
        })
    </script>
@endsection
