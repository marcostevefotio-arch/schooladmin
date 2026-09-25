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
                    <form action="{{ isset($data)? route("compteUpdate", ["slug"=>$data->id]): route("compteStore") }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="h6" for="codeCompte">
                                        Compte
                                    </label>
                                    <input class="form-control input-mask-phone" type="text" id="codeCompte" name="codeCompte" value="{{  isset($data)? $data->codeCompte : old("codeCompte") }}" />

                                    @error("codeCompte")
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="h6" for="libelleCompte">
                                        Titre du compte
                                    </label>
                                    <input class="form-control input-mask-phone" type="text" id="libelleCompte" name="libelleCompte" value="{{  isset($data)? $data->libelleCompte : old("libelleCompte") }}" />

                                    @error("libelleCompte")
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="h6" for="descriptionCompte">
                                        Description du compte
                                    </label>
                                    <textarea class="form-control input-mask-phone" id="form-field-mask-2" name="descriptionCompte" >{{ isset($data)? $data->descriptionCompte : old("descriptionCompte") }}</textarea>

                                    @error("descriptionCompte")
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
