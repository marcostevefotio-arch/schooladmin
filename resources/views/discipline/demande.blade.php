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
                    <a href="{{ route("demandeCreate") }}" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;Nouvelle demande de sortie</a>
                </div>
            </div>
            <br>

            <div class="table-header">
                Demande de sortie
            </div>
            <div>
                <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                    <thead>
                    <th>#</th>
                    <th>Etudiants</th>
                    <th>Durée / jours</th>
                    <th>Du</th>
                    <th>Au</th>
                    <th>Motif</th>
                    <th></th>
                    </thead>
                    <tbody>
                    @foreach($demandes as $i=>$d)
                        <tr>
                            <th>{{ ++$i }}</th>
                            <th>{{ $d->inscription->dossier->etudiant->lastname }} {{ $d->inscription->dossier->etudiant->firstname }}</th>
                            <th>{{ (strtotime($d->au) - strtotime($d->du))/86400 }}</th>
                            <th>{{ date("d/m/Y", strtotime($d->du)) }}</th>
                            <th>{{ date("d/m/Y", strtotime($d->au)) }}</th>
                            <th>{{ $d->motifs }}</th>
                            <th>
                                <div class="hidden-sm hidden-xs action-buttons">
                                    <a class="red" href="{{ route("demandeDelete", ["slug"=>$d->id]) }}" title="Supprimer la demande de sortie">
                                        <i class="ace-icon fa fa-trash bigger-130"></i>
                                    </a>
                                    <a class="dark" href="{{ route("demandePrint", ["slug"=>$d->id]) }}" title="Imprimer le ticket de sortie">
                                        <i class="ace-icon fa fa-print bigger-130"></i>
                                    </a>
                                </div>

                                <div class="hidden-md hidden-lg">
                                    <div class="inline pos-rel">
                                        <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                            <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
                                        </button>

                                        <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                           <li>
                                                <a href="{{ route("demandeDelete", ["slug"=>$d->id]) }}" class="tooltip-info" data-rel="tooltip" title="Supprimer la demande de sortie">
                                                    <span class="icheckbox_line-red">
                                                        <i class="ace-icon fa fa-trash bigger-120"></i>
                                                    </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route("demandePrint", ["slug"=>$d->id]) }}" target="_blank" class="tooltip-info" data-rel="tooltip" title="Imprimer le ticket de sortie">
                                                    <span class="dark">
                                                        <i class="ace-icon fa fa-print bigger-120"></i>
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

@section("script")
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/jquery.dataTables.bootstrap.min.js"></script>
    <script src="assets/js/dataTables.buttons.min.js"></script>
    <script src="assets/js/buttons.flash.min.js"></script>
    <script src="assets/js/buttons.html5.min.js"></script>
    <script src="assets/js/buttons.print.min.js"></script>
    <script src="assets/js/buttons.colVis.min.js"></script>
    <script src="assets/js/dataTables.select.min.js"></script>


    <!-- inline scripts related to this page -->
    <script type="text/javascript">
        jQuery(function($) {
            $('#dynamic-table').dataTable({
                "columnDefs": [
                    { "width": "40%", "targets": 5 }
                ],
            });
        })
    </script>

@endsection
