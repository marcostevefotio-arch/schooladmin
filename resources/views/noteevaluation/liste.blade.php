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
                    <a href="{{ route("notesForm") }}" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i>&nbsp;Enregistrer des notes</a>
                    @foreach($module->menu_enfants as $m)
                        @if(strtolower($m->libelle_menu)!=strtolower($title))
                            <a href="{{ route($m->code_menu) }}"  class="btn btn-primary btn-sm" target="{{ $m->libelle_menu=="Procès verbal"? '_blank':'' }}"><i class="fa {{ $m->icon_menu }}"></i>&nbsp;{{ $m->libelle_menu }}</a>
                        @endif
                    @endforeach
                </div>
                <br>
                <br>
            </div>
            <div class="table-header">
                Liste des evaluations
            </div>

            <div>
                <table id="dynamic-table" class="table table-striped table-bordered table-hover display nowrap" width="100%">
                    <thead>
                    <tr>
                        <th>Semestre</th>
                        <th>Specialité</th>
                        <th>Matiere</th>
                        <th>Année</th>
                        <th>Etudiant</th>
                        <th>Examen</th>
                        <th>Note</th>
                        <th></th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($ue as $key=>$ues)
                        @foreach($ues->matiere as $m)
                            @foreach($m->notes as $i=>$n)
                                <tr>
                                    <td>Semestre {{ $ues->semestre->libelleSemestre }}</td>
                                    <td>{{ $ues->specialite->libelleSpecialite }}</td>
                                    <td>{{ $m->libelleMatiere }}</td>
                                    <td>{{ $n->year }}</td>
                                    <td>{{ isset($n->inscription)? $n->inscription->dossier->etudiant->lastname : "" }} {{ isset($n->inscription)? $n->inscription->dossier->etudiant->firstname : "" }}</td>
                                    <td>{{ $n->typeevaluation }}</td>
                                    <td class="font-weight-bold {{ $n->moyenne<10? "bg-danger" : ($n->moyenne>=12? "bg-success" : "") }}"><span style="font-weight: bold!important" class="font-weight-bold {{ $n->moyenne<10? "text-danger" : ($n->moyenne>=12? "text-success" : "") }}">{{ $n->moyenne }}</span></td>
                                    <td><a href="{{ route("notesShow", ["slug"=>$n->id]) }}" class=""><i class="fa fa-search-plus"></i></a></td>
                                </tr>
                            @endforeach
                        @endforeach
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


    <script type="text/javascript">

        $(document).ready( function () {

            $(document).ready(function() {
                $('#dynamic-table').DataTable( {
                    order: [[3, 'asc'], [0, 'asc'], [1,'asc'], [2,'asc']],
                    rowGroup: {
                        dataSrc: [3,1,0,2]
                    },
                    columnDefs: [ {
                        targets: [3,1,0,2],
                        visible: false
                    } ],
                    buttons: [ {
                        extend: 'columnsToggle',
                        columns: '.toggle'
                    } ]
                } );
            } );
        } );
    </script>
@endsection
