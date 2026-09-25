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
        <div class="col-lg-8 col-md-8">
            <div class="card bg-transparent">
                <div class="card-body">
                    <form action="{{ isset($data)? route("enseignantUpdate", ["slug"=>$data->id]): route("enseignantStore") }}" method="post"  enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 co-md-12">
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
                            <div class="col-lg-12 co-md-12">
                                <div class="form-group">
                                    <label class="h6">
                                        Prénom(s)
                                    </label>
                                    <input class="form-control input-mask-phone" type="text" id="firstname" name="firstname" value="{{  isset($data)? $data->firstname : old("firstname") }}" />

                                    @error("firstname")
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 co-md-12">
                                <div class="form-group">
                                    <label class="h6">
                                        Nationalité *
                                    </label>

                                    <div class="input-group">
                                        <select class="form-control  @error('nationality') is-invalid @enderror" id="nationality" name="nationality" required>
                                            <option></option>
                                            @foreach($pays as $r)
                                                <option {{ isset($data)? (($data->nationality==$r->nomPays)? "selected" : "") : old('nationality') }}>{{ $r->nomPays }}</option>
                                            @endforeach
                                        </select>
                                        <span class="input-group-addon"><a href="{{ route("paysCreate") }}" title="Enregistrer un nouveau"><i class="fa fa-plus"></i></a></span>
                                    </div>

                                    @error("nationality")
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 co-md-12">
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
                            <div class="col-lg-12 co-md-12">
                                <div class="form-group">
                                    <label class="h6">
                                        Sexe *
                                    </label>
                                    <select name="sexe" class="form-control" id="sexe">
                                        <option value=""></option>
                                        <option value="{{ "Masculin" }}" {{ (old("sexe")=="Masculin")? "selected" :  ((isset($data) && $data->sexe=="Masculin")? "selected" : "")  }}>Masculin</option>
                                        <option value="{{ "Feminin" }}" {{ (old("sexe")=="Feminin")? "selected" :  ((isset($data) && $data->sexe=="Feminin")? "selected" : "")  }}>Feminin</option>
                                    </select>

                                    @error("sexe")
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 co-md-12">
                                <div class="form-group">
                                    <label class="h6">
                                        Diplome de référence *
                                    </label>

                                    <div class="input-group">
                                        <select class="form-control  @error('diplome') is-invalid @enderror" id="region" name="region" required>
                                            <option></option>
                                            @foreach($diplome as $r)
                                                <option {{ isset($data)? (($data->diplome ==$r->intuleDiplome)? "selected" : "") : old('diplome') }}>{{ $r->intuleDiplome }}</option>
                                            @endforeach
                                        </select>
                                        <span class="input-group-addon"><a href="{{ route("diplomeCreate") }}" title="Enregistrer un nouveau"><i class="fa fa-plus"></i></a></span>
                                    </div>
                                    @error("diplome")
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 co-md-12">
                                <div class="form-group">
                                    <label class="h6">
                                        Grade
                                    </label>

                                    <div class="input-group">
                                        <select class="form-control  @error('grade') is-invalid @enderror" id="grade" name="grade" required>
                                            <option></option>
                                            @foreach($grade as $r)
                                                <option {{ isset($data)? (($data->grade==$r->intituleGrade)? "selected" : "") : old('grade') }}>{{ $r->intituleGrade }}</option>
                                            @endforeach
                                        </select>
                                        <span class="input-group-addon"><a href="{{ route("gradeCreate") }}" title="Enregistrer un nouveau"><i class="fa fa-plus"></i></a></span>
                                    </div>
                                    @error("grade")
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 co-md-12">
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
                            <div class="col-lg-12 co-md-12">
                                <div class="form-group">
                                    <label class="h6">Adresse email *</label>
                                    <input class="form-control input-mask-phone" type="email" min="0" id="email" name="email" value="{{ isset($data)? $data->email : old("email") }}"/>

                                    @error("email")
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 co-md-12">
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
