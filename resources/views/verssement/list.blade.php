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
        <div class="col-xs-12">
            <div class="clearfix">
                <div class="pull-right tableTools-container"></div>
                <div class="btn-group">
                    <a href="{{ route("verssementCreate") }}" class="btn btn-info btn-sm"><i class="fa fa-table"></i>&nbsp;Nouveau verssement</a>
                    @foreach($module->menu_enfants as $m)
                        @if(strtolower($m->libelle_menu)!=strtolower($title))
                            <a href="{{ route($m->code_menu) }}"  class="btn btn-primary btn-sm"><i class="fa {{ $m->icon_menu }}"></i>&nbsp;{{ $m->libelle_menu }}</a>
                        @endif
                    @endforeach
                </div>
            </div>
            <br>
            <div class="form-group bg-aqua" style="float: left">
                <label for="annee">Filtre</label>
                <select name="annee" id="annee" onchange="location = this.value;">
                    <option value="{{ route("verssement", ["slug"=>"all"]) }}">Tous</option>
                    @foreach($annee as $a)
                        <option value="{{ route("verssement", ["slug"=>$a->id]) }}" style="{{ $a->active? 'background:#cccccc' : ''  }}"  {{ ($a->id==$filtre)? "selected" : "" }}>{{ $a->numeroAnnee }} {{ $a->active? '(En cours)' : ''  }}</option>
                    @endforeach
                </select>
            </div>
            <br>
            <br>
            <div class="table-header">
                Liste des verssements
                <a href="{{ route("verssementPrint") }}" class="btn btn-sm" title="Imprimer l'état des verssements" style="background-color: #fff!important; color: #569bff!important;border-color: #fff!important; margin: 2px; float: right"><i class="fa fa-print"></i></a>
            </div>

            <div>
                <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th class="center">
                            <label class="pos-rel">
                                <input type="checkbox" class="ace"/>
                                <span class="lbl"></span>
                            </label>
                        </th>
                        <th>Date</th>
                        <th>Annee</th>
                        <th>Compte</th>
                        <th>Specialite</th>
                        <th>Matricle</th>
                        <th>Nom et prénom</th>
                        <th>Montant</th>
                        <th></th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($data as $v)
                        <tr>
                            <td class="center">
                                <label class="pos-rel">
                                    <input type="checkbox" class="ace"/>
                                    <span class="lbl"></span>
                                </label>
                            </td>
                            <td>{{ $v->dateVerssement }}</td>
                            <td>{{ $v->scolarite->anneeacademique->numeroAnnee }}</td>
                            <td>{{ $v->scolarite->compte->libelleCompte }}</td>
                            <td>{{ $v->scolarite->specialite->libelleSpecialite }}</td>
                            <td>{{ $v->inscription->dossier->matriculeDossier }}</td>
                            <td>{{ $v->inscription->dossier->etudiant->firstname }} {{ $v->inscription->dossier->etudiant->lastname }}</td>
                            <td>{{ $v->montantVerssement }}</td>
                            <td>
                                <div class="hidden-sm hidden-xs action-buttons">
                                    <a class="blue" href="{{ route("verssementShow", ["slug"=>$v->codeVerssement]) }}" title="Afficher">
                                        <i class="ace-icon fa fa-search-plus bigger-130"></i>
                                    </a>
                                    
                                    <a class="dark" href="{{ route("verssementReceipt", ["slug"=>$v->codeVerssement]) }}" title="imprimer le reçu" target="_blank">
                                        <i class="ace-icon fa fa-print bigger-130"></i>
                                    </a>

                                    <a class="green" href="{{ route("verssementEdit", ["slug"=>$v->codeVerssement]) }}" title="Modifier">
                                        <i class="ace-icon fa fa-pencil bigger-130"></i>
                                    </a>

                                    <a class="red" href="{{ route("verssementDelete", ["slug"=>$v->codeVerssement]) }}" title="Supprimer">
                                        <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                    </a>
                                </div>

                                <div class="hidden-md hidden-lg">
                                    <div class="inline pos-rel">
                                        <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                            <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
                                        </button>

                                        <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                            <li>
                                                <a href="{{ route("verssementShow", ["slug"=>$v->codeVerssement]) }}" class="tooltip-success" data-rel="tooltip" title="Afficher">
                                                        <span class="blue">
                                                            <i class="ace-icon fa fa-search-plus bigger-120"></i>
                                                        </span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ route("verssementReceipt", ["slug"=>$v->codeVerssement]) }}" class="tooltip-success" data-rel="tooltip" title="imprimer le reçu"  target="_blank">
                                                        <span class="dark">
                                                            <i class="ace-icon fa fa-print bigger-120"></i>
                                                        </span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ route("verssementEdit", ["slug"=>$v->codeVerssement]) }}" class="tooltip-success" data-rel="tooltip" title="Modifier">
                                                        <span class="green">
                                                            <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                                        </span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ route("verssementDelete", ["slug"=>$v->codeVerssement]) }}" class="tooltip-error" data-rel="tooltip" title="Supprimer">
                                                        <span class="red">
                                                            <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                                        </span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


@section("script")
    <script src="{{ asset("") }}assets/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset("") }}assets/js/jquery.dataTables.bootstrap.min.js"></script>
    <script src="{{ asset("") }}assets/js/dataTables.buttons.min.js"></script>


    <!-- inline scripts related to this page -->
    <script type="text/javascript">
        jQuery(function($) {
            //initiate dataTables plugin
            var myTable =
                $('#dynamic-table')
                //.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
                    .DataTable( {
                        bAutoWidth: false,
                        "aoColumns": [
                            { "bSortable": false },
                            null, null,null, null, null, null, null,
                            { "bSortable": false }
                        ],
                        "aaSorting": [],
                    } );
        })
    </script>
@endsection
