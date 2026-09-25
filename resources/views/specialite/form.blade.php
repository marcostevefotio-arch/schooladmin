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

    <div class="card card-body">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h1>Formulaire de creation de spécialité</h1>
                        <form action="{{ isset($data)? route("specialiteUpdate", ["slug"=>$data->id]) : route("specialiteStore") }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>
                                    <h4 class="">Filière</h4>
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
                            <div class="form-group">
                                <label>
                                    <h4 class="">Code de la spécialité</h4>
                                </label>
                                <input class="form-control input-mask-phone @error('codeSpecialite') is-invalid @enderror" type="text" id="codeSpecialite" name="codeSpecialite" value="{{ isset($data)? $data->codeSpecialite : old('codeSpecialite') }}" required/>
                                @error('codeSpecialite')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>
                                    <h4 class="">Libelle de la spécialité</h4>
                                </label>
                                <input class="form-control input-mask-phone @error('libelleSpecialite') is-invalid @enderror" type="text" id="libelleSpecialite" name="libelleSpecialite" value="{{ isset($data)? $data->libelleSpecialite : old('libelleSpecialite') }}" required/>
                                @error('libelleSpecialite')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label >
                                    <h4 class="">Description de la filière</h4>
                                </label>
                                <textarea class="form-control input-mask-phone @error('description') is-invalid @enderror" id="description" name="description">{{ isset($data)? $data->descriptionSpecialite : old('description') }}</textarea>
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

@endsection


@section("script")

@endsection
