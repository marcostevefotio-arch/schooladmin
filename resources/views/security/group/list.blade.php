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

                            @foreach($right as $r)
                                @if($r == "create")
                                    <a href="{{ route("groupeCreate") }}" class="btn btn-primary" title="Nouveau groupe d'utilisateurs"><i class="fa fa-plus"></i></a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <br>
                </div>
                <div class="col-xs-12">

                    <div class="table-header">
                        Liste des groupes
                    </div>

                    <!-- div.table-responsive -->

                    <!-- div.dataTables_borderWrap -->
                    <div class="table-responsive">

                        <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th class="center">
                                    <label class="pos-rel">
                                        <input type="checkbox" class="ace" />
                                        <span class="lbl"></span>
                                    </label>
                                </th>
                                <th>Groupe</th>
                                <th>Membres</th>
                                <th>Permissions</th>
                                <th></th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($groupes as $g)
                                <tr>
                                    <td class="center">
                                        <label class="pos-rel">
                                            <input type="checkbox" class="ace" />
                                            <span class="lbl"></span>
                                        </label>
                                    </td>

                                    <td>{{ $g->titre_groupe }}</td>
                                    <td>{{ count($g->personnels) }}</td>
                                    <td>{{ count($g->permission) }}</td>
                                    <td>

                                        {{--@if($g->editing)--}}
                                        <div class="hidden-sm hidden-xs action-buttons">
                                            @foreach($right as $r)
                                                @if($r=="read")
                                                    <a class="blue" href="{{ route("groupeShow", ["slug"=>$g->id]) }}" title="Consulter ce groupe">
                                                        <i class="ace-icon fa fa-search-plus bigger-130"></i>
                                                    </a>
                                                @endif
                                                @if($r=="update")
                                                    <a class="green" href="{{ route("groupeEdit", ["slug"=>$g->id]) }}" title="Modifier ce groupe">
                                                        <i class="ace-icon fa fa-pencil bigger-130"></i>
                                                    </a>
                                                @endif
                                                @if($r=="delete")
                                                    <a href="#exampleModal{{ $g->id }}" class="red" title="Supprimer ce groupe" data-toggle="modal" data-target="#exampleModal{{ $g->id }}">
                                                        <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                                    </a>

                                                    <div class="modal fade" id="exampleModal{{ $g->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content modal-sm">
                                                                <div class="modal-header bg-primary">
                                                                    <h5 class="modal-title text-center" id="exampleModalLabel">
                                                                        <i class="fa fa-exclamation-triangle fa-2x red"></i>
                                                                        &nbsp;Suppression d'un groupe
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </h5>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Voulez vous vraiment supprimer le groupe <i class="text-black"><b>"{{ $g->titre_groupe }}"</b></i>?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <a href="{{ route("groupeDelete", ["slug"=>$g->id]) }}" class="btn btn-primary float-left"><i class="fa fa-check"></i>&nbsp;Oui</a>
                                                                    <button type="button" class="btn btn-secondary  float-right" data-dismiss="modal">Annuler</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>

                                        <div class="hidden-md hidden-lg">
                                            <div class="inline pos-rel">
                                                <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                                    <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
                                                </button>

                                                <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                                    @foreach($right as $r)
                                                        @if($r=="read")
                                                            <li>
                                                                <a href="{{ route("groupeShow", ["slug"=>$g->id]) }}" class="tooltip-info" data-rel="tooltip" title="Consulter ce groupe">
                                                                    <span class="blue">
                                                                        <i class="ace-icon fa fa-search-plus bigger-120"></i>
                                                                    </span>
                                                                </a>
                                                            </li>

                                                        @endif
                                                        @if($r=="update")
                                                            <li>
                                                                <a href="{{ route("groupeEdit", ["slug"=>$g->id]) }}" class="tooltip-success" data-rel="tooltip" title="Modifier ce groupe">
                                                                    <span class="green">
                                                                        <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                                                    </span>
                                                                </a>
                                                            </li>

                                                        @endif
                                                        @if($r=="delete")
                                                                <li>
                                                                    <a href="#exampleModal{{ $g->id }}" class="tooltip-error" data-rel="tooltip" title="Supprimer ce groupe"  data-toggle="modal" data-target="#exampleModal{{ $g->id }}">
                                                                        <span class="red">
                                                                            <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                                                        </span>
                                                                    </a>

                                                                    <div class="modal fade" id="exampleModal{{ $g->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
                                                                        <div class="modal-dialog" role="document">
                                                                            <div class="modal-content modal-sm">
                                                                                <div class="modal-header bg-primary">
                                                                                    <h5 class="modal-title text-center" id="exampleModalLabel">
                                                                                        <i class="fa fa-exclamation-triangle fa-2x red"></i>
                                                                                        &nbsp;Suppression d'un groupe
                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                            <span aria-hidden="true">&times;</span>
                                                                                        </button>
                                                                                    </h5>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    Voulez vous vraiment supprimer le groupe <i class="text-black"><b>"{{ $g->titre_groupe }}"</b></i>?
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <a href="{{ route("groupeDelete", ["slug"=>$g->id]) }}" class="btn btn-primary float-left"><i class="fa fa-check"></i>&nbsp;Oui</a>
                                                                                    <button type="button" class="btn btn-secondary  float-right" data-dismiss="modal">Annuler</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                        @endif
                                                    @endforeach

                                                </ul>
                                            </div>
                                        </div>
                                        {{--@endif--}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@section("style")
    <link rel="stylesheet" href="{{ asset("") }}assets/css/jquery-ui-1.10.3.full.min.css" />
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



    <script src="{{ asset("") }}assets/js/jquery-ui-1.10.3.full.min.js"></script>
    <script src="{{ asset("") }}assets/js/jquery.ui.touch-punch.min.js"></script>


    <!-- inline scripts related to this page -->
    <script type="text/javascript">
        jQuery(function($) {
            $('#dynamic-table').dataTable();

            $("#id-btn-dialog1").on('click', function(e) {
                e.preventDefault();



            });
        })

        function suppression(id, title){
            $.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
                _title: function(title) {
                    var $title = this.options.title || '&nbsp;'
                    if( ("title_html" in this.options) && this.options.title_html == true )
                        title.html($title);
                    else title.text($title);
                }
            }));

            $("#dialog-confirm").removeClass('hide').dialog({
                resizable: false,
                modal: true,
                title: "<div class='widget-header'><h4 class='smaller'><i class='icon-warning-sign red'></i>"+title+"</h4></div>",
                title_html: true,
                buttons: [
                    {
                        html: "<i class='icon-trash bigger-110'></i>&nbsp; Oui",
                        "class" : "btn btn-danger btn-xs",
                        click: function() {
                            $.ajax({
                                url: "{!! \Illuminate\Support\Facades\URL::to("delete-groupe") !!}",
                                success: function(response){
                                    location.reload();
                                },
                            })
                        }
                    }
                    ,
                    {
                        html: "<i class='icon-remove bigger-110'></i>&nbsp; Annuler",
                        "class" : "btn btn-xs",
                        click: function() {
                            $( this ).dialog( "close" );
                        }
                    }
                ]
            });
        }
    </script>
@endsection
