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
            <form action="{{ isset($data)? route("verssementUpdate", ["slug"=>$data->id]): route("verssementStore") }}" method="post">
                {{ csrf_field() }}

                <div class="form-group"  style="display: {{ isset($data)? "none" : "block" }}">
                    <label for="scolarite">Specialité *</label>
                    <select name="scolarite" id="scolarite"  {{ isset($data)? "disabled" : "required" }}>
                        <option value=""></option>
                        @foreach($filiere as $f)
                            @foreach($f->specialites as $sp)
                                @if(count($sp->scolarite))
                                    <optgroup label="{{ $sp->libelleSpecialite }}">
                                        @foreach($sp->scolarite as $sc)
                                            <option value="{{ $sc->id }}" > {{ $sc->descriptionScolarite }} = {{ $sc->montantScolarite }}</option>
                                        @endforeach
                                    </optgroup>
                                @endif
                            @endforeach
                        @endforeach
                    </select>
                </div>


                <div class="form-group " style="display: {{ isset($data)? "none" : "block" }}">
                    <label for="etudiants">Etudiant *</label>
                    <select name="etudiants" id="etudiants" class="form-control" {{ isset($data)? "disabled" : "required" }}>
                        <option value=""></option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="montant">Montant *</label>
                    <input type="number" name="montant" id="montant" min="0" class="form-control form-control-sm" value="{{ isset($data)? $data->montantVerssement : old("montant") }}" required style="letter-spacing: 20px; font-weight: bold"/>
                </div>
                <div class="form-group">
                    <label for="dateverssement">Date du verssement *</label>
                    <input type="date" name="dateverssement" id="dateverssement" max="{{ date("Y-m-d") }}" class="form-control form-control-sm" value="{{ isset($data)? $data->dateVerssement : old("dateverssement") }}" required/>
                </div>
                <div class="form-group">
                    <label for="motif">Motif du verssemenr </label>
                    <textarea name="motif" rows="5" id="motif" class="form-control form-control-sm" ></textarea>
                </div>
                <h4><button type="submit" id="submit" class="btn btn-primary" style="display: {{ isset($data)? "" : "none" }}"><i class="fa fa-save">&nbsp;Enregistrer</i></button></h4>
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
            var opts = {
                lines: 10, // The number of lines to draw
                length: 5, // The length of each line
                width: 10, // The line thickness
                radius: 20, // The radius of the inner circle
                scale: 1, // Scales overall size of the spinner
                corners: 1, // Corner roundness (0..1)
                speed: 3, // Rounds per second
                rotate: 0, // The rotation offset
                animation: 'spinner-line-fade-quick', // The CSS animation name for the lines
                direction: 1, // 1: clockwise, -1: counterclockwise
                opacity: 0.2,
                color: '#ffb411', // CSS color or array of colors
                fadeColor: 'transparent', // CSS color or array of colors
                top: '50%', // Top position relative to parent
                left: '50%', // Left position relative to parent
                shadow: false, // Box-shadow for the lines
                zIndex: 2000000000, // The z-index (defaults to 2e9)
                className: 'spinner', // The CSS class to assign to the spinner
                position: 'absolute', // Element positioning
            };



            $("#scolarite").chosen({
                disable_search_threshold: 10,
                no_results_text: "Oops, nothing found!",
                width: "100%"
            });

            $('#scolarite').on('change', function(evt, params) {
                var specialite = $("#scolarite option:selected").val();
                console.log(specialite);
                console.log(params.selected);
                $.ajax({
                    url: "{{ route("scolariteAjax") }}",
                    {{-- data:{scolarite: params.selected}, --}}
                    data:{scolarite: specialite},
                    dataType: "json",
                    async: false,
                    success: function(scolarite){
                        console.log(scolarite);
                        $.ajax({
                            url: "{{ route("etudiantAjaxList2") }}",
                            type: "post",
                            data:{specialite: specialite, _token: "{{ csrf_token() }}"},
                            dataType: "json",
                            success: function(response){
                                console.log(response);
                                if(response.length>0){
                                    $("#submit").css("display", "block");

                                    var data = [];

                                    var html = "<option value=''></option>";
                                        response.forEach(function(item, index){
                                        html+="<option value='"+item.inscrID+"'>"+item.firstname+" "+item.lastname+" ("+item.matriculeDossier+")</option>";
                                        $("#montant").attr("max", scolarite.montantScolarite);
                                        $("#motif").text(scolarite.descriptionScolarite);
                                    });
                                    $("#etudiants").empty();
                                    $("#etudiants").append(html);
                                }else{
                                    $("#submit").css("display", "none");
                                }
                            },
                        });
                    }
                });
            });
        })
    </script>

@endsection
