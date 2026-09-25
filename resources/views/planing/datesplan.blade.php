@extends('layouts.layout')

@section('language')
    {{ (Session::has("locale"))? Session::get("locale") : "en" }}
@endsection

@section('lang')
    {{ (Session::has("locale"))? app()->setLocale(Session::get("locale")) : app()->setLocale('en') }}
@endsection

@section('breadcrum')
    <li><a href="{{ route("classe") }}">Classes</a></li>
    <li class="active">Creation</li>
@endsection

@section('page')
    {{ Session::put("page", "timetable") }}
    Creation de cours
@endsection

@section('content')
    <div class="page-content">
        <div class="ace-settings-container" id="ace-settings-container">
            <div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
                <i class="ace-icon fa fa-cog bigger-130"></i>
            </div>

            <div class="ace-settings-box clearfix" id="ace-settings-box">
                <div class="pull-left width-50">
                    <div class="ace-settings-item">
                        <div class="pull-left">
                            <select id="skin-colorpicker" class="hide">
                                <option data-skin="no-skin" value="#438EB9">#438EB9</option>
                                <option data-skin="skin-1" value="#222A2D">#222A2D</option>
                                <option data-skin="skin-2" value="#C6487E">#C6487E</option>
                                <option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
                            </select>
                        </div>
                        <span>&nbsp; Choose Skin</span>
                    </div>

                    <div class="ace-settings-item">
                        <input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-navbar" autocomplete="off" />
                        <label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
                    </div>

                    <div class="ace-settings-item">
                        <input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-sidebar" autocomplete="off" />
                        <label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
                    </div>

                    <div class="ace-settings-item">
                        <input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-breadcrumbs" autocomplete="off" />
                        <label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
                    </div>

                    <div class="ace-settings-item">
                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" autocomplete="off" />
                        <label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
                    </div>

                    <div class="ace-settings-item">
                        <input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-add-container" autocomplete="off" />
                        <label class="lbl" for="ace-settings-add-container">
                            Inside
                            <b>.container</b>
                        </label>
                    </div>
                </div><!-- /.pull-left -->

                <div class="pull-left width-50">
                    <div class="ace-settings-item">
                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-hover" autocomplete="off" />
                        <label class="lbl" for="ace-settings-hover"> Submenu on Hover</label>
                    </div>

                    <div class="ace-settings-item">
                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact" autocomplete="off" />
                        <label class="lbl" for="ace-settings-compact"> Compact Sidebar</label>
                    </div>

                    <div class="ace-settings-item">
                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight" autocomplete="off" />
                        <label class="lbl" for="ace-settings-highlight"> Alt. Active Item</label>
                    </div>
                </div><!-- /.pull-left -->
            </div><!-- /.ace-settings-box -->
        </div><!-- /.ace-settings-container -->

        <div class="page-header">
            <h1>
                Gestion de la disponibilite
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    Details
                </small>
            </h1>
        </div>

    <div class="card card-body">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h1>Formulaire de creation de cours</h1>
                        <form action="{{ isset($data)? route("coursUpdate", ["slug"=>$data->id]) : route("coursStore") }}" method="post">
                            @csrf

                            <div class="form-group">
                                <label>
                                    <h4 class="">Specialité</h4>
                                </label>
                                <select class="form-control @error('specialite') is-invalid @enderror" id="specialite" name="specialite" required>
                                    <option value="{{ $specialite->id }}" >{{ $specialite->libelleSpecialite }}</option>
                                </select>
                                @error('specialite')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                            </div>

                            <div class="form-group">
                                <label>
                                    <h4 class="">Matiere</h4>
                                </label>
                                <select class="form-control @error('matiere') is-invalid @enderror" id="matiere" name="matiere" required>
                                    <option value=""></option>
                                    @foreach($specialite->ues as $ue)
                                        @foreach($ue->matiere as $m)
                                            <option value="{{ $m->id }}" {{ (isset($data) && $data->matiere_id == $m->id )? "selected" : "" }}>{{ $m->libelleMatiere }} ({{ $ue->codeUE }})</option>
                                        @endforeach
                                    @endforeach
                                </select>
                                @error('matiere')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                            </div>

                            <div class="form-group">
                                <label>
                                    <h4 class="">Intitulé du cours</h4>
                                </label>
                                <input class="form-control input-mask-phone @error('intituleCours') is-invalid @enderror" type="text" id="intituleCours" name="intituleCours" value="{{ isset($data)? $data->intituleCours : old('intituleCours') }}" required/>
                                @error('intituleCours')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>
                                    <h4 class="">Début</h4>
                                </label>
                                <input class="form-control input-mask-phone @error('debut') is-invalid @enderror" type="datetime-local" id="debut" name="debut" value="{{ isset($data)? date("Y-m-d", strtotime($data->debutCours))."T".date("H:i", strtotime($data->debutCours)) : old('debut') }}" required/>
                                @error('debut')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>
                                    <h4 class="">Durée</h4>
                                </label>
                                <input class="form-control input-mask-phone @error('duree') is-invalid @enderror" type="number" min="1" id="duree" name="duree" value="{{ isset($data)? $data->dureeCours : old('duree') }}" required/>
                                @error('libelleClasse')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label >
                                    <h4 class="">Description</h4>
                                </label>
                                <textarea class="form-control input-mask-phone @error('description') is-invalid @enderror" id="description" name="description">{{ isset($data)? $data->description : old('description') }}</textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
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
    </div>

    </div>
@endsection


@section("script")
    <script type="text/javascript">
        $(document).ready(function(){
            $("#matiere").change(function(){
                var cours = $("#matiere option:selected").text();
                $("#intituleCours").val(cours)
            });

            $("#filiere").change(function(){
                $.ajax({
                    url: "{{ route("filiereJson") }}",
                    data: {filiere: $(this).val()},
                    dataType: "json",
                    type: "get",
                    success: function(response){
                        if(response.length!=0){
                            $("#zoneSP").removeClass("hidden");
                            $("#alertSP").removeClass("hidden");

                            $("#alertSP").addClass("hidden");

                            response.forEach(function(item, index){
                                $("#specialite").append('<option value="'+item.id+'">'+item.libelleSpecialite+'</option>');
                            });

                        }else{
                            $("#zoneSP").removeClass("hidden");
                            $("#alertSP").removeClass("hidden");

                            $("#zoneSP").addClass("hidden");
                        }
                    },
                })
            });
        });
    </script>
@endsection
