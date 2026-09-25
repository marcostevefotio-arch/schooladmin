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

                    <div class="btn-group">
                        @foreach($module->menu_enfants as $m)
                            @if(strtolower($m->libelle_menu)!=strtolower($title))
                                <a href="{{ route($m->code_menu) }}"  class="btn btn-primary btn-sm"><i class="fa {{ $m->icon_menu }}"></i>&nbsp;{{ $m->libelle_menu }}</a>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="clearfix">
                    <br>
                    <div class="pull-right tableTools-container"></div>

                    <div class="btn-group">
                        <label for="">Generer la liste des etudiants</label>
                        <select name="" id="impression">
                            <option value="all">Tous</option>
                            <option value="cycle">Par Cycle</option>
                            <option value="filiere">Par Filière</option>
                            <option value="specialite">Par Spécialité</option>
                            <option value="sexe">Par Sexe</option>
                            {{--<option value="nationalite">Par Nationalité</option>--}}
                            {{--<option value="langue">Par Langue</option>--}}
                            {{--<option value="solvabilite">Solvable</option>--}}
                            {{--<option value="insolvabilite">Insolvable</option>--}}
                        </select>
                    </div>
                    @if(!$isfilter)
                        <a href="{{ route("etudiantFilter", ["slug"=>"all"]) }}" class="btn btn-success btn-sm" style="float: right">Afficher toutes les années</a>
                    @else
                        <a href="{{ route("etudiant") }}" class="btn btn-success btn-sm" style="float: right">Afficher cette années</a>
                    @endif
                    <a href="{{ route("etudiant-carte") }}" class="btn btn-info btn-sm" style="float: right"><i class="fa fa-print"></i>&nbsp;Cartes d'étudiants</a>
                    <br>
                    <br>
                </div>
                <div class="table-header">
                    Liste des etudiants
                </div>

                <div>
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
                    <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                        <thead>
                        {{--<tr>--}}
                            <th class="center">
                                <label class="pos-rel">
                                    <input type="checkbox" class="ace"/>
                                    <span class="lbl"></span>
                                </label>
                            </th>
                            <th>Matricules</th>
                            <th>Nom(s) et prénom(s)</th>
                            <th>Cycle</th>
                            <th>Filières</th>
                            <th>Spécialités</th>
                            <th>Niveau</th>
                            <th></th>
                        {{--</tr>--}}
                        </thead>

                        <tbody>
                        @foreach($data as $d)
                            <tr>
                                <td class="center">
                                    <label class="pos-rel">
                                        <input type="checkbox" class="ace"/>
                                        <span class="lbl"></span>
                                    </label>
                                </td>
                                <td>{{ $d->matriculeDossier }}</td>
                                <td>{{ $d->firstname }} {{ $d->lastname }}</td>
                                <td>{{ $d->codeCycle }} = {{ $d->titreCycle }}</td>
                                <td>{{ $d->codeFiliere }} = {{ $d->libelleFiliere }}</td>
                                <td>{{ $d->codeSpecialite }} = {{ $d->libelleSpecialite }}</td>
                                <td>Niveau {{ $d->numeroLevel }}</td>
                                <th>
                                    <div class="hidden-sm hidden-xs action-buttons">
                                        <a class="blue" href="{{ route("etudiantShow", ["slug"=>$d->idEt]) }}">
                                            <i class="ace-icon fa fa-search-plus bigger-130"></i>
                                        </a>

                                        <a class="red" href="{{ route("etudiantDelete", ["slug"=>$d->idEt]) }}">
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
                                                    <a href="{{ route("inscriptionShow", ["slug"=>$d->idEt]) }}" class="tooltip-info" data-rel="tooltip" title="View">
                                                                <span class="blue">
                                                                    <i class="ace-icon fa fa-search-plus bigger-120"></i>
                                                                </span>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="{{ route("inscriptionDelete", ["slug"=>$d->idEt]) }}" class="tooltip-error" data-rel="tooltip" title="Delete">
                                                                <span class="red">
                                                                    <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                                                </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

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


    <!-- inline scripts related to this page -->
    <script type="text/javascript">
        jQuery(function($) {
            //initiate dataTables plugin
            $('#dynamic-table').DataTable( {
                order: [[3, 'asc'], [4, 'asc'], [5,'asc'], [6,'asc'],[2,'asc']],
                rowGroup: {
                    dataSrc: [3,4,5,6]
                },
                columnDefs: [ {
                    targets: [3,4,5,6],
                    visible: false
                } ],
                buttons: [ {
                    extend: 'columnsToggle',
                    columns: '.toggle'
                } ]
            } );
        })
    </script>

    <script type="text/javascript">
        $("#impression").change(function(){
            var sort = $(this).val();
            window.open("/print-sort/"+sort, "_blank");
        });
    </script>
@endsection
