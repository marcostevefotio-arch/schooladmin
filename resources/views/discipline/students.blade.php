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
                    <a href="{{ route("demande") }}" class="btn btn-sm btn-primary">Demandes de sortie</a>
                    <a href="{{ route("disciplineETCreate") }}" class="btn btn-sm btn-info">Enregistrer les absences</a>
                    @foreach($module->menu_enfants as $m)
                        @if(strtolower($m->libelle_menu)!=strtolower($title))
                            <a href="{{ route($m->code_menu) }}"  class="btn btn-primary btn-sm"><i class="fa {{ $m->icon_menu }}"></i>&nbsp;{{ $m->libelle_menu }}</a>
                        @endif
                    @endforeach
                </div>
            </div>
            <br>
            <div class="table-header">
                Notes de discipline
            </div>

            <div>
                <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                    <thead>
                    <th>#</th>
                    <th>Specialite</th>
                    <th>Total absences</th>
                    <th></th>
                    </thead>
                    <tbody>
                    @foreach($specialite as $i=>$sp)
                        @php
                            $totalabsence = 0;
                            foreach($absences as $ab){
                                if($ab->spid == $sp->id){
                                    $totalabsence = $totalabsence + $ab->absences;
                                }
                            }
                        @endphp
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $sp->libelleSpecialite }}</td>
                            <td>{{ $totalabsence }}</td>
                            <td>
                                <div class="hidden-sm hidden-xs action-buttons">
                                    <a class="blue" href="{{ route("disciplineETShow", ["slug"=>$sp->id]) }}">
                                        <i class="ace-icon fa fa-search-plus bigger-130"></i>
                                    </a>
                                </div>

                                <div class="hidden-md hidden-lg">
                                    <div class="inline pos-rel">
                                        <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                            <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
                                        </button>

                                        <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                            <li>
                                                <a href="{{ route("disciplineETShow", ["slug"=>$sp->id]) }}" class="tooltip-info" data-rel="tooltip" title="View">
                                                            <span class="blue">
                                                                <i class="ace-icon fa fa-search-plus bigger-120"></i>
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
                    { "width": "40%", "targets": 2 }
                ],
            });
        })
    </script>

@endsection
