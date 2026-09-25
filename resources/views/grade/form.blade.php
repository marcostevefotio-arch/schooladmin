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
            <!-- PAGE CONTENT BEGINS -->
            <form action="{{ isset($data)? route("gradeUpdate", ["slug"=>$data->id]) : route("gradeStore") }}" method="post">
                @csrf
                <div class="form-group">
                    <label>
                        <h4 class="">Code du grade *</h4>
                    </label>
                    <input class="form-control input-mask-phone @error('codeGrade') is-invalid @enderror" type="text" id="codeGrade" name="codeGrade" value="{{ isset($data)? $data->codeGrade : old('codeGrade') }}" required/>
                    @error('codeGrade')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>
                        <h4 class="">Intitulé du grade *</h4>
                    </label>
                    <input class="form-control input-mask-phone @error('intituleGrade') is-invalid @enderror" type="text" id="intituleGrade" name="intituleGrade" value="{{ isset($data)? $data->intituleGrade : old('intituleGrade') }}" required/>
                    @error('intituleGrade')
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

            <div class="hr hr-18 dotted hr-double"></div>

        </div><!-- /.col -->
    </div>
@endsection

@section("script")
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/jquery.dataTables.bootstrap.min.js"></script>
    <script src="assets/js/dataTables.buttons.min.js"></script>
    <script src="assets/js/buttons.flash.min.js"></script>
    <script src="assets/js/buttons.html5.min.js"></script>
    <script src="assets/js/buttons.print.min.js"></script>
    <script src="assets/js/buttons.colVis.min.js"></script>
    <script src="assets/js/dataTables.select.min.js"></script>

    <script type="text/javascript">
        jQuery(function($) {
            var myTable =
                $('#dynamic-table')
                    .DataTable( {
                        bAutoWidth: false,
                        "aoColumns": [
                            { "bSortable": false },
                            null, null,null, null,
                            { "bSortable": false }
                        ],
                        "aaSorting": [],
                        select: {
                            style: 'multi'
                        }
                    } );

        })
    </script>
@endsection
