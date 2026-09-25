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
    {{ Session::put("page", "school") }}
    Creation de classe
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
                Gestion des classes
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    Creation d'une classe
                </small>
            </h1>
        </div>

        <div class="card card-body">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h1>Formulaire de creation de classe</h1>
                            <form action="{{ isset($data)? route("classeUpdate", ["slug"=>$data->id]) : route("classeStore") }}" method="post">
                                @csrf

                                @if(!isset($data))
                                    <div class="form-group">
                                        <label>
                                            <h4 class="">Filiere</h4>
                                        </label>
                                        <select class="form-control @error('filiere') is-invalid @enderror" type="text" id="filiere" name="filiere" required>
                                            <option value=""></option>
                                            @foreach($filiere as $fl)
                                                <option value="{{ $fl->id }}" {{ (isset($data) && ($data->filiere_id==$fl->id))? "selected" : ""  }}>{{ $fl->libelleFiliere }}</option>
                                            @endforeach
                                        </select>
                                        @error('filiere')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group hidden" id="zoneSP">
                                        <label>
                                            <h4 class="">Specialité</h4>
                                        </label>
                                        <select class="form-control @error('specialite') is-invalid @enderror" type="text" id="specialite" name="specialite" required>
                                            <option value=""></option>
                                        </select>
                                        @error('specialite')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                    <div class="form-group hidden" id="alertSP">
                                        <div class="alert alert-warning">
                                            <a href="{{ route("specialiteForm") }}" class="btn btn-warning" id="newSpecialite">Creer une spécialité</a>
                                        </div>
                                    </div>
                                @else
                                    <div class="form-group">
                                        <label>
                                            <h4 class="">Specialité</h4>
                                        </label>
                                        <select class="form-control @error('specialite') is-invalid @enderror" type="text" id="specialite" name="specialite" required>
                                            <option value=""></option>
                                            @foreach($specialite as $sp)
                                                <option value="{{ $sp->id }}" {{ (isset($data) && $data->specialite_id == $sp->id )? "selected" : "" }}>{{ $sp->libelleSpecialite }} - {{ $sp->filiere->libelleFiliere }}</option>
                                            @endforeach
                                        </select>
                                        @error('specialite')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror

                                    </div>

                                @endif

                                <div class="form-group">
                                    <label>
                                        <h4 class="">Libelle de la classe</h4>
                                    </label>
                                    <input class="form-control input-mask-phone @error('libelleClasse') is-invalid @enderror" type="text" id="libelleClasse" name="libelleClasse" value="{{ isset($data)? $data->libelleClasse : old('libelleClasse') }}" required/>
                                    @error('libelleClasse')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label >
                                        <h4 class="">Description de la classe</h4>
                                    </label>
                                    <textarea class="form-control input-mask-phone @error('description') is-invalid @enderror" id="description" name="description">{{ isset($data)? $data->descriptionClasse : old('description') }}</textarea>
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
