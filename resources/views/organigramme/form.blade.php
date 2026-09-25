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
        <div class="col-sm-6">
            <div class="widget-box widget-color-blue2">
                <div class="widget-header">
                    <h4 class="widget-title lighter smaller">Formulaire d'enregistrement de service</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main padding-8">
                        <form action="{{ isset($data["data"])? route("organisationUpdate", ["slug"=>$data["data"]->id]) : route("organisationstore") }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label class="control-label no-padding-right">Nom du service</label>
                                <input type="text" class="form-control  @error('title') is-invalid @enderror" id="form-field-icon-1" name="title" value="{{ isset($data["data"])? $data["data"]->organisationTitle : old("title") }}"/>

                                @error('title')
                                <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label no-padding-right">Presentation du service</label>
                                <textarea class="form-control  @error('description') is-invalid @enderror" id="form-field-icon-1" name="description">{{ isset($data["data"])? $data["data"]->organisationTitle : old("description") }}</textarea>
                                @error('description')
                                <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label no-padding-right">Superieur Hierachie</label>
                                <select type="text" class="form-control" id="form-field-icon-1" name="parent">
                                    <option value=""></option>
                                    @foreach($data["org"] as $org)
                                        @if(isset($data["data"]))
                                            @if($data["data"]->id!== $org->id)
                                                <option value="{{ $org->id }}" {{ isset($data["data"])? (($data["data"]->organisation_id==$org->id)? "selected" : "") : "" }}>{{ $org->organisationTitle }}</option>
                                            @endif
                                        @else
                                            <option value="{{ $org->id }}" {{ isset($data["data"])? (($data["data"]->organisation_id==$org->id)? "selected" : "") : "" }}>{{ $org->organisationTitle }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label no-padding-right">Responssable</label>
                                <select type="text" class="form-control" id="form-field-icon-1" name="responssable">
                                    <option value=""></option>
                                    @foreach($data["personnel"] as $personel)
                                        <option value="{{ $personel->id }}" {{ isset($data["data"])? (($data["data"]->user_id==$personel->id)? "selected" : "") : "" }}>{{ $personel->lastname }} {{ $personel->firstname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i>&nbsp;Enregistrer</button>
                                <button type="reset" class="btn btn-default btn-sm"><i class="fa fa-close"></i>&nbsp;Annuler</button>
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
