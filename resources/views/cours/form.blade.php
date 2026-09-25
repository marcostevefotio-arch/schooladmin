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
        <div class="col-lg-12 col-md-12">
            <div class="card bg-transparent">
                <div class="card-body">
                    <form action="{{ isset($data)? route("coursUpdate", ["slug"=>$data->id]): route("coursStore") }}" method="post"  enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="specialite">Specialité *</label>

                            <select name="specialite" id="specialite">
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
                            <label for="matiere">Unité d'enseignement *</label>

                            <select name="matiere" id="matiere" class="form-control">

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="enseignant">Enseignant *</label>

                            <select name="enseignant" id="enseignant" class="form-control">
                                <option value=""></option>
                                @foreach($enseignants as $ens)
                                    <option value="{{ $ens->id }}">{{ $ens->lastname }} {{ $ens->firstname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="h6">
                                Date et heure du cours *
                            </label>
                            <input class="form-control input-mask-phone" type="datetime-local" id="datecours" name="datecours" value="{{  isset($data)? $data->lastname : old("lastname") }}" />

                            @error("lastname")
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="h6">
                                Durée du cours *
                            </label>
                            <input class="form-control input-mask-phone" type="text" id="duree" name="duree" value="{{  isset($data)? $data->lastname : old("lastname") }}" />

                            @error("lastname")
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-success"><i class="fa fa-save">&nbsp;</i>Enregistrer</button>
                            </div>
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
    <script src="{{ asset("") }}assets/js/spin.js"></script>


    <!-- inline scripts related to this page -->
    <script type="text/javascript">
        $(document).ready(function(){
            $('#specialite').on('change', function(evt, params) {
                $.ajax({
                    url: "{{ route("matiereAjax") }}",
                    type: "post",
                    data:{specialite: params.selected, _token: "{{ csrf_token() }}"},
                    dataType: "json",
                    success: function(response){
                        if(response.length>0){

                            var html = '<option value=""></option>';
                            response.forEach(function(item, index){
                                html+='<option value="'+item.ecID+'">'+item.codeUE+':'+item.codeMatiere+'-'+item.libelleMatiere+'</option>';
                            });

                            $("#matiere").empty();
                            $("#matiere").append(html);
                        }else{
                            $("#totalStudents").text(response.length);
                            $("#listeStudents").css("display", "none");
                            $("#submit").css("display", "none");
                        }


                        $("#libelleSPecialite").text($("#specialite option:selected").text());
                        $("#etudiants").empty();
                        $("#etudiants").append(html);
                    },
                });
            });

            $("#specialite").chosen({
                disable_search_threshold: 10,
                no_results_text: "Oops, nothing found!",
                width: "100%"
            });
        })
    </script>
@endsection
