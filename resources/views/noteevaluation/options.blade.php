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
            <form action="{{ route("note-pv-gen") }}" method="get" target="_blank">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="specialite">Specialité *</label>
                    <select name="specialite" id="specialite" required>
                        <option value=""></option>
                        @foreach($filiere as $f)
                            <optgroup label="{{ $f->libelleFiliere }}">
                                @foreach($f->specialites as $s)
                                    @foreach($s->choice as $c)
                                        @if($c->etat==1)
                                            <option value="{{ $s->id }}">{{ $s->libelleSpecialite }}</option>
                                            @break
                                        @endif
                                    @endforeach
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="semestre">Semestres *</label>
                    <select name="semestre" id="semestre" class="form-control">
                        <option value="">Tous</option>
                        @foreach($semestre as $s)
                            <option value="{{ $s->id }}">Semestre {{ $s->libelleSemestre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="format">Format *</label>
                    <select name="format" id="format" class="form-control">
                        <option value="a4">A4</option>
                        <option value="a3" selected >A3</option>
                        <option value="a2">A2</option>
                    </select>
                </div>
                <h4><button type="submit" id="submit" class="btn btn-black"><i class="fa fa-print">&nbsp;Generer les PV</i></button  ></h4>
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
        $(document).ready(function() {
            $("#specialite").chosen({
                disable_search_threshold: 10,
                no_results_text: "Oops, nothing found!",
                width: "100%"
            });
        });
    </script>

@endsection
