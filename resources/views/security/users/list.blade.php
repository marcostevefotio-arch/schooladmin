@extends('layouts.layout')

@section('title')
    {{ isset($title)? $title : "" }}
@endsection

@section('breadcrum')
    <li><i class="ace-icon fa fa-home home-icon"></i><a href="{{ route("home") }}">Home</a></li>
    <li><i class="ace-icon home-icon"></i><a href="{{ isset($module)? route($module->code_menu) : "" }}">{{ isset($parent)? $parent : "" }}</a></li>
    <li><i class="ace-icon home-icon"></i><a href="{{ $option_route }}">{{ isset($title)? $title : "" }}</a></li>
    <li class="active">liste</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12">
                    <div class="text-right">
                        <div class="btn-group float-right">
                            <a href="{{ route("userCreate") }}" class="btn btn-primary" title="Nouveau Compte"><i class="fa fa-key">&nbsp;Nouveau Compte</i></a>
                            <a href="{{ route("personnelCreate") }}" class="btn btn-info"  title="Nouvel Utilisateur"><i class="fa fa-user"></i>&nbsp;Nouvel Utilisateur</a>
                        </div>
                    </div>

                    <div class="clearfix">
                        <div class="pull-right tableTools-container"></div>
                    </div>
                    <div class="table-header">
                        Liste d'utilisateurs
                    </div>

                    <!-- div.table-responsive -->

                    <!-- div.dataTables_borderWrap -->
                    <div>
                        <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="center">
                                        <label class="pos-rel">
                                            <input type="checkbox" class="ace" />
                                            <span class="lbl"></span>
                                        </label>
                                    </th>
                                    <th>Nom</th>
                                    <th>Groupe</th>
                                    <th>Email</th>
                                    <th>Actif</th>
                                    <th>Mot de passe</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                            @foreach($users as $u)

                                    @if(isset($u->personnel))
                                        @if(auth()->user()->id!=$u->id)
                                            <tr>
                                                <td class="center">
                                                    <label class="pos-rel">
                                                        <input type="checkbox" class="ace" />
                                                        <span class="lbl"></span>
                                                    </label>
                                                </td>
                                                <td>{{ $u->personnel->lastname }}</td>
                                                <td>{{ $u->personnel->groupe->titre_groupe }}</td>
                                                <td>{{ $u->email }}</td>
                                                <td>
                                                    @if($u->personnel->groupe->editing)
                                                        @if($u->active===1)
                                                            <a class="btn btn-minier btn-success" href="{{ route("userActive", ["slug"=>$u->id]) }}">Actif</a>
                                                        @else
                                                            <a class="btn btn-minier btn-danger" href="{{ route("userActive", ["slug"=>$u->id]) }}">Inactif</a>
                                                        @endif
                                                    @else
                                                        <span class="label label-sm label-info"><i class="fa fa-user-secret"></i></span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($u->personnel->groupe->editing)
                                                        <a class="btn btn-minier btn-success" href="{{ route("userReset", ["slug"=>$u->id]) }}">Reinitialiser</a>
                                                    @else
                                                        <span class="label label-sm label-info"><i class="fa fa-shield"></i></span>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if($u->personnel->groupe->editing)
                                                    <div class="hidden-sm hidden-xs action-buttons">
                                                        <a class="blue" href="{{ route("userShow", ["slug"=>$u->id]) }}">
                                                            <i class="ace-icon fa fa-search-plus bigger-130"></i>
                                                        </a>

                                                        <a class="green" href="{{ route("userEdit", ["slug"=>$u->id]) }}">
                                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                                                        </a>

                                                        <a href="#exampleModal{{ $u->id }}" class="red" title="Supprimer ce groupe" data-toggle="modal" data-target="#exampleModal{{ $u->id }}">
                                                            <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                                        </a>

                                                        <div class="modal fade" id="exampleModal{{ $u->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content modal-sm">
                                                                    <div class="modal-header bg-primary">
                                                                        <h5 class="modal-title text-center" id="exampleModalLabel">
                                                                            <i class="fa fa-exclamation-triangle fa-2x red"></i>
                                                                            &nbsp;Suppression d'un compte
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </h5>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Voulez vous vraiment supprimer le compte <i class="text-black"><b>"{{ $u->email }}"</b></i>?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <a href="{{ route("userDelete", ["slug"=>$u->id]) }}" class="btn btn-primary float-left"><i class="fa fa-check"></i>&nbsp;Oui</a>
                                                                        <button type="button" class="btn btn-secondary  float-right" data-dismiss="modal">Annuler</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="hidden-md hidden-lg">
                                                        <div class="inline pos-rel">
                                                            <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                                                <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
                                                            </button>

                                                            <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                                                <li>
                                                                    <a href="{{ route("userDelete", ["slug"=>$u->id]) }}" class="tooltip-info" data-rel="tooltip" title="View">
                                                                                            <span class="blue">
                                                                                                <i class="ace-icon fa fa-search-plus bigger-120"></i>
                                                                                            </span>
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a href="{{ route("userEdit", ["slug"=>$u->id]) }}" class="tooltip-success" data-rel="tooltip" title="Edit">
                                                                                            <span class="green">
                                                                                                <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                                                                            </span>
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a href="{{ route("userDelete", ["slug"=>$u->id]) }}" class="tooltip-error" data-rel="tooltip" title="Delete">
                                                                                            <span class="red">
                                                                                                <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                                                                            </span>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @elseif(isset($u->etudiant))
                                        <tr>
                                            <td class="center">
                                                <label class="pos-rel">
                                                    <input type="checkbox" class="ace" />
                                                    <span class="lbl"></span>
                                                </label>
                                            </td>
                                            <td>{{ $u->etudiant->lastname }}</td>
                                            <td>{{ $u->etudiant->groupe->titre_groupe }}</td>
                                            <td>{{ $u->email }}</td>
                                            <td>
                                                @if($u->active===1)
                                                    <a class="btn btn-minier btn-success" href="{{ route("userActive", ["slug"=>$u->id]) }}">Actif</a>
                                                @else
                                                    <a class="btn btn-minier btn-danger" href="{{ route("userActive", ["slug"=>$u->id]) }}">Inactif</a>
                                                @endif
                                            </td>

                                            <td>
                                                    <div class="hidden-sm hidden-xs action-buttons">
                                                        <a class="blue" href="#">
                                                            <i class="ace-icon fa fa-search-plus bigger-130"></i>
                                                        </a>

                                                        <a class="green" href="#">
                                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                                                        </a>

                                                        <a class="red" href="#">
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
                                                                    <a href="#" class="tooltip-info" data-rel="tooltip" title="View">
                                                                                        <span class="blue">
                                                                                            <i class="ace-icon fa fa-search-plus bigger-120"></i>
                                                                                        </span>
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
                                                                                        <span class="green">
                                                                                            <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                                                                        </span>
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
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
        jQuery(function($) {
            var myTable =
                $('#dynamic-table')
                    .DataTable( {
                        bAutoWidth: false,
                        "aoColumns": [
                            { "bSortable": false },
                            null, null,null, null, null,
                            { "bSortable": false }
                        ],
                        "aaSorting": [],
                    } );

        })
    </script>
@endsection
