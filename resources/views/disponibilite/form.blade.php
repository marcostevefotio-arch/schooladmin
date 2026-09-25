@extends('layouts.layout')

@section('language')
    {{ (Session::has("locale"))? Session::get("locale") : "en" }}
@endsection

@section('lang')
    {{ (Session::has("locale"))? app()->setLocale(Session::get("locale")) : app()->setLocale('en') }}
@endsection

@section('breadcrum')
    <li class="breadcrumb-item"><a href="{{ route("enseignant") }}">Disponibilité</a></li>
    <li class="active">create</li>
@endsection

@section('page')
    {{ Session::put("page", "enseignant") }}
    Disponibilité d'un enseignant
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
                Gestion de la disponibilité
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    enseignants
                </small>
            </h1>
        </div>

        <div class="card card-body">
            <div class="row">
                <div class="col-lg-8 col-md-8">
                    <div class="card bg-transparent">
                        <div class="card-body">
                            <form action="{{ isset($data)? route("enseignantUpdate", ["slug"=>$data->id]): route("enseignantStore") }}" method="post"  enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="h6">
                                                Nom(s) *
                                            </label>
                                            <input class="form-control input-mask-phone" type="text" id="lastname" name="lastname" value="{{  isset($data)? $data->lastname : old("lastname") }}" />

                                            @error("lastname")
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="h6">
                                                Prénom(s) *
                                            </label>
                                            <input class="form-control input-mask-phone" type="text" id="firstname" name="firstname" value="{{  isset($data)? $data->firstname : old("firstname") }}" />

                                            @error("firstname")
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="h6">
                                                Nationalité *
                                            </label>
                                            <input class="form-control input-mask-phone" type="text" id="nationality" name="nationality" value="{{  isset($data)? $data->nationality : old("nationality") }}" />

                                            @error("nationality")
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="h6">
                                                Numéro de téléphone *
                                            </label>
                                            <input class="form-control input-mask-phone" type="text" id="phone" name="phone" value="{{  isset($data)? $data->phonenumber : old("phone") }}" />

                                            @error("phone")
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="h6">
                                                Diplome de référence *
                                            </label>
                                            <input class="form-control input-mask-phone" type="text" id="diplome" name="diplome" value="{{ isset($data)? $data->diplome : old("diplome") }}"/>

                                            @error("diplome")
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="h6">
                                                Grade
                                            </label>
                                            <input class="form-control input-mask-phone" type="text" id="grade" name="grade" value="{{ isset($data)? $data->grade : old("grade") }}"/>

                                            @error("grade")
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="h6">
                                                Spécialité *
                                            </label>
                                            <input class="form-control input-mask-phone" type="text" id="specialite" name="specialite" value="{{ isset($data)? $data->specialite : old("specialite") }}"/>

                                            @error("specialite")
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="h6">Adresse email *</label>
                                            <input class="form-control input-mask-phone" type="email" min="0" id="email" name="email" value="{{ isset($data)? $data->email : old("email") }}"/>

                                            @error("email")
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="h6">Photo</label>
                                            <input class="form-control input-mask-phone" type="file" id="photo" name="photo" value="{{ old("photo") }}"/>

                                            @error("Photo")
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
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
    <script>
        $(document).ready(function(){
            $("#specialite").change(function(){
                var spe = $(this).val();
                $("#codeue").val(spe);
            })
        });
    </script>
@endsection
