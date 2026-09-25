@extends('layouts.layout')

@section('title')
    {{ isset($title)? $title : "" }}
@endsection

@section('breadcrum')
    <li><i class="ace-icon fa fa-home home-icon"></i><a href="{{ route("home") }}">Home</a></li>
    <li><i class="ace-icon home-icon"></i><a href="{{ isset($module)? route($module->code_menu) : "" }}">{{ isset($parent)? $parent : "" }}</a></li>
    <li><i class="ace-icon home-icon"></i><a href="{{ $option_route }}">{{ isset($title)? $title : "" }}</a></li>
    <li class="active">Create</li>
@endsection

@section('content')
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <form action="{{ isset($groupe)? route("groupeUpdate", ["slug"=>$groupe->id]) : route("groupeStore") }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label>
                            <h4 class="">Titre du groupe</h4>
                        </label>
                        <input class="form-control input-mask-phone @error('titre') is-invalid @enderror" type="text" id="titre" name="titre" value="{{ isset($groupe)? $groupe->titre_groupe : old('titre') }}" required/>
                        @error('titre')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>
                            <h4 class="">Description</h4>
                        </label>
                        <textarea class="form-control input-mask-phone @error('description') is-invalid @enderror" type="description" id="description" name="description">{{ isset($groupe)? $groupe->description_groupe : old('description') }}</textarea>
                        @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label >
                            <h4 class="">Permissions</h4>
                        </label>
                        <table class="table table-bordered text-center" id="dynamic-datatable">
                            <thead>
                            <th>Modules</th>
                            <th>Creation</th>
                            <th>Lecture</th>
                            <th>Modification</th>
                            <th>Supression</th>
                            <th>Exportation</th>
                            </thead>
                            <tbody>

                            @foreach($menu as $m)
                                <tr class="bg-primary text-white">
                                    <td class="text-left"><b>{{ $m->libelle_menu }}</b></td>
                                    @foreach($m->permission as $p)
                                        <td><input type="checkbox" name="permission_{{ $p->id }}" {{ isset($groupe)? ($groupe->permission->contains($p)? "checked" : "" ): "" }} ></td>
                                    @endforeach
                                </tr>
                                @if(count($m->menu_enfants)>0)
                                    @foreach($m->menu_enfants as $sm)
                                    <tr>
                                        <td>{{ $sm->libelle_menu }}</td>
                                        @foreach($sm->permission as $p)
                                            <td><input type="checkbox" name="permission_{{ $p->id }}" {{ isset($groupe)? ($groupe->permission->contains($p)? "checked" : "" ): "" }} ></td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>


                    <div class="form-group">
                        <div class="btn-group">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save">&nbsp;</i>Enregistrer</button>
                        </div>
                    </div>
                </form>


                <div class="hr hr-18 dotted hr-double"></div>

            </div>
        </div>
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

    <script type="text/javascript">
        jQuery(function($) {
            var myTable =
                $('#dynamic-datatable')
                    .DataTable( {
                        bAutoWidth: false,
                        "pageLength": 50,
                        "aoColumns": [
                            { "bSortable": false },
                            null, null,null, null,
                            { "bSortable": false }
                        ],
                        "aaSorting": [],
                    } );

        })
    </script>
@endsection
