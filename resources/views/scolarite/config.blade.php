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
            <table class="table table-bordered table-striped">
                @foreach($config as $key=>$item)
                    <tr>
                        <td colspan="2" class="bg-primary">{{ str_replace("_"," ", strtoupper($key)) }}</td>
                    </tr>
                    <tr>
                        <td>Année</td>
                        <td>{{ $item["year"] }}</td>
                    </tr>
                    <tr>
                        <td>Specialité</td>
                        <td>{{ $item["specialite_name"] }}</td>
                    </tr>
                    <tr>
                        <td>Type de frais</td>
                        <td>{{ $item["type"] }}</td>
                    </tr>
                    <tr>
                        <td>Montant</td>
                        <td>{{ $item["montant"] }}</td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td>{{ $item["description"] }}</td>
                    </tr>
                @endforeach
            </table>
            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Ajouter/Modifier une configuration</button>
            </div>

        </div><!-- /.col -->
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title">Montant de la scolarité
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </h5>

                </div>
                <div class="modal-body">
                    <form action="{{ route("scolariteConfigStore") }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="specialite">Specialité *</label>
                            <select name="specialite" id="specialite" required>
                                <option value=""></option>
                                @foreach($filiere as $f)
                                    <optgroup label="{{ $f->libelleFiliere }}">
                                        @foreach($f->specialites as $s)
                                            <option value="{{ $s->id }}">{{ $s->libelleSpecialite }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Type de frais *</label>
                            <select class="form-control" name="type" required>
                                <option value=""></option>
                                <option value="scolarite">Scolarité</option>
                                <option value="autre">Autres</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Montant *</label>
                            <input type="number" class="form-control" min="0" name="montant" style="letter-spacing: 10px; font-weight: bold" required>
                        </div>


                        <div class="form-group">
                            <label for="">Description *</label>
                            <textarea class="form-control" name="description" required></textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i>&nbsp;Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("style")
    <link rel="stylesheet" href="{{ asset("") }}assets/css/chosen.css" />
@endsection

@section("script")
    <script src="{{ asset("") }}assets/js/chosen.jquery.js"></script>
    <script type="text/javascript">
        $("#specialite").chosen({
            disable_search_threshold: 10,
            no_results_text: "Oops, nothing found!",
            width: "100%"
        });
    </script>
@endsection
