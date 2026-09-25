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
        <div class="col-xs-12">
            <div class="card card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <td class="bg-primary">Spécialité</td>
                            <td colspan="3">{{ $data->ues->specialite->libelleSpecialite }}</td>
                        </tr>
                        <tr>
                            <td class="bg-primary">UE</td>
                            <td>{{ $data->ues->libelleUE }}</td>
                            <td class="bg-primary">Matière</td>
                            <td>{{ $data->libelleMatiere }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-md-12">
            <div class="card card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <caption class="h4"><i class="fa fa-circle text-primary"></i>&nbsp;Présentation</caption>
                        @foreach($data->syllabus as $key=>$sy)
                            <tr>
                                <td class="bg-primary h4">{{ ++$key }} - Chapitre/Partie</td>
                                <td class="h4">{{ $sy->titleSyllabus }}</td>
                                <td class="h4 text-center"><i class="{{ $sy->statusSyllabus? "fa fa-check text-success" : "fa fa-hourglass text-info" }}"></i></td>
                                <td rowspan="2" class="text-center">
                                    <a class="btn btn-md btn-warning" title="Modifier" href="{{ route("syllabusEdit", ["slug"=>$sy->id]) }}">
                                        <i class="ace-icon fa fa-pencil bigger-130"></i>
                                    </a>
                                    <br>
                                    <br>
                                    <a class="btn btn-md btn-danger" title="Supprimer" href="{{ route("syllabusDeleteOnce", ["slug"=>$sy->id]) }}">
                                        <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3"><pre style="min-height: 150px; overflow: auto">{{ strip_tags($sy->descriptionSyllabus) }}</pre></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection


@section("script")

@endsection
