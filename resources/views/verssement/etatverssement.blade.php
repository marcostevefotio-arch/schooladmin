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
            <form action="{{ route("verssementPrintPDF") }}" method="post" target="_blank">
                {{ csrf_field() }}

                <div class="form-group"  style="display: {{ isset($data)? "none" : "block" }}">
                    <label for="annee">Année *</label>
                    <select name="annee" id="annee" >
                        <option value="">--</option>
                        @foreach($annees as $a)
                            <option value="{{ $a->id }}" > {{ $a->numeroAnnee }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="form-group"  style="display: {{ isset($data)? "none" : "block" }}">
                    <label for="scolarite">Specialité *</label>
                    <select name="scolarite" id="scolarite" >
                        <option value="">--</option>
                        @foreach($filiere as $f)
                            <optgroup label="{{ $f->libelleFiliere }}">
                                @foreach($f->specialites as $sp)
                                    @foreach($sp->choice as $c)
                                        @if($c->etat == 1)
                                            <option value="{{ $sp->id }}" > {{ $sp->libelleSpecialite }}</option>
                                            @break
                                        @endif
                                    @endforeach
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>


                <div class="form-group " style="display: {{ isset($data)? "none" : "block" }}">
                    <label for="etudiants">Etudiant *</label>
                    <select name="etudiants" id="etudiants" class="form-control">
                        <option value=""></option>
                    </select>
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



            $("#annee").chosen({
                disable_search_threshold: 10,
                no_results_text: "Oops, nothing found!",
                width: "100%"
            });
            $("#scolarite").chosen({
                disable_search_threshold: 10,
                no_results_text: "Oops, nothing found!",
                width: "100%"
            });

            $('#scolarite').on('change', function(evt, params) {
                var annee = $("#annee").val();
                var specialite = $("#scolarite option:selected").val();

                if(specialite){
                    $.ajax({
                        url: "{{ route("etudiantAjaxList2") }}",
                        type: "post",
                        data:{specialite: params.selected, annee: annee, _token: "{{ csrf_token() }}"},
                        dataType: "json",
                        success: function(response){
                            if(response.length>0){
                                $("#submit").css("display", "block");
                                var data = [];

                                var html = "<option value=''></option>";
                                response.forEach(function(item, index){
                                    html+="<option value='"+item.inscrID+"'>"+item.firstname+" "+item.lastname+" ("+item.matriculeDossier+")</option>";
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

            $('#annee').on('change', function(evt, params) {
                var annee = $("#annee").val();
                var specialite = $("#scolarite option:selected").val();

                if(specialite){
                    $.ajax({
                        url: "{{ route("etudiantAjaxList2") }}",
                        type: "post",
                        data:{specialite: specialite, annee: annee, _token: "{{ csrf_token() }}"},
                        dataType: "json",
                        success: function(response){
                            if(response.length>0){
                                $("#submit").css("display", "block");
                                var data = [];

                                var html = "<option value=''></option>";
                                response.forEach(function(item, index){
                                    html+="<option value='"+item.inscrID+"'>"+item.firstname+" "+item.lastname+" ("+item.matriculeDossier+")</option>";
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
        })
    </script>

@endsection
