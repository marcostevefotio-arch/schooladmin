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
                    <a href="{{ route("scolariteCreate") }}" class="btn btn-info btn-sm"><i class="fa fa-cog"></i>&nbsp;Nouvelle configuration</a>
                    @foreach($module->menu_enfants as $m)
                        @if(strtolower($m->libelle_menu)!=strtolower($title))
                            <a href="{{ route($m->code_menu) }}"  class="btn btn-primary btn-sm"><i class="fa {{ $m->icon_menu }}"></i>&nbsp;{{ $m->libelle_menu }}</a>
                        @endif
                    @endforeach
                </div>
            </div>
            <br>
            <div class="table-header">
                Liste des verssements
                <a href="{{ route("scolaritePrint") }}" class="btn btn-sm" title="Imprimer la fiche de scolarité" style="background-color: #fff!important; color: #569bff!important;border-color: #fff!important; margin: 2px; float: right"><i class="fa fa-print"></i></a>
            </div>

            <div>
                <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                    <thead>
                        <th class="center">
                            <label class="pos-rel">
                                <input type="checkbox" class="ace"/>
                                <span class="lbl"></span>
                            </label>
                        </th>
                        <th>Code</th>
                        <th>Compte</th>
                        <th>Année</th>
                        <th>Spécialité</th>
                        <th>Montant</th>
                        <th>Description</th>
                        <th></th>
                    </thead>

                    <tbody>
                        @foreach($data as $s)
                        @if(isset($s->specialite))
                            <tr>
                                <td class="center">
                                    <label class="pos-rel">
                                        <input type="checkbox" class="ace" />
                                        <span class="lbl"></span>
                                    </label>
                                </td>
                                <td>{{ $s->codeScolarite }}</td>
                                <td>{{ $s->compte->libelleCompte }}</td>
                                <td>{{ $s->anneeacademique->numeroAnnee }}</td>
                                <td>{{ $s->specialite->libelleSpecialite }}</td>
                                <td>{{ $s->montantScolarite }}</td>
                                <td>{{ $s->descriptionScolarite }}</td>
                                <td>
                                    <div class="hidden-sm hidden-xs action-buttons">
                                        <a class="green" href="{{ route("scolariteEdit", ["slug"=>$s->id]) }}">
                                            <i class="ace-icon fa fa-edit bigger-130"></i>
                                        </a>
                                        <a class="red" href="{{ route("scolariteDelete", ["slug"=>$s->id]) }}">
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
                                                    <a href="{{ route("scolariteEdit", ["slug"=>$s->id]) }}" class="tooltip-error" data-rel="tooltip" title="Edit">
                                                        <span class="green">
                                                            <i class="ace-icon fa fa-edit bigger-120"></i>
                                                        </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route("scolariteDelete", ["slug"=>$s->id]) }}" class="tooltip-error" data-rel="tooltip" title="Delete">
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
                            @endif
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
            //initiate dataTables plugin
            var myTable =
                $('#dynamic-table')
                //.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
                    .DataTable( {
                        bAutoWidth: false,
                        "aoColumns": [
                            { "bSortable": false },
                            null, null,null, null, null, null,
                            { "bSortable": false }
                        ],
                        "aaSorting": [],

                        select: {
                            style: 'multi'
                        }
                    } );
        })
    </script>
@endsection
