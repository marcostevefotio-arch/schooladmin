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
            <form action="{{ route("scolaritePrintAction") }}" method="post" target="_blank">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="annee">Annee *</label>
                    <select name="annee" id="annee" class="form-control" required>
                        <option value=""></option>
                        @foreach($annee as $a)
                            <option value="{{ $a->id }}" {{  isset($data)? ($data->anneeacademique_id==$a->id? "selected" : "") : "" }}>{{ $a->numeroAnnee }}</option>
                        @endforeach
                    </select>

                    @error("annee")
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="specialite">Specialité *</label>
                    <select name="specialite" id="specialite" value="{{  isset($data)? $data->specialite_id : old("specialite") }}" required>
                        <option value="all">Tous</option>
                        @foreach($filiere as $f)
                            <optgroup label="{{ $f->libelleFiliere }}">
                                @foreach($f->specialites as $s)
                                    @foreach($s->choice as $c)
                                        @if($c->etat == 1)
                                            <option value="{{ $s->id }}"  {{  isset($data)? ($data->specialite_id==$s->id? "selected" : "") : "" }}>{{ $s->libelleSpecialite }}</option>
                                            @break
                                        @endif
                                    @endforeach
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>

                    @error("specialite")
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <h4><button type="submit" id="submit" class="btn btn-primary"><i class="fa fa-print">&nbsp;Imprimer</i></button></h4>
            </form>
        </div>
    </div>
@endsection

@section("style")
    <link rel="stylesheet" href="{{ asset("") }}assets/css/chosen.css" />
@endsection

@section("script")
    <script src="{{ asset("") }}assets/js/chosen.jquery.js"></script>
    <script src="{{ asset("") }}assets/js/spin.js"></script>


    <!-- inline scripts related to this page -->
    <script type="text/javascript">
        $(document).ready(function(){


            $("#specialite").chosen({
                disable_search_threshold: 10,
                no_results_text: "Oops, nothing found!",
                width: "100%"
            });

        })
    </script>

@endsection
