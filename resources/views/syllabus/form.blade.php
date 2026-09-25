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
                    <form action="{{ isset($data)? route("syllabusUpdate", ["slug"=>$data->id]): route("syllabusStore") }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <label class="h6">
                                    Matière *
                                    </label>
                                    <select name="matiere" class="form-control" id="matiere">
                                        <option value=""></option>
                                        @foreach($spes as $sp)
                                            <optgroup label="{{  $sp->libelleSpecialite }}">
                                            @foreach($sp->ues as $ues)
                                                    <optgroup label="{{ $ues->libelleUE }}">
                                                    @foreach($ues->matiere as $m)
                                                            <option value="{{ $m->id }}" {{ isset($data)? ($data->matiere_id==$m->id? "selected" : "") : "" }}>{{ $m->libelleMatiere }}</option>
                                                    @endforeach
                                                    </optgroup>
                                            @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>

                                    @error("matiere")
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <label class="h6">
                                        Titre du chapitre/partie *
                                    </label>
                                    <input class="form-control input-mask-phone" type="text" id="form-field-mask-2" name="titleSyllabus" value="{{ isset($data)? $data->titleSyllabus : old("titleSyllabus") }}"/>

                                    @error("titleSyllabus")
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <label class="h6">
                                        Description du chapitre/partie
                                    </label>
                                    <textarea class="form-control input-mask-phone" id="form-field-mask-2" name="descriptionSyllabus" >{{ isset($data)? strip_tags($data->descriptionSyllabus) : strip_tags(old("descriptionSyllabus")) }}</textarea>

                                    @error("descriptionSyllabus")
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
