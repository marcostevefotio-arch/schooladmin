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
                    <form action="{{ isset($data)? route("matiereUpdate", ["slug"=>$data->id]): route("matiereStore") }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="h6">
                                    Unité d'enseignement *
                                    </label>
                                    <select name="ue" class="form-control" id="ue">
                                        <option value=""></option>
                                        @foreach($ues as $f)
                                            <option value="{{ $f->id }}"
                                                    {{ (old("ue")==$f->id)?
                                                    "selected" :
                                                    ((isset($data) && ($data->ue_id==$f->id))?
                                                     "selected" : "")
                                                     }}>({{ $f->codeUE }}) {{ $f->libelleUE }}</option>
                                        @endforeach
                                    </select>

                                    @error("ue")
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="h6">
                                        Code de l'EC *
                                    </label>
                                    <input class="form-control input-mask-phone" type="text" id="codeMatiere" name="codeMatiere" value="{{  isset($data)? $data->codeMatiere : old("codeMatiere") }}" />

                                    @error("codeMatiere")
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="h6">
                                        Intitullé de l'EC *
                                    </label>
                                    <input class="form-control input-mask-phone" type="text" id="form-field-mask-2" name="libelleMatiere" value="{{ isset($data)? $data->libelleMatiere : old("libelleMatiere") }}"/>

                                    @error("libelleMatiere")
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="h6">
                                        Description de l'EC
                                    </label>
                                    <textarea class="form-control input-mask-phone" id="form-field-mask-2" name="descriptionMatiere" >{{ isset($data)? $data->descriptionMatiere : old("descriptionMatiere") }}</textarea>

                                    @error("descriptionMatiere")
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
